<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use App\Services\JWTService;
use Illuminate\Http\Request;
use App\Mail\EmailValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;


class login
{

    private static Request $request;

    private static array $credentials;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function buildRefreshToken(): string
    {
        $refresh_token_payload = [
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + 2592000, // 1 mois
            "ip_addresse" => static::$request->ip(),
        ];

        $refresh_jwt = new JWTService($refresh_token_payload);
        return $refresh_jwt->getJwtToken();
    }


    private static function buildAccessToken(): string
    {
        $access_token_payload = [
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + 600, // 10 minutes
            "ip_addresse" => static::$request->ip(),
            "user_data" => array(
                "user_id" => auth()->user()->id,
            )
        ];

        $access_jwt = new JWTService($access_token_payload);
        return $access_jwt->getJwtToken();
    }


    private static function logoutUser()
    {
        $current_user =  User::find(auth()->user()->id);

        $current_user->last_login = now();

        $current_user->save();

        Auth::logout();

        static::$request->session()->invalidate();

        static::$request->session()->regenerateToken();
    }

    private static function performLogin(): RedirectResponse
    {
        if (auth()->attempt(static::$credentials)) {

            if (auth()->user()->role == "admin" || auth()->user()->role == "user") {

                if (auth()->user()->is_active == 0) {

                    if (auth()->user()->email_verification_token == "") {

                        $message = [
                            "type" => "warning",
                            "text" => "Vous n avez pas access à votre compte. Veuillez contacter notre support pour assistance."
                        ];

                    } else {

                        try {
                            Mail::to(auth()->user()->email)->send(new EmailValidation(auth()->user()->first_name, auth()->user()->email_verification_token));

                            $message = [
                                "type" => "success",
                                "text" => "Votre compte n est pas encore confirmé.
                                Un email de confirmation vous a été envoyé. Veuillez vérifier votre boîte de réception pour confirmer votre adresse email."
                            ];
                        } catch (\Exception $e) {

                            $message = [
                                "type" => "warning",
                                "text" => "Votre compte n est pas encore confirmé."
                            ];
                        }

                    }

                    static::logoutUser();

                    return back()->with("message", $message);
                } else {

                    $access_token = static::buildAccessToken();

                    $refresh_token = static::buildRefreshToken();

                    static::$request->session()->regenerate();

                    return to_route("dashboard.index")->withCookies(
                        [
                            cookie("access_token", $access_token, httpOnly: true, secure: true),
                            cookie("refresh_token", $refresh_token, httpOnly: true, secure: true),
                        ]
                    );
                }
            } else {

                static::logoutUser();

                $message = [
                    "type" => "danger",
                    "text" => "email ou mot de passe incorrect"
                ];

                return back()->with("message", $message);
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
            "username" => ['required'],
            // "password" => ["required", "min:5", "max:50"],
            "password" => ["required"],
        ]);

        return static::performLogin();
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
