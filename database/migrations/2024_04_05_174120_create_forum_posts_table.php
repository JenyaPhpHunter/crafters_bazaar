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
            $table->unsignedBigInteger('forum_topic_id')->comment('Id теми форума');
            $table->unsignedBigInteger('creator_id')->comment("Id користувача, який створив запис");
            $table->unsignedBigInteger('answer_to')->nullable()->comment('Відповідь на пост Id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('forum_topic_id')->references('id')->on('forum_topics')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users');
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
            $table->dropForeign(['creator_id']);
        });

        Schema::dropIfExists('forum_posts');
    }
};
