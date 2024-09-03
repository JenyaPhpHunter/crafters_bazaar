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
            $table->unsignedInteger('order')->default(999);
            $table->dateTime('enddate');
            $table->unsignedInteger('percent')->default(0);
            $table->unsignedInteger('article')->default(0);
            $table->unsignedInteger('actual')->default(0);
            $table->boolean('active')->unsigned()->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
