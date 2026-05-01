{{-- resources/views/transactions/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-6 lg:py-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center text-sm mb-6 text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-emerald-600 font-medium">Riwayat Transaksi</span>
            </nav>

            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-6">Riwayat Transaksi</h1>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @if ($transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50/50 border-b">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Invoice
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">
                                        Tanggal</th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Total
                                    </th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">
                                        Metode</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($transactions as $transaction)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-semibold text-gray-800">{{ $transaction->invoice_number }}
                                                </p>
                                                <p class="text-xs text-gray-500 md:hidden mt-1">
                                                    {{ $transaction->transaction_date->format('d M Y') }} •
                                                    {{ strtoupper($transaction->payment_method) }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 hidden md:table-cell">
                                            {{ $transaction->transaction_date->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="font-bold text-gray-800">{{ $transaction->formatted_total }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center hidden sm:table-cell">
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                                    bg-gray-100 text-gray-700">
                                                <i
                                                    class="fas fa-{{ $transaction->payment_method == 'cash'
                                                        ? 'money-bill'
                                                        : ($transaction->payment_method == 'qris'
                                                            ? 'qrcode'
                                                            : 'credit-card') }}
                                                      text-[10px]"></i>
                                                {{ strtoupper($transaction->payment_method) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if ($transaction->status == 'completed')
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                                        bg-emerald-100 text-emerald-700">
                                                    <i class="fas fa-check-circle text-[10px]"></i>
                                                    Selesai
                                                </span>
                                            @elseif($transaction->status == 'pending')
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                                        bg-amber-100 text-amber-700">
                                                    <i class="fas fa-clock text-[10px]"></i>
                                                    Pending
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                                        bg-red-100 text-red-700">
                                                    <i class="fas fa-times-circle text-[10px]"></i>
                                                    Batal
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('transactions.show', $transaction->invoice_number) }}"
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center
                                                      text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                                                    title="Detail">
                                                    <i class="fas fa-eye text-sm"></i>
                                                </a>
                                                <a href="{{ route('transactions.print', $transaction->invoice_number) }}"
                                                    target="_blank"
                                                    class="w-8 h-8 rounded-lg flex items-center justify-center
                                                      text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all"
                                                    title="Cetak">
                                                    <i class="fas fa-print text-sm"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-4 border-t">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="p-12 lg:p-16 text-center">
                        <div class="w-24 h-24 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-receipt text-gray-300 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Transaksi</h3>
                        <p class="text-gray-500 mb-8">Anda belum melakukan transaksi apapun.</p>
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center gap-2 bg-emerald-600 text-white px-6 py-3 rounded-xl
                              hover:bg-emerald-700 transition-all shadow-sm hover:shadow-md font-medium">
                            <i class="fas fa-shopping-bag"></i>
                            Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
