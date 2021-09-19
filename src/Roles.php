<?php

namespace Kolgaev\Users;

use Illuminate\Http\Request;

class Roles
{

    /**
     * Adding a role to a user
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function addRole(Request $request)
    {

        if (!method_exists($request->user(), "addRole"))
            return response(['message' => "Method not defined. Add trait [\Kolgaev\Users\Models\UsersRoleAndPermission] to the user model"], 500);

        if (!$user = Users::getUserModel($request->id))
            return response()->json(['message' => "User not found"], 400);

        if (Users::getRoleModel()->find($request->id))
            return response()->json(['message' => "Role not found"], 400);

        $user->addRole($request->role_id);

        return response()->json([
            'message' => "Role added to user",
        ]);

    }

    
    /**
     * Role removing to user
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function removeRole(Request $request)
    {

        if (!method_exists($request->user(), "removeRole"))
            return response(['message' => "Method not defined. Add trait [\Kolgaev\Users\Models\UsersRoleAndPermission] to the user model"], 500);

        if (!$user = Users::getUserModel($request->id))
            return response()->json(['message' => "User not found"], 400);

        if (Users::getRoleModel()->find($request->role_id))
            return response()->json(['message' => "Role not found"], 400);

        $user->removeRole($request->role_id);

        return response()->json([
            'message' => "Role removed to user",
        ]);

    }

    /**
     * Adding permission for a role
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function addPermission(Request $request)
    {

        if ($role = Users::getRoleModel()->find($request->id))
            return response()->json(['message' => "Role not found"], 400);

        if (!Users::getPermissionModel()->find($request->permission_id))
            return response()->json(['message' => "Permission not found"], 400);

        $role->addPermission($request->permission_id);

        return response()->json([
            'message' => "Permission added to role",
        ]);

    }

    
    /**
     * Removing permission for a role
     * 
     * @param \Illuminate\Http\Request $request
     * @return response
     */
    public static function removePermission(Request $request)
    {

        if ($role = Users::getRoleModel()->find($request->id))
            return response()->json(['message' => "Role not found"], 400);

        if (!Users::getPermissionModel()->find($request->permission_id))
            return response()->json(['message' => "Permission not found"], 400);

        $role->removePermission($request->permission_id);

        return response()->json([
            'message' => "Permission removed to role",
        ]);

    }

}