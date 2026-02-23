<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// ────────────────────────────────────────────────
// Головна сторінка (батьківський breadcrumb для більшості)
Breadcrumbs::for('welcome', function (BreadcrumbTrail $trail) {
    $trail->push('Головна', route('welcome'));
});

// ────────────────────────────────────────────────
// Адмін-панель (батьківський для всіх адмінських розділів)
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Адмін-панель', route('admin.dashboard')); // або route('admin.home') – підстав свій маршрут
});

// ────────────────────────────────────────────────
// Товари (public частина)
Breadcrumbs::for('products.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome');
    $trail->push('Товари', route('products.index'));
});

Breadcrumbs::for('products.show', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('products.index');
    $trail->push($product->name ?? 'Товар', route('products.show', $product));
});

Breadcrumbs::for('products.create', function (BreadcrumbTrail $trail) {
    $trail->parent('products.index');
    $trail->push('Створення товару');
});

// Список брендів
Breadcrumbs::for('brands.index', function (BreadcrumbTrail $trail) {
    $trail->parent('welcome'); // або 'home', якщо головна називається 'home'
    $trail->push('Бренди', route('brands.index'));
});

// Детальна сторінка бренду (якщо є)
Breadcrumbs::for('brands.show', function (BreadcrumbTrail $trail, $brand) {
    $trail->parent('brands.index');
    $trail->push($brand->name ?? 'Бренд', route('brands.show', $brand));
});

// Створення бренду (якщо є)
Breadcrumbs::for('brands.create', function (BreadcrumbTrail $trail) {
    $trail->parent('brands.index');
    $trail->push('Додати бренд');
});

// ────────────────────────────────────────────────
// Кошик
Breadcrumbs::for('cart.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Кошик', route('cart.index'));
});

// ────────────────────────────────────────────────
// Адмінські розділи – відповідають твоїм константам BREADCRUMPNAMES

Breadcrumbs::for('admin_kind_products.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Види товарів', route('admin_kind_products.index'));
});

Breadcrumbs::for('admin_sub_kind_products.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Підвиди товарів', route('admin_sub_kind_products.index'));
});

Breadcrumbs::for('admin.products.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Товари', route('admin.products.index')); // якщо у тебе є окремий адмін-маршрут
});

Breadcrumbs::for('orders.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Список замовлень', route('orders.index'));
});

Breadcrumbs::for('roles.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Ролі', route('roles.index'));
});

Breadcrumbs::for('users.index', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Користувачі', route('users.index'));
});

// ────────────────────────────────────────────────
// Форум – відповідає твоїй константі FRIENDLY_BREADCRUMPS

Breadcrumbs::for('forum_categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Категорії форуму', route('forum_categories.index'));
});

Breadcrumbs::for('forum_sub_categories.index', function (BreadcrumbTrail $trail, $category = null) {
    $trail->parent('forum_categories.index');

    if ($category) {
        $trail->push($category->name ?? 'Категорія', route('forum_categories.show', $category));
    }

    $trail->push('Підкатегорії', route('forum_sub_categories.index'));
});

Breadcrumbs::for('forum_topics.index', function (BreadcrumbTrail $trail, $subCategory = null) {
    $trail->parent('forum_categories.index');

    if ($subCategory) {
        $trail->push($subCategory->category->name ?? 'Категорія', route('forum_categories.show', $subCategory->category));
        $trail->push($subCategory->name ?? 'Підкатегорія', route('forum_sub_categories.show', $subCategory));
    }

    $trail->push('Теми', route('forum_topics.index'));
});

// ────────────────────────────────────────────────
// Приклади детальних сторінок (можна розширити)

Breadcrumbs::for('forum_categories.show', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('forum_categories.index');
    $trail->push($category->name, route('forum_categories.show', $category));
});

Breadcrumbs::for('forum_sub_categories.show', function (BreadcrumbTrail $trail, $subCategory) {
    $trail->parent('forum_categories.show', $subCategory->category);
    $trail->push($subCategory->name, route('forum_sub_categories.show', $subCategory));
});

Breadcrumbs::for('forum_topics.show', function (BreadcrumbTrail $trail, $topic) {
    $trail->parent('forum_topics.index', $topic->subCategory ?? null);
    $trail->push($topic->title, route('forum_topics.show', $topic));
});
