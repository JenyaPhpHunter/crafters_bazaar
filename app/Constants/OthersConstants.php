<?php

namespace App\Constants;

class OthersConstants
{
    const RATING = [
        '1' => 'Дуже погано',
        '2' => 'Дуже погано',
        '3' => 'Погано',
        '4' => 'Погано',
        '5' => 'Нормально',
        '6' => 'Нормально',
        '7' => 'Добре',
        '8' => 'Добре',
        '9' => 'Дуже добре',
        '10' => 'Дуже добре',
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
        'orders' => ['name' => 'Список замовлень', 'route' => 'orders.index'],
        'admin_roles' => ['name' => 'Ролі', 'route' => 'roles.index'],
        'admin_users' => ['name' => 'Користувачі', 'route' => 'users.index'],
        'cart' => ['name' => 'Корзина', 'route' => 'cart.index'],
        'forum_categories' => ['name' => 'Категорії форума', 'route' => 'forum_categories.index'],
        'forum_sub_categories' => ['name' => 'Підкатегорії форума', 'route' => 'forum_sub_categories.index'],
        'forum_topics' => ['name' => 'Теми форума', 'route' => 'forum_topics.index'],
        'users' => ['name' => 'Користвачі', 'route' => 'users.show'],
    ];

    const FRIENDLY_BREADCRUMPS = [
        'forum_categories.index' => 'Категорії форума',
        'forum_sub_categories.index' => 'Підкатегорії форума',
        'forum_topics.index' => 'Теми форума',
    ];
}
