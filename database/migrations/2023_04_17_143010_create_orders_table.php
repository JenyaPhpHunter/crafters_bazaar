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
            $table->string('email', 255);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('phone', 255);
            $table->unsignedBigInteger('delivery_id');
            $table->unsignedBigInteger('kind_payment_id');
            $table->foreign('kind_payment_id')->references('id')->on('kind_payments');
            $table->integer('card')->nullable();
            $table->string('city', 255);
            $table->string('address', 255);
            $table->unsignedBigInteger('newposts_id')->nullable();
            $table->foreign('newposts_id')->references('id')->on('newposts');
            $table->integer('promocode')->nullable();
            $table->decimal('pricedelivery', 12, 2)->nullable();
            $table->decimal('discounttotal', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->text('comment')->nullable();
            $table->unsignedBigInteger('status_order_id');
            $table->foreign('status_order_id')->references('id')->on('status_orders');
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['kind_payment_id']);
            $table->dropForeign(['status_order_id']);
        });
        Schema::dropIfExists('orders');
    }
}
