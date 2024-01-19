<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('name');
            $table->string('php_name');
            $table->string('code');
            $table->timestamps();
        });
        DB::table('colors')->insert([
            ['name' => 'Чорний', 'php_name' => 'Black', 'code' => '#000000'],
            ['name' => 'Білий', 'php_name' => 'White', 'code' => '#ffffff'],
            ['name' => 'Червоний', 'php_name' => 'Red',  'code' => '#ff0000'],
            ['name' => 'Зелений', 'php_name' => 'Green',  'code' => '#00ff00'],
            ['name' => 'Синій', 'php_name' => 'Blue',  'code' => '#0000ff'],
            ['name' => 'Жовтий', 'php_name' => 'Yellow',  'code' => '#ffff00'],
            ['name' => 'Фіолетовий', 'php_name' => 'Violet',  'code' => '#ff00ff'],
            ['name' => 'Помаранчевий', 'php_name' => 'Orange',  'code' => '#ffa500'],
            ['name' => 'Темно-зелений', 'php_name' => 'Dark_green',  'code' => '#008000'],
            ['name' => 'Пурпурний', 'php_name' => 'Purple',  'code' => '#800080'],
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
