<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment("Назва доставки");
//            $table->integer('price');
            $table->boolean('del')->unsigned()->default(0);
            $table->timestamps();
        });
        DB::table('deliveries')->insert([
            ['name' => 'Самовивіз з Нової Пошти'],
            ['name' => 'Адресна доставка'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
