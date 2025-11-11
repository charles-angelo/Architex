<!-- Footer -->
<footer class="bg-[#e8e8e8] border-t border-gray-200 relative">

    <!-- Background Image Left -->
    <div class="absolute top-0 left-0 z-0 pointer-events-none mix-blend-multiply">
        <img src="{{ asset('img/footer/first.png') }}" alt="" class="object-contain w-full h-full">
    </div>

    <!-- Background Image Right -->
    <div class="absolute top-0 right-0 z-0 pointer-events-none mix-blend-multiply">
        <img src="{{ asset('img/footer/second.png') }}" alt="" class="object-contain w-full h-full">
    </div>

    <!-- Newsletter -->
    <div class="flex items-center justify-center w-full">
        <div class="lg:absolute -top-[8rem] max-w-screen-xl mx-auto -mt-52">
            <div
                class="bg-[#253e16] text-white shadow-lg flex flex-col-reverse md:grid md:grid-cols-2 gap-0 items-stretch overflow-hidden">
                <!-- Text -->
                <div class="flex flex-col justify-center p-10">
                    <h2 class="mb-6 text-4xl font-semibold">Subscribe to Newsletter!</h2>
                    <p class="mb-6 text-gray-200">
                        From project highlights and innovative solutions to company news and industry trends,
                        our newsletter keeps you updated on everything that shapes the future of modern spaces.
                    </p>

                    <!-- Newsletter Form (AJAX version) -->
                    <form id="newsletterForm" class="flex w-full gap-1 lg:w-full">
                        @csrf
                        <input type="email" id="newsletterEmail" name="email" placeholder="Enter your email address"
                            required
                            class="w-full py-4 px-3 text-black border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400 placeholder:text-[#253e16]">

                        <button type="submit"
                            class="text-nowrap px-6 py-3 bg-[#ffd601] hover:bg-yellow-500 text-[#253e16] rounded-md transition">
                            Subscribe Now
                        </button>
                    </form>
                </div>

                <!-- Full Image -->
                <div class="flex items-end justify-end max-h-[25rem]">
                    <img src="{{ asset('img/footer/newsletter.png') }}" alt="Newsletter"
                        class="object-cover object-right w-full h-auto md:w-100">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Content -->
    <div class="flex items-center justify-center w-full">
        <div class="max-w-screen-xl px-3 py-16 mx-auto mt-10 text-black">

            <!-- Logo + Socials -->
            <div class="flex flex-col items-center justify-between md:flex-row md:items-start">
                <img src="{{ asset('img/footer/logo.png') }}" alt="Logo" class="h-10 mb-6 md:mb-0">
                <div class="flex space-x-4">
                    <a href="#" class="transition hover:opacity-80">
                        <img src="{{ asset('img/footer/fb.png') }}" alt="Facebook" class="w-10 h-10">
                    </a>
                    {{-- <a href="#" class="transition hover:opacity-80">
                        <img src="{{ asset('img/footer/insta.png') }}" alt="Instagram" class="w-10 h-10">
                    </a>
                    <a href="#" class="transition hover:opacity-80">
                        <img src="{{ asset('img/footer/tiktok.png') }}" alt="TikTok" class="w-10 h-10">
                    </a> --}}
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t-2 border-[#00721b] my-8"></div>

            <!-- Quick Links / Properties / Contact -->
            <div class="grid grid-cols-1 gap-10 md:grid-cols-3">

                <!-- Quick Links -->
                <div>
                    <h3 class="mb-4 text-2xl font-bold text-black">QUICK LINKS</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('homepage') }}"
                                class="flex items-center gap-2 text-lg hover:text-green-700">›
                                Home</a></li>
                        <li><a href="{{ route('about-us') }}"
                                class="flex items-center gap-2 text-lg hover:text-green-700">›
                                About Us</a></li>
                        <li><a href="{{ route('properties.show') }}"
                                class="flex items-center gap-2 text-lg hover:text-green-700">› Properties</a></li>
                        <li><a href="{{ route('services') }}"
                                class="flex items-center gap-2 text-lg hover:text-green-700">› Services</a></li>
                        <li><a href="{{ route('blogs.show') }}"
                                class="flex items-center gap-2 text-lg hover:text-green-700">› Blogs</a></li>
                        <li><a href="{{ route('contactUs') }}"
                                class="flex items-center gap-2 text-lg hover:text-green-700">› Contact Us</a></li>
                    </ul>
                </div>

                <!-- Properties -->
                <div>
                    <h3 class="mb-4 text-2xl font-bold text-black">PROPERTIES</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('properties.show') }}"
                                class="flex items-center gap-2 text-lg hover:text-green-700">› Apo Yama
                                Residences</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="mb-4 text-2xl font-bold text-black">CONTACT US</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <img src="{{ asset('img/footer/location.png') }}" alt="Location" class="w-6 h-6 mt-1">
                            <span class="text-lg ">
                                Door 7, Josie 1944 Commercial Bldg., E. Palma Gil St., Obrero, Brgy. 13-B, Davao City,
                                Philippines
                            </span>
                        </li>
                        <li class="flex items-center gap-2">
                            <img src="{{ asset('img/footer/phone.png') }}" alt="Phone" class="w-6 h-6">
                            <span class="text-lg">0927 725 7326</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <img src="{{ asset('img/footer/email.png') }}" alt="Email" class="w-6 h-6">
                            <span class="text-lg text-wrap">info@architexphil.com</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bg-[#253e16] text-gray-200 py-4 font-semibold">
        <div class="flex flex-col items-center justify-between px-6 mx-auto text-sm max-w-7xl md:flex-row">
            <div class="flex mt-2 space-x-4 md:mt-0">
                <a href="{{ route('terms') }}" class="hover:underline">Terms & Conditions</a>
                <a href="{{ route('privacy') }}" class="hover:underline">Privacy Policy</a>
            </div>
            <a href="https://rwebsolutions.com.ph/" class="mt-2 text-center md:mt-0">
                © Architex Phil, Inc. 2025. Designed and Developed by
                <span class="text-[#ff6200] font-semibold">R Web Solutions Corp.</span>
            </a>
        </div>
    </div>
</footer>

<!-- ✅ SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- ✅ AJAX Script -->
<script>
    document.getElementById('newsletterForm').addEventListener('submit', function(e) {
                e.preventDefault();
                document.getElementById('newsletterForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const email = document.getElementById('newsletterEmail').value;
                    const csrfToken = document.querySelector('input[name="_token"]').value;

                    fetch("{{ route('newsletter.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                email: email
                            })
                        })
                        .then(response => {
                            if (response.ok) return response.json();
                            return response.text().then(text => {
                                throw new Error(text)
                            });
                        })
                        .then(data => {
                            Swal.fire({
                                title: 'Subscribed!',
                                text: 'Your email has been successfully added to our newsletter!',
                                icon: 'success',
                                confirmButtonColor: '#253e16',
                                confirmButtonText: 'OK'
                            });
                            document.getElementById('newsletterForm').reset();
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Please enter a valid email address or try again later.',
                                icon: 'error',
                                confirmButtonColor: '#253e16',
                                confirmButtonText: 'Try Again'
                            });
                        });
                });
</script>
