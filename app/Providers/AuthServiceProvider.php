<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\ForumCategory;
use App\Models\User;
use App\Policies\ForumCategoryPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => RolePolicy::class,
        ForumCategory::class => ForumCategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
