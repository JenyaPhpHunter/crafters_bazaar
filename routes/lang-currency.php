<?php

use Illuminate\Support\Facades\Route;

// Переключення мови
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['uk', 'en'])) abort(400);

    session(['locale' => $locale]);

    if (!session()->has('currency_switched')) {
        session(['currency' => $locale === 'uk' ? 'UAH' : 'USD']);
    }

    return redirect()->back();
})->name('locale.switch');



// Переключення валюти вручну
Route::get('/currency/{currency}', function ($currency) {
    if (!in_array($currency, ['UAH', 'USD', 'EUR'])) abort(400);

    session([
        'currency' => $currency,
        'currency_switched' => true,
    ]);

    return redirect()->back();
})->name('currency.switch');


