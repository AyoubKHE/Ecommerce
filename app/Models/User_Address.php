<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Address extends Model
{
    use HasFactory;

    protected $table = "users_addresses";

    protected $fillable = [
        "user_id", "address_id", "is_default", "is_active"
    ];

    public function address() {
        return $this->belongsTo(Address::class, "address_id", "id");
    }

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('user_id', $this->getAttribute('user_id'))
            ->where('address_id', $this->getAttribute('address_id'));
        return $query;
    }
}
