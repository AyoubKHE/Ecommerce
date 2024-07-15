<?php

namespace App\Http\Controllers\Web\ProductsCategories\helpers;

use App\Models\ProductCategory;
use App\Services\BackupService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Services\SubCategories\SubCategoriesService;
use App\Models\ProductCategory_Product;
use App\Http\Requests\ProductCategoryRequest;

class enModificationsMadeOn
{
    const nothing_changed = 0;
    const category = 1;
    const related_products = 2;
    const all_changed = 3;
}

class updateProductCategory
{
    private static ProductCategory $products_category;
    private static ProductCategoryRequest $product_category_request;
    private static array $product_category_form_fields;
    private static array $related_products = [];

    private static bool $isBackupCreated = false;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    // Preparing data for update -----------------------------------------------------------------------------------------------------------


    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$product_category_request->user()->cannot("update_productsCategories", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de modifier les catégories"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function moreValidations(): bool|RedirectResponse
    {
        if (static::$product_category_form_fields["base_category_name"] !== "N/A") {

            $parent_category = ProductCategory::where("name", static::$product_category_form_fields["base_category_name"])->first();

            if ($parent_category->products->count() > 0) {
                $message = [
                    "type" => "warning",
                    "text" => "La catégorie | " . $parent_category->name .
                        " | Possède des produits, elle ne peut pas être une catégorie de base pour la catégorie | " . static::$products_category->name . " |."
                ];
                return back()->with("message", $message);
            }

            // if ($parent_category->is_leaf_category == 1) {
            //     $message = [
            //         "type" => "warning",
            //         "text" => "Vous pouvez pas attribuer | " . $parent_category->name .
            //             " | comme la catégorie de base de | " . static::$products_category->name .
            //             " | car la categorie | " . $parent_category->name .
            //             " | possède déja des produits. Vous devez premièrement supprimer toutes les ralation
            //                 de | " . $parent_category->name . " | avec les produits"
            //     ];
            //     return back()->with("message", $message);
            // }
        }

        return true;
    }


    private static function preparingBaseCategory(): bool|RedirectResponse
    {
        if (static::$product_category_form_fields["base_category_name"] !== "N/A") {
            $parent_category = ProductCategory::where("name", static::$product_category_form_fields["base_category_name"])->first();

            if ($parent_category->is_leaf_category == 1) {
                $parent_category->is_leaf_category = 0;

                if (!$parent_category->save()) {
                    $message = [
                        "type" => "danger",
                        "text" => "la modification de la catégorie a échoué. Réessayer plus tard",
                        "error" => "échec de modifier la colonne | is_leaf_category | de la catégorie
                                    de base | " . $parent_category->name . " |.",
                    ];
                    return back()->with("message", $message);
                }
            }

            unset(static::$product_category_form_fields["base_category_name"]);
            static::$product_category_form_fields["parent_id"] = $parent_category->id;
        } else {

            $parent_category = ProductCategory::find(static::$products_category->parent_id);

            if ($parent_category !== null) {
                if ($parent_category->childCategories->count() == 1) {

                    $parent_category->is_leaf_category = 1;

                    if (!$parent_category->save()) {
                        $message = [
                            "type" => "danger",
                            "text" => "la modification de la catégorie a échoué. Réessayer plus tard",
                            "error" => "échec de modifier la colonne | is_leaf_category | de la catégorie
                                        de base | " . $parent_category->name . " |.",
                        ];
                        return back()->with("message", $message);
                    }
                }
            }


            unset(static::$product_category_form_fields["base_category_name"]);
            static::$product_category_form_fields["parent_id"] = null;
        }

        return true;
    }


    private static function preparingCategory(): void
    {
        $original_data = static::$products_category->getOriginal();

        foreach (static::$product_category_form_fields as $key => $value) {
            if (array_key_exists($key, $original_data)) {

                if ($key === "parent_id") {
                    if ($value == $original_data[$key]) {
                        unset(static::$product_category_form_fields[$key]);
                    }
                } else {
                    if ($value === null || $value == $original_data[$key]) {
                        unset(static::$product_category_form_fields[$key]);
                    }
                }
            }
        }
    }


    private static function preparingUpdatedAndDeletedRelations(): void
    {
        if (
            count(static::$products_category->products) !== 0 &&
            !isset(static::$product_category_form_fields["is_active"])
        ) {

            static::$related_products["allRelations"] = ProductCategory_Product::where("productCategory_id", static::$products_category->id)->get();

            static::$related_products["updated_relations"] = [];
            static::$related_products["deleted_relations"] = [];

            foreach (static::$related_products["allRelations"] as $key => $related_product) {

                if (isset(static::$product_category_request["related_products"][$related_product->product_id])) {

                    if ($related_product->is_active != static::$product_category_request["related_products"][$related_product->product_id]) {

                        array_push(static::$related_products["updated_relations"], $related_product);
                    }
                } else {

                    array_push(static::$related_products["deleted_relations"], $related_product);
                }

                unset(static::$related_products["allRelations"][$key]);
            }

            if (count(static::$related_products["updated_relations"]) === 0) {
                unset(static::$related_products["updated_relations"]);
            }

            if (count(static::$related_products["deleted_relations"]) === 0) {
                unset(static::$related_products["deleted_relations"]);
            }
        }
    }
    private static function preparingNewRelations(): void
    {

        if (isset(static::$product_category_request["related_products"])) {

            static::$related_products["new_relations"] = [];

            foreach (static::$product_category_request["related_products"] as $product_id => $value) {

                if (count(static::$products_category->products->where("id", $product_id)) !== 0) {

                    continue;
                } else {

                    $new_relation["product_id"] = $product_id;
                    $new_relation["is_active"] = isset(static::$product_category_form_fields["is_active"]) ?
                        static::$product_category_form_fields["is_active"] :
                        $value;
                    array_push(static::$related_products["new_relations"], $new_relation);
                }
            }

            if (count(static::$related_products["new_relations"]) === 0) {
                unset(static::$related_products["new_relations"]);
            }
        }
    }
    private static function preparingRelatedProducts(): void
    {

        static::preparingUpdatedAndDeletedRelations();

        static::preparingNewRelations();
    }


    private static function preparingData(): bool|RedirectResponse
    {
        // static::preparingBaseCategory();

        $preparingBaseCategory_FunctionResult = static::preparingBaseCategory();
        if ($preparingBaseCategory_FunctionResult instanceof RedirectResponse) {
            return $preparingBaseCategory_FunctionResult;
        }

        static::preparingCategory();

        static::preparingRelatedProducts();

        return true;
    }

    //-------------------------------------------------------------------------------------------------------------------------------------

    // Verfiying if user made any changes -------------------------------------------------------------------------------------------------


    private static function isCategoryChanged(): bool
    {
        return count(static::$product_category_form_fields) !== 0 ||
            static::$product_category_request->hasFile('product_category_image');
    }


    private static function isRelatedProductsChanged(): bool
    {
        if (isset(static::$related_products["new_relations"])) {
            return true;
        }

        if (isset(static::$product_category_form_fields["is_active"])) {
            return false;
        }

        return isset(static::$related_products["updated_relations"]) ||
            isset(static::$related_products["deleted_relations"]);
    }


    private static function modificationsMadeOn(): int
    {

        $is_category_changed = static::isCategoryChanged();

        $is_category_products_changed = static::isRelatedProductsChanged();


        if (!$is_category_changed && !$is_category_products_changed) {
            return enModificationsMadeOn::nothing_changed;
        } elseif ($is_category_changed && !$is_category_products_changed) {
            return enModificationsMadeOn::category;
        } elseif (!$is_category_changed && $is_category_products_changed) {
            return enModificationsMadeOn::related_products;
        } else {
            return enModificationsMadeOn::all_changed;
        }
    }

    //------------------------------------------------------------------------------------------------------------------------------------

    // Performing updates ----------------------------------------------------------------------------------------------------------------


    private static function updateProductsCategoryImage(): void
    {
        if (static::$product_category_request->hasFile('product_category_image')) {

            if (!BackupService::createImagesBackup("products_categories", static::$products_category->id)) {
                static::$isBackupCreated = false;
                throw new \Exception("échec de crée une sauvgarde pour les images");
            }

            static::$isBackupCreated = true;

            if (!unlink(storage_path('app/public/' . static::$products_category->image_path))) {
                throw new \Exception("échec de supprimer l'ancienne image dans le dossier products_categories");
            }

            $imageFile = static::$product_category_request->file('product_category_image');
            $folderPath = 'products_categories/id_' . static::$products_category->id;
            static::$product_category_form_fields["image_path"] = $imageFile->store($folderPath, 'public');
            if (!static::$product_category_form_fields["image_path"]) {
                throw new \Exception("échec de stocké la nouvelle image dans le dossier products_categories");
            }

            unset(static::$product_category_form_fields["product_category_image"]);
        }
    }
    private static function updateSubCategories(): void
    {
        $sub_categories = SubCategoriesService::getSubCategoriesListForSpecificCategory(static::$products_category->id);

        foreach ($sub_categories as $sub_category) {
            if (!ProductCategory::find($sub_category->id)->update(["is_active" => (int)static::$product_category_form_fields["is_active"]])) {
                throw new \Exception("échec de mise à jour les sous catégories");
            }
        }
    }
    private static function updateProductsCategory(): void
    {

        static::updateProductsCategoryImage();

        if (!static::$products_category->update(static::$product_category_form_fields)) {
            throw new \Exception("échec de mise à jour l'enregistrement dans la table 'productscategories'");
        }

        if (isset(static::$product_category_form_fields["is_active"])) {

            static::updateSubCategories();

            static::$related_products["allRelations"] = ProductCategory_Product::where("productCategory_id", static::$products_category->id)->get();

            foreach (static::$related_products["allRelations"] as $relation) {
                if (!$relation->update(["is_active" => (int)static::$product_category_form_fields["is_active"]])) {
                    throw new \Exception("échec de mise à jour dans la table 'productscategories_products'");
                }
            }
        }

        BackupService::deleteImagesBackup("products_categories", static::$products_category->id);
    }


    private static function manageUpdatedRelations(): void
    {
        if (isset(static::$related_products["updated_relations"])) {
            foreach (static::$related_products["updated_relations"] as $updated_relation) {
                $original_data_is_active = $updated_relation->is_active;
                if (!$updated_relation->update(["is_active" => $original_data_is_active == "1" ? 0 : 1])) {
                    throw new \Exception("échec de mise à jour dans la table 'productscategories_products'");
                }
            }
        }
    }
    private static function manageDeletedRelations(): void
    {
        if (isset(static::$related_products["deleted_relations"])) {
            foreach (static::$related_products["deleted_relations"] as $deleted_relation) {
                if (!$deleted_relation->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'productscategories_products'");
                }
            }
        }
    }
    private static function manageNewRelations(): void
    {
        if (isset(static::$related_products["new_relations"])) {
            foreach (static::$related_products["new_relations"] as $new_relation) {
                if (!ProductCategory_Product::create([
                    "productCategory_id" => self::$products_category->id,
                    "product_id" => $new_relation["product_id"],
                    "is_active" => $new_relation["is_active"]
                ])) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'productscategories_products'");
                }
            }
        }
    }
    private static function updateRelatedProducts(): void
    {
        static::manageUpdatedRelations();

        static::manageDeletedRelations();

        static::manageNewRelations();
    }


    private static function makeUpdate(int $modificationsMadeOn): RedirectResponse
    {
        try {

            switch ($modificationsMadeOn) {
                case enModificationsMadeOn::nothing_changed:
                    $message = [
                        "type" => "warning",
                        "text" => "Vous n avez rien modifié !"
                    ];

                    return back()->with("message", $message);

                    break;

                case enModificationsMadeOn::category:
                    DB::transaction(function () {
                        self::updateProductsCategory();
                    });

                    break;

                case enModificationsMadeOn::related_products:
                    DB::transaction(function () {
                        self::updateRelatedProducts();
                    });

                    break;

                case enModificationsMadeOn::all_changed:
                    DB::transaction(function () {
                        self::updateProductsCategory();
                        self::updateRelatedProducts();
                    });

                    break;
            }

            $message = [
                "type" => "success",
                "text" => "Catégorie bien modifiée"
            ];
        } catch (\Exception $th) {

            if (static::$isBackupCreated) {
                /*
                    la question que j'ai pas trouvé encore de réponse c'est que si par exemple meme la restoration n'est pas aussi réussi. est ce que je fais un autre block catch !!
                */
                BackupService::makeImagesRestoration("products_categories", static::$products_category->id);
            }

            $message = [
                "type" => "danger",
                "text" => "Modification de la catégorie a échoué",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            // Retourner avec le message approprié
            return back()->with("message", $message);
        }
    }

    //-------------------------------------------------------------------------------------------------------------------------------------

    //! -----------------------------------------------------------------------------------------------------------------------------------



    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(ProductCategory $products_category, ProductCategoryRequest $product_category_request): RedirectResponse
    {
        static::$products_category = $products_category;
        static::$product_category_request = $product_category_request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        static::$product_category_form_fields = static::$product_category_request->validated();

        $moreValidations_FunctionResult = static::moreValidations();

        if ($moreValidations_FunctionResult instanceof RedirectResponse) {
            return $moreValidations_FunctionResult;
        }

        $preparingData_FunctionResult = static::preparingData();
        if ($preparingData_FunctionResult instanceof RedirectResponse) {
            return $preparingData_FunctionResult;
        }

        $modificationsMadeOn_FunctionResult = self::modificationsMadeOn();

        return static::makeUpdate($modificationsMadeOn_FunctionResult);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------
}
