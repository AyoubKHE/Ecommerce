<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $table = "productsVariations";

    // public $timestamps = false;

    protected $fillable = [
        "price", "quantity_in_stock", "is_active", "image_path", "product_id"
    ];

    public function attributes_options_pivot() {
        return $this->hasMany(ProductVariation_AttributeOption::class, "productVariation_id", "id");
    }

    public function options() {
        return $this->belongsToMany(ProductAttributeOption::class, "productsVariations_attributesOptions", "productVariation_id", "productAttributeOption_id", "id", "id");
    }

    public function attributes() {
        return $this->belongsToMany(ProductAttribute::class, "productsVariations_attributesOptions", "productVariation_id", "productAttribute_id", "id", "id");
    }

}
