<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $table = "communes";

    public $timestamps = false;

    protected $fillable = [
        "postal_code", "name", "wilaya_id"
    ];

    public function wilaya() {
        return $this->belongsTo(Wilaya::class, "wilaya_id", "id");
    }
}
