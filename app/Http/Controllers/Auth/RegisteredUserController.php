<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(Request $request)
    {
        if ($request->input('review_product_id')){
            session()->put('review_product_id', $request->input('review_product_id'));
        }

        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->post('password'));
        $user->role_id = 6;
        $user->category_user_id = 5;
        $user->created_at = date("Y-m-d H:i:s");

        $user->save();

        event(new Registered($user));

        Auth::login($user);

        $review_product_id = session()->get('review_product_id', []);
        if ($review_product_id) {
            return redirect( route('products.show', [
                'product' => $review_product_id
            ]));
        }

        return redirect()->intended();
    }
}
