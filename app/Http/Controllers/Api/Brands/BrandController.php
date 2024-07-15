<?php

namespace App\Http\Controllers\Api\Brands;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{

    public function search(Request $request, Response $response)
    {
        $pattern = "%" . $request->input("data") . "%";

        $page = $request->input("page", 1);

        $brandsData = Brand::where('name', 'like', $pattern)->addSelect(
            [
                'added_by_username' => User::whereColumn('users.id', 'brands.added_by')
                    ->select('users.username'),

                'quantity_of_products' => Product::select(DB::raw('count(*)'))
                    ->whereColumn('brand_id', 'brands.id'),
            ]
        )->paginate(env("brandsPagination"), ['*'], 'page', $page);

        return response()->json(
            [
                "htmlView" => view("components.dashboard.brands.brands_table", compact('brandsData'))->render(),
            ],
            200
        );
    }



    public function filter(Request $request, Response $response)
    {

        $filter = $request->input("data");

        $page = $request->input("page", 1);

        $brandsFilterQuery = Brand::query();

        if (isset($filter['id'])) {
            $brandsFilterQuery = $brandsFilterQuery->where('id', $filter['id']);
        }
        if (isset($filter['name'])) {
            $brandsFilterQuery = $brandsFilterQuery->where('name', 'like', $filter['name']);
        }
        if (isset($filter['description'])) {
            $brandsFilterQuery = $brandsFilterQuery->where('description', 'like', $filter['description']);
        }
        if (isset($filter['is_active'])) {
            $brandsFilterQuery = $brandsFilterQuery->where('is_active', $filter['is_active']);
        }
        if (isset($filter['created_at'])) {
            $brandsFilterQuery = $brandsFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);
        }
        if (isset($filter['updated_at'])) {
            $brandsFilterQuery = $brandsFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);
        }

        if (isset($filter['added_by'])) {
            $brandsFilterQuery = $brandsFilterQuery->whereHas('addedBy', function (Builder $query) use ($filter) {
                $query->whereHas('person', function (Builder $query) use ($filter) {
                    $query->where('username', $filter['added_by']);
                });
            });
        }


        if (isset($filter['quantity_of_products'])) {
            $brandsFilterQuery = $brandsFilterQuery->has('products', '>=', $filter['quantity_of_products']["from"])
                ->has('products', '<=', $filter['quantity_of_products']["to"]);
        }

        $brandsData = $brandsFilterQuery->addSelect(
            [
                'added_by_username' => User::whereColumn('users.id', 'brands.added_by')
                    ->select('users.username'),

                'quantity_of_products' => Product::select(DB::raw('count(*)'))
                    ->whereColumn('brand_id', 'brands.id'),
            ]
        )->paginate(env("brandsPagination"), ['*'], 'page', $page);

        return response()->json(
            [
                "htmlView" => view("components.dashboard.brands.brands_table", compact('brandsData'))->render(),
            ],
            200
        );
    }
}
