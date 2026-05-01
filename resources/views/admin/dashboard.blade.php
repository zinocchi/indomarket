{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <span class="text-gray-800 font-medium ml-2">Dashboard</span>
@endsection

@section('content')
    <div class="space-y-6">
        {{-- Welcome Banner --}}
        <div
            class="bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-600 rounded-3xl p-6 lg:p-8 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-300 rounded-full blur-2xl"></div>
            </div>

            <div class="relative flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-emerald-100 mt-1">Kelola toko Anda dengan mudah dan efisien</p>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <i class="fas fa-calendar text-emerald-200"></i>
                    <span>{{ now()->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
            {{-- Total Products --}}
            <div
                class="bg-white rounded-2xl p-5 lg:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                        <i class="fas fa-box text-blue-600 text-lg"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-gray-400 uppercase">Total</span>
                </div>
                <p class="text-3xl font-bold text-gray-800">{{ $stats['total_products'] }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-xs text-gray-500">Aktif: <span
                            class="font-semibold text-emerald-600">{{ $stats['active_products'] }}</span></span>
                </div>
            </div>

            {{-- Low Stock --}}
            <div
                class="bg-white rounded-2xl p-5 lg:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                        <i class="fas fa-exclamation-triangle text-amber-600 text-lg"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-gray-400 uppercase">Alert</span>
                </div>
                <p class="text-3xl font-bold text-amber-600">{{ $stats['low_stock_products'] }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-xs text-gray-500">Habis: <span
                            class="font-semibold text-red-600">{{ $stats['out_of_stock_products'] }}</span></span>
                </div>
            </div>

            {{-- Today's Sales --}}
            <div
                class="bg-white rounded-2xl p-5 lg:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                        <i class="fas fa-wallet text-emerald-600 text-lg"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-gray-400 uppercase">Hari Ini</span>
                </div>
                <p class="text-xl lg:text-3xl font-bold text-gray-800">
                    Rp {{ number_format($salesStats['today']['total'], 0, ',', '.') }}
                </p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-xs text-gray-500">{{ $salesStats['today']['count'] }} transaksi</span>
                </div>
            </div>

            {{-- Monthly Sales --}}
            <div
                class="bg-white rounded-2xl p-5 lg:p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                        <i class="fas fa-chart-line text-purple-600 text-lg"></i>
                    </div>
                    <span class="text-[10px] font-semibold text-gray-400 uppercase">Bulan Ini</span>
                </div>
                <p class="text-xl lg:text-3xl font-bold text-gray-800">
                    Rp {{ number_format($salesStats['this_month']['total'], 0, ',', '.') }}
                </p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="text-xs text-gray-500">{{ $salesStats['this_month']['count'] }} transaksi</span>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <a href="{{ route('admin.products.create') }}"
                class="flex items-center gap-3 bg-white rounded-2xl p-4 shadow-sm border border-gray-100
                  hover:shadow-md hover:border-emerald-200 transition-all group">
                <div
                    class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                    <i class="fas fa-plus text-emerald-600"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Tambah Produk</p>
                    <p class="text-[10px] text-gray-400">Produk baru</p>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center gap-3 bg-white rounded-2xl p-4 shadow-sm border border-gray-100
                  hover:shadow-md hover:border-amber-200 transition-all group">
                <div
                    class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <i class="fas fa-tags text-amber-600"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Kategori</p>
                    <p class="text-[10px] text-gray-400">Kelola</p>
                </div>
            </a>

            <a href="{{ route('admin.transactions.index') }}"
                class="flex items-center gap-3 bg-white rounded-2xl p-4 shadow-sm border border-gray-100
                  hover:shadow-md hover:border-blue-200 transition-all group">
                <div
                    class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                    <i class="fas fa-receipt text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Transaksi</p>
                    <p class="text-[10px] text-gray-400">Lihat semua</p>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 bg-white rounded-2xl p-4 shadow-sm border border-gray-100
                  hover:shadow-md hover:border-purple-200 transition-all group">
                <div
                    class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center group-hover:bg-purple-100 transition-colors">
                    <i class="fas fa-users text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">Pengguna</p>
                    <p class="text-[10px] text-gray-400">Manajemen</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Sales Chart --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800 text-lg">Grafik Penjualan</h3>
                    <span class="text-xs text-gray-400">7 Hari Terakhir</span>
                </div>
                <div class="h-[300px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800 text-lg">Produk Terlaris</h3>
                    <a href="{{ route('admin.products.index') }}"
                        class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua</a>
                </div>

                <div class="space-y-4">
                    @forelse($topProducts as $index => $product)
                        <div class="flex items-center gap-4">
                            <div
                                class="w-8 h-8 bg-{{ $index == 0 ? 'amber' : ($index == 1 ? 'gray' : ($index == 2 ? 'orange' : 'gray')) }}-100
                                    rounded-lg flex items-center justify-center flex-shrink-0">
                                <span
                                    class="text-{{ $index == 0 ? 'amber' : ($index == 1 ? 'gray' : ($index == 2 ? 'orange' : 'gray')) }}-700
                                        text-xs font-bold">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-400">{{ $product->category->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800">{{ $product->total_sold ?? 0 }}</p>
                                <p class="text-[10px] text-gray-400">terjual</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 text-sm py-8">Belum ada data penjualan</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Transactions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 text-lg">Transaksi Terbaru</h3>
                    <a href="{{ route('admin.transactions.index') }}"
                        class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">Lihat Semua</a>
                </div>
                <div class="divide-y">
                    @forelse($recentTransactions as $transaction)
                        <a href="{{ route('admin.transactions.show', $transaction) }}"
                            class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors group">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-{{ $transaction->status == 'completed' ? 'emerald' : ($transaction->status == 'pending' ? 'amber' : 'red') }}-50
                                        rounded-xl flex items-center justify-center">
                                    <i
                                        class="fas fa-{{ $transaction->status == 'completed' ? 'check' : ($transaction->status == 'pending' ? 'clock' : 'times') }}
                                          text-{{ $transaction->status == 'completed' ? 'emerald' : ($transaction->status == 'pending' ? 'amber' : 'red') }}-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ $transaction->invoice_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->user->name }} •
                                        {{ $transaction->transaction_date->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-800">{{ $transaction->formatted_total }}</p>
                                <span
                                    class="text-[10px] px-2 py-0.5 rounded-full font-medium
                                {{ $transaction->status == 'completed'
                                    ? 'bg-emerald-100 text-emerald-700'
                                    : ($transaction->status == 'pending'
                                        ? 'bg-amber-100 text-amber-700'
                                        : 'bg-red-100 text-red-700') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-center text-gray-500 text-sm py-8">Belum ada transaksi</p>
                    @endforelse
                </div>
            </div>

            {{-- Low Stock Alerts --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 text-lg">Stok Menipis</h3>
                    <a href="{{ route('admin.products.index', ['stock_status' => 'low_stock']) }}"
                        class="text-xs text-amber-600 hover:text-amber-700 font-medium">Lihat Semua</a>
                </div>
                <div class="divide-y">
                    @forelse($lowStockProducts as $product)
                        <a href="{{ route('admin.products.show', $product) }}"
                            class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors group">
                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                <div
                                    class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-box text-gray-400"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0 ml-3">
                                <p
                                    class="text-sm font-bold {{ $product->stock == 0 ? 'text-red-600' : 'text-amber-600' }}">
                                    {{ $product->stock }}
                                </p>
                                <p class="text-[10px] text-gray-400">/ {{ $product->min_stock }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-check-circle text-emerald-500 text-2xl"></i>
                            </div>
                            <p class="text-sm text-gray-500">Semua stok aman! 🎉</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Sales Chart
            const ctx = document.getElementById('salesChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($salesChart['labels']) !!},
                    datasets: [{
                        label: 'Total Penjualan',
                        data: {!! json_encode($salesChart['data']) !!},
                        borderColor: '#10b981',
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {
                                ctx,
                                chartArea
                            } = chart;
                            if (!chartArea) return null;
                            const gradient = ctx.createLinearGradient(0, 0, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                            gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');
                            return gradient;
                        },
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            cornerRadius: 12,
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6'
                            },
                            ticks: {
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000) + 'M';
                                    }
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
