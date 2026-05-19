<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Role;
use App\Models\StatusProduct;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    // Переглянути список товарів
    public function viewAny(User $user): bool
    {
        return true; // всі авторизовані
    }

    // Переглянути один товар
    public function view(User $user, Product $product): bool
    {
        return true; // всі авторизовані
    }

    // Створити користувача або зареєструватись
    public function create(User $user): bool
    {
        return true;
    }

    // Редагувати товар
    public function update(User $user, Product $product): bool
    {
        // Адміни (role_id <= 3) можуть редагувати будь-який
        // Автор може редагувати свій
        return $user->role_id <= 3 || $user->id === $product->creator_id;
    }

    // Видалити товар
    public function delete(User $user, Product $product): bool
    {
        // Тільки адміни або автор
        return $user->role_id <= 3 || $user->id === $product->creator_id;
    }

    // Відновити після soft delete
    public function restore(User $user, Product $product): bool
    {
        return $user->role_id <= 2; // тільки супер-адміни
    }

    // Видалити назавжди
    public function forceDelete(User $user, Product $product): bool
    {
        return $user->role_id === 1; // тільки головний адмін
    }

    // app/Policies/ProductPolicy.php
    public function putUpForSale(User $user, Product $product): bool
    {
        return $user->id === $product->creator_id
            && ($product->status_product_id === StatusProduct::NEW);
    }

    public function publish(User $user, Product $product): bool
    {
        return $user->role_id <= Role::ADMIN
            && $product->status_product_id === StatusProduct::APPROVED;
    }
}
