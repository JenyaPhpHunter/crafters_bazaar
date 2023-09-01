<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Отримати роль користувача з сесії
        $userRole = $request->session()->get('user_role');

        // Перевірити, чи має користувач необхідну роль (наприклад, role > 3)
        if ($userRole > 3) {
            return $next($request);
        }

        // Якщо у користувача немає відповідної ролі, перенаправити його куди завгодно
        return redirect('/admin.users.create'); // або /dashboard
    }

}
