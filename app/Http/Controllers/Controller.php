<?php

namespace App\Http\Controllers;

use App\Constants\OthersConstants;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $without_route = [
        'welcome',
        'admin',
        'admin_kind_products.index',
        'admin_sub_kind_products.index',
        'admin_roles.index',
        'admin_users.index',
        'cart.index',
        'orders.status',
        'products.index',
        'wishlist.index',
        'forum_categories.index',
        'forum_sub_categories.index',
        'forum_topics.index',
        'users.show',
    ];


    private $only_action = [
        'createkindsubkind',
    ];

    private $without_breadcrumps = [
        'users.show',
    ];

    public function getBreadcrumbs($routeName)
    {
        if (!in_array($routeName, $this->without_breadcrumps)) {
            // Розділяємо рядок на дві частини (клас і дію)
            $routeParts = explode('.', $routeName);
            // Перевіряємо, чи можна розділити на два елементи
            if (count($routeParts) === 2) {
                list($class, $action) = $routeParts;
            } else {
                // У випадку, якщо ім'я роута не відповідає очікуваному формату
                return [];
            }

            $breadcrumbs = [];
            // Отримуємо базові значення з OthersConstants
            $classData = OthersConstants::BREADCRUMPNAMES[$class] ?? null;
            $actionName = OthersConstants::ACTIONS[$action] ?? null;
            // Розділяємо рядок по символу підкреслення '_'
            $Parts = explode('_', $routeName);
            $is_forum = ($Parts[0] == 'forum');
            if ($is_forum) {
                $friendly_breadcrumps = OthersConstants::FRIENDLY_BREADCRUMPS;
                foreach ($friendly_breadcrumps as $key => $item) {
                    if ($routeName != $key){
                        $breadcrumbs[count($breadcrumbs)] = [
                            'title' => '',
                            'name' => $item,
                            'route' => route($key)
                        ];
                    }
                }
            }
            // Перевіряємо, чи маршрут є специфічним і потрібно пропустити 'name'
            if (in_array($routeName, $this->without_route) || $is_forum) {
                $breadcrumbs[] = [
                    'title' => [$classData['name']],
                    'name'  => '',
                    'route' => '',
                ];
                if ($actionName) {
                    $breadcrumbs[count($breadcrumbs) - 1]['title'][] = $actionName;
                }
            } else {
                if (in_array($action, $this->only_action)) {
                    // Створюємо базовий запис для списку breadcrumbs з відображенням 'name'
                    $breadcrumbs[] = [
                        'title' => [],
                        'name'  => $classData['name'],
                        'route' => route($classData['route']),
                    ];
                } else {
                    // Створюємо базовий запис для списку breadcrumbs з відображенням 'name'
                    $breadcrumbs[] = [
                        'title' => [$classData['name']],
                        'name'  => $classData['name'],
                        'route' => route($classData['route']),
                    ];
                }

                // Якщо є специфічні дії (create, edit, etc.), додаємо до breadcrumbs
                if ($actionName) {
                    $breadcrumbs[count($breadcrumbs) - 1]['title'][] = $actionName;
                }
            }
        } else {
            $breadcrumbs = [];
        }
        return $breadcrumbs;
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
