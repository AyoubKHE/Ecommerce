<?php

namespace App\Http\Controllers\Api\Shop\Carts\helpers;


use App\Models\CartItem;

use Illuminate\Support\Facades\DB;
use App\Models\ProductVariation;
use Illuminate\Http\JsonResponse;


class destroyCartItem
{
    private static CartItem $cart_item;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------


    private static function updateProductVariation()
    {
        $product_variation = ProductVariation::where("id", static::$cart_item->productVariation_id)->first();

        $product_variation->quantity_in_stock += (int)static::$cart_item->quantity;

        if (!$product_variation->save()) {
            throw new \Exception("échec de modifier | quantity_in_stock | de la variation " . $product_variation->id . ".");
        }
    }

    private static function updateCart()
    {
        $cart = static::$cart_item->cart;

        if ($cart->items->count() == 1) {
            if (!$cart->delete()) {
                throw new \Exception("échec de supprimer l enregistrement dans la table 'carts'");
            }
        } else {

            $cart->updated_at = time();
            $cart->items_count -= 1;
            $cart->total_price -= (int)static::$cart_item->price;

            if (!$cart->save()) {
                throw new \Exception("échec de modifier la cart " . $cart->id . " dans la table 'carts'");
            }

            if (!static::$cart_item->delete()) {
                throw new \Exception("échec de supprimer l enregistrement dans la table 'cartsItems'");
            }
        }
    }


    //! -----------------------------------------------------------------------------------------------------------------------------------



    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------


    public static function start(int $cart_id, int $productVariation_id): JsonResponse
    {
        static::$cart_item = CartItem::where("cart_id", $cart_id)
            ->where("productVariation_id", $productVariation_id)
            ->first();

        try {
            DB::transaction(function () {

                static::updateProductVariation();

                static::updateCart();

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

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
