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
        Schema::create('product_photos', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->comment("Назва файлу");
            $table->string('ext',4)->comment("Розширення");
            $table->string('path')->comment("Шлях до файлу");
            $table->string('link')->comment("Посилання");
            $table->integer('queue')->comment("Черга");
            $table->string('hover_filename')->default('')->comment("Назва файлу при наведенні");
            $table->string('hover_ext',4)->default('')->comment("Розширення при наведенні");
            $table->string('hover_path')->default('')->comment("Шлях до файлу при наведенні");
            $table->string('zoom_filename')->default('')->comment("Назва файлу при збільшенні");
            $table->string('zoom_ext',4)->default('')->comment("Розширення при збільшенні");
            $table->string('zoom_path')->default('')->comment("Шлях до файлу при збільшенні");
            $table->string('small_filename')->default('')->comment("Назва маленького файлу");
            $table->string('small_ext',4)->default('')->comment("Розширення маленького файлу");
            $table->string('small_path')->default('')->comment("Шлях до маленького файлу");
            $table->unsignedBigInteger('product_id')->comment('Id товару');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_photos', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        Schema::dropIfExists('product_photos');
    }
};
