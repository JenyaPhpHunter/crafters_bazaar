<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use App\Models\User;
use App\Models\WishItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class WishController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        if (!$user_id && request()->cookie('user_id') != NULL){
            $user_id = request()->cookie('user_id');
        }
        $wishitems = WishItems::query()
            ->where('user_id', $user_id)
            ->with('product.productphotos')
            ->get();

//        foreach ($wishitems as $wishitem){
//            $selectedPhoto = $wishitem->product->productphotos->where('queue', 1)->first();
//            $this->seedie($selectedPhoto->small_path . '/' . $selectedPhoto->small_filename);
//        }

        return view('wishlist.index', ['wishitems' => $wishitems]);
    }

    public function addToWishlist(Request $request, $productId)
    {
        if($request->input('user_id')) {
            $user_id = $request->input('user_id');
        } else {
            $user = new User();
            $user->email = Str::random(50) . '@user.com';
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

        // Перевірка, чи товар вже є в кошику
        $wishItem = WishItems::query()->where('product_id', $productId)->first();
        if ($wishItem) {
            // Якщо товар вже є в кошику,то попереджаємо, що товар вже є у Wishlist
        } else {
            // Якщо товару немає в кошику, додаємо його
            $wishItem = new WishItems([
                'user_id' => $user_id,
                'product_id' => $productId,
                'price' => $product->price,
            ]);
            $wishItem->save();
        }

        return redirect()->back()->with('success', 'Товар додано до улюблених');
//        return redirect()->route('products.show')->with(['success' => 'Товар додано до улюблених']);
    }

    public function clear(Request $request)
    {
        $user_id = $request->input('user_id');
        WishItems::query()->where('user_id', $user_id)->delete();

        return redirect()->route('products.index')->with('success', 'Список бажань очищено');
    }

    public function toCart(Request $request)
    {
        $user_id = $request->input('user_id');

        $wishitems = WishItems::query()
            ->where('user_id', $user_id)
            ->with('product')
            ->get();

        $wishitems->each(function ($wishitem) use ($user_id) {
            $product = $wishitem->product;

            // Отримуємо або створюємо кошик користувача
            $cart = Cart::firstOrNew(['user_id' => $user_id]);
            $cart->user_id = $user_id;
            $cart->active = 1;
            $cart->save();

            // Перевірка, чи товар вже є в кошику
            $cartItem = CartItems::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                // Якщо товар вже є в кошику, збільшуємо кількість
                $cartItem->quantity += 1;
                $cartItem->save();
            } else {
                // Якщо товару немає в кошику, додаємо його
                $cartItem = new CartItems([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'quantity' => 1,
                ]);
                $cartItem->save();
            }
        });
        WishItems::query()->where('user_id', $user_id)->delete();
        $cartItems = CartItems::query()
            ->join('carts', 'cart_items.cart_id', '=', 'carts.id')->with('product')
            ->where('carts.user_id', $user_id)
            ->where('carts.active', 1)
            ->get();
        return view('cart.index', compact('cartItems'))->with('success', 'Елементи додані до корзини');
//        return redirect()->back()->with('success', 'Елементи додані до корзини');
    }

    public function removeItem(Request $request)
    {
        echo "<pre>";
        print_r($request->all());
        echo "</pre>";
        die();

        return redirect()->route('wishlist.index')->with('success', 'Товар видалено з корзини');
    }

}

