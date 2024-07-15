<?php

namespace App\Http\Controllers\Web\ProductsCategories\helpers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;

class editProductCategory
{

    private static ProductCategory $products_category; // pointer
    private static Request $request;

    private static array $data;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("update_productsCategories", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de modifier les catégories"
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
                ]
            )->first();
    }


    private static function loadRelatedProductsData()
    {

        if (static::$data['productCategoryData']['quantity_of_products'] === 0) {

            static::$data["relatedProductsData"] = collect();
        } else {

            static::$data["relatedProductsData"] = ProductCategory_Product::where('productcategory_id', static::$products_category->id)->get();
        }
    }


    private static function loadAllProductsData()
    {
        static::$data["allProductsData"] = Product::addSelect(
            [
                'added_by_username' => User::whereColumn('users.id', 'products.added_by')
                    ->select('users.username'),

                "brand_name" => Brand::select("name")
                    ->whereColumn('brands.id', 'products.brand_id'),
            ]
        )->get();
    }


    private static function loadAllProductsCategoriesNames()
    {
        static::$data["productsCategoriesNames"] = ProductCategory::pluck("name");
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

        if($products_category->is_leaf_category) {

            static::loadRelatedProductsData();

            static::loadAllProductsData();
        }

        static::loadAllProductsCategoriesNames();

        return view("dashboard.productsCategories.edit", ["data" => static::$data]);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
