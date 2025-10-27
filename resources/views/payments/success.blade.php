@extends('layouts.guest')

@section('title', 'Payment Successful')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-100 via-green-200 to-green-50 flex items-center justify-center pt-20 pb-[50rem]">
    <div class="bg-white p-12 rounded-3xl shadow-2xl text-center max-w-md w-full transform transition-all hover:scale-105">

        <div class="text-green-600 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mx-auto animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
            </svg>
        </div>

        {{-- 🟢 Success Message --}}
        @if ($payment->payment_method === 'pay_later')
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Reservation Confirmed!</h1>
        <p class="text-gray-600 mb-8">
            Your lot has been <strong>reserved</strong>. Please complete your payment within
            <strong>3 days</strong> to keep your reservation. If not paid within this time,
            the reservation will be automatically cancelled.
        </p>
        @elseif ($payment->status === 'partial')
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Partial Payment Received!</h1>
        <p class="text-gray-600 mb-8">
            Thank you for your ₱50,000 down payment. Your lot is now <strong>reserved</strong>.
            Please complete the remaining balance to finalize your purchase.
        </p>
        @else
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Successful!</h1>
        <p class="text-gray-600 mb-8">
            Thank you for your payment. Your transaction has been completed successfully.
            The lot is now marked as <strong>sold</strong>.
        </p>
        @endif

        <a href="{{ route('homepage') }}"
            class="inline-block bg-green-600 text-white px-8 py-3 rounded-xl shadow-lg hover:bg-green-700 transition transform hover:-translate-y-1">
            Return to Homepage
        </a>
    </div>
</div>
@endsection