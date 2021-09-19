<?php

namespace Kolgaev\Users\Models;

use Kolgaev\Users\Users;

trait UsersRoleAndPermission
{

    /**
     * Roles owned by the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {

        return $this->belongsToMany(
            Users::$roleModel,
            Users::pivot('role_user.name', 'role_user'),
            Users::pivot('role_user.user_id', 'user_id'),
            Users::pivot('role_user.role_id', 'role_id')
        );

    }

    /**
     * Permissions owned by the user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {

        return $this->belongsToMany(
            Users::$permissionModel,
            Users::pivot('user_permission.name', 'user_permission'),
            Users::pivot('user_permission.user_id', 'user_id'),
            Users::pivot('user_permission.permission_id', 'permission_id')
        );

    }

    /**
     * Checking a user's permission through his roles and personal permissions
     * 
     * @return bool
     */
    public function hasPermit(...$permissions)
    {

        if ($this->permissions()->whereIn('permission', $permissions)->count())
            return true;

        foreach ($this->roles as $role) {
            if ($role->permissions()->whereIn('permission', $permissions)->count())
                return true;
        }

        return false;

    }

    /**
     * All permissions user
     * 
     * @return array
     */
    public function getAllPermissions()
    {

        $permissions = $this->permissions->pluck('permission')->toArray();

        foreach ($this->roles as $role) {

            foreach ($role->permissions()->whereNotIn('permission', $permissions)->get() as $row)
                $permissions[] = $row->permission;

        }

        return array_unique($permissions, SORT_STRING);

    }

    /**
     * Adding a role to a user
     * 
     * @param int $id   Идентификатор роли
     * @return $this
     */
    public function addRole($id)
    {

        if (!$this->roles()->where('id', $id)->count())
            $this->roles()->attach($id);

        return $this;

    }

    /**
     * Удаление роли у пользователю
     * 
     * @param int $id   Role ID
     * @return $this
     */
    public function removeRole($id)
    {

        if ($this->roles()->where('id', $id)->count())
            $this->roles()->detach($id);

        return $this;

    }

    /**
     * Removing a role from a user
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
     * Removing a right from a user
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