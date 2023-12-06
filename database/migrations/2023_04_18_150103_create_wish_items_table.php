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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->decimal('price');
            $table->boolean('active')->unsigned()->default(1);
            $table->boolean('del')->unsigned()->default(0);
            $table->timestamps();
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
