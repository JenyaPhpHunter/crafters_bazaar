<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
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

    public function edit(User $user, Tag $tag)
    {
        return $user->role_id < 4;
    }

    public function delete(User $user, Tag $tag)
    {
        return $user->role_id < 4;
    }
}
