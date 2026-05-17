<nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                    <!-- Icon gambar -->
                    {{-- <div
                        class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-200 group-hover:scale-105">
                        <img src="{{ asset('asset/icon-store.png') }}" alt="Icon" class="w-5 h-5 object-contain">
                    </div> --}}

                    <!-- Logo gambar (tulisan Indomarket) -->
                    <div class="hidden sm:block">
                        <img src="{{ asset('image/indomarket2.jpeg') }}" alt="Indomarket" class="h-10 object-contain">
                    </div>
                </a>
            </div>

            {{-- Desktop Search --}}
            <div class="hidden lg:flex flex-1 max-w-xl mx-8">
                <div class="relative w-full" x-data="{
                    search: '',
                    results: [],
                    loading: false,
                    focused: false
                }">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" x-model="search"
                            @input.debounce.300ms="
                                   if(search.length >= 2) {
                                       loading = true;
                                       fetch('{{ route('products.search') }}?q=' + search)
                                           .then(res => res.json())
                                           .then(data => {
                                               results = data;
                                               loading = false;
                                           });
                                   } else {
                                       results = [];
                                   }
                               "
                            @focus="focused = true" @click.away="focused = false; results = []"
                            placeholder="Cari produk, kategori, atau SKU..."
                            class="w-full pl-12 pr-4 py-2.5 bg-gray-100 border-2 border-transparent rounded-xl
                                      focus:bg-white focus:border-emerald-500 focus:ring-0 transition-all duration-200
                                      placeholder-gray-400 text-gray-800">

                        {{-- Clear Button --}}
                        <button x-show="search.length > 0" @click="search = ''; results = []"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    {{-- Search Results Dropdown --}}
                    <div x-show="focused && results.length > 0" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full mt-2 w-full bg-white rounded-2xl shadow-lg border border-gray-100
                                max-h-96 overflow-y-auto z-50">
                        <div class="p-2">
                            <template x-for="product in results" :key="product.id">
                                <a :href="product.url"
                                    class="flex items-center gap-3 p-3 hover:bg-emerald-50 rounded-xl transition-colors group">
                                    <div
                                        class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center
                                                group-hover:bg-emerald-100 transition-colors">
                                        <i class="fas fa-box text-gray-400 group-hover:text-emerald-600"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-800 truncate" x-text="product.name"></p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-500" x-text="product.category"></span>
                                            <span class="text-xs text-gray-300">•</span>
                                            <span class="text-xs text-gray-500">Stok: <span
                                                    x-text="product.stock"></span></span>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-emerald-600" x-text="product.price"></p>
                                </a>
                            </template>
                        </div>
                    </div>

                    {{-- Loading --}}
                    <div x-show="focused && loading"
                        class="absolute top-full mt-2 w-full bg-white rounded-2xl shadow-lg border border-gray-100 p-4 text-center">
                        <i class="fas fa-spinner fa-spin text-emerald-600"></i>
                        <span class="ml-2 text-gray-600">Mencari...</span>
                    </div>

                    {{-- No Results --}}
                    <div x-show="focused && search.length >= 2 && results.length === 0 && !loading"
                        class="absolute top-full mt-2 w-full bg-white rounded-2xl shadow-lg border border-gray-100 p-4 text-center">
                        <i class="fas fa-search text-gray-300 text-2xl mb-2"></i>
                        <p class="text-gray-500">Produk tidak ditemukan</p>
                    </div>
                </div>
            </div>

            {{-- Right Menu --}}
            <div class="flex items-center gap-2">
                @php
                    $cartItems = session('cart', []);
                    $cartCount = 0;
                    if (is_array($cartItems)) {
                        $cartCount = array_sum(array_column($cartItems, 'quantity'));
                    }
                @endphp

                <div x-data="{ cartCount: {{ $cartCount }} }" @cart-updated.window="cartCount = $event.detail.count">
                    <a href="{{ route('cart.index') }}"
                        class="relative flex items-center justify-center w-10 h-10 rounded-xl hover:bg-gray-100 transition-colors group">
                        <i
                            class="fas fa-shopping-bag text-gray-600 group-hover:text-emerald-600 text-lg transition-colors"></i>
                        <span x-show="cartCount > 0" x-text="cartCount"
                            class="absolute -top-1 -right-1 bg-amber-500 text-white text-[10px] font-bold
                     rounded-full min-w-[18px] h-[18px] flex items-center justify-center px-1
                     shadow-sm">
                        </span>
                    </a>
                </div>

                {{-- User Menu --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 p-2 rounded-xl hover:bg-gray-100 transition-colors group">
                        <div
                            class="w-9 h-9 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center
                                    text-white font-semibold shadow-sm group-hover:shadow-md transition-all">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-[11px] text-gray-500 leading-tight">
                                {{ Auth::user()->isAdmin() ? 'Admin' : 'Member' }}</p>
                        </div>
                        <i
                            class="fas fa-chevron-down text-gray-400 text-xs hidden md:block
                                 group-hover:text-gray-600 transition-colors"></i>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden z-50">
                        {{-- User Info --}}
                        <div class="p-4 bg-gradient-to-br from-emerald-50 to-amber-50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center
                                            justify-center text-white font-semibold text-lg shadow-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Menu Items --}}
                        <div class="p-2">
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors group">
                                <i
                                    class="fas fa-user-circle w-5 text-gray-400 group-hover:text-emerald-500 transition-colors"></i>
                                <span>Profil Saya</span>
                            </a>

                            @if (Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors group">
                                    <i
                                        class="fas fa-cog w-5 text-gray-400 group-hover:text-emerald-500 transition-colors"></i>
                                    <span>Panel Admin</span>
                                    <span
                                        class="ml-auto bg-emerald-100 text-emerald-700 text-xs px-2 py-0.5 rounded-full">Admin</span>
                                </a>
                            @endif

                            <div class="border-t my-2"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors w-full group">
                                    <i class="fas fa-sign-out-alt w-5 group-hover:text-red-600 transition-colors"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden w-10 h-10 rounded-xl hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <i class="fas fa-bars text-gray-600 text-lg"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Search --}}
        <div class="lg:hidden py-3 border-t" x-show="mobileMenuOpen" x-transition>
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari produk..."
                        class="w-full pl-12 pr-4 py-3 bg-gray-100 border-2 border-transparent rounded-xl
                                  focus:bg-white focus:border-emerald-500 focus:ring-0 transition-all">
                </form>
            </div>

            {{-- Mobile Menu Links --}}
            <div class="mt-3 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors
                          {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                    <i class="fas fa-home w-5"></i>
                    <span class="font-medium">Beranda</span>
                </a>
                <a href="{{ route('products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors
                          {{ request()->routeIs('products.*') ? 'bg-emerald-50 text-emerald-700' : '' }}">
                    <i class="fas fa-th-large w-5"></i>
                    <span class="font-medium">Semua Produk</span>
                </a>
                <a href="{{ route('cart.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-shopping-bag w-5"></i>
                    <span class="font-medium">Keranjang</span>
                </a>
                <a href="{{ route('transactions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-clock-rotate-left w-5"></i>
                    <span class="font-medium">Riwayat</span>
                </a>
            </div>
        </div>
    </div>
</nav>
