<?php

namespace App\Http\Controllers\Web\Shop\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Shop\Cart\helpers\storeCart;

class CartController extends Controller
{
    public function store(Request $request)
    {
        return storeCart::start($request);
    }
}
