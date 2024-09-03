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
            $table->unsignedInteger('user_id')->comment("Id користувача");
            $table->decimal('sum_order',12,2)->comment("сума замовлення");
            $table->unsignedInteger('card')->nullable()->comment("карта"); // ??
            $table->unsignedInteger('cart_id')->comment("Id корзини");
            $table->unsignedInteger('kind_payment_id')->comment("Id виду оплати");
            $table->text('comment')->nullable()->comment("коментар замовлення");
            $table->unsignedInteger('delivery_id')->comment("Id виду доставки");
            $table->unsignedInteger('region_id')->comment("Id області");
            $table->unsignedInteger('city_id')->comment("Id міста");
            $table->string('address', 255)->comment("Адреса");
            $table->unsignedInteger('newpost_id')->nullable()->comment("Id НП");
            $table->string('promocode', 255)->nullable()->comment("Промокод");
            $table->decimal('pricedelivery', 12, 2)->nullable()->comment("Вартсіть доставки");
            $table->unsignedInteger('status_order_id')->comment("Статус замовлення");
            $table->boolean('active')->default(true);
            $table->softDeletes();
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
