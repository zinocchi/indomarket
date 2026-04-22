<?php
// database/migrations/2024_01_01_000003_create_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->decimal('total_amount', 12, 2);
            $table->decimal('payment_amount', 12, 2);
            $table->decimal('change_amount', 12, 2);
            $table->enum('payment_method', ['cash', 'debit', 'credit', 'qris'])->default('cash');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('transaction_date');
            $table->timestamps();

            // Indexes
            $table->index(['invoice_number', 'status']);
            $table->index('transaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
