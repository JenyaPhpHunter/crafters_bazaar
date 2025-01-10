<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment("Назва кольору");
            $table->string('php_name')->comment("Назва кольору на англійській мові");
            $table->string('code')->comment("Код кольору");
            $table->timestamps();
        });
        DB::table('colors')->insert([
            ['title' => 'Чорний', 'php_name' => 'Black', 'code' => '#000000'],
            ['title' => 'Білий', 'php_name' => 'White', 'code' => '#ffffff'],
            ['title' => 'Червоний', 'php_name' => 'Red',  'code' => '#ff0000'],
            ['title' => 'Зелений', 'php_name' => 'Green',  'code' => '#00ff00'],
            ['title' => 'Синій', 'php_name' => 'Blue',  'code' => '#0000ff'],
            ['title' => 'Жовтий', 'php_name' => 'Yellow',  'code' => '#ffff00'],
            ['title' => 'Фіолетовий', 'php_name' => 'Violet',  'code' => '#ff00ff'],
            ['title' => 'Помаранчевий', 'php_name' => 'Orange',  'code' => '#ffa500'],
            ['title' => 'Темно-зелений', 'php_name' => 'Dark_green',  'code' => '#008000'],
            ['title' => 'Пурпурний', 'php_name' => 'Purple',  'code' => '#800080'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colors');
    }
};
