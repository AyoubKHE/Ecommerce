<?php

namespace App\Http\Controllers\Api\Shop\ProductsCategories;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Builder;

use App\Services\SubCategories\SubCategoriesService;


class ProductCategoryController extends Controller
{

    private static int $product_category_id;

    private static int $page;

    private static int $perPage;

    private static bool $is_leaf_category;


    private static function getSubCategoriesCount()
    {
        $subCategories = ProductCategory::where("parent_id", static::$product_category_id)->get()->toArray();

        foreach ($subCategories as $sub_category) {

            $products_count = SubCategoriesService::getActiveProductsCountForSpecificCategory((int)$sub_category["id"]);

            if ($products_count > 0) {

                $subCategoriesProductsCount[$sub_category["id"]]["category_name"] = $sub_category["name"];
                $subCategoriesProductsCount[$sub_category["id"]]["products_count"] = $products_count;
            }
        }

        return count($subCategoriesProductsCount);
    }

    private static function prepareLinksData()
    {
        $linksData["currentPage"] = static::$page;

        static::$is_leaf_category = DB::table("productsCategories")->where("id", static::$product_category_id)->select("is_leaf_category")->first()->is_leaf_category;

        if (static::$is_leaf_category == 1) {

            static::$perPage = (int)env("shopProductsPagination");
        } else {

            static::$perPage =  static::getSubCategoriesCount() * (int)env("shopProductsPerCategoryPagination");
        }

        $products_count = SubCategoriesService::getActiveProductsCountForSpecificCategory(static::$product_category_id);

        $linksData["lastPage"] = ceil($products_count / static::$perPage);

        $linksData["links"] = [];

        for ($page_number = 1; $page_number <= $linksData["lastPage"]; $page_number++) {

            $link = "http://127.0.0.1:8000/api/shop/products-categories?categoryId=" . static::$product_category_id . "&page=" . $page_number;

            array_push($linksData["links"], $link);
        }

        return $linksData;
    }

    private static function loadCategoryProducts()
    {

        if (static::$is_leaf_category == 1) {

            $products = SubCategoriesService::getActiveProductsListForSpecificCategory(
                static::$product_category_id,
                (static::$page - 1) * static::$perPage,
                static::$perPage
            )["products"];
        } else {

            $products = SubCategoriesService::getActiveProductsListForSpecificCategory(
                static::$product_category_id,
                (static::$page - 1),
                (int)env("shopProductsPerCategoryPagination")
            )["products"];
        }

        return $products;
    }

    public function index(Request $request, Response $response)
    {

        $page = $request->query("page");

        $product_category_id = $request->query("categoryId");

        static::$product_category_id = $product_category_id;

        static::$page = $page;

        $linksData = static::prepareLinksData();

        $products = static::loadCategoryProducts();

        return response()->json(
            [
                "htmlView" => view("shop.layouts.products.products_table", compact('product_category_id', 'products', 'linksData'))->render(),
            ],
            200
        );
    }

    // public function filter(Request $request, Response $response)
    // {

    //     $filter = $request->input("data");

    //     $page = $request->input("page", 1);

    //     $productsCategoriesFilterQuery = ProductCategory::query();

    //     if (isset($filter['id'])) {
    //         $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->where('id', $filter['id']);
    //     }
    //     if (isset($filter['name'])) {
    //         $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->where('name', 'like', $filter['name']);
    //     }
    //     if (isset($filter['description'])) {
    //         $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->where('description', 'like', $filter['description']);
    //     }
    //     if (isset($filter['is_active'])) {
    //         $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->where('is_active', $filter['is_active']);
    //     }
    //     if (isset($filter['created_at'])) {
    //         $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);
    //     }
    //     if (isset($filter['updated_at'])) {
    //         $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);
    //     }

    //     if (isset($filter['added_by'])) {
    //         $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereHas('addedBy', function (Builder $query) use ($filter) {
    //             $query->whereHas('person', function (Builder $query) use ($filter) {
    //                 $query->where('username', $filter['added_by']);
    //             });
    //         });
    //     }

    //     if (isset($filter['base_category_name'])) {
    //         $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereHas('parentCategory', function (Builder $query) use ($filter) {
    //             $query->where('name', $filter['base_category_name']);
    //         });
    //     }

    //     // if (isset($filter['quantity_of_products'])) {
    //     //     $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->has('products', '>=', $filter['quantity_of_products']["from"])
    //     //         ->has('products', '<=', $filter['quantity_of_products']["to"]);
    //     // }

    //     // if (isset($filter['quantity_of_active_products'])) {
    //     //     $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereHas('productsPivot', function (Builder $query) use ($filter) {
    //     //         $query->where('is_active', 1);
    //     //     }, '>=', $filter['quantity_of_active_products']["from"])
    //     //         ->whereHas('productsPivot', function (Builder $query) use ($filter) {
    //     //             $query->where('is_active', 1);
    //     //         }, '<=', $filter['quantity_of_products']["to"]);
    //     // }

    //     $productsCategoriesData = $productsCategoriesFilterQuery->addSelect(
    //         [
    //             'added_by_username' => User::whereColumn('users.id', 'productscategories.added_by')
    //                 ->select('users.username'),

    //             'base_category_name' => DB::table('productscategories AS t2')->select('t2.name')
    //                 ->whereColumn('t2.id', 'productscategories.parent_id'),

    //         ]
    //     )->get();
    //     // paginate(env("productCategoriesPagination"), ['*'], 'page', $page);

    //     foreach ($productsCategoriesData as $key => $product_category_data) {
    //         $product_category_data->subCategoriesCount = SubCategoriesService::getSubCategoriesCountForSpecificCategory($product_category_data->id);
    //         $product_category_data->productsCount = SubCategoriesService::getProductsCountForSpecificCategory($product_category_data->id);
    //         $product_category_data->activeProductsCount = SubCategoriesService::getActiveProductsCountForSpecificCategory($product_category_data->id);
    //     }

    //     $linksData["currentPage"] = $page;
    //     $perPage = (int)env("productCategoriesPagination");
    //     $products_categories_count = count($productsCategoriesData);
    //     $linksData["lastPage"] = ceil($products_categories_count / $perPage);

    //     $linksData["links"] = [];
    //     for ($page_number = 1; $page_number <= $linksData["lastPage"]; $page_number++) {

    //         $link = "http://127.0.0.1:8000/products-categories?page=" . $page_number;

    //         array_push($linksData["links"], $link);
    //     }

    //     $productsCategoriesData = $productsCategoriesData->skip(($page - 1) * $perPage)->take($perPage);

    //     return response()->json(
    //         [
    //             "htmlView" => view("components.dashboard.productsCategories.products_categories_table", compact('productsCategoriesData', 'linksData'))->render(),
    //         ],
    //         200
    //     );
    // }
}
