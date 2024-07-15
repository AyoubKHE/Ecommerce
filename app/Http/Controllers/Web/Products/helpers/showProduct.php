<?php

namespace App\Http\Controllers\Web\Products\helpers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;

class showProduct
{
    private static Product $product; // pointer
    private static Request $request;

    private static array $data;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("read_products", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'afficher les produits"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function loadProductData()
    {
        static::$data["productData"] = Product::where("id", static::$product->id)->addSelect([

            'added_by_username' => User::whereColumn('users.id', 'products.added_by')
                ->select('users.username'),

            "brand_name" => Brand::select("name")
                ->whereColumn('brands.id', 'products.brand_id'),
        ])->first();
    }


    private static function preparingProductImages()
    {
        static::$data["product_images"]["other_images"] = [];
        foreach (static::$product->images as $product_image) {

            if ($product_image["is_default"]) {

                static::$data["product_images"]["default"] = $product_image;
            } else {

                array_push(static::$data["product_images"]["other_images"], $product_image);
            }
        }
    }


    private static function loadRelatedCategoriesData()
    {
        static::$data["relatedCategoriesData"] = ProductCategory_Product::where('product_id', static::$product->id)->addSelect(
            [
                "product_category_name" => ProductCategory::select("name")->whereColumn('productscategories.id', 'productscategories_products.productcategory_id'),
                "product_category_created_at" => ProductCategory::select("created_at")
                    ->whereColumn('productscategories.id', 'productscategories_products.productcategory_id'),
                "product_category_updated_at" => ProductCategory::select("updated_at")
                    ->whereColumn('productscategories.id', 'productscategories_products.productcategory_id'),
                "product_category_added_by_username" => ProductCategory::join('users', 'productscategories.added_by', '=', 'users.id')
                    ->select("users.username")
                    ->whereColumn('productscategories.id', 'productscategories_products.productcategory_id'),
                "product_category_quantity_of_products" => DB::table('productscategories_products AS t2')
                    ->select(DB::raw('count(*)'))
                    ->whereColumn('t2.productcategory_id', 'productscategories_products.productcategory_id'),
                "product_category_quantity_of_active_products" => DB::table('productscategories_products AS t2')
                    ->select(DB::raw('count(*)'))
                    ->whereColumn('t2.productcategory_id', 'productscategories_products.productcategory_id')
                    ->where('t2.is_active', 1),
            ]
        )->get();
    }


    private static function loadProductVariations()
    {
        static::$data["productVariations"]["variations"] = ProductVariation::where('product_id', static::$product->id)
            ->with("options", function ($query) {
                $query->with("productAttribute");
            })->get()->toArray();

        static::$data["productVariations"]["usedAttributes"] = [];

        foreach (static::$data["productVariations"]["variations"][0]["options"] as $option) {
            array_push(static::$data["productVariations"]["usedAttributes"], $option["product_attribute"]["name"]);
        }
    }


    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(Product $product, Request $request)
    {
        static::$product = $product;

        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        static::loadProductData();

        static::preparingProductImages();

        static::loadRelatedCategoriesData();

        static::loadProductVariations();

        return view("dashboard.products.show", ["data" => static::$data]);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
