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
            $table->string('title')->comment("Назва ролі");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('roles')->insert([
            ['title' => 'Супер Адмін'],
            ['title' => 'Адміністратор'],
            ['title' => 'SEO'],
            ['title' => 'Керівник'],
            ['title' => 'Продавець'],
            ['title' => 'Співробітник'],
            ['title' => 'Віп користувач'],
            ['title' => 'Зареєстрований користувач'],
            ['title' => 'Не зареєстрований користувач'],
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
