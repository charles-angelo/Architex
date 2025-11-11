{{-- <nav x-data="{ open: false }" class="relative bg-transparent">
    <div class="flex items-center justify-between py-4 lg:mr-[15rem] border-b-2 border-[#717171]/30">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="{{ route('homepage') }}">
                <img src="{{ asset('img/homepage/logo.png') }}" alt="Architex Logo" class="object-contain w-auto h-10">
            </a>
        </div>

        <!-- Desktop Navigation -->
        <ul class="items-center hidden gap-8 font-medium text-black md:flex">
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
                    class="{{ request()->routeIs('properties') ? 'text-[#00721B] font-bold' : 'hover:text-[#00721B]' }}">
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
                <a href="{{ route('blogs') }}"
                    class="{{ request()->routeIs('blogs') ? 'text-[#00721B] font-bold' : 'hover:text-[#00721B]' }}">
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
        <button @click="open = !open" class="md:hidden flex flex-col justify-center items-center space-y-1.5">
            <span :class="open ? 'rotate-45 translate-y-1.5' : ''"
                class="block w-6 h-0.5 bg-black transition-all duration-300"></span>
            <span :class="open ? 'opacity-0' : ''" class="block w-6 h-0.5 bg-black transition-all duration-300"></span>
            <span :class="open ? '-rotate-45 -translate-y-1.5' : ''"
                class="block w-6 h-0.5 bg-black transition-all duration-300"></span>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition class="absolute z-50 bg-white border-t border-black md:hidden top-full">
        <ul class="flex flex-col items-start px-6 py-4 space-y-4 font-medium text-black">
            <li><a href="{{ route('homepage') }}"
                    class="block w-full {{ request()->routeIs('homepage') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">Home</a>
            </li>
            <li><a href="{{ route('about-us') }}"
                    class="block w-full {{ request()->routeIs('about-us') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">About
                    Us</a></li>
            <li><a href="{{ route('properties.show') }}"
                    class="block w-full {{ request()->routeIs('properties') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">Properties</a>
            </li>
            <li><a href="{{ route('services') }}"
                    class="block w-full {{ request()->routeIs('services') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">Services</a>
            </li>
            <li><a href="{{ route('blogs') }}"
                    class="block w-full {{ request()->routeIs('blogs') ? 'text-[#00721B]' : 'hover:text-[#00721B]' }}">Blogs</a>
            </li>
            <li class="w-full">
                <a href="{{ route('contactUs') }}"
                    class="block w-full px-5 py-2 font-medium text-center text-white transition-all bg-green-900 rounded hover:bg-green-700">
                    Contact Us
                </a>
            </li>
        </ul>
    </div>
</nav>

<script src="//unpkg.com/alpinejs" defer></script> --}}
