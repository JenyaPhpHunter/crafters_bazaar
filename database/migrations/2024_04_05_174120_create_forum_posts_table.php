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
            $table->string('content')->comment('Контент поста');
            $table->unsignedInteger('forum_topic_id')->comment('Id теми форума');
            $table->unsignedInteger('user_id')->comment('Id користувача');
            $table->unsignedInteger('answer_to')->nullable()->comment('Відповідь на пост Id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('forum_topic_id')->references('id')->on('forum_topics')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('answer_to')->references('id')->on('forum_posts')->onDelete('set null'); // Затриманий зовнішній ключ
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
