@extends('layouts.guest')


@section('content')
@php
// Example heroes data (you can make this dynamic too)
$heroes = [
[
'title' => 'Innovation in <br> Every Design',
'description' =>
'We create architectural solutions that blend functionality, sustainability, and aesthetics—shaping modern environments that inspire and endure.',
'button_text' => 'Explore Properties',
'button_link' => '/properties',
'video' => 'img/homepage/family1.mp4',
'fallback_image' => 'assets/images/banners/BANNER_1.png',
],
];
@endphp

<section>
    @include('components.banner', [
    'banner_type' => 'home',
    'heroes' => $heroes,
    ])
</section>

<!-- Merged Card Section -->
<section class="bg-[#e8e8e8] py-[70px]">
    <div
        class="grid max-w-screen-xl grid-cols-1 mx-auto -mt-48 overflow-hidden bg-white border border-gray-100 shadow-2xl md:grid-cols-3">

        <!-- Card 1 -->
        <div class="relative p-12 mt-10 bg-white shadow-xl group">
            <!-- Green Corner (Inset) -->
            <div class="relative">
                <div class="h-[15rem] overflow-hidden">
                    <img src="{{ asset('img/homepage/architectural design.jpg') }}" alt=""
                        class="object-cover w-full h-full ">
                </div>

                <div
                    class="absolute text-9xl top-[8rem] right-10 font-bold text-white select-none -mt-10 outlined-number transition-colors duration-300 group-hover:text-[#1E4D2B]">
                    01
                </div>

                <div
                    class="absolute top-0 left-0 w-0 h-0 border-t-[50px] border-t-[#1E4D2B] border-r-[50px] border-r-transparent">
                </div>
            </div>

            <div class="flex items-start justify-between">
                <h3
                    class="font-semibold text-2xl text-gray-900 mt-6 transition-colors duration-300 group-hover:text-[#1E4D2B]">
                    Architectural Design
                </h3>
            </div>

            <p class="text-gray-600 leading-relaxed mt-4 transition-colors duration-300 group-hover:text-[#1E4D2B]">
                Innovative and functional concepts that balance aesthetics, sustainability, and efficiency.
            </p>
        </div>

        <div class="relative p-12 mt-10 bg-white shadow-xl group">
            <!-- Green Corner (Inset) -->
            <div class="relative">
                <div class="h-[15rem] overflow-hidden">
                    <img src="{{ asset('img/homepage/Building & Interior Design.jpg') }}" alt=""
                        class="object-cover w-full h-full ">
                </div>

                <div
                    class="absolute text-9xl top-[8rem] right-10 font-bold text-white select-none -mt-10 outlined-number transition-colors duration-300 group-hover:text-[#1E4D2B]">
                    02
                </div>

                <div
                    class="absolute top-0 left-0 w-0 h-0 border-t-[50px] border-t-[#1E4D2B] border-r-[50px] border-r-transparent">
                </div>
            </div>

            <div class="flex items-start justify-between">
                <h3
                    class="font-semibold text-2xl text-gray-900 mt-6 transition-colors duration-300 group-hover:text-[#1E4D2B]">
                    Building & Interior Designs
                </h3>
            </div>

            <p class="text-gray-600 leading-relaxed mt-4 transition-colors duration-300 group-hover:text-[#1E4D2B]">
                Smart building solutions and interiors that blend style, comfort, and purpose.
            </p>
        </div>

        <div class="relative p-12 mt-10 bg-white shadow-xl group">
            <!-- Green Corner (Inset) -->
            <div class="relative">
                <div class="h-[15rem] overflow-hidden">
                    <img src="{{ asset('img/homepage/Project management.png') }}" alt=""
                        class="object-cover w-full h-full ">
                </div>

                <div
                    class="absolute text-9xl top-[8rem] right-10 font-bold text-white select-none -mt-10 outlined-number transition-colors duration-300 group-hover:text-[#1E4D2B]">
                    03
                </div>

                <div
                    class="absolute top-0 left-0 w-0 h-0 border-t-[50px] border-t-[#1E4D2B] border-r-[50px] border-r-transparent">
                </div>
            </div>

            <div class="flex items-start justify-between">
                <h3
                    class="font-semibold text-2xl text-gray-900 mt-6 transition-colors duration-300 group-hover:text-[#1E4D2B]">
                    Project Management
                </h3>
            </div>

            <p class="text-gray-600 leading-relaxed mt-4 transition-colors duration-300 group-hover:text-[#1E4D2B]">
                End-to-end management ensuring timely delivery, cost efficiency, and quality.
            </p>
        </div>
    </div>
</section>

<!-- About Company Section -->
<section class="relative bg-[#f3f3f3] py-20 px-3">
    <!-- Background Image with Multiply Blend (Left Side Only) -->
    <div class="absolute inset-y-0 left-0 w-[45vw] md:w-[35vw] lg:w-[15vw] overflow-hidden">
        <img src="{{ asset('img/homepage/about-us.png') }}" alt="Background Design"
            class="object-contain w-full h-full mix-blend-multiply opacity-80">
    </div>

    <div class="relative grid items-center max-w-screen-xl grid-cols-1 gap-16 mx-auto md:grid-cols-2">

        <!-- Left Content -->
        <div class="relative group">
            <!-- Background Text -->
            <div
                class="absolute left-0 z-0 text-6xl font-bold leading-none text-gray-300 select-none -top-2 md:text-7xl outlined-number">
                About Company
            </div>

            <!-- Foreground Content -->
            <div class="relative">
                <h4 class="text-[#1E4D2B] font-bold mb-3">About Company</h4>
                <h2 class="text-4xl md:text-4xl font-semibold text-[#1E4D2B] leading-tight mb-6">
                    CRAFTING TIMELESS ARCHITECTURE
                </h2>

                <p class="mb-5 text-lg font-semibold leading-relaxed text-gray-700">
                    Architex Philippines is an architectural solutions firm dedicated to providing clients with the most
                    personalized services in architectural design, building and interior design, project management, and
                    other construction professional practices.
                </p>

                <p class="mb-8 text-lg font-semibold leading-relaxed text-gray-700">
                    We are currently undertaking residential, commercial, mixed-use, and subdivision development
                    projects in Mindanao. We are also planning on expanding our services across the Philippines and soon
                    extending our reach globally.
                </p>

                <a href="#"
                    class="inline-block bg-[#1E4D2B] text-white font-semibold px-6 py-3 rounded-md shadow-md hover:bg-[#256738] transition-all duration-300">
                    Learn More
                </a>
            </div>
        </div>

        <!-- Right Image -->
        <div class="flex items-center justify-center">
            <div class="w-full">
                <img src="{{ asset('img/homepage/about-company.png') }}" alt="Project"
                    class="object-cover w-full h-full" />
            </div>
        </div>
    </div>
</section>

<!-- Services Section-->
<section id="services" class="relative w-full py-20 bg-white">
    <div class="relative z-0 max-w-screen-xl px-6 mx-auto text-center">
        <!-- Background Text -->
        <div
            class="absolute inset-x-0 z-0 text-6xl leading-none tracking-tight text-gray-400 select-none -top-1 md:text-7xl opacity-20 text-outline">
            Our Services
        </div>
        <p class="text-[#1E4D2B] font-bold mb-4 text-lg">Our Services</p>
        <h2 class="text-4xl md:text-4xl font-semibold text-[#1E4D2B] mb-12 tracking-tight">
            TAILORED ARCHITECTURAL SOLUTIONS
        </h2>

        <div class="space-y-10">
            <x-service-card title="Property for Sale"
                description="Invest in a property built to last. Our homes and spaces are crafted with durability, style, and value in mind, giving you the opportunity to own a place that matches both your lifestyle and future goals."
                button-text="See All For Sale" button-link="{{ route('properties.show') }}"
                image="img/homepage/sale.png" />

            <x-service-card title="Property for Rent"
                description="Flexible housing and property options designed for modern living. Our rental units offer comfort, convenience, and functionality—perfect for families, professionals, and businesses seeking quality spaces without long-term commitment."
                button-text="See All For Rent" button-link="{{ route('properties.show') }}"
                image="img/homepage/rent.png" :reverse="true" />
        </div>
    </div>
</section>

<!-- Feature Properties Section-->
<section class="py-20 bg-[#f3f3f3] overflow-hidden relative">
    <div class="relative z-0 mb-12 text-center">
        <p class="mb-3 text-2xl font-bold tracking-wide text-green-700">Featured Properties</p>
        <h2 class="text-4xl font-bold text-[#253e16]">SHOWCASING OUR WORK</h2>

        <!-- Background text (optional aesthetic) -->
        <div class="absolute inset-0 flex items-center justify-center -z-10">
            <h2 class="text-[4rem] text-outline text-gray-200 opacity-20 select-none">Featured Properties</h2>
        </div>
    </div>

    <!-- Top Row (scrolls left) -->
    <div class="relative flex mb-10 overflow-hidden">
        <div class="flex gap-6 animate-scroll-left">
            @foreach ([['img/homepage/image-1.png', 'Heather 1 Exterior'], ['img/homepage/image-2.png', 'Lounge Area'], ['img/homepage/image-3.png', 'Landscape Design'], ['img/homepage/image-4.png', 'Reception Area']] as [$src, $caption])
            <x-showcase-image :src="asset($src)" :caption="$caption" />
            @endforeach

            <!-- Duplicate for seamless looping -->
            @foreach ([['img/homepage/image-1.png', 'Heather 1 Exterior'], ['img/homepage/image-2.png', 'Lounge Area'], ['img/homepage/image-3.png', 'Landscape Design'], ['img/homepage/image-4.png', 'Reception Area']] as [$src, $caption])
            <x-showcase-image :src="asset($src)" :caption="$caption" />
            @endforeach
        </div>
    </div>

    <!-- Bottom Row (scrolls right) -->
    <div class="relative flex overflow-hidden">
        <div class="flex gap-6 animate-scroll-right">
            @foreach ([['img/homepage/image-5.png', 'Pool Area'], ['img/homepage/image-6.png', 'Entrance Gate'], ['img/homepage/image-7.png', 'Model Unit 1'], ['img/homepage/image-8.png', 'Model Unit 2']] as [$src, $caption])
            <x-showcase-image :src="asset($src)" :caption="$caption" />
            @endforeach

            <!-- Duplicate for seamless looping -->
            @foreach ([['img/homepage/image-5.png', 'Pool Area'], ['img/homepage/image-6.png', 'Entrance Gate'], ['img/homepage/image-7.png', 'Model Unit 1'], ['img/homepage/image-8.png', 'Model Unit 2']] as [$src, $caption])
            <x-showcase-image :src="asset($src)" :caption="$caption" />
            @endforeach
        </div>
    </div>
</section>


<!-- Blogs Section -->
<section id="blogs" class="relative w-full pt-20 pb-[20rem] bg-[#f3f3f3]">
    <div class="relative z-0 max-w-screen-xl mx-auto">
        <!-- Section Header -->
        <div class="relative z-0 px-6 mx-auto max-w-screen-2xl">
            <div class="flex flex-col mb-12 md:flex-row md:items-center md:justify-between">
                <!-- Left Side (Title Block) -->
                <div class="relative">
                    <span
                        class="absolute -top-2 left-0 text-[5rem] md:text-[4rem] opacity-20 leading-none select-none text-outline">
                        Blogs
                    </span>
                    <p class="relative mb-4 text-lg font-bold text-green-700 uppercase">
                        Blogs
                    </p>
                    <h2 class="relative text-3xl font-bold md:text-4xl text-green-950">
                        NEWS & UPDATES
                    </h2>
                </div>

                <!-- Right Side (Button) -->
                <div class="mt-6 md:mt-0">
                    <a href="{{ route('blogs.show') }}"
                        class="inline-block px-6 py-3 font-semibold text-white transition bg-green-900 rounded-sm hover:bg-green-700">
                        See All Blogs
                    </a>
                </div>
            </div>
        </div>

        <!-- Blog Cards -->
        <section class="bg-transparent pt-20 pb-[10rem]">
            <div class="grid max-w-screen-xl grid-cols-1 gap-8 px-6 mx-auto md:grid-cols-3">
                @forelse ($blogs as $item)
                <div
                    class="group bg-white rounded-sm shadow-sm hover:shadow-md transition overflow-visible border-b-4 border-transparent hover:border-[#253e16] duration-300">

                    <!-- Image -->
                    <div class="relative w-full h-64 overflow-hidden">
                        <img src="{{ asset($item->blog_image) }}" alt="{{ $item->blog_title }}"
                            class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
                    </div>

                    <!-- Category & Date Bar -->
                    <div class="relative z-20 flex justify-center">
                        <div
                            class="absolute -top-5 bg-[#f3f3f3] text-[#253e16] text-sm px-2 py-3 flex items-center justify-between gap-2 shadow-lg w-[90%] max-w-md border border-gray-200 
                        transition-all duration-300 group-hover:bg-[#253e16] group-hover:text-white group-hover:border-[#253e16]">

                            <!-- Category -->
                            <div
                                class="flex items-center justify-center w-1/2 gap-2 text-center border-r border-gray-400 group-hover:border-gray-500">
                                <span class="text-base mingcute--pencil-ruler-line"></span>
                                <span>{{ $item->category->category_name ?? 'Uncategorized' }}</span>
                            </div>

                            <!-- Date -->
                            <div class="flex items-center justify-center w-1/2 gap-2 text-center">
                                <span class="text-base la--calendar-solid"></span>
                                <span>{{ \Carbon\Carbon::parse($item->blog_date)->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 mt-6 text-center">
                        <h3
                            class="mb-3 font-semibold text-gray-800 text-lg transition-colors duration-300 group-hover:text-[#253e16]">
                            {{ $item->title }}
                        </h3>
                        <a href="{{ route('blogs.details', ['id' => $item->id]) }}"
                            class="inline-block mt-2 text-[#253e16] font-medium hover:text-green-600 transition border-b border-b-[#253e16]">
                            Read More
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 col-span-3">No blogs available yet.</p>
                @endforelse
            </div>
        </section>
    </div>
</section>


<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Swiper Initialization -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Swiper(".blog-swiper", {
            loop: true,
            spaceBetween: 24,
            slidesPerView: 1,
            centeredSlides: false,
            navigation: {
                nextEl: ".blog-swiper-button-next",
                prevEl: ".blog-swiper-button-prev",
            },
            breakpoints: {
                640: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                },
            },
        });
    });
</script>
@endsection