<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = "shippingMethods";

    public $timestamps = false;

    protected $fillable = [
        "name", "description", "price"
    ];

    // public function items() {
    //     return $this->hasMany(CartItem::class, "cart_id", "id");
    // }
}
