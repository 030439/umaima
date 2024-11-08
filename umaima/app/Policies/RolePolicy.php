<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function view(User $user, Role $role)
    {
        return $user->hasPermissionTo('role_read');
    }

    // Check if user can create a Role
    public function create(User $user)
    {
        return $user->hasPermissionTo('role_create');
    }

    // Check if user can update a Role
    public function update(User $user, Role $role)
    {
        return $user->hasPermissionTo('role_write');
    }

    // Check if user can delete a Role
    public function delete(User $user, Role $role)
    {
        return $user->hasPermissionTo('role_delete');
    }
}
