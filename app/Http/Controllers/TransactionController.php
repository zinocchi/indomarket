<?php
// app/Http/Controllers/TransactionController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display user's transaction history
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $transactions = $user->transactions()
            ->with(['details.product'])
            ->latest('transaction_date')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show transaction details
     */
    public function show($invoiceNumber)
    {
        $transaction = Transaction::with(['details.product.category', 'user'])
            ->where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        // Get products in cart
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)
            ->active()
            ->get()
            ->keyBy('id');

        $cartItems = [];
        $total = 0;
        $errors = [];

        foreach ($cart as $productId => $item) {
            $product = $products[$productId] ?? null;

            if (!$product) {
                $errors[] = "Produk dengan ID {$productId} tidak ditemukan.";
                continue;
            }

            if ($product->stock < $item['quantity']) {
                $errors[] = "Stok {$product->name} tidak mencukupi. Tersedia: {$product->stock}";
                continue;
            }

            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            $cartItems[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'subtotal' => $subtotal,
            ];
        }

        if (!empty($errors)) {
            return redirect()->route('cart.index')
                ->with('error', implode(' ', $errors));
        }

        return view('transactions.checkout', compact('cartItems', 'total'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,debit,credit,qris',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        try {
            DB::beginTransaction();

            // Get products and validate stock
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)
                ->active()
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $totalAmount = 0;
            $details = [];

            foreach ($cart as $productId => $item) {
                $product = $products[$productId] ?? null;

                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan.");
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi.");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $details[] = [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            $paymentAmount = $request->payment_amount;

            if ($paymentAmount < $totalAmount) {
                throw new \Exception("Jumlah pembayaran kurang.");
            }

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'payment_amount' => $paymentAmount,
                'change_amount' => $paymentAmount - $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'notes' => $request->notes,
            ]);

            // Create transaction details
            foreach ($details as $detail) {
                $detail['transaction_id'] = $transaction->id;
                TransactionDetails::create($detail);
            }

            // Clear cart
            session()->forget('cart');

            DB::commit();

            return redirect()->route('transactions.show', $transaction->invoice_number)
                ->with('success', 'Transaksi berhasil! Total: ' . $transaction->formatted_total);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('cart.index')
                ->with('error', 'Transaksi gagal: ' . $e->getMessage());
        }
    }

    /**
     * Print invoice
     */
    public function print($invoiceNumber)
    {
        $transaction = Transaction::with(['details.product', 'user'])
            ->where('invoice_number', $invoiceNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('transactions.print', compact('transaction'));
    }
}
