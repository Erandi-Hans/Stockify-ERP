<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Full system access and administrative rights',
            ],
            [
                'name' => 'Manager',
                'description' => 'Can manage inventory, purchases, and view reports',
            ],
            [
                'name' => 'Cashier',
                'description' => 'Can handle customer invoices and process payments',
            ],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
