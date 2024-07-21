<?php

namespace App\Http\Controllers\Web\Shop\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view("shop.auth.login");
    }

    public function login(Request $request): RedirectResponse
    {
        return login::start($request);
    }

    public function logout(Request $request): RedirectResponse
    {

        $current_user =  User::find(auth()->user()->id);

        $current_user->last_login = now();

        $current_user->save();

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route("shop.auth.login.index");
    }
}
