<?php

use Illuminate\Support\Facades\Route;

// === ADMIN ===
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\KindProductController as AdminKindProductController;
use App\Http\Controllers\Admin\SubKindProductController as AdminSubKindProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\TagController;

// === FRONT ===
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\ReviewController;

// === FORUM ===
use App\Http\Controllers\ForumCategoryController;
use App\Http\Controllers\ForumSubCategoryController;
use App\Http\Controllers\ForumTopicController;
use App\Http\Controllers\ForumPostController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'dashboard'])
            ->name('dashboard');

        Route::resource('admin_users', AdminUserController::class);
        Route::get('admin_users/{admin_user}/details', [AdminUserController::class, 'getDetails'])
            ->name('admin_users.details');

        Route::resource('admin_roles', RoleController::class);
        Route::resource('admin_kind_products', AdminKindProductController::class);
        Route::resource('admin_sub_kind_products', AdminSubKindProductController::class);
        Route::resource('admin_orders', AdminOrderController::class);
        Route::resource('admin_tags', TagController::class);
    });

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // === USERS ===
    Route::resource('users', UserController::class)
        ->only(['show', 'edit', 'update']);

    // === PRODUCTS ===
    Route::resource('products', ProductController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);

    Route::get('products/create-kind-subkind', [ProductController::class, 'createkindsubkind'])
        ->name('products.createkindsubkind');

    Route::post('products/storekindsubkind', [ProductController::class, 'storekindsubkind'])
        ->name('products.storekindsubkind');

    Route::post('products/sendquestion/{product}', [ProductController::class, 'sendquestion'])
        ->name('products.sendquestion');

    // === FORUM ===
    Route::resource('forum_categories', ForumCategoryController::class);
    Route::resource('forum_sub_categories', ForumSubCategoryController::class);
    Route::resource('forum_topics', ForumTopicController::class);
    Route::resource('forum_posts', ForumPostController::class)->except(['index']);

    // === ORDERS ===
    Route::resource('orders', OrderController::class)
        ->except(['index', 'store', 'create']);

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');

    // === BRANDS ===
    Route::resource('brands', BrandController::class);

    Route::post('brands/{brand}/invite', [BrandController::class, 'invite'])
        ->name('brands.invite');

    Route::get('brands/{brand}/accept', [BrandController::class, 'acceptInvitation'])
        ->name('brands.acceptInvitation');

    Route::post('brands/{brand}/join', [BrandController::class, 'join'])
        ->name('brands.join');

    Route::patch('brands/{brand}/restore', [BrandController::class, 'restore'])
        ->name('brands.restore');

    Route::delete('brands/{brand}/leave', [BrandController::class, 'leave'])
        ->name('brands.leave');

    Route::delete('brands/{brand}/users/{user}', [BrandController::class, 'removeUser'])
        ->name('brands.removeUser');

    Route::delete('brands/{brand}/invitations/{invitation}', [BrandController::class, 'cancelInvitation'])
        ->name('brands.cancelInvitation');

    //Route::get('/test-email', function () {
//    $emailService = new \App\Services\EmailService();
//    $emailService->sendWelcomeEmail('bulic2012@gmail.com', 'your_test_password');
//});
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// === PRODUCTS (PUBLIC) ===
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::get('products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('products/kind_products/{kind_products}', [ProductController::class, 'productsKind'])
    ->name('products_kind');
Route::get('products/sub_kind_products/{sub_kind_products}', [ProductController::class, 'productsKindSubkind'])
    ->name('products_kind_subkind');

// === CART ===
Route::get('carts/index', [CartController::class, 'index'])->name('carts.index');
Route::get('carts/index/{product}', [CartController::class, 'addToCart'])->name('carts.addToCart');
Route::delete('carts/clear', [CartController::class, 'clearCart'])->name('carts.clearCart');
Route::delete('carts', [CartController::class, 'removeItem'])->name('carts.remove_item');
Route::get('cart/remove-item-guest/{product}', [CartController::class, 'removeItemGuest'])
    ->name('carts.remove_item_guest');

// === WISHLIST ===
Route::get('wishlist/index', [WishController::class, 'index'])->name('wishlist.index');
Route::get('wishlist/index/{product}', [WishController::class, 'addToWishlist'])
    ->name('wishlist.addToWishlist');
Route::delete('wishlist/clear', [WishController::class, 'clear'])->name('wishlist.clear');
Route::post('wishlist/toCart', [WishController::class, 'toCart'])->name('wishlist.toCart');

// === REVIEWS ===
Route::post('products/{product}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');

// === SUBSCRIBE ===
Route::post('subscribe', [UserController::class, 'toggleSubscriptionStatus'])
    ->name('subscribe.toggle');

/*
|--------------------------------------------------------------------------
| AUTH / LOCALE
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
require __DIR__ . '/lang-currency.php';
