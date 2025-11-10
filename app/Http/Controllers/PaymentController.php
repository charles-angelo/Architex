<?php

namespace App\Http\Controllers;

use App\Models\Lots;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private string $paymongoSecret = 'Basic c2tfdGVzdF9YNHZ1elRQZ0Z6Q05SWWUxb3NaWnlnaGU6';

    /**
     * 🟩 ADMIN: List payments
     */
    public function index()
    {
        $payments = Payment::with(['lot.block', 'lot.category', 'lot.images'])
            ->latest()
            ->paginate(10);


        return view('admin.payments.index', compact('payments'));
    }

    /**
     * 🟩 ADMIN: Show single payment
     */
    public function show($id)
    {
        $payment = Payment::with('lot')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * 🟩 ADMIN: Create new payment manually
     */
    public function create()
    {
        $lots = Lots::doesntHave('payment')->get();
        return view('admin.payments.create', compact('lots'));
    }

    /**
     * 🟩 STORE: Handle new payment checkout session
     */
    public function store(Request $request)
    {
        $request->validate([
            'lot_id' => 'required|exists:lots,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'telephone_number' => 'nullable|string|max:20',
            'payment_method' => 'required|string|in:gcash,paymaya,pay_later,bank_transfer',
            'status' => 'required|string|in:paid,partial,pending',
            'payment_proof' => 'required_if:payment_method,bank_transfer|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $lot = Lots::findOrFail($request->lot_id);
        $amount = $lot->price ?? 0;

        // ✅ Force status = "pending" for bank_transfer, regardless of user input
        if ($request->payment_method === 'bank_transfer') {
            $request->merge(['status' => 'pending']);
        }

        // Determine payment amount
        $paymentAmount = match ($request->status) {
            'partial' => 50000,
            'paid' => $amount,
            default => 0,
        };

        /**
         * 🟣 PAY LATER — Reservation only, no payment yet
         */
        if ($request->payment_method === 'pay_later') {
            $payment = Payment::create([
                'lot_id'           => $lot->id,
                'full_name'        => $request->full_name,
                'email'            => $request->email,
                'contact_number'   => $request->contact_number,
                'telephone_number' => $request->telephone_number,
                'total'            => $amount,
                'amount_paid'      => 0,
                'payment_method'   => 'pay_later',
                'status'           => 'unpaid',
            ]);

            $lot->update(['status' => 'reserved']);

            return redirect()
                ->route('payments.success', ['lot_id' => $lot->id])
                ->with('info', 'Your reservation has been saved. Please pay within 3 days to avoid cancellation.');
        }

        /**
         * 🏦 BANK TRANSFER — Manual proof upload, pending verification
         */
        if ($request->payment_method === 'bank_transfer') {
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Save directly inside public/storage/proof_payment
            $destination = public_path('storage/proof_payment');
            $file->move($destination, $filename);

            $path = 'proof_payment/' . $filename; // relative path for display later

            $payment = Payment::create([
                'lot_id'           => $lot->id,
                'full_name'        => $request->full_name,
                'email'            => $request->email,
                'contact_number'   => $request->contact_number,
                'telephone_number' => $request->telephone_number,
                'total'            => $amount,
                'amount_paid'      => 0,
                'payment_method'   => 'bank_transfer',
                'status'           => 'pending',
                'proof_path'       => $path, // store only relative path
            ]);

            $lot->update(['status' => 'reserved']);

            return redirect()
                ->route('payments.success', ['lot_id' => $lot->id])
                ->with('info', 'Your bank transfer has been submitted and is pending admin verification.');
        }


        /**
         * 💳 NORMAL PayMongo Flow (GCash / PayMaya)
         */
        $payment = Payment::create([
            'lot_id'           => $lot->id,
            'full_name'        => $request->full_name,
            'email'            => $request->email,
            'contact_number'   => $request->contact_number,
            'telephone_number' => $request->telephone_number,
            'total'            => $amount,
            'amount_paid'      => $paymentAmount,
            'payment_method'   => $request->payment_method,
            'status'           => Payment::STATUS_UNPAID,
        ]);

        // Handle invalid amounts
        if ($paymentAmount <= 0) {
            return redirect()
                ->route('payments.cancel', ['lot_id' => $lot->id])
                ->with('warning', 'Payment not initiated yet.');
        }

        $successUrl = route('payments.success', ['lot_id' => $lot->id]);
        $cancelUrl  = route('payments.cancel', ['lot_id' => $lot->id]);

        // PayMongo Checkout Session
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => $this->paymongoSecret,
        ])->post('https://api.paymongo.com/v1/checkout_sessions', [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'name'  => $request->full_name,
                        'email' => $request->email,
                        'phone' => $request->contact_number,
                    ],
                    'line_items' => [[
                        'name' => $lot->lot_name ?? 'Lot Payment',
                        'description' => 'Payment for Lot ' . ($lot->lot_name ?? "ID {$lot->id}") .
                            ' by ' . ($request->full_name ?? 'Unknown Buyer'),
                        'amount' => intval($paymentAmount * 100),
                        'currency' => 'PHP',
                        'quantity' => 1,
                        'show_description' => true,
                        'metadata' => [
                            'payment_id' => (string) $payment->id,
                            'lot_id'     => (string) $lot->id,
                            'intended_status' => $request->status,
                        ],
                    ]],
                    'payment_method_types' => [$request->payment_method],
                    'success_url' => $successUrl,
                    'cancel_url'  => $cancelUrl,
                    'statement_descriptor' => 'Lot Payment',
                    'send_email_receipt'   => true,
                ]
            ]
        ]);

        if (!$response->successful()) {
            Log::error('PayMongo Error:', $response->json());

            return back()->withErrors([
                'payment' => $response->json()['errors'][0]['detail']
                    ?? 'Failed to create checkout session.',
            ]);
        }

        $checkoutUrl = $response->json()['data']['attributes']['checkout_url'] ?? null;
        return redirect($checkoutUrl);
    }




    /**
     * 🟩 SUCCESS PAGE
     */
    public function success(Request $request)
    {
        $lotId = $request->query('lot_id');
        $lot   = Lots::find($lotId);

        if (!$lot) {
            return redirect()->route('homepage')->with('error', 'Lot not found.');
        }

        $payment = Payment::where('lot_id', $lot->id)->latest()->first();

        if (!$payment) {
            return redirect()->route('homepage')->with('error', 'Payment not found.');
        }

        try {
            if ($payment->payment_method !== 'bank_transfer') {
                // Only update status for non-bank transfer payments
                $paidAmount = $payment->amount_paid;
                $status = 'partial';

                if ($paidAmount >= $lot->price) {
                    $paidAmount = $lot->price;
                    $status = 'paid';
                }

                $payment->update([
                    'status' => $status,
                    'amount_paid' => $paidAmount,
                ]);

                $lotStatus = $status === 'paid' ? 'sold' : 'reserved';
                $lot->update(['status' => $lotStatus]);
            }

            return view('payments.success', [
                'payment' => $payment->fresh(),
                'lot'     => $lot,
            ])->with('success', 'Payment confirmed successfully!');
        } catch (\Throwable $e) {
            Log::error('Payment Success Error: ' . $e->getMessage());
            return view('payments.success', compact('payment', 'lot'))
                ->with('warning', 'Payment completed, but verification failed.');
        }
    }



    /**
     * 🟥 CANCEL PAGE
     */
    public function cancel()
    {
        return view('payments.cancel');
    }

    /**
     * 🟩 ADMIN: Edit payment manually
     */
    public function edit(Payment $payment)
    {
        $payment->load('lot.block', 'lot.category');
        return view('admin.payments.edit', compact('payment'));
    }

    /**
     * 🟩 ADMIN: Update payment manually
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::with('lot')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:paid,unpaid,partial',
            'amount_paid' => 'nullable|numeric|min:0',
        ]);

        // ✅ Add new payment to existing amount
        $newAmount = $payment->amount_paid + ($request->amount_paid ?? 0);
        $totalPrice = $payment->total; // Assuming "total" column exists in payments table (total lot price)

        // ✅ Auto-detect final status
        if ($newAmount >= $totalPrice) {
            $finalStatus = 'paid';
            $lotStatus = 'sold';
            $newAmount = $totalPrice; // Cap at total price
        } elseif ($newAmount > 0) {
            $finalStatus = 'partial';
            $lotStatus = 'reserved';
        } else {
            $finalStatus = 'unpaid';
            $lotStatus = 'available';
        }

        // ✅ Save updates
        $payment->update([
            'amount_paid' => $newAmount,
            'status' => $finalStatus,
        ]);

        // ✅ Update lot status accordingly
        if ($payment->lot) {
            $payment->lot->update(['status' => $lotStatus]);
        }

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment updated successfully. Total paid: ₱' . number_format($newAmount, 2));
    }

    /**
     * 🟥 ADMIN: Delete payment manually
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $lot = $payment->lot;

        $payment->delete();

        if ($lot) {
            $lot->update(['status' => 'available']);
        }

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully and lot is now available.');
    }
}
