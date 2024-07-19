<?php
// app/Services/UserService.php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function choiceSellerAdmin()
    {
        $user = User::where('role_id', 3)->first();
        // TODO
        // Логіка вибору користувача і оновлення лічильника
        // Ви можете використовувати код з попереднього прикладу тут

        return $user;
    }

    // Інші методи для роботи з користувачами
}
