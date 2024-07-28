<?php

namespace App\Http\Controllers\Web\Shop\Payment;

use Illuminate\Http\Request;
use App\Models\ChargilyPayment;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Shop\Payment\helpers\webhook;
use Chargily\ChargilyPay\ChargilyPay;
use Chargily\ChargilyPay\Auth\Credentials;

class ChargilyPayController extends Controller
{
    /**
     * The client will be redirected to the ChargilyPay payment page
     *
     */
    public function redirect(ChargilyPayment $payment)
    {
        $checkout = $this->chargilyPayInstance()->checkouts()->create([
            "metadata" => [
                "payment_id" => $payment->id,
            ],
            "locale" => "ar",
            "amount" => $payment->amount,
            "currency" => $payment->currency,
            "description" => "Payment ID={$payment->id}",
            "success_url" => route("chargilypay.back"),
            "failure_url" => route("chargilypay.back"),
            "webhook_endpoint" => route("chargilypay.webhook_endpoint"),
        ]);
        if ($checkout) {
            return redirect($checkout->getUrl());
        }
    }
    /**
     * Your client you will redirected to this link after payment is completed ,failed or canceled
     *
     */
    public function back(Request $request)
    {

        return to_route("shop.showcase");

        // $user = auth()->user();
        // $checkout_id = $request->input("checkout_id");
        // $checkout = $this->chargilyPayInstance()->checkouts()->get($checkout_id);
        // $payment = null;

        // if ($checkout) {
        //     $metadata = $checkout->getMetadata();
        //     $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);
        //     ////
        //     //// Is not recomended to process payment in back page / success or fail page
        //     //// Doing payment processing in webhook for best practices
        //     ////
        // }
        // dd($checkout, $payment);
    }
    /**
     * This action will be processed in the background
     */
    public function webhook()
    {
        $webhook = $this->chargilyPayInstance()->webhook()->get();

        webhook::start($webhook);
    }

    /**
     * Just a shortcut
     */
    protected function chargilyPayInstance()
    {
        return new ChargilyPay(new Credentials([
            "mode" => "test",
            "public" => env("PUBLIC_KEY"),
            "secret" => env("SECRET_KEY"),
        ]));
    }
}
