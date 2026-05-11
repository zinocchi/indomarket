{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Indomarket') - Indomarket</title>

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

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-slideInUp {
            animation: slideInUp 0.6s ease-out;
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
    {{-- Top Promo Bar --}}
    @include('partials.promo-bar')

    {{-- Navbar Redesign --}}
    @include('partials.navbar-redesign')

    {{-- Main Content --}}
    <main class="flex-1">
        {{-- Flash Messages --}}
        @if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
            <div class="container mx-auto px-4 pt-4">
                @if (session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-4 rounded-r-xl animate-fadeIn"
                        x-data="{ show: true }" x-show="show" x-transition.duration.300ms>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-emerald-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-check-circle text-emerald-600"></i>
                                </div>
                                <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false"
                                class="text-emerald-500 hover:text-emerald-700 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-4 rounded-r-xl animate-fadeIn"
                        x-data="{ show: true }" x-show="show" x-transition.duration.300ms>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-red-100 rounded-full p-2 mr-3">
                                    <i class="fas fa-exclamation-circle text-red-600"></i>
                                </div>
                                <p class="text-red-800 font-medium">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="text-red-500 hover:text-red-700 transition-colors">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Footer Redesign --}}
    @include('partials.footer-redesign')

    {{-- Mobile Bottom Navigation --}}
    @include('partials.mobile-bottom-nav')

    @stack('scripts')
</body>

</html>
