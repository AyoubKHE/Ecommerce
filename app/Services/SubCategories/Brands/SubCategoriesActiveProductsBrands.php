<?php

namespace App\Services\SubCategories\Brands;

use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\SubCategories\SubCategoriesService;

class SubCategoriesActiveProductsBrands
{

    private static array $brands = [];

    private static Collection $all_categories;

    private static function recursiveFunc(int $product_category_id)
    {
        $is_leaf_category = DB::table("productsCategories")->where("id", $product_category_id)->select("is_leaf_category")->first()->is_leaf_category;

        if ($is_leaf_category == 1) {

            //! 32 query, 65 model
            // $category_products = ProductCategory::where("id", $product_category_id)
            //     ->with("products", function ($query) {
            //         $query->where("productsCategories_products.is_active", 1)
            //             ->with("brand");
            //     })
            //     ->first()->products->toArray();

            //! 19 query, 33 model
            $category_brands = DB::table('productsCategories_products')
                ->where('productsCategories_products.productCategory_id', $product_category_id)
                ->where('productsCategories_products.is_active', 1)
                ->join('products', 'productsCategories_products.product_id', '=', 'products.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->select('brands.name')
                ->get()
                ->toArray();

            foreach ($category_brands as $brand) {

                if (array_key_exists($brand->name, static::$brands)) {
                    static::$brands[$brand->name]++;
                } else {
                    static::$brands[$brand->name] = 1;
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

    public static function getBrandsFor(int $product_category_id)
    {
        static::$brands = [];

        static::$all_categories = ProductCategory::get();

        static::recursiveFunc($product_category_id);

        return static::$brands;
    }
}
