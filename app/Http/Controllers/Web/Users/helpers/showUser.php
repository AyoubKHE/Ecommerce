<?php

namespace App\Http\Controllers\Web\Users\helpers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Models\SystemPermission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class showUser
{
    private static Request $request;

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("read_users", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'afficher les utilisateurs"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    public static function start(User $user, Request $request)
    {
        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }


        $data["userData"] = User::where("id", $user->id)->addSelect([
            'added_by_username' => DB::table('users AS t2')->select('t2.username')
                ->whereColumn('t2.id', 'users.added_by'),

        ])->first();

        if ($user->role === "user") {
            $data["userPermissions"] = UserPermission::where("user_id", $user->id)->with("systemPermissionsPivot")->first();

            $data["systemPermissions"] = SystemPermission::orderBy("id")->get();
        }

        return view("dashboard.users.show", compact("data"));
    }
}
