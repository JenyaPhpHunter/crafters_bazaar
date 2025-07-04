<?php

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
        Schema::create('brand_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->foreignId('invited_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('accepted_at')->nullable();
            $table->unsignedInteger('resent_count')->default(0); // 👈 для обліку повторних запрошень
            $table->timestamp('last_sent_at')->nullable();       // 👈 коли востаннє надіслано
            $table->timestamps();

            $table->unique(['brand_id', 'email']); // дозволяє 1 запис на email у бренді
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_invitations');
    }
};
