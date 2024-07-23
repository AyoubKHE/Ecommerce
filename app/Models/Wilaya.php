<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    use HasFactory;

    protected $table = "wilayas";

    public $timestamps = false;

    protected $fillable = [
        "code", "name"
    ];

    // public function items() {
    //     return $this->hasMany(CartItem::class, "cart_id", "id");
    // }
}
