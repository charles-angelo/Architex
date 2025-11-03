<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'ARCHITEX PHIL., INC.')</title>

    <!-- SEO -->
    <meta name="title" content="ARCHITEX PHIL., INC.">
    <meta name="description"
        content="Architex Phil., Inc. is an architectural design and construction firm dedicated to delivering innovative, sustainable, and high-quality building solutions. From residential and commercial projects to interior design and project management, we create spaces that inspire modern living and reflect excellence in every detail.">
    <meta name="keywords"
        content="architex, architectural design firm, construction company Philippines, modern architecture, sustainable building design, interior design solutions, residential architecture, commercial building projects, project management services, architectural planning, building construction services, modern house design, mixed-use development, subdivision development, architectural innovation, property development Philippines, interior architecture, design and build company, professional architects, architectural consultancy">
    <meta name="author" content="Architex Phil., Inc.">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="copyright" content="Architex Phil., Inc.">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="ARCHITEX PHIL., INC.">
    <meta property="og:description"
        content="Architex Phil., Inc. is an architectural design and construction firm dedicated to delivering innovative, sustainable, and high-quality building solutions.">
    <meta property="og:image" content="{{ asset('Thumbnail.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Architex Phil., Inc.">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ARCHITEX PHIL., INC.">
    <meta name="twitter:description"
        content="Architex Phil., Inc. is an architectural design and construction firm dedicated to delivering innovative, sustainable, and high-quality building solutions.">
    <meta name="twitter:image" content="{{ asset('Thumbnail.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/lucide@latest" defer></script>

    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-DT06pTv3.css') }}"> --}}
    @vite('resources/css/app.css')
</head>

<body>
    @include('css.design')
    <main>
        @yield('content')
    </main>

    @include('partials.footer')
    @yield('data')

    @stack('scripts')
</body>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('reserveModal', {
            open: false,
            step: 1
        });
    });
</script>

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
            },
        };
    }
</script>

</html>