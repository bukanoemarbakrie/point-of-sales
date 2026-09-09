<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role_id dari tabel roles
        $adminRole = Role::where('name', 'Administrator')->first();
        $cashierRole = Role::where('name', 'Cashier')->first();
        $leaderRole = Role::where('name', 'Leader')->first();

        // User dengan role Administrator
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole?->id
        ]);

        // User dengan role Cashier
        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => $cashierRole?->id
        ]);

        // User dengan role Leader
        User::create([
            'name' => 'Leader User',
            'email' => 'leader@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => $leaderRole?->id
        ]);

        // User tambahan untuk testing (admin2)
        User::create([
            'name' => 'Admin 2',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => $adminRole?->id
        ]);
    }
}
