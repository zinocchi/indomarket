<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin IND MARKET',
            'email' => 'admin@indomarket.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0812234567890',
            'address' => 'Jl. Admin No. 1, Jakarta Pusat',
        ]);

        // Regular Users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 123, Jakarta',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '081234567892',
                'address' => 'Jl. Thamrin No. 45, Jakarta',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '081234567893',
                'address' => 'Jl. Gatot Subroto No. 67, Jakarta',
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '081234567894',
                'address' => 'Jl. Kemang Raya No. 89, Jakarta Selatan',
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '081234567895',
                'address' => 'Jl. Cempaka Putih No. 12, Jakarta Pusat',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        echo "✅ Users created: 1 admin + " . count($users) . " users\n";
        echo "   Admin: admin@indomarket.com / password\n";
    }
}
