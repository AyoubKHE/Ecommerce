<?php

namespace App\Http\Controllers\Web\Products\helpers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\BackupService;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductCategory_Product;
use App\Models\ProductVariation_AttributeOption;

class enModificationsMadeOn
{
    const nothing_changed = 0;

    const product = 1;
    const related_categories = 2;
    const product_images = 3;
    const product_variations = 4;

    const product_and_related_categories = 5;
    const product_and_product_images = 6;
    const product_and_product_variations = 7;
    const related_categories_and_product_images = 8;
    const related_categories_and_product_variations = 9;
    const product_images_and_product_variations = 10;


    const product_and_product_categories_and_product_images = 11;
    const product_and_product_categories_and_product_variations = 12;
    const product_and_product_images_and_product_variations = 13;
    const product_categories_and_product_images_and_product_variations = 14;


    const all_changed = 15;
}

class updateProduct
{
    private static Product $product; // pointer
    private static ProductRequest $product_request; // pointer
    private static array $product_form_fields;
    private static array $related_categories = [];

    private static array $product_images = [];

    private static bool $isBackupCreated = false;

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function isUserAuthorized(): bool|RedirectResponse
    {
        if (static::$product_request->user()->cannot("update_products", [auth()->user()])) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez pas la permission de modifier les produits"
            ];
            return back()->with("message", $message);
        }

        return true;
    }


    // More validation of data -----------------------------------------------------------------------------------------------------------

    private static function isProductBelongsAtleastToOneCategory(): bool|RedirectResponse
    {

        if(static::$product_request["related_categories"] === null) {
            $message = [
                "type" => "warning",
                "text" => "Il faut que le produit appartient au moins à une seule catégorie"
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

        if (static::$product_request->input("deleted_images_numbers") !== null) {
            if (count(static::$product_request->input("deleted_images_numbers")) === count(static::$product->images)) {
                $message = [
                    "type" => "warning",
                    "text" => "Il faut que le produit possède au moin une image"
                ];
                return back()->with("message", $message);
            }
        }

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

        $areVariationsValid_FunctionResult = static::areVariationsValid();
        if ($areVariationsValid_FunctionResult instanceof RedirectResponse) {
            return $areVariationsValid_FunctionResult;
        }

        return true;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------


    // Preparing data for update -----------------------------------------------------------------------------------------------------------


    private static function preparingBrand(): void
    {
        $brand = Brand::where("name", static::$product_form_fields["brand_name"])->first();
        unset(static::$product_form_fields["brand_name"]);
        static::$product_form_fields["brand_id"] = $brand->id;
    }


    private static function preparingProduct(): void
    {
        $original_data = static::$product->getOriginal();

        foreach (static::$product_form_fields as $key => $value) {
            if (array_key_exists($key, $original_data)) {

                if ($value === null || $value == $original_data[$key]) {
                    unset(static::$product_form_fields[$key]);
                }
            }
        }

        unset(static::$product_form_fields["product_image_1"]);
        unset(static::$product_form_fields["product_image_2"]);
        unset(static::$product_form_fields["product_image_3"]);
        unset(static::$product_form_fields["product_image_4"]);
    }


    private static function preparingUpdatedAndDeletedRelations(): void
    {
        if (!isset(static::$product_form_fields["is_active"])) {

            static::$related_categories["allCategories"] = ProductCategory_Product::where("product_id", static::$product->id)->get();

            static::$related_categories["updated_relations"] = [];
            static::$related_categories["deleted_relations"] = [];

            foreach (static::$related_categories["allCategories"] as $key => $related_category) {

                if (isset(static::$product_request["related_categories"][$related_category->productCategory_id])) {

                    if ($related_category->is_active != static::$product_request["related_categories"][$related_category->productCategory_id]) {

                        array_push(static::$related_categories["updated_relations"], $related_category);
                    }
                } else {

                    array_push(static::$related_categories["deleted_relations"], $related_category);
                }
            }

            unset(static::$related_categories["allCategories"]);

            if (count(static::$related_categories["updated_relations"]) === 0) {
                unset(static::$related_categories["updated_relations"]);
            }

            if (count(static::$related_categories["deleted_relations"]) === 0) {
                unset(static::$related_categories["deleted_relations"]);
            }
        }
    }
    private static function preparingNewRelations(): void
    {
        static::$related_categories["new_relations"] = [];

        foreach (static::$product_request["related_categories"] as $category_id => $value) {
            if (count(static::$product->categories->where("id", $category_id)) !== 0) {

                continue;
            } else {

                $new_relation["category_id"] = $category_id;
                $new_relation["is_active"] = isset(static::$product_form_fields["is_active"]) ?
                    static::$product_form_fields["is_active"] :
                    $value;
                array_push(static::$related_categories["new_relations"], $new_relation);
            }
        }

        if (count(static::$related_categories["new_relations"]) === 0) {
            unset(static::$related_categories["new_relations"]);
        }
    }
    private static function preparingRelatedCategories(): void
    {
        static::preparingUpdatedAndDeletedRelations();

        static::preparingNewRelations();
    }


    private static function preparingProductImages(): void
    {
        if (count(static::$product_request->file()) > 0) {

            static::$product_images['updated_images'] = [];
            static::$product_images['new_images'] = [];

            foreach (static::$product_request->file() as $key => $file) {

                $image_number = explode("_", $key)[2];
                if ((int)$image_number <= count(static::$product->images)) {

                    static::$product_images['updated_images'][$image_number] = $file;
                } else {

                    static::$product_images['new_images'][$image_number] = $file;
                }
            }

            if (count(static::$product_images['updated_images']) === 0) {
                unset(static::$product_images['updated_images']);
            }

            if (count(static::$product_images['new_images']) === 0) {
                unset(static::$product_images['new_images']);
            }
        }
    }


    private static function preparingData(): void
    {

        static::preparingBrand();

        static::preparingProduct();

        static::preparingRelatedCategories();

        static::preparingProductImages();
    }

    //--------------------------------------------------------------------------------------------------------------------------------------


    // Verfiying if user made any changes --------------------------------------------------------------------------------------------------


    private static function isProductChanged(): bool
    {
        return count(static::$product_form_fields) !== 0;
    }


    private static function isRelatedCategoriesChanged(): bool
    {

        if (isset(static::$related_categories["new_relations"])) {
            return true;
        }

        if (isset(static::$product_form_fields["is_active"])) {
            return false;
        }

        return isset(static::$related_categories["updated_relations"]) ||
            isset(static::$related_categories["deleted_relations"]);
    }


    private static function isProductImagesChanged(): bool
    {
        return static::$product_request->input("deleted_images_numbers") !== null ||
            count(static::$product_request->file()) > 0 ||
            static::$product_request->input("old_default_image") !== null;
    }


    private static function isProductVariationsChanged(): bool
    {

        if (
            static::$product_request["removed_attributes"] !== null ||
            static::$product_request["new_attributes"] !== null ||
            static::$product->variations->count() < count(static::$product_request["variations"])
        ) {
            return true;
        }

        $originale_product_variations = ProductVariation::where('product_id', static::$product->id)
            ->with("options", function ($query) {
                $query->with("productAttribute");
            })->get();

        foreach ($originale_product_variations as $index => $originale_variation) {

            $received_variation = static::$product_request["variations"][$index];

            foreach ($received_variation["options"] as $received_variation_attribut => $received_variation_option) {

                $received_variation_attribut_id = ProductAttribute::where("name", $received_variation_attribut)->first()->id;

                $received_variation_option_id = ProductAttributeOption::where("value", $received_variation_option)->first()->id;

                $originale_variation_option = ProductVariation_AttributeOption::where("productVariation_id", $originale_variation->id)
                    ->where("productAttribute_id", $received_variation_attribut_id)->first();

                if ($originale_variation_option->productAttributeOption_id !== $received_variation_option_id) {

                    return true;
                }
            }

            if ($received_variation["price"] != $originale_variation->price) {
                return true;
            }

            if ($received_variation["quantity_in_stock"] != $originale_variation->quantity_in_stock) {
                return true;
            }

            if ($received_variation["is_active"] != $originale_variation->is_active) {
                return true;
            }
        }

        return false;
    }


    private static function modificationsMadeOn(): int
    {

        $is_product_changed = static::isProductChanged();

        $is_related_categories_changed = static::isRelatedCategoriesChanged();

        $is_product_images_changed = static::isProductImagesChanged();

        $is_product_variations_changed = static::isProductVariationsChanged();


        if (!$is_product_changed && !$is_related_categories_changed && !$is_product_images_changed && !$is_product_variations_changed) {
            return enModificationsMadeOn::nothing_changed;
        }

        // ----------------------------------------------------------------------------------------------------------------------------------------

        elseif ($is_product_changed && !$is_related_categories_changed && !$is_product_images_changed && !$is_product_variations_changed) {
            return enModificationsMadeOn::product;
        } elseif (!$is_product_changed && $is_related_categories_changed && !$is_product_images_changed && !$is_product_variations_changed) {
            return enModificationsMadeOn::related_categories;
        } elseif (!$is_product_changed && !$is_related_categories_changed && $is_product_images_changed && !$is_product_variations_changed) {
            return enModificationsMadeOn::product_images;
        } elseif (!$is_product_changed && !$is_related_categories_changed && !$is_product_images_changed && $is_product_variations_changed) {
            return enModificationsMadeOn::product_variations;
        }

        // ----------------------------------------------------------------------------------------------------------------------------------------

        elseif ($is_product_changed && $is_related_categories_changed && !$is_product_images_changed && !$is_product_variations_changed) {
            return enModificationsMadeOn::product_and_related_categories;
        } elseif ($is_product_changed && !$is_related_categories_changed && $is_product_images_changed && !$is_product_variations_changed) {
            return enModificationsMadeOn::product_and_product_images;
        } elseif ($is_product_changed && !$is_related_categories_changed && !$is_product_images_changed && $is_product_variations_changed) {
            return enModificationsMadeOn::product_and_product_variations;
        } elseif (!$is_product_changed && $is_related_categories_changed && $is_product_images_changed && !$is_product_variations_changed) {
            return enModificationsMadeOn::related_categories_and_product_images;
        } elseif (!$is_product_changed && $is_related_categories_changed && !$is_product_images_changed && $is_product_variations_changed) {
            return enModificationsMadeOn::related_categories_and_product_variations;
        } elseif (!$is_product_changed && !$is_related_categories_changed && $is_product_images_changed && $is_product_variations_changed) {
            return enModificationsMadeOn::product_images_and_product_variations;
        }

        // ----------------------------------------------------------------------------------------------------------------------------------------

        elseif ($is_product_changed && $is_related_categories_changed && $is_product_images_changed && !$is_product_variations_changed) {
            return enModificationsMadeOn::product_and_product_categories_and_product_images;
        } elseif ($is_product_changed && $is_related_categories_changed && !$is_product_images_changed && $is_product_variations_changed) {
            return enModificationsMadeOn::product_and_product_categories_and_product_variations;
        } elseif ($is_product_changed && !$is_related_categories_changed && $is_product_images_changed && $is_product_variations_changed) {
            return enModificationsMadeOn::product_and_product_images_and_product_variations;
        } elseif (!$is_product_changed && $is_related_categories_changed && $is_product_images_changed && $is_product_variations_changed) {
            return enModificationsMadeOn::product_categories_and_product_images_and_product_variations;
        }

        // ----------------------------------------------------------------------------------------------------------------------------------------

        elseif ($is_product_changed && $is_related_categories_changed && $is_product_images_changed) {
            return enModificationsMadeOn::all_changed;
        }
    }

    //--------------------------------------------------------------------------------------------------------------------------------------


    // Performing updates ------------------------------------------------------------------------------------------------------------------


    private static function updateProduct(): void
    {
        if (!static::$product->update(static::$product_form_fields)) {
            throw new \Exception("échec de mis à jour l'enregistrement dans la table 'productscategories'");
        }

        if (isset(static::$product_form_fields["is_active"])) {

            static::$related_categories["allCategories"] = ProductCategory_Product::where("product_id", static::$product->id)->get();

            foreach (static::$related_categories["allCategories"] as $related_category) {
                if (!$related_category->update(["is_active" => (int)static::$product_form_fields["is_active"]])) {
                    throw new \Exception("échec de mis à jour dans la table 'productscategories_products'");
                }
            }
        }
    }


    private static function manageUpdatedRelations(): void
    {
        if (isset(static::$related_categories["updated_relations"])) {
            foreach (static::$related_categories["updated_relations"] as $related_category) {
                $original_data_is_active = $related_category->is_active;
                if (!$related_category->update(["is_active" => $original_data_is_active == "1" ? 0 : 1])) {
                    throw new \Exception("échec de mis à jour dans la table 'productscategories_products'");
                }
            }
        }
    }
    private static function manageDeletedRelations(): void
    {
        if (isset(static::$related_categories["deleted_relations"])) {
            foreach (static::$related_categories["deleted_relations"] as $related_category) {
                if (!$related_category->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'productscategories_products'");
                }
            }
        }
    }
    private static function manageNewRelations(): void
    {
        if (isset(static::$related_categories["new_relations"])) {
            foreach (static::$related_categories["new_relations"] as $related_category) {
                if (!ProductCategory_Product::create([
                    "product_id" => static::$product->id,
                    "productCategory_id" => $related_category["category_id"],
                    "is_active" => $related_category["is_active"]
                ])) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'productscategories_products'");
                }
            }
        }
    }
    private static function updateRelatedCategories(): void
    {

        static::manageUpdatedRelations();

        static::manageDeletedRelations();

        static::manageNewRelations();
    }


    private static function manageOldDefaultImage(): void
    {

        $deleted_images_numbers = static::$product_request->input("deleted_images_numbers");
        $old_index = (int)static::$product_request->input("old_default_image") - 1;

        if ($deleted_images_numbers === null || !in_array($old_index, $deleted_images_numbers)) {
            $old_default_image = static::$product->images[$old_index];
            $old_default_image->is_default = 0;

            if (!$old_default_image->save()) {
                throw new \Exception("échec de mise à jour dans la table 'productsimages'");
            }
        }
    }
    private static function manageNewDefaultImage(): void
    {
        $new_index = (int)static::$product_request->input("new_default_image") - 1;

        if ($new_index + 1 <= count(static::$product->images)) {
            $new_default_image = static::$product->images[$new_index];
            $new_default_image->is_default = 1;

            if (!$new_default_image->save()) {
                throw new \Exception("échec de mise à jour dans la table 'productsimages'");
            }
        }
    }
    private static function manageImagesDefaultStatus(): void
    {
        if (static::$product_request->input("old_default_image") !== null) {

            static::manageOldDefaultImage();
            static::manageNewDefaultImage();
        }
    }


    private static function manageNewImages(): void
    {
        if (isset(static::$product_images['new_images'])) {
            foreach (static::$product_images['new_images'] as $image_number => $image) {

                $product_image_form_fields['image_path'] = $image->store('products/id_' . static::$product->id, 'public');

                if (!$product_image_form_fields['image_path']) {
                    throw new \Exception("échec de stocker l'image du produit dans le dossier products");
                }

                if ("product_image_" . $image_number === static::$product_request->input("is_default")) {
                    $product_image_form_fields['is_default'] = 1;
                } else {
                    $product_image_form_fields['is_default'] = 0;
                }

                $product_image_form_fields['product_id'] = static::$product->id;

                if (!ProductImage::create($product_image_form_fields)) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'productsimages'");
                }
            }
        }
    }
    private static function manageUpdatedImages(): void
    {

        if (isset(static::$product_images['updated_images'])) {
            foreach (static::$product_images['updated_images'] as $image_number => $image) {

                $old_image = static::$product->images[$image_number - 1];

                if (!unlink(storage_path('app/public/' . $old_image->image_path))) {
                    throw new \Exception("échec de supprimer l'ancienne image dans le dossier products");
                }

                $old_image["image_path"] = $image->store('products/id_' . static::$product->id, 'public');

                if (!$old_image["image_path"]) {
                    throw new \Exception("échec de stocké la nouvelle image dans le dossier products");
                }

                if (!$old_image->save()) {
                    throw new \Exception("échec de mis à jour dans la table 'productsimages'");
                }
            }
        }
    }
    private static function manageDeletedImages(): void
    {
        $deleted_images_numbers = static::$product_request->input("deleted_images_numbers");

        if ($deleted_images_numbers !== null) {

            foreach ($deleted_images_numbers as $deleted_image_number) {

                $deleted_image = static::$product->images[$deleted_image_number];

                if (!unlink(storage_path('app/public/' . $deleted_image->image_path))) {
                    throw new \Exception("échec de supprimer l'image dans le dossier products");
                }

                if (!$deleted_image->delete()) {
                    throw new \Exception("échec de mis à jour dans la table 'productsimages'");
                }
            }
        }
    }
    private static function updateProductImages(): void
    {

        static::manageImagesDefaultStatus();

        if (count(static::$product_request->file()) > 0 || static::$product_request->input("deleted_images_numbers") !== null) {

            if (!BackupService::createImagesBackup("products", static::$product->id)) {
                static::$isBackupCreated = false;
                throw new \Exception("échec de crée une sauvgarde pour les images");
            }
            static::$isBackupCreated = true;

            static::manageUpdatedImages();

            static::manageNewImages();

            static::manageDeletedImages();

            BackupService::deleteImagesBackup("products", static::$product->id);
        }
    }



    private static function manageNewAttributes(): void
    {
        if (static::$product_request["new_attributes"] !== null) {
            $product_variations = ProductVariation::where('product_id', static::$product->id)->with("options", function ($query) {
                $query->with("productAttribute");
            })->get();

            foreach ($product_variations as $index => $variation) {

                foreach (static::$product_request["new_attributes"] as $new_attribute) {

                    $new_attribute_id = ProductAttribute::where("name", $new_attribute)->first()->id;

                    $attribute_option = static::$product_request["variations"][$index]["options"][$new_attribute];

                    $attribute_option_id = ProductAttributeOption::where("value", $attribute_option)->first()->id;

                    if (!ProductVariation_AttributeOption::create([
                        "productVariation_id" => $variation->id,
                        "productAttribute_id" => $new_attribute_id,
                        "productAttributeOption_id" => $attribute_option_id
                    ])) {
                        throw new \Exception("échec de la création de l'enregistrement dans la table 'productsVariations_attributesOptions'");
                    }
                }
            }
        }
    }
    private static function manageDeletedAttributes(): void
    {
        if (static::$product_request["removed_attributes"] !== null) {

            $product_variations = ProductVariation::where('product_id', static::$product->id)->with("options", function ($query) {
                $query->with("productAttribute");
            })->get();

            foreach ($product_variations as $variation) {
                foreach (static::$product_request["removed_attributes"] as $removed_attribute) {

                    $removed_attribute_id = ProductAttribute::where("name", $removed_attribute)->first()->id;

                    $option_id = $variation->options->filter(function ($option) use ($removed_attribute) {
                        return $option->productAttribute->name === $removed_attribute;
                    })->first()->id;

                    $variation_option = ProductVariation_AttributeOption::where("productVariation_id", $variation->id)
                        ->where("productAttribute_id", $removed_attribute_id)
                        ->where("productAttributeOption_id", $option_id)->first();

                    if (!$variation_option->delete()) {
                        throw new \Exception("échec de supprimer l'enregistrement dans la table 'productsVariations_attributesOptions'");
                    }
                }
            }
        }
    }
    private static function manageUpdatedAttributes(array $received_variation_options, int $originale_variation_id): void
    {
        foreach ($received_variation_options as $received_variation_attribut => $received_variation_option) {

            $received_variation_attribut_id = ProductAttribute::where("name", $received_variation_attribut)->first()->id;

            $received_variation_option_id = ProductAttributeOption::where("value", $received_variation_option)->first()->id;

            $originale_variation_option = ProductVariation_AttributeOption::where("productVariation_id", $originale_variation_id)
                ->where("productAttribute_id", $received_variation_attribut_id)->first();

            if ($originale_variation_option->productAttributeOption_id !== $received_variation_option_id) {

                if (!$originale_variation_option->delete()) {
                    throw new \Exception("échec de supprimer l'enregistrement dans la table 'productsVariations_attributesOptions'");
                }

                if (!ProductVariation_AttributeOption::create([
                    "productVariation_id" => $originale_variation_id,
                    "productAttribute_id" => $received_variation_attribut_id,
                    "productAttributeOption_id" => $received_variation_option_id,
                ])) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'productsVariations_attributesOptions'");
                }
            }
        }
    }
    private static function manageUpdatedVariations(): void
    {
        $originale_product_variations = ProductVariation::where('product_id', static::$product->id)
            ->with("options", function ($query) {
                $query->with("productAttribute");
            })->get();

        foreach ($originale_product_variations as $index => $originale_variation) {

            $received_variation = static::$product_request["variations"][$index];

            static::manageUpdatedAttributes($received_variation["options"], $originale_variation->id);

            unset($received_variation["options"]);

            if ($received_variation["price"] == $originale_variation->price) {
                unset($received_variation["price"]);
            }

            if ($received_variation["quantity_in_stock"] == $originale_variation->quantity_in_stock) {
                unset($received_variation["quantity_in_stock"]);
            }

            if ($received_variation["is_active"] == $originale_variation->is_active) {
                unset($received_variation["is_active"]);
            }

            if (count($received_variation) !== 0) {
                if (!$originale_variation->update($received_variation)) {
                    throw new \Exception("échec de mis à jour dans la table 'productsVariations'");
                }
            }
        }
    }
    private static function manageNewVariations(): void
    {

        $product_variations_count = static::$product->variations->count();

        for ($i = $product_variations_count; $i < count(static::$product_request["variations"]); $i++) {

            $new_variation = static::$product_request["variations"][$i];

            $product_variation = ProductVariation::create([
                "product_id" => static::$product->id,
                "price" => $new_variation["price"],
                "quantity_in_stock" => $new_variation["quantity_in_stock"],
                "is_active" => $new_variation["is_active"],
                "image_path" => null,
            ]);

            if (!$product_variation) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'productsVariations'");
            }

            foreach ($new_variation["options"] as $attribute => $option) {

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
    private static function updateProductVariations(): void
    {
        static::manageDeletedAttributes();

        static::manageNewAttributes();

        static::manageUpdatedVariations();

        static::manageNewVariations();
    }


    private static function makeUpdate(int $modificationsMadeOn): RedirectResponse
    {
        try {

            switch ($modificationsMadeOn) {
                case enModificationsMadeOn::nothing_changed:

                    $message = [
                        "type" => "warning",
                        "text" => "Vous n avez rien modifier !"
                    ];
                    return back()->with("message", $message);
                    break;
                case enModificationsMadeOn::product:

                    DB::transaction(function () {
                        static::updateProduct();
                    });

                    break;

                case enModificationsMadeOn::related_categories:
                    DB::transaction(function () {
                        static::updateRelatedCategories();
                    });

                    break;
                case enModificationsMadeOn::product_images:

                    DB::transaction(function () {
                        static::updateProductImages();
                    });

                    break;

                case enModificationsMadeOn::product_variations:
                    DB::transaction(function () {
                        static::updateProductVariations();
                    });

                    break;

                case enModificationsMadeOn::product_and_related_categories:

                    DB::transaction(function () {
                        static::updateProduct();
                        static::updateRelatedCategories();
                    });

                    break;
                case enModificationsMadeOn::product_and_product_images:

                    DB::transaction(function () {
                        static::updateProduct();
                        static::updateProductImages();
                    });

                    break;

                case enModificationsMadeOn::product_and_product_variations:

                    DB::transaction(function () {
                        static::updateProduct();
                        static::updateProductVariations();
                    });

                    break;

                case enModificationsMadeOn::related_categories_and_product_images:

                    DB::transaction(function () {
                        static::updateRelatedCategories();
                        static::updateProductImages();
                    });

                    break;

                case enModificationsMadeOn::related_categories_and_product_variations:

                    DB::transaction(function () {
                        static::updateRelatedCategories();
                        static::updateProductVariations();
                    });

                    break;

                case enModificationsMadeOn::product_images_and_product_variations:

                    DB::transaction(function () {
                        static::updateProductImages();
                        static::updateProductVariations();
                    });

                    break;

                case enModificationsMadeOn::product_and_product_categories_and_product_images:

                    DB::transaction(function () {
                        static::updateProduct();
                        static::updateRelatedCategories();
                        static::updateProductImages();
                    });

                    break;

                case enModificationsMadeOn::product_and_product_categories_and_product_variations:

                    DB::transaction(function () {
                        static::updateProduct();
                        static::updateRelatedCategories();
                        static::updateProductVariations();
                    });

                    break;

                case enModificationsMadeOn::product_and_product_images_and_product_variations:

                    DB::transaction(function () {
                        static::updateProduct();
                        static::updateProductImages();
                        static::updateProductVariations();
                    });

                    break;

                case enModificationsMadeOn::product_categories_and_product_images_and_product_variations:

                    DB::transaction(function () {
                        static::updateRelatedCategories();
                        static::updateProductImages();
                        static::updateProductVariations();
                    });

                    break;

                case enModificationsMadeOn::all_changed:

                    DB::transaction(function () {
                        static::updateProduct();
                        static::updateRelatedCategories();
                        static::updateProductImages();
                        static::updateProductVariations();
                    });

                    break;
            }

            $message = [
                "type" => "success",
                "text" => "Produit bien modifiée"
            ];
        } catch (\Throwable $th) {

            if (static::$isBackupCreated) {

                /*
                    la question que j'ai pas trouvé encore de réponse c'est que si par exemple meme la restoration n'est pas aussi réussi. est ce que je fais un autre block catch !!
                */
                BackupService::makeImagesRestoration("products", static::$product->id);
            }

            $message = [
                "type" => "danger",
                "text" => "Modification du produit a échoué",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return back()->with("message", $message);
        }
    }

    //------------------------------------------------------------------------------------------------------------------------------------

    //! -----------------------------------------------------------------------------------------------------------------------------------


    //! PUBLIC Functions-------------------------------------------------------------------------------------------------------------------

    public static function start(Product $product, ProductRequest $product_request): RedirectResponse
    {

        static::$product = $product;
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

        $modificationsMadeOn_FunctionResult = static::modificationsMadeOn();

        return static::makeUpdate($modificationsMadeOn_FunctionResult);
    }

    //! -----------------------------------------------------------------------------------------------------------------------------------
}
