<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = "orderStatuses";

    public $timestamps = false;

    protected $fillable = [
        "status", "description"
    ];

    // public function items() {
    //     return $this->hasMany(CartItem::class, "cart_id", "id");
    // }
}
