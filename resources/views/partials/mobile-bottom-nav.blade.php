{{-- resources/views/partials/mobile-bottom-nav.blade.php --}}
<nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg z-50">
    <div class="flex items-center justify-around py-2">
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-colors
                  {{ request()->routeIs('dashboard') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="fas fa-home text-lg"></i>
            <span class="text-[10px] font-medium">Beranda</span>
        </a>

        <a href="{{ route('products.index') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-colors
                  {{ request()->routeIs('products.*') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="fas fa-th-large text-lg"></i>
            <span class="text-[10px] font-medium">Produk</span>
        </a>

        @php
            $cartItems = session('cart', []);
            $cartCount = 0;
            if (is_array($cartItems)) {
                $cartCount = array_sum(array_column($cartItems, 'quantity'));
            }
        @endphp

        <a href="{{ route('cart.index') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-colors relative
          {{ request()->routeIs('cart.*') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="fas fa-shopping-bag text-lg"></i>
            @if ($cartCount > 0)
                <span
                    class="absolute -top-1 right-0 bg-amber-500 text-white text-[9px] font-bold
                     rounded-full min-w-[16px] h-[16px] flex items-center justify-center">
                    {{ $cartCount }}
                </span>
            @endif
            <span class="text-[10px] font-medium">Keranjang</span>
        </a>

        <a href="{{ route('transactions.index') }}"
            class="flex flex-col items-center gap-1 px-3 py-2 rounded-xl transition-colors
                  {{ request()->routeIs('transactions.*') ? 'text-emerald-600' : 'text-gray-400 hover:text-gray-600' }}">
            <i class="fas fa-clock-rotate-left text-lg"></i>
            <span class="text-[10px] font-medium">Riwayat</span>
        </a>
    </div>
</nav>
