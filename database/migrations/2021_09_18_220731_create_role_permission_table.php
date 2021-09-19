<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('tables.role_permission.name', 'role_permission'), function (Blueprint $table) {
            
            $table->unsignedBigInteger(config('tables.role_permission.role_id', 'role_id'));
            $table->unsignedBigInteger(config('tables.role_permission.permission_id', 'permission_id'));

            $table->foreign(config('tables.role_permission.role_id', 'role_id'))
                ->references('id')
                ->on(config('tables.roles.name', 'roles'));

            $table->foreign(config('tables.role_permission.permission_id', 'permission_id'))
                ->references('id')
                ->on(config('tables.permissions.name', 'permissions'));

            $table->unique(
                config('tables.role_permission.role_id', 'role_id'),
                config('tables.role_permission.permission_id', 'permission_id')
            );
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('tables.role_permission.name', 'role_permission'));
    }
}
