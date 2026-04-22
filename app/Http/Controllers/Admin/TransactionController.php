<?php
// app/Http/Controllers/Admin/TransactionController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'details.product']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        // Search by invoice number
        if ($request->has('search')) {
            $query->where('invoice_number', 'like', "%{$request->search}%");
        }

        $transactions = $query->latest('transaction_date')
            ->paginate(20)
            ->withQueryString();

        // Calculate summary
        $summary = [
            'total' => $transactions->sum('total_amount'),
            'count' => $transactions->total(),
        ];

        return view('admin.transactions.index', compact('transactions', 'summary'));
    }

    /**
     * Display the specified transaction
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product.category']);

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Update transaction status
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    /**
     * Export transactions report
     */
    public function export(Request $request)
    {
        // Implementation for CSV/Excel export
        // This is a placeholder - you can implement actual export logic
        return back()->with('info', 'Fitur export akan segera hadir.');
    }
}
