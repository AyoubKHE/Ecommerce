<?php

namespace App\Http\Controllers\Web\ProductsAttributes\helpers;

use Illuminate\Support\Str;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductAttributeOption;
use App\Http\Requests\ProductAttributeRequest;

class enModificationsMadeOn
{
    const nothing_changed = 0;
    const attribute = 1;
    const attribute_options = 2;
    const all_changed = 3;
}

class updateProductAttribute
{

    private static ProductAttribute $products_attribute;
    private static ProductAttributeRequest $products_attribute_request;
    private static array $product_attribute_form_fields;

    private static array $attribute_options = [];

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    // More validation of data -----------------------------------------------------------------------------------------------------------

    private static function moreValidations(): bool|RedirectResponse
    {

        $attribute_options_names = [];

        foreach (static::$products_attribute_request->input() as $input => $value) {
            if (strpos($input, 'option_') !== false && $value !== null) {
                array_push($attribute_options_names, Str::lower($value));
            }
        }

        if (count($attribute_options_names) > count(array_unique($attribute_options_names))) {
            $message = [
                "type" => "warning",
                "text" => "Des valuers en double ont été détectées."
            ];
            return back()->with("message", $message);
        }

        return true;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------


    // Preparing data for update -----------------------------------------------------------------------------------------------------------

    private static function preparingProductAttribute(): void
    {
        $original_data = static::$products_attribute->getOriginal();

        foreach (static::$product_attribute_form_fields as $key => $value) {

            if (array_key_exists($key, $original_data)) {

                if ($value === null || $value == $original_data[$key]) {

                    unset(static::$product_attribute_form_fields[$key]);
                }
            }
        }
    }


    private static function preparingAttributeOptions(): void
    {
        static::$attribute_options["original_options"] = static::$products_attribute->options->all();

        static::$attribute_options["new_options"] = [];

        $original_options_count = count(static::$attribute_options["original_options"]);

        foreach (static::$products_attribute_request->input() as $input => $value) {
            if (strpos($input, 'option_') !== false) {

                $option_number = (int)explode("_", $input)[1];

                if ($option_number <= $original_options_count) {

                    $original_option = Str::lower(static::$attribute_options["original_options"][$option_number - 1]->value);
                    $input_option = Str::lower($value);

                    if ($original_option !== $input_option) {

                        static::$attribute_options["original_options"][$option_number - 1]->value = $value;
                    } else {

                        unset(static::$attribute_options["original_options"][$option_number - 1]);
                    }
                } else {

                    if($value !== null) {
                        array_push(static::$attribute_options["new_options"], $value);
                    }
                }
            }
        }

        if (count(static::$attribute_options["new_options"]) === 0) {
            unset(static::$attribute_options["new_options"]);
        }

        if (count(static::$attribute_options["original_options"]) === 0) {
            unset(static::$attribute_options["original_options"]);
        }
    }


    private static function preparingData()
    {
        static::preparingProductAttribute();

        static::preparingAttributeOptions();
    }

    //--------------------------------------------------------------------------------------------------------------------------------------


    // Verfiying if user made any changes --------------------------------------------------------------------------------------------------


    private static function isProductAttributeChanged(): bool
    {
        return count(static::$product_attribute_form_fields) !== 0;
    }


    private static function isAttributeOptionsChanged(): bool
    {
        return isset(static::$attribute_options["original_options"]) ||
            isset(static::$attribute_options["new_options"]);
    }


    private static function modificationsMadeOn(): int
    {
        $is_attribute_changed = static::isProductAttributeChanged();

        $is_attribute_options_changed = static::isAttributeOptionsChanged();


        if (!$is_attribute_changed && !$is_attribute_options_changed) {
            return enModificationsMadeOn::nothing_changed;
        } elseif ($is_attribute_changed && !$is_attribute_options_changed) {
            return enModificationsMadeOn::attribute;
        } elseif (!$is_attribute_changed && $is_attribute_options_changed) {
            return enModificationsMadeOn::attribute_options;
        } else {
            return enModificationsMadeOn::all_changed;
        }
    }

    //--------------------------------------------------------------------------------------------------------------------------------------

    // Performing updates ------------------------------------------------------------------------------------------------------------------

    private static function updateAttribute(): void
    {
        if (!static::$products_attribute->update(static::$product_attribute_form_fields)) {
            throw new \Exception("échec de mis à jour l'enregistrement dans la table 'productsAttributes'");
        }
    }


    private static function manageUpdatedOptions(): void
    {
        if (isset(static::$attribute_options["original_options"])) {
            foreach (static::$attribute_options["original_options"] as $original_option) {
                if (!$original_option->save()) {
                    throw new \Exception("échec de mise à jour dans la table 'productsAttributesOptions'");
                }
            }
        }
    }
    private static function manageNewOptions(): void
    {
        if (isset(static::$attribute_options["new_options"])) {
            foreach (static::$attribute_options["new_options"] as $new_option) {
                if (!ProductAttributeOption::create([
                    "value" => $new_option,
                    "productAttribute_id" => static::$products_attribute->id
                ])) {
                    throw new \Exception("échec de la création de l'enregistrement dans la table 'productsAttributesOptions'");
                }
            }
        }
    }
    private static function updateAttributeOptions(): void
    {
        static::manageUpdatedOptions();

        static::manageNewOptions();
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
                case enModificationsMadeOn::attribute:

                    DB::transaction(function () {
                        static::updateAttribute();
                    });

                    break;

                case enModificationsMadeOn::attribute_options:
                    DB::transaction(function () {
                        static::updateAttributeOptions();
                    });

                    break;

                case enModificationsMadeOn::all_changed:

                    DB::transaction(function () {;
                        static::updateAttribute();
                        static::updateAttributeOptions();
                    });

                    break;
            }

            $message = [
                "type" => "success",
                "text" => "Attribut bien modifiée"
            ];
        } catch (\Throwable $th) {

            $message = [
                "type" => "danger",
                "text" => "Modification du l'attribut a échoué",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return back()->with("message", $message);
        }
    }

    //--------------------------------------------------------------------------------------------------------------------------------------

    //! ------------------------------------------------------------------------------------------------------------------------------------



    //! PUBLIC Functions--------------------------------------------------------------------------------------------------------------------

    public static function start(ProductAttributeRequest $products_attribute_request, ProductAttribute $products_attribute): RedirectResponse
    {
        static::$products_attribute_request = $products_attribute_request;

        static::$products_attribute = $products_attribute;

        static::$product_attribute_form_fields = $products_attribute_request->validated();

        $moreValidations_FunctionResult = static::moreValidations();

        if ($moreValidations_FunctionResult instanceof RedirectResponse) {
            return $moreValidations_FunctionResult;
        }

        static::preparingData();

        $modificationsMadeOn_FunctionResult = static::modificationsMadeOn();

        // dd($modificationsMadeOn_FunctionResult);


        return static::makeUpdate($modificationsMadeOn_FunctionResult);
    }

    //! ------------------------------------------------------------------------------------------------------------------------------------
}
