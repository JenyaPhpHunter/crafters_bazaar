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
            $table->enum('rating', array_keys(config('others.rating')))
                    ->nullable()
                    ->default(null)
                    ->comment("рейтинг бренду");
            $table->integer('createdby')->comment('id ким створено/оновлено');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
};
