<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'jenyaphphunter@gmail.com',
                'password' => Hash::make(
                    app()->isLocal() ? 'password' : str()->random(32)
                ),
                'surname' => 'Super',
                'name' => 'Admin',
                'secondname' => null,
                'phone' => '+380670000001',
                'role_id' => 1,
                'gender' => null,
                'birthday' => null,
                'region_id' => null,
                'city_id' => null,
                'address' => null,
                'delivery_id' => null,
                'newpost_id' => null,
                'kind_payment_id' => null,
                'is_subscribed' => true,
                'email_verified_at' => now(),
            ],
            [
                'email' => 'bulic2012@gmail.com',
                'password' => Hash::make('12345678'),
                'surname' => 'Рибалкін',
                'name' => 'Євгеній',
                'secondname' => null,
                'phone' => '+380673291419',
                'role_id' => 1,
                'gender' => null,
                'birthday' => null,
                'region_id' => null,
                'city_id' => null,
                'address' => null,
                'delivery_id' => null,
                'newpost_id' => null,
                'kind_payment_id' => null,
                'is_subscribed' => true,
                'email_verified_at' => now(),
            ],
            [
                'email' => 'chmyk_vika@ukr.net',
                'password' => Hash::make('12345678'),
                'surname' => 'Рибалкіна',
                'name' => 'Вікторія',
                'secondname' => null,
                'phone' => '+380971129869',
                'role_id' => 4,
                'gender' => null,
                'birthday' => null,
                'region_id' => null,
                'city_id' => null,
                'address' => null,
                'delivery_id' => null,
                'newpost_id' => null,
                'kind_payment_id' => null,
                'is_subscribed' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
