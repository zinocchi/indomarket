{{-- resources/views/admin/transactions/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')

@section('breadcrumb')
    <span class="text-gray-400">/</span>
    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600 transition-colors ml-2">Dashboard</a>
    <span class="text-gray-400 ml-2">/</span>
    <span class="text-gray-800 font-medium ml-2">Transaksi</span>
@endsection

@section('content')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Header --}}
        <div class="p-5 lg:p-6 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Transaksi</h2>
                <p class="text-sm text-gray-500 mt-1">Total: {{ $summary['count'] }} transaksi</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.transactions.export') }}"
                    class="inline-flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl
                      hover:bg-gray-200 transition-all text-sm font-medium">
                    <i class="fas fa-download"></i>Export
                </a>
            </div>
        </div>

        {{-- Filters --}}
        <div class="p-5 lg:p-6 border-b bg-gray-50/50">
            <form action="{{ route('admin.transactions.index') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    {{-- Search Invoice --}}
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari no. invoice..."
                            class="w-full pl-10 pr-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                  focus:border-emerald-500 focus:ring-0 transition-all">
                    </div>

                    {{-- Status --}}
                    <select name="status"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                          focus:border-emerald-500 focus:ring-0 transition-all bg-white">
                        <option value="">Semua Status</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>✅ Completed
                        </option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>❌ Cancelled
                        </option>
                    </select>

                    {{-- Payment Method --}}
                    <select name="payment_method"
                        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl text-sm
                                               focus:border-emerald-500 focus:ring-0 transition-all bg-white">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>💵 Cash</option>
                        <option value="debit" {{ request('payment_method') == 'debit' ? 'selected' : '' }}>💳 Debit
                        </option>
                        <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>📱 QRIS</option>
                    </select>

                    {{-- Actions --}}
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-emerald-600 text-white px-4 py-2.5 rounded-xl hover:bg-emerald-700 transition-all text-sm">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        @if (request('search') || request('status') || request('payment_method'))
                            <a href="{{ route('admin.transactions.index') }}"
                                class="bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl hover:bg-gray-300 transition-all text-sm flex items-center">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="p-5 lg:p-6 border-b bg-gradient-to-r from-emerald-50 to-teal-50">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-xs text-gray-500 uppercase">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $summary['count'] }}</p>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-500 uppercase">Total Nilai</p>
                    <p class="text-xl lg:text-2xl font-bold text-emerald-600 mt-1">
                        Rp {{ number_format($summary['total'], 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice
                        </th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Customer</th>
                        <th
                            class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Tanggal</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Total
                        </th>
                        <th
                            class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                            Metode</th>
                        <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-5 py-4">
                                <span class="font-semibold text-gray-800 text-sm">{{ $transaction->invoice_number }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold text-gray-600">
                                            {{ substr($transaction->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span
                                        class="text-sm text-gray-600 truncate max-w-[120px]">{{ $transaction->user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-500 hidden md:table-cell">
                                {{ $transaction->transaction_date->format('d M Y H:i') }}
                                <span class="block text-xs text-gray-400 md:hidden">
                                    {{ strtoupper($transaction->payment_method) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <span class="font-bold text-gray-800 text-sm">{{ $transaction->formatted_total }}</span>
                            </td>
                            <td class="px-5 py-4 text-center hidden sm:table-cell">
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium
                                       bg-gray-100 text-gray-600">
                                    {{ strtoupper($transaction->payment_method) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if ($transaction->status == 'completed')
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium
                                           bg-emerald-100 text-emerald-700">
                                        <i class="fas fa-check-circle text-[10px]"></i>Selesai
                                    </span>
                                @elseif($transaction->status == 'pending')
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium
                                           bg-amber-100 text-amber-700">
                                        <i class="fas fa-clock text-[10px]"></i>Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium
                                           bg-red-100 text-red-700">
                                        <i class="fas fa-times-circle text-[10px]"></i>Batal
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.transactions.show', $transaction) }}"
                                    class="inline-flex items-center gap-1 text-emerald-600 hover:text-emerald-700 text-sm font-medium
                                      opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-eye"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-16 text-center">
                                <div class="max-w-sm mx-auto">
                                    <div
                                        class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-receipt text-gray-300 text-3xl"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Transaksi</h3>
                                    <p class="text-gray-500 text-sm">Transaksi akan muncul di sini setelah ada pembelian.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($transactions->hasPages())
            <div class="px-5 py-4 border-t">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
@endsection
