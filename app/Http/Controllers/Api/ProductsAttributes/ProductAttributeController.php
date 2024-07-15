<?php

namespace App\Http\Controllers\Api\ProductsAttributes;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductAttributeResource;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{

    public function getAttributeOptions(string $attribute_name) {

        $attribute = ProductAttribute::where("name", $attribute_name)->first();

        if($attribute !== null) {

            $productOptions = ProductAttributeOption::where("productAttribute_id", $attribute->id)->pluck("value");
            return response()->json(["productOptions" => $productOptions], 200);
        }
        else {
            response()->json(404);
        }
    }
}
