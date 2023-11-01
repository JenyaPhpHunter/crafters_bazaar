<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('del')->unsigned()->default(0);
            $table->timestamps();
        });
        DB::table('roles')->insert([
            ['name' => 'Супер Адмін'],
            ['name' => 'Адміністратор'],
            ['name' => 'Начальник'],
            ['name' => 'Продавець'],
            ['name' => 'Віп користувач'],
            ['name' => 'Зареєстрований користувач'],
            ['name' => 'Не зареєстрований користувач'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
