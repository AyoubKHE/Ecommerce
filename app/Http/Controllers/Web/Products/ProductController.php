<?php

namespace App\Http\Controllers\Web\Products;


use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Web\Products\helpers\editProduct;
use App\Http\Controllers\Web\Products\helpers\showProduct;
use App\Http\Controllers\Web\Products\helpers\storeProduct;
use App\Http\Controllers\Web\Products\helpers\createProduct;
use App\Http\Controllers\Web\Products\helpers\updateProduct;
use App\Http\Controllers\Web\Products\helpers\destroyProduct;
use App\Http\Controllers\Web\Products\helpers\showAllProducts;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return showAllProducts::start($request);
    }


    public function create(Request $request)
    {
        return createProduct::start($request);
    }


    public function store(ProductRequest $product_request)
    {
        return storeProduct::start($product_request);
    }


    public function show(Product $product, Request $request)
    {
        return showProduct::start($product, $request);
    }


    public function edit(Product $product, Request $request)
    {
        return editProduct::start($product, $request);
    }


    public function update(Product $product, ProductRequest $product_request)
    {
        return updateProduct::start($product, $product_request);
    }


    public function destroy(Product $product, Request $request)
    {
        return destroyProduct::start($product, $request);
    }
}
