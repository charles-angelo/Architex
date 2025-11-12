<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Login | Architex</title>
    <script src={{ asset('cdn/TAILWINDCSS.js') }}></script>
</head>

<body class="h-screen w-screen bg-[#e8e8e8] flex items-center justify-center">

    <div class="grid w-full h-full grid-cols-1 md:grid-cols-2">

        <!-- Left Side -->
        <div class="hidden md:flex bg-[#1E4D2B] items-center justify-center relative overflow-hidden">
            <!-- Soft glow -->
            <div class="absolute w-[500px] h-[500px] bg-[#256738]/30 rounded-full blur-3xl"></div>

            <!-- Logo + Text -->
            <div
                class="relative z-10 flex flex-col items-center text-center transition-transform duration-500 transform hover:scale-105">
                <img src="{{ asset('img/homepage/logo.png') }}" alt="Architex System Inc. Logo"
                    class="h-28 mb-6 drop-shadow-[0_10px_20px_rgba(0,0,0,0.5)]">

                <div>
                    <h1 class="text-4xl font-extrabold tracking-wide text-white drop-shadow-lg">ARCHITEX</h1>
                    <p class="text-sm text-white/80 tracking-[0.3em] drop-shadow">SYSTEM INC.</p>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="flex items-center justify-center px-6 bg-[#f9fafb]">
            <div
                class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 transform transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(0,0,0,0.2)]">

                <!-- Heading -->
                <h2 class="text-3xl font-bold text-[#1E4D2B] mb-6 flex items-center gap-2">
                    <span class="border-l-4 border-[#1E4D2B] pl-2"></span>
                    <span>Administrator <span class="font-normal text-gray-700">Login</span></span>
                </h2>

                <!-- Success Message -->
                @if (session('success'))
                    <div
                        class="p-2 mb-4 text-sm font-medium text-center text-green-700 bg-green-100 rounded shadow-inner">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="p-2 mb-4 text-sm font-medium text-center text-red-700 bg-red-100 rounded shadow-inner">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block mb-1 font-medium text-gray-600">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-[#1E4D2B] focus:ring-2 focus:ring-[#1E4D2B]/40 shadow-sm"
                            placeholder="Enter your email" required autofocus>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block mb-1 font-medium text-gray-600">Password</label>
                        <input type="password" name="password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:border-[#1E4D2B] focus:ring-2 focus:ring-[#1E4D2B]/40 shadow-sm"
                            placeholder="Enter your password" required>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-[#1E4D2B] text-white py-3 rounded-lg font-semibold shadow-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_20px_rgba(30,77,43,0.4)] hover:bg-[#256738]">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
