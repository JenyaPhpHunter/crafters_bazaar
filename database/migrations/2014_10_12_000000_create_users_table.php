<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            $table->string('email')->comment("Email");
            $table->string('password')->comment("Пароль");
            $table->string('surname')->nullable()->comment("Прізвище");
            $table->string('name')->nullable()->comment("Ім'я");
            $table->string('secondname')->nullable()->comment("По-батькові");
            $table->string('phone')->nullable()->comment("телефон");
            $table->unsignedBigInteger('role_id')->default(7)->comment("Id ролі користувача");
            $table->string('gender')->nullable()->comment("Стать користувача");
            $table->date('birthday')->nullable()->comment("День народження");
            $table->unsignedBigInteger('region_id')->nullable()->comment("Id області");
            $table->unsignedBigInteger('city_id')->nullable()->comment("Id міста");
            $table->string('address')->nullable()->comment("Адреса");
            $table->unsignedBigInteger('delivery_id')->nullable()->comment("Id виду доставки");
            $table->unsignedBigInteger('newpost_id')->nullable()->comment("Id НП");
            $table->unsignedBigInteger('kind_payment_id')->nullable()->comment("Id виду оплати");
            $table->boolean('is_subscribed')->default(1)->comment('Чи підписаний на новини');
            $table->boolean('active')->unsigned()->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('region_id')->references('id')->on('regions');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->foreign('newpost_id')->references('id')->on('newposts');
            $table->foreign('kind_payment_id')->references('id')->on('kind_payments');
        });
        DB::table('users')->insert([
            [
                'email' => 'jenyaphphunter@gmail.com',
                'password' => Hash::make(env('APP_KEY')),
                'name' => 'Admin',
                'surname' => 'Super',
                'secondname' => null,
                'phone' => null,
                'role_id' => 1,
                'gender' => null,
                'birthday' => null,
                'region_id' => null,
                'city_id' => null,
                'address' => null,
                'delivery_id' => null,
                'newpost_id' => null,
                'kind_payment_id' => null,
                'is_subscribed' => 1,
                'active' => 1,
                'email_verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'email' => 'bulic2012@gmail.com',
                'password' => Hash::make('12345678'),
                'name' => 'Євгеній',
                'surname' => 'Рибалкін',
                'secondname' => null,
                'phone' => '0673291419',
                'role_id' => 1,
                'gender' => null,
                'birthday' => null,
                'region_id' => null,
                'city_id' => null,
                'address' => null,
                'delivery_id' => null,
                'newpost_id' => null,
                'kind_payment_id' => null,
                'is_subscribed' => 1,
                'active' => 1,
                'email_verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'email' => 'Chmyk_Vika@ukr.net',
                'password' => Hash::make('12345678'),
                'name' => 'Вікторія',
                'surname' => 'Рибалкіна',
                'secondname' => null,
                'phone' => '0971129869',
                'role_id' => 4,
                'gender' => null,
                'birthday' => null,
                'region_id' => null,
                'city_id' => null,
                'address' => null,
                'delivery_id' => null,
                'newpost_id' => null,
                'kind_payment_id' => null,
                'is_subscribed' => 1,
                'active' => 1,
                'email_verified_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
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
            $table->dropForeign(['region_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['newpost_id']);
            $table->dropForeign(['delivery_id']);
            $table->dropForeign(['kind_payment_id']);
        });

        Schema::dropIfExists('users');
    }

}
