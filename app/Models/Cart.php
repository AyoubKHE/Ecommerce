<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";

    protected $fillable = [
        "session_id", "items_count", "total_price"
    ];

    public function items() {
        return $this->hasMany(CartItem::class, "cart_id", "id");
    }
}
