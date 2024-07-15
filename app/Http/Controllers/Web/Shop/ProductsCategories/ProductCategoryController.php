<?php

namespace App\Http\Controllers\Web\Shop\ProductsCategories;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\SubCategories\SubCategoriesService;

class ProductCategoryController extends Controller
{
    private static array $data;

    private static ProductCategory $products_category;



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


    private static function loadCategoryData()
    {
        static::$data["productCategoryData"]  = static::$products_category->toArray();

        static::$data["productCategoryData"]["productsBrands"] = SubCategoriesService::getActiveProductsBrandsListForSpecificCategory(static::$products_category->id);

        static::$data["productCategoryData"]["productsAttributes"] = SubCategoriesService::getActiveProductsAttributesListForSpecificCategory(static::$products_category->id);

        static::$data["productCategoryData"]["MinMaxPrices"] = SubCategoriesService::getActiveProductsMinMaxPricesForSpecificCategory(static::$products_category->id);

        static::$data["relatedCategories"] = ProductCategory::where("parent_id", static::$products_category->parent_id)->select("id", "name")->get()->toArray();
    }


    // private static function loadLeafCategoryProducts()
    // {

    //     static::$data["productCategoryData"]["products"] =
    //         SubCategoriesService::getActiveProductsListForSpecificCategory(static::$products_category->id, 0, env("shopProductsPagination"))
    //         ;

    //     static::$data["productCategoryData"]["productsCount"] =
    //         static::$data["productCategoryData"]["products"]["all_products_count"];
    // }


    private static function loadCategoryProducts()
    {

        [
            "products" => static::$data["productCategoryData"]["products"],
            "all_products_count" => static::$data["productCategoryData"]["productsCount"]
        ] =
            SubCategoriesService::getActiveProductsListForSpecificCategory(
                static::$products_category->id,
                0,
                static::$products_category->is_leaf_category == 1 ? env("shopProductsPagination") : env("shopProductsPerCategoryPagination")
            );
    }


    private static function loadSubCategories()
    {
        $subCategories = ProductCategory::where("parent_id", static::$products_category->id)->get()->toArray();

        foreach ($subCategories as $sub_category) {

            $products_count = SubCategoriesService::getActiveProductsCountForSpecificCategory((int)$sub_category["id"]);

            if ($products_count > 0) {

                static::$data["subCategoriesProductsCount"][$sub_category["id"]]["category_name"] = $sub_category["name"];
                static::$data["subCategoriesProductsCount"][$sub_category["id"]]["products_count"] = $products_count;
            }
        }
    }


    private static function prepareLinksData()
    {
        static::$data["linksData"]["currentPage"] = 1;

        if (static::$products_category->is_leaf_category) {
            $perPage = (int)env("shopProductsPagination");
        } else {
            $perPage = count(static::$data["subCategoriesProductsCount"]) * (int)env("shopProductsPerCategoryPagination");
        }

        $products_count = static::$data["productCategoryData"]["productsCount"];

        static::$data["linksData"]["lastPage"] = ceil($products_count / $perPage);

        static::$data["linksData"]["links"] = [];

        for ($page_number = 1; $page_number <= static::$data["linksData"]["lastPage"]; $page_number++) {

            $link = "http://127.0.0.1:8000/api/shop/products-categories?categoryId=". static::$products_category->id . "&page=" . $page_number;

            array_push(static::$data["linksData"]["links"], $link);
        }
    }


    public function index(ProductCategory $products_category)
    {

        static::$products_category = $products_category;

        static::prepareNavCategories();

        static::loadCategoryData();

        static::loadCategoryProducts();

        if (!$products_category->is_leaf_category) {
            static::loadSubCategories();
        }

        static::prepareLinksData();

        dd(static::$data);

        return view("shop.categories.index", ["data" => static::$data]);
    }
}
