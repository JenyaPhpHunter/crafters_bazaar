<?php

namespace App\Policies;

use App\Models\KindProduct;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KindProductPolicy
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

    public function edit(User $user, KindProduct $kind_product)
    {
        return $user->role_id < 4;
    }

}
