<?php

namespace App\Http\Controllers\Web\Users\helpers;

use Illuminate\Http\Request;
use App\Models\SystemPermission;
use Illuminate\Http\RedirectResponse;

class createUser
{
    private static Request $request;

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("create_users", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'ajouter un nouveau utilisateur"
            ];
            return back()->with("message", $message);
        }

        return true;
    }



    public static function start(Request $request)
    {
        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }


        $data["systemPermissions"] = SystemPermission::orderBy("id")->pluck("name");

        return view("dashboard.users.create", compact("data"));
    }
}
