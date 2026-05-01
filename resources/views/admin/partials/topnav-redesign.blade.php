{{-- resources/views/admin/partials/topnav-redesign.blade.php --}}
<header class="bg-white shadow-sm sticky top-0 z-30 h-16">
    <div class="h-full px-4 lg:px-6 flex items-center justify-between">
        {{-- Left Side --}}
        <div class="flex items-center gap-4">
            {{-- Toggle Sidebar --}}
            <button @click="toggleSidebar()"
                class="w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center transition-colors">
                <i class="fas fa-bars text-gray-600 text-lg"></i>
            </button>

            {{-- Breadcrumb --}}
            <nav class="hidden sm:flex items-center text-sm">
                @yield('breadcrumb')
            </nav>
        </div>

        {{-- Right Side --}}
        <div class="flex items-center gap-2 lg:gap-3">
            {{-- View Site --}}
            <a href="{{ route('dashboard') }}" target="_blank"
                class="hidden sm:flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-emerald-600
                      hover:bg-emerald-50 rounded-xl transition-all">
                <i class="fas fa-external-link-alt text-xs"></i>
                <span>Lihat Toko</span>
            </a>

            {{-- Notifications --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="relative w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <i class="fas fa-bell text-gray-600 text-lg"></i>
                    @php
                        $alertCount = App\Models\Product::lowStock()->count();
                    @endphp
                    @if ($alertCount > 0)
                        <span
                            class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] font-bold
                                     rounded-full min-w-[18px] h-[18px] flex items-center justify-center shadow-sm">
                            {{ $alertCount }}
                        </span>
                    @endif
                </button>

                {{-- Notifications Dropdown --}}
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden z-50">
                    <div class="p-4 border-b">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                            @if ($alertCount > 0)
                                <span
                                    class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded-full">{{ $alertCount }}
                                    alert</span>
                            @endif
                        </div>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        @php
                            $lowStockProducts = App\Models\Product::with('category')->lowStock()->take(5)->get();
                        @endphp
                        @forelse($lowStockProducts as $product)
                            <a href="{{ route('admin.products.show', $product) }}"
                                class="flex items-start gap-3 p-4 hover:bg-gray-50 transition-colors border-b last:border-b-0">
                                <div
                                    class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-amber-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800">Stok Menipis</p>
                                    <p class="text-sm text-gray-600 truncate">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        Stok: <span class="font-semibold text-amber-600">{{ $product->stock }}</span> /
                                        Min: {{ $product->min_stock }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <p class="p-4 text-center text-gray-500 text-sm">Tidak ada notifikasi</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- User Menu --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center gap-2 p-2 rounded-xl hover:bg-gray-100 transition-colors">
                    <div
                        class="w-9 h-9 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center
                                text-white font-semibold text-sm shadow-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-gray-500 leading-tight">Admin</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs hidden md:block"></i>
                </button>

                {{-- Dropdown --}}
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden z-50">
                    <div class="p-3">
                        <p class="px-3 py-2 text-xs text-gray-500 uppercase font-semibold tracking-wider">Akun</p>
                        <a href="{{ route('dashboard') }}" target="_blank"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-store w-5 text-gray-400"></i>
                            Lihat Toko
                        </a>
                        <a href="#"
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors text-sm">
                            <i class="fas fa-user-cog w-5 text-gray-400"></i>
                            Pengaturan
                        </a>

                        <div class="border-t my-2"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-600 hover:bg-red-50 transition-colors text-sm w-full">
                                <i class="fas fa-sign-out-alt w-5"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
