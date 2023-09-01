<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $topMenu;

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
        view()->composer('*', function ($view) {

            if (!isset($this->topMenu)) {
                // выборка меню из базы
                $this->topMenu = "При першій покупці знижка 10%";
            }

            $view->with(['topMenu' => $this->topMenu]);

        });
    }
}
