{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition-colors ml-2">Dashboard</a>
    <span class="text-gray-400 ml-2">/</span>
    <span class="text-gray-800 font-medium ml-2">Produk</span>
@endsection

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header --}}
        <div class="p-5 lg:p-6 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $products->total() }} produk</p>
            </div>
            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center justify-center gap-2 bg-emerald-600 text-white px-5 py-2.5 rounded-xl
                  hover:bg-emerald-700 transition-all shadow-sm hover:shadow-md text-sm font-medium">
                <i class="fas fa-plus"></i>
                Tambah Produk
            </a>
        </div>

        {{-- Filters --}}
        <div class="p-5 lg:p-6 border-b bg-gray-50/50">
            <form action="{{ route('admin.products.index') }}" method="GET" id="filterForm">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    {{-- Search --}}
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari produk atau SKU..."
                            class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                  focus:border-emerald-500 focus:ring-0 transition-all">
                    </div>

                    {{-- Category --}}
                    <div>
                        <select name="category" onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                   focus:border-emerald-500 focus:ring-0 transition-all bg-white">
                            <option value="">📁 Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Stock Status --}}
                    <div>
                        <select name="stock_status" onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                   focus:border-emerald-500 focus:ring-0 transition-all bg-white">
                            <option value="">📊 Semua Stok</option>
                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>✅ Stok
                                Tersedia</option>
                            <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>⚠️
                                Stok Menipis</option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                                ❌ Stok Habis</option>
                        </select>
                    </div>

                    {{-- Sort --}}
                    <div class="flex gap-2">
                        <select name="sort"
                            class="flex-1 px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                   focus:border-emerald-500 focus:ring-0 transition-all bg-white">
                            <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>🆕 Terbaru
                            </option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>🔤 Nama A-Z
                            </option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>💰 Harga
                                Rendah</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>💎 Harga
                                Tinggi</option>
                            <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>📉 Stok Rendah
                            </option>
                        </select>
                        <button type="submit"
                            class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl hover:bg-emerald-700 transition-all text-sm">
                            <i class="fas fa-filter"></i>
                        </button>
                        @if (request('category') || request('stock_status') || request('search') || request('sort'))
                            <a href="{{ route('admin.products.index') }}"
                                class="bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl hover:bg-gray-300 transition-all text-sm flex items-center">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk
                        </th>
                        <th
                            class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Kategori</th>
                        <th
                            class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            SKU</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga
                        </th>
                        <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok
                        </th>
                        <th
                            class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                            Status</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            {{-- Product Info --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-box text-gray-300 text-lg"></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-800 truncate text-sm">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-400 md:hidden">{{ $product->category->name }}</p>
                                        <p class="text-[10px] text-gray-400 lg:hidden">{{ $product->sku }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-5 py-4 hidden md:table-cell">
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 rounded-lg text-xs font-medium text-gray-600">
                                    <i class="fas fa-tag text-[10px]"></i>
                                    {{ $product->category->name }}
                                </span>
                            </td>

                            {{-- SKU --}}
                            <td class="px-5 py-4 hidden lg:table-cell">
                                <span class="text-sm font-mono text-gray-500">{{ $product->sku }}</span>
                            </td>

                            {{-- Price --}}
                            <td class="px-5 py-4 text-right">
                                <span class="font-bold text-gray-800 text-sm">{{ $product->formatted_price }}</span>
                            </td>

                            {{-- Stock --}}
                            <td class="px-5 py-4 text-center">
                                <div class="inline-flex flex-col items-center">
                                    <span
                                        class="font-bold text-sm {{ $product->isLowStock() ? 'text-amber-600' : ($product->stock == 0 ? 'text-red-600' : 'text-emerald-600') }}">
                                        {{ $product->stock }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">/ {{ $product->min_stock }}</span>
                                </div>
                            </td>

                            {{-- Status --}}
                            <td class="px-5 py-4 text-center hidden sm:table-cell">
                                @if ($product->is_active)
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-medium">
                                        <i class="fas fa-check-circle text-[10px]"></i>Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-medium">
                                        <i class="fas fa-times-circle text-[10px]"></i>Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-1" x-data="{ open: false }">
                                    {{-- Desktop Actions --}}
                                    <div class="hidden md:flex items-center gap-1">
                                        <a href="{{ route('admin.products.show', $product) }}"
                                            class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                                            title="Detail">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                                            title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button
                                            onclick="openStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})"
                                            class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-all"
                                            title="Update Stok">
                                            <i class="fas fa-boxes text-sm"></i>
                                        </button>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                                title="Hapus">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Mobile Dropdown --}}
                                    <div class="md:hidden relative">
                                        <button @click="open = !open"
                                            class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 transition-all">
                                            <i class="fas fa-ellipsis-v text-sm"></i>
                                        </button>

                                        <div x-show="open" @click.away="open = false" x-transition
                                            class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                                            <a href="{{ route('admin.products.show', $product) }}"
                                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-eye text-blue-500 w-4"></i>Detail
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product) }}"
                                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-edit text-emerald-500 w-4"></i>Edit
                                            </a>
                                            <button
                                                onclick="openStockModal({{ $product->id }}, '{{ $product->name }}', {{ $product->stock }})"
                                                class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors w-full">
                                                <i class="fas fa-boxes text-amber-500 w-4"></i>Update Stok
                                            </button>
                                            <div class="border-t my-1"></div>
                                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors w-full">
                                                    <i class="fas fa-trash w-4"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="max-w-sm mx-auto">
                                    <div
                                        class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-box-open text-gray-300 text-3xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak Ada Produk</h3>
                                    <p class="text-gray-500 text-sm mb-6">
                                        @if (request('search') || request('category') || request('stock_status'))
                                            Tidak ada produk yang sesuai dengan filter.
                                        @else
                                            Belum ada produk. Tambahkan produk pertama Anda!
                                        @endif
                                    </p>
                                    @if (request('search') || request('category') || request('stock_status'))
                                        <a href="{{ route('admin.products.index') }}"
                                            class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium text-sm">
                                            <i class="fas fa-times"></i>Reset Filter
                                        </a>
                                    @else
                                        <a href="{{ route('admin.products.create') }}"
                                            class="inline-flex items-center gap-2 bg-emerald-600 text-white px-5 py-2.5 rounded-xl
                                              hover:bg-emerald-700 transition-all text-sm font-medium">
                                            <i class="fas fa-plus"></i>Tambah Produk
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="px-5 py-4 border-t">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    {{-- Stock Update Modal --}}
    @include('admin.partials.stock-modal')
@endsection
