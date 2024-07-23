<?php

namespace App\Http\Controllers\Web\Shop\Checkout;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Commune;
use App\Models\Wilaya;
use App\Services\SubCategories\SubCategoriesService;

class CheckoutController extends Controller
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
            static::$data["cartData"] = static::$data["cartData"]->toArray();
        }
    }

    private static function loadWilayasAndCommunes()
    {
        static::$data["wilayas"] = Wilaya::all()->toArray();

        static::$data["BejaiaCommunes"] = Commune::where("wilaya_id", 6)->get()->toArray();
    }

    public function index(Request $request)
    {

        static::$request = $request;

        static::prepareNavCategories();

        static::loadCartData();

        static::loadWilayasAndCommunes();

        // dd(static::$data);

        return view("shop.checkout.index", ["data" => static::$data]);
    }
}
