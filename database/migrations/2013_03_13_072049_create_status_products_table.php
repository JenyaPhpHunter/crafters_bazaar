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
            $table->string('title')->comment("Назва статусу товару");
            $table->timestamps();
        });
        DB::table('status_products')->insert([
            ['title' => 'Новий'],
            ['title' => 'На затверджені'],
            ['title' => 'В продажу'],
            ['title' => 'Проданий'],
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
