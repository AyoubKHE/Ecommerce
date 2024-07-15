<?php

namespace App\Http\Controllers\Web\Users\helpers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Models\SystemPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\UserPermission_SystemPermission;

class enModificationsMadeOn
{
    const nothing_changed = 0;

    const user = 1;
    const user_permissions = 2;

    const all_changed = 3;
}

class updateUser
{

    private static Request $request;

    private static User $user;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$user->role === "admin") {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de modifier un administrateur"
            ];
            return back()->with("message", $message);
        }

        if (static::$request->user()->cannot("update_users", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de modifier les utilisateurs"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function isUserPermissionsChanged()
    {
        $originale_permissions = UserPermission::where("user_id", static::$user->id)->with("systemPermissionsPivot")->first();

        foreach (static::$request["permissions"] as $received_syteme_permission => $received_system_permission_value) {

            $syteme_permission_id = SystemPermission::where("name", $received_syteme_permission)->first()->id;

            $originale_permission_value = $originale_permissions->systemPermissionsPivot
                ->filter(function ($systemPermissionPivot) use ($syteme_permission_id) {
                    return $systemPermissionPivot->systemPermission_id === $syteme_permission_id;
                })
                ->first()->value;


            if ($originale_permission_value != $received_system_permission_value) {
                return true;
            }
        }

        return false;
    }


    private static function modificationsMadeOn(): int
    {
        $is_user_changed = static::$user->is_active != static::$request->input("is_active");

        $is_user_permissions_changed = static::isUserPermissionsChanged();


        if (!$is_user_changed && !$is_user_permissions_changed) {
            return enModificationsMadeOn::nothing_changed;
        } else if ($is_user_changed && !$is_user_permissions_changed) {
            return enModificationsMadeOn::user;
        } else if (!$is_user_changed && $is_user_permissions_changed) {
            return enModificationsMadeOn::user_permissions;
        } else {
            return enModificationsMadeOn::all_changed;
        }

        return 0;
    }


    private static function updateUser(): void
    {
        static::$user->is_active = static::$user->is_active == 1 ? 0 : 1;
        if (!static::$user->save()) {
            throw new \Exception("échec de mis à jour l'enregistrement dans la table 'users'");
        }
    }


    private static function updateUserPermissions(): void
    {
        $originale_permissions = UserPermission::where("user_id", static::$user->id)->with("systemPermissionsPivot")->first();

        foreach (static::$request["permissions"] as $received_syteme_permission => $received_system_permission_value) {

            $syteme_permission_id = SystemPermission::where("name", $received_syteme_permission)->first()->id;

            $originale_permission = $originale_permissions->systemPermissionsPivot
                ->filter(function ($systemPermissionPivot) use ($syteme_permission_id) {
                    return $systemPermissionPivot->systemPermission_id === $syteme_permission_id;
                })
                ->first();


            if ($originale_permission->value != $received_system_permission_value) {
                $originale_permission->value = $received_system_permission_value;

                if (!$originale_permission->save()) {
                    throw new \Exception("échec de mis à jour l'enregistrement dans la table 'usersPermissions_systemPermissions'");
                }
            }
        }
    }


    private static function makeUpdate(int $modificationsMadeOn): RedirectResponse
    {
        try {


            switch ($modificationsMadeOn) {
                case enModificationsMadeOn::nothing_changed:

                    $message = [
                        "type" => "warning",
                        "text" => "Vous n avez rien modifier !"
                    ];
                    return back()->with("message", $message);
                    break;
                case enModificationsMadeOn::user:

                    DB::transaction(function () {
                        static::updateUser();
                    });

                    break;

                case enModificationsMadeOn::user_permissions:
                    DB::transaction(function () {
                        static::updateUserPermissions();
                    });

                    break;


                case enModificationsMadeOn::all_changed:

                    DB::transaction(function () {
                        static::updateUser();
                        static::updateUserPermissions();
                    });

                    break;
            }

            $message = [
                "type" => "success",
                "text" => "l utilisateur est bien modifiée."
            ];
        } catch (\Exception $th) {

            $message = [
                "type" => "danger",
                "text" => "la modification d utilisateur a échoué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return back()->with("message", $message);
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(User $user, Request $request): RedirectResponse
    {

        static::$request = $request;

        static::$user = $user;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        $modificationsMadeOn_FunctionResult = static::modificationsMadeOn();

        return static::makeUpdate($modificationsMadeOn_FunctionResult);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
