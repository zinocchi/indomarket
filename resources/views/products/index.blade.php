{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', $currentCategory ? $currentCategory->name : 'Semua Produk')

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
                @if ($currentCategory)
                    <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                    <span class="text-emerald-600 font-medium">{{ $currentCategory->name }}</span>
                @endif
            </nav>

            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">
                    {{ $currentCategory ? $currentCategory->name : 'Semua Produk' }}
                </h1>
                @if (request('search'))
                    <p class="text-gray-500 mt-1">
                        Hasil pencarian: <span class="font-medium text-emerald-600">"{{ request('search') }}"</span>
                        <span class="text-gray-400">({{ $products->total() }} produk)</span>
                    </p>
                @else
                    <p class="text-gray-500 mt-1">{{ $products->total() }} produk tersedia</p>
                @endif
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Sidebar Filters --}}
                <div class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-24">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="font-semibold text-gray-800 text-lg">Filter</h3>
                            @if (request('category') || request('sort') || request('search'))
                                <a href="{{ route('products.index') }}"
                                    class="text-xs text-red-500 hover:text-red-600 transition-colors">
                                    <i class="fas fa-times mr-1"></i>Reset
                                </a>
                            @endif
                        </div>

                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            {{-- Categories --}}
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                    <i class="fas fa-tags text-emerald-500 text-xs"></i>Kategori
                                </h4>
                                <div class="space-y-1 max-h-60 overflow-y-auto">
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" name="category" value=""
                                            {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()"
                                            class="sr-only peer">
                                        <span
                                            class="w-full px-3 py-2.5 rounded-xl text-sm transition-all
                                               {{ !request('category') ? 'bg-emerald-50 text-emerald-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                            📦 Semua Kategori
                                        </span>
                                    </label>

                                    @foreach ($categories as $category)
                                        <label class="flex items-center cursor-pointer group">
                                            <input type="radio" name="category" value="{{ $category->slug }}"
                                                {{ request('category') == $category->slug ? 'checked' : '' }}
                                                onchange="this.form.submit()" class="sr-only peer">
                                            <span
                                                class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl text-sm transition-all
                                                   {{ request('category') == $category->slug ? 'bg-emerald-50 text-emerald-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                                <span>{{ $category->name }}</span>
                                                <span
                                                    class="text-xs {{ request('category') == $category->slug ? 'text-emerald-500' : 'text-gray-400' }}">
                                                    {{ $category->products_count }}
                                                </span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Sort --}}
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                    <i class="fas fa-sort-amount-down text-emerald-500 text-xs"></i>Urutkan
                                </h4>
                                <select name="sort" onchange="this.form.submit()"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm bg-gray-50
                                           focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>🆕
                                        Terbaru</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>💰
                                        Harga Terendah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>💎
                                        Harga Tertinggi</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>🔤 Nama
                                        A-Z</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Products Grid --}}
                <div class="flex-1">
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-5">
                            @foreach ($products as $product)
                                @include('partials.product-card', ['product' => $product])
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-8">
                            {{ $products->links() }}
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 lg:p-16 text-center">
                            <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-box-open text-gray-300 text-4xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Produk Tidak Ditemukan</h3>
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">
                                @if (request('search') || request('category'))
                                    Maaf, tidak ada produk yang sesuai dengan filter yang Anda pilih.
                                    Coba ubah kata kunci atau kategori.
                                @else
                                    Belum ada produk yang tersedia saat ini. Silakan cek kembali nanti.
                                @endif
                            </p>

                            @if (request('category') || request('search') || request('sort'))
                                <a href="{{ route('products.index') }}"
                                    class="inline-flex items-center gap-2 bg-emerald-600 text-white px-6 py-3 rounded-xl
                                      hover:bg-emerald-700 transition-all shadow-sm hover:shadow-md">
                                    <i class="fas fa-sync-alt"></i>
                                    Reset Filter
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}"
                                    class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali ke Beranda
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('partials.add-to-cart-script')
@endsection
