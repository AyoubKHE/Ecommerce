<?php

namespace App\Http\Controllers\Web\ProductsAttributes;


use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use App\Models\ProductAttributeOption;
use App\Http\Requests\ProductAttributeRequest;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Web\ProductsAttributes\helpers\storeProductAttribute;
use App\Http\Controllers\Web\ProductsAttributes\helpers\updateProductAttribute;

class ProductAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data["productsAttributesData"] = ProductAttribute::addSelect(
            [
                "options" => ProductAttributeOption::select(DB::raw("GROUP_CONCAT(productsAttributesOptions.value SEPARATOR ', ')"))
                    ->whereColumn('productsAttributesOptions.productAttribute_id', 'productsAttributes.id')
            ]
        )->paginate(5);

        return view("dashboard.productsAttributes.index", compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.productsAttributes.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductAttributeRequest $products_attribute_request)
    {
        return storeProductAttribute::start($products_attribute_request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductAttribute $products_attribute)
    {
        $data['productAttributeData'] = ProductAttribute::where('id', $products_attribute->id)->first();

        $data["attributeOptions"] = ProductAttributeOption::where('productAttribute_id', $products_attribute->id)->get();

        return view("dashboard.productsAttributes.edit", compact("data"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductAttributeRequest $products_attribute_request, ProductAttribute $products_attribute)
    {
        return updateProductAttribute::start($products_attribute_request, $products_attribute);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductAttribute $products_attribute)
    {

        try {
            DB::transaction(function () use ($products_attribute) {

                $attribute_options = $products_attribute->options;

                foreach ($attribute_options as $option) {
                    if (!$option->delete()) {
                        throw new \Exception("échec de supprimer l enregistrement dans la table 'productsAttributesOptions'");
                    }
                }

                if (!$products_attribute->delete()) {
                    throw new \Exception("échec de supprimer l enregistrement dans la table 'productsAttributes'");
                }
            });

            $message = [
                "type" => "success",
                "text" => "Produit bien supprimée"
            ];
        } catch (\Exception $th) {

            if (explode(":", $th->getMessage())[0] === "SQLSTATE[23000]") {
                $text = "suppression du l attribut a échoué. Il se peut que vous utiliser cet attribut dans l un de vos produit";
            } else {
                $text = "suppression du l attribut a échoué";
            }

            $message = [
                "type" => "danger",
                "text" => $text,
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return to_route("products-attributes.index")->with("message", $message);
        }
    }
}
