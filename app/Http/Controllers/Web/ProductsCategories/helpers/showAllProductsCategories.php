<?php

namespace App\Http\Controllers\Web\ProductsCategories\helpers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;
use App\Services\SubCategories\SubCategoriesService;

class showAllProductsCategories
{

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


    private static function loadAllProductsCategoriesData()
    {
        static::$data['productCategoriesData'] = DB::table('productsCategories')->addSelect([

            'added_by_username' => User::whereColumn('users.id', 'productscategories.added_by')
                ->select('users.username'),

            'base_category_name' => DB::table('productscategories AS t2')->select('t2.name')
                ->whereColumn('t2.id', 'productscategories.parent_id'),
        ])->get();

        foreach (static::$data['productCategoriesData'] as $key => $product_category_data) {

            $product_category_data->subCategoriesCount = SubCategoriesService::getSubCategoriesCountForSpecificCategory($product_category_data->id);
            $product_category_data->productsCount = SubCategoriesService::getProductsCountForSpecificCategory($product_category_data->id);
            $product_category_data->activeProductsCount = SubCategoriesService::getActiveProductsCountForSpecificCategory($product_category_data->id);
        }
    }


    private static function loadFilterModalData()
    {
        static::$data["filterModalData"]["productsCategoriesNames"] = ProductCategory::pluck("name")->all();


        static::$data["filterModalData"]["usersNames"] = User::pluck("username")->all();

        static::$data["filterModalData"]["minCreatedAtDate"] = (new Carbon(ProductCategory::min("created_at")))->sub("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["minCreatedAtTime"] = (new Carbon(ProductCategory::min("created_at")))->sub("1 minute")->isoFormat("kk:mm");
        static::$data["filterModalData"]["maxCreatedAtDate"] = (new Carbon(ProductCategory::max("created_at")))->add("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["maxCreatedAtTime"] = (new Carbon(ProductCategory::max("created_at")))->add("1 minute")->isoFormat("kk:mm");
        static::$data["filterModalData"]["minUpdatedAtDate"] = (new Carbon(ProductCategory::min("updated_at")))->sub("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["minUpdatedAtTime"] = (new Carbon(ProductCategory::min("updated_at")))->sub("1 minute")->isoFormat("kk:mm");
        static::$data["filterModalData"]["maxUpdatedAtDate"] = (new Carbon(ProductCategory::max("updated_at")))->add("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["maxUpdatedAtTime"] = (new Carbon(ProductCategory::max("updated_at")))->add("1 minute")->isoFormat("kk:mm");


        static::$data["filterModalData"]["minQuantityOfProducts"] = static::$data['productCategoriesData']->min("productsCount");
        static::$data["filterModalData"]["maxQuantityOfProducts"] = static::$data['productCategoriesData']->max("productsCount");
        static::$data["filterModalData"]["minQuantityOfActiveProducts"] = static::$data['productCategoriesData']->min("activeProductsCount");
        static::$data["filterModalData"]["maxQuantityOfActiveProducts"] = static::$data['productCategoriesData']->max("activeProductsCount");
    }


    private static function prepareLinksData()
    {
        static::$data["linksData"]["currentPage"] = 1;
        $perPage = (int)env("productCategoriesPagination");
        $products_categories_count = count(static::$data['productCategoriesData']);
        static::$data["linksData"]["lastPage"] = ceil($products_categories_count / $perPage);

        static::$data["linksData"]["links"] = [];

        for ($page_number = 1; $page_number <= static::$data["linksData"]["lastPage"]; $page_number++) {

            $link = "http://127.0.0.1:8000/products-categories?page=" . $page_number;

            array_push(static::$data["linksData"]["links"], $link);
        }
    }


    private static function paginateProductsCategories()
    {
        static::$data['productCategoriesData'] = static::$data['productCategoriesData']->take((int)env("productCategoriesPagination"));

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

        static::loadAllProductsCategoriesData();

        static::loadFilterModalData();

        static::prepareLinksData();

        static::paginateProductsCategories();

        return view("dashboard.productsCategories.index", ["data" => static::$data]);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
