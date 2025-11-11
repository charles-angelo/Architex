@extends('layouts.guest')

@section('content')
    <div>
        <x-banner2 page="Blog Details" breadcrumb="Blogs" breadcrumb2="{{ $blog->title }}" link="{{ route('blogs.show') }}"
            img="{{ asset('img/blog-banner.png') }}" />
    </div>

    <section class="w-full bg-[#f3f3f3] pt-20 pb-[35rem]">
        <div class="container mx-auto">
            <div class="container grid grid-cols-1 gap-20 px-6 mx-auto lg:grid-cols-3">

                <!-- Left Content -->
                <div class="lg:col-span-2">
                    <!-- Featured Image or Video -->
                    <div class="w-full mb-6 shadow-md max-h-[40rem] overflow-hidden rounded-xl">
                        @php
                            $image = $blog->blog_image;
                            $isVideo = false;
                            $videoId = null;

                            if ($image) {
                                // Detect if it's a YouTube URL
    if (Str::contains($image, ['youtube.com/watch?v=', 'youtu.be/'])) {
        $isVideo = true;
        // Extract the video ID
        if (preg_match('/(?:v=|be\/)([^&]+)/', $image, $matches)) {
                                        $videoId = $matches[1];
                                    }
                                }
                            }
                        @endphp

                        @if ($isVideo && $videoId)
                            <!-- YouTube Video Embed -->
                            <iframe class="w-full aspect-video rounded-xl"
                                src="https://www.youtube.com/embed/{{ $videoId }}" title="{{ $blog->blog_title }}"
                                frameborder="0" allowfullscreen>
                            </iframe>
                        @elseif ($image)
                            <!-- Normal Image -->
                            <img src="{{ Str::startsWith($image, ['http://', 'https://']) ? $image : asset($image) }}"
                                alt="{{ $blog->blog_title }}"
                                class="w-full h-auto object-cover max-h-[40rem] transition-transform duration-500 hover:scale-105 rounded-xl">
                        @else
                            <!-- Placeholder -->
                            <div class="flex items-center justify-center h-64 text-gray-400 bg-gray-100 rounded-xl">
                                No image available
                            </div>
                        @endif
                    </div>

                    <!-- Meta Info -->
                    <div class="flex items-center gap-6 pb-5 mb-4 text-sm text-gray-600 border-b">
                        <div class="flex items-center gap-1">
                            <i class="text-green-700 fa-solid fa-user"></i> <span>Admin</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="text-green-700 fa-solid fa-tags"></i>
                            <span>{{ $blog->category?->category_name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="text-green-700 fa-solid fa-calendar"></i>
                            <span>{{ \Carbon\Carbon::parse($blog->blog_date)->format('F d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Title -->
                    <h2 class="text-2xl md:text-3xl font-semibold text-[#355E3B] mb-4">
                        {{ $blog->blog_title }}
                    </h2>

                    <!-- Paragraph -->
                    <div class="mb-6 text-lg leading-relaxed text-gray-700">
                        {!! $blog->description !!}
                    </div>
                </div>


                <!-- Right Sidebar -->
                <div class="grid grid-cols-2 space-y-14 md:grid-cols-1">
                    <div class="col-span-2 space-y-5 lg:col-span-1">
                        <h3 class="mb-4 text-xl font-semibold text-green-700">Latest Posts</h3>
                        @foreach ($recentBlogs as $item)
                            <a href="{{ route('blogs.details', ['id' => $item->id]) }}"
                                class="flex items-center gap-5 p-2 transition duration-300 rounded-md hover:bg-green-900/20">
                                <img src="{{ asset($item->blog_image) }}" alt="{{ $item->blog_title }}"
                                    class="object-cover h-20 rounded-sm shadow w-28">
                                <div>
                                    <p class="mb-1 font-medium leading-tight text-gray-800 line-clamp-2">
                                        {{ $item->blog_title }}
                                    </p>
                                    <p class="flex items-center gap-1 text-xs text-gray-500">
                                        <i class="text-green-700 fa-solid fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($item->blog_date)->format('F d, Y') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <x-contact-box image="{{ asset('img/contact-us/image.png') }}" title="Need help with your reservation?"
                        description="Call Us:" phone="(082) 299 2390" buttonText="Contact Now"
                        buttonLink="{{ route('contactUs') }}" />
                </div>
            </div>

            <!-- You Might Also Like -->
            <div class="grid grid-cols-3 gap-20 mx-3 mt-10 lg:mx-0">
                <div class="col-span-3 md:col-span-2">
                    <div class="container mx-auto">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-green-700">You Might Also Like</h3>
                            <div class="relative z-10 flex gap-2">
                                <div class="transition duration-300 cursor-pointer hover:scale-105 custom-prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 9"
                                        class="p-1 text-sm text-green-900 border rounded-full size-10 border-black/50">
                                        <path fill="currentColor"
                                            d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" />
                                        <path fill="currentColor"
                                            d="M6 8.5a.47.47 0 0 1-.35-.15l-3.5-3.5c-.2-.2-.2-.51 0-.71L5.65.65c.2-.2.51-.2.71 0s.2.51 0 .71L3.21 4.51l3.15 3.15c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z" />
                                    </svg>
                                </div>
                                <div class="transition duration-300 cursor-pointer hover:scale-105 custom-next">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 9"
                                        class="p-1 text-sm text-green-900 border rounded-full size-10 border-black/50">
                                        <path fill="currentColor"
                                            d="M12.5 5h-9c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h9c.28 0 .5.22.5.5s-.22.5-.5.5" />
                                        <path fill="currentColor"
                                            d="M10 8.5a.47.47 0 0 1-.35-.15c-.2-.2-.2-.51 0-.71l3.15-3.15l-3.15-3.15c-.2-.2-.2-.51 0-.71s.51-.2.71 0l3.5 3.5c.2.2.2.51 0 .71l-3.5 3.5c-.1.1-.23.15-.35.15Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Swiper -->
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                @foreach ($blogs as $item)
                                    <div class="min-h-full bg-white swiper-slide">
                                        <a href="{{ route('blogs.details', ['id' => $item->id]) }}"
                                            class="group bg-white rounded-sm shadow-sm hover:shadow-md transition overflow-visible border-b-4 border-transparent hover:border-[#253e16] duration-300">

                                            <div class="relative w-full h-64 overflow-hidden">
                                                <img src="{{ asset($item->blog_image) }}" alt="{{ $item->blog_title }}"
                                                    class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
                                            </div>

                                            <div class="relative z-20 flex justify-center">
                                                <div
                                                    class="absolute -top-5 bg-[#f3f3f3] text-[#253e16] text-sm px-2 py-3 flex items-center justify-between gap-2 shadow-lg w-[90%] max-w-md border border-gray-200 
                                                    transition-all duration-300 group-hover:bg-[#253e16] group-hover:text-white group-hover:border-[#253e16]">

                                                    <div
                                                        class="flex items-center justify-center w-1/2 gap-2 text-center border-r border-gray-400 group-hover:border-gray-500">
                                                        <span class="text-base mingcute--pencil-ruler-line"></span>
                                                        <span>{{ $item->category?->category_name ?? 'Uncategorized' }}</span>
                                                    </div>

                                                    <div class="flex items-center justify-center w-1/2 gap-2 text-center">
                                                        <span class="text-base la--calendar-solid"></span>
                                                        <span>{{ \Carbon\Carbon::parse($item->blog_date)->format('F d, Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-5 mt-6 text-center">
                                                <h3
                                                    class="mb-3 font-semibold text-gray-800 text-lg transition-colors duration-300 group-hover:text-[#253e16] line-clamp-2">
                                                    {{ $item->blog_title }}
                                                </h3>
                                                <div
                                                    class="inline-block mt-2 text-[#253e16] font-medium hover:text-green-600 transition border-b border-b-[#253e16]">
                                                    Read More
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            navigation: {
                nextEl: ".custom-next",
                prevEl: ".custom-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 2
                },
            },
        });
    </script>
@endsection
