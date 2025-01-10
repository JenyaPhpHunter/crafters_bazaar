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
            $table->string('title', 255)->nullable()->default(null)->comment("Назва товару");
            $table->unsignedBigInteger('sub_kind_product_id')->nullable()->default(null)->comment("Id підвиду товару");
            $table->text('content')->nullable()->default(null)->comment("Коментар до товару");
            $table->text('links_networks')->nullable()->default(null)->comment("Посилання на товар");
            $table->unsignedBigInteger('price')->nullable()->default(null)->comment("Вартість");
            $table->unsignedBigInteger('discount')->nullable()->default(null)->comment("Знижка");
            $table->unsignedBigInteger('stock_balance')->nullable()->default(1)->comment("Залишок на складі");
            $table->unsignedBigInteger('color_id')->nullable()->comment("Id кольору");
            $table->unsignedBigInteger('term_creation')->nullable()->default(null)->comment("строк виготовлення");
            $table->unsignedBigInteger('status_product_id')->default(1)->comment("Статус товару");
            $table->unsignedBigInteger('user_id')->comment("Id користувача");
            $table->boolean('new')->unsigned()->default(1)->comment("Новий");
            $table->boolean('featured')->unsigned()->default(0)->comment("Рекомендований");
            $table->boolean('active')->unsigned()->default(1);
            $table->dateTime('date_put_up_for_sale')->nullable()->comment("Дата виставлення на продаж");
            $table->dateTime('date_approve_sale')->nullable()->comment("Дата початку продажу");
            $table->unsignedBigInteger('admin_id')->unsigned()->nullable()->comment("Id затверджуючого товар");
            $table->text('additional_information')->nullable()->default(null)->comment("Додаткова інформація");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sub_kind_product_id')->references('id')->on('sub_kind_products');
            $table->foreign('color_id')->references('id')->on('colors');
            $table->foreign('status_product_id')->references('id')->on('status_products');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('admin_id')->references('id')->on('users');
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
            $table->dropForeign(['sub_kind_product_id']);
            $table->dropForeign(['color_id']);
            $table->dropForeign(['status_product_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['admin_id']);
        });
        Schema::dropIfExists('products');
    }
}
