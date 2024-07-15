<?php

namespace App\Http\Controllers\Web\Products\helpers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;

class showAllProducts
{

    private static array $data;

    private static Request $request;

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


    private static function loadProductsData()
    {

        static::$data["productsData"] = Product::addSelect([

            'added_by_username' => User::whereColumn('users.id', 'products.added_by')
                ->select('users.username'),

            "brand_name" => Brand::select("name")
                ->whereColumn('brands.id', 'products.brand_id'),

        ])->paginate(env("productPagination"));
    }


    private static function loadFilterModalData()
    {
        static::$data["filterModalData"]["productsCategoriesNames"] = ProductCategory::pluck("name")->all();

        static::$data["filterModalData"]["brandsNames"] = Brand::pluck("name")->all();

        static::$data["filterModalData"]["usersNames"] = User::pluck("username")->all();

        static::$data["filterModalData"]["minCreatedAtDate"] = (new Carbon(Product::min("created_at")))->sub("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["minCreatedAtTime"] = (new Carbon(Product::min("created_at")))->sub("1 minute")->isoFormat("kk:mm");
        static::$data["filterModalData"]["maxCreatedAtDate"] = (new Carbon(Product::max("created_at")))->add("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["maxCreatedAtTime"] = (new Carbon(Product::max("created_at")))->add("1 minute")->isoFormat("kk:mm");

        static::$data["filterModalData"]["minUpdatedAtDate"] = (new Carbon(Product::min("updated_at")))->sub("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["minUpdatedAtTime"] = (new Carbon(Product::min("updated_at")))->sub("1 minute")->isoFormat("kk:mm");
        static::$data["filterModalData"]["maxUpdatedAtDate"] = (new Carbon(Product::max("updated_at")))->add("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["maxUpdatedAtTime"] = (new Carbon(Product::max("updated_at")))->add("1 minute")->isoFormat("kk:mm");

        static::$data["filterModalData"]["minPrice"] = Product::min("price");
        static::$data["filterModalData"]["maxPrice"] = Product::max("price");

        static::$data["filterModalData"]["minRating"] = Product::min("rating") ?? 0;
        static::$data["filterModalData"]["maxRating"] = Product::max("rating") ?? 100;
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

        static::loadFilterModalData();

        return view("dashboard.products.index", ["data" => static::$data]);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
