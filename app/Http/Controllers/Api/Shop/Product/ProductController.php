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
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductVariations(int $product_id, Request $request)
    {

        $filters = $request->query();

        $sub_query = DB::table('productsvariations_attributesoptions as pv_ao')
            ->join("productsAttributesOptions as pao", "pv_ao.productAttributeOption_id", "pao.id")
            ->join("productsAttributes as pa", "pv_ao.productAttribute_id", "pa.id")
            ->select('pv_ao.productVariation_id', DB::raw('GROUP_CONCAT(pa.name,"=", pao.value SEPARATOR ", ") AS variation_options'))
            ->whereIn('pv_ao.productVariation_id', function ($query) use ($product_id) {
                $query->select('pv.id')
                    ->from('productsvariations as pv')
                    ->where('pv.product_id', $product_id);
            })
            ->groupBy('pv_ao.productVariation_id');

        $main_query = DB::table(DB::raw("({$sub_query->toSql()}) as variations"))
            ->select('variations.productVariation_id', 'variations.variation_options')
            ->mergeBindings($sub_query);

        foreach ($filters as $column => $value) {

            $value = "%{$column}={$value}%";
            $main_query->whereRaw("variations.variation_options LIKE ?", $value);
        }

        $variations = $main_query->get();

        return response()->json(
            [
                "productVariations" => $variations,
            ],
            200
        );
    }

}
