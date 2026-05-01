{{-- resources/views/transactions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Transaksi #' . $transaction->invoice_number)

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-6 lg:py-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center text-sm mb-6 text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <a href="{{ route('transactions.index') }}" class="hover:text-emerald-600 transition-colors">Riwayat</a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-emerald-600 font-medium">{{ $transaction->invoice_number }}</span>
            </nav>

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Transaksi</h1>
                    <p class="text-gray-500 mt-1">{{ $transaction->invoice_number }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('transactions.print', $transaction->invoice_number) }}" target="_blank"
                        class="inline-flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-700
                          px-4 py-2.5 rounded-xl hover:bg-gray-50 transition-all font-medium text-sm">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                    <a href="{{ route('transactions.index') }}"
                        class="inline-flex items-center gap-2 bg-white border-2 border-gray-200 text-gray-700
                          px-4 py-2.5 rounded-xl hover:bg-gray-50 transition-all font-medium text-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Transaction Info --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-info-circle text-emerald-500"></i>
                                Informasi Transaksi
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase mb-1">No. Invoice</p>
                                    <p class="font-semibold text-gray-800">{{ $transaction->invoice_number }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase mb-1">Tanggal</p>
                                    <p class="font-semibold text-gray-800">
                                        {{ $transaction->transaction_date->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase mb-1">Status</p>
                                    @if ($transaction->status == 'completed')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium
                                                bg-emerald-100 text-emerald-700">
                                            <i class="fas fa-check-circle"></i> Selesai
                                        </span>
                                    @elseif($transaction->status == 'pending')
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium
                                                bg-amber-100 text-amber-700">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium
                                                bg-red-100 text-red-700">
                                            <i class="fas fa-times-circle"></i> Batal
                                        </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase mb-1">Metode Bayar</p>
                                    <p class="font-semibold text-gray-800">{{ strtoupper($transaction->payment_method) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase mb-1">Total Item</p>
                                    <p class="font-semibold text-gray-800">{{ $transaction->total_items }} item</p>
                                </div>
                                @if ($transaction->notes)
                                    <div class="col-span-2">
                                        <p class="text-xs text-gray-500 uppercase mb-1">Catatan</p>
                                        <p class="text-gray-700">{{ $transaction->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Items --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-list text-emerald-500"></i>
                                Detail Item
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach ($transaction->details as $detail)
                                    <div class="flex items-center gap-4 pb-4 border-b last:border-b-0 last:pb-0">
                                        <div
                                            class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                            @if ($detail->product->image)
                                                <img src="{{ asset('storage/' . $detail->product->image) }}"
                                                    alt="{{ $detail->product->name }}"
                                                    class="w-full h-full object-cover rounded-xl">
                                            @else
                                                <i class="fas fa-box text-gray-300 text-lg"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-gray-800">{{ $detail->product->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $detail->product->category->name }}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-sm text-gray-500">{{ $detail->quantity }} x
                                                {{ $detail->formatted_price }}</p>
                                            <p class="font-bold text-gray-800">{{ $detail->formatted_subtotal }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Payment Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="font-bold text-gray-800 text-lg mb-6 flex items-center gap-2">
                            <i class="fas fa-calculator text-emerald-500"></i>
                            Ringkasan
                        </h3>

                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Total Belanja</span>
                                <span class="font-semibold text-gray-800">{{ $transaction->formatted_total }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Jumlah Bayar</span>
                                <span class="font-semibold text-gray-800">{{ $transaction->formatted_payment }}</span>
                            </div>

                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-gray-800">Kembalian</span>
                                    <span
                                        class="text-2xl font-bold text-emerald-600">{{ $transaction->formatted_change }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-emerald-50 rounded-xl">
                            <p class="text-sm text-emerald-800 flex items-start gap-2">
                                <i class="fas fa-check-circle mt-0.5"></i>
                                <span>Terima kasih telah berbelanja di Indomarket!</span>
                            </p>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="mt-6 space-y-2">
                            <a href="{{ route('transactions.print', $transaction->invoice_number) }}" target="_blank"
                                class="block w-full text-center bg-white border-2 border-gray-200 text-gray-700
                                  px-4 py-3 rounded-xl hover:bg-gray-50 transition-all font-medium text-sm">
                                <i class="fas fa-print mr-2"></i>Cetak Struk
                            </a>
                            <a href="{{ route('products.index') }}"
                                class="block w-full text-center bg-emerald-600 text-white px-4 py-3 rounded-xl
                                  hover:bg-emerald-700 transition-all font-medium text-sm">
                                <i class="fas fa-shopping-bag mr-2"></i>Belanja Lagi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
