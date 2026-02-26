<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Nike Running Shoes',
            'price' => 3500,
            'category_id' => 1,
            'brand_id' => 1,
        ]);

        Product::create([
            'name' => 'Wireless Gaming Mouse',
            'price' => 1200,
            'category_id' => 1,
            'brand_id' => 1,
        ]);

        Product::create([
            'name' => 'Mechanical Keyboard RGB',
            'price' => 2800,
            'category_id' => 1,
            'brand_id' => 1,
        ]);

        Product::create([
            'name' => 'Smartphone 128GB',
            'price' => 15999,
            'category_id' => 1,
            'brand_id' => 1,
        ]);

        Product::create([
            'name' => 'Bluetooth Headphones',
            'price' => 2200,
            'category_id' => 1,
            'brand_id' => 1,
        ]);
    }
}