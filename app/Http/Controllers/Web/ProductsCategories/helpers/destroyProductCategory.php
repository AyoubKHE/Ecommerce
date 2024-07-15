<?php

namespace App\Http\Controllers\Web\ProductsCategories\helpers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Services\BackupService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;
use Illuminate\Support\Facades\Storage;

class destroyProductCategory
{
    private static ProductCategory $products_category;
    private static Request $request;

    private static bool $isBackupCreated = false;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("delete_productsCategories", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de supprimer les catégories"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function destroyProductsCategoryImageInFolder()
    {
        if (!BackupService::createImagesBackup("products_categories", static::$products_category->id)) {
            static::$isBackupCreated = false;
            throw new \Exception("échec de crée une sauvgarde pour les images");
        }

        static::$isBackupCreated = true;

        $productsCategoryImagesFolder = "public/products_categories/id_" . static::$products_category->id;
        if (!Storage::deleteDirectory($productsCategoryImagesFolder)) {
            throw new \Exception("échec de supprimer le dossier 'products/id_" . static::$products_category->id . "' qui contient les images de la catégorie");
        }
    }


    private static function destroyRelatedProducts()
    {
        if (count(static::$products_category->products) !== 0) {
            $related_products = ProductCategory_Product::where("productcategory_id", static::$products_category->id)->get();
            foreach ($related_products as $related_product) {
                if (!$related_product->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'productscategories_products'");
                }
            }
        }
    }

    private static function manageParentCategory()
    {
        $parent_category = ProductCategory::find(static::$products_category->parent_id);

        if ($parent_category !== null) {
            if ($parent_category->childCategories->count() == 1) {

                $parent_category->is_leaf_category = 1;

                if (!$parent_category->save()) {

                    throw new \Exception("échec de modifier la colonne | is_leaf_category | de la catégorie
                                    de base | " . $parent_category->name . " |.");
                }
            }
        }
    }



    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(ProductCategory $products_category, Request $request): RedirectResponse
    {
        static::$products_category = $products_category;

        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        try {
            DB::transaction(function () use ($products_category) {

                static::destroyProductsCategoryImageInFolder();

                static::destroyRelatedProducts();

                static::manageParentCategory();

                if (!$products_category->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'productscategories'");
                }

                BackupService::deleteImagesBackup("products_categories", static::$products_category->id);
            });

            $message = [
                "type" => "success",
                "text" => "Catégorie bien supprimée"
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
                "text" => "suppression de la catégorie a échoué",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {

            return to_route("products-categories.index")->with("message", $message);
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
