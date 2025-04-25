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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment("Тип населенного пункту");
            $table->string('title')->comment("Назва населенного пункту");
            $table->string('index')->nullable()->comment("індекс");
            $table->unsignedBigInteger('region_id')->nullable()->comment("Id області");
            $table->foreign('region_id')->references('id')->on('regions');
            $table->string('latitude')->nullable()->comment("широта");
            $table->string('longitude')->nullable()->comment("довгота");
            $table->string('warehouse')->nullable()->comment("наявність НП");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
        });

        Schema::dropIfExists('cities');
    }
};
