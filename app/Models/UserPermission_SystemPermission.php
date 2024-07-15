<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission_SystemPermission extends Model
{
    use HasFactory;

    protected $table = "usersPermissions_systemPermissions";

    public $timestamps = false;

    protected $fillable = [
        "userPermission_id",
        "systemPermission_id",
        "value",
    ];

    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('userPermission_id', $this->getAttribute('userPermission_id'))
            ->where('systemPermission_id', $this->getAttribute('systemPermission_id'));
        return $query;
    }
}
