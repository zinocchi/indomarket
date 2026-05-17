<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetails;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        $this->command->info('📝 Creating admin user...');
        $admin = User::create([
            'name' => 'Admin Indomarket',
            'email' => 'admin@indomarket.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0812234567890',
            'address' => 'Jl. Admin No. 1, Jakarta Pusat',
        ]);
        $this->command->info('✅ Admin created: admin@indomarket.com / password');

        // Create regular users
        $this->command->info('📝 Creating regular users...');
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
        ];

        $createdUsers = [];
        foreach ($users as $userData) {
            $createdUsers[] = User::create($userData);
        }
        $this->command->info('✅ ' . count($createdUsers) . ' regular users created');

        // Create categories
        $this->command->info('📁 Creating categories...');
        $categories = [
            [
                'name' => 'Makanan Ringan',
                'slug' => 'makanan-ringan',
                'description' => 'Aneka snack, keripik, biskuit, dan makanan ringan lainnya',
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'description' => 'Minuman dingin, minuman panas, jus, soda, dan air mineral',
            ],
            [
                'name' => 'Kebutuhan Pokok',
                'slug' => 'kebutuhan-pokok',
                'description' => 'Beras, gula, minyak goreng, tepung, dan bahan pokok lainnya',
            ],
            [
                'name' => 'Perlengkapan Mandi',
                'slug' => 'perlengkapan-mandi',
                'description' => 'Sabun, sampo, pasta gigi, sikat gigi, dan perlengkapan mandi',
            ],
            [
                'name' => 'Alat Tulis',
                'slug' => 'alat-tulis',
                'description' => 'Buku, pulpen, pensil, penghapus, dan alat tulis lainnya',
            ],
            [
                'name' => 'Produk Kebersihan',
                'slug' => 'produk-kebersihan',
                'description' => 'Deterjen, pembersih lantai, sabun cuci, dan produk kebersihan',
            ],
            [
                'name' => 'Makanan Instan',
                'slug' => 'makanan-instan',
                'description' => 'Mie instan, bubur instan, makanan kaleng, dan makanan siap saji',
            ],
            [
                'name' => 'Bumbu Dapur',
                'slug' => 'bumbu-dapur',
                'description' => 'Kecap, saus, bumbu instan, penyedap rasa, dan bumbu masak',
            ],
        ];

        $createdCategories = [];
        foreach ($categories as $catData) {
            $createdCategories[] = Category::create($catData);
        }
        $this->command->info('✅ ' . count($createdCategories) . ' categories created');

        // Create products
        $this->command->info('📦 Creating products...');
        $productsData = $this->getProductsData();

        $createdProducts = [];
        foreach ($productsData as $productData) {
            $productData['slug'] = Str::slug($productData['name']);
            $productData['sku'] = $this->generateSKU($productData['category_id']);
            $productData['image'] = null;
            $productData['is_active'] = true;

            $createdProducts[] = Product::create($productData);
        }
        $this->command->info('✅ ' . count($createdProducts) . ' products created');

        // Create sample transactions
        $this->command->info('💰 Creating sample transactions...');
        $this->createSampleTransactions($createdUsers, $createdProducts);

        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Users: ' . User::count());
        $this->command->info('   - Categories: ' . Category::count());
        $this->command->info('   - Products: ' . Product::count());
        $this->command->info('   - Transactions: ' . Transaction::count());
    }

    private function generateSKU($categoryId): string
    {
        $prefix = match ($categoryId) {
            1 => 'SNACK',
            2 => 'DRINK',
            3 => 'POKOK',
            4 => 'MANDI',
            5 => 'ATK',
            6 => 'CLEAN',
            7 => 'INSTAN',
            8 => 'BUMBU',
            default => 'PRD',
        };

        return $prefix . '-' . strtoupper(Str::random(6));
    }

    private function getProductsData(): array
    {
        return [
            // Makanan Ringan (Category 1)
            ['category_id' => 1, 'name' => 'Chitato Sapi Panggang 60g', 'price' => 15000, 'stock' => 45, 'min_stock' => 10, 'description' => 'Keripik kentang rasa sapi panggang'],
            ['category_id' => 1, 'name' => 'Oreo Original 133g', 'price' => 10000, 'stock' => 60, 'min_stock' => 15, 'description' => 'Biskuit sandwich dengan krim vanilla'],
            ['category_id' => 1, 'name' => 'Tango Wafer Vanilla 130g', 'price' => 8000, 'stock' => 35, 'min_stock' => 10, 'description' => 'Wafer renyah dengan krim vanilla'],
            ['category_id' => 1, 'name' => 'Lays Rumput Laut 68g', 'price' => 14000, 'stock' => 40, 'min_stock' => 10, 'description' => 'Keripik kentang rasa rumput laut'],
            ['category_id' => 1, 'name' => 'Qtela Singkong Balado 80g', 'price' => 9000, 'stock' => 50, 'min_stock' => 10, 'description' => 'Keripik singkong rasa balado'],
            ['category_id' => 1, 'name' => 'Pringles Original 110g', 'price' => 25000, 'stock' => 25, 'min_stock' => 5, 'description' => 'Keripik kentang premium rasa original'],
            ['category_id' => 1, 'name' => 'Nabati Wafer Coklat 50g', 'price' => 3000, 'stock' => 100, 'min_stock' => 20, 'description' => 'Wafer renyah dengan krim coklat'],
            ['category_id' => 1, 'name' => 'Good Time Chocochip 80g', 'price' => 12000, 'stock' => 30, 'min_stock' => 8, 'description' => 'Cookies dengan choco chip'],

            // Minuman (Category 2)
            ['category_id' => 2, 'name' => 'Coca Cola 390ml', 'price' => 8000, 'stock' => 120, 'min_stock' => 20, 'description' => 'Minuman bersoda rasa cola'],
            ['category_id' => 2, 'name' => 'Aqua 600ml', 'price' => 4000, 'stock' => 200, 'min_stock' => 30, 'description' => 'Air mineral'],
            ['category_id' => 2, 'name' => 'Teh Botol Sosro 450ml', 'price' => 6000, 'stock' => 85, 'min_stock' => 15, 'description' => 'Minuman teh dalam kemasan botol'],
            ['category_id' => 2, 'name' => 'Sprite 390ml', 'price' => 8000, 'stock' => 95, 'min_stock' => 15, 'description' => 'Minuman bersoda rasa lemon'],
            ['category_id' => 2, 'name' => 'Fanta 390ml', 'price' => 8000, 'stock' => 90, 'min_stock' => 15, 'description' => 'Minuman bersoda rasa stroberi'],
            ['category_id' => 2, 'name' => 'Pocari Sweat 500ml', 'price' => 10000, 'stock' => 70, 'min_stock' => 12, 'description' => 'Minuman isotonik'],
            ['category_id' => 2, 'name' => 'Kopi Kapal Api 25g', 'price' => 2500, 'stock' => 150, 'min_stock' => 25, 'description' => 'Kopi bubuk sachet'],
            ['category_id' => 2, 'name' => 'Nutrisari Jeruk 15g', 'price' => 2000, 'stock' => 180, 'min_stock' => 30, 'description' => 'Minuman serbuk rasa jeruk'],
            ['category_id' => 2, 'name' => 'Susu Ultra Milk 250ml', 'price' => 7000, 'stock' => 55, 'min_stock' => 10, 'description' => 'Susu UHT full cream'],
            ['category_id' => 2, 'name' => 'Milo Active Go 22g', 'price' => 3500, 'stock' => 140, 'min_stock' => 20, 'description' => 'Minuman coklat malt sachet'],

            // Kebutuhan Pokok (Category 3)
            ['category_id' => 3, 'name' => 'Beras Premium 5kg', 'price' => 75000, 'stock' => 40, 'min_stock' => 8, 'description' => 'Beras kualitas premium'],
            ['category_id' => 3, 'name' => 'Gula Pasir 1kg', 'price' => 16000, 'stock' => 80, 'min_stock' => 15, 'description' => 'Gula pasir putih premium'],
            ['category_id' => 3, 'name' => 'Minyak Goreng Bimoli 2L', 'price' => 42000, 'stock' => 35, 'min_stock' => 8, 'description' => 'Minyak goreng kemasan 2 liter'],
            ['category_id' => 3, 'name' => 'Tepung Terigu Segitiga Biru 1kg', 'price' => 14000, 'stock' => 50, 'min_stock' => 10, 'description' => 'Tepung terigu serbaguna'],
            ['category_id' => 3, 'name' => 'Telur Ayam 1kg', 'price' => 28000, 'stock' => 30, 'min_stock' => 5, 'description' => 'Telur ayam negeri segar'],
            ['category_id' => 3, 'name' => 'Garam Dapur 500g', 'price' => 6000, 'stock' => 100, 'min_stock' => 20, 'description' => 'Garam beryodium'],
            ['category_id' => 3, 'name' => 'Beras Ramos 5kg', 'price' => 65000, 'stock' => 35, 'min_stock' => 8, 'description' => 'Beras ramos pulen'],

            // Perlengkapan Mandi (Category 4)
            ['category_id' => 4, 'name' => 'Sabun Mandi Lifebuoy 100g', 'price' => 5000, 'stock' => 120, 'min_stock' => 20, 'description' => 'Sabun mandi kesehatan'],
            ['category_id' => 4, 'name' => 'Sampo Sunsilk 170ml', 'price' => 18000, 'stock' => 45, 'min_stock' => 10, 'description' => 'Sampo untuk rambut sehat'],
            ['category_id' => 4, 'name' => 'Pasta Gigi Pepsodent 190g', 'price' => 22000, 'stock' => 55, 'min_stock' => 10, 'description' => 'Pasta gigi dengan fluoride'],
            ['category_id' => 4, 'name' => 'Sikat Gigi Formula', 'price' => 12000, 'stock' => 80, 'min_stock' => 15, 'description' => 'Sikat gigi berkualitas'],
            ['category_id' => 4, 'name' => 'Sabun Cuci Muka Garnier 100ml', 'price' => 25000, 'stock' => 30, 'min_stock' => 8, 'description' => 'Pembersih wajah'],
            ['category_id' => 4, 'name' => 'Deodorant Rexona 50ml', 'price' => 20000, 'stock' => 60, 'min_stock' => 12, 'description' => 'Deodorant roll-on'],

            // Alat Tulis (Category 5)
            ['category_id' => 5, 'name' => 'Buku Tulis Sidu 38 Lembar', 'price' => 5000, 'stock' => 200, 'min_stock' => 30, 'description' => 'Buku tulis bergaris'],
            ['category_id' => 5, 'name' => 'Pulpen Standard AE7', 'price' => 3000, 'stock' => 300, 'min_stock' => 50, 'description' => 'Pulpen tinta biru/hitam'],
            ['category_id' => 5, 'name' => 'Pensil 2B Faber Castell', 'price' => 4000, 'stock' => 150, 'min_stock' => 25, 'description' => 'Pensil untuk menulis dan menggambar'],
            ['category_id' => 5, 'name' => 'Penghapus Faber Castell', 'price' => 2500, 'stock' => 180, 'min_stock' => 30, 'description' => 'Penghapus karet berkualitas'],
            ['category_id' => 5, 'name' => 'Penggaris 30cm', 'price' => 6000, 'stock' => 70, 'min_stock' => 15, 'description' => 'Penggaris plastik transparan'],
            ['category_id' => 5, 'name' => 'Spidol Snowman Permanent', 'price' => 8000, 'stock' => 90, 'min_stock' => 15, 'description' => 'Spidol permanen'],
            ['category_id' => 5, 'name' => 'Buku Gambar A4', 'price' => 10000, 'stock' => 50, 'min_stock' => 10, 'description' => 'Buku gambar ukuran A4'],

            // Produk Kebersihan (Category 6)
            ['category_id' => 6, 'name' => 'Deterjen Rinso 900g', 'price' => 20000, 'stock' => 55, 'min_stock' => 10, 'description' => 'Deterjen bubuk'],
            ['category_id' => 6, 'name' => 'Pembersih Lantai Super Pell 900ml', 'price' => 18000, 'stock' => 40, 'min_stock' => 8, 'description' => 'Cairan pembersih lantai'],
            ['category_id' => 6, 'name' => 'Sabun Cuci Piring Sunlight 755ml', 'price' => 15000, 'stock' => 65, 'min_stock' => 12, 'description' => 'Sabun cuci piring cair'],
            ['category_id' => 6, 'name' => 'Pembersih Kaca Windex 500ml', 'price' => 35000, 'stock' => 20, 'min_stock' => 5, 'description' => 'Cairan pembersih kaca'],
            ['category_id' => 6, 'name' => 'Bayclin 1L', 'price' => 14000, 'stock' => 45, 'min_stock' => 10, 'description' => 'Pemutih dan desinfektan'],
            ['category_id' => 6, 'name' => 'Spons Cuci Piring', 'price' => 5000, 'stock' => 100, 'min_stock' => 20, 'description' => 'Spons untuk mencuci piring'],

            // Makanan Instan (Category 7)
            ['category_id' => 7, 'name' => 'Indomie Goreng', 'price' => 3500, 'stock' => 200, 'min_stock' => 40, 'description' => 'Mie instan goreng'],
            ['category_id' => 7, 'name' => 'Indomie Kuah Ayam Bawang', 'price' => 3000, 'stock' => 180, 'min_stock' => 35, 'description' => 'Mie instan kuah rasa ayam bawang'],
            ['category_id' => 7, 'name' => 'Mie Sedap Goreng', 'price' => 3500, 'stock' => 150, 'min_stock' => 30, 'description' => 'Mie instan goreng'],
            ['category_id' => 7, 'name' => 'Pop Mie Ayam', 'price' => 7000, 'stock' => 80, 'min_stock' => 15, 'description' => 'Mie instan cup rasa ayam'],
            ['category_id' => 7, 'name' => 'Sarden ABC 425g', 'price' => 18000, 'stock' => 35, 'min_stock' => 8, 'description' => 'Ikan sarden dalam saus tomat'],
            ['category_id' => 7, 'name' => 'Kornet Beef Pronas 198g', 'price' => 25000, 'stock' => 25, 'min_stock' => 5, 'description' => 'Kornet sapi kaleng'],
            ['category_id' => 7, 'name' => 'Bubur Instan Energen', 'price' => 2500, 'stock' => 120, 'min_stock' => 25, 'description' => 'Bubur sereal instan'],

            // Bumbu Dapur (Category 8)
            ['category_id' => 8, 'name' => 'Kecap Manis Bango 275ml', 'price' => 18000, 'stock' => 70, 'min_stock' => 15, 'description' => 'Kecap manis'],
            ['category_id' => 8, 'name' => 'Saus Sambal ABC 275ml', 'price' => 12000, 'stock' => 85, 'min_stock' => 15, 'description' => 'Saus sambal botol'],
            ['category_id' => 8, 'name' => 'Saus Tiram Saori 250ml', 'price' => 16000, 'stock' => 40, 'min_stock' => 10, 'description' => 'Saus tiram'],
            ['category_id' => 8, 'name' => 'Royco Ayam 200g', 'price' => 12000, 'stock' => 60, 'min_stock' => 12, 'description' => 'Bumbu penyedap rasa ayam'],
            ['category_id' => 8, 'name' => 'Masako Sapi 100g', 'price' => 6000, 'stock' => 90, 'min_stock' => 18, 'description' => 'Bumbu kaldu sapi'],
            ['category_id' => 8, 'name' => 'Bumbu Rendang Indofood', 'price' => 10000, 'stock' => 35, 'min_stock' => 8, 'description' => 'Bumbu instan rendang'],
            ['category_id' => 8, 'name' => 'Lada Bubuk Ladaku 30g', 'price' => 12000, 'stock' => 50, 'min_stock' => 10, 'description' => 'Lada bubuk'],
            ['category_id' => 8, 'name' => 'Ketumbar Bubuk 50g', 'price' => 8000, 'stock' => 45, 'min_stock' => 10, 'description' => 'Ketumbar bubuk'],
        ];
    }

    private function createSampleTransactions($users, $products): void
    {
        $paymentMethods = ['cash', 'debit', 'qris'];
        $statuses = ['completed', 'completed', 'completed', 'completed', 'pending', 'cancelled']; // Mostly completed

        // Create 30 sample transactions
        for ($i = 0; $i < 30; $i++) {
            $user = $users[array_rand($users)];
            $status = $statuses[array_rand($statuses)];
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
            $transactionDate = now()->subDays(rand(0, 30))->subHours(rand(0, 23));

            // Select random 1-5 products
            $selectedProducts = $products->random(rand(1, 5));
            $totalAmount = 0;
            $details = [];

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
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

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'invoice_number' => Transaction::generateInvoiceNumber(),
                'total_amount' => $totalAmount,
                'payment_amount' => $totalAmount + rand(0, 10000),
                'change_amount' => 0,
                'payment_method' => $paymentMethod,
                'status' => $status,
                'transaction_date' => $transactionDate,
                'created_at' => $transactionDate,
                'updated_at' => $transactionDate,
            ]);

            // Update change amount
            $transaction->update([
                'change_amount' => $transaction->payment_amount - $transaction->total_amount,
            ]);

            // Create transaction details
            foreach ($details as $detail) {
                $detail['transaction_id'] = $transaction->id;
                TransactionDetails::create($detail);
            }
        }
    }
}
