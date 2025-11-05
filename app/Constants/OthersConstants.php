<?php

namespace App\Constants;

class OthersConstants
{
    public const BREADCRUMPNAMES = [
        'products' => ['name' => 'Товари', 'route' => 'products.index'],
        // Інші класи
    ];

    public const FRIENDLY_BREADCRUMPS = [
        'products.index' => 'Всі товари',
        'products.show' => 'Деталі товару',
    ];

    public const BUTTONSNAMES = [
        'products' => ['name' => 'Новий товар', 'route' => 'products.create', 'icon' => 'fas fa-plus'],
    ];

    public const FRIENDLY_BUTTONS = [
        'products' => ['products.create', 'products.index'],
    ];

    public const ACTIONS = [
        'index' => 'Список',
        'show' => 'Деталі',
        'create' => 'Створення',
        'edit' => 'Редагування',
    ];
}
