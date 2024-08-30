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
            $table->string('name')->comment("Назва категорії користвача");
            $table->boolean('del')->unsigned()->default(0);
            $table->timestamps();
        });
        DB::table('category_users')->insert([
            ['name' => 'SEO'],
            ['name' => 'Співробітник'],
            ['name' => 'Продавець'],
            ['name' => 'Покупець'],
            ['name' => 'Користувач'],
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
