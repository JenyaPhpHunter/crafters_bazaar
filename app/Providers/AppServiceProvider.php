<?php

namespace App\Providers;

use App\View\Composers\HeaderComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer([
            'include.header-section',
            'admin.include.header-section',
            'include.header-sticky-section',
            'admin.include.header-sticky-section',
            'include.footer',
        ], HeaderComposer::class);
    }
}
