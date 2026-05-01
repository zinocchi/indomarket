{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-6 lg:py-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center text-sm mb-6 text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <a href="{{ route('products.index') }}" class="hover:text-emerald-600 transition-colors">Produk</a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                    class="hover:text-emerald-600 transition-colors">{{ $product->category->name }}</a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-emerald-600 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
            </nav>

            {{-- Product Detail --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    {{-- Product Image Section --}}
                    <div
                        class="relative bg-gradient-to-br from-gray-50 to-gray-100 p-8 lg:p-12 flex items-center justify-center">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-full max-w-md h-auto rounded-2xl shadow-lg object-cover">
                        @else
                            <div
                                class="w-full max-w-md aspect-square bg-white rounded-2xl shadow-lg flex items-center justify-center">
                                <i class="fas fa-box text-gray-200 text-8xl"></i>
                            </div>
                        @endif

                        {{-- Stock Badge (Absolute Position) --}}
                        @if ($product->stock == 0)
                            <div
                                class="absolute top-4 left-4 bg-red-500 text-white px-4 py-2 rounded-2xl font-semibold shadow-lg">
                                <i class="fas fa-times-circle mr-2"></i>Stok Habis
                            </div>
                        @elseif($product->isLowStock())
                            <div
                                class="absolute top-4 left-4 bg-amber-500 text-white px-4 py-2 rounded-2xl font-semibold shadow-lg">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Stok Terbatas
                            </div>
                        @endif
                    </div>

                    {{-- Product Info Section --}}
                    <div class="p-8 lg:p-12 flex flex-col">
                        {{-- Category Badge --}}
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                            class="self-start inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-50 text-emerald-700
                              rounded-full text-sm font-medium hover:bg-emerald-100 transition-colors mb-4">
                            <i class="fas fa-tag text-xs"></i>
                            {{ $product->category->name }}
                        </a>

                        {{-- Product Name --}}
                        <h1 class="text-2xl lg:text-3xl font-extrabold text-gray-800 mb-2">{{ $product->name }}</h1>

                        {{-- SKU --}}
                        <p class="text-sm text-gray-400 mb-6">SKU: <span
                                class="font-mono text-gray-500">{{ $product->sku }}</span></p>

                        {{-- Price --}}
                        <div class="bg-gray-50 rounded-2xl p-5 mb-6">
                            <p class="text-sm text-gray-500 mb-1">Harga</p>
                            <div class="flex items-baseline gap-2">
                                <span
                                    class="text-3xl lg:text-4xl font-extrabold text-emerald-600">{{ $product->formatted_price }}</span>
                            </div>
                        </div>

                        {{-- Stock Info --}}
                        <div class="mb-6">
                            @if ($product->stock > 0)
                                <div class="flex items-center gap-2 text-emerald-600">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                    <span class="font-medium">Stok Tersedia: {{ $product->stock }} unit</span>
                                </div>
                                @if ($product->isLowStock())
                                    <p class="text-sm text-amber-600 mt-2 flex items-center gap-1">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Stok hampir habis, segera beli!
                                    </p>
                                @endif
                            @else
                                <div class="bg-red-50 rounded-2xl p-4">
                                    <p class="text-red-700 font-medium flex items-center gap-2">
                                        <i class="fas fa-times-circle"></i>
                                        Stok sedang kosong
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Description --}}
                        @if ($product->description)
                            <div class="mb-8">
                                <h3 class="font-semibold text-gray-800 mb-2">Deskripsi</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                            </div>
                        @endif

                        {{-- Add to Cart Section --}}
                        @if ($product->stock > 0)
                            <div class="mt-auto" x-data="{ quantity: 1 }">
                                <div class="flex items-center gap-4 mb-4">
                                    <label class="text-sm font-semibold text-gray-700">Jumlah:</label>
                                    <div
                                        class="inline-flex items-center border-2 border-gray-200 rounded-xl overflow-hidden">
                                        <button @click="if(quantity > 1) quantity--"
                                            class="w-12 h-12 flex items-center justify-center text-gray-500
                                                   hover:bg-gray-100 transition-colors">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" x-model="quantity" min="1" max="{{ $product->stock }}"
                                            class="w-16 text-center text-lg font-semibold text-gray-800
                                                  border-x-2 border-gray-200 py-3 focus:outline-none">
                                        <button @click="if(quantity < {{ $product->stock }}) quantity++"
                                            class="w-12 h-12 flex items-center justify-center text-gray-500
                                                   hover:bg-gray-100 transition-colors">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>

                                    @if ($product->stock <= 10 && $product->stock > 0)
                                        <span class="text-sm text-amber-600">
                                            Maks {{ $product->stock }} unit
                                        </span>
                                    @endif
                                </div>

                                <div class="flex gap-3">
                                    <button onclick="addToCart({{ $product->id }}, quantity)"
                                        class="flex-1 bg-gradient-to-r from-emerald-600 to-emerald-500 text-white px-8 py-4
                                               rounded-2xl font-semibold text-lg hover:from-emerald-700 hover:to-emerald-600
                                               transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                        <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                                    </button>

                                    <button
                                        class="w-14 h-14 flex items-center justify-center border-2 border-gray-200 rounded-2xl
                                               text-gray-400 hover:text-red-500 hover:border-red-200 transition-all">
                                        <i class="far fa-heart text-xl"></i>
                                    </button>
                                </div>

                                {{-- Subtotal Preview --}}
                                <div class="mt-4 p-4 bg-amber-50 rounded-2xl">
                                    <p class="text-sm text-amber-800 flex items-center gap-1">
                                        <i class="fas fa-info-circle"></i>
                                        Subtotal:
                                        <span class="font-bold">Rp <span
                                                x-text="({{ $product->price }} * quantity).toLocaleString('id-ID')"></span></span>
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="mt-auto">
                                <button disabled
                                    class="w-full bg-gray-200 text-gray-400 px-8 py-4 rounded-2xl font-semibold text-lg cursor-not-allowed">
                                    <i class="fas fa-times-circle mr-2"></i>Stok Habis
                                </button>

                                <p class="text-center text-sm text-gray-400 mt-3">
                                    Produk akan tersedia kembali dalam beberapa hari
                                </p>
                            </div>
                        @endif

                        {{-- Additional Info --}}
                        <div class="mt-8 pt-8 border-t grid grid-cols-3 gap-4 text-center">
                            <div class="p-3 bg-gray-50 rounded-2xl">
                                <i class="fas fa-truck text-emerald-500 text-xl mb-2"></i>
                                <p class="text-xs font-medium text-gray-700">Gratis Ongkir</p>
                                <p class="text-[10px] text-gray-500">Min. 50k (3km)</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-2xl">
                                <i class="fas fa-shield-check text-emerald-500 text-xl mb-2"></i>
                                <p class="text-xs font-medium text-gray-700">Terpercaya</p>
                                <p class="text-[10px] text-gray-500">⭐ 4.9 Rating</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-2xl">
                                <i class="fas fa-clock text-emerald-500 text-xl mb-2"></i>
                                <p class="text-xs font-medium text-gray-700">Cepat</p>
                                <p class="text-[10px] text-gray-500">Pengiriman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related Products --}}
            @if ($relatedProducts->count() > 0)
                <div class="mt-12">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Produk Terkait</h2>
                            <p class="text-gray-500 mt-1">Produk lain dalam kategori yang sama</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5">
                        @foreach ($relatedProducts as $related)
                            @include('partials.product-card', ['product' => $related])
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('partials.add-to-cart-script')
@endsection 
