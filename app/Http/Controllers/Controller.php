<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Кастомні хлібні крихти для специфічних маршрутів.
     *
     * @param string $routeName Ім'я маршруту
     * @param array $parameters Параметри маршруту
     * @return array Масив кастомних хлібних крихт
     */
    public function customBreadcrumbs(string $routeName, array $parameters): array
    {
        // Приклад: кастомні хлібні крихти для маршруту users.show
        if ($routeName === 'users.show' && isset($parameters['user'])) {
            return [
                [
                    'title' => ['Користувачі', 'Профіль'],
                    'name' => 'Профіль користувача',
                    'route' => route('users.show', $parameters['user']),
                ],
            ];
        }

        return []; // Повертаємо порожній масив, якщо немає кастомізації
    }

    /**
     * Кастомні кнопки для специфічних маршрутів.
     *
     * @param string $routeName Ім'я маршруту
     * @param mixed $parameter Параметр маршруту
     * @return array Масив кастомних кнопок
     */
    public function customButtons(string $routeName, $parameter = null): array
    {
        // Приклад: кастомна кнопка для маршруту products.show
        if ($routeName === 'products.show' && $parameter) {
            return [
                [
                    'name' => 'Редагувати продукт',
                    'route' => route('products.edit', $parameter),
                    'icon' => 'fas fa-edit',
                ],
                [
                    'name' => 'Видалити продукт',
                    'route' => route('products.destroy', $parameter),
                    'icon' => 'fas fa-trash',
                ],
            ];
        }

        return []; // Повертаємо порожній масив, якщо немає кастомізації
    }

    protected function see($item)
    {
        echo "<pre>";
        print_r($item);
        echo "</pre>";
    }
    protected function seedie($item)
    {
        echo "<pre>";
        print_r($item);
        echo "</pre>";
        die();
    }
}
