<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('comment')->comment("Коментар");
            $table->unsignedBigInteger('product_id')->comment("Id товару");
            $table->unsignedBigInteger('user_id')->comment("Id користувача");
            $table->enum('rating', ['1', '2', '3', '4', '5'])->nullable()->comment("рейтинг");
            $table->boolean('del')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('reviews');
    }
}
