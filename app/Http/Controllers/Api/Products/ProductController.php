<?php

namespace App\Http\Controllers\Api\Products;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function search(Request $request, Response $response)
    {

        $pattern = "%" . $request->input("data") . "%";

        $page = $request->input("page", 1);

        $productsData = Product::where("name", "like", $pattern)->addSelect([
            'added_by_username' => User::whereColumn('users.id', 'products.added_by')
                ->select('users.username'),

            "brand_name" => Brand::select("name")
                ->whereColumn('brands.id', 'products.brand_id'),
        ])->paginate(env("productPagination"), ['*'], 'page', $page);

        return response()->json(
            [
                "htmlView" => view("components.dashboard.products.products_table", compact('productsData'))->render(),
            ],
            200
        );
    }

    public function filter(Request $request, Response $response)
    {

        $filter = $request->input("data");

        $page = $request->input("page", 1);

        $productsFilterQuery = Product::query();

        if (isset($filter['id'])) {
            $productsFilterQuery = $productsFilterQuery->where('id', $filter['id']);
        }
        if (isset($filter['name'])) {
            $productsFilterQuery = $productsFilterQuery->where('name', 'like', $filter['name']);
        }
        if (isset($filter['description'])) {
            $productsFilterQuery = $productsFilterQuery->where('description', 'like', $filter['description']);
        }
        if (isset($filter['is_active'])) {
            $productsFilterQuery = $productsFilterQuery->where('is_active', $filter['is_active']);
        }

        $productsFilterQuery = $productsFilterQuery->whereBetween('price', [$filter["price"]["from"], $filter["price"]["to"]]);

        if ($filter['include_null_rating'] === 1) {
            $productsFilterQuery = $productsFilterQuery->where(function (Builder $query) use ($filter) {
                $query->whereBetween('rating', [$filter["rating"]["from"], $filter["rating"]["to"]])
                    ->orWhere('rating', null);
            });
        } else {
            $productsFilterQuery = $productsFilterQuery->whereBetween('rating', [$filter["rating"]["from"], $filter["rating"]["to"]]);
        }

        $productsFilterQuery = $productsFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);

        $productsFilterQuery = $productsFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);

        if (isset($filter['added_by'])) {
            $productsFilterQuery = $productsFilterQuery->whereHas('addedBy', function (Builder $query) use ($filter) {
                $query->whereHas('person', function (Builder $query) use ($filter) {
                    $query->where('username', $filter['added_by']);
                });
            });
        }

        if (isset($filter['product_category_name'])) {
            $productsFilterQuery = $productsFilterQuery->whereHas('categories', function (Builder $query) use ($filter) {
                $query->where('name', $filter['product_category_name']);
            });
        }

        if (isset($filter['brand_name'])) {
            $productsFilterQuery = $productsFilterQuery->whereHas('brand', function (Builder $query) use ($filter) {
                $query->where('name', $filter['brand_name']);
            });
        }


        $productsData = $productsFilterQuery->addSelect([

            'added_by_username' => User::whereColumn('users.id', 'products.added_by')
                ->select('users.username'),

            "brand_name" => Brand::select("name")
                ->whereColumn('brands.id', 'products.brand_id'),
        ])->paginate(env("productPagination"), ['*'], 'page', $page);

        return response()->json(
            [
                "htmlView" => view("components.dashboard.products.products_table", compact('productsData'))->render(),
            ],
            200
        );
    }
}
