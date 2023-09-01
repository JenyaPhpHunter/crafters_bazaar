<?php

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

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

Route::middleware( ['admin'])->prefix('admin')->group(function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
});
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
//require __DIR__.'/auth.php';
