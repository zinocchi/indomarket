<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        // Statistics for cards
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'low_stock_products' => Product::lowStock()->count(),
            'out_of_stock_products' => Product::where('stock', 0)->count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'total_transactions' => Transaction::count(),
            'completed_transactions' => Transaction::completed()->count(),
        ];

        // Sales statistics
        $today = now()->startOfDay();
        $thisMonth = now()->startOfMonth();

        $salesStats = [
            'today' => [
                'count' => Transaction::today()->completed()->count(),
                'total' => Transaction::today()->completed()->sum('total_amount'),
            ],
            'this_month' => [
                'count' => Transaction::whereDate('transaction_date', '>=', $thisMonth)
                    ->completed()
                    ->count(),
                'total' => Transaction::whereDate('transaction_date', '>=', $thisMonth)
                    ->completed()
                    ->sum('total_amount'),
            ],
        ];

        // Recent transactions
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Top selling products
        $topProducts = Product::with('category')
            ->select('products.*')
            ->addSelect(DB::raw('(
                SELECT SUM(quantity)
                FROM transaction_details
                WHERE product_id = products.id
            ) as total_sold'))
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Low stock products alert
        $lowStockProducts = Product::with('category')
            ->lowStock()
            ->active()
            ->take(5)
            ->get();

        // Sales chart data (last 7 days)
        $salesChart = $this->getSalesChartData();

        return view('admin.dashboard', compact(
            'stats',
            'salesStats',
            'recentTransactions',
            'topProducts',
            'lowStockProducts',
            'salesChart'
        ));
    }

    /**
     * Get sales chart data
     */
    private function getSalesChartData()
    {
        $dates = [];
        $totals = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dates[] = $date->format('d M');

            $total = Transaction::whereDate('transaction_date', $date)
                ->completed()
                ->sum('total_amount');

            $totals[] = $total;
        }

        return [
            'labels' => $dates,
            'data' => $totals,
        ];
    }
}
