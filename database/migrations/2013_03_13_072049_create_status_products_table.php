<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStatusProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment("Назва статусу товару");
            $table->timestamps();
        });
        DB::table('status_products')->insert([
            ['name' => 'Новий'],
            ['name' => 'На затверджені'],
            ['name' => 'В продажу'],
            ['name' => 'Проданий'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_products');
    }
}
