<?php
// database/migrations/2024_01_01_000004_create_transaction_details_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 12, 2); // Harga saat transaksi
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            // Indexes
            $table->index(['transaction_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
