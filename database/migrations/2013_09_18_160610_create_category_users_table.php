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
        Schema::create('category_users', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment("Назва категорії користвача");
            $table->timestamps();
        });
        DB::table('category_users')->insert([
            ['title' => 'SEO'],
            ['title' => 'Співробітник'],
            ['title' => 'Продавець'],
            ['title' => 'Покупець'],
            ['title' => 'Користувач'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_users');
    }
};
