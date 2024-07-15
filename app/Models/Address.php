<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "unit_number", "street_number", "address_line1", "address_line2", "city", "region", "postal_code", "country_id"
    ];

    public function country() {
        return $this->belongsTo(Country::class, "country_id", "id");
    }

    public function people() {
        return $this->belongsToMany(User::class, "users_addresse", "address_id", "user_id");
    }
}
