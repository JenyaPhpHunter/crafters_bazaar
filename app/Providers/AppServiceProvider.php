<?php

namespace App\Providers;

use App\View\Composers\HeaderComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
        App::setLocale(Session::get('locale', config('app.locale')));

        View::composer([
            'include.header-section',
            'admin.include.header-section',
            'include.header-sticky-section',
            'admin.include.header-sticky-section',
            'include.footer',
        ], HeaderComposer::class);
    }
}
