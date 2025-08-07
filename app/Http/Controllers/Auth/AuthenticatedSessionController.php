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

    public function loginRegister(Request $request)
    {
        if ($request->input('review_product_id')){
            session()->put('review_product_id', $request->input('review_product_id'));

            return view('auth.login-register');
        }

        $sendQuestion = $request->input('sendQuestion') === 'sendQuestion';
        $product_id = $sendQuestion ? $request->input('product_id') : null;

        return view('auth.login-register', [
            'sendQuestion' => $sendQuestion,
            'product_id' => $product_id,
        ]);

    }

//    public function create(Request $request): View
//    {
//        if ($request->input('review_product_id')){
//            session()->put('review_product_id', $request->input('review_product_id'));
//
//            return view('auth.login');
//        }
//        $sendQuestion = $request->input('sendQuestion') === 'sendQuestion';
//        $product_id = $sendQuestion ? $request->input('product_id') : null;
//
//        return view('auth.login', [
//            'sendQuestion' => $sendQuestion,
//            'product_id' => $product_id,
//        ]);
//    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Отримуємо дані кошика з сесії перед регенерацією
        $cart = session()->get('cart', []);
        $review_product_id = session()->get('review_product_id', []);

        // Аутентифікація користувача
        $request->authenticate();

        // Регенерація сесії після успішної аутентифікації
        $request->session()->regenerate();

        // Повертаємо дані кошика у нову сесію
        session()->put('cart', $cart);
        if ($review_product_id) {
            return redirect( route('products.show', [
                'product' => $review_product_id
            ]));
        }

        $user = Auth::user();

        // Отримаємо URL, куди користувач хотів перейти
        $intendedUrl = url()->previous();

        // Якщо URL був /login або /register — перенаправляємо на іншу сторінку
        if (str_contains($intendedUrl, '/login-register')) {
            return redirect($user->role_id < 6 ? '/admin' : route('welcome'));
        }

        return redirect()->intended();
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
