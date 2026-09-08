<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // eloquent : query builder/orm laravel
        // insert into, select, update, delete
        // model itu acuan ke table
        Role::insert([
            [
                'name' => 'Administrator'
            ],
            [
                'name' => 'Cashier'
            ],
            [
                'name' => 'Leader'
            ],
        ]);
    }
}
