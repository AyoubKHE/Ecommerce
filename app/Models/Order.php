<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        "user_id", "shippingMethod_id", "address_id", "orderStatus_id", "items_count", "total_price", "more_details"
    ];

    // public function items() {
    //     return $this->hasMany(CartItem::class, "cart_id", "id");
    // }
}
