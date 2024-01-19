<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newposts', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('name'); // Додано визначення типу для поля name
            $table->string('address'); // Додано визначення типу для поля address
            $table->string('category_warehouse');
            $table->unsignedBigInteger('city_id'); // Змінено на unsignedBigInteger
            $table->unsignedBigInteger('region_id'); // Змінено на unsignedBigInteger
            $table->timestamps();

            // Додаємо зовнішні ключі для city_id та region_id
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('newposts', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropForeign(['city_id']);
        });
        Schema::dropIfExists('newposts');
    }
}
