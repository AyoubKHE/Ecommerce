<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class ProductCategory_Product extends Model
{
    use HasFactory;

    protected $table = "productscategories_products";

    public $timestamps = false;

    protected $fillable = [
        "product_id",
        "productCategory_id",
        "is_active"
    ];

    public function productCategoryData() {
        return $this->belongsTo(ProductCategory::class, "productCategory_id", "id");
    }

    public function productData() {
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('productCategory_id', $this->getAttribute('productCategory_id'))
            ->where('product_id', $this->getAttribute('product_id'));
        return $query;
    }
}
