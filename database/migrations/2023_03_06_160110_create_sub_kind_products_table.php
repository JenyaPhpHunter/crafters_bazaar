<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubKindProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_kind_products', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment("Назва підвиду товару");
            $table->unsignedBigInteger('kind_product_id')->comment("Id виду товару");
            $table->unsignedBigInteger('user_id')->comment("Id адміна");
            $table->boolean('checked')->default(true)->comment('перевірений підвид');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kind_product_id')->references('id')->on('kind_products');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_kind_products', function (Blueprint $table) {
            $table->dropForeign(['kind_product_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('sub_kind_products');
    }
}
