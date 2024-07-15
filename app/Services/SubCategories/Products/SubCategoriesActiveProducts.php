<?php

namespace App\Services\SubCategories\Products;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory_Product;
use App\Services\SubCategories\SubCategoriesService;

class SubCategoriesActiveProducts
{
    private static array $products;
    private static int $products_count;

    private static int $skip;
    private static int $take;

    private static Collection $all_categories;

    private static function recursiveFunc(int $product_category_id)
    {
        $is_leaf_category = DB::table("productsCategories")->where("id", $product_category_id)->select("is_leaf_category")->first()->is_leaf_category;

        if ($is_leaf_category == 1) {

            //! 64 query   101 model   1.23 s
            // $category_products = ProductCategory::where("id", $product_category_id)
            //     ->with("products", function ($query) {
            //         $query->where("productsCategories_products.is_active", 1)
            //             ->with("images")
            //             ->with("brand")
            //             ->paginate(1, ['*'], 'page', 2);
            //     })
            //     ->first()->products->toArray();

            // if (count($category_products) > 0) {
            //     static::$products["category_" . $product_category_id . "_products"] = $category_products;

            //     static::$products_count += ProductCategory_Product::where("productCategory_id", $product_category_id)
            //         ->where("is_active", 1)
            //         ->count();
            // }



            //! 23 query   33 model!!!   719 ms
            // SELECT 	p.*,
            //     b.name AS brand_name,
            //     (
            //         SELECT GROUP_CONCAT(CONCAT(pi.is_default, " | ", pi.image_path) SEPARATOR ", ")
            //         FROM productsimages pi
            //         WHERE pi.product_id = p.id
            //     ) AS "product_images"
            // FROM productscategories_products pc_p
            // INNER JOIN products p ON pc_p.product_id = p.id
            // INNER JOIN brands b ON p.brand_id = b.id
            // WHERE pc_p.productCategory_id = 2 AND pc_p.is_active = 1

            $product_images_subquery = DB::table('productsImages as pi')
                ->selectRaw('GROUP_CONCAT(CONCAT(pi.is_default, " | ", pi.image_path) SEPARATOR ", ")')
                ->whereColumn('pi.product_id', 'p.id');

            $query_result = DB::table('productscategories_products as pc_p')
                ->select("p.*", "b.name as brand_name")
                ->selectSub($product_images_subquery, 'product_images')
                ->join('products as p', 'pc_p.product_id', '=', 'p.id')
                ->join('brands as b', 'p.brand_id', '=', 'b.id')
                ->where('pc_p.productCategory_id', $product_category_id)
                ->where('pc_p.is_active', 1)
                ->skip(static::$skip)
                ->take(static::$take)
                ->get()
                ->toArray();

            if (count($query_result) > 0) {

                // static::$products["category_" . $product_category_id . "_products"] = $query_result;

                foreach ($query_result as $product) {
                    array_push(static::$products, $product);
                }

                static::$products_count += ProductCategory_Product::where("productCategory_id", $product_category_id)
                    ->where("is_active", 1)
                    ->count();
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

    public static function getProductsFor(int $product_category_id, int $skip, int $take)
    {
        static::$products = [];
        static::$products_count = 0;

        static::$skip = $skip;
        static::$take = $take;

        static::$all_categories = ProductCategory::get();

        static::recursiveFunc($product_category_id);

        return [
            "products" => static::$products,
            "all_products_count" => static::$products_count
        ];
    }
}
