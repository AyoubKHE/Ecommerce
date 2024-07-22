<?php

namespace App\Http\Controllers\Web\Shop\Auth\helpers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Services\JWTService;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ClientRegisterRequest;
use App\Mail\EmailValidation;
use App\Services\SubCategories\SubCategoriesService;


class register
{

    private static ClientRegisterRequest $client_register_request;

    private static array $client_form_fields;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function preparingData(): void
    {

        static::$client_form_fields["password"] = Hash::make(static::$client_form_fields["password"]);

        static::$client_form_fields["email_verification_token"] = Str::random(60);

        static::$client_form_fields["role"] = "client";

        static::$client_form_fields["is_active"] = 0;
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(ClientRegisterRequest $client_register_request)
    {
        static::$client_register_request = $client_register_request;

        static::$client_form_fields = $client_register_request->validated();

        static::preparingData();

        try {
            DB::transaction(function () {

                $user = User::create(static::$client_form_fields);

                if (!$user) {
                    throw new \Exception("La creation de votre compte a échoué. Réessayer plus tard");
                }

                Mail::to($user->email)->send(new EmailValidation($user->first_name, $user->email_verification_token));
            });

            $message = [
                "type" => "success",
                "text" => "La creation de votre compte a réussi.
                Un email de confirmation vous a été envoyé. Veuillez vérifier votre boîte de réception pour confirmer votre adresse email."
            ];
        } catch (\Exception $e) {
            $message = [
                "type" => "warning",
                "text" => "La creation de votre compte a échoué. Réessayer plus tard"
            ];
        } finally {
            return back()->with("message", $message);
        }

    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
