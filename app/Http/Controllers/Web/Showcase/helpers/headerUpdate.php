<?php

namespace App\Http\Controllers\Web\Showcase\helpers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class headerUpdate
{
    private static Request $request;

    private static array $modified_categories = [];

    private static function moreValidations(): bool|RedirectResponse
    {
        $hidden_categories_count = 0;

        foreach (static::$request["product_categories"] as $product_category_id => $show_category) {

            if ($show_category == 0) {
                $hidden_categories_count++;
            }

            $product_category = ProductCategory::find($product_category_id);

            // if ($product_category->products->count() < 0 && $show_category == 1) {
            //     $message = [
            //         "type" => "warning",
            //         "text" => "Afin d offrir une expérience utilisateur optimale,
            //         les catégories contenant moins de 5 produits ne sont pas affichées dans l en-tête du site web.
            //         La catégorie " . $product_category->name . " en fait partie."
            //     ];
            //     return back()->with("message", $message);
            // }

            if ($product_category->show_on_website_header != $show_category) {
                array_push(static::$modified_categories, $product_category);
            }
        }

        if ($hidden_categories_count === count(static::$request["product_categories"])) {
            $message = [
                "type" => "warning",
                "text" => "Vous avez caché toutes les catégories !!!"
            ];
            return back()->with("message", $message);
        }

        if (count(static::$modified_categories) === 0) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez rien modifié !!!"
            ];
            return back()->with("message", $message);
        }

        return true;
    }



    public static function start(Request $request): RedirectResponse
    {
        static::$request = $request;

        $moreValidations_FunctionResult = static::moreValidations();

        if ($moreValidations_FunctionResult instanceof RedirectResponse) {
            return $moreValidations_FunctionResult;
        }

        try {

            DB::transaction(function () use ($request) {

                foreach (static::$modified_categories as $modified_category) {

                    $modified_category->update(["show_on_website_header" => $modified_category->show_on_website_header == 1 ? 0 : 1]);
                }
            });

            $message = [
                "type" => "success",
                "text" => "les modification ont été bien appliqué."
            ];
        } catch (\Exception $th) {

            $message = [
                "type" => "danger",
                "text" => "les modification n'ont pas été appliqué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return back()->with("message", $message);
        }
    }
}
