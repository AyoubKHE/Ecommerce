<?php

namespace App\Http\Controllers\Web\Shop\Showcase;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory_Product;
use App\Services\SubCategories\SubCategoriesService;

class ShowcaseController extends Controller
{

    private static array $data;

    private static Request $request;

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


    private static function loadCartData()
    {
        $laravel_session = static::$request->session()->getId();

        static::$data["cartData"] = Cart::where("session_id", $laravel_session)
            ->with("items", function ($query) {
                $query->with("variation", function ($query) {
                    $query->with("product", function ($query) {
                        $query->with("images");
                    })
                        ->with("attributes_options_pivot", function ($query) {
                            $query->with("attribute")->with("option");
                        });
                })->orderBy("created_at");
            })
            ->first();

        if (static::$data["cartData"] !== null) {
            static::$data["cartData"]->toArray();
        }
    }


    public function index(Request $request)
    {

        static::$request = $request;

        static::prepareNavCategories();

        static::loadCartData();


        return view("shop.index", ["data" => static::$data]);
    }
}
