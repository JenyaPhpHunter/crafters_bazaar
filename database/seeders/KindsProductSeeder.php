<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KindsProductSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ===== Види товарів =====
        DB::table('kind_products')->insert([
            [
                'id' => 1,
                'title' => 'Сумки',
                'user_id' => 1,
                'checked' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'title' => 'Авто',
                'user_id' => 1,
                'checked' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // ===== Підвиди товарів =====
        DB::table('sub_kind_products')->insert([
            [
                'title' => 'Жіночі сумки',
                'kind_product_id' => 1,
                'user_id' => 1,
                'checked' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Чоловічі сумки',
                'kind_product_id' => 1,
                'user_id' => 1,
                'checked' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Причіп',
                'kind_product_id' => 2,
                'user_id' => 1,
                'checked' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
