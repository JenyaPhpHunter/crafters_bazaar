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
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->unsignedBigInteger('forum_topic_id');
            $table->foreign('forum_topic_id')->references('id')->on('forum_topics')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('answer_to')->nullable(); // Тип поля answer_to тепер nullable
            $table->foreign('answer_to')->references('id')->on('forum_posts')->onDelete('set null'); // Затриманий зовнішній ключ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropForeign(['forum_topic_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('forum_posts');
    }
};
