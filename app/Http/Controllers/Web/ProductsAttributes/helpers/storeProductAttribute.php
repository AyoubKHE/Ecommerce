<?php

namespace App\Http\Controllers\Web\ProductsAttributes\helpers;

use Illuminate\Support\Str;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use App\Models\ProductAttributeOption;
use App\Http\Requests\ProductAttributeRequest;

class storeProductAttribute
{
    private static ProductAttributeRequest $products_attribute_request;
    private static array $attribute_options_names = [];

    //! PRIVATE Functions-------------------------------------------------------------------------------------------------------------------

    private static function moreValidationsAndPreparingData(): bool|RedirectResponse
    {

        foreach (static::$products_attribute_request->input() as $input => $value) {
            if (strpos($input, 'option_') !== false && $value !== null) {
                array_push(static::$attribute_options_names, Str::lower($value));
            }
        }

        if (count(static::$attribute_options_names) === 0) {
            $message = [
                "type" => "warning",
                "text" => "Il faut que l attribut possède au moins une seule valeur ou plus"
            ];
            return back()->with("message", $message);
        }

        if (count(static::$attribute_options_names) > count(array_unique(static::$attribute_options_names))) {
            $message = [
                "type" => "warning",
                "text" => "Des valeurs en double ont été détectées."
            ];
            return back()->with("message", $message);
        }

        return true;
    }



    private static function storeProductAttribute(): ProductAttribute
    {
        $productsAttribute = ProductAttribute::create(
            [
                "name" => static::$products_attribute_request->input("name"),
                "description" => static::$products_attribute_request->input("description")
            ]
        );

        if (!$productsAttribute) {
            throw new \Exception("échec de la création de l'enregistrement dans la table 'productsAttributes'");
        }

        return $productsAttribute;
    }



    private static function storeProductAttributeOptions(int $products_attribute_id): void
    {
        foreach (static::$attribute_options_names as $value) {
            if (!ProductAttributeOption::create([
                "value" => $value,
                "productAttribute_id" => $products_attribute_id
            ])) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'productsAttributesOptions'");
            }
        }
    }



    private static function makeStorage(): RedirectResponse
    {
        try {

            DB::transaction(function () {

                $productsAttribute = static::storeProductAttribute();

                static::storeProductAttributeOptions($productsAttribute->id);
            });

            $message = [
                "type" => "success",
                "text" => "l attribut est bien créé."
            ];
        } catch (\Exception $th) {

            $message = [
                "type" => "danger",
                "text" => "la création de l attribut a échoué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return to_route("products-attributes.index")->with("message", $message);
        }
    }

    //! ------------------------------------------------------------------------------------------------------------------------------------

    //! PUBLIC Functions--------------------------------------------------------------------------------------------------------------------

    public static function start(ProductAttributeRequest $products_attribute_request): RedirectResponse
    {
        static::$products_attribute_request = $products_attribute_request;

        $moreValidations_FunctionResult = static::moreValidationsAndPreparingData();

        if ($moreValidations_FunctionResult instanceof RedirectResponse) {
            return $moreValidations_FunctionResult;
        }

        return static::makeStorage();
    }

    //! ------------------------------------------------------------------------------------------------------------------------------------
}
