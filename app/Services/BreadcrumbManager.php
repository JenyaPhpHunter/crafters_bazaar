<?php

namespace App\Services;

use App\Constants\OthersConstants;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class BreadcrumbManager
{
    /**
     * Генерує хлібні крихти для поточного маршруту.
     *
     * @param string|null $routeName Ім'я поточного маршруту
     * @param array $parameters Параметри маршруту
     * @param object|null $controller Екземпляр контролера (опціонально для кастомізації)
     * @return array Масив хлібних крихт
     */
    public function getBreadcrumbs(?string $routeName, array $parameters = [], ?object $controller = null): array
    {
        if (!$routeName) {
            return [];
        }

        // Розділяємо маршрут на клас і дію (наприклад, products.index -> products, index)
        $routeParts = explode('.', $routeName);
        if (count($routeParts) !== 2) {
            return [];
        }

        [$class, $action] = $routeParts;

        // Базові хлібні крихти
        $breadcrumbs = [];

        // Перевіряємо, чи є кастомна логіка в контролері
        if ($controller && method_exists($controller, 'customBreadcrumbs')) {
            $customBreadcrumbs = $controller->customBreadcrumbs($routeName, $parameters);
            if (!empty($customBreadcrumbs)) {
                return $customBreadcrumbs; // Використовуємо кастомні хлібні крихти
            }
        }

        // Отримуємо дані з констант
        $classData = OthersConstants::BREADCRUMPNAMES[$class] ?? null;
        $actionName = OthersConstants::ACTIONS[$action] ?? null;

        // Якщо немає даних про клас, повертаємо порожній масив
        if (!$classData) {
            return [];
        }

        // Перевіряємо, чи маршрут належить до форуму
        $isForum = str_starts_with($routeName, 'forum');

        // Додаємо форумні хлібні крихти
        if ($isForum) {
            foreach (OthersConstants::FRIENDLY_BREADCRUMPS as $key => $item) {
                if ($routeName !== $key) {
                    $breadcrumbs[] = [
                        'title' => $item,
                        'name' => $item,
                        'route' => route($key),
                    ];
                }
            }
        }

        // Формуємо базову хлібну крихту
        $breadcrumb = [
            'title' => [$classData['name']],
            'name' => $classData['name'],
            'route' => route($classData['route'] ?? $routeName),
        ];

        // Додаємо дію до заголовка, якщо вона є
        if ($actionName && $action !== 'createkindsubkind') {
            $breadcrumb['title'][] = $actionName;
        }

        $breadcrumbs[] = $breadcrumb;

        return $breadcrumbs;
    }

    /**
     * Генерує кнопки для поточного маршруту.
     *
     * @param string|null $routeName Ім'я поточного маршруту
     * @param mixed $parameter Параметр маршруту (опціонально)
     * @param object|null $controller Екземпляр контролера (опціонально для кастомізації)
     * @return array Масив кнопок
     */
    public function getButtons(?string $routeName, $parameter = null, ?object $controller = null): array
    {
        if (!$routeName) {
            return [];
        }

        // Перевіряємо, чи є кастомна логіка в контролері
        if ($controller && method_exists($controller, 'customButtons')) {
            $customButtons = $controller->customButtons($routeName, $parameter);
            if (!empty($customButtons)) {
                return $customButtons; // Використовуємо кастомні кнопки
            }
        }

        // Список маршрутів, для яких потрібні кнопки
        $routesWithButtons = [
            'admin_kind_products.index',
            'admin_kind_products.show',
            'admin_sub_kind_products.index',
            'admin_sub_kind_products.show',
            'admin_orders.index',
            'admin_roles.index',
            'admin_tags.index',
            'admin_users.index',
            'admin_users.details',
            'products.index',
            'brands.index',
            'forum_categories.index',
            'forum_categories.show',
            'forum_sub_categories.index',
            'forum_sub_categories.show',
            'forum_topics.index',
            'forum_topics.show',
        ];

        if (!in_array($routeName, $routesWithButtons)) {
            return [];
        }

        // Розділяємо маршрут на клас і дію
        $routeParts = explode('.', $routeName);
        if (count($routeParts) !== 2) {
            return [];
        }

        [$class, $action] = $routeParts;

        // Отримуємо дані з констант
        $classData = OthersConstants::BUTTONSNAMES[$class] ?? null;
        if (!$classData) {
            return [];
        }

        $buttons = [
            [
                'name' => $classData['name'],
                'route' => route($classData['route']),
                'icon' => $classData['icon'],
            ],
        ];

        // Додаємо дружні кнопки
        if (isset(OthersConstants::FRIENDLY_BUTTONS[$class])) {
            foreach (OthersConstants::FRIENDLY_BUTTONS[$class] as $item) {
                $buttonData = OthersConstants::BUTTONSNAMES[$item] ?? null;
                if ($buttonData) {
                    $buttons[] = [
                        'name' => $buttonData['name'],
                        'route' => $action === 'show' && $parameter
                            ? route($buttonData['route'], $parameter)
                            : route($buttonData['route']),
                        'icon' => $buttonData['icon'],
                    ];
                }
            }
        }

        return $buttons;
    }
}
