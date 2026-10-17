<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@stockify.com'],
                [
                    'role_id' => $adminRole->id,
                    'name' => 'Stockify System Admin',
                    'email' => 'admin@stockify.com',
                    'password' => Hash::make('Admin@1234'), // Securely hashed password
                    'is_active' => true,
                ]
            );
        }
    }
}
