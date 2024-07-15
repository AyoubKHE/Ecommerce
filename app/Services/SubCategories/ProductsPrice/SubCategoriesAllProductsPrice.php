<?php

namespace App\Services\SubCategories\ProductsPrice;

use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory_Product;
use App\Services\SubCategories\SubCategoriesService;

class SubCategoriesAllProductsPrice
{
    private static int $products_count;

    private static Collection $all_categories;

    private static function recursiveFunc(int $product_category_id)
    {

        $is_leaf_category = DB::table("productsCategories")->where("id", $product_category_id)->select("is_leaf_category")->first()->is_leaf_category;

        if ($is_leaf_category == 1) {

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

    public static function getProductsCountFor(int $product_category_id)
    {
        static::$products_count = 0;

        static::$all_categories = DB::table('productsCategories')->get();

        static::recursiveFunc($product_category_id);

        return static::$products_count;
    }
}
