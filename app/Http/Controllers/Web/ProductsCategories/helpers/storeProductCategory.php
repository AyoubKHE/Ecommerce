<?php

namespace App\Http\Controllers\Web\ProductsCategories\helpers;

use App\Models\Person;
use App\Models\ProductCategory;
use App\Models\ProductCategory_Product;
use App\Http\Requests\ProductCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class storeProductCategory
{
    private static ProductCategoryRequest $products_category_request;
    private static array $products_category_form_fields;
    private static array $related_products = [];

    private static int $products_category_id;

    private static bool $isProductsCategoryImagesFolderCreated = false;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$products_category_request->user()->cannot("create_productsCategories", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'ajouter une nouvelle catégorie"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function moreValidations(): bool|RedirectResponse
    {
        if (static::$products_category_form_fields["base_category_name"] !== "N/A") {

            $parent_category = ProductCategory::where("name", static::$products_category_form_fields["base_category_name"])->first();

            if ($parent_category->products->count() > 0) {
                $message = [
                    "type" => "warning",
                    "text" => "La catégorie | " . $parent_category->name .
                        " | Possède des produits, elle ne peut pas être une catégorie de base pour la catégorie | " . static::$products_category_form_fields["name"] . " |."
                ];
                return back()->with("message", $message);
            }

            //! j'ai pas fais if($parent_category->is_leaf_category == 1) pour éviter une situation de deadlock
            //! lors de premier et deuxieme enregistements inserer dans la table productscategories
            // if ($parent_category->is_leaf_category == 1) {

            //     $message = [
            //         "type" => "warning",
            //         "text" => "La catégorie | " . $parent_category->name .
            //             " | une catégorie feuille, elle ne peut pas être une catégorie de base pour la catégorie | " . static::$products_category_form_fields["name"] . " |."
            //     ];
            //     return back()->with("message", $message);
            // }
        }

        return true;
    }


    private static function preparingBaseCategory(): bool|RedirectResponse
    {
        if (static::$products_category_form_fields["base_category_name"] !== "N/A") {

            $parent_category = ProductCategory::where("name", static::$products_category_form_fields["base_category_name"])->first();

            if ($parent_category->is_leaf_category == 1) {

                $parent_category->is_leaf_category = 0;

                if (!$parent_category->save()) {
                    $message = [
                        "type" => "danger",
                        "text" => "la création de la catégorie a échoué. Réessayer plus tard",
                        "error" => "échec de modifier la colonne | is_leaf_category | de la catégorie
                                    de base | " . $parent_category->name . " |.",
                    ];
                    return back()->with("message", $message);
                }
            }

            static::$products_category_form_fields["parent_id"] = $parent_category->id;
            unset(static::$products_category_form_fields["base_category_name"]);
        } else {

            static::$products_category_form_fields["parent_id"] = null;
            unset(static::$products_category_form_fields["base_category_name"]);
        }

        return true;
    }
    private static function preparingData(): bool|RedirectResponse
    {

        $preparingBaseCategory_FunctionResult = static::preparingBaseCategory();
        if ($preparingBaseCategory_FunctionResult instanceof RedirectResponse) {
            return $preparingBaseCategory_FunctionResult;
        }

        if (isset(static::$products_category_request["related_products"])) {
            foreach (static::$products_category_request["related_products"] as $product_id => $value) {
                $record["product_id"] = $product_id;
                $record["is_active"] = $value;

                array_push(static::$related_products, $record);
            }
        }


        static::$products_category_form_fields["added_by"] = auth()->user()->id;

        return true;
    }


    private static function storeProductsCategoryImage()
    {

        $table_status = DB::select("SHOW TABLE STATUS LIKE 'productscategories'");
        static::$products_category_id = $table_status[0]->Auto_increment;

        $imageFile = static::$products_category_request->file('product_category_image');
        $folderPath = 'products_categories/id_' . static::$products_category_id;

        static::$products_category_form_fields["image_path"] = $imageFile->store($folderPath, 'public');
        if (!static::$products_category_form_fields["image_path"]) {
            throw new \Exception("échec de stocké l'image de la categorie dans le dossier products_categories");
        }

        static::$isProductsCategoryImagesFolderCreated = true;

        unset(static::$products_category_form_fields["product_category_image"]);
    }



    private static function storeRelatedProducts(int $products_category_id)
    {
        foreach (static::$related_products as $related_product) {
            if (!ProductCategory_Product::create([
                "productCategory_id" => $products_category_id,
                "product_id" => $related_product["product_id"],
                "is_active" => $related_product["is_active"]
            ])) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'productscategories_products'");
            }
        }
    }


    private static function storeProductCategory(): int
    {
        // if (count(static::$related_products) > 0) {
        //     static::$products_category_form_fields["is_leaf_category"] = 1;
        // }
        // else {
        //     static::$products_category_form_fields["is_leaf_category"] = 0;
        // }

        static::$products_category_form_fields["is_leaf_category"] = 1;

        $products_category = ProductCategory::create(static::$products_category_form_fields);
        if (!$products_category) {
            throw new \Exception("échec de la création de l'enregistrement dans la table 'productscategories'");
        }

        return $products_category->id;
    }


    private static function makeStorage(): RedirectResponse
    {
        try {
            DB::transaction(function () {

                static::storeProductsCategoryImage();

                $products_category_id = static::storeProductCategory();

                static::storeRelatedProducts($products_category_id);
            });

            $message = [
                "type" => "success",
                "text" => "la catégorie est bien créé."
            ];
        } catch (\Exception $th) {

            if (static::$isProductsCategoryImagesFolderCreated) {
                Storage::deleteDirectory("public/products_categories/id_" . static::$products_category_id);
            }

            $message = [
                "type" => "danger",
                "text" => "la création de la catégorie a échoué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {

            return to_route("products-categories.index")->with("message", $message);
        }
    }



    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(ProductCategoryRequest $products_category_request): RedirectResponse
    {
        static::$products_category_request = $products_category_request;

        static::$products_category_form_fields = $products_category_request->validated();

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }


        $moreValidations_FunctionResult = static::moreValidations();
        if ($moreValidations_FunctionResult instanceof RedirectResponse) {
            return $moreValidations_FunctionResult;
        }


        $preparingData_FunctionResult = static::preparingData();
        if ($preparingData_FunctionResult instanceof RedirectResponse) {
            return $preparingData_FunctionResult;
        }



        return static::makeStorage();
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
