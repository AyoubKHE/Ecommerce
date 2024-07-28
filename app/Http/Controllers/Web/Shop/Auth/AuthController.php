<?php

namespace App\Http\Controllers\Web\Shop\Auth;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ClientRegisterRequest;
use App\Http\Controllers\Web\Shop\Auth\helpers\login;
use App\Http\Controllers\Web\Shop\Auth\helpers\logout;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Web\Shop\Auth\helpers\register;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Web\Shop\Auth\helpers\registerForm;

class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view("shop.auth.login");
    }

    public function login(Request $request): RedirectResponse
    {
        return login::start($request);
    }

    public function logout(Request $request): RedirectResponse
    {

        return logout::start($request);

        // $session_id = $request->cookie()["laravel_session"];

        // $cart = Cart::where("session_id", $session_id)->first();


        // if ($cart != null) {
        //     // !!!!!!! il faut rendre les variation à leur place
        //     if (!$cart->delete()) {
        //         // log cart id in register...
        //     }
        // }


        // $current_user =  User::find(auth()->user()->id);

        // $current_user->last_login = now();

        // $current_user->save();

        // Auth::logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // return to_route("shop.auth.login.index");
    }


    public function registerForm()
    {
        return registerForm::start();
    }

    public function register(ClientRegisterRequest $client_register_request)
    {
        return register::start($client_register_request);
    }

    public function verifyEmail(string $token)
    {
        $user = User::where("email_verification_token", $token)->first();
        if ($user == null) {

            $message = [
                "type" => "warning",
                "text" => "La confirmation de votre email n est pas réussi. Veuillez inscrire à nouveau svp"
            ];

            return to_route("shop.auth.register.form")->with("message", $message);
        } else {

            $user->email_verified_at = Carbon::now();
            $user->is_active = 1;
            $user->email_verification_token = NULL;

            if (!$user->save()) {
                $message = [
                    "type" => "warning",
                    "text" => "Votre email a été confirmé avec succès.
                    Cependant, nous avons rencontré un problème technique. Veuillez contacter notre support pour assistance."
                ];

                return to_route("shop.auth.register.form")->with("message", $message);
            } else {
                $message = [
                    "type" => "success",
                    "text" => "La confirmation de votre compte a réussi."
                ];
            }

            if ($user->role === "client") {
                return to_route("shop.auth.login.index")->with("message", $message);
            } else {
                return to_route("dashboard.auth.login.index")->with("message", $message);
            }
        }
    }
}
