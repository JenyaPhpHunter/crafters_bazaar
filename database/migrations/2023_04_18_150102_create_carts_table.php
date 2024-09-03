<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->comment("Id користувача");
            $table->decimal('sum')->nullable()->comment("сума");
            $table->decimal('pricediscount')->nullable()->comment("знижка");
            $table->decimal('total')->nullable()->comment("загалом");
            $table->boolean('active')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('carts');
    }


}
