<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $table = "usersPermissions";

    public $timestamps = false;

    protected $fillable = [
        "user_id"
    ];

    public function systemPermissions() {
        return $this->belongsToMany(SystemPermission::class, "usersPermissions_systemPermissions", "userPermission_id", "systemPermission_id", "id", "id");
    }

    public function systemPermissionsPivot()
    {
        return $this->hasMany(UserPermission_SystemPermission::class, "userPermission_id", "id");
    }

}
