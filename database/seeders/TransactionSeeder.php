<?php
// database/seeders/TransactionSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();
        $paymentMethods = ['cash', 'cash', 'cash', 'debit', 'qris'];
        $statuses = ['completed', 'completed', 'completed', 'completed', 'completed', 'pending', 'cancelled'];

        // Create 50 sample transactions
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

            $transactionDate = now()->subDays(rand(0, 30))->subHours(rand(0, 12))->subMinutes(rand(0, 59));

            // Select random 1-6 products
            $itemCount = rand(1, 6);
            $selectedProducts = $products->random($itemCount);
            $totalAmount = 0;
            $details = [];

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 4);
                $price = $product->price;
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;

                $details[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }

            // Payment amount
            $paymentAmount = ceil($totalAmount / 1000) * 1000 + (rand(0, 5) * 1000);
            if ($paymentMethod !== 'cash') {
                $paymentAmount = $totalAmount;
            }

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'total_amount' => $totalAmount,
                'payment_amount' => $paymentAmount,
                'change_amount' => $paymentAmount - $totalAmount,
                'payment_method' => $paymentMethod,
                'status' => $status,
                'notes' => rand(0, 3) === 0 ? 'Pembelian kebutuhan sehari-hari' : null,
                'transaction_date' => $transactionDate,
                'created_at' => $transactionDate,
                'updated_at' => $transactionDate,
            ]);

            // Create transaction details
            foreach ($details as $detail) {
                $detail['transaction_id'] = $transaction->id;
                TransactionDetails::create($detail);
            }
        }

        echo "✅ 50 sample transactions created\n";
    }
}
