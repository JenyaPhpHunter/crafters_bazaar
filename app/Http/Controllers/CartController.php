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
        if($request->input('user_id')){
            $user_id = $request->input('user_id');
        } else {
            $user_id = request()->cookie('user_id');
        }
        $cartItems = CartItems::query()
            ->join('carts', 'cart_items.cart_id', '=', 'carts.id')->with('product')
            ->where('carts.user_id', $user_id)
            ->where('carts.active', 1)
            ->get();

        return view('cart.index', ['cartItems' => $cartItems]);
    }

    public function addToCart(Request $request, $productId)
    {
        if ($request->input('user_id')) {
            $user_id = $request->input('user_id');
        } elseif(request()->cookie('user_id') != NULL) {
            $user_id = request()->cookie('user_id');
        } else {
            $user = new User();
            $user->email = date('Ymd_His') . '_' . Str::random(10) . '@user.com';
            $user->password =  Hash::make($request->post('password'));
            $user->created_at = date("Y-m-d H:i:s");
            $user->role_id = 7;

            $user->save();
            // Автентифікувати користувача
//            Auth::login($user);

            $user_id = $user->id;
        }

        $product = Product::find($productId);
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
            $cartItem->quantity += 1;
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
        // Опціонально можна використовувати метод associate для спрощення зв'язку з об'єктом товару
        $cartItem->product()->associate($product);
        $cartItem->save();

        return redirect()->route('carts.index')
            ->with([
            'success' => 'Товар додано до корзини',
            'cartItem' => $cartItem,
        ])->withCookie(cookie('user_id', $user_id));
    }

    public function clearCart(Request $request)
    {
        if ($request->input('user_id')) {
            $user_id = $request->input('user_id');
        } elseif(request()->cookie('user_id') != NULL) {
            $user_id = request()->cookie('user_id');
        }
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

