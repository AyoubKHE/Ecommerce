<?php

namespace App\Http\Controllers\Web\Shop\Checkout\helpers;

use App\Models\Cart;
use App\Models\Wilaya;
use App\Models\Commune;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\ShippingMethod;
use App\Models\User_Address;
use App\Services\SubCategories\SubCategoriesService;

class orderValidation extends Controller
{

    private static Request $request;

    private static array $order_data;

    private static function createNewAddressRecord()
    {
        $address = Address::create([
            "address" => static::$request->input("address"),
            "commune_id" => static::$request->input("commune_id")
        ]);

        if (!$address) {
            throw new \Exception("échec de la création de l'enregistrement dans la table 'addresses'");
        }

        if (!User_Address::create([
            "user_id" => auth()->user()->id,
            "address_id" => $address->id,
            "is_default" => User_Address::where("user_id", auth()->user()->id)->count() == 0 ? 1 : 0,
            "is_active" => 1
        ])) {
            throw new \Exception("échec de la création de l'enregistrement dans la table 'users_addresses'");
        }

        static::$order_data["address_id"] = $address->id;
    }

    private static function manageOrderAddress() {
        if(static::$request->input("user_address") == null || static::$request->input("user_address") == "new_address") {
            static::createNewAddressRecord();
        }
        else {
            static::$order_data["address_id"] = static::$request->input("user_address");
        }
    }

    public static function start(Request $request)
    {

        static::$request = $request;

        // dd($request->all());

        try {

            DB::transaction(function () {
                static::manageOrderAddress();
            });

            // $message = [
            //     "type" => "success",
            //     "text" => "le produit est bien ajouter au panier."
            // ];

        } catch (\Exception $th) {

            // $error_code = explode(": ", $th->getMessage())[0];

            // $message = [
            //     "type" => "danger",
            //     "text" => $error_code == "SQLSTATE[23000]"
            //         ? "l ajout du produit au panier a échoué. la variation est déja été ajouté au panier"
            //         : "l ajout du produit au panier a échoué. Réessayer plus tard",
            //     "error" => $th->getMessage(),
            //     "file" => $th->getFile(),
            //     "line" => $th->getLine()
            // ];
        } finally {

            // $product_id = static::$product_variation->product_id;

            // return to_route("shop.product", ["product" => $product_id])->with("message", $message);
        }

        // return view("shop.checkout.index", ["data" => static::$data]);
    }
}
