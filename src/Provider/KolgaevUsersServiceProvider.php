<?php

namespace Kolgaev\Users\Provider;

use Illuminate\Support\ServiceProvider;
use Kolgaev\Users\Users;
use Kolgaev\Users\Models\Role;
use Kolgaev\Users\Models\Permission;

class KolgaevUsersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if (!app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../../config/kolgaev_users.php', 'kolgaev_users');
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->publishes([
            __DIR__ . '/../../config/kolgaev_users.php' => config_path('kolgaev_users.php'),
        ]);

        $role = config('kolgaev_users.roles', Role::class);
        Users::setRoleModel($role);

        $permission = config('kolgaev_users.permissions', Permission::class);
        Users::setPermissionModel($permission);

        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

    }

}