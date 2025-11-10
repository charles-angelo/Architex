<!-- resources/views/components/contact-box.blade.php -->
<div class="hidden lg:flex">
    <div class="w-full max-w-sm overflow-hidden bg-white shadow-md">
        <!-- Image -->
        <img src="{{ $image ?? 'https://via.placeholder.com/400x200' }}" alt="Contact Banner"
            class="object-cover w-full h-auto">

        <!-- Content -->
        <div class="bg-[#495a46] text-white text-left py-6 px-5 relative">
            <h4 class="mb-2 text-lg">
                {{ $title ?? 'Need help with your reservation?' }}
            </h4>

            <p class="mb-5 text-sm">
                {{ $description ?? 'Call Us:' }}
                <span class="">{{ $phone ?? '(082) 299 2390' }}</span>
            </p>

            <!-- Divider -->
            <div class="flex items-center justify-center mb-5">
                <div class="flex-1 border-t border-gray-400"></div>
                <span class="mx-3 text-sm text-gray-300">or</span>
                <div class="flex-1 border-t border-gray-400"></div>
            </div>

            <!-- Button -->
            <a href="{{ $buttonLink ?? route('contactUs') }}"
                class="inline-block bg-[#ffd601] text-green-950 px-6 py-3 hover:bg-yellow-400 transition">
                {{ $buttonText ?? 'Contact Now' }}
            </a>
        </div>
    </div>
</div>
