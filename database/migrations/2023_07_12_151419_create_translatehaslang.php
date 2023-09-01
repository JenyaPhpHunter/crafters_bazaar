<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslatehaslang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translatehaslang', function (Blueprint $table) {
            $table->id();
            $table->string('value', 255);
            $table->unsignedBigInteger('translate_id');
            $table->unsignedBigInteger('language_id');
            $table->timestamps();

            $table->foreign('translate_id')->references('id')->on('translate');
            $table->foreign('language_id')->references('id')->on('language');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translatehaslang');
    }
}
