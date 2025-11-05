<?php

namespace App\Services;

use App\Constants\OthersConstants;
use Illuminate\Support\Facades\Route;

class UrlService
{
    /**
     * Отримує контролер поточного маршруту.
     *
     * @return string
     */
    protected function getCtrl(): string
    {
        $routeName = Route::currentRouteName();
        if (!$routeName) {
            return '';
        }
        // Розділяємо маршрут на частини (наприклад, products.index -> products)
        $parts = explode('.', $routeName);
        return $parts[0] ?? '';
    }

    /**
     * Отримує дію поточного маршруту.
     *
     * @return string
     */
    protected function getAction(): string
    {
        $routeName = Route::currentRouteName();
        if (!$routeName) {
            return '';
        }
        // Розділяємо маршрут на частини (наприклад, products.index -> index)
        $parts = explode('.', $routeName);
        return $parts[1] ?? '';
    }

    /**
     * Отримує параметри маршруту як рядок запиту.
     *
     * @return string
     */
    protected function getParams(): string
    {
        $parameters = Route::current()->parameters();
        if (empty($parameters)) {
            return '';
        }
        // Формуємо рядок запиту, наприклад, ?id=1&slug=test
        return http_build_query($parameters);
    }

    /**
     * Генерує URL для поточного маршруту.
     *
     * @return string
     */
    public function getLink(): string
    {
        if ($this->getCtrl() === '') {
            return '#'; // Повертаємо якір, якщо маршрут відсутній
        }

        // Отримуємо базовий URL із конфігурації Laravel
        $baseUrl = config('app.url', url('/'));
        $link = $baseUrl . '/' . $this->getCtrl() . '/';

        if ($this->getAction() !== '') {
            $link .= $this->getAction() . '/';
        }

        if ($this->getParams() !== '') {
            $link .= '?' . $this->getParams();
        }

        return $link;
    }

    /**
     * Генерує хлібні крихти для поточного маршруту.
     *
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        $routeName = Route::currentRouteName();
        if (!$routeName) {
            return [];
        }

        $controller = Route::current()->getController();
        $parameters = Route::current()->parameters();

        // Використовуємо BreadcrumbManager для генерації хлібних крихт
        $breadcrumbManager = app(BreadcrumbManager::class);
        return $breadcrumbManager->getBreadcrumbs($routeName, $parameters, $controller);
    }
}
