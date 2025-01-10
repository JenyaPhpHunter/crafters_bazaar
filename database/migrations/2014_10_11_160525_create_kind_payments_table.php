<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKindPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kind_payments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment("Назва виду оплати");
            $table->string('comment')->comment("Коментар до оплати");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::table('kind_payments')->insert([
            ['title' => 'Оплатити зараз', 'comment' => 'Якщо Вам не сподобається товар, то ми повернемо Вам гроші.'],
            ['title' => 'Оплата під час отримання товару', 'comment' => 'Поштовий оператор візьме додаткову комісію за накладений платіж.'],
            ['title' => 'Безготівковий для фізичних осіб', 'comment' => 'Оплата для фізичних осіб через розрахунковий рахунок.'],
            ['title' => 'Безготівковими для юридичних осіб', 'comment' => 'Оплата для юридичних осіб через розрахунковий рахунок'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kind_payments');
    }
}
