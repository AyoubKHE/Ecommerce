<?php

namespace App\Services\SubCategories;

use stdClass;
use App\Models\ProductCategory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\SubCategories\Products\SubCategoriesAllProducts;
use App\Services\SubCategories\Products\SubCategoriesActiveProducts;
use App\Services\SubCategories\Brands\SubCategoriesActiveProductsBrands;
use App\Services\SubCategories\ProductsCount\SubCategoriesAllProductsCount;
use App\Services\SubCategories\ProductsCount\SubCategoriesActiveProductsCount;
use App\Services\SubCategories\Attributes\SubCategoriesActiveProductsAttributes;
use App\Services\SubCategories\ProductsPrice\SubCategoriesActiveProductsMinMaxPrice;

class SubCategoriesService
{
    //! SUB CATEGORIES -------------------------------------------------------------------------------------------------------------------

    public static function getSubCategoriesListForSpecificCategory(int $product_category_id): array
    {
        $sub_categories = DB::select(
            "
            WITH RECURSIVE subcategories AS(
                SELECT
                    pc.id,
                    pc.name,
                    pc.parent_id
                FROM
                    productscategories pc
                WHERE
                    pc.parent_id = ?

                UNION ALL

                SELECT
                    pc2.id,
                    pc2.name,
                    pc2.parent_id
                FROM
                    productscategories pc2
                INNER JOIN subcategories sc ON
                    pc2.parent_id = sc.id
            )
            SELECT
                *
            FROM
                subcategories
        ",
            [$product_category_id]
        );

        return $sub_categories;
    }

    public static function getSubCategoriesCountForSpecificCategory(int $product_category_id): int
    {
        return count(static::getSubCategoriesListForSpecificCategory($product_category_id));
    }

    public static function getSubCategoriesCountForAllActiveCategories(): Collection
    {
        $subCategoriesCounts = collect();

        foreach (ProductCategory::where("is_active", 1)->get()->toArray() as $key => $product_category) {
            $subCategoriesCounts->push(static::getSubCategoriesCountForSpecificCategory($product_category["id"]));
        }

        return $subCategoriesCounts;
    }

    public static function isLeafCategory(int $product_category_id)
    {
        return ProductCategory::find($product_category_id)->is_leaf_category ?? null;
    }

    //! PRODUCTS -------------------------------------------------------------------------------------------------------------------------

    public static function getAllProductsListForSpecificCategory(int $product_category_id)
    {
        return SubCategoriesAllProducts::getProductsFor($product_category_id);
    }

    public static function getProductsCountForSpecificCategory(int $product_category_id)
    {
        return SubCategoriesAllProductsCount::getProductsCountFor($product_category_id);
    }

    public static function getAllProductsCountForActiveCategories(): Collection
    {
        $productsCounts = collect();

        foreach (ProductCategory::where("is_active", 1)->get()->toArray() as $key => $product_category) {
            $productsCounts->push(static::getProductsCountForSpecificCategory($product_category["id"]));
        }

        return $productsCounts;
    }



    //!ACTIVE PRODUCTS -------------------------------------------------------------------------------------------------------------------

    public static function getActiveProductsListForSpecificCategory(int $product_category_id, int $skip, int $take)
    {
        return SubCategoriesActiveProducts::getProductsFor($product_category_id, $skip, $take);
    }

    public static function getActiveProductsCountForSpecificCategory(int $product_category_id)
    {
        return SubCategoriesActiveProductsCount::getProductsCountFor($product_category_id);
    }

    public static function getActiveProductsCountForActiveCategories(): Collection
    {
        $activeProductsCounts = collect();

        foreach (ProductCategory::where("is_active", 1)->get()->toArray() as $key => $product_category) {
            $activeProductsCounts->push(static::getActiveProductsCountForSpecificCategory($product_category["id"]));
        }

        return $activeProductsCounts;
    }

    public static function getActiveProductsBrandsListForSpecificCategory(int $product_category_id)
    {
        return SubCategoriesActiveProductsBrands::getBrandsFor($product_category_id);
    }

    public static function getActiveProductsAttributesListForSpecificCategory(int $product_category_id)
    {
        return SubCategoriesActiveProductsAttributes::getAttributesFor($product_category_id);
    }

    public static function getActiveProductsMinMaxPricesForSpecificCategory(int $product_category_id)
    {
        return SubCategoriesActiveProductsMinMaxPrice::getProductsPriceFor($product_category_id);
    }
}
