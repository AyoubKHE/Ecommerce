<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = "productscategories";

    protected $fillable = [
        "name", "description", "image_path", "ordering",
        "is_active", "added_by", "parent_id", "show_on_website_header", "is_leaf_category"
    ];

    protected $hidden = [
        'pivot',
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, "added_by", "id");
    }

    public function parentCategory()
    {
        return $this->belongsTo(ProductCategory::class, "parent_id", "id");
    }

    public function childCategories()
    {
        return $this->hasMany(ProductCategory::class, "parent_id", "id");
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, "productscategories_products", "productcategory_id", "product_id", "id", "id")->withPivot("is_active");
    }

    // public function productsPivot()
    // {
    //     return $this->hasMany(ProductCategory_Product::class, "productCategory_id", "id");
    // }



    // public static function tree($root)
    // {
    //     $all_categories = ProductCategory::get();

    //     $sub_categories = $all_categories->where("parent_id", $root);

    //     static::formatTree($sub_categories, $all_categories);

    //     return $sub_categories;
    // }

    // private static function formatTree($categories, $all_categories)
    // {
    //     foreach ($categories as $category) {

    //         $category->sub_categories = $all_categories->where("parent_id", $category->id);

    //         static::formatTree($category->sub_categories, $all_categories);

    //     }
    // }
}
