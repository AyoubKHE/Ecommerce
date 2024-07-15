<?php

namespace App\Http\Controllers\Web\ProductsCategories\helpers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;

class createProductCategory
{
    private static array $data;

    private static Request $request;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("create_productsCategories", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'ajouter une nouvelle catégorie"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function loadProductsData()
    {
        static::$data["productsData"] = Product::addSelect(
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

    public static function start(Request $request)
    {
        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        static::loadProductsData();

        static::loadAllProductsCategoriesNames();

        return view("dashboard.productsCategories.create", ["data" => static::$data]);

    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
