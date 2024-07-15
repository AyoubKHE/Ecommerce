<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "description", "is_active", "added_by"
    ];

    public function products() {
        return $this->hasMany(Product::class, "brand_id", "id");
    }

    public function addedBy() {
        return $this->belongsTo(User::class, "added_by", "id");
    }
}
