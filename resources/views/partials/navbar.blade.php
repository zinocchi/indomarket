{{-- resources/views/partials/navbar.blade.php --}}
<nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false, searchOpen: false }">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-600">
                    Indomarket
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('dashboard') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600' : '' }}">
                    <i class="fas fa-home mr-2"></i>Beranda
                </a>
                <a href="{{ route('products.index') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('products.*') ? 'text-blue-600' : '' }}">
                    <i class="fas fa-box mr-2"></i>Produk
                </a>
                <a href="{{ route('transactions.index') }}"
                   class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('transactions.*') ? 'text-blue-600' : '' }}">
                    <i class="fas fa-history mr-2"></i>Riwayat
                </a>

                {{-- Search Bar Desktop --}}
                <div class="relative" x-data="{ search: '', results: [], loading: false }">
                    <form @submit.prevent="window.location.href = '{{ route('products.index') }}?search=' + search">
                        <input type="text"
                               x-model="search"
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
                               @click.away="results = []"
                               placeholder="Cari produk..."
                               class="w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                        {{-- Search Results Dropdown --}}
                        <div x-show="results.length > 0"
                             class="absolute top-full mt-2 w-full bg-white rounded-lg shadow-lg border border-gray-200 max-h-96 overflow-y-auto">
                            <template x-for="product in results" :key="product.id">
                                <a :href="product.url"
                                   class="block px-4 py-3 hover:bg-gray-50 border-b last:border-b-0">
                                    <div class="font-medium text-gray-800" x-text="product.name"></div>
                                    <div class="flex justify-between items-center mt-1">
                                        <span class="text-sm text-gray-500" x-text="product.category"></span>
                                        <span class="text-sm font-medium text-blue-600" x-text="product.price"></span>
                                    </div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        Stok: <span x-text="product.stock"></span>
                                    </div>
                                </a>
                            </template>
                        </div>

                        {{-- Loading Indicator --}}
                        <div x-show="loading" class="absolute top-full mt-2 w-full bg-white rounded-lg shadow-lg border border-gray-200 p-4 text-center">
                            <i class="fas fa-spinner fa-spin text-blue-600"></i>
                            <span class="ml-2 text-gray-600">Mencari...</span>
                        </div>

                        {{-- No Results --}}
                        <div x-show="search.length >= 2 && results.length === 0 && !loading"
                             class="absolute top-full mt-2 w-full bg-white rounded-lg shadow-lg border border-gray-200 p-4 text-center">
                            <span class="text-gray-500">Produk tidak ditemukan</span>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Right Menu --}}
            <div class="flex items-center space-x-4">
                {{-- Cart Button --}}
                <div x-data="{ cartCount: {{ array_sum(session('cart', [])) ?? 0 }} }"
                     @cart-updated.window="cartCount = $event.detail.count">
                    <a href="{{ route('cart.index') }}" class="relative text-gray-700 hover:text-blue-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span x-show="cartCount > 0"
                              x-text="cartCount"
                              class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        </span>
                    </a>
                </div>

                {{-- User Dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs"></i>
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2">
                        <div class="px-4 py-2 border-b">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>

                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i>Profil
                        </a>

                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i>Admin Panel
                            </a>
                        @endif

                        <div class="border-t"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenuOpen"
             @click.away="mobileMenuOpen = false"
             class="md:hidden py-4 border-t">
            <div class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-home mr-3"></i>Beranda
                </a>
                <a href="{{ route('products.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-box mr-3"></i>Produk
                </a>
                <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-history mr-3"></i>Riwayat
                </a>

                {{-- Mobile Search --}}
                <div class="px-4 py-2">
                    <form action="{{ route('products.index') }}" method="GET">
                        <input type="text"
                               name="search"
                               placeholder="Cari produk..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
