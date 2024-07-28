<?php

namespace App\Http\Controllers\Web\Shop\Checkout\helpers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Wilaya;
use App\Models\Address;
use App\Models\Commune;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\User_Address;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use App\Models\ChargilyPayment;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use function Laravel\Prompts\select;
use App\Services\SubCategories\SubCategoriesService;

class orderValidation extends Controller
{

    private static Request $request;

    private static array $order_data;


    private static function prepareOrderStatus()
    {
        $pending_status_id = OrderStatus::where("status", "Paiement en attente")->first()->id;

        static::$order_data["orderStatus_id"] = $pending_status_id;
    }
    private static function prepareShippingMethod()
    {
        static::$order_data["shippingMethod_id"] = static::$request->input("shipping_method_id");
    }
    private static function prepareOrderData()
    {
        static::$order_data["user_id"] = auth()->user()->id;

        static::prepareOrderStatus();

        static::prepareShippingMethod();

        $cart_data = Cart::where("id", static::$request->input("cart_id"))->first();

        static::$order_data["items_count"] = $cart_data->items_count;

        $shipping_price = ShippingMethod::where("id", static::$order_data["shippingMethod_id"])
            ->select("price")
            ->first()
            ->price;

        static::$order_data["total_price"] = $cart_data->total_price + $shipping_price;
        static::$order_data["more_details"] = "Paiement en attente";
    }


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
    private static function manageOrderAddress()
    {

        if (static::$request->input("user_address") == null || static::$request->input("user_address") == "new_address") {
            static::createNewAddressRecord();
        } else {
            static::$order_data["address_id"] = static::$request->input("user_address");
        }
    }


    private static function deleteCart()
    {
        $cart = Cart::where("id", static::$request->input("cart_id"))->first();
        if (!$cart->delete()) {
            throw new \Exception("échec de supprimer l'enregistrement dans la table 'carts'");
        }
    }


    private static function createPayment(int $order_id, float $amount): ChargilyPayment
    {
        $payment = ChargilyPayment::create([
            "user_id"  => auth()->user()->id,
            "order_id" => $order_id,
            "status"   => "en attente",
            "currency" => "dzd",
            "amount"   => $amount,
        ]);

        if (!$payment) {
            throw new \Exception("échec de la création de l'enregistrement dans la table 'chargilyPayments'");
        }

        return $payment;
    }


    private static function createOrderItems(int $order_id)
    {
        $cart_items = CartItem::where("cart_id", static::$request->input("cart_id"))->get();

        foreach ($cart_items as $cart_item) {
            if (!OrderItem::create([
                "order_id" => $order_id,
                "productVariation_id" => $cart_item->productVariation_id,
                "quantity" => $cart_item->quantity,
                "price" => $cart_item->price
            ])) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'orderItems'");
            }
        }
    }


    private static function createOrder(): Order
    {
        static::manageOrderAddress();

        $order = Order::create(static::$order_data);

        if (!$order) {
            throw new \Exception("échec de la création de l'enregistrement dans la table 'orders'");
        }

        return $order;
    }


    public static function start(Request $request)
    {

        static::$request = $request;

        static::prepareOrderData();

        try {

            $payment = null;

            DB::transaction(function () use(&$payment) {

                $order = static::createOrder();

                static::createOrderItems($order->id);

                static::deleteCart();

                $payment = static::createPayment($order->id, $order->total_price);
            });

            return to_route("chargilypay.redirect", $payment->id);

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
