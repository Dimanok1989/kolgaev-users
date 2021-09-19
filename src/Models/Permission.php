<?php

namespace Kolgaev\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kolgaev\Users\Users;

class Permission extends Model
{
    use HasFactory;

    /**
     * Roles with permission
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {

        return $this->belongsToMany(
            Users::$roleModel,
            Users::pivot('role_permission.name', 'role_permission'),
            Users::pivot('role_permission.permission_id', 'permission_id'),
            Users::pivot('role_permission.role_id', 'role_id')
        );

    }

    /**
     * Users with permission
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {

        return $this->belongsToMany(
            config('auth.providers.users.model', \App\Models\User::class),
            Users::pivot('user_permission.name', 'user_permission'),
            Users::pivot('user_permission.permission_id', 'permission_id'),
            Users::pivot('user_permission.user_id', 'user_id')
        );

    }

}
