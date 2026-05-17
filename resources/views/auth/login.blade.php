{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - Indomarket</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts - Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body class="min-h-screen relative overflow-x-hidden bg-white-50">
    {{-- Background Decorative Elements --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        {{-- Top Right Circle --}}
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-emerald-100 rounded-full opacity-50 blur-3xl"></div>

        {{-- Bottom Left Circle --}}
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-amber-100 rounded-full opacity-50 blur-3xl"></div>

        {{-- Center decorative --}}
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-br from-emerald-50 to-amber-50 rounded-full opacity-30 blur-3xl">
        </div>
    </div>

    {{-- Scrollable Container --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center py-8 px-4">
        <div class="max-w-md w-full animate-fadeInUp">
            {{-- Logo & Brand --}}
            <div class="text-center mb-6 lg:mb-8">
                <!-- Icon di atas -->
                {{-- <div
                    class="inline-flex items-center justify-center w-16 h-16 lg:w-20 lg:h-20">
                    <img src="{{ asset('image/icon2.jpeg') }}" alt="Icon"
                        class="w-32 h-34 lg:w-10 lg:h-10 object-contain">
                </div> --}}

                <!-- Tulisan Indomarket di bawah -->
                <h1 class="text-2xl lg:text-3xl font-extrabold text-gray-800">
                    <img src="{{ asset('image/indomarket2.jpeg') }}" alt="Indomarket" class="h-22 lg:h-28 inline-block">
                </h1>

                <p class="text-gray-500 text-sm lg:text-base mt-2">Masuk untuk melanjutkan belanja</p>
            </div>
            {{-- Login Card --}}
            <div class="bg-white rounded-3xl shadow-xl p-6 lg:p-8 border border-gray-100">
                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-3 lg:p-4 mb-4 lg:mb-6">
                        <div class="flex items-start gap-3">
                            <div class="bg-emerald-100 rounded-xl p-2 flex-shrink-0">
                                <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                            </div>
                            <p class="text-emerald-800 text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-3 lg:p-4 mb-4 lg:mb-6">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-start gap-3">
                                <div class="bg-red-100 rounded-xl p-2 flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-600 text-sm"></i>
                                </div>
                                <p class="text-red-800 text-sm">{{ $error }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Social Login Buttons --}}
                {{-- <div class="grid grid-cols-2 gap-2 lg:gap-3 mb-4 lg:mb-6">
                    <button
                        class="flex items-center justify-center gap-2 px-3 py-2.5 lg:py-3 border-2 border-gray-200 rounded-xl
                                   hover:bg-gray-50 transition-all text-xs lg:text-sm font-medium text-gray-700">
                        <i class="fab fa-google text-red-500"></i>
                        Google
                    </button>
                    <button
                        class="flex items-center justify-center gap-2 px-3 py-2.5 lg:py-3 border-2 border-gray-200 rounded-xl
                                   hover:bg-gray-50 transition-all text-xs lg:text-sm font-medium text-gray-700">
                        <i class="fab fa-facebook text-blue-600"></i>
                        Facebook
                    </button>
                </div> --}}

                {{-- Divider --}}
                <div class="relative mb-4 lg:mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs lg:text-sm">
                        <span class="px-4 bg-white text-gray-400">atau masuk dengan email</span>
                    </div>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3 lg:mb-5">
                        <label for="email"
                            class="block text-sm font-semibold text-gray-700 mb-1.5 lg:mb-2">Email</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-envelope text-sm"></i>
                            </span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="nama@email.com" required
                                class="w-full pl-11 lg:pl-12 pr-4 py-3 lg:py-3.5 border-2 border-gray-200 rounded-xl
                                          focus:border-emerald-500 focus:ring-0 transition-all
                                          placeholder-gray-400 text-gray-800 font-medium text-sm lg:text-base">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3 lg:mb-5">
                        <label for="password"
                            class="block text-sm font-semibold text-gray-700 mb-1.5 lg:mb-2">Password</label>
                        <div class="relative" x-data="{ show: false }">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input :type="show ? 'text' : 'password'" name="password" id="password"
                                placeholder="••••••••" required
                                class="w-full pl-11 lg:pl-12 pr-12 py-3 lg:py-3.5 border-2 border-gray-200 rounded-xl
                                          focus:border-emerald-500 focus:ring-0 transition-all
                                          placeholder-gray-400 text-gray-800 font-medium text-sm lg:text-base">
                            <button type="button" @click="show = !show"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas text-sm" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between mb-4 lg:mb-6">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded-lg border-2 border-gray-300 text-emerald-600
                                          focus:ring-emerald-500 transition-all">
                            <span
                                class="ml-2 text-xs lg:text-sm text-gray-600 group-hover:text-gray-800 transition-colors">Ingat
                                saya</span>
                        </label>

                        <a href="#"
                            class="text-xs lg:text-sm text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                            Lupa password?
                        </a>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full bg-green-500 text-white py-3.5 lg:py-4 rounded-xl
               font-semibold  transition-all
               shadow-sm hover:shadow-md transform hover:-translate-y-0.5 text-base lg:text-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                    </button>
                </form>

                {{-- Register Link --}}
                <div class="mt-4 lg:mt-6 text-center">
                    <p class="text-gray-500 text-sm">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>

            {{-- Demo Info --}}
            {{-- <div class="mt-4 lg:mt-6 text-center">
                <div
                    class="inline-flex items-center gap-2 bg-white rounded-2xl shadow-sm border border-gray-100 px-3 py-2.5 lg:px-4 lg:py-3">
                    <i class="fas fa-info-circle text-amber-500 text-sm"></i>
                    <div class="text-left">
                        <p class="text-[10px] lg:text-xs text-gray-500">Demo: <span
                                class="font-mono font-semibold text-gray-700">admin@indomarket.com</span></p>
                        <p class="text-[10px] lg:text-xs text-gray-400">Password: <span
                                class="font-mono">password</span></p>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</body>

</html>
