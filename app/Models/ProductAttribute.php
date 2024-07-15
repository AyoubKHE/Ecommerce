<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = "productsattributes";

    public $timestamps = false;

    protected $fillable = [
        "name", "description"
    ];

    public function options() {
        return $this->hasMany(ProductAttributeOption::class, "productAttribute_id", "id");
    }

}
