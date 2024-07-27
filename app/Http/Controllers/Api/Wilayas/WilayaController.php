<?php

namespace App\Http\Controllers\Api\Wilayas;

use App\Models\Commune;
use App\Http\Controllers\Controller;

class WilayaController extends Controller
{

    public function getWilayaCommunes(int $wilaya_id) {

        $communes = Commune::where("wilaya_id", $wilaya_id)->get()->toArray();

        return response()->json(["communes" => $communes], 200);
    }
}
