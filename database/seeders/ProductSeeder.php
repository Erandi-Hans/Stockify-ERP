<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        if ($categories->isEmpty() || $suppliers->isEmpty()) {
            return;
        }

        $adjectives = ['Pro', 'Ultra', 'Max', 'Smart', 'Wireless', 'Portable', 'Compact', 'Advanced', 'Premium', 'Elite'];

        for ($i = 1; $i <= 100; $i++) {
            $category = $categories->random();
            $supplier = $suppliers->random();

            $cost = rand(500, 50000);
            $price = $cost + rand(200, 15000);

            Product::create([
                'sku' => 'SKU-' . sprintf("%04d", $i),
                'name' => $category->name . ' ' . $adjectives[array_rand($adjectives)] . ' ' . $i,
                'category_id' => $category->id,
                'supplier_id' => $supplier->id,
                'description' => 'High quality ' . strtolower($category->name) . ' item with standard manufacturer warranty.',
                'cost_price' => $cost,
                'unit_price' => $price,
                'stock_quantity' => rand(10, 100),
                'reorder_level' => 10,
            ]);
        }
    }
}
