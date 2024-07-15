<?php

namespace App\Http\Controllers\Web\Brands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{

    public function index()
    {

        $addSelectArray = [

            'added_by_username' => User::whereColumn('users.id', 'brands.added_by')
                ->select('users.username'),

            'quantity_of_products' => Product::select(DB::raw('count(*)'))
                ->whereColumn('brand_id', 'brands.id'),
        ];

        $data['brandsData'] = Brand::addSelect($addSelectArray)->paginate(env("brandsPagination"));

        $data["filterModalData"]["usersNames"] = User::pluck("username")->all();

        $data["filterModalData"]["minCreatedAtDate"] = (new Carbon(Brand::min("created_at")))->sub("1 minute")->isoFormat("Y-MM-DD");
        $data["filterModalData"]["minCreatedAtTime"] = (new Carbon(Brand::min("created_at")))->sub("1 minute")->isoFormat("kk:mm");
        $data["filterModalData"]["maxCreatedAtDate"] = (new Carbon(Brand::max("created_at")))->add("1 minute")->isoFormat("Y-MM-DD");
        $data["filterModalData"]["maxCreatedAtTime"] = (new Carbon(Brand::max("created_at")))->add("1 minute")->isoFormat("kk:mm");
        $data["filterModalData"]["minUpdatedAtDate"] = (new Carbon(Brand::min("updated_at")))->sub("1 minute")->isoFormat("Y-MM-DD");
        $data["filterModalData"]["minUpdatedAtTime"] = (new Carbon(Brand::min("updated_at")))->sub("1 minute")->isoFormat("kk:mm");
        $data["filterModalData"]["maxUpdatedAtDate"] = (new Carbon(Brand::max("updated_at")))->add("1 minute")->isoFormat("Y-MM-DD");
        $data["filterModalData"]["maxUpdatedAtTime"] = (new Carbon(Brand::max("updated_at")))->add("1 minute")->isoFormat("kk:mm");

        $allBrands = Brand::addSelect($addSelectArray)->get();

        $data["filterModalData"]["minQuantityOfProducts"] = $allBrands->min("quantity_of_products");
        $data["filterModalData"]["maxQuantityOfProducts"] = $allBrands->max("quantity_of_products");

        return view("dashboard.brands.index", compact("data"));
    }


    public function create()
    {
        return view("dashboard.brands.create");
    }


    public function store(BrandRequest $brand_request)
    {
        $form_fields = $brand_request->validated();

        $form_fields["added_by"] = auth()->user()->id;

        try {
            if (!Brand::create($form_fields)) {
                throw new \Exception("échec de la création de l'enregistrement dans la table 'brands'");
            }

            // Si tout s'est bien passé, préparer un message de succès
            $message = [
                "type" => "success",
                "text" => "la marque est bien créé."
            ];
        } catch (\Exception $th) {

            // Préparer un message d'erreur avec les détails de l'exception
            $message = [
                "type" => "danger",
                "text" => "la création de la marque a échoué. Réessayer plus tard",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            // Retourner à la vue d'index des catégories de produits avec le message approprié
            return to_route("brands.index")->with("message", $message);
        }
    }


    public function show(Brand $brand)
    {

        $data['brandData'] = Brand::where('id', $brand->id)
            ->addSelect(
                [
                    'added_by_username' => User::whereColumn('users.id', 'brands.added_by')
                        ->select('users.username'),

                    'quantity_of_products' => Product::select(DB::raw('count(*)'))
                        ->whereColumn('brand_id', 'brands.id'),
                ]
            )->first();


        if ($data['brandData']['quantity_of_products'] === 0) {
            $data["relatedProductsData"] = collect();
        } else {

            $data["relatedProductsData"] = Product::where('brand_id', $brand->id)->addSelect(
                [

                    'added_by_username' => User::whereColumn('users.id', 'products.added_by')
                        ->select('users.username'),

                ]
            )->get();
        }

        // dd($data);

        return view("dashboard.brands.show", compact("data"));
    }


    public function edit(Brand $brand)
    {
        $data['brandData'] = Brand::where('id', $brand->id)
            ->addSelect(
                [

                    'added_by_username' => User::whereColumn('users.id', 'brands.added_by')
                        ->select('users.username'),

                ]
            )->first();

        return view("dashboard.brands.edit", compact("data"));
    }


    public function update(BrandRequest $brand_request, Brand $brand)
    {
        $form_fields = $brand_request->validated();

        $original_data = $brand->getOriginal();
        $is_brand_changed = false;

        foreach ($form_fields as $key => $value) {
            if (array_key_exists($key, $original_data)) {
                if ($value === null || $value == $original_data[$key]) {
                    unset($form_fields[$key]);
                } else {
                    $is_brand_changed = true;
                }
            }
        }

        if (!$is_brand_changed) {
            $message = [
                "type" => "warning",
                "text" => "Vous n avez rien modifié !"
            ];
            return back()->with("message", $message);
        } else {
            try {

                if (!$brand->update($form_fields)) {
                    throw new \Exception("échec de mise à jour l'enregistrement dans la table 'brands'");
                }

                if (isset($form_fields["is_active"])) {

                    $related_products = $brand->products;

                    if (count($related_products) > 0) {
                        foreach ($related_products as $related_product) {
                            if (!$related_product->update(["is_active" => $form_fields["is_active"] === "1" ? 1 : 0])) {
                                throw new \Exception("échec de mise à jour dans la table 'products'");
                            }
                        }
                    }
                }

                $message = [
                    "type" => "success",
                    "text" => "Marque bien modifiée"
                ];
            } catch (\Exception $th) {

                $message = [
                    "type" => "danger",
                    "text" => "Modification de la marque a échoué",
                    "error" => $th->getMessage(),
                    "file" => $th->getFile(),
                    "line" => $th->getLine()
                ];
            } finally {
                return back()->with("message", $message);
            }
        }
    }


    public function destroy(Brand $brand)
    {
        try {
            if (!$brand->delete()) {
                throw new \Exception("échec de supprimer l'enregistrement dans la table 'brands'");
            }

            $message = [
                "type" => "success",
                "text" => "Marque bien supprimée"
            ];
        } catch (\Exception $th) {
            $message = [
                "type" => "danger",
                "text" => "suppression de la marque a échoué",
                "error" => $th->getMessage(),
                "file" => $th->getFile(),
                "line" => $th->getLine()
            ];
        } finally {
            return to_route("brands.index")->with("message", $message);
        }
    }
}
