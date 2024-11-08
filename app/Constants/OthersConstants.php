<?php

namespace App\Constants;

class OthersConstants
{
    const RATING = [
        '1' => 'Дуже погано',
        '2' => 'Погано',
        '3' => 'Нормально',
        '4' => 'Добре',
        '5' => 'Дуже добре',
    ];

    const ACTIONS = [
        'create' => 'Створення',
        'edit' => 'Редагування',
        'show' => 'Перегляд',
        'destroy' => 'Видалення',
        'createkindsubkind' => 'Додавання виду та підвиду продукту',
    ];

    const BREADCRUMPNAMES = [
        'admin_kind_products' => ['name' => 'Види товарів', 'route' => 'admin_kind_products.index'],
        'admin_sub_kind_products' => ['name' => 'Підвиди товарів', 'route' => 'admin_sub_kind_products.index'],
        'products' => ['name' => 'Товари', 'route' => 'products.index'],
        'admin_orders' => ['name' => 'Список замовлень', 'route' => 'admin_orders.index'],
        'admin_roles' => ['name' => 'Ролі', 'route' => 'admin_roles.index'],
        'admin_users' => ['name' => 'Користувачі', 'route' => 'admin_users.index'],
        'wishlist' => ['name' => 'Список бажань', 'route' => 'wishlist.index'],
        'orders' => ['name' => 'Замовлення', 'route' => 'orders.index'],
        'carts' => ['name' => 'Корзина', 'route' => 'carts.index'],
        'forum_categories' => ['name' => 'Категорії форума', 'route' => 'forum_categories.index'],
        'forum_sub_categories' => ['name' => 'Підкатегорії форума', 'route' => 'forum_sub_categories.index'],
        'forum_topics' => ['name' => 'Теми форума', 'route' => 'forum_topics.index'],
        'forum_posts' => ['name' => 'Пости форума', 'route' => 'forum_posts.index'],
        'users' => ['name' => 'Користвачі', 'route' => 'users.show'],
        'sellers_buyers' => ['name' => 'Продавці та покупці', 'route' => 'sellers_buyers.index'],
    ];

    const FRIENDLY_BREADCRUMPS = [
        'forum_categories.index' => 'Категорії форума',
        'forum_sub_categories.index' => 'Підкатегорії форума',
        'forum_topics.index' => 'Теми форума',
    ];

    const BUTTONSNAMES = [
        'admin_kind_products' => ['name' => 'Створити вид товарів', 'route' => 'admin_kind_products.create' , 'icon' => 'fal fa-box-open'],
        'admin_sub_kind_products' => ['name' => 'Створити підвид товарів', 'route' => 'admin_sub_kind_products.create', 'icon' => 'fal fa-boxes'],
        'products' => ['name' => 'Створити товар', 'route' => 'products.create', 'icon' => 'fal fa-cube'],
        'admin_orders' => ['name' => 'Створити замовлення', 'route' => 'admin_orders.create', 'icon' => 'fal fa-shopping-cart'],
        'admin_roles' => ['name' => 'Створити роль', 'route' => 'admin_roles.create', 'icon' => 'fal fa-user-shield'],
        'admin_users' => ['name' => 'Створити користувача', 'route' => 'admin_users.create', 'icon' => 'fal fa-user-plus'],
        'forum_categories' => ['name' => 'Створити категорію', 'route' => 'forum_categories.create', 'icon' => 'fal fa-folder-plus'],
        'forum_sub_categories' => ['name' => 'Створити підкатегорію', 'route' => 'forum_sub_categories.create', 'icon' => 'fal fa-folder-tree'],
        'forum_topics' => ['name' => 'Створити тему', 'route' => 'forum_topics.create', 'icon' => 'fal fa-comments'],
        'forum_posts' => ['name' => 'Створити пост', 'route' => 'forum_posts.create', 'icon' => 'fal fa-comments'],
    ];

    const FRIENDLY_BUTTONS = [
        'admin_sub_kind_products' => [
            'admin_kind_products'
        ],
        'admin_kind_products' => [
            'admin_sub_kind_products'
        ],
        'forum_categories' => [
            'forum_sub_categories',
            'forum_topics',
        ],
        'forum_sub_categories' => [
            'forum_categories',
            'forum_topics',
        ],
        'forum_topics' => [
            'forum_categories',
            'forum_sub_categories',
            'forum_posts',
        ],
    ];
}
