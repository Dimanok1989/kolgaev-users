<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | You can define your own models for all rights and role tables.
    | Place in the appropriate variable the model class
    |
    */

    /** Roles Model class */
    'roles' => Kolgaev\Users\Models\Role::class,

    /** Permissions Model class */
    'permissions' => Kolgaev\Users\Models\Permission::class,

    /*
    |--------------------------------------------------------------------------
    | Pivot tables
    |--------------------------------------------------------------------------
    |
    | You can also change the names of the linking tables and their columns
    |
    */

    'tables' => [

        'role_user' => [
            'name' => "role_user",
            'role_id' => "role_id",
            'user_id' => "user_id",
        ],

        'role_permission' => [
            'name' => "role_permission",
            'role_id' => "role_id",
            'permission_id' => "permission_id",
        ],

        'user_permission' => [
            'name' => "user_permission",
            'user_id' => "user_id",
            'permission_id' => "permission_id",
        ],

        'roles' => [
            'name' => "roles",
        ],

        'permissions' => [
            'name' => "permissions",
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Route pefix
    |--------------------------------------------------------------------------
    |
    | Prefix authorization routes
    |
    */

    'prefix' => 'api',

];