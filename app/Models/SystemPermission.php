<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemPermission extends Model
{
    use HasFactory;

    protected $table = "systemPermissions";

    public $timestamps = false;

    protected $fillable = [
        "name"
    ];

    public function usersPermissions() {
        return $this->belongsToMany(UserPermission::class, "usersPermissions_systemPermissions", "systemPermission_id", "userPermission_id", "id", "id");
    }

}
