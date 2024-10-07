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
            $table->string('type')->comment('Тип діалогу');
            $table->string('comment')->comment('Коментар');
            $table->unsignedBigInteger('product_id')->comment('Id товару');
            $table->unsignedBigInteger('answer_to')->nullable()->comment('Відповідь на діалог Id'); // Тип поля answer_to тепер nullable
            $table->decimal('queue', 15, 10);
            $table->unsignedBigInteger('user_id')->comment('Id користувача');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('answer_to')->references('id')->on('dialogs')->onDelete('set null'); // Затриманий зовнішній ключ
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
