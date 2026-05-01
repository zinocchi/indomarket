{{-- resources/views/admin/products/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Produk - ' . $product->name)

@section('breadcrumb')
    <span class="text-gray-500">/</span>
    <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-blue-600 ml-2">Produk</a>
    <span class="text-gray-500 ml-2">/</span>
    <span class="text-gray-800 ml-2">{{ $product->name }}</span>
@endsection

@section('content')
    <div class="space-y-6">
        {{-- Header Actions --}}
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Detail Produk</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Product Info --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            {{-- Image --}}
                            <div class="flex-shrink-0">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-32 h-32 object-cover rounded-lg">
                                @else
                                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box text-gray-400 text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>

                                <div class="flex items-center gap-3 mb-4">
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                        {{ $product->category->name }}
                                    </span>
                                    <span class="text-sm text-gray-500">SKU: {{ $product->sku }}</span>
                                    <span class="text-sm">
                                        @if ($product->is_active)
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Aktif</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Nonaktif</span>
                                        @endif
                                    </span>
                                </div>

                                @if ($product->description)
                                    <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                                @endif

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Harga</p>
                                        <p class="text-xl font-bold text-blue-600">{{ $product->formatted_price }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Stok Saat Ini</p>
                                        <p
                                            class="text-xl font-bold {{ $product->isLowStock() ? 'text-yellow-600' : 'text-green-600' }}">
                                            {{ $product->stock }}
                                            <span class="text-sm text-gray-500 font-normal">/ {{ $product->min_stock }}
                                                min</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Stock Update --}}
                    <div class="border-t p-6 bg-gray-50">
                        <h4 class="font-semibold text-gray-800 mb-3">Update Stok Cepat</h4>
                        <form action="{{ route('admin.products.update-stock', $product) }}" method="POST"
                            class="flex items-end gap-3">
                            @csrf
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Tipe</label>
                                <select name="type" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <option value="add">Tambah (+)</option>
                                    <option value="subtract">Kurangi (-)</option>
                                    <option value="set">Set Stok (=)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Jumlah</label>
                                <input type="number" name="quantity" min="1" required
                                    class="w-32 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                <i class="fas fa-check mr-1"></i>Update
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Sales History --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b">
                        <h3 class="font-semibold text-gray-800">Riwayat Penjualan</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($product->transactionDetails->take(10) as $detail)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-3">
                                            <a href="{{ route('admin.transactions.show', $detail->transaction) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm">
                                                {{ $detail->transaction->invoice_number }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-3 text-sm text-gray-600">
                                            {{ $detail->transaction->transaction_date->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-3 text-center text-sm text-gray-800">
                                            {{ $detail->quantity }}
                                        </td>
                                        <td class="px-6 py-3 text-right text-sm font-medium text-gray-800">
                                            {{ $detail->formatted_subtotal }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada riwayat penjualan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Stats Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-20">
                    <h3 class="font-semibold text-gray-800 mb-4">Statistik Produk</h3>

                    <div class="space-y-4">
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Total Terjual</p>
                            <p class="text-2xl font-bold text-green-600">{{ $stats['total_sold'] }} unit</p>
                        </div>

                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Total Pendapatan</p>
                            <p class="text-lg font-bold text-blue-600">
                                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-sm text-gray-500">Nilai Stok Saat Ini</p>
                            <p class="text-lg font-bold text-purple-600">
                                Rp {{ number_format($stats['stock_value'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <h4 class="text-sm font-medium text-gray-700 mb-3">Status Stok</h4>
                        @if ($product->stock == 0)
                            <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg text-sm">
                                <i class="fas fa-times-circle mr-2"></i>Stok Habis
                            </div>
                        @elseif($product->isLowStock())
                            <div class="bg-yellow-50 text-yellow-700 px-4 py-3 rounded-lg text-sm">
                                <i class="fas fa-exclamation-triangle mr-2"></i>Stok Menipis
                            </div>
                        @else
                            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-lg text-sm">
                                <i class="fas fa-check-circle mr-2"></i>Stok Aman
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
