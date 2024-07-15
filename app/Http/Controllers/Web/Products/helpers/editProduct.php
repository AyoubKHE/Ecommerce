<?php

namespace App\Http\Controllers\Web\Products\helpers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductAttribute;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

use App\Models\ProductAttributeOption;
use App\Models\ProductCategory_Product;

class editProduct
{

    private static Product $product; // pointer
    private static Request $request;

    private static array $data;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("update_products", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de modifier les produits"
            ];
            return back()->with("message", $message);
        }

        return true;
    }

    private static function loadProductData()
    {
        static::$data["productData"] = Product::where("id", static::$product->id)->addSelect([

            'added_by_username' => User::whereColumn('users.id', 'products.added_by')
                ->select('users.username'),

            "brand_name" => Brand::select("name")
                ->whereColumn('brands.id', 'products.brand_id'),
        ])->first();
    }


    private static function loadRelatedCategoriesData()
    {
        static::$data["relatedCategoriesData"] = ProductCategory_Product::where('product_id', static::$product->id)->addSelect(
            [
                "product_category_name" => ProductCategory::select("name")
                    ->whereColumn('productscategories.id', 'productscategories_products.productcategory_id'),

                "product_category_created_at" => ProductCategory::select("created_at")
                    ->whereColumn('productscategories.id', 'productscategories_products.productcategory_id'),

                "product_category_updated_at" => ProductCategory::select("updated_at")
                    ->whereColumn('productscategories.id', 'productscategories_products.productcategory_id'),

                "product_category_added_by_username" => ProductCategory::join('users', 'productscategories.added_by', '=', 'users.id')
                    ->select("users.username")
                    ->whereColumn('productscategories.id', 'productscategories_products.productcategory_id'),

                "product_category_quantity_of_products" => DB::table('productscategories_products AS t2')
                    ->select(DB::raw('count(*)'))
                    ->whereColumn('t2.productcategory_id', 'productscategories_products.productcategory_id'),
                    
                "product_category_quantity_of_active_products" => DB::table('productscategories_products AS t2')
                    ->select(DB::raw('count(*)'))
                    ->whereColumn('t2.productcategory_id', 'productscategories_products.productcategory_id')
                    ->where('t2.is_active', 1),
            ]
        )->get();
    }


    private static function loadAllCategoriesData()
    {
        static::$data["allCategoriesData"] = ProductCategory::addSelect([
            'added_by_username' => User::whereColumn('users.id', 'productscategories.added_by')
                ->select('users.username'),
            'base_category_name' => DB::table('productscategories AS t2')->select('t2.name')
                ->whereColumn('t2.id', 'productscategories.parent_id'),
            'quantity_of_products' => ProductCategory_Product::select(DB::raw('count(*)'))
                ->whereColumn('productcategory_id', 'productscategories.id'),
            'quantity_of_active_products' => ProductCategory_Product::select(DB::raw('count(*)'))
                ->whereColumn('productcategory_id', 'productscategories.id')
                ->where('is_active', 1)
        ])
        ->where("is_leaf_category", 1)
        ->get();
    }


    private static function loadBrandsNames()
    {
        static::$data['brandsNames'] = Brand::pluck("name");
    }


    private static function loadAttributesNames()
    {
        static::$data['attributesNames'] = ProductAttribute::pluck("name");
    }


    private static function loadProductVariations()
    {
        static::$data["productVariations"]["variations"] = ProductVariation::where('product_id', static::$product->id)->with("options", function ($query) {
            $query->with("productAttribute");
        })->get();

        static::$data["productVariations"]["usedAttributes"] = [];

        foreach (static::$data["productVariations"]["variations"][0]->options as $option) {
            array_push(static::$data["productVariations"]["usedAttributes"], $option->productAttribute["name"]);
        }
    }

    private static function loadAttributesOptions()
    {
        static::$data["productVariations"]["attributesAndOptions"] = [];

        foreach (static::$data["productVariations"]["usedAttributes"] as $used_attribute) {

            $used_attribute_id = ProductAttribute::where("name", $used_attribute)->first()->id;

            static::$data["productVariations"]["attributesAndOptions"][$used_attribute] = ProductAttributeOption::where("productAttribute_id", $used_attribute_id)->pluck("value")->toArray();
        }
    }


    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(Product $product, Request $request)
    {
        static::$product = $product;

        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        static::loadProductData();

        static::loadRelatedCategoriesData();

        static::loadAllCategoriesData();

        static::loadBrandsNames();

        static::loadAttributesNames();

        static::loadProductVariations();

        static::loadAttributesOptions();

        static::$data["product_images"] = $product->images;

        return view("dashboard.products.edit", ["data" => static::$data]);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
