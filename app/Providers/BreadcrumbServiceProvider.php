<?php

namespace App\Providers;

use App\Services\BreadcrumbManager;
use App\Services\UrlService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BreadcrumbServiceProvider extends ServiceProvider
{
    /**
     * Реєструємо сервіси для всіх view.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Перевіряємо, чи існує активний маршрут
            if (!request()->route()) {
                return; // Виходимо, якщо маршрут відсутній
            }

            // Отримуємо ім’я поточного маршруту
            $currentRouteName = Route::currentRouteName();
            // Отримуємо параметри маршруту
            $routeParameters = Route::current()->parameters();

            // Створюємо екземпляр UrlService
            $urlService = app(UrlService::class);

            // Генеруємо хлібні крихти через UrlService
            $breadcrumbs = $urlService->getBreadcrumbs();

            // Отримуємо контролер поточного маршруту (якщо є)
            $controller = Route::current()->getController();
            // Генеруємо кнопки через BreadcrumbManager
            $breadcrumbManager = app(BreadcrumbManager::class);
            $firstParameter = !empty($routeParameters) ? reset($routeParameters) : null;
            $buttons = $breadcrumbManager->getButtons($currentRouteName, $firstParameter, $controller);

            // Передаємо дані у всі view
            $view->with('breadcrumbs', $breadcrumbs)
                ->with('buttons', $buttons);
        });
    }

    /**
     * Реєстрація сервісів.
     */
    public function register(): void
    {
        // Реєструємо BreadcrumbManager як singleton
        $this->app->singleton(BreadcrumbManager::class, function () {
            return new BreadcrumbManager();
        });

        // Реєструємо UrlService як singleton
        $this->app->singleton(UrlService::class, function () {
            return new UrlService();
        });
    }
}
