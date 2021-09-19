<?php

namespace Kolgaev\Users;

use Illuminate\Http\Request;

class Users
{

    /**
     * Role Model
     * 
     * @var string
     */
    public static $roleModel = \Kolgaev\Users\Models\Role::class;

    /**
     * Permission Model
     * 
     * @var string
     */
    public static $permissionModel = \Kolgaev\Users\Models\Permission::class;

    /**
     * Set Role Model
     * 
     * @param string
     * @return null
     */
    public static function setRoleModel($model)
    {

        self::$roleModel = $model;

        return null;

    }

    /**
     * Set Permission Model
     * 
     * @param string
     * @return null
     */
    public static function setPermissionModel($model)
    {

        self::$permissionModel = $model;

        return null;

    }

    /**
     * Get Role Model
     * 
     * @return $roleModel
     */
    public static function getRoleModel()
    {

        return new self::$roleModel;

    }

    /**
     * Get Permission Model
     * 
     * @return $permissionModel
     */
    public static function getPermissionModel()
    {

        return new self::$permissionModel;

    }

    /**
     * Get User Model
     * 
     * @return $permissionModel
     */
    public static function getUserModel()
    {

        $model = config('auth.providers.users.model', \App\Models\User::class);

        return new $model;

    }

    /**
     * Get setting pivot tables
     * 
     * @param string $option Path config key
     * @param string $default Default value
     * @return string
     */
    public static function pivot($option = "", $default = null)
    {

        $params[] = "kolgaev_users.tables.{$option}";

        if ($default)
            $params[] = $default;

        return config(...$params);

    }

    /**
     * Adding permission for a user
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function addPermission(Request $request)
    {

        if ($user = self::getUserModel()->find($request->id))
            return response()->json(['message' => "User not found"], 400);

        if (!self::getPermissionModel()->find($request->permission_id))
            return response()->json(['message' => "Permission not found"], 400);

        $user->addPermission($request->permission_id);

        return response()->json([
            'message' => "Permission added to user",
        ]);

    }

    
    /**
     * Removing permission for a user
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function removePermission(Request $request)
    {

        if ($user = self::getRoleModel()->find($request->id))
            return response()->json(['message' => "Role not found"], 400);

        if (!self::getPermissionModel()->find($request->permission_id))
            return response()->json(['message' => "Permission not found"], 400);

        $user->removePermission($request->permission_id);

        return response()->json([
            'message' => "Permission removed to user",
        ]);

    }

}