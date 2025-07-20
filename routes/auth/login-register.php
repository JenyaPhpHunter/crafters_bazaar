<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::middleware('guest')->group(function () {
    // Спільна сторінка логіну/реєстрації
    Route::get('login-register', [AuthenticatedSessionController::class, 'loginRegister'])
        ->name('login-register');

    // Логін
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login');

    // Реєстрація
    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('register');
});

// Logout — для авторизованих
Route::middleware('auth')->post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
