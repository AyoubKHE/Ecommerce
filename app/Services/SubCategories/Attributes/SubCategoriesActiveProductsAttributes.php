<?php

namespace App\Services\SubCategories\Attributes;

use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ProductAttributeOption;


class SubCategoriesActiveProductsAttributes
{

    private static array $attributes;

    private static Collection $all_categories;

    private static function recursiveFunc(int $product_category_id)
    {
        $is_leaf_category = DB::table("productsCategories")->where("id", $product_category_id)->select("is_leaf_category")->first()->is_leaf_category;

        if ($is_leaf_category == 1) {

            //! 49 query   543 model   1 s
            // $category_products = ProductCategory::where("id", $product_category_id)
            //     ->with("products", function ($query) {
            //         $query->where("productsCategories_products.is_active", 1)
            //             ->with("variations", function ($query) {
            //                 $query->with("attributes_options_pivot", function ($query) {
            //                     $query->with("attribute")->with("option");
            //                 });
            //             });
            //     })
            //     ->first()->products->toArray();

            // foreach ($category_products as $product) {
            //     foreach ($product["variations"][0]["attributes_options_pivot"] as $key => $attribute_option) {

            //         $attribute_name = $attribute_option["attribute"]["name"];

            //         if (!array_key_exists($attribute_name, static::$attributes)) {

            //             $attribute_id = $attribute_option["attribute"]["id"];

            //             $attribute_options = ProductAttributeOption::where("productAttribute_id", $attribute_id)->pluck("value")->toArray();

            //             static::$attributes[$attribute_option["attribute"]["name"]] = $attribute_options;
            //         }
            //     }
            // }




            //! 20 query   33 model!!!   314 ms!!!

            /*
                SELECT
                (
                    SELECT (
                        SELECT GROUP_CONCAT(CONCAT(pa.id, " : ", pa.name) SEPARATOR ", ")
                        FROM productsvariations_attributesoptions pv_ao
                        INNER JOIN productsattributes pa ON pv_ao.productAttribute_id = pa.id
                        INNER JOIN productsattributesoptions pao ON pv_ao.productAttributeOption_id = pao.id
                        WHERE pv_ao.productVariation_id = pv.id
                    )
                    FROM productsvariations pv
                    WHERE pv.product_id = p.id
                    LIMIT 1
                ) AS "products_attributes"
                FROM productscategories_products pc_p
                INNER JOIN products p ON pc_p.product_id = p.id
                WHERE pc_p.productCategory_id = 5 AND pc_p.is_active = 1
            */

            $attributes_subquery = DB::table('productsvariations_attributesoptions as pv_ao')
                ->selectRaw('GROUP_CONCAT(CONCAT(pa.id, " : ", pa.name) SEPARATOR ", ")')
                ->join('productsattributes as pa', 'pv_ao.productAttribute_id', '=', 'pa.id')
                ->whereColumn('pv_ao.productVariation_id', 'pv.id');

            $variations_subquery = DB::table('productsvariations as pv')
                ->selectSub($attributes_subquery, 'products_attribes')
                ->whereColumn('pv.product_id', 'p.id')
                ->limit(1);

            $query_result = DB::table('productscategories_products as pc_p')
                ->selectSub($variations_subquery, 'products_attributes')
                ->join('products as p', 'pc_p.product_id', '=', 'p.id')
                ->where('pc_p.productCategory_id', $product_category_id)
                ->where('pc_p.is_active', 1)
                ->get();



            foreach ($query_result as $record) {

                $product_attributes = explode(", ", $record->products_attributes);

                foreach ($product_attributes as $product_attribute) {

                    $product_attribute = explode(" : ", $product_attribute);

                    $product_attribute_name = $product_attribute[1];

                    if (!array_key_exists($product_attribute_name, static::$attributes)) {

                        $product_attribute_id = $product_attribute[0];

                        $attribute_options = ProductAttributeOption::where("productAttribute_id", $product_attribute_id)->pluck("value")->toArray();

                        static::$attributes[$product_attribute_name] = $attribute_options;
                    }
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

    public static function getAttributesFor(int $product_category_id)
    {
        static::$attributes = [];

        static::$all_categories = ProductCategory::get();

        static::recursiveFunc($product_category_id);

        return static::$attributes;
    }
}
