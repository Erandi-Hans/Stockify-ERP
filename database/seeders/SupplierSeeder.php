<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Kamal Perera', 'company_name' => 'Abans PLC', 'phone' => '0771234567', 'email' => 'abans@gmail.com', 'address' => 'Colombo, Sri Lanka'],
            ['name' => 'Nimal Silva', 'company_name' => 'Singer Sri Lanka', 'phone' => '0712345678', 'email' => 'singer@gmail.com', 'address' => 'Kandy, Sri Lanka'],
            ['name' => 'Sunil Shantha', 'company_name' => 'Softlogic Retail', 'phone' => '0701234567', 'email' => 'softlogic@gmail.com', 'address' => 'Galle, Sri Lanka'],
        ];

        foreach ($suppliers as $sup) {
            Supplier::create([
                'name' => $sup['name'],
                'company_name' => $sup['company_name'],
                'phone' => $sup['phone'],
                'email' => $sup['email'],
                'address' => $sup['address'],
                'status' => 'Active',
            ]);
        }
    }
}
