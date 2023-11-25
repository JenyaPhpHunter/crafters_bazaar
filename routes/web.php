<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KindProductController as AdminKindProductController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubKindProductController as AdminSubKindProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
//use App\Http\Controllers\KindProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
//use App\Http\Controllers\SubKindProductController;
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

//Route::get('/locations/{location:slug}', [LocationsController::class, 'show'])
//    ->name('locations.view')
//    ->missing(function (Request $request) {
//        return Redirect::route('locations.index');
//    });

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->group(callback: function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('admin_users', AdminUserController::class);
    Route::resource('admin_roles', RoleController::class);
    Route::resource('admin_products', AdminProductController::class);
    Route::get('/admin_products/{uri}/create-kind-subkind', [AdminProductController::class, 'createkindsubkind'])->name('admin.products.createkindsubkind');
    Route::post('/admin_products/storekindsubkind', [AdminProductController::class, 'storekindsubkind'])->name('admin.products.storekindsubkind');
    Route::resource('admin_kind_products', AdminKindProductController::class);
    Route::resource('admin_sub_kind_products', AdminSubKindProductController::class);
    Route::resource('admin_orders', AdminOrderController::class);
    Route::get('/admin_products/kind_products/{kind_products}', [AdminProductController::class, 'productsKind'])->name('admin_products_kind');
    Route::get('/admin_products/kind_products/{kind_products}/sub_kind_products/{sub_kind_products}', [AdminProductController::class, 'productsKindSubkind'])->name('admin_products_kind_subkind');
    Route::get('/admin_carts/index/{admin_product}', [AdminCartController::class, 'addToCart'])->name('admin_carts.addToCart');
});

Route::get('/', [HomeController::class,'welcome'])->name('welcome');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/seller/{user}', [UserController::class, 'showSeller'])->name('users.show_seller');
Route::get('/users/buyer/{user}', [UserController::class, 'showBuyer'])->name('users.show_buyer');
Route::get('/users/{user}/edit/', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit/', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/{uri}/create-kind-subkind', [ProductController::class, 'createkindsubkind'])->name('products.createkindsubkind');
Route::post('/products/storekindsubkind', [ProductController::class, 'storekindsubkind'])->name('products.storekindsubkind');
Route::resource('orders', OrderController::class);
Route::get('/products/kind_products/{kind_products}', [ProductController::class, 'productsKind'])->name('products_kind');
Route::get('/products/sub_kind_products/{sub_kind_products}', [ProductController::class, 'productsKindSubkind'])->name('products_kind_subkind');
Route::get('/carts/index', [CartController::class, 'index'])->name('carts.index');
Route::get('/carts/index/{product}', [CartController::class, 'addToCart'])->name('carts.addToCart');
Route::delete('/carts/clear', [CartController::class, 'clearCart'])->name('carts.clearСart');
Route::delete('/carts', [CartController::class, 'removeItem'])->name('carts.remove_item');
Route::get('/wishlist/index', [WishController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/index/{product}', [WishController::class, 'addToWishlist'])->name('wishlist.addToWishlist');
Route::delete('/wishlist/clear', [WishController::class, 'clear'])->name('wishlist.clear');
Route::post('wishlist/toCart', [WishController::class, 'toCart'])->name('wishlist.toCart');



//Route::get('/searchusers', [UserController::class, 'searchusers'])->name('searchusers');

//Route::resource('products', ProductController::class)->except(['destroy']);
//Route::view('/validation/debug', 'validation_debug')->name('validation.debug');


//Route::get('/sub_kind_products/create', [AdminSubKindProductController::class, 'create'])->name('sub_kind_products.create');
//Route::get('/sub_kind_products', [AdminSubKindProductController::class, 'index'])->name('sub_kind_products.index');
//Route::post('/sub_kind_products', [AdminSubKindProductController::class, 'store'])->name('sub_kind_products.store');
//Route::get('/sub_kind_products/{sub_kind_product}', [AdminSubKindProductController::class, 'show'])->name('sub_kind_products.show');
//Route::get('/sub_kind_products/{sub_kind_product}/edit/', [AdminSubKindProductController::class, 'edit'])->name('sub_kind_products.edit');
//Route::put('/sub_kind_products/{sub_kind_product}', [AdminSubKindProductController::class, 'update'])->name('sub_kind_products.update');
//Route::delete('/sub_kind_products/{sub_kind_product}', [AdminSubKindProductController::class, 'destroy'])->name('sub_kind_products.destroy');
// Маршрути для незареєстрованих користувачів
//Route::middleware('guest')->group(function () {
//    // Остальні маршрути реєстрації, відновлення пароля та інші
//});
//Route::put('/post/{id}', function ($id) {
//    //
//})->middleware('role:editor');
//Route::controller(OrderController::class)->group(function () {
//    Route::get('/orders/{id}', 'show');
//    Route::post('/orders', 'store');
//});


//Route::name('admin.')->group(function () {
//    Route::get('/users', function () {
//        // Маршруту присвоено имя `admin.users` ...
//    })->name('users');
//});
//Route::fallback(function () {
//    echo "Резервный маршрут";
//});
require __DIR__.'/auth.php';
