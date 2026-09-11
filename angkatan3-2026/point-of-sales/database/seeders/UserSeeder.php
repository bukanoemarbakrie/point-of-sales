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
        $adminRole = Role::where('name', 'Administrator')->first();
        $cashierRole = Role::where('name', 'Cashier')->first();
        $leaderRole = Role::where('name', 'Leader')->first();

        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => $adminRole?->id,
            ],
            [
                'name' => 'Cashier User',
                'email' => 'cashier@gmail.com',
                'password' => Hash::make('11223344'),
                'role_id' => $cashierRole?->id,
            ],
            [
                'name' => 'Leader User',
                'email' => 'leader@gmail.com',
                'password' => Hash::make('22446688'),
                'role_id' => $leaderRole?->id,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], // ← Cek berdasarkan email
                $user
            );
        }
    }
}
