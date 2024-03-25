<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialogs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('comment');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('answer_to')->nullable(); // Тип поля answer_to тепер nullable
            $table->foreign('answer_to')->references('id')->on('dialogs')->onDelete('set null'); // Затриманий зовнішній ключ
            $table->decimal('queue', 15, 10);
            $table->unsignedBigInteger('user_id');
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
        Schema::table('dialogs', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('dialogs');
    }
};
