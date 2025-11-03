@extends('layouts.guest')

@section('content')
<div>
    <x-banner2 page="Latest Blogs" breadcrumb="Blogs" img="img/blog-banner.png" />
</div>

<section class="bg-[#e8e8e8] pt-20 pb-[20rem]">
    <div class="grid max-w-screen-xl grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 px-6 mx-auto">
        @forelse ($blogs as $item)
        <div
            class="group bg-white rounded-sm shadow-sm hover:shadow-md transition overflow-visible border-b-4 border-transparent hover:border-[#253e16] duration-300">

            <!-- Image -->
            <div class="relative w-full h-64 overflow-hidden">
                <img src="{{ asset($item->thumbnail_image) }}" alt="{{ $item->thumbnail_image }}"
                    class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
            </div>

            <!-- Category & Date -->
            <div class="relative z-20 flex justify-center">
                <div
                    class="absolute -top-5 bg-[#f3f3f3] text-[#253e16] text-sm px-2 py-3 flex items-center justify-between gap-2 shadow-lg w-[90%] max-w-md border border-gray-200 
                            transition-all duration-300 group-hover:bg-[#253e16] group-hover:text-white group-hover:border-[#253e16]">

                    <!-- Category -->
                    <div
                        class="flex items-center justify-center w-1/2 gap-2 text-center border-r border-gray-400 group-hover:border-gray-500">
                        <span class="text-base mingcute--pencil-ruler-line"></span>
                        <span>{{ $item->category?->category_name ?? 'Uncategorized' }}</span>
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
                    {{ $item->blog_title }}
                </h3>

                <a href="{{ route('blogs.details', ['id' => $item->id]) }}"
                    class="inline-block mt-2 text-[#253e16] font-medium hover:text-green-600 transition border-b border-b-[#253e16]">
                    Read More
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center text-gray-600">
            No blogs available at the moment.
        </div>
        @endforelse
    </div>
</section>
@endsection