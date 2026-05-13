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
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique()->comment('Сам промокод який вводить користувач, наприклад SPRING20');

            // Тип знижки за промокодом
            $table->string('type', 20)->comment('percent | fixed — відсоток або фіксована сума');
            $table->unsignedInteger('percent')->nullable()->comment('Знижка у відсотках якщо type=percent');
            $table->unsignedBigInteger('fixed_amount')->nullable()->comment('Знижка в копійках якщо type=fixed');

            // Обмеження використання
            $table->unsignedInteger('usage_limit')->nullable()->comment('Максимальна кількість використань, null = необмежено');
            $table->unsignedInteger('usage_count')->default(0)->comment('Скільки разів вже використано');
            $table->unsignedInteger('usage_limit_per_user')->nullable()->comment('Скільки разів один користувач може використати');

            // Мінімальна сума замовлення для застосування
            $table->unsignedBigInteger('min_order_amount')->nullable()->comment('Мінімальна сума замовлення в копійках для активації промокоду');

            // Активність та термін
            $table->boolean('active')->default(true);
            $table->dateTime('starts_at')->nullable()->comment('Дата початку дії промокоду');
            $table->dateTime('ends_at')->nullable()->comment('Дата закінчення дії промокоду');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
