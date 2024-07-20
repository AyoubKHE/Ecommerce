<?php



use Carbon\Carbon;

use App\Models\Cart;

use App\Models\Product;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Crypt;




use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Cache;;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\Users\UserController;
use App\Http\Controllers\Web\Brands\BrandController;
use App\Services\SubCategories\SubCategoriesService;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\Web\Shop\Cart\CartController;
use App\Http\Controllers\Web\Products\ProductController;
use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Services\SubCategories\Products\SubCategoriesActiveProducts;
use App\Services\SubCategories\Brands\SubCategoriesActiveProductsBrands;
use App\Http\Controllers\Web\ProductsAttributes\ProductAttributeController;
use App\Services\SubCategories\ProductsPrice\SubCategoriesActiveProductsPrice;
use App\Services\SubCategories\Attributes\SubCategoriesActiveProductsAttributes;
use App\Services\SubCategories\ProductsPrice\SubCategoriesActiveProductsMinMaxPrice;
use App\Http\Controllers\Web\Shop\Product\ProductController as ShopProductController;
use App\Http\Controllers\Web\Shop\Showcase\ShowcaseController as ShopShowcaseController;
use App\Http\Controllers\Web\Showcase\ShowcaseController as DashboardShowcaseController;
use App\Http\Controllers\Web\Shop\ProductsCategories\ProductCategoryController as ShopProductCategoryController;
use App\Http\Controllers\Web\ProductsCategories\ProductCategoryController  as DashboardProductCategoryController;

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






Route::get("/test", function () {


    dd(Cart::where("session_id", "UNJuiSyC5kTyGIj2tRgS03oUpfVtQ1C0iQEbG5Wi")
        ->with("items", function ($query) {
            $query->with("variation", function ($query) {
                $query->with("product");
            });
        })
        ->first()->toArray());

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


Route::get('/', [ShopShowcaseController::class, "index"])->name("shop.showcase");

Route::get('/shop/products-categories/{products_category}', [ShopProductCategoryController::class, "index"])->name("shop.products-categories");

Route::get('/shop/product/{product}', [ShopProductController::class, "index"])->name("shop.product");

Route::post('/cart', [CartController::class, "store"])->name("cart.store");

Route::get("/login", [AuthController::class, "index"])->name("auth.login.index");
Route::post("/login", [AuthController::class, "login"])->name("auth.login.login");
Route::get("/logout", [AuthController::class, "logout"])->name("auth.logout");

Route::group(['middleware' => ['auth']], function () {
    Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard.index");
    Route::resource("products-categories", DashboardProductCategoryController::class);
    Route::resource("products", ProductController::class);
    Route::resource("products-attributes", ProductAttributeController::class);
    Route::resource("brands", BrandController::class);

    Route::get("/showcase/header/edit", [DashboardShowcaseController::class, "headerEdit"])->name("showcase.header.edit");
    Route::PUT("/showcase/header", [DashboardShowcaseController::class, "headerUpdate"])->name("showcase.header.update");

    Route::get("/showcase/body/edit", [DashboardShowcaseController::class, "bodyEdit"])->name("showcase.body.edit");
    Route::PUT("/showcase/body", [DashboardShowcaseController::class, "bodyUpdate"])->name("showcase.body.update");
});

Route::resource("users", UserController::class);
Route::put("/currentUser/{user}", [UserController::class, "updateCurrentUser"])->name("users.updateCurrentUser");
