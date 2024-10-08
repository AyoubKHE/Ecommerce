<?php

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Users\UserController;
use App\Http\Controllers\Web\Brands\BrandController;
use App\Http\Controllers\Web\Shop\Cart\CartController;
use App\Http\Controllers\Web\Products\ProductController;
use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\ProductsAttributes\ProductAttributeController;
use App\Http\Controllers\Web\Auth\AuthController as DashboardAuthController;
use App\Http\Controllers\Web\Shop\Auth\AuthController as ShopAuthController;
use App\Http\Controllers\Web\Shop\Product\ProductController as ShopProductController;
use App\Http\Controllers\Web\Shop\Showcase\ShowcaseController as ShopShowcaseController;
use App\Http\Controllers\Web\Showcase\ShowcaseController as DashboardShowcaseController;
use App\Http\Controllers\Web\Shop\ProductsCategories\ProductCategoryController as ShopProductCategoryController;
use App\Http\Controllers\Web\ProductsCategories\ProductCategoryController  as DashboardProductCategoryController;
use App\Http\Controllers\Web\Shop\Checkout\CheckoutController;
use App\Http\Controllers\Web\Shop\Payment\ChargilyPayController;

// use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get("/test", function (Request $request) {

    // dd(auth()->user());

    // User::create([
    //     "first_name" => "Ayoub",
    //     "last_name" => "Kheyar",
    //     "username" => "a",
    //     "email" => "a@a.com",
    //     "password" => Hash::make("a"),
    //     "phone" => "0785496521",
    //     "birth_date" => "2000-01-12",
    //     "is_active" => "1",
    //     "role" => "admin",
    //     "added_by" => null
    // ]);

});

//! SHOP ROUTES ----------------------------------------------------------------------------------------------------------------------------
Route::get('/home', [ShopShowcaseController::class, "index"])->name("shop.showcase");

Route::get('/shop/products-categories/{products_category}', [ShopProductCategoryController::class, "index"])->name("shop.products-categories");

Route::get('/shop/product/{product}', [ShopProductController::class, "index"])->name("shop.product");

Route::post('/cart', [CartController::class, "store"])->name("cart.store");

Route::get('/shop/checkout', [CheckoutController::class, "index"])->name("shop.checkout");

Route::post('/shop/checkout', [CheckoutController::class, "orderValidation"])->name("shop.checkout.validation");

Route::get("/shop/login", [ShopAuthController::class, "index"])->name("shop.auth.login.index")->middleware("guest");
Route::post("/shop/login", [ShopAuthController::class, "login"])->name("shop.auth.login.login")->middleware("guest");
Route::get("/shop/logout", [ShopAuthController::class, "logout"])->name("shop.auth.logout")->middleware("auth");

Route::get("/shop/register", [ShopAuthController::class, "registerForm"])->name("shop.auth.register.form")->middleware("guest");
Route::post("/shop/register", [ShopAuthController::class, "register"])->name("shop.auth.register.register")->middleware("guest");

Route::get("/verify-email/{token}", [ShopAuthController::class, "verifyEmail"])->name("shop.auth.verifyEmail");



Route::get('chargilypay/redirect/{payment}', [ChargilyPayController::class, "redirect"])->name("chargilypay.redirect");
Route::get('chargilypay/back', [ChargilyPayController::class, "back"])->name("chargilypay.back");
Route::post('chargilypay/webhook', [ChargilyPayController::class, "webhook"])->name("chargilypay.webhook_endpoint");

//!-----------------------------------------------------------------------------------------------------------------------------------------

//! DASHBOARD ROUTES -----------------------------------------------------------------------------------------------------------------------

Route::get("/login", [DashboardAuthController::class, "index"])->name("dashboard.auth.login.index")->middleware("guest");
Route::post("/login", [DashboardAuthController::class, "login"])->name("dashboard.auth.login.login")->middleware("guest");
Route::get("/logout", [DashboardAuthController::class, "logout"])->name("dashboard.auth.logout")->middleware("auth");

// Route::get("dashboard/verify-email/{token}", [DashboardAuthController::class, "verifyEmail"])->name("dashboard.auth.verifyEmail");

Route::group(['middleware' => ['auth']], function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard.index");
    Route::resource("products-categories", DashboardProductCategoryController::class);
    Route::resource("products", ProductController::class);
    Route::resource("products-attributes", ProductAttributeController::class);
    Route::resource("brands", BrandController::class);

    Route::get("/showcase/header/edit", [DashboardShowcaseController::class, "headerEdit"])->name("showcase.header.edit");
    Route::put("/showcase/header", [DashboardShowcaseController::class, "headerUpdate"])->name("showcase.header.update");

    Route::get("/showcase/body/edit", [DashboardShowcaseController::class, "bodyEdit"])->name("showcase.body.edit");
    Route::put("/showcase/body", [DashboardShowcaseController::class, "bodyUpdate"])->name("showcase.body.update");

    Route::resource("users", UserController::class);
    Route::put("/currentUser/{user}", [UserController::class, "updateCurrentUser"])->name("users.updateCurrentUser");
});

//!-----------------------------------------------------------------------------------------------------------------------------------------
