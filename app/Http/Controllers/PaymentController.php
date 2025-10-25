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

    public function index()
    {
        $payments = Payment::with([
            'lot.block',
            'lot.category',
            'lot.images'
        ])->latest()->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('lot')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function create()
    {
        $lots = Lots::doesntHave('payment')->get();
        return view('admin.payments.create', compact('lots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lot_id' => 'required|exists:lots,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'telephone_number' => 'nullable|string|max:20',
            'payment_method' => 'required|string|in:gcash,paymaya',
            'payment_type' => 'required|string|in:partial,full',
        ]);

        $lot = Lots::findOrFail($request->lot_id);
        $amount = $lot->price ?? 0;
        $paymentAmount = $request->payment_type === 'partial' ? 50000 : $amount;

        $payment = Payment::create([
            'lot_id' => $lot->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'telephone_number' => $request->telephone_number,
            'total' => $amount,
            'amount_paid' => 0,
            'payment_method' => $request->payment_method,
            'status' => 'unpaid',
        ]);

        if ($paymentAmount <= 0) {
            $payment->update([
                'amount_paid' => $amount,
                'payment_method' => 'free',
                'status' => 'paid',
            ]);
            $lot->update(['status' => 'sold']);

            return redirect()->route('payments.success', ['lot_id' => $lot->id])
                ->with('success', 'Payment not required. Lot marked as sold.');
        }

        $userData = [
            'name'  => $request->full_name,
            'email' => $request->email,
            'phone' => $request->contact_number,
        ];

        $successUrl = route('payments.success', ['lot_id' => $lot->id]);
        $cancelUrl  = route('payments.cancel', ['lot_id' => $lot->id]);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => $this->paymongoSecret,
        ])->post('https://api.paymongo.com/v1/checkout_sessions', [
            'data' => [
                'attributes' => [
                    'billing' => $userData,
                    'line_items' => [[
                        'name' => $lot->lot_name ?? 'Lot Payment',
                        'description' => "Lot #{$lot->id} | {$request->full_name} | {$request->email}",
                        'amount' => intval($paymentAmount * 100),
                        'currency' => 'PHP',
                        'quantity' => 1,
                        'metadata' => [
                            'payment_id' => $payment->id,
                            'lot_id' => $lot->id,
                            'payment_type' => $request->payment_type,
                        ],
                    ]],
                    'payment_method_types' => [$request->payment_method],
                    'success_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                    'statement_descriptor' => 'Lot Payment',
                    'send_email_receipt' => true,
                ]
            ]
        ]);

        if (!$response->successful()) {
            Log::error('PayMongo Error:', $response->json());
            return back()->withErrors([
                'payment' => $response->json()['errors'][0]['detail'] ?? 'Failed to create checkout session.',
            ]);
        }

        $checkoutUrl = $response->json()['data']['attributes']['checkout_url'] ?? null;

        return redirect($checkoutUrl);
    }

    public function webhook(Request $request)
    {
        Log::info('PayMongo Webhook Received:', $request->all());

        $payload = $request->all();
        if (!isset($payload['data']['attributes']['status'])) {
            return response()->json(['message' => 'Invalid webhook payload'], 400);
        }

        $status = $payload['data']['attributes']['status'];
        $checkoutId = $payload['data']['id'];
        $lineItem = $payload['data']['attributes']['line_items'][0] ?? [];
        $metadata = $lineItem['metadata'] ?? [];
        $paymentId = $metadata['payment_id'] ?? null;

        if (!$paymentId) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $payment = Payment::find($paymentId);
        if (!$payment) {
            return response()->json(['message' => 'Payment record not found'], 404);
        }

        $lot = Lots::find($metadata['lot_id'] ?? null);
        if (!$lot) {
            return response()->json(['message' => 'Lot not found'], 404);
        }

        $amountPaid = ($payload['data']['attributes']['amount'] ?? 0) / 100;
        $paymentType = $metadata['payment_type'] ?? 'full';

        $statusToSave = $paymentType === 'partial' ? 'partial' : 'paid';
        $lotStatus = $paymentType === 'partial' ? 'reserved' : 'sold';

        $payment->update([
            'amount_paid' => $amountPaid,
            'status' => $statusToSave,
            'checkout_id' => $checkoutId,
        ]);

        $lot->update(['status' => $lotStatus]);

        return response()->json(['message' => 'Payment updated successfully']);
    }

    public function success()
    {
        return view('payments.success');
    }

    public function cancel()
    {
        return view('payments.cancel');
    }

    public function edit(Payment $payment)
    {
        // Eager load related models for display in the form
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

        $payment->update([
            'amount_paid' => $request->amount_paid ?? $payment->amount_paid,
            'status' => $request->status,
        ]);

        // Sync lot status with payment
        if ($payment->lot) {
            $lotStatus = match ($request->status) {
                'paid' => 'sold',
                'partial' => 'reserved',
                default => 'available',
            };

            $payment->lot->update(['status' => $lotStatus]);
        }

        return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully.');
    }


    /**
     * 🟥 ADMIN: Delete payment manually
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $lot = $payment->lot;

        $payment->delete();

        // Revert lot to available
        if ($lot) {
            $lot->update(['status' => 'available']);
        }

        return response()->json(['message' => 'Payment deleted successfully.']);
    }
}
