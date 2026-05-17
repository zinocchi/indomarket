{{-- resources/views/transactions/checkout.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 py-6 lg:py-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center text-sm mb-6 text-gray-500">
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition-colors">
                    <i class="fas fa-home mr-1"></i> Beranda
                </a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <a href="{{ route('cart.index') }}" class="hover:text-emerald-600 transition-colors">Keranjang</a>
                <i class="fas fa-chevron-right mx-2 text-[10px]"></i>
                <span class="text-emerald-600 font-medium">Checkout</span>
            </nav>

            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-6">Checkout</h1>

            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Main Form --}}
                <div class="flex-1">
                    <form action="{{ route('transactions.process') }}" method="POST" id="checkoutForm">
                        @csrf

                        {{-- Payment Method --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                                <i class="fas fa-wallet text-emerald-500"></i>
                                Metode Pembayaran
                            </h3>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="cash" checked class="sr-only peer">
                                    <div
                                        class="border-2 border-gray-200 rounded-2xl p-4 text-center peer-checked:border-emerald-500
                                            peer-checked:bg-emerald-50 hover:border-gray-300 transition-all">
                                        <div
                                            class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2
                                                peer-checked:bg-emerald-100">
                                            <i
                                                class="fas fa-money-bill-wave text-gray-500 peer-checked:text-emerald-600 text-xl"></i>
                                        </div>
                                        <p class="font-medium text-gray-800 text-sm">Tunai</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="debit" class="sr-only peer">
                                    <div
                                        class="border-2 border-gray-200 rounded-2xl p-4 text-center peer-checked:border-emerald-500
                                            peer-checked:bg-emerald-50 hover:border-gray-300 transition-all">
                                        <div
                                            class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2
                                                peer-checked:bg-emerald-100">
                                            <i
                                                class="fas fa-credit-card text-gray-500 peer-checked:text-emerald-600 text-xl"></i>
                                        </div>
                                        <p class="font-medium text-gray-800 text-sm">Debit</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="qris" class="sr-only peer">
                                    <div
                                        class="border-2 border-gray-200 rounded-2xl p-4 text-center peer-checked:border-emerald-500
                                            peer-checked:bg-emerald-50 hover:border-gray-300 transition-all">
                                        <div
                                            class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2
                                                peer-checked:bg-emerald-100">
                                            <i
                                                class="fas fa-qrcode text-gray-500 peer-checked:text-emerald-600 text-xl"></i>
                                        </div>
                                        <p class="font-medium text-gray-800 text-sm">QRIS</p>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="credit" class="sr-only peer">
                                    <div
                                        class="border-2 border-gray-200 rounded-2xl p-4 text-center peer-checked:border-emerald-500
                                            peer-checked:bg-emerald-50 hover:border-gray-300 transition-all">
                                        <div
                                            class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2
                                                peer-checked:bg-emerald-100">
                                            <i
                                                class="fas fa-building-columns text-gray-500 peer-checked:text-emerald-600 text-xl"></i>
                                        </div>
                                        <p class="font-medium text-gray-800 text-sm">Kredit</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Payment Details --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                                <i class="fas fa-calculator text-emerald-500"></i>
                                Detail Pembayaran
                            </h3>

                            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Total Belanja</span>
                                    <span class="text-2xl font-bold text-gray-800">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jumlah Bayar
                                    </label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                                        <input type="number" name="payment_amount" id="payment_amount"
                                            min="{{ $total }}" step="1000" value="{{ $total }}" required
                                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-xl
                                                  focus:border-emerald-500 focus:ring-0 text-lg font-semibold
                                                  transition-all">
                                    </div>
                                </div>

                                <div class="bg-emerald-50 rounded-xl p-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-emerald-700 font-medium">Kembalian</span>
                                        <span id="change_amount" class="text-xl font-bold text-emerald-600">Rp 0</span>
                                    </div>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Catatan (Opsional)
                                    </label>
                                    <textarea name="notes" id="notes" rows="2" placeholder="Tambahkan catatan untuk pesanan ini..."
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl
                                                 focus:border-emerald-500 focus:ring-0 transition-all resize-none"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Order Summary Sidebar --}}
                <div class="lg:w-96">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                        <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                            <i class="fas fa-receipt text-emerald-500"></i>
                            Detail Pesanan
                        </h3>

                        <div class="space-y-3 mb-4 max-h-80 overflow-y-auto">
                            @foreach ($cartItems as $item)
                                <div class="flex items-center gap-3 pb-3 border-b last:border-b-0">
                                    <div
                                        class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                        @if ($item['product']->image)
                                            <img src="{{ asset('storage/' . $item['product']->image) }}"
                                                alt="{{ $item['product']->name }}"
                                                class="w-full h-full object-cover rounded-xl">
                                        @else
                                            <i class="fas fa-box text-gray-300"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $item['product']->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-sm font-semibold text-gray-800 flex-shrink-0">
                                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-800">Total</span>
                                <span class="text-emerald-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-6 space-y-3">
                            <button type="submit" form="checkoutForm"
                                class="w-full bg-gradient-to-r from-green-500 to-green-500 text-white px-6 py-4
                                       rounded-2xl font-semibold hover:from-green-500 hover:to-green-500
                                       transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                                <i class="fas fa-check-circle mr-2"></i>Proses Pembayaran
                            </button>

                            <a href="{{ route('cart.index') }}"
                                class="block w-full text-center text-gray-600 hover:text-gray-800 py-2 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const totalAmount = {{ $total }};
            const paymentInput = document.getElementById('payment_amount');
            const changeElement = document.getElementById('change_amount');

            function calculateChange() {
                const payment = parseFloat(paymentInput.value) || 0;
                const change = payment - totalAmount;

                if (change >= 0) {
                    changeElement.textContent = 'Rp ' + change.toLocaleString('id-ID');
                    changeElement.parentElement.className = 'bg-emerald-50 rounded-xl p-4';
                    changeElement.className = 'text-xl font-bold text-emerald-600';
                } else {
                    changeElement.textContent = 'Rp ' + change.toLocaleString('id-ID') + ' (Kurang)';
                    changeElement.parentElement.className = 'bg-red-50 rounded-xl p-4';
                    changeElement.className = 'text-xl font-bold text-red-600';
                }
            }

            paymentInput.addEventListener('input', calculateChange);
            calculateChange();
        </script>
    @endpush
@endsection
