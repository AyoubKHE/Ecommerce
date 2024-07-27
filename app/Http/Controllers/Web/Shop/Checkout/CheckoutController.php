<?php

namespace App\Http\Controllers\Web\Shop\Checkout;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Shop\Checkout\helpers\Index;
use App\Http\Controllers\Web\Shop\Checkout\helpers\orderValidation;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        return Index::start($request);
    }

    public function orderValidation(Request $request)
    {
        return orderValidation::start($request);
    }
}
