<?php

namespace App\Http\Controllers\Web\Shop\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function store(Request $request)
    {

        try {

            DB::transaction(function () use ($request) {

                $session_id = $request->session()->getId();

                $item_quantity = $request->input("item_quantity");

                $product_variation = ProductVariation::where("id", $request->input("variation_id"))->with("product")->first();

                if ($product_variation->price != null) {
                    $item_price = $product_variation->price * $item_quantity;
                } else {
                    $item_price = $product_variation->product->price * $item_quantity;
                }

                $cart = Cart::where("session_id", $session_id)->first();

                if ($cart === null) {

                    $cart = Cart::create([
                        "session_id" => $session_id,
                        "items_count" => 1,
                        "total_price" => $item_price
                    ]);

                    if (!$cart) {
                        throw new \Exception("échec de la création de l'enregistrement dans la table 'carts'");
                    }
                } else {

                    $cart->updated_at = time();
                    $cart->total_price += $item_price;
                    $cart->items_count++;

                    if (!$cart->save()) {
                        throw new \Exception("échec de modifier la cart " . $cart->id . " dans la table 'carts'");
                    }
                }

                if (!CartItem::create([
                    "cart_id" => $cart->id,
                    "productVariation_id" => $product_variation->id,
                    "quantity" => $item_quantity,
                    "price" => $item_price
                ])) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'cartsItems'");
                }

                $product_variation->quantity_in_stock -= (int)$item_quantity;

                if (!$product_variation->save()) {
                    throw new \Exception("échec de modifier | quantity_in_stock | de la variation " . $product_variation->id . " dans la table 'carts'");
                }

            });

            $message = [
                "type" => "success",
                "text" => "le produit est bien ajouter au panier."
            ];
        } catch (\Exception $th) {

            $error_code = explode(": ", $th->getMessage())[0];

            $message = [
                "type" => "danger",
                "text" => $error_code == "SQLSTATE[23000]"
                    ? "l ajout du produit au panier a échoué. la variation est déja été ajouté au panier"
                    : "l ajout du produit au panier a échoué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {

            $product_id = ProductVariation::find($request->input("variation_id"))->product_id;

            return to_route("shop.product", ["product" => $product_id])->with("message", $message);
        }
    }
}
