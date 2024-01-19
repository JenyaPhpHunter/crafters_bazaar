<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('delivery_id');
            $table->unsignedBigInteger('kind_payment_id');
            $table->integer('card')->nullable();
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('city_id');
            $table->string('address', 255);
            $table->unsignedBigInteger('newpost_id')->nullable();
            $table->integer('promocode')->nullable();
            $table->decimal('pricedelivery', 12, 2)->nullable();
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('cart_id');
            $table->decimal('sum_order',12,2);
            $table->unsignedBigInteger('status_order_id');
            $table->boolean('active')->unsigned()->default(1);
            $table->boolean('del')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('kind_payment_id')->references('id')->on('kind_payments');
            $table->foreign('newpost_id')->references('id')->on('newposts');
            $table->foreign('status_order_id')->references('id')->on('status_orders');
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['kind_payment_id']);
            $table->dropForeign(['newpost_id']);
            $table->dropForeign(['status_order_id']);
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['region_id']);
            $table->dropForeign(['city_id']);
        });
        Schema::dropIfExists('orders');
    }
}
