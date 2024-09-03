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
            $table->unsignedInteger('cart_id')->comment("Id корзини");
            $table->unsignedInteger('product_id')->comment("Id товару");
            $table->unsignedInteger('quantity')->comment("Кількість");
            $table->decimal('price')->comment("Вартість");
            $table->decimal('pricediscount')->nullable()->comment("Знижка");
            $table->boolean('active')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
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
