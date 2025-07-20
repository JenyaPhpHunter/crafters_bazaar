<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale'));
        App::setLocale($locale);

        if (!Session::has('currency')) {
            Session::put('currency', $locale === 'uk' ? 'UAH' : 'USD');
        }

        View::share('currency', Session::get('currency'));

        return $next($request);
    }
}


