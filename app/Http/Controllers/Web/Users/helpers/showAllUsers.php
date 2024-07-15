<?php

namespace App\Http\Controllers\Web\Users\helpers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class showAllUsers
{

    private static array $data;

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


    private static function loadUsersData()
    {
        static::$data["usersData"] = User::whereIn("role", ["admin", "user"])->addSelect([
            'added_by_username' => DB::table('users AS t2')->select('t2.username')
                ->whereColumn('t2.id', 'users.added_by'),

        ])->where("id", "!=", auth()->user()->id)->paginate(env("usersPagination"));
    }


    private static function loadCustomersData()
    {
        static::$data["usersData"] = User::where("role", "customer")->paginate(env("usersPagination"));
    }


    private static function loadFilterModalData()
    {

        static::$data["filterModalData"]["usersNames"] = User::pluck("username")->all();

        static::$data["filterModalData"]["minBirthDate"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->min("birth_date")))->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["maxBirthDate"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->max("birth_date")))->isoFormat("Y-MM-DD");

        static::$data["filterModalData"]["minCreatedAtDate"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->min("created_at")))->sub("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["minCreatedAtTime"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->min("created_at")))->sub("1 minute")->isoFormat("kk:mm");
        static::$data["filterModalData"]["maxCreatedAtDate"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->max("created_at")))->add("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["maxCreatedAtTime"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->max("created_at")))->add("1 minute")->isoFormat("kk:mm");

        static::$data["filterModalData"]["minUpdatedAtDate"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->min("updated_at")))->sub("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["minUpdatedAtTime"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->min("updated_at")))->sub("1 minute")->isoFormat("kk:mm");
        static::$data["filterModalData"]["maxUpdatedAtDate"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->max("updated_at")))->add("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["maxUpdatedAtTime"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->max("updated_at")))->add("1 minute")->isoFormat("kk:mm");

        static::$data["filterModalData"]["minLastLoginDate"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->min("last_login")))->sub("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["minLastLoginTime"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->min("last_login")))->sub("1 minute")->isoFormat("kk:mm");
        static::$data["filterModalData"]["maxLastLoginDate"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->max("last_login")))->add("1 minute")->isoFormat("Y-MM-DD");
        static::$data["filterModalData"]["maxLastLoginTime"] = (new Carbon(User::where("id", "!=", auth()->user()->id)->max("last_login")))->add("1 minute")->isoFormat("kk:mm");
    }


    public static function start(Request $request)
    {

        $requested_resource = explode("/", $request->getPathInfo())[1];

        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        if ($requested_resource === "users") {

            static::loadUsersData();

            static::loadFilterModalData();

        } else {
            static::loadCustomersData();
        }

        return view("dashboard.users.index", ["data" => static::$data]);
    }
}
