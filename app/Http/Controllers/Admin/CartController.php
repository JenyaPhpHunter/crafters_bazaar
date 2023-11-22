<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $cartItems = CartItems::query()
            ->join('carts', 'cart_items.cart_id', '=', 'carts.id')->with('product')
            ->where('carts.user_id', $user_id)
            ->get();

        return view('cart.index', ['cartItems' => $cartItems]);
    }

    public function addToCart(Request $request, $productId)
    {
        if($request->input('user_id')) {
            $user_id = $request->input('user_id');
        } else {
            $user = new User();
            $user->email = Str::random(50) . 'user.com';
            $user->password =  Hash::make($request->post('password'));
            $user->created_at = date("Y-m-d H:i:s");
            $user->role_id = 7;

            $user->save();
            // Автентифікувати користувача
            Auth::login($user);

            $user_id = $user->id;
        }
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Товар не знайдено');
        }

// Отримуємо або створюємо кошик користувача
        $cart = Cart::firstOrNew(['user_id' => $user_id]);
        $cart->user_id = $user_id;
        $cart->active = 0;
        $cart->save();

// Перевірка, чи товар вже є в кошику
        $cartItem = CartItems::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Якщо товар вже є в кошику, збільшуємо кількість
            $cartItem->quantity += 1;
            $cartItem->price = $cartItem->price*$cartItem->quantity;
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

// Опціонально можна використовувати метод associate для спрощення зв'язку з об'єктом товару
        $cartItem->product()->associate($product);
        $cartItem->save();
//
//        $cartItems = CartItems::query()
//            ->join('carts', 'cart_items.cart_id', '=', 'carts.id')->with('product')
//            ->where('carts.user_id', $user_id)
//            ->get();

        return redirect()->route('carts.index')->with(['success' => 'Товар додано до корзини']);
    }

    public function clearCart(Request $request)
    {
        $user_id = $request->input('user_id');
        $cartItems = CartItems::query()
            ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
            ->where('carts.user_id', $user_id)
            ->delete();

        return redirect( route('carts.index'));
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
}

