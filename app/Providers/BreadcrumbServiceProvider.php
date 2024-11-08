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
            $currentRouteName = Route::currentRouteName(); // Отримуємо ім'я поточного маршруту
            $routeParameters = Route::current()->parameters(); // Отримуємо всі параметри маршруту як масив
//// Далі можна обробити параметри в залежності від потреби
            foreach ($routeParameters as $key => $value) {
                // $key — це ім'я параметра (наприклад, 'product' або 'forum_sub_category')
                // $value — це значення параметра
                $firstParameterValue = [
                    $key => $value
                ];
            }
//            echo "<pre>";
//            print_r($routeParameters);
//            echo "</pre>";
//            die();
            // Якщо ви хочете отримати перший параметр без імені:
//            $firstParameterValue = reset($routeParameters); // Значення першого параметра (якщо такий є)
            // Генеруємо breadcrumbs за допомогою глобального методу
            $controller = app(Controller::class);
            $breadcrumbs = $controller->getBreadcrumbs($currentRouteName);
            if (!empty($firstParameterValue)){
                $buttons = $controller->getButtons($currentRouteName, $firstParameterValue);
            } else {
                $buttons = $controller->getButtons($currentRouteName);
            }


            // Передаємо breadcrumbs у всі view
            $view->with('breadcrumbs', $breadcrumbs)
                ->with('buttons', $buttons);
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
