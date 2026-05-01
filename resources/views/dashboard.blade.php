{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="min-h-screen bg-gray-50">
        {{-- Hero Section --}}
        <section class="relative bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-600 overflow-hidden">
            {{-- Decorative Elements --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-yellow-300 rounded-full blur-3xl"></div>
            </div>

            <div class="container mx-auto px-4 py-12 lg:py-16 relative">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    {{-- Hero Text --}}
                    <div class="flex-1 text-white text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 mb-6">
                            <span class="w-2 h-2 bg-amber-400 rounded-full animate-pulse"></span>
                            <span class="text-sm">Gratis Ongkir min. belanja Rp 50.000</span>
                        </div>

                        <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-4">
                            Belanja Kebutuhan
                            <span class="text-amber-300">Sehari-hari</span>
                            Lebih Mudah
                        </h1>

                        <p class="text-lg text-emerald-100 mb-8 leading-relaxed">
                            Temukan berbagai produk kebutuhan pokok, makanan ringan, minuman,
                            dan perlengkapan rumah tangga dengan harga terbaik.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center justify-center bg-white text-emerald-700 px-8 py-4 rounded-2xl
                                  font-semibold hover:bg-amber-400 hover:text-gray-900 transition-all duration-300
                                  shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-shopping-bag mr-2"></i>
                                Mulai Belanja
                            </a>
                            <a href="#categories"
                                class="inline-flex items-center justify-center border-2 border-white/30 text-white px-8 py-4
                                  rounded-2xl font-semibold hover:bg-white/10 transition-all duration-300">
                                <i class="fas fa-th-large mr-2"></i>
                                Lihat Kategori
                            </a>
                        </div>
                    </div>

                    {{-- Hero Image/Illustration --}}
                    <div class="flex-1 flex justify-center lg:justify-end">
                        <div class="relative">
                            <div
                                class="w-64 h-64 lg:w-80 lg:h-80 bg-white/10 backdrop-blur-sm rounded-3xl
                                    flex items-center justify-center border border-white/20">
                                <div class="text-center">
                                    <i class="fas fa-store text-7xl lg:text-8xl text-white/80 animate-float"></i>
                                    <p class="text-white/60 mt-4 text-sm">Tersedia 50+ Produk</p>
                                </div>
                            </div>

                            {{-- Floating Cards --}}
                            <div class="absolute -top-4 -right-4 bg-white rounded-2xl p-3 shadow-lg animate-fadeIn">
                                <p class="text-emerald-600 font-bold text-sm">⭐ 4.9</p>
                                <p class="text-gray-500 text-xs">Rating</p>
                            </div>

                            <div class="absolute -bottom-4 -left-4 bg-white rounded-2xl p-3 shadow-lg animate-fadeIn">
                                <p class="text-amber-500 font-bold text-sm">⚡ Cepat</p>
                                <p class="text-gray-500 text-xs">Pengiriman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Wave Shape --}}
            <div class="absolute bottom-0 left-0 right-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full">
                    <path fill="#f9fafb" fill-opacity="1"
                        d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                    </path>
                </svg>
            </div>
        </section>

        {{-- Quick Stats --}}
        <section class="container mx-auto px-4 -mt-12 relative z-10">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 animate-slideInUp">
                <div
                    class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300
                        hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-box text-emerald-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ App\Models\Product::active()->inStock()->count() }}</p>
                    <p class="text-sm text-gray-500">Produk Tersedia</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300
                        hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-tags text-amber-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ App\Models\Category::count() }}</p>
                    <p class="text-sm text-gray-500">Kategori</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300
                        hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-truck text-blue-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">Gratis</p>
                    <p class="text-sm text-gray-500">Ongkir (3km)</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300
                        hover:-translate-y-1 text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-clock text-green-600"></i>
                    </div>
                    <p class="text-2xl font-bold text-gray-800">08-22</p>
                    <p class="text-sm text-gray-500">Jam Buka</p>
                </div>
            </div>
        </section>

        {{-- Categories Section --}}
        <section id="categories" class="container mx-auto px-4 py-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Kategori Produk</h2>
                    <p class="text-gray-500 mt-1">Pilih berdasarkan kategori kebutuhan Anda</p>
                </div>
                <a href="{{ route('products.index') }}"
                    class="hidden sm:inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                    Semua Kategori
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @php
                    $categories = App\Models\Category::withCount([
                        'products' => function ($q) {
                            $q->active()->inStock();
                        },
                    ])
                        ->having('products_count', '>', 0)
                        ->take(6)
                        ->get();
                @endphp

                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                        class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300
                          hover:-translate-y-1 text-center border border-gray-50">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl
                                flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-box-open text-emerald-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-800 group-hover:text-emerald-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">{{ $category->products_count }} Produk</p>
                    </a>
                @endforeach
            </div>

            {{-- Mobile View All --}}
            <div class="mt-6 text-center sm:hidden">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-emerald-600 font-medium">
                    Semua Kategori
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
        </section>

        {{-- Featured Products --}}
        <section class="container mx-auto px-4 py-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Produk Unggulan</h2>
                    <p class="text-gray-500 mt-1">Produk terbaik pilihan pelanggan</p>
                </div>
                <a href="{{ route('products.index') }}"
                    class="hidden sm:inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                    Lihat Semua
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
                @php
                    $featuredProducts = App\Models\Product::with('category')
                        ->active()
                        ->inStock()
                        ->latest()
                        ->take(8)
                        ->get();
                @endphp

                @foreach ($featuredProducts as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>

            {{-- Mobile View All --}}
            <div class="mt-6 text-center sm:hidden">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-emerald-600 font-medium">
                    Lihat Semua Produk
                    <i class="fas fa-arrow-right text-sm"></i>
                </a>
            </div>
        </section>

        {{-- Promo Banner --}}
        <section class="container mx-auto px-4 py-12">
            <div
                class="bg-gradient-to-r from-amber-400 via-amber-500 to-orange-500 rounded-3xl p-8 lg:p-12
                    shadow-lg relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white rounded-full blur-2xl"></div>
                </div>

                <div class="relative flex flex-col lg:flex-row items-center gap-8">
                    <div class="flex-1 text-white text-center lg:text-left">
                        <span class="inline-block bg-white/20 backdrop-blur-sm rounded-full px-4 py-1 text-sm mb-4">
                            🎉 Promo Spesial
                        </span>
                        <h3 class="text-2xl lg:text-3xl font-bold mb-2">
                            Gratis Ongkos Kirim!
                        </h3>
                        <p class="text-white/90 text-lg">
                            Untuk pembelian minimal <strong>Rp 50.000</strong> dengan jarak maksimal <strong>3 km</strong>
                        </p>
                        <p class="text-white/80 text-sm mt-2">*Berlaku untuk belanja minimarket</p>
                    </div>

                    <div class="flex-shrink-0">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center bg-white text-amber-600 px-8 py-4 rounded-2xl
                              font-bold hover:bg-gray-900 hover:text-white transition-all duration-300 shadow-lg
                              hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Belanja Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Recent Transactions --}}
        @php
            $recentTransactions = Auth::user()
                ->transactions()
                ->with(['details.product'])
                ->latest()
                ->take(5)
                ->get();
        @endphp

        @if ($recentTransactions->count() > 0)
            <section class="container mx-auto px-4 py-12">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold text-gray-800">Transaksi Terakhir</h2>
                        <p class="text-gray-500 mt-1">Riwayat pembelian Anda</p>
                    </div>
                    <a href="{{ route('transactions.index') }}"
                        class="hidden sm:inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                        Lihat Semua
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @foreach ($recentTransactions as $transaction)
                        <a href="{{ route('transactions.show', $transaction->invoice_number) }}"
                            class="flex items-center justify-between p-4 lg:p-6 hover:bg-gray-50 transition-colors border-b last:border-b-0 group">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-{{ $transaction->status == 'completed' ? 'emerald' : ($transaction->status == 'pending' ? 'amber' : 'red') }}-100
                                        rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i
                                        class="fas fa-{{ $transaction->status == 'completed' ? 'check' : ($transaction->status == 'pending' ? 'clock' : 'times') }}
                                          text-{{ $transaction->status == 'completed' ? 'emerald' : ($transaction->status == 'pending' ? 'amber' : 'red') }}-600"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $transaction->invoice_number }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $transaction->transaction_date->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-800">{{ $transaction->formatted_total }}</p>
                                <span
                                    class="text-xs px-2 py-1 rounded-full
                                {{ $transaction->status == 'completed'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : ($transaction->status == 'pending'
                                        ? 'bg-amber-100 text-amber-700'
                                        : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    @include('partials.add-to-cart-script')
@endsection
