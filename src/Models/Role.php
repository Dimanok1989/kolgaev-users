<?php

namespace Kolgaev\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kolgaev\Users\Users;

class Role extends Model
{
    use HasFactory;

    /**
     * Role owned permissions
     * 
     * @return \App\Models\Role
     */
    public function permissions()
    {

        return $this->belongsToMany(
            Users::$permissionModel,
            Users::pivot('role_permission.name', 'role_permission'),
            Users::pivot('role_permission.role_id', 'role_id'),
            Users::pivot('role_permission.permission_id', 'permission_id')
        );

    }

    /**
     * Role related users
     * 
     * @return \App\Models\User
     */
    public function users()
    {

        return $this->belongsToMany(
            config('auth.providers.users.model', \App\Models\User::class),
            Users::pivot('role_user.name', 'role_user'),
            Users::pivot('role_user.role_id', 'role_id'),
            Users::pivot('role_user.user_id', 'user_id')
        );

    }

    /**
     * Removing a role from a role
     * 
     * @param int $id   Permission ID
     * @return $this
     */
    public function addPermission($id)
    {

        if (!$this->permissions()->where('id', $id)->count())
            $this->permissions()->attach($id);

        return $this;

    }

    /**
     * Removing a right from a role
     * 
     * @param int $id   Permission ID
     * @return $this
     */
    public function removePermission($id)
    {

        if ($this->permissions()->where('id', $id)->count())
            $this->permissions()->detach($id);

        return $this;

    }

}