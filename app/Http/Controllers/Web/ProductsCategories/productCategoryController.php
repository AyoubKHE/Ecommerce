<?php

namespace App\Http\Controllers\Web\ProductsCategories;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Controllers\Web\ProductsCategories\helpers\editProductCategory;
use App\Http\Controllers\Web\ProductsCategories\helpers\showProductCategory;
use App\Http\Controllers\Web\ProductsCategories\helpers\storeProductCategory;
use App\Http\Controllers\Web\ProductsCategories\helpers\createProductCategory;
use App\Http\Controllers\Web\ProductsCategories\helpers\updateProductCategory;
use App\Http\Controllers\Web\ProductsCategories\helpers\destroyProductCategory;
use App\Http\Controllers\Web\ProductsCategories\helpers\showAllProductsCategories;



class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        return showAllProductsCategories::start($request);
    }


    public function create(Request $request)
    {
        return createProductCategory::start($request);
    }


    public function store(ProductCategoryRequest $product_category_request)
    {
        return storeProductCategory::start($product_category_request);
    }


    public function show(ProductCategory $products_category, Request $request)
    {
        return showProductCategory::start($products_category, $request);
    }


    public function edit(ProductCategory $products_category, Request $request)
    {
        return editProductCategory::start($products_category, $request);
    }


    public function update(ProductCategory $products_category, ProductCategoryRequest $product_category_request)
    {
        return updateProductCategory::start($products_category, $product_category_request);
    }


    public function destroy(ProductCategory $products_category, Request $request)
    {
        return destroyProductCategory::start($products_category, $request);
    }
}
