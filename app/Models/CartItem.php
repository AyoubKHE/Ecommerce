<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = "cartsItems";

    protected $fillable = [
        "cart_id", "productVariation_id", "quantity", "price"
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, "cart_id", "id");
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, "productVariation_id", "id");
    }

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('cart_id', $this->getAttribute('cart_id'))
            ->where('productVariation_id', $this->getAttribute('productVariation_id'));
        return $query;
    }
}
