<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "description", "is_active", "price", "added_by", "brand_id"
    ];

    protected $hidden = [
        'pivot',
    ];

    public function images() {
        return $this->hasMany(ProductImage::class, "product_id", "id");
    }

    public function variations() {
        return $this->hasMany(ProductVariation::class, "product_id", "id");
    }

    public function categories() {
        return $this->belongsToMany(ProductCategory::class, "productscategories_products", "product_id", "productcategory_id", "id", "id")->withPivot("is_active");
    }

    public function categoriesPivot() {
        return $this->hasMany(ProductCategory_Product::class, "product_id", "id");
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, "brand_id", "id"); // ownerKey => id of userroles are the owners
    }

    public function addedBy() {
        return $this->belongsTo(User::class, "added_by", "id");
    }
}
