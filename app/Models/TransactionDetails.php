<?php
// app/Models/TransactionDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($detail) {
            // Auto-calculate subtotal if not provided
            if (empty($detail->subtotal)) {
                $detail->subtotal = $detail->quantity * $detail->price;
            }
        });

        static::created(function ($detail) {
            // Decrease product stock when transaction detail is created
            $product = $detail->product;
            if ($product) {
                $product->decrement('stock', $detail->quantity);
            }
        });
    }

    /**
     * Get the transaction that owns the detail
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get the product for this detail
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Format price to Rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Format subtotal to Rupiah
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}
