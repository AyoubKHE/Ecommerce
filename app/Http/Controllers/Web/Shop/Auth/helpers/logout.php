<?php

namespace App\Http\Controllers\Web\Shop\Auth\helpers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


class logout
{

    private static Request $request;

    //! -----------------------------------------------------------------------------------------------------------------------------------

    private static function deleteCart()
    {

        $session_id = static::$request->cookie()["laravel_session"];

        $cart = Cart::where("session_id", $session_id)->first();

        if ($cart != null) {

            try {
                DB::transaction(function () use ($cart) {

                    $cart_items = $cart->items;

                    foreach ($cart_items as $cart_item) {

                        $product_variation = ProductVariation::where("id", $cart_item->productVariation_id)->first();

                        $product_variation->quantity_in_stock += (int)$cart_item->quantity;

                        if (!$product_variation->save()) {
                            throw new \Exception("échec de modifier | quantity_in_stock | de la variation " . $product_variation->id . " dans la table | productsVariations |");
                        }
                    }

                    if (!$cart->delete()) {
                        throw new \Exception("échec de supprimer l'enregistrement dans la table | carts |");
                    }
                });
            } catch (\Exception $e) {
                // log cart id in register...
            }
        }
    }

    private static function updateLastLoginField()
    {
        $current_user =  User::find(auth()->user()->id);

        $current_user->last_login = now();

        try {
            if (!$current_user->save()) {
                throw new \Exception("échec de modifier | last_login | du client " . $current_user->id . " dans la table | users |");
            }
        } catch (\Exception $e) {
            // log user id in register...
        }
    }

    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(Request $request): RedirectResponse
    {
        static::$request = $request;

        static::deleteCart();

        static::updateLastLoginField();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route("shop.auth.login.index");
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
