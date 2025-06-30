<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
{
    use HandlesAuthorization;

    /**
     * Дозволяє доступ адміну (role_id == 1) до всіх дій.
     */
    public function before(User $user, $ability)
    {
        if ($user->role_id === 1) {
            return true;
        }
    }

    /**
     * Приклад — чи може користувач переглядати бренд.
     */
    public function view(User $user)
    {
        // Всі користувачі з роллю продавця або вище можуть переглядати
        return $user->role_id >= 3;
    }

    /**
     * Приклад — чи може користувач редагувати бренд.
     */
    public function update(User $user)
    {
        return $user->role_id <= 3; // Адмін і редактор
    }

    /**
     * Приклад — чи може користувач видаляти бренд.
     */
    public function delete(User $user)
    {
        return $user->role_id <= 2; // Тільки адміністратори
    }

    // Додаткові методи за потреби...
}
