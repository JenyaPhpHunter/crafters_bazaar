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
//        Schema::create('cities', function (Blueprint $table) {
//            $table->id();
//            $table->string('name')->comment("Назва міста");
//            $table->string('index')->comment("індекс");
//            $table->unsignedBigInteger('region_id')->nullable()->comment("Id області");
//            $table->string('latitude')->comment("широта");
//            $table->string('longitude')->comment("довгота");
//            $table->string('warehouse')->comment("наявність НП");
//            $table->timestamps();
//
//            $table->foreign('region_id')->references('id')->on('regions');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('cities', function (Blueprint $table) {
//            $table->dropForeign(['region_id']);
//        });
//
//        Schema::dropIfExists('cities');
    }
};
