@props(['flag' => '', 'images' => []])

<div>
    <div x-data="gallery({{ json_encode($images) }})" class="relative z-10 lg:col-span-7">
        <!-- Main Image Container -->
        <div class="relative w-full overflow-hidden bg-gray-200 aspect-video">
            <!-- Main Image -->
            <div class="relative w-full h-full group">
                <template x-for="(image, index) in images" :key="index">
                    <img x-show="current === index" :src="image"
                        class="
                            {{ $flag === 'Amenities' ? 'object-cover' : ($flag === 'FloorPlan' ? 'object-contain' : 'object-contain') }} 
                            object-center w-full h-full transition-all duration-500 ease-in-out
                        ">
                </template>

                <!-- Navigation Arrows -->
                <div class="absolute inset-0 flex items-center justify-between p-4">
                    <button @click="prev" class="p-2 text-white transition rounded-full bg-black/50 hover:bg-black/70">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>
                    <button @click="next" class="p-2 text-white transition rounded-full bg-black/70 hover:bg-black/70">
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
                        <svg x-show="!showThumbs" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                        <svg x-show="showThumbs" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
                        </svg>
                        <span x-show="showThumbs">Hide All</span>
                        <span x-show="!showThumbs">Show All</span>
                    </button>
                </div>

                <!-- Thumbnails Overlay -->
                <div x-show="!showThumbs" x-transition:enter="transition ease-in-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute bottom-0 z-10 grid w-full h-full grid-cols-5 gap-3 p-4 bg-gradient-to-t from-[#002B0A] to-transparent">

                    <template x-for="(image, index) in images" :key="index">
                        <div @click="current = index"
                            class="
                                {{ $flag === 'Amenities' ? '2xl:mt-[38rem]' : ($flag === 'FloorPlan' ? '2xl:mt-[18rem]' : '2xl:mt-[15rem]') }}
                                overflow-hidden transition border-2 cursor-pointer h-fit hover:opacity-80
                            "
                            :class="current === index ? 'border-yellow-400' : 'border-transparent'">
                            <img :src="image"
                                class="
                                    {{ $flag === 'Amenities' ? 'h-[10rem]' : ($flag === 'FloorPlan' ? 'h-[8rem]' : 'h-[6rem]') }}
                                    object-cover w-full aspect-square
                                ">
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
