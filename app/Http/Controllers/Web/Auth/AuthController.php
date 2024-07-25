<?php

namespace App\Http\Controllers\Web\Auth;

use App\Models\User;
use App\Models\Person;
use App\Services\JWTService;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Date;

class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view("auth.login");
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

        return to_route("dashboard.auth.login.index");
    }

}
