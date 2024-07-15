<?php

namespace App\Http\Controllers\Api\Users;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    public function search(Request $request, Response $response)
    {

        $current_user_id = $request->header("current_user_id");

        $pattern = "%" . $request->input("data") . "%";

        $page = $request->input("page", 1);

        $usersData = User::where("username", "like", $pattern)->addSelect([
            'added_by_username' => DB::table('users AS t2')->select('t2.username')
                ->whereColumn('t2.id', 'users.added_by'),

        ])->where("id", "!=", $current_user_id)->paginate(env("usersPagination"), ['*'], 'page', $page);

        return response()->json(
            [
                "htmlView" => view("components.dashboard.users.users_table", compact('usersData'))->render(),
            ],
            200
        );
    }

    public function filter(Request $request, Response $response)
    {

        $current_user_id = $request->header("current_user_id");

        $filter = $request->input("data");

        $page = $request->input("page", 1);

        $usersFilterQuery = User::query();

        if (isset($filter['id'])) {
            $usersFilterQuery = $usersFilterQuery->where('id', $filter['id']);
        }

        if (isset($filter['username'])) {
            $usersFilterQuery = $usersFilterQuery->where('username', 'like', $filter['username']);
        }

        if (isset($filter['first_name'])) {
            $usersFilterQuery = $usersFilterQuery->where('first_name', 'like', $filter['first_name']);
        }

        if (isset($filter['last_name'])) {
            $usersFilterQuery = $usersFilterQuery->where('last_name', 'like', $filter['last_name']);
        }

        if (isset($filter['email'])) {
            $usersFilterQuery = $usersFilterQuery->where('email', 'like', $filter['email']);
        }

        if (isset($filter['phone'])) {
            $usersFilterQuery = $usersFilterQuery->where('phone', $filter['phone']);
        }

        if (isset($filter['added_by'])) {
            $usersFilterQuery = $usersFilterQuery->whereHas('addedBy', function (Builder $query) use ($filter) {
                $query->where('username', $filter['added_by']);
            });
        }

        if (isset($filter['role'])) {
            $usersFilterQuery = $usersFilterQuery->where('role', $filter['role']);
        }


        if (isset($filter['is_active'])) {
            $usersFilterQuery = $usersFilterQuery->where('is_active', $filter['is_active']);
        }

        $usersFilterQuery = $usersFilterQuery->whereBetween('birth_date', [$filter["birth_date"]["from"], $filter["birth_date"]["to"]]);

        $usersFilterQuery = $usersFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);

        $usersFilterQuery = $usersFilterQuery->whereBetween('created_at', [$filter["created_at"]["from"], $filter["created_at"]["to"]]);

        // $usersFilterQuery = $usersFilterQuery->whereBetween('last_login', [$filter["last_login"]["from"], $filter["last_login"]["to"]]);


        $usersData = $usersFilterQuery->addSelect([

            'added_by_username' => DB::table('users AS t2')->select('t2.username')
                ->whereColumn('t2.id', 'users.added_by'),

        ])->where("id", "!=", $current_user_id)->paginate(env("productPagination"), ['*'], 'page', $page);


        return response()->json(
            [
                "htmlView" => view("components.dashboard.users.users_table", compact('usersData'))->render(),
            ],
            200
        );
    }
}
