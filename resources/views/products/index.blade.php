{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', $currentCategory ? $currentCategory->name : 'Semua Produk')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar Filters --}}
        <div class="lg:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-20">
                <h3 class="font-semibold text-gray-800 mb-4">Filter</h3>

                <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                    {{-- Search Input --}}
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{-- Categories --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Kategori</h4>
                        <div class="space-y-2 max-h-60 overflow-y-auto">
                            <label class="flex items-center">
                                <input type="radio"
                                       name="category"
                                       value=""
                                       {{ !request('category') ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Semua Kategori</span>
                            </label>

                            @foreach($categories as $category)
                                <label class="flex items-center">
                                    <input type="radio"
                                           name="category"
                                           value="{{ $category->slug }}"
                                           {{ request('category') == $category->slug ? 'checked' : '' }}
                                           onchange="this.form.submit()"
                                           class="text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">{{ $category->name }}</span>
                                    <span class="ml-auto text-xs text-gray-400">{{ $category->products_count }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sort Options --}}
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Urutkan</h4>
                        <select name="sort"
                                onchange="this.form.submit()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        </select>
                    </div>

                    {{-- Clear Filters --}}
                    @if(request('category') || request('sort') || request('search'))
                        <a href="{{ route('products.index') }}"
                           class="mt-4 inline-block text-sm text-red-600 hover:text-red-700">
                            <i class="fas fa-times mr-1"></i>Reset Filter
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Products Grid --}}
        <div class="flex-1">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    {{ $currentCategory ? $currentCategory->name : 'Semua Produk' }}
                </h1>

                @if(request('search'))
                    <p class="text-gray-600">
                        Hasil pencarian untuk: <span class="font-medium">"{{ request('search') }}"</span>
                        ({{ $products->total() }} produk ditemukan)
                    </p>
                @else
                    <p class="text-gray-600">{{ $products->total() }} produk tersedia</p>
                @endif
            </div>

            {{-- Products --}}
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow">
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="relative">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <i class="fas fa-box text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif

                                    @if($product->isLowStock())
                                        <span class="absolute top-2 right-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">
                                            Stok Terbatas
                                        </span>
                                    @endif

                                    @if($product->stock == 0)
                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                                            <span class="bg-red-500 text-white px-4 py-2 rounded-lg font-medium">
                                                Stok Habis
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <div class="p-4">
                                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                                   class="text-sm text-blue-600 hover:text-blue-700">
                                    {{ $product->category->name }}
                                </a>

                                <a href="{{ route('products.show', $product->slug) }}" class="block mt-1">
                                    <h3 class="font-semibold text-gray-800 hover:text-blue-600">{{ $product->name }}</h3>
                                </a>

                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>

                                <div class="mt-3">
                                    <p class="text-xl font-bold text-blue-600">{{ $product->formatted_price }}</p>
                                </div>

                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        <i class="fas fa-box mr-1"></i>
                                        Stok: {{ $product->stock }}
                                    </span>

                                    @if($product->stock > 0)
                                        <button onclick="addToCart({{ $product->id }})"
                                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                            <i class="fas fa-shopping-cart mr-2"></i>Tambah
                                        </button>
                                    @else
                                        <button disabled
                                                class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed text-sm">
                                            <i class="fas fa-shopping-cart mr-2"></i>Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <i class="fas fa-box-open text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Tidak Ada Produk</h3>
                    <p class="text-gray-500 mb-4">
                        @if(request('search') || request('category'))
                            Tidak ada produk yang sesuai dengan filter.
                        @else
                            Belum ada produk yang tersedia.
                        @endif
                    </p>

                    @if(request('category') || request('search') || request('sort'))
                        <a href="{{ route('products.index') }}"
                           class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Lihat Semua Produk
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    async function addToCart(productId) {
        try {
            const response = await fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            });

            const data = await response.json();

            if (data.success) {
                window.dispatchEvent(new CustomEvent('cart-updated', {
                    detail: { count: data.cart_count }
                }));
                alert('Produk berhasil ditambahkan ke keranjang!');
            } else {
                alert(data.message || 'Gagal menambahkan produk');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
    }
</script>
@endpush
@endsection
