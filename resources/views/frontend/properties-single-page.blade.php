@extends('layouts.guest')

@php
    $tabs = ['Overview', 'Sitemap', 'Amenities'];
@endphp

@section('content')
    <!-- 🟢 Banner -->
    <div class="bg-[#f3f3f3]">
        <div>
            <x-banner2 page="Property Details" breadcrumb="Properties" breadcrumb2="Apo Yama Residences"
                link="{{ route('properties.show') }}" img="img/properties/page-header.png" />
        </div>

        <!-- 🟢 Header Image -->
        <section class="px-4 py-16 md:px-12">
            <div class="flex flex-col items-center justify-center mx-auto text-center max-w-screen-2xl">
                <!-- Property Logo -->
                <img src="{{ asset('img/properties/apo-yama logo.png') }}" alt="Apo Yama Logo" class="h-auto w-[25rem] mb-6">

                <!-- Property Name -->
                <h2 class="text-3xl md:text-2xl text-[#1E4D2B] mb-10">{{ $property['name'] }}</h2>

                <!-- 🟢 Property Thumbnail Only -->
                @if (!empty($property['property_thumbnail']))
                    <div class="w-full overflow-hidden rounded-lg shadow-md max-w-screen-2xl">
                        <img src="{{ asset($property['property_thumbnail']) }}" alt="{{ $property['name'] }}"
                            class="object-cover w-full h-auto transition-all duration-500 ease-in-out">
                    </div>
                @endif
            </div>
        </section>



        <!-- 🟢 Tabs Section -->
        <section class="pt-10 pb-[35rem] px-4 sm:px-6 lg:px-8" x-data="{
            tabs: @js($tabs),
            activeTab: 'Overview',
        }">
            <div class="mx-auto max-w-screen-2xl">

                <!-- Tabs -->
                <div class="flex justify-center mb-12 border-b border-gray-300">
                    <template x-for="tab in tabs" :key="tab">
                        <button @click="activeTab = tab"
                            class="px-4 pb-3 text-lg font-semibold transition duration-300 border-b-2"
                            :class="{
                                'text-green-900 border-green-700': activeTab === tab,
                                'text-gray-500 hover:text-green-900 border-transparent': activeTab !== tab
                            }">
                            <span x-text="tab"></span>
                        </button>
                    </template>
                </div>

                <!-- 🟢 Overview Tab -->
                <div x-show="activeTab === 'Overview'" x-transition>
                    <div>
                        <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-16">
                            <!-- Left -->
                            <div class="flex flex-col justify-center">
                                <h1 class="text-4xl font-bold text-[#537746] mb-6">{{ $property['name'] }}</h1>
                                <p class="mb-6 text-lg leading-relaxed text-gray-700">{!! $property['description'] !!}</p>
                                <button class="bg-[#253e16] px-5 py-3 mt-5 text-white w-fit" @click="activeTab = 'Sitemap'">
                                    Reserve Nowssss
                                </button>
                            </div>

                            <!-- Right Gallery -->
                            <x-image-gallery :images="$property->images->map(fn($img) => asset($img->image))" />
                        </div>
                    </div>
                </div>

                <!-- 🟢 Sitemap Tab -->
                <div x-show="activeTab === 'Sitemap'" x-transition>
                    <x-property.sitemap-view :lots="$lots" :property="$property" :floorplan="$lots" />
                    {{-- <x-sitemap-interactive :lots="$lots" /> --}}
                </div>


                <!-- 🟢 Amenities Tab -->
                <div x-show="activeTab === 'Amenities'" x-transition>
                    <x-amenities-image :images="$allAmenities" flag="Amenities" />
                </div>
            </div>
        </section>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function gallery(images) {
            return {
                images,
                current: 0,
                showThumbs: true,
                next() {
                    this.current = (this.current + 1) % this.images.length;
                },
                prev() {
                    this.current = (this.current - 1 + this.images.length) % this.images.length;
                }
            };
        }
    </script>
@endsection
