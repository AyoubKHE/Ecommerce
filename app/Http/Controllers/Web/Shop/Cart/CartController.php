<?php

namespace App\Http\Controllers\Web\Shop\Cart;

use App\Models\Cart;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Shop\Cart\helpers\storeCart;

class CartController extends Controller
{
    public function store(Request $request)
    {
        return storeCart::start($request);
    }
}
