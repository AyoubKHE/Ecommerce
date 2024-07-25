<?php

namespace App\Http\Controllers\Web\Users\helpers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\EmailValidation;
use App\Models\UserPermission;
use App\Models\SystemPermission;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\UserPermission_SystemPermission;

class storeUser
{

    private static UserRequest $user_request;
    private static array $user_form_fields;

    private static int $user_id;

    private static bool $isUsersImagesFolderCreated = false;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------


    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$user_request->user()->cannot("create_users", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'ajouter un utilisateur"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function preparingData(): void
    {

        static::$user_form_fields["added_by"] = auth()->user()->id;

        static::$user_form_fields["password"] = Hash::make(static::$user_form_fields["password"]);

        static::$user_form_fields["email_verification_token"] = Str::random(60);

        static::$user_form_fields["is_active"] = 0;
    }


    private static function storeUserImage()
    {

        $table_status = DB::select("SHOW TABLE STATUS LIKE 'users'");
        static::$user_id = $table_status[0]->Auto_increment;

        $imageFile = static::$user_request->file('user_image');
        $folderPath = 'users/id_' . static::$user_id;

        static::$user_form_fields["image_path"] = $imageFile->store($folderPath, 'public');
        if (!static::$user_form_fields["image_path"]) {
            throw new \Exception("échec de stocké l'image de l'utilisateur dans le dossier users");
        }

        static::$isUsersImagesFolderCreated = true;

        unset(static::$user_form_fields["user_image"]);
    }


    private static function storeUserPermissions()
    {
        if(static::$user_request["role"] === "admin") {
            return;
        }

        $user_permission = UserPermission::create([
            "user_id" => static::$user_id
        ]);

        if (!$user_permission) {
            throw new \Exception("échec de la création de l'enregistrement dans la table 'usersPermissions'");
        }

        foreach (static::$user_request["permissions"] as $syteme_permission => $system_permission_value) {

            $syteme_permission_id = SystemPermission::where("name", $syteme_permission)->first()->id;

            if (!UserPermission_SystemPermission::create([
                "userPermission_id" => $user_permission->id,
                "systemPermission_id" => $syteme_permission_id,
                "value" => $system_permission_value
            ])) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'usersPermissions_systemPermissions'");
            }
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(UserRequest $user_request): RedirectResponse
    {

        static::$user_request = $user_request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }


        static::$user_form_fields = $user_request->validated();

        static::preparingData();

        try {

            DB::transaction(function () {

                static::storeUserImage();

                $user = User::create(static::$user_form_fields);
                if (!$user) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'users'");
                }

                static::storeUserPermissions();

                Mail::to($user->email)->send(new EmailValidation($user->first_name, $user->email_verification_token));
            });

            $message = [
                "type" => "success",
                "text" => "La creation de compte a réussi.
                Un email de confirmation a été envoyé à l utilsateur."
            ];

            // $message = [
            //     "type" => "success",
            //     "text" => "l utilisateur est bien créé."
            // ];
        } catch (\Exception $th) {

            if (static::$isUsersImagesFolderCreated) {
                Storage::deleteDirectory("public/users/id_" . static::$user_id);
            }

            $message = [
                "type" => "danger",
                "text" => "la création d utilisateur a échoué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return to_route("users.index")->with("message", $message);
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
