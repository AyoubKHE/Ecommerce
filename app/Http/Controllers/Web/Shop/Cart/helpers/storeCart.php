<?php

namespace App\Http\Controllers\Web\Shop\Cart\helpers;

use App\Models\Cart;
use App\Models\Brand;
use App\Models\Product;
use App\Models\CartItem;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductAttributeOption;
use App\Models\ProductCategory_Product;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductVariation_AttributeOption;
use App\Services\SubCategories\SubCategoriesService;


class storeCart
{
    private static Request $request;

    private static ?Cart $cart;

    private static ProductVariation $product_variation;

    private static string $session_id;
    private static int $item_quantity;
    private static float $item_price;


    //! -----------------------------------------------------------------------------------------------------------------------------------


    private static function prepareData()
    {
        static::$session_id = static::$request->session()->getId();

        static::$item_quantity = static::$request->input("item_quantity");

        static::$product_variation = ProductVariation::where("id", static::$request->input("variation_id"))->with("product")->first();

        if (static::$product_variation->price != null) {
            static::$item_price = static::$product_variation->price * static::$item_quantity;
        } else {
            static::$item_price = static::$product_variation->product->price * static::$item_quantity;
        }

    }

    private static function storeCart()
    {
        static::$cart = Cart::where("session_id", static::$session_id)->first();

        if (static::$cart === null) {

            static::$cart = Cart::create([
                "session_id" => static::$session_id,
                "items_count" => 1,
                "total_price" => static::$item_price
            ]);

            if (!static::$cart) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'carts'");
            }
        } else {

            static::$cart->updated_at = time();
            static::$cart->total_price += static::$item_price;
            static::$cart->items_count++;

            if (!static::$cart->save()) {
                throw new \Exception("échec de modifier la cart " . static::$cart->id . " dans la table 'carts'");
            }
        }
    }

    private static function storeCartItem()
    {
        if (!CartItem::create([
            "cart_id" => static::$cart->id,
            "productVariation_id" => static::$product_variation->id,
            "quantity" => static::$item_quantity,
            "price" => static::$item_price
        ])) {
            throw new \Exception("échec de la création de l'enregistrement dans la table 'cartsItems'");
        }
    }

    private static function updateProductVariation()
    {
        static::$product_variation->quantity_in_stock -= (int)static::$item_quantity;

        if (!static::$product_variation->save()) {
            throw new \Exception("échec de modifier | quantity_in_stock | de la variation " . static::$product_variation->id . " dans la table 'carts'");
        }
    }


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(Request $request): RedirectResponse
    {
        static::$request = $request;

        static::prepareData();

        try {

            DB::transaction(function () {

                static::storeCart();

                static::storeCartItem();

                static::updateProductVariation();
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

            $product_id = static::$product_variation->product_id;

            return to_route("shop.product", ["product" => $product_id])->with("message", $message);
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
