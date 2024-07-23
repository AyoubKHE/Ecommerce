<?php

namespace App\Http\Controllers\Web\Shop\Checkout;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Shop\Checkout\helpers\Index;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        return Index::start($request);
    }
}
