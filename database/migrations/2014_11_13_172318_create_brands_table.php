<?php

use App\Constants\OthersConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->comment("Назва бренду");
            $table->text('content')->nullable()->default(null)->comment("Коментар до бренду");
            $table->string('image_path')->nullable()->default(null)->comment("Шлях до картинки бренду");
            $table->unsignedBigInteger('creator_id')->comment("Id користувача, який створив запис");
            $table->unsignedTinyInteger('rating_avg')->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign(['creator_id']);
        });

        Schema::dropIfExists('brands');
    }
};
