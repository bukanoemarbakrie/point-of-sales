<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kategori berdasarkan nama
        $coffee = Category::where('category_name', 'Coffee')->first();
        $nonCoffee = Category::where('category_name', 'Non-Coffee')->first();
        $snack = Category::where('category_name', 'Snack')->first();

        // Cek apakah semua kategori ada
        if (!$coffee || !$nonCoffee || !$snack) {
            $this->command->error('Category not found. Run CategorySeeder first.');
            return;
        }

        $products = [
            // ============ SNACK ============
            [
                'category_id' => $snack->id,
                'product_name' => 'Dimsum Mentai',
                'product_photo' => 'products/dimsum-mentai.jpg',      // ← Ganti nama file
                'product_price' => 25000,
                'qty' => 100,
                'product_description' => 'Dimsum lembut dengan saus mentai creamy',
                'is_active' => 1,
            ],
            [
                'category_id' => $snack->id,
                'product_name' => 'Snack Platter',
                'product_photo' => 'products/snack-platter.jpg',       // ← Ganti nama file
                'product_price' => 35000,
                'qty' => 100,
                'product_description' => 'Sosis, nugget, kentang goreng',
                'is_active' => 1,
            ],
            [
                'category_id' => $snack->id,
                'product_name' => 'Cireng Bumbu Rujak',
                'product_photo' => 'products/cireng-bumbu-rujak.jpg',  // ← Ganti nama file
                'product_price' => 20000,
                'qty' => 100,
                'product_description' => 'Cireng goreng dengan bumbu rujak pedas manis',
                'is_active' => 1,
            ],

            // ============ NON-COFFEE ============
            [
                'category_id' => $nonCoffee->id,
                'product_name' => 'Matcha Latte (Hot)',
                'product_photo' => 'products/matcha-latte-hot.jpg',    // ← Ganti nama file
                'product_price' => 70000,
                'qty' => 100,
                'product_description' => 'Matcha latte panas dengan susu premium',
                'is_active' => 1,
            ],
            [
                'category_id' => $nonCoffee->id,
                'product_name' => 'Lychee Tea (Cold)',
                'product_photo' => 'products/lychee-tea-cold.jpg',     // ← Ganti nama file
                'product_price' => 20000,
                'qty' => 100,
                'product_description' => 'Teh leci dingin segar',
                'is_active' => 1,
            ],

            // ============ COFFEE ============
            [
                'category_id' => $coffee->id,
                'product_name' => 'Aren Latte Coffee (Cold)',
                'product_photo' => 'products/aren-latte-coffee-cold.jpg', // ← Ganti nama file
                'product_price' => 25000,
                'qty' => 100,
                'product_description' => 'Kopi latte dengan gula aren, creamy lembut',
                'is_active' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['product_name' => $product['product_name']],
                $product
            );
        }

        $this->command->info('✅ ProductSeeder: ' . count($products) . ' products seeded (no duplicates).');
    }
}
