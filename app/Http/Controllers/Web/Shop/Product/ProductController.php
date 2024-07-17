<?php

namespace App\Http\Controllers\Web\Shop\Product;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductAttributeOption;
use App\Models\ProductCategory_Product;
use App\Services\SubCategories\SubCategoriesService;

class ProductController extends Controller
{
    private static array $data;

    private static Product $product;



    private static function prepareNavCategories()
    {
        static::$data["navCategories"] = ProductCategory::where("show_on_website_header", 1)->select("id", "name", "image_path")
            ->addSelect([

                'subCategories' => DB::table('productscategories AS t2')
                    ->whereColumn('t2.parent_id', 'productscategories.id')
                    ->select(DB::raw("GROUP_CONCAT(CONCAT(t2.id, ' : ' , t2.name) SEPARATOR ', ')"))

            ])->get()
            ->toArray();

        foreach (static::$data["navCategories"] as &$nav_category) {

            $nav_category["brands"] = SubCategoriesService::getActiveProductsBrandsListForSpecificCategory($nav_category["id"]);
        }
    }


    private static function loadProductData()
    {
        static::$data["productData"] = Product::with("images")
            ->where("id", static::$product->id)->addSelect([

                'added_by_username' => User::whereColumn('users.id', 'products.added_by')
                    ->select('users.username'),

                "brand_name" => Brand::select("name")
                    ->whereColumn('brands.id', 'products.brand_id'),
            ])->first()->toArray();
    }


    private static function loadProductAttributes()
    {
        $product_variations = ProductVariation::where("product_id", static::$product->id)
            ->with("attributes_options_pivot", function ($query) {
                $query->with("attribute")->with("option");
            })->get()->toArray();


        $first_variation = $product_variations[0];

        foreach ($first_variation["attributes_options_pivot"] as $attribute_option) {

            $attribute_name = $attribute_option["attribute"]["name"];

            static::$data["productData"]["attributes"][$attribute_name] = [];
        }

        foreach ($product_variations as $product_variation) {

            foreach ($product_variation["attributes_options_pivot"] as $attribute_option) {

                $attribute_name = $attribute_option["attribute"]["name"];

                $attribute_option = $attribute_option["option"]["value"];

                if (!in_array($attribute_option, static::$data["productData"]["attributes"][$attribute_name])) {
                    array_push(static::$data["productData"]["attributes"][$attribute_name], $attribute_option);
                }
            }
        }
    }


    private static function loadRelatedProductsData()
    {
        $related_categories = static::$product->categories;

        foreach ($related_categories as $key => $category) {
            static::$data["relatedProducts"] = $category->productsExcept(static::$product->id)->get()->toArray();
        }



        // static::$data["productData"] = Product::with("images")
        //     ->where("id", static::$product->id)->addSelect([

        //         'added_by_username' => User::whereColumn('users.id', 'products.added_by')
        //             ->select('users.username'),

        //         "brand_name" => Brand::select("name")
        //             ->whereColumn('brands.id', 'products.brand_id'),
        //     ])->first()->toArray();
    }


    public function index(Product $product)
    {

        static::$product = $product;

        static::prepareNavCategories();

        static::loadProductData();

        static::loadProductAttributes();

        static::loadRelatedProductsData();

        // dd(static::$data);

        return view("shop.product.index", ["data" => static::$data]);
    }
}
