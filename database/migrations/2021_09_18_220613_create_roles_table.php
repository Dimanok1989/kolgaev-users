<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('tables.roles.name', 'roles'), function (Blueprint $table) {
            $table->id();
            $table->string('role')->unique()->comment("Наименование роли");
            $table->string('comment', 255)->nullable()->comment("Короткий комментарий");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('tables.roles.name', 'roles'));
    }
}
