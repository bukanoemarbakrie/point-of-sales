<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,      // 1. Roles dulu
            CategorySeeder::class,  // 2. Categories
            UserSeeder::class,      // 3. Users (butuh role_id)
            ProductSeeder::class,   // 4. Products (butuh category_id) ← TAMBAHKAN INI
        ]);
    }
}
