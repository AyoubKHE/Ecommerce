<?php

namespace App\Http\Controllers\Web\Products\helpers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\BackupService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;
use Illuminate\Support\Facades\Storage;

class destroyProduct
{
    private static Product $product;
    private static Request $request;

    private static bool $isBackupCreated = false;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$request->user()->cannot("delete_products", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de supprimer les produits"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function destroyProductVariations()
    {
        $product_variations = static::$product->variations;

        foreach ($product_variations as $product_variation) {

            $variation_options = $product_variation->optionsPivot;

            foreach ($variation_options as $variation_option) {
                if (!$variation_option->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'productsVariations_attributesOptions'");
                }
            }

            if (!$product_variation->delete()) {
                throw new \Exception("échec de supprimer l'enregistrement dans la table 'productsVariations'");
            }
        }
    }



    private static function destroyProductImagesInFolder()
    {

        if (!BackupService::createImagesBackup("products", static::$product->id)) {
            static::$isBackupCreated = false;
            throw new \Exception("échec de crée une sauvgarde pour les images");
        }

        static::$isBackupCreated = true;

        $productsImagesFolder = "public/products/id_" . static::$product->id;
        if (!Storage::deleteDirectory($productsImagesFolder)) {
            throw new \Exception("échec de supprimer le dossier 'products/id_" . static::$product->id . "' qui contient les images de produit");
        }
    }



    private static function destroyProductImagesInDB()
    {
        foreach (static::$product->images as $product_image) {
            if (!$product_image->delete()) {
                throw new \Exception("échec de supprimer l'enregistrement dans la table 'productsimages'");
            }
        }
    }



    private static function destroyRelatedCategories()
    {
        $related_categories = ProductCategory_Product::where("product_id", static::$product->id)->get();
        foreach ($related_categories as $related_category) {
            if (!$related_category->delete()) {
                throw new \Exception("échec de supprimer l'enregistrement dans la table 'productscategories_products'");
            }
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------



    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------


    public static function start(Product $product, Request $request): RedirectResponse
    {
        static::$product = $product;

        static::$request = $request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        try {
            DB::transaction(function () {

                static::destroyProductImagesInFolder();

                static::destroyProductImagesInDB();

                static::destroyRelatedCategories();

                static::destroyProductVariations();

                if (!static::$product->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'products'");
                }

                BackupService::deleteImagesBackup("products", static::$product->id);
            });

            $message = [
                "type" => "success",
                "text" => "Produit bien supprimée"
            ];
        } catch (\Exception $th) {

            if (static::$isBackupCreated) {

                /*
                    la question que j'ai pas trouvé encore de réponse c'est que si par exemple meme la restoration n'est pas aussi réussi. est ce que je fais un autre block catch !!
                */
                BackupService::makeImagesRestoration("products", static::$product->id);
            }

            $message = [
                "type" => "danger",
                "text" => "suppression du produit a échoué",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return to_route("products.index")->with("message", $message);
        }
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
