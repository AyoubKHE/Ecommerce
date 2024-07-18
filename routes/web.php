<?php



use App\Models\Product;

use App\Models\ProductCategory;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;;

use App\Http\Controllers\Web\Auth\AuthController;




use App\Http\Controllers\Web\Users\UserController;
use App\Http\Controllers\Web\Brands\BrandController;
use App\Services\SubCategories\SubCategoriesService;
use App\Http\Controllers\Web\Products\ProductController;
use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Services\SubCategories\Products\SubCategoriesActiveProducts;
use App\Services\SubCategories\Brands\SubCategoriesActiveProductsBrands;
use App\Http\Controllers\Web\ProductsAttributes\ProductAttributeController;
use App\Services\SubCategories\ProductsPrice\SubCategoriesActiveProductsPrice;
use App\Services\SubCategories\Attributes\SubCategoriesActiveProductsAttributes;
use App\Services\SubCategories\ProductsPrice\SubCategoriesActiveProductsMinMaxPrice;
use App\Http\Controllers\Web\Shop\Showcase\ShowcaseController as ShopShowcaseController;
use App\Http\Controllers\Web\Showcase\ShowcaseController as DashboardShowcaseController;
use App\Http\Controllers\Web\Shop\ProductsCategories\ProductCategoryController as ShopProductCategoryController;
use App\Http\Controllers\Web\Shop\Product\ProductController as ShopProductController;
use App\Http\Controllers\Web\ProductsCategories\ProductCategoryController  as DashboardProductCategoryController;
use App\Http\Controllers\Web\Shop\Cart\CartController;

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


    $product_id = 2;

    // WHERE variations.variation_options LIKE '% 6%' AND variations.variation_options LIKE '% 13%'

    // dd("{$product_id} hello");

    $sub_query = DB::table('productsVariations_attributesOptions as pv_ao')
        ->join("productsVariations as pv", "pv_ao.productVariation_id", "pv.id")
        ->join("productsAttributes as pa", "pv_ao.productAttribute_id", "pa.id")
        ->join("productsAttributesOptions as pao", "pv_ao.productAttributeOption_id", "pao.id")
        ->select('pv.*', DB::raw('GROUP_CONCAT(pa.name,"=", pao.value SEPARATOR ", ") AS variation_options'))
        ->where('pv.product_id', $product_id)
        ->groupBy('pv.id');

    $main_query = DB::table(DB::raw("({$sub_query->toSql()}) as variations"))
        ->mergeBindings($sub_query)->get();

    dd($main_query);


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
