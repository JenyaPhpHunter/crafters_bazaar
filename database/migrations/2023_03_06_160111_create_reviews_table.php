<?php

use App\Constants\OthersConstants;
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
            $table->unsignedInteger('product_id')->comment("Id товару");
            $table->unsignedInteger('user_id')->comment("Id користувача");
            $table->enum('rating', array_keys(OthersConstants::RATING))->nullable()->comment("рейтинг товару");
            $table->softDeletes();
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
