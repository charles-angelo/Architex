@props([
'banner_type' => 'home',
'heroes' => [],
])

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

<section class="w-full mt-16 2xl:mt-0">
    <div>
        <div class="relative w-auto h-full 2xl:w-full swiper">
            <div class="absolute z-50 w-full">
                <div class="container mx-auto">
                    <x-header2 />
                </div>
            </div>

            <div class="h-full swiper-wrapper">
                @foreach ($heroes as $hero)
                @php
                // ✅ Automatically add <br> after first word if none present
                $title = $hero['title'] ?? '';
                if (strpos($title, '<br>') === false) {
                $title = preg_replace('/\s+/', '<br>', $title, 1);
                }
                @endphp

                <div class="relative w-auto 2xl:h-full 2xl:w-full swiper-slide">
                    {{-- 🎬 VIDEO --}}
                    @if (!empty($hero['video']))
                    <video autoplay loop muted playsinline class="object-cover w-full h-[30rem] 2xl:h-[55rem]">
                        <source src="{{ asset($hero['video']) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    {{-- 🌀 GIF or 🖼 IMAGE --}}
                    @elseif(!empty($hero['fallback_image']))
                    <img src="{{ asset($hero['fallback_image']) }}"
                        class="object-cover w-full h-[30rem] 2xl:h-[55rem]"
                        alt="Banner Image">
                    @endif

                    {{-- 🧠 Overlay Content --}}
                    <div
                        class="absolute inset-0 z-50 flex flex-col justify-center h-full px-4 mx-auto space-y-5 max-w-screen-2xl sm:px-6 lg:px-8">
                        <h1 class="text-5xl font-bold leading-tight text-green-900 2xl:text-7xl">
                            {!! $title !!}
                        </h1>

                        {{-- ✅ Description (without <p> tag issue) --}}
                        @if (!empty($hero['description']))
                        <div class="w-1/2 mt-4 text-xl text-green-900">
                            {!! strip_tags($hero['description'], '<br><strong><em><b><i>') !!}
                        </div>
                        @endif

                        {{-- 🔘 CTA Button --}}
                        @if (!empty($hero['button_text']))
                        <a href="{{ $hero['button_link'] ?? '#' }}"
                            class="px-6 py-3 mt-6 text-white bg-green-900 w-fit hover:bg-green-800 transition">
                            {{ $hero['button_text'] }}
                        </a>
                        @endif
                    </div>

                    {{-- 🩶 Gradient Overlay for Home --}}
                    @if ($banner_type === 'home')
                    <div class="absolute inset-0 z-20 bg-gradient-to-r from-white via-white/20 to-transparent"></div>
                    <div class="h-full z-10 bg-[#717171]/30 absolute inset-0"></div>
                    @endif
                </div>
                @endforeach
            </div>

            {{-- Swiper Navigation --}}
            @if ($banner_type === 'home')
            <div class="absolute bottom-0 right-0 z-20 flex justify-between gap-2 p-5 bg-white">
                <div
                    class="flex items-center justify-center w-12 h-12 text-[#00721B] transition-all duration-300 bg-white border border-gray-300 rounded-full shadow-lg cursor-pointer custom-swiper-button-prev bg-opacity-70 hover:bg-gray-700 hover:border-green-500 hover:scale-105">
                    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </div>

                <div
                    class="flex items-center justify-center w-12 h-12 text-[#00721B] transition-all duration-300 bg-white border border-gray-300 rounded-full shadow-lg cursor-pointer custom-swiper-button-next bg-opacity-70 hover:bg-gray-700 hover:border-green-500 hover:scale-105">
                    <svg class="w-6 h-6 stroke-current" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    const swiper = new Swiper('.swiper', {
        loop: true,
        speed: 800,
        navigation: {
            nextEl: '.custom-swiper-button-next',
            prevEl: '.custom-swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });
</script>