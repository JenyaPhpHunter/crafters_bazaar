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

            // Тип знижки: 'product' | 'category'
            $table->string('type', 20);

            // Прив'язка — або товар, або категорія (sub_kind_product)
            // Заповнюється тільки одне з двох
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('sub_kind_product_id')->nullable()->constrained('sub_kind_products')->nullOnDelete();

            // Розмір знижки: або відсоток, або фіксована сума в копійках
            $table->unsignedInteger('percent')->nullable()->comment('Знижка у відсотках, наприклад 20 = 20%');
            $table->unsignedBigInteger('fixed_amount')->nullable()->comment('Знижка фіксованою сумою в копійках, наприклад 5000 = 50 грн');

            // Активність та термін дії
            $table->boolean('active')->default(true);
            $table->dateTime('starts_at')->nullable()->comment('Коли знижка починає діяти, null = одразу');
            $table->dateTime('ends_at')->nullable()->comment('Коли знижка закінчується, null = безстрокова');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discounts');
    }
}
