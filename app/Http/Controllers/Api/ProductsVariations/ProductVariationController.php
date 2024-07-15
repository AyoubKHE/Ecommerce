<?php

namespace App\Http\Controllers\Api\ProductsVariations;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductVariation;
use App\Models\ProductVariation_AttributeOption;

class ProductVariationController extends Controller
{
    public function destroy(ProductVariation $products_variation, Request $request, Response $response)
    {
        try {
            DB::transaction(function () use ($products_variation) {

                $variation_options = ProductVariation_AttributeOption::where("productVariation_id", $products_variation->id)->get();

                foreach ($variation_options as $option) {
                    if (!$option->delete()) {
                        throw new \Exception("échec de supprimer l'enregistrement dans la table 'productsVariations_attributesOptions'");
                    }
                }

                if (!$products_variation->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'productsVariations'");
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
