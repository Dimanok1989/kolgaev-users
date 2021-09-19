<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create(config('tables.role_user.name', 'role_user'), function (Blueprint $table) {
            
            $table->unsignedBigInteger(config('tables.role_user.user_id', 'user_id'));
            $table->unsignedBigInteger(config('tables.role_user.role_id', 'role_id'));

            $table->foreign(config('tables.role_user.user_id', 'user_id'))
                ->references('id')
                ->on('users');

            $table->foreign(config('tables.role_user.role_id', 'role_id'))
                ->references('id')
                ->on(config('tables.roles.name', 'roles'));

            $table->unique(
                config('tables.role_user.user_id', 'user_id'),
                config('tables.role_user.role_id', 'role_id')
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
        Schema::dropIfExists(config('tables.role_user.name', 'role_user'));
    }
}
