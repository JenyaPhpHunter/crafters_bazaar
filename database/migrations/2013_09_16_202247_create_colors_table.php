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
            $table->string('code');
            $table->timestamps();
        });
        DB::table('colors')->insert([
            ['name' => 'Чорний', 'code' => '#000000'],
            ['name' => 'Білий', 'code' => '#ffffff'],
            ['name' => 'Червоний', 'code' => '#ff0000'],
            ['name' => 'Зелений', 'code' => '#00ff00'],
            ['name' => 'Синій', 'code' => '#0000ff'],
            ['name' => 'Жовтий', 'code' => '#ffff00'],
            ['name' => 'Фіолетовий', 'code' => '#ff00ff'],
            ['name' => 'Помаранчевий', 'code' => '#ffa500'],
            ['name' => 'Темно-зелений', 'code' => '#008000'],
            ['name' => 'Пурпурний', 'code' => '#800080'],
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
