<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
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
//        echo "<pre>";
//        print_r($request->all());
//        echo "</pre>";
//        die();
//        $request->authenticate();
//
//        $request->session()->regenerate();
//
//        return redirect()->intended(RouteServiceProvider::HOME);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            $role = $user->role_id;
            if ($role < 5) {
                if($request->input('createProduct') == 'createProducts'){
                    return redirect()->route('admin.products.create');
                } else {
                    return redirect()->intended('/admin');
                }
            }
            if($request->input('createProduct')){
                return redirect()->route('products.create');
            } elseif(! empty($request->input('sendquestion'))) {
                return redirect()->route('products.show',['product' => $request->input('product_id')]);
            } else {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        return back()->withErrors([
            'email' => 'Надані облікові дані не збігаються з нашими записами.',
        ]);
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
