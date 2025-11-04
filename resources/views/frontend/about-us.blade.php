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
                'fallback_image' => 'img/about-us/page-header.png',
            ],
        ];

        $breadcrumbs = [
            'homepage' => 'Home',
            'about-us' => 'About Us',
        ];

        $pageTitle = 'About Us';
    @endphp

    {{-- <section>
        @include('components.banner', [
            'banner_type' => 'other',
            'heroes' => $heroes,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => $pageTitle,
        ])
    </section> --}}

    <div>
        <x-banner2 page="About Us" breadcrumb="About Us" img="img/about-us-banner.png" />
    </div>

    <section class="relative w-full bg-[#f3f3f3] py-24 overflow-hidden">
        <div class="flex flex-col">
            <div class="flex flex-col">
                <div class="grid items-center grid-cols-2 md:grid-cols-3 mx-[5rem]">
                    <div>
                        <img src="{{ asset('img/about-us/Architex Japan Logo2.png') }}" alt="" class="h-auto w-[60%]">
                    </div>

                    <div class="grid items-center justify-center grid-cols-1 gap-10">
                        <img src="{{ asset('img/about-us/about us - who we are intro 1.png') }}"
                            alt="Sanderiana Two Storey Single Detached" class="object-cover w-[80%] h-auto">
                        <img src="{{ asset('img/about-us/about us - who we are intro 2.jpg') }}"
                            alt="Sanderiana Two Storey Single Detached" class="object-cover w-[80%] h-auto">
                    </div>

                    <div class="col-span-3 space-y-6 md:col-span-1">
                        <div>
                            <p class="text-[#00721B] font-bold tracking-wide text-lg">Who We Are</p>
                            <h2 class="text-3xl md:text-4xl font-semibold text-[#253e16] relative">
                                <span
                                    class="absolute text-[#253e16]/10 -top-5 text-5xl font-extrabold select-none text-outline opacity-20">
                                    Who We Are
                                </span>
                                JOURNEY OF GROWTH
                            </h2>
                        </div>

                        <p class="text-lg leading-relaxed text-justify text-gray-700">
                            The origins of Architex Phil., Inc. can be traced back to Japan, where our founders built a
                            solid
                            reputation for providing affordable housing solutions for all life stages. Over the years,
                            Architex
                            Group has expanded to more than 37 offices across Osaka, Nagoya, and Tokyo, gaining the
                            confidence
                            of
                            local communities with our dedication to quality, innovation, and integrity.
                            <br> <br>
                            With the same commitment, we bring this legacy to the Philippines, starting in Mindanao, fusing
                            Japanese
                            precision with Filipino creativity to build sustainable, people-centered communities and
                            developments
                            that elevate lives and contribute to a better future for communities around the world.

                        </p>

                        <!-- ✅ Bullet Points -->
                        {{-- <ul class="mt-6 space-y-3">
                            <li class="flex items-center gap-3">
                                <img src="{{ asset('img/ico/check-icon.png') }}" alt="check" class="w-6 h-6">
                                <span class="text-lg">Innovative & Sustainable Designs</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <img src="{{ asset('img/ico/check-icon.png') }}" alt="check" class="w-6 h-6">
                                <span class="text-lg">Skilled and Experienced Team</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <img src="{{ asset('img/ico/check-icon.png') }}" alt="check" class="w-6 h-6">
                                <span class="text-lg">Quality Materials & Workmanship</span>
                            </li>
                        </ul> --}}
                    </div>
                </div>
                <div class="py-5 text-xl text-center opacity-50">
                    Architex Office - Okazaki, Japan
                </div>
            </div>
            <div class="container mx-auto">
                <div class="bg-white p-16 border-l-[4px] border-[#253e16] w-auto mx-[5rem]">
                    <div class="grid grid-cols-3 text-[#253e16] divide-x divide-solid divide-[#253e16]">

                        <div class="space-y-3 text-center">
                            <div class="text-5xl font-semibold counter" data-target="120">0+</div>
                            <div class="text-lg">Projects Completed</div>
                        </div>

                        <div class="space-y-3 text-center">
                            <div class="text-5xl font-semibold counter" data-target="15">0+</div>
                            <div class="text-lg">Years of Experience</div>
                        </div>

                        <div class="space-y-3 text-center">
                            <div class="text-5xl font-semibold counter" data-target="37">0+</div>
                            <div class="text-lg">Offices</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="h-full bg-[#f3f3f3]">
        <div class="flex flex-col items-center justify-center gap-10 ">
            <div class="relative flex items-center justify-center w-auto text-[#253e16] container mx-auto">
                <div class="text-[#253e16]/10 -top-5 text-7xl select-none text-outline opacity-20">
                    Highlighting
                </div>

                <div class="absolute inset-0">
                    <div class="flex flex-col items-center justify-center w-full gap-3">
                        <div class="text-lg font-semibold text-[#3d9251]">
                            Highlighting
                        </div>
                        <div class="text-4xl font-medium uppercase">
                            Architex japan
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-[60%] text-center text-lg container mx-auto">
                Architex Japan continues to redefine modern living by combining timeless Japanese craftsmanship
                with innovative architectural solutions. With more than 37 offices across Okazaki, Nagoya, and Tokyo,
                the company leads in designing, building, and managing sustainable communities that embody
                comfort, efficiency, and harmony.
            </div>

            <div class="container grid w-full mx-auto mt-10 md:grid-cols-3">
                <div class="flex flex-row items-center justify-center w-full gap-16 md:flex-col">
                    <img src="{{ asset('img/architex-fun.png') }}" alt="" class="w-auto h-32">
                    <a href="https://architex.jp/portfolio/#p65" class="flex items-center gap-3" target="_blank"
                        rel="noopener noreferrer">
                        <div class="text-xl">
                            Visit Website
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M7 7h10m0 0v10m0-10L7 17" />
                        </svg>
                    </a>
                </div>
                <div class="flex flex-row items-center justify-center w-full gap-16 md:flex-col">
                    <img src="{{ asset('img/architex-home.png') }}" alt="" class="w-auto h-32">
                    <a href="https://architex.jp/portfolio/#p76" class="flex items-center gap-3" target="_blank"
                        rel="noopener noreferrer">
                        <div class="text-xl">
                            Visit Website
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M7 7h10m0 0v10m0-10L7 17" />
                        </svg>
                    </a>
                </div>
                <div class="flex flex-row items-center justify-center w-full gap-16 md:flex-col">
                    <img src="{{ asset('img/architex-dev.png') }}" alt="" class="w-auto h-32">
                    <a href="https://architex.jp/portfolio/#p125" class="flex items-center gap-3" target="_blank"
                        rel="noopener noreferrer">
                        <div class="text-xl">
                            Visit Website
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M7 7h10m0 0v10m0-10L7 17" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-[#f3f3f3] h-full pt-28">
        <div class="relative z-10">
            <div class="grid h-full grid-cols-1 mx-20 md:grid-cols-3">
                <div class="bg-[#d9d9d9] col-span-1 h-[40rem]">

                </div>
                <div class="col-span-2">
                    <div class="max-w-5xl px-6 py-12 mx-auto text-gray-800">
                        <h2 class="mb-8 text-2xl text-[#253E16] md:text-3xl">What We Do in Japan?</h2>

                        <!-- 1. Custom Home Building -->
                        <div class="mb-10">
                            <h3 class="mb-2 text-lg font-semibold md:text-xl">1. Custom Home Building (注文住宅事業)</h3>
                            <ul class="space-y-2 text-gray-700 list-disc list-inside">
                                <li>A team of <strong>architects, coordinators, exterior planners, and advisors</strong>
                                    work hand-in-hand with clients to bring their dream homes to life.</li>
                                <li>Unlike traditional approaches, Architex ensures architects lead the entire process —
                                    from <strong>land search and financial planning to design, structure, interiors, and
                                        garden layouts</strong> — guaranteeing a seamless and personalized home-building
                                    journey.</li>
                                <li>Special focus is given to <strong>simplicity and functionality</strong>, removing waste
                                    and unnecessary cost while delivering timeless design and comfort.</li>
                            </ul>
                        </div>

                        <!-- 2. Renovation & Remodeling -->
                        <div class="mb-10">
                            <h3 class="mb-2 text-lg font-semibold md:text-xl">2. Renovation & Remodeling (リフォーム・リノベーション)
                            </h3>
                            <ul class="space-y-2 text-gray-700 list-disc list-inside">
                                <li>Architex breathes new life into existing homes through <strong>renovations, extensions,
                                        and maintenance</strong>.</li>
                                <li>Our goal is to ensure homes evolve with the needs of families, remaining efficient,
                                    comfortable, and modern.</li>
                            </ul>
                        </div>

                        <!-- 3. Real Estate & Development -->
                        <div class="mb-10">
                            <h3 class="mb-2 text-lg font-semibold md:text-xl">3. Real Estate & Development
                                (不動産・ディベロップメント事業)</h3>
                            <ul class="space-y-2 text-gray-700 list-disc list-inside">
                                <li>Architex develops <strong>“ARCHITEX Town”</strong> residential communities—subdivided
                                    land projects designed with consistent architectural style and reliable infrastructure.
                                </li>
                                <li>We also manage <strong>rental housing, property sales, brokerage, and
                                        consulting</strong>, helping clients maximize the value of their assets.</li>
                            </ul>
                        </div>

                        <!-- 4. Housing Brands & Partnerships -->
                        <div>
                            <h3 class="mb-2 text-lg font-semibold md:text-xl">4. Housing Brands & Partnerships</h3>
                            <p class="mb-2">Architex Japan offers multiple house brands to suit different lifestyles and
                                budgets, including:</p>
                            <ul class="space-y-2 text-gray-700 list-disc list-inside">
                                <li><strong>ARCASA Order Homes</strong> – Flexible, client-centered designs with high
                                    performance.</li>
                                <li><strong>SIMPLE</strong> – Minimalist, cost-efficient homes focusing on practical beauty.
                                </li>
                                <li><strong>Kanal Home</strong> – Transparent “all-in pricing” homes with a balance of
                                    design and affordability.</li>
                                <li><strong>niko and … EDIT HOUSE</strong> – A collaboration with lifestyle brand <em>niko
                                        and …</em>, blending fashion and living for unique home experiences.</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <img src="{{ asset('img/about-us/Architex Japan Logo.png') }}" alt=""
                class="absolute -bottom-[4rem] -left-[12rem] -z-10 w-auto h-[55rem]">
        </div>
    </div>

    <div class="bg-[#f3f3f3] h-full pb-20 pt-5">
        <div class="flex flex-col-reverse mx-20 md:grid md:grid-cols-3">
            <div class="relative z-10 col-span-2">
                <div class="max-w-5xl px-6 py-12 mx-auto text-gray-800">
                    <h2 class="text-2xl md:text-4xl font-medium text-[#253E16] mb-6">
                        How We Connect with the Community
                    </h2>

                    <p class="mb-6 text-lg">
                        For Architex, building a house is
                        <strong>not the end—it’s the beginning.</strong>
                    </p>

                    <ul class="space-y-3 text-lg leading-relaxed text-gray-700 list-disc list-inside">
                        <li>
                            Through the <strong>Architex Community</strong>, we remain by our clients’ side
                            even after handing over their homes.
                        </li>
                        <li>
                            We support families through different life events, offering solutions to their
                            “it would be nice if…” and “I wish we could…” needs.
                        </li>
                        <li>
                            With the <strong>Architex Fun App</strong>, we engage homeowners with maintenance
                            reminders, lifestyle tips, exclusive events, and loyalty benefits — ensuring
                            peace of mind, comfort, and happiness for years to come.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="bg-[#d9d9d9] h-[30rem]">

            </div>
        </div>
    </div>

    <div class="bg-[#f9f9f9] h-full pt-28 pb-44">
        <div class="relative h-full">
            <div class="container flex flex-col items-center justify-center mx-auto">
                <div class="md:w-[60%]">
                    <div class="relative flex items-center justify-center w-auto text-[#253e16] container mx-auto mb-3">
                        <div class="text-[#253e16]/10 -top-5 text-7xl select-none text-outline opacity-20">
                            Our Philosophy
                        </div>

                        <div class="absolute inset-0">
                            <div class="flex flex-col items-center justify-center w-full gap-3">
                                <div class="text-lg font-semibold text-[#3d9251]">
                                    Our Philosophy
                                </div>
                                <div class="text-4xl font-medium uppercase">
                                    Driven by innovation
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="max-w-5xl px-6 py-12 mx-auto text-lg leading-relaxed text-justify text-gray-800">
                            <!-- Intro paragraph -->
                            <p class="mb-8">
                                At Architex, we believe in more than just building houses — we build
                                <strong>living spaces that inspire security, comfort, and joy.</strong>
                                By combining Japanese precision, design innovation, and community-centered service,
                                we continuously create value for homeowners and partners alike.
                            </p>

                            <!-- Section heading -->
                            <h2 class="text-2xl md:text-3xl font-medium text-[#253E16] mb-6">
                                How We Connect with the Community
                            </h2>

                            <!-- Paragraphs -->
                            <p class="mb-5">
                                At Architex, we believe building a home is only the beginning of our relationship with our
                                clients.
                            </p>

                            <p class="mb-5">
                                Through the <strong>Architex Community</strong>, we continue to support families even after
                                their
                                home
                                is handed over. Whether it’s a new life event or a change in lifestyle, we provide solutions
                                that
                                make
                                everyday living easier and more enjoyable.
                            </p>

                            <p class="mb-8">
                                We created an app called <strong>Architex Fun App</strong>, where homeowners can access
                                helpful
                                tools
                                and services, such as maintenance reminders, lifestyle tips, exclusive events, and special
                                rewards.
                                This ongoing support ensures every Architex home remains a place of comfort, security, and
                                lasting
                                happiness.
                            </p>

                            <!-- Learn More button -->
                            <a href="https://play.google.com/store/apps/details?id=com.iecon.app.android.atx&hl=en"
                                class="inline-block bg-[#253E16] text-white px-6 py-3 rounded-sm hover:bg-[#1e3412] transition-colors">
                                Learn More
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="absolute top-0 hidden md:flex left-20">
                <img src="{{ asset('img/our-philo-img1.png') }}" alt="">
            </div>
            <div class="hidden md:flex absolute -bottom-[8rem] right-20">
                <img src="{{ asset('img/our-philo-img2.png') }}" alt="">
            </div>
        </div>
    </div>

    <!--History Section-->
    {{-- <section class="relative w-full py-20 overflow-hidden bg-white md:py-32">

        <!-- Main Content Wrapper -->
        <div class="relative z-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="relative mb-16 text-center">
                <p class="text-[#00721B] text-xl tracking-widest font-bold">Our History</p>
                <h2 class="text-4xl md:text-4xl font-bold text-[#253e16] mt-4">
                    FROM HUMBLE BEGINNINGS
                    <!-- Subtle background text effect -->
                    <span
                        class="absolute inset-0 flex items-center justify-center text-6xl md:text-6xl font-semibold text-[#253e16] opacity-20 text-outline">
                        Our History
                    </span>
                </h2>
            </div>

            <!-- Timeline Items -->

            <!-- Year 2000 - Left Image, Right Text -->
            <div class="grid items-start grid-cols-1 gap-12 mb-20 md:grid-cols-2 md:gap-x-24">
                <!-- Single Image - Left Column -->
                <div class="flex justify-center order-2 md:order-1">
                    <img src="img/about-us/2000.png" alt="Team members shaking hands" class="w-full h-full">
                </div>

                <!-- Text Content - Right Column -->
                <div class="order-1 space-y-4 md:order-2">
                    <!-- Corrected: Year as a regular text element, not absolute -->
                    <h3 class="text-6xl font-extrabold text-[#bfdbc6] mb-4 leading-none">2000</h3>
                    <p class="text-lg leading-relaxed text-gray-700">
                        When a group of passionate professionals came together with a shared dream for building homes,
                        communities, lives, and goals. We weren't just looking to build properties – we wanted to be able to
                        trust, long-term relationships, and spaces that enhance quality of life. These early years were
                        about establishing our values: integrity, innovation, and a deep commitment to our clients.
                    </p>
                </div>
            </div>

            <!-- Year 2003 - Right Image, Left Text -->
            <div class="grid items-start grid-cols-1 gap-12 mb-20 md:grid-cols-2 md:gap-x-24">
                <!-- Text Content - Left Column -->
                <div class="order-1 space-y-4">
                    <!-- Corrected: Year as a regular text element, not absolute -->
                    <h3 class="text-6xl font-extrabold text-[#bfdbc6] mb-4 leading-none">2003</h3>
                    <p class="text-lg leading-relaxed text-gray-700">
                        We had started to establish a reputation in the industry. With our growing team and stronger
                        partnerships, we invested in refining our business model and expanding our services. This was a time
                        when our company went solidified, but we became known not only as developers, but as visionaries who
                        placed people at the heart of every project. Our culture of collaboration and customer focus became
                        our strongest foundation.
                    </p>
                </div>

                <!-- Single Image - Right Column -->
                <div class="flex justify-center order-2 md:order-1">
                    <img src="img/about-us/2003.png" alt="Team members shaking hands" class="w-full h-full ">
                </div>
            </div>

            <!-- Year 2008 - Left Image, Right Text -->
            <div class="grid items-start grid-cols-1 gap-12 md:grid-cols-2 md:gap-x-24">
                <!-- Single Image - Left Column -->
                <div class="flex justify-center order-2 md:order-1">
                    <img src="img/about-us/2008.png" alt="Team members shaking hands" class="w-full h-full ">
                </div>
                <!-- Text Content - Right Column -->
                <div class="order-1 space-y-4 md:order-2">
                    <!-- Corrected: Year as a regular text element, not absolute -->
                    <h3 class="text-6xl font-extrabold text-[#bfdbc6] mb-4 leading-none">2008</h3>
                    <p class="text-lg leading-relaxed text-gray-700">
                        Our organization expanded its workforce, bringing in experts from different fields who enriched our
                        capabilities. Internally, we developed stronger systems and a culture that embraced both discipline
                        and creativity. Externally, we gained recognition as a company that delivers quality, reliability,
                        and forward-thinking solutions. This was the year when our brand name started to stand out in the
                        competitive landscape.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Miletone Section -->
    <section class="relative w-full bg-[#f7f7f7] py-20 md:py-32 overflow-hidden">

        <!-- Header Section -->
        <div class="relative z-10 px-4 mx-auto mb-16 max-w-7xl sm:px-6 lg:px-8">
            <span class="absolute text-[#00721b] text-6xl font-extrabold select-none opacity-20 text-outline">
                Project Milestone
            </span>
            <p class="text-[#00721b] text-lg uppercase tracking-widest font-bold">Project Milestone</p>
            <h2 class="mt-2 text-4xl font-bold text-gray-800 uppercase md:text-5xl">
                A JOURNEY OF GROWTH
            </h2>
        </div>

        <!-- Timeline Wrapper -->
        <div class="relative z-10 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Positioned to be roughly between the two content columns on desktop -->
            <div class="absolute left-[calc(22%-0px)] top-0 bottom-0 w-[2px] bg-[#cfcfcf] z-0 hidden md:block"></div>
            <!-- For mobile, line is still on the far left -->
            <div class="absolute left-6 top-0 bottom-0 w-[2px] bg-green-200 z-0 md:hidden"></div>

            <!-- Timeline Items -->

            <!-- Milestone 2010 -->
            <div class="relative flex flex-col items-start py-8 md:flex-row">
                <!-- Year and Subtitle (Left Column) -->
                <div class="relative flex-shrink-0 w-full pr-8 text-left md:w-1/4">
                    <h3 class="text-6xl md:text-7xl font-bold text-[#cecece] leading-none">2010</h3>
                    <p class="text-lg ml-4 text-[#303030] font-semibold mt-2">The Beginning</p>
                    <!-- Dot on Timeline (Desktop) -->
                    <div
                        class="absolute right-[2.5rem] top-1/2 transform -translate-y-1/2 w-7 h-7 bg-[#00721b] rounded-full border-4 border-white z-20 hidden md:block">
                    </div>
                    <!-- Dot on Timeline (Mobile) -->
                    <div
                        class="absolute left-[-14px] top-1/2 transform -translate-y-1/2 w-7 h-7 bg-[#00721b] rounded-full border-4 border-white z-20 md:hidden">
                    </div>
                </div>

                <!-- Content (Image & Text) (Right Column) -->
                <div class="relative w-full pt-6 md:pt-0">
                    <div class="flex flex-col gap-6 md:flex-row ">
                        <img src="img/about-us/2010.png" alt="Project 2010" class="w-full h-full">
                        <div class="md:w-full">
                            <p class="leading-relaxed text-gray-700 text-md">
                                In 2010, our journey began with a simple but powerful idea: to create living and working
                                spaces that go beyond four walls. At this stage, our focus was on studying the needs of
                                communities and understanding how modern design could improve quality of life. It was a year
                                of laying the groundwork — forming the team, building partnerships, and drafting the
                                blueprint for what would later become our signature projects.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Milestone 2014 -->
            <div class="relative flex flex-col items-start py-8 md:flex-row">
                <!-- Year and Subtitle (Left Column) -->
                <div class="relative flex-shrink-0 w-full pr-8 text-left md:w-1/4">
                    <h3 class="text-6xl md:text-7xl font-bold text-[#cecece] leading-none">2014</h3>
                    <p class="text-lg ml-2 text-[#303030] font-semibold mt-2">First Breakthrough</p>
                    <!-- Dot on Timeline (Desktop) -->
                    <div
                        class="absolute right-[2.5rem] top-1/2 transform -translate-y-1/2 w-7 h-7 bg-[#00721b] rounded-full border-4 border-white z-20 hidden md:block">
                    </div>
                    <!-- Dot on Timeline (Mobile) -->
                    <div
                        class="absolute left-[-14px] top-1/2 transform -translate-y-1/2 w-7 h-7 bg-[#00721b] rounded-full border-4 border-white z-20 md:hidden">
                    </div>
                </div>

                <!-- Content (Image & Text) (Right Column) -->
                <div class="relative w-full pt-6 md:pt-0">
                    <div class="flex flex-col gap-6 md:flex-row">
                        <img src="img/about-us/2014.png" alt="Interior 2014" class="w-full h-full">
                        <div class="md:w-full">
                            <p class="leading-relaxed text-gray-700 text-md">
                                By 2014, after years of preparation and planning, we launched our very first approved
                                project. This milestone marked a turning point, transforming our vision into something
                                tangible. The project was modest in scale but ambitious in design, blending functionality
                                with comfort. It introduced us to the challenges of construction and community-building,
                                while also proving that our approach to modern, thoughtful spaces had a real impact on
                                people's lives.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Milestone 2017 -->
            <div class="relative flex flex-col items-start py-8 md:flex-row">
                <!-- Year and Subtitle (Left Column) -->
                <div class="relative flex-shrink-0 w-full pr-8 text-left md:w-1/4">
                    <h3 class="text-6xl md:text-7xl font-bold text-[#cecece] leading-none">2017</h3>
                    <p class="text-lg  text-[#303030] font-semibold mt-2">Expanding Horizons</p>
                    <!-- Dot on Timeline (Desktop) -->
                    <div
                        class="absolute right-[2.5rem] top-1/2 transform -translate-y-1/2 w-7 h-7 bg-[#00721b] rounded-full border-4 border-white z-20 hidden md:block">
                    </div>
                    <!-- Dot on Timeline (Mobile) -->
                    <div
                        class="absolute left-[-14px] top-1/2 transform -translate-y-1/2 w-7 h-7 bg-[#00721b] rounded-full border-4 border-white z-20 md:hidden">
                    </div>
                </div>

                <!-- Content (Image & Text) (Right Column) -->
                <div class="relative w-full pt-6 md:pt-0">
                    <div class="flex flex-col gap-6 md:flex-row">
                        <img src="img/about-us/2017.png" alt="Landscape 2017" class="w-full h-full">
                        <div class="md:w-full">
                            <p class="leading-relaxed text-gray-700 text-md">
                                With experience and confidence, 2017 was the year of expansion. We moved beyond initial
                                projects and started developing larger residential communities and commercial spaces. This
                                was also the year we introduced innovative concepts like open green areas, integrated
                                amenities, and smart design solutions that made our developments stand out. Our brand was no
                                longer just emerging — it was starting to gain recognition for quality and innovation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Milestone 2025 -->
            <div class="relative flex flex-col items-start py-8 md:flex-row">
                <!-- Year and Subtitle (Left Column) -->
                <div class="relative flex-shrink-0 w-full pr-8 text-left md:w-1/4">
                    <h3 class="text-6xl md:text-7xl font-bold text-[#cecece] leading-none">2025</h3>
                    <p class="text-lg text-[#303030] font-semibold mt-2">Shaping the Future</p>
                    <!-- Dot on Timeline (Desktop) -->
                    <div
                        class="absolute right-[2.5rem] top-1/2 transform -translate-y-1/2 w-7 h-7 bg-[#00721b] rounded-full border-4 border-white z-20 hidden md:block">
                    </div>
                    <!-- Dot on Timeline (Mobile) -->
                    <div
                        class="absolute left-[-14px] top-1/2 transform -translate-y-1/2 w-7 h-7 bg-[#00721b] rounded-full border-4 border-white z-20 md:hidden">
                    </div>
                </div>

                <!-- Content (Image & Text) (Right Column) -->
                <div class="relative w-full pt-6 md:pt-0">
                    <div class="flex flex-col gap-6 md:flex-row">
                        <img src="img/about-us/2025.png" alt="Modern Homes 2025" class="w-full h-full ">
                        <div class="md:w-full">
                            <p class="leading-relaxed text-gray-700 text-md">
                                Today, we continue to grow with a clear focus on the future. Our current projects are built
                                around the concept of "Smart Spaces" — blending technology, sustainability, and
                                human-centered design. We are expanding nationwide, creating communities that are not only
                                modern and connected, but also environmentally responsible. The present is not just about
                                building structures — it's about building lifestyles, where innovation meets everyday
                                living.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Mission & Vision Section -->
    <section class="relative bg-[#1E3B15] text-white overflow-hidden">
        <!-- BACKGROUND LAYER -->
        <div class="absolute inset-0 bg-[#1E3B15]">
            <!-- Vision background (right side diagonal) -->
            <div
                class="absolute right-0 top-0 w-1/2 h-full bg-[url('/img/about-us/vision-bg.jpg')] bg-cover bg-center clip-path-diagonal opacity-90">
            </div>
            <img src="{{ asset('img/about-us/bg-mission.png') }}" alt=""
                class="bg-left bg-no-repeat bg-contain mix-blend-multiply ">
        </div>

        <!-- Foreground mission image (right side, visible on top) -->
        <div class="absolute inset-0 flex items-center justify-end border">
            <img src="{{ asset('img/about-us/mission.png') }}" alt="" class="w-auto h-full">
        </div>

        <!-- Content -->
        <div class="relative z-0 px-6 mx-auto py-28 max-w-screen-2xl">
            <!-- Heading -->
            <div class="container relative mx-auto mb-20 ml-[5rem]">
                <!-- Background Outline Text -->
                <h1
                    class="absolute inset-0 z-10 flex items-start justify-start text-6xl font-bold pointer-events-none select-none md:text-6xl stroke-text ">
                    Mission & Vision
                </h1>

                <!-- Foreground Text -->
                <p class="relative z-10 text-lg font-semibold">Mission & Vision</p>
                <h2 class="text-4xl md:text-5xl text-[#45b700] relative z-10">
                    Commitment to Excellence
                </h2>
            </div>


            <!-- Mission and Vision Cards -->
            <div class="relative z-20 grid w-full grid-cols-2 gap-8 md:flex">
                <!-- Mission -->
                <div class="bg-white text-gray-900  relative border-b-[6px] border-[#ffe350] pt-10 pb-5 px-10 md:w-[30%]">
                    <div class="absolute -top-8 left-8 bg-[#00721b] p-5 ">
                        <img src="{{ asset('img/ico/mission-icon.png') }}" alt="Check Icon"
                            class="object-contain w-5 h-5">
                    </div>
                    <h3 class="text-3xl font-bold mb-4 text-[#2A441A] uppercase">Our Mission</h3>
                    <div class="leading-relaxed text-gray-700 text-md">
                        To deliver innovative and sustainable architectural solutions that combine function, beauty, and
                        quality, shaping spaces that add value to people and communities.
                    </div>
                </div>

                <!-- Vision -->
                <div class="bg-white text-gray-900 relative border-b-[6px] border-[#ffe350] pt-10 pb-5 px-10 md:w-[30%]">
                    <div class="absolute -top-8 left-8 bg-[#00721b] p-5">
                        <img src="{{ asset('img/ico/vision-icon.png') }}" alt="Check Icon"
                            class="object-contain w-5 h-5">
                    </div>
                    <h3 class="text-3xl font-bold mb-4 text-[#2A441A] uppercase">Our Vision</h3>
                    <p class="leading-relaxed text-gray-700 text-md">
                        To be recognized as a leading architectural and construction partner in the Philippines, known for
                        transforming ideas into lasting landmarks that stand the test of time.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="relative bg-[#f3f3f3] h-full pb-[20rem] pt-[10rem] md:pb-0 md:pt-0">
        <div class="flex items-center justify-center w-full">
            <div>
                <img src="{{ asset('img/about-us/Architex Japan Logo.png') }}" alt=""
                    class="object-cover object-left w-full h-screen ">
            </div>
        </div>

        <div class="absolute inset-0 top-[4rem] z-10">
            <div class="text-center">
                <!-- ✅ Section Title -->
                <div class="relative mb-16">
                    <div class="flex flex-col gap-3">
                        <p class="text-[#00721B] font-semibold uppercase tracking-wide">Our Core Values</p>
                        <h2 class="text-4xl md:text-5xl text-[#253e16] relative inline-block mt-2">
                            CREATING RESPONSIBLY
                        </h2>
                    </div>
                    <div
                        class="absolute inset-x-0 z-0 text-6xl leading-none tracking-tight text-gray-400 select-none -top-1 md:text-7xl opacity-20 text-outline">
                        Our Core Values
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute inset-0">
            <div class="flex items-center justify-center w-full h-full text-center ">
                <div class="container grid grid-cols-2 mx-auto md:grid-cols-3 gap-y-20">
                    <div class="flex flex-col items-center justify-center gap-5">
                        <div>
                            <img src="{{ asset('img/ico/expertise.png') }}" alt="">
                        </div>
                        <div class="text-2xl font-semibold uppercase">
                            Quality
                        </div>
                        <div class="w-[80%]">
                            Commited to excellence in design, materials, and craftsmanship to ensure lasting value.
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-5">
                        <div>
                            <img src="{{ asset('img/ico/leadership.png') }}" alt="">
                        </div>
                        <div class="text-2xl font-semibold uppercase">
                            Integrity
                        </div>
                        <div class="w-[80%]">
                            Building trust through transparency, profesisonalism, and ethical standards in every aspect of
                            our work.
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-5">
                        <div>
                            <img src="{{ asset('img/ico/sustainability.png') }}" alt="">
                        </div>
                        <div class="text-2xl font-semibold uppercase">
                            Sustainability
                        </div>
                        <div class="w-[80%]">
                            Designing responsibility while balancing function, beauty, and the environments.
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-5">
                        <div>
                            <img src="{{ asset('img/ico/integrity.png') }}" alt="">
                        </div>
                        <div class="text-2xl font-semibold uppercase">
                            Innovation
                        </div>
                        <div class="w-[80%]">
                            Embracing new ideas, modern moethods, and sustainable practices to create designs that inspire.
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-5">
                        <div>
                            <img src="{{ asset('img/ico/collab.png') }}" alt="">
                        </div>
                        <div class="text-2xl font-semibold uppercase">
                            Collaboration
                        </div>
                        <div class="w-[80%]">
                            Working closely with clients, partners, and communities to bring visions to life.
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-5">
                        <div>
                            <img src="{{ asset('img/ico/precision.png') }}" alt="">
                        </div>
                        <div class="text-2xl font-semibold uppercase">
                            Precision
                        </div>
                        <div class="w-[80%]">
                            With focus to details, we uphold the highest standards in accuracy and execution.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        li {
            margin-left: 20px;
        }
    </style>

    <script>
        const counters = document.querySelectorAll('.counter');
        const speed = 100; // smaller = faster

        counters.forEach(counter => {
            const animate = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText.replace('+', '');

                const increment = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + increment) + '+';
                    setTimeout(animate, 80);
                } else {
                    counter.innerText = target + '+';
                }
            };

            // Optional: start counting only when visible
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animate();
                        observer.unobserve(counter);
                    }
                });
            }, {
                threshold: 0.5
            });

            observer.observe(counter);
        });
    </script>
@endsection
