@extends('layouts.admin')

@section('title', 'Update Payment')

@section('content')
<div class="max-w-screen-2xl mx-auto mt-10 bg-white shadow-lg rounded-2xl p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Update Payment</h2>

    <!-- Payment + Lot Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Payment Information</h3>
            <p><strong>Full Name:</strong> {{ $payment->full_name }}</p>
            <p><strong>Email:</strong> {{ $payment->email }}</p>
            <p><strong>Contact Number:</strong> {{ $payment->contact_number }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
            <p><strong>Current Status:</strong>
                <span class="px-2 py-1 text-sm rounded 
                    @if($payment->status === 'paid') bg-green-100 text-green-700 
                    @elseif($payment->status === 'partial') bg-yellow-100 text-yellow-700 
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ ucfirst($payment->status) }}
                </span>
            </p>
        </div>

        @if($payment->lot)
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Lot Information</h3>
            <p><strong>Lot Name:</strong> {{ $payment->lot->lot_name ?? 'N/A' }}</p>
            <p><strong>Block:</strong> {{ $payment->lot->block->block_number ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $payment->lot->category->category_name ?? 'N/A' }}</p>
            <p><strong>Total Price:</strong> ₱{{ number_format($payment->total, 2) }}</p>
            <p><strong>Lot Status:</strong> {{ ucfirst($payment->lot->status ?? 'N/A') }}</p>
        </div>
        @endif
    </div>

    <!-- Update Form -->
    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Display current total paid -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Total Amount Paid</label>
            <input type="number" readonly
                class="mt-1 block  bg-gray-100 text-gray-700 rounded-md border-gray-300 shadow-sm"
                value="{{ number_format($payment->amount_paid, 2, '.', '') }}">
        </div>

        <!-- Input for new payment -->
        <div class="max-w-sm">
            <label for="amount_paid" class="block text-sm font-medium text-gray-700">Add New Payment</label>
            <input type="number" name="amount_paid" id="amount_paid" step="0.01" min="0"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                placeholder="Enter new payment amount">
            @error('amount_paid')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status dropdown -->
        <div class="max-w-sm mt-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Payment Status</label>
            <select name="status" id="status"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                <option value="unpaid" {{ $payment->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                <option value="partial" {{ $payment->status == 'partial' ? 'selected' : '' }}>Partial</option>
                <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>
            @error('status')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <!-- ✅ Remaining Balance -->
        <div class="border-t pt-4 text-right">
            <p class="text-lg font-semibold text-gray-800">
                Remaining Balance:
                <span id="remaining-balance" class="text-red-600 text-xl font-bold">
                    ₱{{ number_format(max($payment->total - $payment->amount_paid, 0), 2) }}
                </span>
            </p>
        </div>

        <div class="flex justify-between mt-8 items-center">
            <a href="{{ route('admin.payments.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                ← Back
            </a>

            <div class="flex items-center gap-3">
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    Save Changes
                </button>

                @if($payment->status !== 'paid')
                <button type="button" id="cancelPaymentBtn"
                    class="px-6 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">
                    Cancel Payment
                </button>
                @endif
            </div>
        </div>
    </form>

    @if($payment->status !== 'paid')
    <form id="cancelPaymentForm" action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
    @endif
</div>

<input type="hidden" id="total" value="{{ $payment->total }}">
<input type="hidden" id="alreadyPaid" value="{{ $payment->amount_paid }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const cancelBtn = document.getElementById("cancelPaymentBtn");
        const cancelForm = document.getElementById("cancelPaymentForm");
        const amountPaidInput = document.getElementById("amount_paid");
        const remainingBalanceEl = document.getElementById("remaining-balance");

        // ✅ Get values safely from hidden inputs
        const total = Number(document.getElementById("total").value);
        const alreadyPaid = Number(document.getElementById("alreadyPaid").value);

        // SweetAlert cancel
        if (cancelBtn) {
            cancelBtn.addEventListener("click", function() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "Canceling this payment will make the lot available again.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, keep it"
                }).then((result) => {
                    if (result.isConfirmed) cancelForm.submit();
                });
            });
        }

        // 💰 Live update remaining balance
        if (amountPaidInput) {
            amountPaidInput.addEventListener("input", function() {
                let newPayment = parseFloat(this.value) || 0;
                let remaining = Math.max(total - (alreadyPaid + newPayment), 0);
                remainingBalanceEl.textContent = "₱" + remaining.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            });
        }
    });
</script>


@endsection