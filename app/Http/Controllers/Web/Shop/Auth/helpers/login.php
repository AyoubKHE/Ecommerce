<?php

namespace App\Http\Controllers\Web\Shop\Auth\helpers;

use App\Models\Cart;
use App\Models\User;
use App\Services\JWTService;
use Illuminate\Http\Request;
use App\Mail\EmailValidation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;


class login
{

    private static Request $request;

    private static array $credentials;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------


    private static function logoutUser()
    {
        $current_user =  User::find(auth()->user()->id);

        $current_user->last_login = now();

        $current_user->save();

        Auth::logout();

        static::$request->session()->invalidate();

        static::$request->session()->regenerateToken();
    }


    private static function changeCartSessionId(): bool
    {
        $old_session_id = static::$request->cookie()["laravel_session"];

        static::$request->session()->regenerate();

        $new_session_id = static::$request->session()->getId();

        $cart = Cart::where("session_id", $old_session_id)->first();

        if ($cart) {
            return $cart->update(["session_id" => $new_session_id]) > 0;
        }

        return true;
    }


    private static function performLogin(): RedirectResponse
    {
        if (auth()->attempt(static::$credentials)) {

            if (auth()->user()->is_active == 0) {

                if (auth()->user()->email_verification_token == "") {
                    static::logoutUser();

                    $message = [
                        "type" => "warning",
                        "text" => "Vous n avez pas access à votre compte. Veuillez contacter notre support pour assistance."
                    ];

                    return back()->with("message", $message);
                } else {

                    Mail::to(auth()->user()->email)->send(new EmailValidation(auth()->user()->first_name, auth()->user()->email_verification_token));

                    $message = [
                        "type" => "success",
                        "text" => "Votre compte n est pas encore confirmé.
                        Un email de confirmation vous a été envoyé. Veuillez vérifier votre boîte de réception pour confirmer votre adresse email."
                    ];

                    return back()->with("message", $message);
                }
            } else {
                if (static::changeCartSessionId()) {
                    return to_route("shop.showcase");
                }
                else {

                    $message = [
                        "type" => "warning",
                        "text" => "Veuillez remplir votre panier à nouveau svp !"
                    ];

                    return back();
                }

            }
        } else {

            $message = [
                "type" => "danger",
                "text" => "email ou mot de passe incorrect"
            ];

            return back()->with("message", $message);
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(Request $request): RedirectResponse
    {
        static::$request = $request;

        static::$credentials = $request->validate([
            "email" => ['required'],
            // "password" => ["required", "min:5", "max:50"],
            "password" => ["required"],
        ]);

        return static::performLogin();
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
