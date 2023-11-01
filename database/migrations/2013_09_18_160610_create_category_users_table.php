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
            $table->string('name');
            $table->boolean('del')->unsigned()->default(0);
            $table->timestamps();
        });
        DB::table('category_users')->insert([
            ['name' => 'Користувач'],
            ['name' => 'Продавець'],
            ['name' => 'Покупець'],
            ['name' => 'Співробітник'],
            ['name' => 'SEO'],
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
