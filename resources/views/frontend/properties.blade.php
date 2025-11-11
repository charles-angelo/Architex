@extends('layouts.guest')

@section('content')
    @php
        // Example heroes data (you can make this dynamic too)
        $heroes = [
            [
                'title' => '',
                'description' => '',
                'button_text' => '',
                'button_link' => '#',
                'video' => '',
                'fallback_image' => 'img/properties/page-header.png',
            ],
        ];

        $breadcrumbs = [
            'homepage' => 'Home',
            'properties' => 'Properties',
        ];

        $pageTitle = 'Properties';
    @endphp

    <div>
        <x-banner2 page="List of Properties" breadcrumb="Properties" img="img/properties/page-header.png" />
    </div>

    <section class="bg-[#f3f3f3] pt-[10rem] pb-[35rem] px-6 md:px-16">
        <div class="mx-auto max-w-screen-2xl">
            <!-- 2x2 Grid Layout -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                @foreach ($properties as $item)
                    <a href="{{ route('properties.single-page', ['id' => $item->id]) }}"
                        class="relative block h-auto col-span-2 overflow-hidden shadow-md group">

                        <img src="{{ asset($item->image) }}" alt="Project {{ $item->title }}"
                            class="object-cover w-full h-full transition-transform duration-700 group-hover:scale-105">

                        <!-- Custom Dark Green Overlay (appears on hover) -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#253e16]/90 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <!-- Title Text -->
                        <div
                            class="absolute bottom-0 left-0 w-full p-6 text-white transition-all duration-500 translate-y-6 opacity-0 group-hover:opacity-100 group-hover:translate-y-0">
                            <h3 class="text-2xl font-semibold">{{ $item->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
