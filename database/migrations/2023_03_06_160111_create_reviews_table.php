<?php

use App\Constants\OthersConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // 🔗 Товар, який оцінюють
            $table->foreignId('product_id')
                ->comment('Товар')
                ->constrained('products')
                ->cascadeOnDelete();
            // ⬆️ якщо товар видалено — відгуки більше не потрібні

            // 👤 Користувач, який поставив оцінку
            $table->foreignId('user_id')
                ->comment('Користувач')
                ->constrained('users')
                ->cascadeOnDelete();
            // ⬆️ користувач видалений → його оцінка теж зникає (ЛОГІЧНО)

            // ⭐ Оцінка 1–5
            $table->unsignedTinyInteger('rating')
                ->comment('Оцінка (1–5)');

            // 💬 Коментар
            $table->text('comment')
                ->nullable()
                ->comment('Відгук користувача');

            $table->timestamps();

            // 🚫 Один користувач — одна оцінка на товар
            $table->unique(['product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
