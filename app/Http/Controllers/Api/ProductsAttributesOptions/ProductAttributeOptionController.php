<?php

namespace App\Http\Controllers\Api\ProductsAttributesOptions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductAttributeOption;

class ProductAttributeOptionController extends Controller
{
    public function destroy(ProductAttributeOption $products_attribute_option, Request $request, Response $response)
    {
        try {
            DB::transaction(function () use ($products_attribute_option) {

                if (!$products_attribute_option->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'productsAttributesOptions'");
                }
            });

            $message = [
                "success" => true,
            ];

            $status = 200;
        } catch (\Exception $e) {

            $message = [
                "success" => false,
                "message" => $e->getMessage(),
                "file" => $e->getFile(),
                "line" => $e->getLine()
            ];

            $status = 500;
        } finally {

            return response()->json($message, $status);
            
        }
    }
}
