<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('tables.permissions.name', 'permissions'), function (Blueprint $table) {
            $table->id();
            $table->string('permission')->unique()->comment("Наименование разрешения");
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
        Schema::dropIfExists(config('tables.permissions.name', 'permissions'));
    }
}
