<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "address", "commune_id"
    ];

    public function commune() {
        return $this->belongsTo(Commune::class, "commune_id", "id");
    }

    // public function people() {
    //     return $this->belongsToMany(User::class, "users_addresse", "address_id", "user_id");
    // }
}
