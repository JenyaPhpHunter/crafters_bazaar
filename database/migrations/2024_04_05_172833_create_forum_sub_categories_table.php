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
        Schema::create('forum_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Назва підкатегорії форума');
            $table->unsignedBigInteger('forum_category_id')->comment('Id категорії форума');
            $table->unsignedBigInteger('creator_id')->comment("Id користувача, який створив запис");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('forum_category_id')->references('id')->on('forum_categories')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('forum_sub_categories', function (Blueprint $table) {
            $table->dropForeign(['forum_category_id']);
            $table->dropForeign(['creator_id']);
        });

        Schema::dropIfExists('forum_sub_categories');
    }
};
