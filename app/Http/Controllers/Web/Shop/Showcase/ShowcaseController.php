<?php

namespace App\Http\Controllers\Web\Shop\Showcase;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory_Product;
use App\Services\SubCategories\SubCategoriesService;

class ShowcaseController extends Controller
{
    public function index()
    {

        $data["navCategories"] = ProductCategory::where("show_on_website_header", 1)->select("id", "name", "image_path")
            ->addSelect([

                'subCategories' => DB::table('productscategories AS t2')
                    ->whereColumn('t2.parent_id', 'productscategories.id')
                    ->select(DB::raw("GROUP_CONCAT(CONCAT(t2.id, ' : ' , t2.name) SEPARATOR ', ')"))

            ])->get()
            ->toArray();

        foreach ($data["navCategories"] as &$nav_category) {

            $nav_category["brands"] = SubCategoriesService::getActiveProductsBrandsListForSpecificCategory($nav_category["id"]);
        }

        return view("shop.index", compact("data"));
    }
}
