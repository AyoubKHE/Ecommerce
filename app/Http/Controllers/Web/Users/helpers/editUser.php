<?php

namespace App\Http\Controllers\Web\Users\helpers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Models\SystemPermission;
use Illuminate\Http\RedirectResponse;

class editUser
{
    private static User $user;
    private static Request $request;

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$user->id === auth()->user()->id) {

            return true;
        } else {

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
        }

        return true;
    }


    public static function start(User $user, Request $request)
    {

        static::$user = $user;

        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        if (static::$user->id === auth()->user()->id) {

            $data["user"] = $user;

            return view("dashboard.users.editCurrentUser", compact("data"));
        } else {

            $data["userPermissions"] = UserPermission::where("user_id", $user->id)
                ->with("systemPermissionsPivot")->first();

            $data["systemPermissions"] = SystemPermission::orderBy("id")->get();

            $data['user']["id"] = $user->id;
            $data['user']["username"] = $user->username;
            $data['user']["isActive"] = $user->is_active;

            return view("dashboard.users.edit", compact("data"));
        }
    }
}
