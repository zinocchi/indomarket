{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-6 lg:py-8">
            {{-- Breadcrumb --}}
            {{-- <nav class="flex items-center text-sm mb-6 text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-emerald-600 font-medium">Keranjang Belanja</span>
            </nav> --}}

            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-6">
                Keranjang Belanja
                @if (count($cartItems) > 0)
                    <span class="text-lg font-normal text-gray-400">({{ count($cartItems) }} item)</span>
                @endif
            </h1>

            @if (count($cartItems) > 0)
                <div class="flex flex-col lg:flex-row gap-6" x-data="cartManager()" x-init="init()">
                    {{-- Cart Items --}}
                    <div class="flex-1">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            {{-- Header --}}
                            <div class="p-5 border-b bg-gray-50/50">
                                <div class="grid grid-cols-12 gap-4 text-xs font-semibold text-gray-500 uppercase">
                                    <div class="col-span-5">Produk</div>
                                    <div class="col-span-2 text-center">Harga</div>
                                    <div class="col-span-2 text-center">Jumlah</div>
                                    <div class="col-span-2 text-right">Subtotal</div>
                                    <div class="col-span-1"></div>
                                </div>
                            </div>

                            {{-- Items --}}
                            <div class="divide-y">
                                @foreach ($cartItems as $item)
                                    <div class="p-5 hover:bg-gray-50/50 transition-colors" x-data="{ quantity: {{ $item['quantity'] }} }">
                                        <div class="grid grid-cols-12 gap-4 items-center">
                                            {{-- Product --}}
                                            <div class="col-span-5">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center
                                                            flex-shrink-0 overflow-hidden">
                                                        @if ($item['product']->image)
                                                            <img src="{{ asset('storage/' . $item['product']->image) }}"
                                                                alt="{{ $item['product']->name }}"
                                                                class="w-full h-full object-cover">
                                                        @else
                                                            <i class="fas fa-box text-gray-300 text-xl"></i>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0">
                                                        <a href="{{ route('products.show', $item['product']->slug) }}"
                                                            class="font-semibold text-gray-800 hover:text-emerald-600 transition-colors
                                                              line-clamp-2 text-sm lg:text-base">
                                                            {{ $item['product']->name }}
                                                        </a>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ $item['product']->category->name }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Price --}}
                                            <div class="col-span-2 text-center">
                                                <p class="text-sm font-medium text-gray-600">
                                                    {{ $item['product']->formatted_price }}</p>
                                            </div>

                                            {{-- Quantity --}}
                                            <div class="col-span-2 flex justify-center">
                                                <div
                                                    class="inline-flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                                    <button
                                                        @click="updateQuantity({{ $item['product']->id }}, quantity - 1)"
                                                        :disabled="quantity <= 1"
                                                        class="w-9 h-9 flex items-center justify-center text-gray-500
                                                               hover:bg-gray-100 disabled:opacity-30 transition-colors">
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>
                                                    <input type="number" x-model="quantity"
                                                        @change="updateQuantity({{ $item['product']->id }}, quantity)"
                                                        min="1" max="{{ $item['product']->stock }}"
                                                        class="w-12 text-center text-sm font-semibold text-gray-800
                                                              border-x-2 border-gray-200 py-2 focus:outline-none">
                                                    <button
                                                        @click="updateQuantity({{ $item['product']->id }}, quantity + 1)"
                                                        :disabled="quantity >= {{ $item['product']->stock }}"
                                                        class="w-9 h-9 flex items-center justify-center text-gray-500
                                                               hover:bg-gray-100 disabled:opacity-30 transition-colors">
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Subtotal --}}
                                            <div class="col-span-2 text-right">
                                                <p class="font-bold text-gray-800">Rp
                                                    {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                            </div>

                                            {{-- Remove --}}
                                            <div class="col-span-1 text-center">
                                                <button @click="removeItem({{ $item['product']->id }})"
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center
                                                           text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Footer --}}
                            <div class="p-5 border-t bg-gray-50/50">
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <a href="{{ route('products.index') }}"
                                        class="text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                                        <i class="fas fa-arrow-left mr-2"></i>Lanjutkan Belanja
                                    </a>
                                    <button @click="clearCart()"
                                        class="text-red-500 hover:text-red-600 font-medium transition-colors">
                                        <i class="fas fa-trash mr-2"></i>Kosongkan Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="lg:w-80">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h3 class="font-bold text-gray-800 text-lg mb-4">Ringkasan Belanja</h3>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Total Item</span>
                                    <span class="font-medium text-gray-800">{{ count($cartItems) }} item</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Total Harga</span>
                                    <span class="font-medium text-gray-800" x-text="formattedTotal">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="border-t pt-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-gray-800">Total</span>
                                    <span class="text-xl font-bold text-emerald-600" x-text="formattedTotal">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('transactions.checkout') }}"
                                class="block w-full bg-gradient-to-r from-green-500 to-green-500 text-white text-center
                                  px-6 py-4 rounded-2xl font-semibold hover:from-green-500 hover:to-green-500
                                  transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                <i class="fas fa-credit-card mr-2"></i>Lanjut ke Pembayaran
                            </a>

                            {{-- Promo Info --}}
                            <div class="mt-4 p-3 bg-amber-50 rounded-xl">
                                <p class="text-xs text-amber-700 flex items-center gap-1">
                                    <i class="fas fa-truck"></i>
                                    Gratis ongkir min. belanja Rp 50.000
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty Cart --}}
                <div
                    class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 lg:p-16 text-center max-w-lg mx-auto">
                    <div class="w-32 h-32 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shopping-bag text-gray-300 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Keranjang Kosong</h3>
                    <p class="text-gray-500 mb-8">
                        Yuk, isi keranjangmu dengan produk-produk terbaik dari Indomarket!
                    </p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center gap-2 bg-green-500 text-white px-8 py-4 rounded-2xl
                          font-semibold hover:bg-emerald-700 transition-all shadow-sm hover:shadow-md">
                        <i class="fas fa-shopping-cart"></i>
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>

    @if (count($cartItems) > 0)
        @push('scripts')
            <script>
                function cartManager() {
                    return {
                        total: {{ $total }},
                        formattedTotal: 'Rp {{ number_format($total, 0, ',', '.') }}',

                        init() {},

                        async updateQuantity(productId, quantity) {
                            if (quantity < 1) return;

                            try {
                                const response = await fetch(`{{ url('/cart') }}/${productId}`, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({
                                        quantity: quantity
                                    })
                                });

                                const data = await response.json();

                                if (data.success) {
                                    this.total = data.total;
                                    this.formattedTotal = data.formatted_total;
                                    window.dispatchEvent(new CustomEvent('cart-updated', {
                                        detail: {
                                            count: data.cart_count
                                        }
                                    }));

                                    if (data.message.includes('dihapus')) {
                                        window.location.reload();
                                    } else {
                                        location.reload();
                                    }
                                } else {
                                    alert(data.message);
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan. Silakan coba lagi.');
                            }
                        },

                        async removeItem(productId) {
                            if (!confirm('Hapus produk dari keranjang?')) return;

                            try {
                                const response = await fetch(`{{ url('/cart') }}/${productId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    }
                                });

                                const data = await response.json();

                                if (data.success) {
                                    window.dispatchEvent(new CustomEvent('cart-updated', {
                                        detail: {
                                            count: data.cart_count
                                        }
                                    }));
                                    window.location.reload();
                                }
                            } catch (error) {
                                console.error('Error:', error);
                            }
                        },

                        async clearCart() {
                            if (!confirm('Kosongkan seluruh keranjang?')) return;

                            try {
                                const response = await fetch('{{ route('cart.clear') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    }
                                });

                                window.location.reload();
                            } catch (error) {
                                console.error('Error:', error);
                            }
                        }
                    }
                }
            </script>
        @endpush
    @endif
@endsection
