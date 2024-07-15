<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategory_Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory_Product>
 */
class ProductCategory_ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productsCategories = ProductCategory::all();
        $products = Product::all();

        do {
            $productCategory = $productsCategories->random();
            $product = $products->random();

        } while (ProductCategory_Product::where('productCategory_id', $productCategory->id)->where('product_id', $product->id)->exists());

        return [
            'product_id' => $product->id,
            'productcategory_id' => $productCategory->id,
            'is_active' => fake()->boolean()
        ];
    }
}
