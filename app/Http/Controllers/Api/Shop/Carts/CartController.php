<?php

namespace App\Http\Controllers\API\Shop\Carts;


use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;


use App\Http\Controllers\Api\Shop\Carts\helpers\destroyCartItem;

class CartController extends Controller
{
    public function destroy(int $cart_id, int $productVariation_id): JsonResponse
    {

        return destroyCartItem::start($cart_id, $productVariation_id);

    }
}
