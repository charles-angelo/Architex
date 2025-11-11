@props([
    'banner_type' => 'home', // default to 'home'
    'heroes' => '',
    'breadcrumbs' => [],
    'pageTitle' => 'Home', // default to 'Home'
])

<main class="relative">
    {{-- Banner Background --}}
    @include('components.layout.page-banner-layout')

    {{-- Overlay Hero Content --}}
    <section class="absolute inset-0 mb-16 lg:ml-[10rem] flex items-center justify-center">
        @include('components.cards.banner-card', ['heroes' => $heroes])
    </section>

    {{-- @if ($banner_type != 'home')
        <section
            class="absolute top-0 z-10 flex items-center justify-center text-6xl -translate-x-1/2 -bottom-12 left-1/2">
            {{ $pageTitle }}
        </section>
        <section class="absolute z-50 flex items-center justify-center -translate-x-1/2 -bottom-14 left-1/2">
            @include('components.breadcrumbs')
        </section>
    @endif --}}
</main>
