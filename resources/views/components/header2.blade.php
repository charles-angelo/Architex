<nav x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => {
    scrolled = window.scrollY > 50;
})"
    :class="scrolled
        ?
        'bg-white shadow-md top-0 left-0 w-full fixed transition-all duration-300 py-8 z-[9999]' :
        'bg-transparent lg:static border-b-2 border-[#717171]/30  lg:container lg:mx-auto'"
    class="fixed min-w-full lg:min-w-fit z-[9999]">
    <div class="flex justify-between py-4 lg:container lg:mx-auto ">
        <!-- Logo -->
        <div class="flex items-center px-3">
            <a href="{{ route('homepage') }}">
                <img src="{{ asset('img/homepage/logo.png') }}" alt="Architex Logo" class="object-contain w-auto h-10">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <ul class="items-center hidden gap-8 font-medium text-black xl:flex">
            <li>
                <a href="{{ route('homepage') }}"
                    class="{{ request()->routeIs('homepage') ? 'text-[#00721B] font-bold' : 'hover:text-[#00721B]' }}">
                    Home
                </a>
            </li>
            <li>
                <a href="{{ route('about-us') }}"
                    class="{{ request()->routeIs('about-us') ? 'text-[#00721B] font-bold' : 'hover:text-[#00721B]' }}">
                    About Us
                </a>
            </li>
            <li>
                <a href="{{ route('properties.show') }}"
                    class="{{ Route::is('properties.*') ? 'text-[#00721B] font-bold' : 'hover:text-[#00721B]' }}">
                    Properties
                </a>
            </li>
            <li>
                <a href="{{ route('services') }}"
                    class="{{ request()->routeIs('services') ? 'text-[#00721B] font-bold' : 'hover:text-[#00721B]' }}">
                    Services
                </a>
            </li>
            <li>
                <a href="{{ route('blogs.show') }}"
                    class="{{ request()->routeIs('blogs.*') ? 'text-[#00721B] font-bold' : 'hover:text-[#00721B]' }}">
                    Blogs
                </a>
            </li>
            <li>
                <div class="flex items-center gap-4">
                    <a href="{{ route('contactUs') }}"
                        class="relative px-5 py-2 overflow-hidden font-medium text-white transition-all duration-300 bg-green-900 rounded group">
                        <span class="relative z-10">Contact Us</span>
                        <span
                            class="absolute top-0 left-0 w-0 h-full transition-all duration-500 ease-in-out bg-green-700 pointer-events-none group-hover:w-full"></span>
                    </a>

                    <button class="text-green-900 hover:text-[#00721B]" aria-label="search">
                        <span class="text-2xl material-symbols--search">search</span>
                    </button>
                </div>
            </li>
        </ul>

        <!-- Hamburger Menu Button -->
        <button @click="open = !open" class="xl:hidden flex flex-col justify-center items-center space-y-1.5 px-3 mr-5">
            <span :class="open ? 'rotate-45 translate-y-1.5' : ''"
                class="block w-6 h-0.5 bg-black transition-all duration-300"></span>
            <span :class="open ? 'opacity-0' : ''" class="block w-6 h-0.5 bg-black transition-all duration-300"></span>
            <span :class="open ? '-rotate-45 -translate-y-1.5' : ''"
                class="block w-6 h-0.5 bg-black transition-all duration-300"></span>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="absolute z-50 w-full bg-white xl:hidden top-full drop-shadow-md">
        <ul class="flex flex-col items-start py-4 pb-12 mx-3 space-y-4 font-medium text-black">
            <li><a href="{{ route('homepage') }}"
                    class="block  {{ request()->routeIs('homepage') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">Home</a>
            </li>
            <li><a href="{{ route('about-us') }}"
                    class="block  {{ request()->routeIs('about-us') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">About
                    Us</a></li>
            <li><a href="{{ route('properties.show') }}"
                    class="block  {{ request()->routeIs('properties.*') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">Properties</a>
            </li>
            <li><a href="{{ route('services') }}"
                    class="block  {{ request()->routeIs('services') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">Services</a>
            </li>
            <li><a href="{{ route('blogs.show') }}"
                    class="block  {{ request()->routeIs('blogs.*') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">Blogs</a>
            </li>
            <li class="">
                <a href="{{ route('contactUs') }}"
                    class="block w-full px-10 py-2 font-medium text-center text-white transition-all bg-green-900 rounded hover:bg-green-700">
                    Contact Us
                </a>
            </li>
            <li class="flex lg:hidden">
                <div class="absolute lg:grid items-center justify-center flex lg:grid-cols-1 lg:top-[30%] gap-10">
                    <div class="flex flex-col items-center gap-10">
                        <span
                            class="text-sm tracking-widest rotate-0 lg:-rotate-90 text-black lg:text-white origin-center transform scale-y-[1]">
                            Follow Us
                        </span>
                    </div>

                    <!-- Social Icons -->
                    <div class="flex items-center gap-6 lg:flex-col">
                        <span class="w-px h-6 rotate-90 bg-green-900"></span>
                        <a href="#"
                            class="flex items-center justify-center w-10 h-10 text-[#00C52F] hover:text-green-800 hover:bg-yellow-400 bg-green-800 rounded-full transition duration-300">
                            <i class="p-3 ri--facebook-fill"></i>
                        </a>
                        {{-- <a href="#"
                            class="flex items-center justify-center w-10 h-10 bg-green-800 text-[#00C52F] rounded-full hover:text-green-800 hover:bg-yellow-400 transition duration-300">
                            <i class="p-3 mingcute--instagram-fill "></i>
                        </a>
                        <a href="#"
                            class="flex items-center justify-center w-10 h-10 bg-green-900 text-[#00C52F] rounded-full hover:text-green-800 hover:bg-yellow-400 transition duration-300">
                            <i class="p-3 ic--baseline-tiktok "></i>
                        </a> --}}
                        <span class="w-px h-6 rotate-90 bg-green-900"></span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script src="//unpkg.com/alpinejs" defer></script>
