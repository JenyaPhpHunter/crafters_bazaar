<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishItemsTable extends Migration
{
    public function up()
    {
        Schema::create('wish_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment("Id користувача");
            $table->unsignedBigInteger('product_id')->comment("Id товару");
            $table->decimal('price')->comment("Вартість");
            $table->boolean('active')->unsigned()->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    public function down()
    {
        Schema::table('wish_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('wish_items');
    }


}
