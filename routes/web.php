<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KindProductController as AdminKindProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubKindProductController as AdminSubKindProductController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ForumCategoryController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\ForumSubCategoryController;
use App\Http\Controllers\ForumTopicController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});
Route::prefix('admin')->middleware('auth')->group(callback: function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('admin_users', AdminUserController::class);
    Route::get('/sellers_buyers', [AdminUserController::class, 'sellersBuyers'])->name('sellers_buyers.index');
    Route::get('/admin_users/{admin_user}/details', [AdminUserController::class, 'getDetails'])->name('admin_users.details');
    Route::resource('admin_roles', RoleController::class);
    Route::resource('admin_kind_products', AdminKindProductController::class);
    Route::resource('admin_sub_kind_products', AdminSubKindProductController::class);
    Route::resource('admin_orders', AdminOrderController::class);
    Route::resource('admin_tags', TagController::class);
//Route::get('/test-email', function () {
//    $emailService = new \App\Services\EmailService();
//    $emailService->sendWelcomeEmail('bulic2012@gmail.com', 'your_test_password');
//});
});
Route::middleware('auth')->group(function () {
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit/', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::post('products/sendquestion/{product}', [ProductController::class, 'sendquestion'])->name('products.sendquestion');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit/', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/{uri}/create-kind-subkind', [ProductController::class, 'createkindsubkind'])->name('products.createkindsubkind');
    Route::post('/products/storekindsubkind', [ProductController::class, 'storekindsubkind'])->name('products.storekindsubkind');
    Route::delete('/products', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::resource('forum_categories', ForumCategoryController::class);
    Route::resource('forum_sub_categories', ForumSubCategoryController::class);
    Route::resource('forum_topics', ForumTopicController::class);
    Route::resource('forum_posts', ForumPostController::class)->except(['index']);
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});
Route::get('/', [HomeController::class,'welcome'])->name('welcome');
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/kind_products/{kind_products}', [ProductController::class, 'productsKind'])->name('products_kind');
Route::get('/products/sub_kind_products/{sub_kind_products}', [ProductController::class, 'productsKindSubkind'])->name('products_kind_subkind');
Route::get('/carts/index', [CartController::class, 'index'])->name('carts.index');
Route::get('/carts/index/{product}', [CartController::class, 'addToCart'])->name('carts.addToCart');
Route::delete('/carts/clear', [CartController::class, 'clearCart'])->name('carts.clearСart');
Route::delete('/carts', [CartController::class, 'removeItem'])->name('carts.remove_item');
Route::get('cart/remove-item-guest/{product_id}', [CartController::class, 'removeItemGuest'])->name('carts.remove_item_guest');
Route::get('/wishlist/index', [WishController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/index/{product}', [WishController::class, 'addToWishlist'])->name('wishlist.addToWishlist');
Route::delete('/wishlist/clear', [WishController::class, 'clear'])->name('wishlist.clear');
Route::post('wishlist/toCart', [WishController::class, 'toCart'])->name('wishlist.toCart');
Route::resource('orders', OrderController::class)->except(['index', 'store', 'create']);
Route::post('/products/{productId}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/subscribe', [UserController::class, 'toggleSubscriptionStatus'])->name('subscribe.toggle');

require __DIR__.'/auth.php';
//Route::get('/searchusers', [UserController::class, 'searchusers'])->name('searchusers');

//Route::view('/validation/debug', 'validation_debug')->name('validation.debug');

// Маршрути для незареєстрованих користувачів
//Route::middleware('guest')->group(function () {
//    // Остальні маршрути реєстрації, відновлення пароля та інші
//});
//Route::put('/post/{id}', function ($id) {
//    //
//})->middleware('role:editor');
//});

//Route::fallback(function () {
//    echo "Резервный маршрут";
//});

