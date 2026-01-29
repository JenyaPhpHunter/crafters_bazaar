<?php

use App\Models\StatusProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Назва товару');
            $table->unsignedInteger('price')->comment('Ціна');
            $table->foreignId('sub_kind_product_id')
                ->comment('Підвид товару')
                ->constrained('sub_kind_products')
                ->restrictOnDelete();
            $table->unsignedInteger('stock_balance')->default(0);
            $table->unsignedInteger('term_creation')->nullable();
            $table->foreignId('brand_id')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();
            $table->text('content')->nullable()->comment('Опис товару');
            $table->string('tags')->nullable()->comment('Теги товару');
            $table->text('social_links')->nullable()->comment('Посилання на соцмережі');
            $table->text('additional_information')
                ->nullable()
                ->comment('Додаткова інформація');
            $table->foreignId('status_product_id')
                ->default(StatusProduct::NEW)
                ->constrained('status_products')
                ->restrictOnDelete();
            $table->foreignId('creator_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('date_put_up_for_sale')->nullable();
            $table->timestamp('date_approve_sale')->nullable();
            $table->unsignedTinyInteger('rating_avg')
                ->default(0)
                ->comment('Середній рейтинг × 10 (наприклад 45 = 4.5)');
            $table->unsignedInteger('rating_count')
                ->default(0)
                ->comment('Кількість оцінок');
            $table->boolean('featured')->default(false);
//            $table->unsignedInteger('discount')->default(0)->comment('Знижка');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('products');
        Schema::enableForeignKeyConstraints();
    }
};
