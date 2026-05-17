{{-- resources/views/admin/partials/sidebar-redesign.blade.php --}}
<aside
    class="bg-gray-900 text-white flex flex-col transition-all duration-300 ease-in-out
              fixed inset-y-0 left-0 z-50
              w-64"
    :class="{
        'translate-x-0': sidebarOpen || sidebarMobile,
        '-translate-x-full': !sidebarOpen && !sidebarMobile,
        'lg:translate-x-0 lg:w-64': sidebarOpen,
        'lg:translate-x-0 lg:w-20': !sidebarOpen
    }">

    {{-- Logo --}}
    <div class="flex items-center gap-3 p-5 border-b border-gray-800 h-16 flex-shrink-0">
        <!-- Logo gambar -->
        <div x-show="sidebarOpen || sidebarMobile" class="flex-1 min-w-0">
            <img src="{{ asset('image/indomarket2.jpeg') }}" alt="Indomarket" class="h-6 object-contain">
        </div>
        {{-- Logo kecil saat collapse --}}
        <div x-show="!sidebarOpen && !sidebarMobile" class="w-full flex justify-center">
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                <i class="fas fa-store-alt text-white text-sm"></i>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 py-4 overflow-y-auto custom-scrollbar">
        <div class="px-3 space-y-1">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 group
                      {{ request()->routeIs('admin.dashboard') ? 'bg-green-500 text-white shadow-lg shadow-green-500/25' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <i
                    class="fas fa-chart-pie w-5 text-center text-lg {{ request()->routeIs('admin.dashboard') ? '' : 'group-hover:text-green-400' }}"></i>
                <span x-show="sidebarOpen || sidebarMobile" class="font-medium text-sm">Dashboard</span>
                @if (request()->routeIs('admin.dashboard'))
                    <span x-show="sidebarOpen || sidebarMobile"
                        class="ml-auto w-1.5 h-1.5 bg-white rounded-full"></span>
                @endif
            </a>
        </div>

        {{-- Products Section --}}
        <div class="mt-6">
            <div x-show="sidebarOpen || sidebarMobile" class="px-6 mb-2">
                <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Products</p>
            </div>
            <div class="px-3 space-y-1">
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 group
                          {{ request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.create') ? 'bg-green-500 text-white shadow-lg shadow-green-500/25' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-box w-5 text-center text-lg"></i>
                    <span x-show="sidebarOpen || sidebarMobile" class="font-medium text-sm">Semua Produk</span>
                </a>

                <a href="{{ route('admin.products.create') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 group
                          {{ request()->routeIs('admin.products.create') ? 'bg-green-500 text-white shadow-lg shadow-green-500/25' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-plus-circle w-5 text-center text-lg"></i>
                    <span x-show="sidebarOpen || sidebarMobile" class="font-medium text-sm">Tambah Produk</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 group
                          {{ request()->routeIs('admin.categories.*') ? 'bg-green-500 text-white shadow-lg shadow-green-500/25' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-tags w-5 text-center text-lg"></i>
                    <span x-show="sidebarOpen || sidebarMobile" class="font-medium text-sm">Kategori</span>
                </a>
            </div>
        </div>

        {{-- Transactions Section --}}
        <div class="mt-6">
            <div x-show="sidebarOpen || sidebarMobile" class="px-6 mb-2">
                <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Transactions</p>
            </div>
            <div class="px-3 space-y-1">
                <a href="{{ route('admin.transactions.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 group
                          {{ request()->routeIs('admin.transactions.*') ? 'bg-green-500 text-white shadow-lg shadow-green-500/25' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-shopping-cart w-5 text-center text-lg"></i>
                    <span x-show="sidebarOpen || sidebarMobile" class="font-medium text-sm">Transaksi</span>
                </a>
            </div>
        </div>

        {{-- Users Section --}}
        <div class="mt-6">
            <div x-show="sidebarOpen || sidebarMobile" class="px-6 mb-2">
                <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-wider">Users</p>
            </div>
            <div class="px-3 space-y-1">
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 group
                          {{ request()->routeIs('admin.users.*') ? 'bg-green-500 text-white shadow-lg shadow-green-500/25' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas fa-users w-5 text-center text-lg"></i>
                    <span x-show="sidebarOpen || sidebarMobile" class="font-medium text-sm">Pengguna</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- User Info Footer --}}
    <div class="p-4 border-t border-gray-800 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-white font-semibold flex-shrink-0">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div x-show="sidebarOpen || sidebarMobile" class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400">Administrator</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" x-show="sidebarOpen || sidebarMobile">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-400 transition-colors">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
