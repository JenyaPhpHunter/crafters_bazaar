<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AddUserIdToRequest
{
    public function handle($request, Closure $next)
    {
        // Отримати залогіненого користувача (якщо він існує)
        $user = Auth::user();

        // Перевірити, чи існує залогінений користувач і додати його id до запиту
        if ($user) {
            $request->merge(['user_id' => $user->id]);
        }

        return $next($request);
    }
}

