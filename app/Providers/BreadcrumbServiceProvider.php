<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route; // Додаємо імпорт Route
use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Передача breadcrumbs у всі view
        View::composer('*', function ($view) {
            // Отримуємо назву поточного роуту
            $currentRouteName = Route::currentRouteName(); // Використовуємо Route з правильним імпортом
            // Генеруємо breadcrumbs за допомогою глобального методу
            $controller = app(Controller::class);
            $breadcrumbs = $controller->getBreadcrumbs($currentRouteName);
            // Передаємо breadcrumbs у всі view
            $view->with('breadcrumbs', $breadcrumbs);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
