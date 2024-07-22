<?php

namespace App\Http\Controllers\Web\Shop\Auth\helpers;

use App\Models\User;
use App\Services\JWTService;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Services\SubCategories\SubCategoriesService;


class registerForm
{

    private static array $data;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

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




    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start()
    {
        static::prepareNavCategories();

        return view("shop.auth.register", ["data" => static::$data]);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
