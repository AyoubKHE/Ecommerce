<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        "first_name", "last_name", "username", "email", "password", "phone",
        "birth_date", "image_path", "is_active", "role", "added_by", "last_login", "email_verified_at",
    ];

    public function products()
    {
        return $this->hasMany(Product::class, "added_by", "id");
    }

    public function productsCategories()
    {
        return $this->hasMany(ProductCategory::class, "added_by", "id");
    }

    public function productsImages()
    {
        return $this->hasManyThrough(ProductImage::class, Product::class, "added_by", "product_id");
    }

    public function addresses() {
        return $this->belongsToMany(Address::class, "users_addresse", "user_id", "address_id");
    }

    public function addedBy() {
        return $this->belongsTo(User::class, "added_by", "id");
    }

    public function permission()
    {
        return $this->hasOne(UserPermission::class, "user_id", "id");
    }
}
