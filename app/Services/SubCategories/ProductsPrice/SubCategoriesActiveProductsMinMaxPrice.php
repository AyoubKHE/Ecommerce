<?php

namespace App\Services\SubCategories\ProductsPrice;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory_Product;
use App\Services\SubCategories\SubCategoriesService;

class SubCategoriesActiveProductsMinMaxPrice
{
    private static int $min_price;
    private static int $max_price;

    private static Collection $all_categories;

    private static function recursiveFunc(int $product_category_id)
    {

        $is_leaf_category = DB::table("productsCategories")->where("id", $product_category_id)->select("is_leaf_category")->first()->is_leaf_category;

        if ($is_leaf_category == 1) {

            $query_result = DB::table('productscategories_products as pc_p')
                ->select("p.price")
                ->join('products as p', 'pc_p.product_id', '=', 'p.id')
                ->where('pc_p.productCategory_id', $product_category_id)
                ->where('pc_p.is_active', 1)
                ->get()
                ->toArray();

            foreach ($query_result as $record) {
                if($record->price < static::$min_price) {
                    static::$min_price = $record->price;
                }
                if($record->price > static::$max_price) {
                    static::$max_price = $record->price;
                }
            }


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

    public static function getProductsPriceFor(int $product_category_id)
    {
        static::$min_price = PHP_INT_MAX;
        static::$max_price = PHP_INT_MIN;

        static::$all_categories = DB::table('productsCategories')->get();

        static::recursiveFunc($product_category_id);

        return [
            "min_price" => static::$min_price,
            "max_price" => static::$max_price,
        ];
    }
}
