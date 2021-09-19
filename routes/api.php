<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Kolgaev Users Routes
|--------------------------------------------------------------------------
*/

Route::prefix(config('kolgaev_users.prefix', 'api'))->middleware('api')->group(function() {

    /** New user registration */
    Route::post('registration', '\Kolgaev\Users\Authorization@registration');

    /** User authorization and token issuance */
    Route::post('login', '\Kolgaev\Users\Authorization@login');

    /** Authorized User Routing */
    Route::middleware('auth:sanctum')->group(function() {

        /** User logout and token revocation */
        Route::post('logout', '\Kolgaev\Users\Authorization@logout');

        /** User data */
        Route::post('userdata', '\Kolgaev\Users\Authorization@user');

    });

});
