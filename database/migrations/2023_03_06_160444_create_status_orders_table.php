<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_orders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment("Назва статусу замовлення");
            $table->timestamps();
        });
        DB::table('status_orders')->insert([
            ['title' => 'Нове'],
            ['title' => 'Затверджене'],
            ['title' => 'Відправлене'],
            ['title' => 'Доставлене'],
            ['title' => 'Отримане'],
            ['title' => 'Виконане'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_orders');
    }
}
