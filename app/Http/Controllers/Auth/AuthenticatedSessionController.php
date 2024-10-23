<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    public function loginRegister()
    {
        return view('auth.login-register',[

        ]);
    }

    public function create(Request $request): View
    {
        if($request->input('sendquestion') == 'sendquestion'){
            $sendquestion = true;
            $product_id = $request->input('product_id');
            return view('auth.login', [
                'sendquestion' => $sendquestion,
                'product_id' => $product_id,
            ]);
        } else {
            $sendquestion = false;
            return view('auth.login', [
                'sendquestion' => $sendquestion,
            ]);
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Отримуємо дані кошика з сесії перед регенерацією
        $cart = session()->get('cart', []);
        // Аутентифікація користувача
        $request->authenticate();

        // Регенерація сесії після успішної аутентифікації
        $request->session()->regenerate();

        // Повертаємо дані кошика у нову сесію
        session()->put('cart', $cart);

        $user = User::where('email', $request->input('email'))->first();
        if ($user->role_id < 5) {
            return redirect()->intended('/admin');
        } else {
            return redirect()->intended();
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Вихід користувача з системи
        Auth::guard('web')->logout();

        // Інвалідація сесії користувача
        $request->session()->invalidate();

        // Регенерація CSRF токена
        $request->session()->regenerateToken();

        // Встановлюємо кукі 'user_id' з від'ємним терміном для видалення
        return redirect('/')
            ->withCookie(Cookie::forget('user_id'));
    }

}
