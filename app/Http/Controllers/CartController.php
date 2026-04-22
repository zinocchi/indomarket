<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart contents
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)
                ->active()
                ->get()
                ->keyBy('id');

            foreach ($cart as $productId => $item) {
                $product = $products[$productId] ?? null;

                if ($product) {
                    $subtotal = $product->price * $item['quantity'];
                    $total += $subtotal;

                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal,
                    ];
                }
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active || $product->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak tersedia.'
            ], 400);
        }

        $cart = session()->get('cart', []);

        $productId = $product->id;

        if (isset($cart[$productId])) {
            $newQuantity = $cart[$productId]['quantity'] + $request->quantity;

            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Tersedia: ' . $product->stock
                ], 400);
            }

            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            if ($request->quantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Tersedia: ' . $product->stock
                ], 400);
            }

            $cart[$productId] = [
                'quantity' => $request->quantity,
                'added_at' => now()->toDateTimeString(),
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang.'
            ], 404);
        }

        if ($request->quantity == 0) {
            unset($cart[$productId]);
            $message = 'Produk dihapus dari keranjang.';
        } else {
            if ($request->quantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Tersedia: ' . $product->stock
                ], 400);
            }

            $cart[$productId]['quantity'] = $request->quantity;
            $message = 'Jumlah produk diperbarui.';
        }

        session()->put('cart', $cart);

        // Calculate new totals
        $cartItems = [];
        $total = 0;

        if (!empty($cart)) {
            $productIds = array_keys($cart);
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            foreach ($cart as $id => $item) {
                if (isset($products[$id])) {
                    $subtotal = $products[$id]->price * $item['quantity'];
                    $total += $subtotal;

                    $cartItems[] = [
                        'product_id' => $id,
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal,
                        'formatted_subtotal' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
                    ];
                }
            }
        }

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $cartCount,
            'total' => $total,
            'formatted_total' => 'Rp ' . number_format($total, 0, ',', '.'),
            'items' => $cartItems,
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        $cartCount = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang.',
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang belanja telah dikosongkan.');
    }

    /**
     * Get cart count
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }
}
