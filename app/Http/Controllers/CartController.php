<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // Перевірка чи користувач авторизований
        if (auth()->check()) {
            // Якщо користувач авторизований, то використовуємо його id
            $user_id = auth()->id();

            // Отримуємо товари з бази даних для авторизованого користувача
            $cartItems = CartItems::query()
                ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                ->with('product')
                ->where('carts.user_id', $user_id)
                ->where('carts.active', 1)
                ->get();
        } else {
            // Якщо користувач неавторизований, використовуємо сесію для отримання товарів
            $cart = session()->get('cart', []);
            $cartItems = [];

            // Перебираємо товари з сесії
            foreach ($cart as $productId => $details) {
                $product = Product::find($productId);
                if ($product) {
                    $cartItems[] = (object)[
                        'product' => $product,
                        'quantity' => $details['quantity'],
                        'price' => $product->price,
                    ];
                }
            }
        }

        // Повертаємо вигляд з товарами
        return view('cart.index', ['cartItems' => $cartItems]);
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::find($productId);
        if ($request->input('user_id')) {
            $user_id = $request->input('user_id');
            // Отримуємо або створюємо кошик користувача
            $cart = Cart::firstOrNew(['user_id' => $user_id, 'active' => 1]);
            $cart->user_id = $user_id;

            $cart->save();

// Перевірка, чи товар вже є в кошику
            $cartItem = CartItems::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                // Якщо товар вже є в кошику, збільшуємо кількість
                $cartItem->quantity ++;
                $cartItem->save();
            } else {
                // Якщо товару немає в кошику, додаємо його
                $cartItem = new CartItems([
                    'cart_id' => $cart->id,
                    'product_id' => $productId,
                    'price' => $product->price,
                    'quantity' => 1,
                ]);
                $cartItem->save();
            }
            $cartItems = CartItems::query()->where('cart_id', $cart->id)->get();
            $sum = 0;
            $pricediscount = 0;
            foreach ($cartItems as $item){
                $sum += $item->price * $item->quantity;
                $pricediscount += $item->pricediscount;
            }
            $cart->sum = $sum;
            $cart->pricediscount = $pricediscount;
            $cart->total = $sum - $pricediscount;
            $cart->save();
        } else {
            $cart = session()->get('cart', []);
            // Перевірка чи товар вже є в кошику
            if(isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    "quantity" => 1,
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('carts.index')
            ->with([
            'success' => 'Товар додано до кошика',
        ]);
//        ->withCookie(cookie('user_id', $user_id));
    }

    public function clearCart(Request $request)
    {
        // Отримуємо user_id або з request, або з cookie
        $user_id = $request->input('user_id') ?? $request->cookie('user_id');

        if ($user_id) {
            // Якщо user_id існує, видаляємо товари з корзини користувача
            CartItems::query()
                ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                ->where('carts.user_id', $user_id)
                ->delete();
        } else {
            // Якщо user_id немає, видаляємо товари з сесії
            session()->forget('cart'); // Видаляє лише ключ 'cart'
        }

        return redirect()->route('carts.index');
    }
    public function removeItem(Request $request)
    {
        echo "<pre>";
        print_r($request->all());
        echo "</pre>";
        die();
        if (array_key_exists($productId, $cartItems)) {
            unset($cartItems[$productId]);
            session(['cart' => $cartItems]);
        }

        return redirect()->route('cart.index')->with('success', 'Товар видалено з корзини');
    }

    public function removeItemGuest($productId)
    {
        $cart = session()->get('cart', []);

        // Якщо товар є в кошику, видаляємо його
        if(isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Товар був видалений з кошика!');
    }

}

