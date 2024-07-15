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


    // dd(SubCategoriesService::getActiveProductsListForSpecificCategory(2, 0, 1));

    // dd(SubCategoriesService::getActiveProductsListForSpecificCategory(1));


    // dd(SubCategoriesService::getActiveProductsBrandsListForSpecificCategory(2));

    // $data = Cache::remember("productsCategories", 30, function () {
    //     return ProductCategory::where("id", 2)
    //         ->with("products", function ($query) {
    //             $query->where("productsCategories_products.is_active", 1)
    //                 ->with("images")
    //                 ->with("brand")
    //                 ->paginate(3, ['*'], 'page', 1);
    //         })
    //         ->first()->toArray();
    // });

    // $data = DB::table("productsCategories as pc")
    //     ->join("productsCategories as pc2", "pc.parent_id", "=", "pc2.id")
    //     ->join("productsCategories_products as pc_p", "pc.id", "=", "pc_p.productCategory_id")
    //     ->join("products as p", "pc_p.product_id", "=", "p.id")
    //     ->join("brands as b", "p.brand_id", "=", "b.id")
    //     ->join("productsImages as pi", "p.id", "=", "pi.product_id")
    //     ->where("pc_p.productCategory_id", 2)
    //     ->where("pc_p.is_active", 1)
    //     ->select(
    //         [
    //             "pc.id as categoryId",
    //             "pc.name as categoryName",
    //             "pc.description as categoryDescription",
    //             "pc.image_path as categoryImagePath",
    //             "pc.is_active as categoryIsActive",
    //             "pc.show_on_website_header as categoryShowOnWebsiteHeader",
    //             "pc.added_by as categoryAddedBy",
    //             "pc2.name as parentCategory",

    //             "p.id as productId",
    //             "p.name as productName",
    //             "p.description as productDescription",
    //             "p.is_active as productIsActive",
    //             "p.price as productPrice",
    //             "p.added_by as productAddedBy",
    //             "b.name as productBrand",

    //             "pi.id as imageId",
    //             "pi.image_path as imagePath"

    //         ]
    //     )
    //     ->groupBy("p.id")
    //     ->get();

    // dump($data);

    // dd(ProductCategory::where("id", 2)
    //     ->with("products", function ($query) {
    //         $query->where("productsCategories_products.is_active", 1)
    //             ->with("variations", function ($query) {
    //                 $query->with("attributes_options_pivot", function ($query) {
    //                     $query->with("attribute")->with("option");
    //                 })
    //                 ->limit(1)
    //                     ->get();
    //             });
    //     })
    //     ->first()->products->toArray());

    // dd(str_replace(" ", "_", "panhomme"));

    // dd(Product::where("id", 4)
    //     ->with("variations", function ($query) {
    //         $query->with("attributes_options_pivot", function ($query) {
    //             $query->with("attribute")->with("option");
    //         })
    //             ->limit(1);
    //     })
    //     ->first()->toArray());

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
