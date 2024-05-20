<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id')->comment("Id корзини");
            $table->unsignedBigInteger('product_id')->comment("Id товару");
            $table->integer('quantity')->comment("Кількість");
            $table->decimal('price')->comment("Вартість");
            $table->decimal('pricediscount')->nullable()->comment("Знижка");
            $table->boolean('active')->unsigned()->default(1);
            $table->boolean('del')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('cart_items');
    }


}
