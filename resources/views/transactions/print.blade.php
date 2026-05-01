{{-- resources/views/transactions/print.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->invoice_number }}</title>

    {{-- Google Fonts - Inter + Courier Prime untuk tampilan struk --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Source+Code+Pro:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #059669;
            --primary-dark: #047857;
            --accent: #f59e0b;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-600: #4b5563;
            --gray-800: #1f2937;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Source Code Pro', monospace;
            background: #f9fafb;
            display: flex;
            justify-content: center;
            padding: 20px;
            min-height: 100vh;
        }

        .receipt-container {
            width: 100%;
            max-width: 380px;
        }

        .receipt {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        /* Header */
        .receipt-header {
            background: linear-gradient(135deg, #059669, #047857);
            padding: 28px 24px 24px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .receipt-header::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .receipt-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .receipt-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .receipt-logo-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .receipt-logo-text {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .receipt-logo-text span {
            color: #fbbf24;
        }

        .receipt-store-info {
            font-size: 11px;
            opacity: 0.85;
            margin-top: 6px;
            line-height: 1.5;
            position: relative;
            z-index: 1;
        }

        /* Divider bergerigi */
        .receipt-divider {
            height: 16px;
            background: white;
            position: relative;
            overflow: hidden;
        }

        .receipt-divider::before {
            content: '';
            position: absolute;
            top: 0;
            left: -10px;
            right: -10px;
            height: 100%;
            background: radial-gradient(circle at 50% 0%, transparent 8px, #059669 8px);
            background-size: 20px 20px;
            background-position: 0 0;
        }

        /* Body */
        .receipt-body {
            padding: 20px 24px;
        }

        /* Info Section */
        .receipt-info {
            background: #f9fafb;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            font-size: 12px;
        }

        .receipt-info-label {
            color: #6b7280;
            font-weight: 500;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .receipt-info-value {
            color: #1f2937;
            font-weight: 600;
            font-size: 12px;
        }

        .receipt-info-divider {
            border-top: 1px dashed #e5e7eb;
            margin: 8px 0;
        }

        /* Items */
        .receipt-items-header {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
            gap: 12px;
        }

        .receipt-item:last-child {
            border-bottom: none;
        }

        .receipt-item-left {
            flex: 1;
            min-width: 0;
        }

        .receipt-item-name {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.3;
            margin-bottom: 2px;
        }

        .receipt-item-meta {
            font-size: 10.5px;
            color: #9ca3af;
        }

        .receipt-item-right {
            text-align: right;
            flex-shrink: 0;
        }

        .receipt-item-qty {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .receipt-item-price {
            font-size: 13px;
            font-weight: 700;
            color: #1f2937;
        }

        /* Total Section */
        .receipt-total-section {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #1f2937;
        }

        .receipt-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
            font-size: 12px;
        }

        .receipt-total-row.main {
            font-size: 16px;
            font-weight: 800;
            padding: 8px 0;
            color: #059669;
        }

        .receipt-total-label {
            color: #6b7280;
            font-weight: 500;
        }

        .receipt-total-label.main {
            color: #1f2937;
            font-weight: 700;
        }

        .receipt-total-value {
            color: #1f2937;
            font-weight: 600;
        }

        .receipt-total-value.main {
            color: #059669;
            font-size: 18px;
        }

        /* Payment Info */
        .receipt-payment {
            background: #f0fdf4;
            border: 1.5px solid #d1fae5;
            border-radius: 12px;
            padding: 14px 16px;
            margin-top: 16px;
        }

        .receipt-payment-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 3px 0;
            font-size: 12px;
        }

        .receipt-payment-change {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px dashed #d1fae5;
            font-size: 15px;
            font-weight: 700;
            color: #059669;
        }

        /* Footer */
        .receipt-footer {
            background: #f9fafb;
            padding: 20px 24px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }

        .receipt-footer-thanks {
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .receipt-footer-text {
            font-size: 10px;
            color: #9ca3af;
            line-height: 1.6;
        }

        .receipt-barcode {
            margin-top: 16px;
            font-family: 'Source Code Pro', monospace;
            font-size: 11px;
            color: #6b7280;
            letter-spacing: 2px;
        }

        /* Status Badge */
        .receipt-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 8px;
        }

        .receipt-status.completed {
            background: #d1fae5;
            color: #065f46;
        }

        .receipt-status.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .receipt-status.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Promo Banner */
        .receipt-promo {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 20px;
            text-align: center;
        }

        .receipt-promo-text {
            font-size: 11px;
            font-weight: 600;
            color: #92400e;
        }

        .receipt-promo-highlight {
            font-size: 13px;
            font-weight: 800;
            color: #d97706;
            display: block;
            margin-top: 2px;
        }

        /* Print Button */
        .print-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px;
            background: #059669;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
        }

        .print-btn:hover {
            background: #047857;
            box-shadow: 0 4px 16px rgba(5, 150, 105, 0.4);
            transform: translateY(-1px);
        }

        .close-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px;
            background: white;
            color: #6b7280;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            margin-top: 8px;
        }

        .close-btn:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .receipt {
                box-shadow: none;
                border-radius: 0;
                margin-bottom: 0;
                max-width: 100%;
            }

            .receipt-container {
                max-width: 100%;
            }

            .no-print {
                display: none !important;
            }

            @page {
                margin: 0;
                size: 80mm auto;
            }
        }

        @media (max-width: 380px) {
            .receipt-body {
                padding: 16px;
            }

            .receipt-header {
                padding: 20px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        {{-- Struk --}}
        <div class="receipt">
            {{-- Header --}}
            <div class="receipt-header">
                <div class="receipt-logo">
                    <div class="receipt-logo-icon">🏪</div>
                    <div class="receipt-logo-text">Indo<span>market</span></div>
                </div>
                <div class="receipt-store-info">
                    Jl. Pahlawan No. 123, Kec. Sukamaju<br>
                    Jakarta Pusat • Telp: (021) 1234-5678<br>
                    NPWP: 12.345.678.9-012.000
                </div>
            </div>

            {{-- Divider --}}
            <div class="receipt-divider"></div>

            {{-- Body --}}
            <div class="receipt-body">
                {{-- Promo Info --}}
                @if($transaction->total_amount >= 50000)
                    <div class="receipt-promo">
                        <span class="receipt-promo-text">🎉 Selamat! Anda mendapat</span>
                        <span class="receipt-promo-highlight">GRATIS ONGKOS KIRIM</span>
                    </div>
                @endif

                {{-- Transaction Info --}}
                <div class="receipt-info">
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">No. Invoice</span>
                        <span class="receipt-info-value">{{ $transaction->invoice_number }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Tanggal</span>
                        <span class="receipt-info-value">{{ $transaction->transaction_date->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Kasir</span>
                        <span class="receipt-info-value">{{ $transaction->user->name }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Metode</span>
                        <span class="receipt-info-value">{{ strtoupper($transaction->payment_method) }}</span>
                    </div>
                    <div class="receipt-info-divider"></div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Status</span>
                        <span class="receipt-status {{ $transaction->status }}">
                            @if($transaction->status == 'completed')
                                ✅ SELESAI
                            @elseif($transaction->status == 'pending')
                                ⏳ PENDING
                            @else
                                ❌ BATAL
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Items --}}
                <div class="receipt-items-header">Detail Pembelian</div>

                @foreach($transaction->details as $detail)
                    <div class="receipt-item">
                        <div class="receipt-item-left">
                            <div class="receipt-item-name">{{ $detail->product->name }}</div>
                            <div class="receipt-item-meta">
                                {{ $detail->product->category->name }}
                                @if($detail->product->sku)
                                    • {{ $detail->product->sku }}
                                @endif
                            </div>
                        </div>
                        <div class="receipt-item-right">
                            <div class="receipt-item-qty">{{ $detail->quantity }} × Rp {{ number_format($detail->price, 0, ',', '.') }}</div>
                            <div class="receipt-item-price">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @endforeach

                {{-- Total --}}
                <div class="receipt-total-section">
                    <div class="receipt-total-row">
                        <span class="receipt-total-label">Total Item</span>
                        <span class="receipt-total-value">{{ $transaction->total_items }} item</span>
                    </div>
                    <div class="receipt-total-row">
                        <span class="receipt-total-label">Subtotal</span>
                        <span class="receipt-total-value">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="receipt-total-row main">
                        <span class="receipt-total-label main">TOTAL</span>
                        <span class="receipt-total-value main">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="receipt-payment">
                    <div class="receipt-payment-row">
                        <span>Tunai</span>
                        <span style="font-weight: 600;">Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="receipt-payment-change">
                        <div class="receipt-payment-row">
                            <span style="font-weight: 700;">KEMBALI</span>
                            <span style="font-weight: 800; font-size: 16px;">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Notes --}}
                @if($transaction->notes)
                    <div style="margin-top: 12px; padding: 10px 12px; background: #fff7ed; border-radius: 8px; font-size: 11px; color: #9a3412;">
                        <strong>Catatan:</strong> {{ $transaction->notes }}
                    </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="receipt-footer">
                <div class="receipt-footer-thanks">✨ Terima Kasih ✨</div>
                <div class="receipt-footer-text">
                    Barang yang sudah dibeli tidak dapat<br>
                    ditukar atau dikembalikan.<br>
                    Simpan struk ini sebagai bukti pembayaran.
                </div>
                <div class="receipt-barcode">
                    *{{ $transaction->invoice_number }}*
                </div>
                <div style="margin-top: 8px; font-size: 9px; color: #d1d5db;">
                    Dicetak: {{ now()->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="no-print" style="display: flex; flex-direction: column; gap: 8px;">
            <button onclick="window.print()" class="print-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8"/>
                </svg>
                Cetak Struk
            </button>

            <button onclick="window.close()" class="close-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
                Tutup
            </button>
        </div>
    </div>

    {{-- Auto-print (optional, bisa dihilangkan jika tidak ingin auto-print) --}}
    {{-- <script>window.onload = function() { window.print(); }</script> --}}
</body>
</html> 
