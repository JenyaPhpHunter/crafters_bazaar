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
            $table->string('name', 255)->nullable()->default(null);
            $table->unsignedBigInteger('kind_product_id')->nullable()->default(null);
            $table->unsignedBigInteger('sub_kind_product_id')->nullable()->default(null);
            $table->text('content')->nullable()->default(null);
            $table->text('links_networks')->nullable()->default(null);
            $table->bigInteger('price')->nullable()->default(null);
            $table->integer('discount')->nullable()->default(null);
            $table->integer('stock_balance')->nullable()->default(1);
            $table->unsignedBigInteger('size_id')->nullable();
            $table->unsignedBigInteger('color_id')->nullable();
            $table->unsignedBigInteger('status_product_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('new')->unsigned()->default(1);
            $table->boolean('featured')->unsigned()->default(0);
            $table->boolean('active')->unsigned()->default(1);
            $table->boolean('del')->unsigned()->default(0);
            $table->dateTime('date_start')->nullable();
            $table->unsignedBigInteger('admin_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('kind_product_id')->references('id')->on('kind_products');
            $table->foreign('sub_kind_product_id')->references('id')->on('sub_kind_products');
            $table->foreign('size_id')->references('id')->on('sizes');
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
            $table->dropForeign(['kind_product_id']);
            $table->dropForeign(['sub_kind_product_id']);
            $table->dropForeign(['size_id']);
            $table->dropForeign(['color_id']);
            $table->dropForeign(['status_product_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['admin_id']);
        });
        Schema::dropIfExists('products');
    }
}
