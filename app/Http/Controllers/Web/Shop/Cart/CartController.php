<?php

namespace App\Http\Controllers\Web\Shop\Cart;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\CartItem;

class CartController extends Controller
{
    public function store(Request $request)
    {

        try {

            DB::transaction(function () use ($request) {

                $session_id = $request->session()->getId();

                $cart = Cart::where("session_id", $session_id)->first();

                if($cart === null) {

                    $cart = Cart::create([
                        "session_id" => $session_id
                    ]);

                    if (!$cart) {
                        throw new \Exception("échec de la création de l'enregistrement dans la table 'carts'");
                    }
                }

                if (!CartItem::create([
                    "cart_id" => $cart->id,
                    "productVariation_id" => $request->input("variation_id"),
                    "quantity" => $request->input("variation_quantity")
                ])) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'cartsItems'");
                }
            });

            $message = [
                "type" => "success",
                "text" => "le produit est bien ajouter au panier."
            ];
        } catch (\Exception $th) {

            $message = [
                "type" => "danger",
                "text" => "l'ajout du produit a échoué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return to_route("shop.product", ["product" => 2])->with("message", $message);
        }
    }
}
