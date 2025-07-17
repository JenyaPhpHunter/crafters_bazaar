<?php

namespace App\Policies;

use App\Models\Brand;
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
     * Будь-хто може переглядати бренд.
     */
    public function view(User $user, Brand $brand)
    {
        return true;
    }

    /**
     * Тільки творець бренду може редагувати.
     */
    public function update(User $user, Brand $brand)
    {
        return $brand->creator_id === $user->id;
    }

    /**
     * Тільки творець бренду може видаляти.
     */
    public function delete(User $user, Brand $brand)
    {
        return $brand->creator_id === $user->id;
    }
}
