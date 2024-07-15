<?php

namespace App\Http\Controllers\Web\Showcase;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategory_Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Web\Showcase\helpers\headerUpdate;
use Illuminate\Support\Collection;

use App\Services\SubCategories\SubCategoriesService;

class ShowcaseController extends Controller
{

    public function headerEdit()
    {
        $data['productCategoriesData'] = DB::table('productsCategories')->addSelect([

            'added_by_username' => User::whereColumn('users.id', 'productscategories.added_by')
                ->select('users.username'),

            'base_category_name' => DB::table('productscategories AS t2')->select('t2.name')
                ->whereColumn('t2.id', 'productscategories.parent_id'),
        ])
            ->where("is_active", 1)
            ->get();



        foreach ($data['productCategoriesData'] as $key => $product_category_data) {

            $product_category_data->subCategoriesCount = SubCategoriesService::getSubCategoriesCountForSpecificCategory($product_category_data->id);
            $product_category_data->productsCount = SubCategoriesService::getProductsCountForSpecificCategory($product_category_data->id);
            $product_category_data->activeProductsCount = SubCategoriesService::getActiveProductsCountForSpecificCategory($product_category_data->id);
        }

        // dd($data);

        $data['productCategoriesData'] = $data['productCategoriesData']->sortBy([
            ["subCategoriesCount", "desc"]
        ]);

        return view("dashboard.showcase.header", compact("data"));
    }

    public function headerUpdate(Request $request)
    {
        return headerUpdate::start($request);
    }

    public function bodyEdit()
    {
        return view("dashboard.showcase.body");
    }

    public function bodyUpdate(Request $request)
    {
    }
}
