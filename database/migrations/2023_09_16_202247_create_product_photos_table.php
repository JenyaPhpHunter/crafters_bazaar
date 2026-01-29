<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('product_photos');

        Schema::create('product_photos', function (Blueprint $table) {
            $table->id()
                ->comment('ID фото товару');

            $table->foreignId('product_id')
                ->comment('ID товару')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->unsignedInteger('queue')
                ->default(1)
                ->comment('Порядок фото (1 — головне, далі по черзі)');

            $table->boolean('is_main')
                ->default(false)
                ->comment('Чи є фото головним');

            $table->string('base', 36)
                ->comment('Базове імʼя файлу (UUID без розширення)');

            $table->string('ext', 10)
                ->comment('Розширення файлу (jpg, png, webp тощо)');

            $table->json('paths')
                ->comment('JSON з шляхами до файлів різних розмірів: original'
                    . ' {"original":"...","small":"...","zoom":"..."}');

            $table->timestamps();

            $table->softDeletes()
                ->comment('Дата мʼякого видалення');

            $table->unique(['product_id', 'queue'], 'product_photos_product_queue_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_photos');
    }
};
