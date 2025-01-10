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
        Schema::create('forum_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Назва теми форума');
            $table->unsignedBigInteger('forum_sub_category_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('forum_sub_category_id')->references('id')->on('forum_sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_topics', function (Blueprint $table) {
            $table->dropForeign(['forum_sub_category_id']);
        });

        Schema::dropIfExists('forum_topics');
    }
};
