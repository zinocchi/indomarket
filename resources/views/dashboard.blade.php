{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- Welcome Section --}}
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-8 mb-8 text-white">
        <h1 class="text-3xl font-bold mb-2">
            Selamat Datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-blue-100">
            Temukan berbagai produk kebutuhan sehari-hari dengan harga terbaik
        </p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Transaksi</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_transactions'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Total Belanja</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-wallet text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Produk Tersedia</p>
                    <p class="text-3xl font-bold text-gray-800">{{ App\Models\Product::active()->inStock()->count() }}</p>
                </div>
                <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class="fas fa-box text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Categories Section --}}
    @if($categories->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Kategori</h2>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                       class="bg-white rounded-xl shadow-sm p-4 border border-gray-100 hover:shadow-md transition-shadow text-center">
                        <div class="bg-blue-50 rounded-full w-16 h-16 mx-auto mb-3 flex items-center justify-center">
                            <i class="fas fa-tag text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="font-medium text-gray-800">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->products_count }} Produk</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Featured Products --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Produk Unggulan</h2>
            <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-box text-gray-400 text-4xl"></i>
                            </div>
                        @endif

                        @if($product->isLowStock())
                            <span class="absolute top-2 right-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded">
                                Stok Terbatas
                            </span>
                        @endif
                    </div>

                    <div class="p-4">
                        <p class="text-sm text-gray-500 mb-1">{{ $product->category->name }}</p>
                        <h3 class="font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>
                        <p class="text-xl font-bold text-blue-600 mb-3">{{ $product->formatted_price }}</p>

                        <div class="flex items-center justify-between">
                            <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                <i class="fas fa-box mr-1"></i>
                                Stok: {{ $product->stock }}
                            </span>

                            <button onclick="addToCart({{ $product->id }})"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-shopping-cart mr-2"></i>Tambah
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Recent Transactions --}}
    @if($stats['recent_transactions']->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Transaksi Terakhir</h2>
                <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-700">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($stats['recent_transactions'] as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $transaction->invoice_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->transaction_date->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $transaction->formatted_total }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-700' :
                                               ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('transactions.show', $transaction->invoice_number) }}"
                                           class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
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
                // Dispatch custom event for cart update
                window.dispatchEvent(new CustomEvent('cart-updated', {
                    detail: { count: data.cart_count }
                }));

                // Show success message
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
