@props(['images' => []])

<div>
    <div x-data="gallery({{ json_encode($images) }})" class="relative z-10 lg:col-span-7">

        <!-- Main Image Container -->
        <div class="relative w-full overflow-hidden bg-gray-200 aspect-video">
            <div class="relative w-full h-full group">

                <!-- Main Image -->
                <template x-for="(image, index) in images" :key="index">
                    <img x-show="current === index" :src="image"
                        class="object-cover object-center w-full h-full transition-all duration-500 ease-in-out">
                </template>

                <!-- Navigation Arrows -->
                <div class="absolute inset-0 flex items-center justify-between p-4">
                    <button @click="prev"
                        class="p-2 text-white transition rounded-full bg-black/50 hover:bg-black/70 amenities-button-next">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>
                    <button @click="next"
                        class="p-2 text-white transition rounded-full bg-black/50 hover:bg-black/70 amenities-button-prev">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>

                <!-- Show/Hide Thumbnails Button -->
                <div
                    class="absolute bottom-0 z-20 transition ease-in-out transform -translate-x-1/2 translate-y-11 left-1/2 group-hover:-translate-y-[2px]">
                    <button @click="showThumbs = !showThumbs"
                        class="flex flex-col items-center gap-1 px-4 py-1 text-sm text-white transition">
                        <!-- Down arrow -->
                        <svg x-show="!showThumbs" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                        <!-- Up arrow -->
                        <svg x-show="showThumbs" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
                        </svg>
                        <span x-show="showThumbs">Hide All</span>
                        <span x-show="!showThumbs">Show All</span>
                    </button>
                </div>

                <!-- Loader -->
                <div x-show="loading" x-transition:enter="transition ease-in-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="absolute bottom-0 z-10 w-full p-6 text-center bg-gradient-to-t from-[#002B0A] to-transparent">
                    <div class="flex items-center justify-center space-x-2 text-yellow-400">
                        <svg class="w-6 h-6 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span>Loading thumbnails...</span>
                    </div>
                </div>

                <!-- Thumbnails -->
                <div x-cloak x-show="!showThumbs && !loading" x-transition:enter="transition ease-in-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="absolute bottom-0 z-10 w-full p-4 bg-gradient-to-t from-[#002B0A] to-transparent lg:mt-[38rem]">
                    <div class="swiper thumbnailSwiper">
                        <div class="swiper-wrapper">
                            <template x-for="(image, index) in images" :key="index">
                                <div class="swiper-slide">
                                    <div @click="current = index"
                                        class="overflow-hidden transition border-2 cursor-pointer h-fit hover:opacity-80"
                                        :class="current === index ? 'border-yellow-400' : 'border-transparent'">
                                        <img :src="image"
                                            class="h-auto xl:h-[10rem] object-cover w-full aspect-square">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('gallery', (initialImages) => ({
            images: [],
            current: 0,
            showThumbs: false,
            loading: true,
            thumbSwiper: null,

            init() {
                // Simulate async load
                setTimeout(() => {
                    this.images = initialImages;
                    this.loading = false;
                    this.showThumbs = true;
                    this.initThumbSwiper();
                }, 1000);

                // Watch visibility
                this.$watch('showThumbs', (value) => {
                    if (value && !this.loading) {
                        setTimeout(() => this.initThumbSwiper(), 200);
                    }
                });
            },

            initThumbSwiper() {
                if (this.thumbSwiper) {
                    this.thumbSwiper.destroy(true, true);
                }
                this.thumbSwiper = new Swiper('.thumbnailSwiper', {
                    slidesPerView: 5,
                    spaceBetween: 10,
                    navigation: {
                        nextEl: '.amenities-button-next',
                        prevEl: '.amenities-button-prev',
                    },
                    loop: true,
                    observer: true,
                    observeParents: true,
                });
            },

            next() {
                this.current = (this.current + 1) % this.images.length;
            },
            prev() {
                this.current = (this.current - 1 + this.images.length) % this.images.length;
            },
        }));
    });
</script>
