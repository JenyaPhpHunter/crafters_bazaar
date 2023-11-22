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
            $table->string('filename');
            $table->string('ext',4);
            $table->string('path');
            $table->string('link');
            $table->integer('queue');
            $table->string('hover_filename')->default('');
            $table->string('hover_ext',4)->default('');
            $table->string('hover_path')->default('');
            $table->string('zoom_filename')->default('');
            $table->string('zoom_ext',4)->default('');
            $table->string('zoom_path')->default('');
            $table->string('small_filename')->default('');
            $table->string('small_ext',4)->default('');
            $table->string('small_path')->default('');
            $table->unsignedBigInteger('product_id');
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
