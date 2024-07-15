<?php

namespace App\Http\Controllers\Api\ProductsCategories;

use App\Models\User;
use App\Services\JWTService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\ProductCategory_Product;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductCategoryCollection;
use App\Services\SubCategories\SubCategoriesService;


class ProductCategoryController extends Controller
{


    public function search(Request $request, Response $response)
    {

        $pattern = "%" . $request->input("data") . "%";

        $page = $request->input("page", 1);

        $productsCategoriesData = DB::table('productsCategories')->where('name', 'like', $pattern)->addSelect(
            [

                'added_by_username' => User::whereColumn('users.id', 'productscategories.added_by')
                    ->select('users.username'),

                'base_category_name' => DB::table('productscategories AS t2')->select('t2.name')
                    ->whereColumn('t2.id', 'productscategories.parent_id'),
            ]
        )->get();
        // paginate(env("productCategoriesPagination"), ['*'], 'page', $page);


        foreach ($productsCategoriesData as $key => $product_category_data) {
            $product_category_data->subCategoriesCount = SubCategoriesService::getSubCategoriesCountForSpecificCategory($product_category_data->id);
            $product_category_data->productsCount = SubCategoriesService::getProductsCountForSpecificCategory($product_category_data->id);
            $product_category_data->activeProductsCount = SubCategoriesService::getActiveProductsCountForSpecificCategory($product_category_data->id);
        }

        $linksData["currentPage"] = $page;
        $perPage = (int)env("productCategoriesPagination");
        $products_categories_count = count($productsCategoriesData);
        $linksData["lastPage"] = ceil($products_categories_count / $perPage);

        $linksData["links"] = [];
        for ($page_number = 1; $page_number <= $linksData["lastPage"]; $page_number++) {

            $link = "http://127.0.0.1:8000/products-categories?page=" . $page_number;

            array_push($linksData["links"], $link);
        }

        $productsCategoriesData = $productsCategoriesData->skip(($page - 1) * $perPage)->take($perPage);

        return response()->json(
            [
                "htmlView" => view("components.dashboard.productsCategories.products_categories_table", compact('productsCategoriesData', 'linksData'))->render(),
            ],
            200
        );
    }

    public function filter(Request $request, Response $response)
    {

        $filter = $request->input("data");

        $page = $request->input("page", 1);

        $productsCategoriesFilterQuery = ProductCategory::query();

        if (isset($filter['id'])) {
            $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->where('id', $filter['id']);
        }
        if (isset($filter['name'])) {
            $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->where('name', 'like', $filter['name']);
        }
        if (isset($filter['description'])) {
            $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->where('description', 'like', $filter['description']);
        }
        if (isset($filter['is_active'])) {
            $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->where('is_active', $filter['is_active']);
        }
        if (isset($filter['created_at'])) {
            $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);
        }
        if (isset($filter['updated_at'])) {
            $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);
        }

        if (isset($filter['added_by'])) {
            $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereHas('addedBy', function (Builder $query) use ($filter) {
                $query->whereHas('person', function (Builder $query) use ($filter) {
                    $query->where('username', $filter['added_by']);
                });
            });
        }

        if (isset($filter['base_category_name'])) {
            $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereHas('parentCategory', function (Builder $query) use ($filter) {
                $query->where('name', $filter['base_category_name']);
            });
        }

        // if (isset($filter['quantity_of_products'])) {
        //     $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->has('products', '>=', $filter['quantity_of_products']["from"])
        //         ->has('products', '<=', $filter['quantity_of_products']["to"]);
        // }

        // if (isset($filter['quantity_of_active_products'])) {
        //     $productsCategoriesFilterQuery = $productsCategoriesFilterQuery->whereHas('productsPivot', function (Builder $query) use ($filter) {
        //         $query->where('is_active', 1);
        //     }, '>=', $filter['quantity_of_active_products']["from"])
        //         ->whereHas('productsPivot', function (Builder $query) use ($filter) {
        //             $query->where('is_active', 1);
        //         }, '<=', $filter['quantity_of_products']["to"]);
        // }

        $productsCategoriesData = $productsCategoriesFilterQuery->addSelect(
            [
                'added_by_username' => User::whereColumn('users.id', 'productscategories.added_by')
                    ->select('users.username'),

                'base_category_name' => DB::table('productscategories AS t2')->select('t2.name')
                    ->whereColumn('t2.id', 'productscategories.parent_id'),

            ]
        )->get();
        // paginate(env("productCategoriesPagination"), ['*'], 'page', $page);

        foreach ($productsCategoriesData as $key => $product_category_data) {
            $product_category_data->subCategoriesCount = SubCategoriesService::getSubCategoriesCountForSpecificCategory($product_category_data->id);
            $product_category_data->productsCount = SubCategoriesService::getProductsCountForSpecificCategory($product_category_data->id);
            $product_category_data->activeProductsCount = SubCategoriesService::getActiveProductsCountForSpecificCategory($product_category_data->id);
        }

        $linksData["currentPage"] = $page;
        $perPage = (int)env("productCategoriesPagination");
        $products_categories_count = count($productsCategoriesData);
        $linksData["lastPage"] = ceil($products_categories_count / $perPage);

        $linksData["links"] = [];
        for ($page_number = 1; $page_number <= $linksData["lastPage"]; $page_number++) {

            $link = "http://127.0.0.1:8000/products-categories?page=" . $page_number;

            array_push($linksData["links"], $link);
        }

        $productsCategoriesData = $productsCategoriesData->skip(($page - 1) * $perPage)->take($perPage);

        return response()->json(
            [
                "htmlView" => view("components.dashboard.productsCategories.products_categories_table", compact('productsCategoriesData', 'linksData'))->render(),
            ],
            200
        );
    }
}
