<?php

namespace App\Http\Controllers\Web\users\helpers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Services\BackupService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class destroyUser
{
    private static User $user;
    private static Request $request;

    private static bool $isBackupCreated = false;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------


    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$user->role === "admin") {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de supprimer un administrateur"
            ];
            return back()->with("message", $message);
        }

        if (static::$request->user()->cannot("delete_users", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de supprimer les utilisateurs"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function destroyUserImageInFolder()
    {
        if (!BackupService::createImagesBackup("users", static::$user->id)) {
            static::$isBackupCreated = false;
            throw new \Exception("échec de crée une sauvgarde pour les images");
        }

        static::$isBackupCreated = true;

        $userImageFolder = "public/users/id_" . static::$user->id;
        if (!Storage::deleteDirectory($userImageFolder)) {
            throw new \Exception("échec de supprimer le dossier 'users/id_" . static::$user->id . "' qui contient l image d'utilisateur");
        }

    }

    private static function destroyUserPermissions()
    {
        $user_permissions = UserPermission::where("user_id", static::$user->id)->with("systemPermissionsPivot")->first();

        if($user_permissions !== null) {
            foreach ($user_permissions->systemPermissionsPivot as $key => $systemPermissionPivot) {
                if (!$systemPermissionPivot->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'usersPermissions_systemPermissions'");
                }
            }

            if (!$user_permissions->delete()) {
                throw new \Exception("échec de supprimer l'enregistrement dans la table 'usersPermissions'");
            }

        }
    }


    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(User $user, Request $request): RedirectResponse
    {
        static::$user = $user;

        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        try {
            DB::transaction(function () use ($user) {

                static::destroyUserImageInFolder();

                static::destroyUserPermissions();

                if (!$user->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'users'");
                }

                BackupService::deleteImagesBackup("users", static::$user->id);
            });

            $message = [
                "type" => "success",
                "text" => "utilisateur bien supprimée"
            ];
        } catch (\Exception $th) {

            if (static::$isBackupCreated) {

                /*
                    la question que j'ai pas trouvé encore de réponse c'est que si par exemple meme la restoration n'est pas aussi réussi. est ce que je fais un autre block catch !!
                */
                BackupService::makeImagesRestoration("users", static::$user->id);
            }

            $message = [
                "type" => "danger",
                "text" => "suppression d utilisateur a échoué",
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
