<?php

namespace App\Http\Controllers\Web\Users;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPermission;
use App\Models\SystemPermission;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Users\helpers\editUser;
use App\Http\Controllers\Web\Users\helpers\showUser;
use App\Http\Controllers\Web\Users\helpers\storeUser;
use App\Http\Controllers\Web\Users\helpers\createUser;
use App\Http\Controllers\Web\Users\helpers\updateUser;
use App\Http\Controllers\Web\users\helpers\destroyUser;
use App\Http\Controllers\Web\Users\helpers\showAllUsers;
use App\Http\Controllers\Web\Users\helpers\updateCurrentUser;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return showAllUsers::start($request);
    }


    public function create(Request $request)
    {
        return createUser::start($request);
    }


    public function store(UserRequest $user_request)
    {
        return storeUser::start($user_request);
    }


    public function show(User $user, Request $request)
    {
        return showUser::start($user, $request);
    }


    public function edit(User $user, Request $request)
    {
        return editUser::start($user, $request);
    }


    public function updateCurrentUser(User $user, UserRequest $user_request)
    {
        return updateCurrentUser::start($user, $user_request);
    }
    public function update(User $user, Request $request)
    {
        return updateUser::start($user, $request);
    }


    public function destroy(User $user, Request $request)
    {
        return destroyUser::start($user, $request);
    }
}
