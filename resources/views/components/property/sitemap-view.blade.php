@props([
'lots' => [],
'floorplan' => [],
'property' => [],
])

<div
    x-data="{
        activeTab: 'Sitemap',
        activeLot: null,
        lots: @js($lots),

        selectLot(lot) {
            this.activeLot = {
                id: lot.id ?? null,
                name: lot.name ?? 'Unnamed Lot',
                address: lot.block && lot.name 
                 ? `Block ${lot.block}, Lot ${lot.name}` 
                 : 'Address not available',
                type: lot.type ?? 'N/A',
                category: lot.category ?? 'N/A',
                description: lot.description ?? 'No description available.',
                highlights: lot.highlights ?? '',
                house_details: lot.images ?? [],
                floor_plans: lot.floorPlans ?? [], // ✅ add this
                position: lot.position ?? '',
                size: lot.size ?? 'N/A',
                price: lot.price ?? 'N/A',
                status: lot.status ?? 'N/A',
            };

            this.$nextTick(() => {
                // Update house gallery
                if (typeof galleryComponent !== 'undefined' && this.activeLot.house_details?.length) {
                    galleryComponent.house_details = this.activeLot.house_details;
                    galleryComponent.current = 0;
                }

                // Update floor plan gallery
                if (typeof floorPlanGalleryComponent !== 'undefined' && this.activeLot.floor_plans?.length) {
                    floorPlanGalleryComponent.plans = this.activeLot.floor_plans;
                    floorPlanGalleryComponent.current = 0;
                }
            });
        },

        resetLot() { this.activeLot = null; },
    }"
    class="w-full">

    <!-- Sitemap Section -->
    <div x-show="activeTab === 'Sitemap'" x-transition>
        <div class="grid items-start grid-cols-1 gap-10 lg:grid-cols-2">

            <!-- 🧩 Left Panel: Lot Info -->
            <div class="bg-white p-8 rounded-lg shadow-inner text-left max-h-[90vh] overflow-y-auto h-fit">

                <!-- Placeholder when no lot is selected -->
                <template x-if="!activeLot">
                    <div class="text-center py-60">
                        <img src="{{ asset('img/properties/property-select.png') }}"
                            alt="Select Lot"
                            class="object-contain w-32 h-32 mx-auto mb-6">
                        <h3 class="text-2xl font-bold text-[#1E4D2B] mb-3">Select a Lot to View Details</h3>
                        <p class="max-w-md mx-auto text-gray-600">
                            Click on any highlighted lot from the sitemap to view details such as size, price, and availability.
                        </p>
                    </div>
                </template>

                <!-- Active Lot Info -->
                <div x-data="{ showFloorPlan: false }">
                    <template x-if="activeLot">
                        <div class="space-y-6 transition-all duration-500 ease-in-out"
                            :class="{ 'relative z-10 w-full': !showFloorPlan, 'absolute inset-0 z-0 opacity-0 pointer-events-none': showFloorPlan }"
                            x-ref="lotContent">

                            <!-- Header -->
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-3xl font-bold text-[#1E4D2B]" x-text="activeLot.name"></h2>
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" class="text-[#1E4D2B]">
                                            <path fill="currentColor" d="M6 .5A4.5 4.5 0 0 1 10.5 5c0 1.863-1.42 3.815-4.2 5.9a.5.5 0 0 1-.6 0C2.92 8.815 1.5 6.863 1.5 5A4.5 4.5 0 0 1 6 .5m0 3a1.5 1.5 0 1 0 0 3a1.5 1.5 0 0 0 0-3" />
                                        </svg>
                                        <p class="mt-1 text-gray-600" x-text="activeLot.address"></p>
                                    </div>
                                    <span class="inline-block px-4 py-1 mt-3 text-sm font-medium text-yellow-800 bg-yellow-100 rounded-full" x-text="activeLot.type"></span>
                                </div>
                                <button @click="showFloorPlan = !showFloorPlan"
                                    class="bg-[#1E4D2B] text-white text-sm font-medium px-6 py-3 hover:bg-green-900 transition"
                                    x-text="showFloorPlan ? 'Back to Lot' : 'Floor Plan'"></button>
                            </div>

                            <!-- Image Gallery for Lot -->
                            <div>
                                <div x-data="gallery2([])"
                                    x-init="$watch('activeLot', value => {
                                            if (value && value.house_details) {
                                                galleryComponent.house_details = value.house_details;
                                                galleryComponent.current = 0;
                                            }
                                        })"
                                    x-ref="galleryWrapper"
                                    class="relative z-10 lg:col-span-7">

                                    <div class="relative w-full overflow-hidden bg-gray-200 aspect-video">
                                        <div class="relative w-full h-full group">

                                            <!-- Main Images -->
                                            <template x-for="(image, index) in house_details" :key="index">
                                                <img
                                                    x-show="current === index"
                                                    :src="image"
                                                    class="object-contain object-center transition-all duration-500 ease-in-out">
                                            </template>

                                            <!-- Navigation Arrows -->
                                            <div class="absolute inset-0 flex items-center justify-between p-4">
                                                <button @click="prev" class="p-2 text-white bg-black/50 rounded-full hover:bg-black/70">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                                    </svg>
                                                </button>
                                                <button @click="next" class="p-2 text-white bg-black/50 rounded-full hover:bg-black/70">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Hide/Show Button -->
                                            <div
                                                class="absolute bottom-0 z-20 transition ease-in-out transform -translate-x-1/2 translate-y-11 left-1/2 group-hover:-translate-y-[2px]">
                                                <button @click="showThumbs = !showThumbs"
                                                    class="flex flex-col items-center gap-1 px-4 py-1 text-sm text-white transition">
                                                    <!-- Down arrow when hidden -->
                                                    <svg x-show="!showThumbs" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M19 9l-7 7-7-7" />
                                                    </svg>

                                                    <!-- Up arrow when shown -->
                                                    <svg x-show="showThumbs" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 15l7-7 7 7" />
                                                    </svg>

                                                    <!-- Text -->
                                                    <span x-show="showThumbs">Hide All</span>
                                                    <span x-show="!showThumbs">Show All</span>
                                                </button>
                                            </div>

                                            <!-- Thumbnails Overlay -->
                                            <div x-show="!showThumbs"
                                                x-transition:enter="transition ease-in-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0"
                                                class="absolute bottom-0 z-10 grid w-full grid-cols-5 gap-3 p-4 bg-gradient-to-t from-[#002B0A] to-transparent">

                                                <template x-for="(image, index) in house_details" :key="index">
                                                    <div
                                                        @click="current = index"
                                                        class="overflow-hidden transition border-2 cursor-pointer hover:opacity-80"
                                                        :class="current === index ? 'border-yellow-400' : 'border-transparent'">
                                                        <img :src="image" class="object-cover w-full h-24 aspect-square">
                                                    </div>
                                                </template>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Lot Info Grid -->
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="p-4 border rounded-md">
                                    <p class="mb-1 text-sm text-gray-600">Lot Area</p>
                                    <p class="text-xl font-semibold text-gray-800" x-text="activeLot.size"></p>
                                </div>
                                <div class="p-4 border rounded-md">
                                    <p class="mb-1 text-sm text-gray-600">Type</p>
                                    <p class="text-xl font-semibold text-gray-800" x-text="activeLot.category"></p>
                                </div>
                                <div class="p-4 border rounded-md">
                                    <p class="mb-1 text-sm text-gray-600">Price</p>
                                    <p class="text-xl font-semibold text-gray-800" x-text="activeLot.price"></p>
                                </div>
                                <div class="p-4 border rounded-md">
                                    <p class="mb-1 text-sm text-gray-600">Status</p>
                                    <p class="text-xl font-semibold"
                                        :class="{
                                            'text-green-700': activeLot.status === 'Available',
                                            'text-yellow-600': activeLot.status === 'Reserved',
                                            'text-red-600': activeLot.status === 'Sold'
                                        }"
                                        x-text="activeLot.status"></p>
                                </div>
                            </div>

                            <!-- Lot Description -->
                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-800">Description</h3>
                                <div class="text-gray-700" x-html="activeLot.description"></div>
                            </div>


                            <div>
                                <h3 class="mb-2 text-lg font-semibold text-gray-800">Highlights</h3>
                                <p class="text-gray-700" x-text="activeLot.highlights || 'Information coming soon.'"></p>
                            </div>
                        </div>
                    </template>

                    <!-- 🏠 Floor Plan Section -->
                    <div class="relative z-10 flex flex-col w-full h-full gap-5 bg-white"
                        :class="{ 'hidden': !showFloorPlan, 'translate-x-0 opacity-100': showFloorPlan }">

                        <div class="flex items-center justify-between">
                            <button @click="showFloorPlan = false"
                                class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="m4 10l-.354.354L3.293 10l.353-.354zm16.5 8a.5.5 0 0 1-1 0zM8.646 15.354l-5-5l.708-.708l5 5zm-5-5.708l5-5l.708.708l-5 5zM4 9.5h10v1H4zM20.5 16v2h-1v-2zM14 9.5a6.5 6.5 0 0 1 6.5 6.5h-1a5.5 5.5 0 0 0-5.5-5.5z" />
                                </svg>
                                Back
                            </button>
                            <div
                                x-data="{ selectedLot: null }"
                                @open-reserve-modal.window="selectedLot = $event.detail.lot"
                                class="flex gap-5">
                                <div class="bg-[#ffd601] px-5 py-3 hover:bg-[#ffe350] cursor-pointer">
                                    Virtual Tours
                                </div>

                                <!-- Reserve Modal -->
                                @include('components.reserveModal')
                            </div>

                        </div>

                        <div class="flex-1">
                            <x-floor-plan-gallery :plans="[]" />

                        </div>

                        <div class="flex flex-col gap-5 text-[#253e16] pb-6">
                            <div class="text-sm font-light">Floor Plan</div>
                            <div class="mb-2 text-xl font-medium" x-text="activeLot?.name || 'Floor Plan'"></div>
                            <div>
                                <div class="text-sm font-bold">Description</div>
                                <div class="mb-2 text-base" x-html="activeLot?.description"></div>
                                <div class="text-sm font-bold">Highlights</div>
                                <div x-text="activeLot?.highlights"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🗺️ Right Panel: Sitemap -->
            <div class="relative overflow-hidden">
                <!-- Background Map -->
                <img src="{{ asset('img/properties/sitemap.svg') }}"
                    alt="Sitemap"
                    class="object-contain w-full h-auto">

                <!-- Dynamic Lot Markers -->
                <template x-for="(lot, index) in lots" :key="index">
                    <button
                        @click="selectLot(lot)"
                        class="absolute flex items-center justify-center w-6 h-6 text-xs font-semibold text-white rounded-full transition transform hover:scale-110 hover:shadow-lg focus:outline-none"
                        :style="`left: ${lot.position.x}px; top: ${lot.position.y}px; transform: translate(-50%, -50%);`"
                        :class="{
            'bg-green-700': lot.status === 'Available',
            'bg-yellow-400': lot.status === 'Reserved',
            'bg-red-500': lot.status === 'Sold',
            'bg-gray-400': !['Available','Reserved','Sold'].includes(lot.status)
        }"
                        x-text="lot.id">
                    </button>
                </template>

            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('gallery2', (initialImages = []) => ({
            house_details: initialImages,
            current: 0,
            showThumbs: true,

            init() {
                galleryComponent = this;
            },
            next() {
                this.current = (this.current + 1) % this.house_details.length;
            },
            prev() {
                this.current = (this.current - 1 + this.house_details.length) % this.house_details.length;
            }
        }))
    })

    document.addEventListener('alpine:init', () => {
        Alpine.data('floorPlanGallery', (initialPlans = []) => ({
            plans: initialPlans,
            current: 0,
            showThumbs: false,
            init() {
                window.floorPlanGalleryComponent = this;
            },
            next() {
                if (this.plans.length)
                    this.current = (this.current + 1) % this.plans.length;
            },
            prev() {
                if (this.plans.length)
                    this.current = (this.current - 1 + this.plans.length) % this.plans.length;
            },
        }));
    });
</script>