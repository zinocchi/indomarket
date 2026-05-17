<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Makanan Ringan', 'slug' => 'makanan-ringan', 'description' => 'Aneka snack dan makanan ringan'],
            ['id' => 2, 'name' => 'Minuman', 'slug' => 'minuman', 'description' => 'Minuman dingin dan panas'],
            ['id' => 3, 'name' => 'Kebutuhan Pokok', 'slug' => 'kebutuhan-pokok', 'description' => 'Beras, gula, minyak, dll'],
            ['id' => 4, 'name' => 'Perlengkapan Mandi', 'slug' => 'perlengkapan-mandi', 'description' => 'Sabun, sampo, pasta gigi, dll'],
            ['id' => 5, 'name' => 'Alat Tulis', 'slug' => 'alat-tulis', 'description' => 'Buku, pulpen, pensil, dll'],
            ['id' => 6, 'name' => 'Pembersih', 'slug' => 'pembersih', 'description' => 'Deterjen, pembersih lantai, dll'],
            ['id' => 7, 'name' => 'Makanan Instan', 'slug' => 'makanan-instan', 'description' => 'Mie instan, sarden, dll'],
            ['id' => 8, 'name' => 'Bumbu Dapur', 'slug' => 'bumbu-dapur', 'description' => 'Kecap, saus, penyedap, dll'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['id' => $category['id']],
                $category
            );
        }
    }
}
