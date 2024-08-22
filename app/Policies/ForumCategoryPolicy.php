<?php

namespace App\Policies;

use App\Models\ForumCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumCategoryPolicy
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

    public function edit(User $user, ForumCategory $category)
    {
        return $user->role_id < 4;
    }

}
