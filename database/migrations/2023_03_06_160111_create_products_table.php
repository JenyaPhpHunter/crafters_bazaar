<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedBigInteger('kind_product_id');
            $table->text('content');
            $table->integer('price');
            $table->string('image_path')->nullable();
            $table->integer('stock_balance')->nullable()->default(null);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('kind_product_id')->references('id')->on('kind_products');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['kind_product_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('products');
    }
}
