<?php

namespace App\Http\Controllers\Web\Shop\Payment\helpers;


use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\ChargilyPayment;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Chargily\ChargilyPay\Elements\WebhookElement;
use Chargily\ChargilyPay\Elements\CheckoutElement;


class webhook extends Controller
{
    private static Order $order;

    private static function updateProductsVariationsQuantity()
    {
        $order_items = static::$order->items;

        foreach ($order_items as $order_item) {

            $product_variation = ProductVariation::where("id", $order_item->productVariation_id)->first();

            $product_variation->quantity_in_stock += (int)$order_item->quantity;

            if (!$product_variation->save()) {
                throw new \Exception("échec de modifier | quantity_in_stock | de la variation " . $product_variation->id . " dans la table | productsVariations |");
            }
        }
    }

    private static function modifiyCancledOrderStatus()
    {

        $cancled_payment_status_id = OrderStatus::where("status", "Annulé")
            ->select("id")
            ->first()
            ->id;

        static::$order->orderStatus_id = $cancled_payment_status_id;
        static::$order->more_details = "Probleme dans le payment";

        if (!static::$order->save()) {
            throw new \Exception("échec de mettre à jour l'enregistrement dans la table 'orders'");
        }
    }

    private static function cancelOrder()
    {
        try {

            DB::transaction(function () {
                static::modifiyCancledOrderStatus();

                static::updateProductsVariationsQuantity();
            });
        } catch (\Exception $e) {
            // logging order id
        }
    }


    private static function confirmOrder()
    {

        $confirmed_payment_status_id = OrderStatus::where("status", "Paiement confirmé")
            ->select("id")
            ->first()
            ->id;

        static::$order->orderStatus_id = $confirmed_payment_status_id;
        static::$order->more_details = "Le payment est confirmé";

        if (!static::$order->save()) {
            // logging order id
        }
    }


    public static function start(?WebhookElement $webhook)
    {
        if ($webhook) {
            //
            $checkout = $webhook->getData();
            //check webhook data is set
            //check webhook data is a checkout
            if ($checkout && $checkout instanceof CheckoutElement) {
                if ($checkout) {
                    $metadata = $checkout->getMetadata();
                    $payment = ChargilyPayment::find($metadata['payment_id']);

                    if ($payment) {

                        static::$order = Order::where("id", $payment->order_id)->first();

                        if ($checkout->getStatus() === "paid") {
                            $payment->status = "payé";
                            $payment->update();

                            static::confirmOrder();
                        } else {
                            if ($checkout->getStatus() === "failed") {
                                $payment->status = "échoué";
                                $payment->update();
                            } else if ($checkout->getStatus() === "canceled") {
                                $payment->status = "annulé";
                                $payment->update();
                            } else if ($checkout->getStatus() === "expired") {
                                $payment->status = "expiré";
                                $payment->update();
                            }

                            static::cancelOrder();
                        }
                    }
                }
            }
        }
        // return response()->json([
        //     "status" => false,
        //     "message" => "Invalid Webhook request",
        // ], 403);
    }
}
