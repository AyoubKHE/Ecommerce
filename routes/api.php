<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Brands\BrandController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Shop\ProductsCategories\ProductCategoryController AS ShopProductCategoryController;
use App\Http\Controllers\API\Shop\Product\ProductController AS ShopProductController;
use App\Http\Controllers\Api\ProductsCategories\ProductCategoryController AS DashboardProductCategoryController;
use App\Http\Controllers\Api\ProductsAttributes\ProductAttributeController;
use App\Http\Controllers\Api\ProductsAttributesOptions\ProductAttributeOptionController;
use App\Http\Controllers\Api\ProductsVariations\ProductVariationController;
use App\Http\Controllers\Api\Users\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    // Route::get("login", [AuthController::class, "index"])->name("auth.login.index");
    // Route::post('login', [AuthController::class, "login"])->name("auth.login.login");
    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    // Route::post('me', 'AuthController@me');
});



// Route::get("test", [DashboardProductCategoryController::class, "search"])->name("products-categories.search_test");

Route::post("users/search", [UserController::class, 'search'])->name("users.search")->middleware('JWTAuth');
Route::post("users/filter", [UserController::class, 'filter'])->name("users.filter")->middleware('JWTAuth');


Route::post("products-categories/search", [DashboardProductCategoryController::class, 'search'])->name("products-categories.search")->middleware('JWTAuth');
Route::post("products-categories/filter", [DashboardProductCategoryController::class, 'filter'])->name("products-categories.filter")->middleware('JWTAuth');

Route::get("shop/products-categories", [ShopProductCategoryController::class, 'index'])->name("products-categories.pagination");


Route::post("products/search", [ProductController::class, 'search'])->name("products.search")->middleware('JWTAuth');
Route::post("products/filter", [ProductController::class, 'filter'])->name("products.filter")->middleware('JWTAuth');


Route::post("brands/search", [BrandController::class, 'search'])->name("brands.search")->middleware('JWTAuth');
Route::post("brands/filter", [BrandController::class, 'filter'])->name("brands.filter")->middleware('JWTAuth');


Route::get("products-attributes/{attribute_name}/options", [ProductAttributeController::class, 'getAttributeOptions'])->name("products-attributes.getAttributeOptions")->middleware('JWTAuth');


Route::get("product/{product_id}/variations", [ShopProductController::class, 'getProductVariations'])->name("product.variations");


Route::delete("products-attributes-options/{products_attribute_option}", [ProductAttributeOptionController::class, 'destroy'])
    ->name("products-attributes-options.destroy")
    ->middleware('JWTAuth');

Route::delete("products-variations/{products_variation}", [ProductVariationController::class, 'destroy'])
    ->name("products-variations.destroy")
    ->middleware('JWTAuth');
