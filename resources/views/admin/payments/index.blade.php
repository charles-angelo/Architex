@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
<!-- 🧭 Page Header -->
<h1 class="text-2xl font-semibold mb-6">PAYMENTS</h1>

<!-- 📋 Payments Table -->
<div class="overflow-x-auto bg-white border rounded-lg">
    <table class="table-fixed w-full border-collapse" id="payments-table">
        <thead>
            <tr class="bg-black text-white text-sm font-semibold">
                <th class="px-6 py-3 text-center rounded-tl-lg">ID</th>
                <th class="px-6 py-3 text-center">Lot</th>
                <th class="px-6 py-3 text-center">Full Name</th>
                <th class="px-6 py-3 text-center">Email</th>
                <th class="px-6 py-3 text-center">Contact</th>
                <th class="px-6 py-3 text-center">Method</th>
                <th class="px-6 py-3 text-center">Amount Paid</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center rounded-tr-lg">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
            <tr class="border-t" id="row-{{ $payment->id }}">
                <td class="px-6 py-3 text-center">{{ $payment->id }}</td>
                <td class="px-6 py-3 text-center">{{ $payment->lot->lot_name ?? 'N/A' }}</td>
                <td class="px-6 py-3 text-center">{{ $payment->full_name }}</td>
                <td class="px-6 py-3 text-center text-gray-600">{{ $payment->email }}</td>
                <td class="px-6 py-3 text-center">{{ $payment->contact_number }}</td>
                <td class="px-6 py-3 text-center capitalize">{{ $payment->payment_method }}</td>
                <td class="px-6 py-3 text-center font-semibold">₱{{ number_format($payment->amount_paid, 2) }}</td>
                <td class="px-6 py-3 text-center">
                    @switch($payment->status)
                    @case('paid')
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Paid</span>
                    @break
                    @case('partial')
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Partial</span>
                    @break
                    @default
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Unpaid</span>
                    @endswitch
                </td>
                <td class="px-6 py-3 text-center">
                    <div class="flex justify-center items-center gap-2">
                        <!-- View -->
                        <button type="button"
                            onclick='openViewModal(@json($payment))'
                            class="px-3 py-1.5 rounded text-white bg-blue-500 hover:bg-blue-600 text-xs transition">
                            View
                        </button>

                        <!-- Edit -->
                        <a href="{{ route('admin.payments.edit', $payment->id) }}"
                            class="px-3 py-1.5 rounded text-white bg-green-500 hover:bg-green-600 text-xs transition">
                            Edit
                        </a>

                        <!-- Delete -->
                        <button type="button"
                            onclick="deletePayment({{ $payment->id }})"
                            class="px-3 py-1.5 rounded text-white bg-red-500 hover:bg-red-600 text-xs transition">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center py-6 text-gray-500">No payments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- 🪟 View Payment Modal -->
<div id="view-modal"
    class="fixed inset-0 bg-black bg-opacity-30 hidden flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white rounded-3xl shadow-lg p-8 w-[700px] max-w-full animate-fade-in">
        <h2 class="text-lg font-semibold mb-6 text-gray-800">PAYMENT & LOT DETAILS</h2>

        <!-- 🏡 Lot Details -->
        <div class="mb-6">
            <h3 class="font-semibold mb-3 text-gray-700 flex items-center gap-1">🏡 Lot Details</h3>

            <div class="flex flex-col sm:flex-row gap-4 items-start">
                <!-- 🖼️ Lot Image -->
                <div class="w-full sm:w-[250px] h-[160px]">
                    <img id="lot_image" src="" alt="Lot Image"
                        class="w-full h-full object-cover rounded-lg border border-gray-200 hidden">
                </div>

                <!-- 📋 Lot Info beside image -->
                <ul class="space-y-1 text-sm">
                    <li><strong>Lot Name:</strong> <span id="lot_name">-</span></li>
                    <li><strong>Block:</strong> <span id="block">-</span></li>
                    <li><strong>Category:</strong> <span id="category">-</span></li>
                    <li><strong>Area:</strong> <span id="area">-</span> sqm</li>
                    <li><strong>Price:</strong> ₱<span id="price">-</span></li>
                    <li><strong>Status:</strong> <span id="lot_status">-</span></li>
                </ul>
            </div>
        </div>

        <!-- 💳 Payment Details BELOW -->
        <div class="border-t border-gray-200 pt-4">
            <h3 class="font-semibold mb-3 text-gray-700 flex items-center gap-1">💳 Payment Details</h3>

            <ul class="space-y-1 text-sm">
                <li><strong>Full Name:</strong> <span id="full_name">-</span></li>
                <li><strong>Email:</strong> <span id="email">-</span></li>
                <li><strong>Contact:</strong> <span id="contact">-</span></li>
                <li><strong>Method:</strong> <span id="method" class="uppercase">-</span></li>
                <li><strong>Amount Paid:</strong> ₱<span id="amount">-</span></li>
                <li><strong>Status:</strong> <span id="status">-</span></li>
            </ul>
        </div>

        <!-- Close Button -->
        <div class="flex justify-end mt-6">
            <button type="button"
                onclick="closeViewModal()"
                class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition">
                Close
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let table;

    $(document).ready(function() {
        table = $('#payments-table').DataTable({
            ordering: false,
            pageLength: 10
        });
    });

    // 🟦 View Modal
    function openViewModal(payment) {
        const lot = payment.lot || {};

        // ✅ Manual /public/storage/lots support
        const firstImage = lot.images?.length ? lot.images[0].image : null;

        if (firstImage) {
            const fullPath = `/${firstImage}`;
            $('#lot_image').attr('src', fullPath).removeClass('hidden');
        } else {
            $('#lot_image').addClass('hidden');
        }

        $('#lot_name').text(lot.lot_name ?? 'N/A');
        $('#block').text(lot.block?.block_number ?? 'N/A');
        $('#category').text(lot.category?.category_name ?? 'N/A');
        $('#area').text(lot.area ?? 'N/A');
        $('#price').text(Number(lot.price ?? 0).toLocaleString());
        $('#lot_status').text(lot.status ?? 'N/A');

        $('#full_name').text(payment.full_name ?? 'N/A');
        $('#email').text(payment.email ?? 'N/A');
        $('#contact').text(payment.contact_number ?? 'N/A');
        $('#method').text(payment.payment_method ?? 'N/A');
        $('#amount').text(Number(payment.amount_paid ?? 0).toLocaleString());
        $('#status').text(payment.status ?? 'N/A');

        document.getElementById('view-modal').classList.remove('hidden');
    }

    function closeViewModal() {
        document.getElementById('view-modal').classList.add('hidden');
    }

    // 🟥 Delete with SweetAlert
    function deletePayment(paymentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This payment record will be permanently deleted.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/admin/payments/" + paymentId,
                    method: "POST",
                    data: {
                        _method: "DELETE",
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        table.row($('#row-' + paymentId)).remove().draw();
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Payment record deleted successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong.',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                });
            }
        });
    }
</script>

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.25s ease-out;
    }
</style>
@endpush