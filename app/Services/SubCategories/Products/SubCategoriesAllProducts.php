<?php

namespace App\Services\SubCategories\Products;

use App\Models\ProductCategory;
use App\Models\ProductCategory_Product;
use App\Services\SubCategories\SubCategoriesService;
use Illuminate\Support\Collection;

class SubCategoriesAllProducts
{
    private static array $products;
    private static int $products_count;

    private static Collection $all_categories;

    private static function recursiveFunc(int $product_category_id)
    {
        if (SubCategoriesService::isLeafCategory($product_category_id)) {

            $category_products = ProductCategory::where("id", $product_category_id)
                ->with("products", function ($query) {
                    $query->with("images")
                        ->with("brand")
                        ->paginate(12, ['*'], 'page', 1);
                })
                ->first()->products->toArray();

            static::$products["category_" . $product_category_id . "_products"] = $category_products;

            static::$products_count += ProductCategory_Product::where("productCategory_id", $product_category_id)->count();

        } else {

            $sub_categories = static::$all_categories->where("parent_id", $product_category_id);

            static::formatTree($sub_categories);
        }
    }


    private static function formatTree($categories)
    {
        foreach ($categories as $category) {
            static::recursiveFunc($category->id);
        }
    }

    public static function getProductsFor(int $product_category_id)
    {
        static::$products = [];
        static::$products_count = 0;

        static::$all_categories = ProductCategory::get();

        static::recursiveFunc($product_category_id);

        return [
            "products" => static::$products,
            "all_products_count" => static::$products_count
        ];
    }
}
