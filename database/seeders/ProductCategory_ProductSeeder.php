<?php

namespace Database\Seeders;

use App\Models\ProductCategory_Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategory_ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            ProductCategory_Product::factory(1)
            ->create();
        }
    }
}
