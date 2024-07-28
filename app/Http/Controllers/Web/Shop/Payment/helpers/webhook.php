<?php

namespace App\Http\Controllers\Web\Shop\Payment\helpers;


use Illuminate\Http\Request;
use App\Models\ChargilyPayment;

use App\Http\Controllers\Controller;
use Chargily\ChargilyPay\Elements\WebhookElement;
use Chargily\ChargilyPay\Elements\CheckoutElement;


class webhook extends Controller
{
    private static Request $request;

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
                        if ($checkout->getStatus() === "paid") {
                            $payment->status = "payé";
                            $payment->update();
                            /////
                            ///// Confirm your order
                            /////
                            return response()->json(["status" => true, "message" => "Payment has been completed"]);
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

                            /////
                            ///// delete order
                            /////
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
