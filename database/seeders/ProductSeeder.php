<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Product::create([
            'sku' => 'PROD001',
            'image' => 'product1.jpg',
            'name' => 'Product 1',
            'description' => 'This is product 1 description.',
            'retail_price' => 100,
            'our_price' => 90,
        ]);

        Product::create([
            'sku' => 'PROD002',
            'image' => 'product2.jpg',
            'name' => 'Product 2',
            'description' => 'This is product 2 description.',
            'retail_price' => 120,
            'our_price' => 100,
        ]);

        // Add more products as needed
    }
}
