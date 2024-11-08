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
        'admin_orders.index',
        'admin_roles.index',
        'admin_users.index',
        'carts.index',
        'orders.index',
        'products.index',
        'wishlist.index',
        'forum_categories.index',
        'forum_sub_categories.index',
        'forum_topics.index',
        'users.show',
        'sellers_buyers.index',
    ];


    private $only_action = [
        'createkindsubkind',
    ];

    private $without_breadcrumps = [
        'users.show',
    ];

    private $with_buttons = [
        'admin_kind_products.index',
        'admin_kind_products.show',
        'admin_sub_kind_products.index',
        'admin_sub_kind_products.show',
        'admin_orders.index',
        'admin_roles.index',
        'admin_users.index',
        'admin_users.details',
        'products.index',
        'forum_categories.index',
        'forum_categories.show',
        'forum_sub_categories.index',
        'forum_sub_categories.show',
        'forum_topics.index',
        'forum_topics.show',
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

    public function getButtons($routeName, $firstParameterValue = null)
    {
        if (in_array($routeName, $this->with_buttons)) {
            $buttons = [];
// Розділяємо рядок на дві частини (клас і дію)
            $routeParts = explode('.', $routeName);
            // Перевіряємо, чи можна розділити на два елементи
            if (count($routeParts) === 2) {
                list($class, $action) = $routeParts;
            } else {
                // У випадку, якщо ім'я роута не відповідає очікуваному формату
                return [];
            }
            // Отримуємо базові значення з OthersConstants
            $classData = OthersConstants::BUTTONSNAMES[$class] ?? null;
//            $actionName = OthersConstants::ACTIONS[$action] ?? null;
            $buttons[] = [
                'name'  => $classData['name'],
                'route' => route($classData['route']),
                'icon' => $classData['icon'],
            ];
            if (isset(OthersConstants::FRIENDLY_BUTTONS[$class])){
                foreach (OthersConstants::FRIENDLY_BUTTONS[$class] as $item) {
                    if ($action === 'show' && !empty($firstParameterValue)) {
                        foreach ($firstParameterValue as $key => $value){
                            $buttons[] = [
                                'name'  => OthersConstants::BUTTONSNAMES[$item]['name'],
                                'route' => route(OthersConstants::BUTTONSNAMES[$item]['route'], [$key => $value]),
                                'icon' => OthersConstants::BUTTONSNAMES[$item]['icon'],
                            ];
                        }
                    } else {
                        $buttons[] = [
                            'name'  => OthersConstants::BUTTONSNAMES[$item]['name'],
                            'route' => route(OthersConstants::BUTTONSNAMES[$item]['route']),
                            'icon' => OthersConstants::BUTTONSNAMES[$item]['icon'],
                        ];
                    }
                }
            }
        } else {
            return [];
        }
        return $buttons;
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
