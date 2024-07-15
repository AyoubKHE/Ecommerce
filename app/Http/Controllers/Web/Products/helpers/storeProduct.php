<?php

namespace App\Http\Controllers\Web\Products\helpers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\ProductRequest;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;
use App\Models\ProductVariation;
use App\Models\ProductVariation_AttributeOption;
use App\Services\SubCategories\SubCategoriesService;
use Illuminate\Support\Facades\Storage;


class storeProduct
{
    private static ProductRequest $product_request;

    private static array $product_form_fields;
    private static array $related_categories = [];

    private static int $product_id;

    private static bool $isProductImagesFolderCreated = false;


    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$product_request->user()->cannot("create_products", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission d'ajouter de nouveau produits"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    // More validation of data -----------------------------------------------------------------------------------------------------------

    private static function isProductBelongsAtleastToOneCategory(): bool|RedirectResponse
    {

        if (static::$product_request["related_categories"] === null) {
            $message = [
                "type" => "warning",
                "text" => "Il faut que le produit appartient au moins à une seule catégorie"
            ];
            return back()->with("message", $message);
        }

        return true;
    }
    

    private static function isProductContainsDuplicateImages(): bool|RedirectResponse
    {
        $originalNames = array_map(function ($file) {
            return $file->getClientOriginalName();
        }, static::$product_request->file());

        if (count($originalNames) > count(array_unique($originalNames))) {
            $message = [
                "type" => "warning",
                "text" => "Des images en double ont été détectées."
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    private static function isArr1EqualArr2(array $arr1, array $arr2)
    {
        foreach ($arr1 as $key => $value_arr_1) {
            if ($value_arr_1 !== $arr2[$key]) {
                return false;
            }
        }
        return true;
    }
    private static function areVariationsValid()
    {
        if (static::$product_request["choosed_attributes"] === null && static::$product_request["variations"] === null) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas renseigner les variations de produits"
            ];
            return back()->with("message", $message);
        }

        if (static::$product_request["choosed_attributes"] !== null && static::$product_request["variations"] === null) {
            $message = [
                "type" => "warning",
                "text" => "Vous avez renseigner les attribut mais vous avez pas envoyé les variations"
            ];
            return back()->with("message", $message);
        }

        if (static::$product_request["choosed_attributes"] === null && static::$product_request["variations"] !== null) {
            $message = [
                "type" => "warning",
                "text" => "Vous avez supprimer tous les attributs"
            ];
            return back()->with("message", $message);
        }

        foreach (static::$product_request["variations"] as $key => $variation) {

            foreach ($variation["options"] as $attribute => $option) {

                if ($option === "N/A") {
                    $message = [
                        "type" => "warning",
                        "text" => "Y a un probleme dans la variation " . $key + 1 . ". Vous n avez pas renseigner l option de l attribut " . $attribute
                    ];
                    return back()->with("message", $message);
                }
            }

            if ($variation["quantity_in_stock"] === null) {
                $message = [
                    "type" => "warning",
                    "text" => "Vous avez pas renseigner la quantité dans le stock que la variation " . $key + 1 . " possède"
                ];
                return back()->with("message", $message);
            }
        }

        foreach (static::$product_request["variations"] as $key => $variation) {

            for ($i = $key + 1; $i < count(static::$product_request["variations"]); $i++) {

                if (static::isArr1EqualArr2($variation["options"], static::$product_request["variations"][$i]["options"])) {
                    $message = [
                        "type" => "warning",
                        "text" => "Des variations en double ont été détectées. (variation " . $key + 1 . " et variation " . $i + 1 . ")"
                    ];
                    return back()->with("message", $message);
                }
            }
        }
    }

    private static function moreValidations(): bool|RedirectResponse
    {
        $isProductBelongsAtleastToOneCategory_FunctionResult = static::isProductBelongsAtleastToOneCategory();
        if ($isProductBelongsAtleastToOneCategory_FunctionResult instanceof RedirectResponse) {
            return $isProductBelongsAtleastToOneCategory_FunctionResult;
        }

        $isProductContainsDuplicateImages_FunctionResult = static::isProductContainsDuplicateImages();
        if ($isProductContainsDuplicateImages_FunctionResult instanceof RedirectResponse) {
            return $isProductContainsDuplicateImages_FunctionResult;
        }

        $areVariationsValid_FunctionResult = static::areVariationsValid();
        if ($areVariationsValid_FunctionResult instanceof RedirectResponse) {
            return $areVariationsValid_FunctionResult;
        }

        return true;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------


    // Preparing data for store -----------------------------------------------------------------------------------------------------------

    private static function preparingData(): void
    {
        foreach (static::$product_request["related_categories"] as $category_id => $value) {
            $record["category_id"] = $category_id;
            $record["is_active"] = $value;
            array_push(static::$related_categories, $record);
        }


        $brand = Brand::where("name", static::$product_form_fields["brand_name"])->first();
        unset(static::$product_form_fields["brand_name"]);
        static::$product_form_fields["brand_id"] = $brand->id;

        static::$product_form_fields["added_by"] = auth()->user()->id;


        unset(static::$product_form_fields["product_image_1"]);
        unset(static::$product_form_fields["product_image_2"]);
        unset(static::$product_form_fields["product_image_3"]);
        unset(static::$product_form_fields["product_image_4"]);
    }

    //--------------------------------------------------------------------------------------------------------------------------------------


    // Performing storage ------------------------------------------------------------------------------------------------------------------

    private static function storeRelatedCategories(int $product_id)
    {
        foreach (static::$related_categories as $related_category) {
            if (!ProductCategory_Product::create([
                "product_id" => $product_id,
                "productCategory_id" => $related_category["category_id"],
                "is_active" => $related_category["is_active"]
            ])) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'productscategories_products'");
            }
        }
    }


    private static function storeProductImages(int $product_id)
    {
        foreach (static::$product_request->file() as $key => $file) {

            $product_image_form_fields['image_path'] = $file->store('products/id_' . $product_id, 'public');

            if ($product_image_form_fields['image_path'] === false) {
                throw new \Exception("échec de stocker l'image du produit dans le dossier products");
            }

            static::$isProductImagesFolderCreated = true;

            if ($key === static::$product_request->input("is_default")) {
                $product_image_form_fields['is_default'] = 1;
            } else {
                $product_image_form_fields['is_default'] = 0;
            }

            $product_image_form_fields['product_id'] = $product_id;

            if (!ProductImage::create($product_image_form_fields)) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'productsimages'");
            }
        }
    }


    private static function storeProductVariations(int $product_id)
    {
        foreach (static::$product_request["variations"] as $key => $variation) {

            $product_variation = ProductVariation::create([
                "product_id" => $product_id,
                "price" => $variation["price"],
                "quantity_in_stock" => $variation["quantity_in_stock"],
                "is_active" => $variation["is_active"],
                "image_path" => null,
            ]);

            if (!$product_variation) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'productsVariations'");
            }

            foreach ($variation["options"] as $attribute => $option) {

                $attribute_id = ProductAttribute::where("name", $attribute)->first()->id;

                $attribute_option_id = ProductAttributeOption::where("value", $option)->first()->id;


                if (!ProductVariation_AttributeOption::create([
                    "productVariation_id" => $product_variation->id,
                    "productAttribute_id" => $attribute_id,
                    "productAttributeOption_id" => $attribute_option_id,
                ])) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'productsVariations_attributesOptions'");
                }
            }
        }
    }


    private static function makeStorage(): RedirectResponse
    {
        try {

            DB::transaction(function () {

                $product = Product::create(static::$product_form_fields);

                if (!$product) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'products'");
                }

                static::$product_id = $product->id;

                static::storeRelatedCategories($product->id);

                static::storeProductImages($product->id);

                static::storeProductVariations($product->id);
            });

            $message = [
                "type" => "success",
                "text" => "le produit est bien créé."
            ];
        } catch (\Exception $th) {
            // Si une exception est levée, supprimer les images stockées
            if (static::$isProductImagesFolderCreated) {
                Storage::deleteDirectory("public/products/id_" . static::$product_id);
            }

            $message = [
                "type" => "danger",
                "text" => "la création du produit a échoué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return to_route("products.index")->with("message", $message);
        }
    }

    //------------------------------------------------------------------------------------------------------------------------------------

    //! -----------------------------------------------------------------------------------------------------------------------------------



    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(ProductRequest $product_request): RedirectResponse
    {
        static::$product_request = $product_request;

        $is_user_authorized = static::isUserAuthorized();
        if ($is_user_authorized instanceof RedirectResponse) {
            return $is_user_authorized;
        }

        static::$product_form_fields = $product_request->validated();

        $moreValidations_FunctionResult = static::moreValidations();

        if ($moreValidations_FunctionResult instanceof RedirectResponse) {
            return $moreValidations_FunctionResult;
        }

        static::preparingData();

        return static::makeStorage();
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------

}
