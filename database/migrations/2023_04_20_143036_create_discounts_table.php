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
            $table->unsignedBigInteger('order')->default(999);
            $table->dateTime('enddate');
            $table->unsignedBigInteger('percent')->default(0);
            $table->unsignedBigInteger('article')->default(0);
            $table->unsignedBigInteger('actual')->default(0);
            $table->boolean('active')->unsigned()->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
