<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandUserTable extends Migration
{
    public function up()
    {
        Schema::create('brand_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('brand_id')->comment("ID бренду");
            $table->unsignedBigInteger('user_id')->comment("ID користувача");

            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['brand_id', 'user_id']); // щоб унікальне поєднання
        });
    }

    public function down()
    {
        Schema::dropIfExists('brand_user');
    }
}
