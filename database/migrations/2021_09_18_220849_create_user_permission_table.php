<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('tables.user_permission.name', 'user_permission'), function (Blueprint $table) {

            $table->unsignedBigInteger(config('tables.user_permission.user_id', 'user_id'));
            $table->unsignedBigInteger(config('tables.user_permission.permission_id', 'permission_id'));

            $table->foreign(config('tables.user_permission.user_id', 'user_id'))
                ->references('id')
                ->on('users');

            $table->foreign(config('tables.user_permission.permission_id', 'permission_id'))
                ->references('id')
                ->on(config('tables.roles.name', 'roles'));

            $table->unique(
                config('tables.user_permission.user_id', 'user_id'),
                config('tables.user_permission.permission_id', 'permission_id')
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
        Schema::dropIfExists(config('tables.user_permission.name', 'user_permission'));
    }
}
