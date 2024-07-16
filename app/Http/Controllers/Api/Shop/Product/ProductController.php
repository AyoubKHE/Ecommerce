<?php

namespace App\Http\Controllers\API\Shop\Product;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductAttributeOption;
use App\Services\SubCategories\SubCategoriesService;

class ProductController extends Controller
{
    public function getProductVariations(int $product_id)
    {
        $product_variations = ProductVariation::where("product_id", $product_id)
            ->with("attributes_options_pivot", function ($query) {
                $query->with("attribute")->with("option");
            })->get()->toArray();

        return response()->json(
            [
                "productVariations" => $product_variations,
            ],
            200
        );
    }
}
