<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('secondname')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('role_id')->default(7);
            $table->unsignedBigInteger('category_users_id')->default(1);
            $table->unsignedBigInteger('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->unsignedBigInteger('paymentkind_id')->nullable();
            $table->unsignedBigInteger('newpost_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('active')->unsigned()->default(1);
            $table->boolean('del')->unsigned()->default(0);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('category_users_id')->references('id')->on('category_users');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->foreign('newpost_id')->references('id')->on('newposts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['category_users_id']);
            $table->dropForeign(['region_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['newpost_id']);
            $table->dropForeign(['delivery_id']);
        });

        Schema::dropIfExists('users');
    }

}
