<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SystemPermission;

class UserPolicy
{
    private $resources_names_mapping = [
        "users" => "Utilisateurs",
        "products" => "Produits",
        "productsCategories" => "Catégories des produits"
    ];

    private $abilities = [
        "nothing" => 0,
        "read" => 1,
        "create" => 2,
        "update" => 4,
        "delete" => 8,
        "all" => -1
    ];

    private int $current_user_resource_permissions_value;

    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === "customer") {
            return false;
        }

        if ($user->role === "admin") {
            return true;
        }

        $resource = $this->resources_names_mapping[explode("_", $ability)[1]];

        $resource_system_permission = SystemPermission::where("name", $resource)->first();

        if ($resource_system_permission === null) {
            return true;
        }

        $resource_system_permission_id = $resource_system_permission->id;

        $this->current_user_resource_permissions_value = $user->permission->systemPermissionsPivot->filter(function ($systemPermissionPivot) use ($resource_system_permission_id) {
            return $systemPermissionPivot->systemPermission_id === $resource_system_permission_id;
        })->first()->value;

        if ($this->current_user_resource_permissions_value === $this->abilities["all"]) {
            return true;
        }

        if ($this->current_user_resource_permissions_value === $this->abilities["nothing"]) {
            return false;
        }

        return null;
    }


    //! USERS -----------------------------------------------------------------------------------------------------------

    public function read_users(): bool
    {
        $read_ability_value = $this->abilities["read"];
        return ($this->current_user_resource_permissions_value & $read_ability_value) === $read_ability_value;
    }


    public function create_users(): bool
    {
        $create_ability_value = $this->abilities["create"];
        return ($this->current_user_resource_permissions_value & $create_ability_value) === $create_ability_value;
    }


    public function update_users(): bool
    {
        $update_ability_value = $this->abilities["update"];
        return ($this->current_user_resource_permissions_value & $update_ability_value) === $update_ability_value;
    }


    public function delete_users(): bool
    {
        $delete_ability_value = $this->abilities["delete"];
        return ($this->current_user_resource_permissions_value & $delete_ability_value) === $delete_ability_value;
    }

    //!------------------------------------------------------------------------------------------------------------------

    //! PRODUCTS --------------------------------------------------------------------------------------------------------

    public function read_products(): bool
    {
        $read_ability_value = $this->abilities["read"];
        return ($this->current_user_resource_permissions_value & $read_ability_value) === $read_ability_value;
    }


    public function create_products(): bool
    {
        $create_ability_value = $this->abilities["create"];
        return ($this->current_user_resource_permissions_value & $create_ability_value) === $create_ability_value;
    }


    public function update_products(): bool
    {
        $update_ability_value = $this->abilities["update"];
        return ($this->current_user_resource_permissions_value & $update_ability_value) === $update_ability_value;
    }


    public function delete_products(): bool
    {
        $delete_ability_value = $this->abilities["delete"];
        return ($this->current_user_resource_permissions_value & $delete_ability_value) === $delete_ability_value;
    }

    //!-----------------------------------------------------------------------------------------------------------------

    //! PRODUCTS CATEGORIES --------------------------------------------------------------------------------------------------------

    public function read_productsCategories(): bool
    {
        $read_ability_value = $this->abilities["read"];
        return ($this->current_user_resource_permissions_value & $read_ability_value) === $read_ability_value;
    }


    public function create_productsCategories(): bool
    {
        $create_ability_value = $this->abilities["create"];
        return ($this->current_user_resource_permissions_value & $create_ability_value) === $create_ability_value;
    }


    public function update_productsCategories(): bool
    {
        $update_ability_value = $this->abilities["update"];
        return ($this->current_user_resource_permissions_value & $update_ability_value) === $update_ability_value;
    }


    public function delete_productsCategories(): bool
    {
        $delete_ability_value = $this->abilities["delete"];
        return ($this->current_user_resource_permissions_value & $delete_ability_value) === $delete_ability_value;
    }

    //!-----------------------------------------------------------------------------------------------------------------
}
