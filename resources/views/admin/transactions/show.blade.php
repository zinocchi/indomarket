{{-- resources/views/admin/transactions/show.blade.php --}}
@extends('layouts.admin')

@section('title', 'Detail Transaksi #' . $transaction->invoice_number)

@section('breadcrumb')
    <span class="text-gray-500">/</span>
    <a href="{{ route('admin.transactions.index') }}" class="text-gray-600 hover:text-blue-600 ml-2">Transaksi</a>
    <span class="text-gray-500 ml-2">/</span>
    <span class="text-gray-800 ml-2">{{ $transaction->invoice_number }}</span>
@endsection

@section('content')
<div class="space-y-6">
    {{-- Header Actions --}}
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Detail Transaksi</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.transactions.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Transaction Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="font-semibold text-gray-800">Informasi Transaksi</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">No. Invoice</p>
                            <p class="font-medium text-gray-800">{{ $transaction->invoice_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal</p>
                            <p class="font-medium text-gray-800">{{ $transaction->transaction_date->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Customer</p>
                            <p class="font-medium text-gray-800">{{ $transaction->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST" class="mt-1">
                                @csrf
                                @method('PATCH')
                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="px-3 py-1 border border-gray-300 rounded text-sm">
                                    <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Metode Pembayaran</p>
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $transaction->payment_method_color }}-100 text-{{ $transaction->payment_method_color }}-700">
                                {{ strtoupper($transaction->payment_method) }}
                            </span>
                        </div>
                        @if($transaction->notes)
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Catatan</p>
                                <p class="text-gray-700">{{ $transaction->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Items --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <h3 class="font-semibold text-gray-800">Detail Item ({{ $transaction->total_items }} item)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($transaction->details as $detail)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($detail->product->image)
                                                <img src="{{ asset('storage/' . $detail->product->image) }}"
                                                     alt="{{ $detail->product->name }}"
                                                     class="w-10 h-10 object-cover rounded">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                                    <i class="fas fa-box text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-800">{{ $detail->product->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $detail->product->category->name }} | SKU: {{ $detail->product->sku }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-gray-600">{{ $detail->formatted_price }}</td>
                                    <td class="px-6 py-4 text-center text-gray-800">{{ $detail->quantity }}</td>
                                    <td class="px-6 py-4 text-right font-medium text-gray-800">{{ $detail->formatted_subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-20">
                <h3 class="font-semibold text-gray-800 mb-4">Ringkasan Pembayaran</h3>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Belanja</span>
                        <span class="font-medium text-gray-800">{{ $transaction->formatted_total }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah Bayar</span>
                        <span class="font-medium text-gray-800">{{ $transaction->formatted_payment }}</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-800">Kembalian</span>
                            <span class="text-xl font-bold text-green-600">{{ $transaction->formatted_change }}</span>
                        </div>
                    </div>
                </div>

                {{-- Status Badge --}}
                <div class="mt-6 p-4 rounded-lg {{ $transaction->status == 'completed' ? 'bg-green-50' : ($transaction->status == 'pending' ? 'bg-yellow-50' : 'bg-red-50') }}">
                    <p class="text-sm {{ $transaction->status == 'completed' ? 'text-green-800' : ($transaction->status == 'pending' ? 'text-yellow-800' : 'text-red-800') }}">
                        <i class="fas fa-info-circle mr-2"></i>
                        Status: {{ ucfirst($transaction->status) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
