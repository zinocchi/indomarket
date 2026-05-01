{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Indomarket Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts - Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
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

        .animate-slideIn {
            animation: slideIn 0.3s ease-out;
        }

        .animate-fadeIn {
            animation: fadeIn 0.4s ease-out;
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50" x-data="{
    sidebarOpen: window.innerWidth >= 1024,
    sidebarMobile: false,

    toggleSidebar() {
        if (window.innerWidth < 1024) {
            this.sidebarMobile = !this.sidebarMobile;
        } else {
            this.sidebarOpen = !this.sidebarOpen;
        }
    },

    init() {
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                this.sidebarMobile = false;
                this.sidebarOpen = true;
            }
        });
    }
}">
    <div class="min-h-screen flex">
        {{-- Sidebar Overlay (Mobile) --}}
        <div x-show="sidebarMobile" @click="sidebarMobile = false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/50 z-40 lg:hidden">
        </div>

        {{-- Sidebar --}}
        @include('admin.partials.sidebar-redesign')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-h-screen">
            {{-- Top Navigation --}}
            @include('admin.partials.topnav-redesign')

            {{-- Page Content --}}
            <main class="flex-1 p-4 lg:p-6">
                {{-- Flash Messages --}}
                @if (session()->has('success') || session()->has('error') || session()->has('warning'))
                    <div class="mb-6 space-y-3">
                        @if (session('success'))
                            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 animate-fadeIn"
                                x-data="{ show: true }" x-show="show">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-emerald-100 rounded-xl p-2">
                                            <i class="fas fa-check-circle text-emerald-600"></i>
                                        </div>
                                        <p class="text-emerald-800 font-medium text-sm">{{ session('success') }}</p>
                                    </div>
                                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 animate-fadeIn"
                                x-data="{ show: true }" x-show="show">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-red-100 rounded-xl p-2">
                                            <i class="fas fa-exclamation-circle text-red-600"></i>
                                        </div>
                                        <p class="text-red-800 font-medium text-sm">{{ session('error') }}</p>
                                    </div>
                                    <button @click="show = false" class="text-red-500 hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
