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
            $table->unsignedBigInteger('number')->comment("номер НП");
            $table->string('title')->comment("назва НП");
            $table->string('address')->comment("Адреса НП");
            $table->unsignedBigInteger('city_id')->comment("Id міста");
            $table->unsignedBigInteger('region_id')->comment("Id області");
            $table->string('category_warehouse')->comment("категорія складу НП");
            $table->timestamps();
            $table->softDeletes();

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
            $table->dropForeign(['city_id']);
            $table->dropForeign(['region_id']);
        });
        Schema::dropIfExists('newposts');
    }
}
