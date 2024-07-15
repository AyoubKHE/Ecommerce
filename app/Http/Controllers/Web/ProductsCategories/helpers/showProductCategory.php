<?php

namespace App\Http\Controllers\Web\ProductsCategories\helpers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;

class showProductCategory
{
    private static ProductCategory $products_category; // pointer
    private static Request $request;

    private static array $data;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("read_productsCategories", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'afficher les catégories"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function loadProductCategoryData()
    {
        static::$data['productCategoryData'] = ProductCategory::where('id', static::$products_category->id)
            ->addSelect(
                [
                    'added_by_username' => User::whereColumn('users.id', 'productscategories.added_by')
                        ->select('users.username'),

                    'base_category_name' => DB::table('productscategories AS t2')->select('t2.name')
                        ->whereColumn('t2.id', 'productscategories.parent_id'),

                    'quantity_of_products' => ProductCategory_Product::select(DB::raw('count(*)'))
                        ->whereColumn('productcategory_id', 'productscategories.id'),

                    'quantity_of_active_products' => ProductCategory_Product::select(DB::raw('count(*)'))
                        ->whereColumn('productcategory_id', 'productscategories.id')
                        ->where('is_active', 1)
                ]
            )->first();
    }


    private static function loadRelatedProductsData()
    {
        if (static::$data['productCategoryData']['quantity_of_products'] === 0) {

            static::$data["relatedProductsData"] = collect();
        } else {

            static::$data["relatedProductsData"] = ProductCategory_Product::where('productcategory_id', static::$products_category->id)->addSelect(
                [
                    "product_name" => Product::select("name")->whereColumn('products.id', 'productscategories_products.product_id'),

                    "product_rating" => Product::select("rating")->whereColumn('products.id', 'productscategories_products.product_id'),

                    "product_created_at" => Product::select("created_at")->whereColumn('products.id', 'productscategories_products.product_id'),

                    "product_updated_at" => Product::select("updated_at")->whereColumn('products.id', 'productscategories_products.product_id'),

                    "product_added_by_username" => Product::join('users', 'products.added_by', '=', 'users.id')
                        ->select("users.username")
                        ->whereColumn('products.id', 'productscategories_products.product_id'),

                    "product_brand_name" => Product::join('brands', 'products.brand_id', '=', 'brands.id')
                        ->select("brands.name")
                        ->whereColumn('products.id', 'productscategories_products.product_id'),
                ]
            )->get();
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(ProductCategory $products_category, Request $request)
    {
        static::$products_category = $products_category;

        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        static::loadProductCategoryData();

        static::loadRelatedProductsData();

        return view("dashboard.productsCategories.show", ["data" => static::$data]);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
