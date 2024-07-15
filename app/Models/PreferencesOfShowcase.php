<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferencesOfShowcase extends Model
{
    use HasFactory;

    protected $table = "preferences_of_showcase";

    protected $fillable = [
        "header", "body", "footer"
    ];

    public $timestamps = false;
}
