<?php

namespace App\Http\Controllers\Web\Products\helpers;

use App\Models\User;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;

class createProduct
{
    private static array $data;

    private static Request $request;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("create_products", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'ajouter de nouveau produits"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function loadProductCategoriesData()
    {
        static::$data['productCategoriesData'] = ProductCategory::addSelect([

            'added_by_username' => User::whereColumn('users.id', 'productscategories.added_by')
                ->select('users.username'),

            'base_category_name' => DB::table('productscategories AS t2')->select('t2.name')
                ->whereColumn('t2.id', 'productscategories.parent_id'),
            'quantity_of_products' => ProductCategory_Product::select(DB::raw('count(*)'))
                ->whereColumn('productcategory_id', 'productscategories.id'),
            'quantity_of_active_products' => ProductCategory_Product::select(DB::raw('count(*)'))
                ->whereColumn('productcategory_id', 'productscategories.id')
                ->where('is_active', 1)
        ])
        ->where("is_leaf_category", 1)
        ->get();
    }


    private static function loadBrandsNames()
    {
        static::$data['brandsNames'] = Brand::pluck("name");
    }


    private static function loadAttributesNames()
    {
        static::$data['attributesNames'] = ProductAttribute::pluck("name");
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

        if (ProductCategory::count() === 0 || Brand::count() === 0 || ProductAttribute::count() === 0) {
            $message = [
                "type" => "warning",
                "text" => "Avant de continuer, veuillez ajouter d abord\n-Les catégories.\n-Les marques.\n-Les attributs"
            ];
            return back()->with("message", $message);
        }

        static::loadProductCategoriesData();

        static::loadBrandsNames();

        static::loadAttributesNames();

        return view("dashboard.products.create", ["data" => static::$data]);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
