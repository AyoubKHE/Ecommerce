<?php

namespace App\Http\Controllers\Api\Wilayas;

use App\Models\Commune;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
use App\Http\Controllers\Controller;
use App\Models\ProductAttributeOption;
use App\Http\Resources\ProductAttributeResource;
use App\Models\Wilaya;

class WilayaController extends Controller
{

    public function getWilayaCommunes(string $wilaya_name) {

        $wilaya = Wilaya::where("name", $wilaya_name)->first();

        if($wilaya !== null) {

            $communes = Commune::where("wilaya_id", $wilaya->id)->pluck("name")->all();

            return response()->json(["communes" => $communes], 200);
        }
        else {
            response()->json(404);
        }
    }
}
