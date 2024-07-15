<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeOption extends Model
{
    use HasFactory;

    protected $table = "productsattributesoptions";

    public $timestamps = false;

    protected $hidden = ['pivot'];

    protected $fillable = [
        "value", "productAttribute_id"
    ];

    public function productAttribute() {
        return $this->belongsTo(ProductAttribute::class, "productAttribute_id", "id");
    }

    public function variations() {
        return $this->belongsToMany(ProductVariation::class, "productsVariations_attributesOptions", "productAttributeOption_id", "productVariation_id", "id", "id");
    }
}
