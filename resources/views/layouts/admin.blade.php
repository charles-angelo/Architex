<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Architex Admin')</title>
    @vite('resources/css/app.css')

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- DataTables & SweetAlert -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/homepage/logo.png') }}">
</head>

<body x-data="{ sidebarOpen: true }" class="flex min-h-screen bg-[#e8e8e8]">

    {{-- Sidebar --}}
    <aside
        :class="sidebarOpen ? 'w-64' : 'w-20'"
        class="bg-[#1E4D2B] text-white flex-shrink-0 flex flex-col justify-between min-h-screen transition-all duration-300 shadow-lg">
        <!-- Top Section -->
        <div>
            <!-- Logo + Toggle -->
            <div class="flex items-center justify-between p-4 border-b border-white/20">
                <!-- Full Logo -->
                <img
                    src="{{ asset('img/homepage/logo.png') }}"
                    alt="Architex Logo"
                    class="h-10 w-auto"
                    x-show="sidebarOpen"
                    x-transition>

                <!-- Small Logo -->
                <img
                    src="{{ asset('img/homepage/logo.png') }}"
                    alt="Small Logo"
                    class="h-10 w-auto mx-auto"
                    x-show="!sidebarOpen"
                    x-transition>

                <!-- Toggle Button -->
                <button
                    class="text-white/70 hover:text-white transition"
                    @click="sidebarOpen = !sidebarOpen">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 transform transition-transform duration-300"
                        :class="sidebarOpen ? 'rotate-0' : 'rotate-180'"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-4 text-sm">
                <ul class="space-y-2">
                    <!-- Homepage Banner -->
                    <li>
                        <a href="{{ route('admin.banners.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition
                            {{ request()->routeIs('admin.banners.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'hover:bg-white/10' }}"
                            :class="{ 'justify-center': !sidebarOpen, 'justify-start': sidebarOpen }">
                            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Homepage Banner</span>
                        </a>
                    </li>

                    <!-- Services -->
                    <!-- <li>
                        <a href="{{ route('admin.services.index') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition
                            {{ request()->routeIs('admin.services.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'hover:bg-white/10' }}"
                            :class="{ 'justify-center': !sidebarOpen, 'justify-start': sidebarOpen }">
                            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L15 12 9.75 7" />
                            </svg>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Services</span>
                        </a>
                    </li> -->

                    <!-- Content Management Dropdown -->
                    <li
                        x-data="{ 
        open: {{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blogCategories.*') ? 'true' : 'false' }} 
    }"
                        class="space-y-1">

                        <button @click="open = !open"
                            class="flex items-center w-full px-3 py-2 rounded-lg transition hover:bg-white/10
        {{ request()->routeIs('admin.blogs.*') || request()->routeIs('admin.blogCategories.*') ? 'bg-white text-[#1E4D2B] font-semibold' : '' }}"
                            :class="{ 'justify-start': !sidebarOpen, 'justify-between': sidebarOpen }">

                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5h18M9 3v2m6-2v2M5 9h14v12H5z" />
                                </svg>
                                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Content Management</span>
                            </div>

                            <svg x-show="sidebarOpen" :class="{ 'rotate-180': open }"
                                class="h-4 w-4 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Links -->
                        <ul x-show="open" x-collapse class="pl-10 mt-1 space-y-1">
                            <li>
                                <a href="{{ route('admin.blogs.index') }}"
                                    class="block py-2 pl-4 pr-6 rounded-lg transition 
                {{ request()->routeIs('admin.blogs.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'text-white hover:bg-white/10' }}">
                                    <span class="whitespace-nowrap">Blogs</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.blogCategories.index') }}"
                                    class="block py-2 pl-4 pr-6 rounded-lg transition 
                {{ request()->routeIs('admin.blogCategories.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'text-white hover:bg-white/10' }}">
                                    <span class="whitespace-nowrap">Blog Categories</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- Property Management Dropdown -->
                    <li x-data="{ 
    open: {{ request()->routeIs('admin.properties.*') || request()->routeIs('admin.blocks.*') || request()->routeIs('admin.lots.*') || request()->routeIs('admin.lotTypes.*') || request()->routeIs('admin.lotCategories.*') ? 'true' : 'false' }} 
}" class="space-y-1">

                        <button @click="open = !open"
                            class="flex items-center w-full px-3 py-2 rounded-lg transition hover:bg-white/10
{{ request()->routeIs('admin.properties.*') || request()->routeIs('admin.blocks.*') || request()->routeIs('admin.lots.*') || request()->routeIs('admin.lotTypes.*') || request()->routeIs('admin.lotCategories.*') ? 'bg-white text-[#1E4D2B] font-semibold' : '' }}"
                            :class="{ 'justify-start': !sidebarOpen, 'justify-between': sidebarOpen }">

                            <div class="flex items-center gap-2">
                                <!-- Icon -->
                                <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 20q-.825 0-1.412-.587T5 18v-7.15l-2 1.525q-.35.25-.75.213T1.6 12.2t-.2-.75t.4-.65l8.975-6.875q.275-.2.588-.3t.637-.1t.638.1t.587.3L16 6.05V5.5q0-.625.438-1.062T17.5 4t1.063.438T19 5.5v2.85l3.2 2.45q.325.25.388.65t-.188.75t-.65.388t-.75-.213l-2-1.525V18q0 .825-.587 1.413T17 20h-1q-.825 0-1.412-.587T14 18v-2q0-.825-.587-1.412T12 14t-1.412.588T10 16v2q0 .825-.587 1.413T8 20z" />
                                </svg>

                                <!-- Text -->
                                <span x-show="sidebarOpen" x-transition class="whitespace-nowrap">Property Management</span>
                            </div>

                            <!-- Arrow -->
                            <svg x-show="sidebarOpen" :class="{ 'rotate-180': open }"
                                class="h-4 w-4 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Links -->
                        <ul x-show="open" x-collapse class="pl-10 mt-1 space-y-1">
                            {{-- Hidden: Properties --}}
                            {{--
                    <li>
                        <a href="{{ route('admin.properties.index') }}"
                            class="block py-2 pl-4 pr-6 rounded-lg transition
                            {{ request()->routeIs('admin.properties.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'text-white hover:bg-white/10' }}">
                            <span class="whitespace-nowrap">Properties</span>
                        </a>
                    </li>
                    --}}

                    {{-- Hidden: Blocks --}}
                    {{--
                    <li>
                        <a href="{{ route('admin.blocks.index') }}"
                                class="block py-2 pl-4 pr-6 rounded-lg transition
                                {{ request()->routeIs('admin.blocks.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'text-white hover:bg-white/10' }}">
                                <span class="whitespace-nowrap">Blocks</span>
                        </a>
                    </li>
                    --}}

                    <li>
                        <a href="{{ route('admin.lots.index') }}"
                            class="block py-2 pl-4 pr-6 rounded-lg transition 
                {{ request()->routeIs('admin.lots.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'text-white hover:bg-white/10' }}">
                            <span class="whitespace-nowrap">Lots</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.lotTypes.index') }}"
                            class="block py-2 pl-4 pr-6 rounded-lg transition 
                {{ request()->routeIs('admin.lotTypes.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'text-white hover:bg-white/10' }}">
                            <span class="whitespace-nowrap">Lot Type</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.lotCategories.index') }}"
                            class="block py-2 pl-4 pr-6 rounded-lg transition 
                {{ request()->routeIs('admin.lotCategories.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'text-white hover:bg-white/10' }}">
                            <span class="whitespace-nowrap">Lot Category</span>
                        </a>
                    </li>
                </ul>
                </li>


                <!-- 💳 Payments -->
                <li>
                    <a href="{{ route('admin.payments.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg transition
        {{ request()->routeIs('admin.payments.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'hover:bg-white/10' }}"
                        :class="{ 'justify-center': !sidebarOpen, 'justify-start': sidebarOpen }">

                        <!-- 💳 Credit Card Icon -->
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 8.25h19.5M2.25 6A1.5 1.5 0 013.75 4.5h16.5A1.5 1.5 0 0121.75 6v12a1.5 1.5 0 01-1.5 1.5H3.75A1.5 1.5 0 012.25 18V6zM5.25 13.5h3m4.5 0h6" />
                        </svg>

                        <span x-show="sidebarOpen" x-transition class="ml-3">Payments</span>
                    </a>
                </li>

                <!-- Newsletters -->
                <li>
                    <a href="{{ route('admin.newsletters.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg transition
        {{ request()->routeIs('admin.newsletters.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'hover:bg-white/10' }}"
                        :class="{ 'justify-center': !sidebarOpen, 'justify-start': sidebarOpen }">

                        <!-- ✉️ Mail Icon -->
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l9 6 9-6m-18 8h18V6H3v10z" />
                        </svg>

                        <span x-show="sidebarOpen" x-transition class="ml-3">Newsletter</span>
                    </a>
                </li>

                <!-- Contacts -->
                <li>
                    <a href="{{ route('admin.contacts.index') }}"
                        class="flex items-center px-3 py-2 rounded-lg transition
        {{ request()->routeIs('admin.contacts.*') ? 'bg-white text-[#1E4D2B] font-semibold' : 'hover:bg-white/10' }}"
                        :class="{ 'justify-center': !sidebarOpen, 'justify-start': sidebarOpen }">

                        <!-- 📞 Phone/Contact Icon -->
                        <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2 4.5C2 3.12 3.12 2 4.5 2h3A1.5 1.5 0 019 3.5v3A1.5 1.5 0 017.5 8H7a11 11 0 0010 10v-.5A1.5 1.5 0 0118.5 16h3A1.5 1.5 0 0123 17.5v3A1.5 1.5 0 0121.5 22C11.28 22 2 12.72 2 2.5V4.5z" />
                        </svg>

                        <span x-show="sidebarOpen" x-transition class="ml-3">Contacts</span>
                    </a>
                </li>

                </ul>
            </nav>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('admin.logout') }}" class="p-4 border-t border-white/20">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 w-full text-left px-3 py-2 rounded-lg font-semibold text-white/80 hover:bg-[#256738] transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 
                    0 005.25 5.25v13.5A2.25 2.25 0 007.5 
                    21h6a2.25 2.25 0 002.25-2.25V15m3 
                    0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span x-show="sidebarOpen" x-transition>Logout</span>
            </button>
        </form>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold text-[#1E4D2B]">@yield('title')</h1>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>

<style>
    table.dataTable thead th {
        border-bottom: 1px solid #d1d5db;
        border-left: 1px solid #d1d5db;
        border-right: 1px solid #d1d5db;
        font-size: 12px;
        font-weight: bold;
        padding: 4px;
    }

    table.dataTable td {
        border-bottom: 1px solid #d1d5db;
        border-left: 1px solid #d1d5db;
        border-right: 1px solid #d1d5db;
        font-size: 11px;
        padding: 0;
    }

    table.dataTable tfoot th,
    table.dataTable tfoot td {
        border-top: 2px solid #d1d5db;
        border-left: 1px solid #d1d5db;
        border-right: 1px solid #d1d5db;
        font-size: 11px;
        font-weight: bold;
    }
</style>