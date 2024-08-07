<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = "orderItems";

    protected $fillable = [
        "order_id", "productVariation_id", "quantity", "price"
    ];

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('order_id', $this->getAttribute('order_id'))
            ->where('productVariation_id', $this->getAttribute('productVariation_id'));
        return $query;
    }
}
