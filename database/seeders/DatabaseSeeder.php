<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        $this->command->info('');

        // Run seeders in order
        $this->command->info('📝 Seeding users...');
        $this->call(UserSeeder::class);
        $this->command->info('');

        $this->command->info('📁 Seeding categories...');
        $this->call(CategorySeeder::class);
        $this->command->info('');

        $this->command->info('📦 Seeding products...');
        $this->call(ProductSeeder::class);
        $this->command->info('');

        $this->command->info('💰 Seeding transactions...');
        $this->call(TransactionSeeder::class);
        $this->command->info('');

        // Summary
        $this->command->info('══════════════════════════════');
        $this->command->info('🎉 Seeding completed!');
        $this->command->info('══════════════════════════════');
        $this->command->info('📊 Summary:');
        $this->command->info('   Users: ' . \App\Models\User::count());
        $this->command->info('   Categories: ' . \App\Models\Category::count());
        $this->command->info('   Products: ' . \App\Models\Product::count());
        $this->command->info('   Transactions: ' . \App\Models\Transaction::count());
        $this->command->info('');
        $this->command->info('🔑 Login Credentials:');
        $this->command->info('   Admin: admin@indomarket.com / password');
        $this->command->info('   User : john@example.com / password');
    }
}
