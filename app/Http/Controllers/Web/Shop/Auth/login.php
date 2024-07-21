<?php

namespace App\Http\Controllers\Web\Shop\Auth;

use App\Models\User;
use App\Services\JWTService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


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

            if (auth()->user()->is_active == 0) {

                static::logoutUser();

                return to_route("dashboard.auth.login.index");
            }

            $access_token = static::buildAccessToken();

            $refresh_token = static::buildRefreshToken();

            static::$request->session()->regenerate();

            return to_route("dashboard.index")->withCookies(
                [
                    cookie("access_token", $access_token, httpOnly: true, secure: true),
                    cookie("refresh_token", $refresh_token, httpOnly: true, secure: true),
                ]
            );
        } else {

            $message = [
                "type" => "danger",
                "text" => "Username ou mot de passe incorrect"
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
