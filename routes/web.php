<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KindProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubKindProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class,'welcome'])->name('welcome');

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
});

//Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
//Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
//Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
//Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
//Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
//Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
//Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

Route::prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('kind_products', KindProductController::class);
    Route::get('/sub_kind_products/create', [SubKindProductController::class, 'create'])->name('sub_kind_products.create');
    Route::post('/sub_kind_products/create', [SubKindProductController::class, 'create'])->name('sub_kind_products.ajaxCreate');
    Route::get('/sub_kind_products', [SubKindProductController::class, 'index'])->name('sub_kind_products.index');
    Route::post('/sub_kind_products', [SubKindProductController::class, 'store'])->name('sub_kind_products.store');
    Route::get('/sub_kind_products/{sub_kind_product}', [SubKindProductController::class, 'show'])->name('sub_kind_products.show');
    Route::get('/sub_kind_products/{sub_kind_product}/edit/', [SubKindProductController::class, 'edit'])->name('sub_kind_products.edit');
    Route::put('/sub_kind_products/{sub_kind_product}', [SubKindProductController::class, 'update'])->name('sub_kind_products.update');
    Route::delete('/sub_kind_products/{sub_kind_product}', [SubKindProductController::class, 'destroy'])->name('sub_kind_products.destroy');
    Route::resource('roles', RoleController::class);
});


Route::get('/searchusers', [UserController::class, 'searchusers'])->name('searchusers');


    // Ваші роути для адмінської зони
//    Route::get('/', [AdminsController::class, 'index'])->name('admin.dashboard');

    // Приклад інших роутів
//    Route::get('/users', [AdminsController::class, 'users'])->name('admin.users');
//    Route::get('/orders', [AdminsController::class, 'orders'])->name('admin.orders');

    // І так далі...

    // Додавання нового роуту до групи 'admin'
//    Route::get('/users/create', [AdminsController::class, 'createUser'])->name('admin.users.create');
//});

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

//Route::prefix('admin')->group(function () {
//    Route::get('/users', function () {
//        // Соответствует URL-адресу `/admin/users` ...
//    });
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
