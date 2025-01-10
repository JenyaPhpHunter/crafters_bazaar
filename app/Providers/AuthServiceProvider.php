<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\ForumCategory;
use App\Models\KindProduct;
use App\Models\SubKindProduct;
use App\Models\Tag;
use App\Models\User;
use App\Policies\ForumCategoryPolicy;
use App\Policies\KindProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\TagPolicy;
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
        KindProduct::class => KindProductPolicy::class,
        Tag::class => TagPolicy::class,
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
