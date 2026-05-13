<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();

            $table->string('title')->comment('Назва акції, наприклад "Весняний розпродаж"');
            $table->text('description')->nullable()->comment('Короткий опис під банером');

            // Зображення
            $table->string('image_path')->nullable()->comment('Шлях до банера у storage/public');

            // Де показувати
            $table->boolean('show_in_header')->default(false)->comment('Показувати у верхньому банері сайту');
            $table->boolean('show_on_homepage')->default(false)->comment('Показувати на головній сторінці');

            // Порядок відображення (менше = вище)
            $table->unsignedInteger('sort_order')->default(999)->comment('Порядок сортування банерів');

            // Посилання при кліку на банер
            $table->string('url')->nullable()->comment('URL куди веде банер, може бути внутрішнім або зовнішнім');

            // Активність та термін
            $table->boolean('active')->default(true);
            $table->dateTime('starts_at')->nullable()->comment('Дата початку показу банера');
            $table->dateTime('ends_at')->nullable()->comment('Дата закінчення показу банера');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
