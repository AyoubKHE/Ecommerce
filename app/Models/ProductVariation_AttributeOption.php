<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation_AttributeOption extends Model
{
    use HasFactory;

    protected $table = "productsVariations_attributesOptions";

    public $timestamps = false;

    protected $fillable = [
        "productVariation_id",
        "productAttribute_id",
        "productAttributeOption_id",
    ];

    protected $hidden = [
        "productVariation_id",
        "productAttribute_id",
        "productAttributeOption_id",
    ];

    public function attribute() {
        return $this->belongsTo(ProductAttribute::class, "productAttribute_id", "id");
    }

    public function option() {
        return $this->belongsTo(ProductAttributeOption::class, "productAttributeOption_id", "id");
    }

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('productVariation_id', $this->getAttribute('productVariation_id'))
            ->where('productAttribute_id', $this->getAttribute('productAttribute_id'))
            ->where('productAttributeOption_id', $this->getAttribute('productAttributeOption_id'));
        return $query;
    }
}
