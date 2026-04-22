<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show user dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get statistics
        $stats = [
            'total_transactions' => $user->transactions()->count(),
            'total_spent' => $user->total_spent,
            'recent_transactions' => $user->transactions()
                ->with(['details.product'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        // Get featured products
        $featuredProducts = Product::with('category')
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        // Get categories with product count
        $categories = Category::withCount(['products' => function ($query) {
            $query->active()->inStock();
        }])
        ->having('products_count', '>', 0)
        ->take(6)
        ->get();

        return view('dashboard', compact('stats', 'featuredProducts', 'categories'));
    }
}
