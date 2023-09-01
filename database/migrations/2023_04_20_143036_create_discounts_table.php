<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('pict', 4);
            $table->boolean('headershow')->default(0);
            $table->integer('order')->default(999);
            $table->dateTime('enddate');
            $table->integer('percent')->default(0);
            $table->integer('article')->default(0);
            $table->integer('actual')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
