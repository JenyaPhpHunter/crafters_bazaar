<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function isUser($user)
    {
        return $user->role > 4;
    }

    public function isSeller($user)
    {
        return $user->role == 4;
    }

    public function isРead($user)
    {
        return $user->role == 3;
    }

    public function isAdmin($user)
    {
        return $user->role < 3;
    }
}
