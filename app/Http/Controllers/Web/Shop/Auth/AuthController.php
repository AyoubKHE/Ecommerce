<?php

namespace App\Http\Controllers\Web\Shop\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ClientRegisterRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Web\Shop\Auth\helpers\login;
use App\Http\Controllers\Web\Shop\Auth\helpers\register;
use App\Http\Controllers\Web\Shop\Auth\helpers\registerForm;
use Carbon\Carbon;

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

        $current_user =  User::find(auth()->user()->id);

        $current_user->last_login = now();

        $current_user->save();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route("shop.auth.login.index");
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

            return to_route("shop.auth.login.index")->with("message", $message);
        }
    }
}
