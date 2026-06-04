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
        if (auth()->check()) {
            $cartItems = CartItems::query()
                ->with(['product.productPhotos', 'product.brand', 'product.discounts', 'product.subKindProduct.discounts'])
                ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
                ->select('cart_items.*')
                ->where('carts.user_id', auth()->id())
                ->where('carts.active', 1)
                ->get();
        } else {
            $cartItems = collect(session()->get('cart', []))
                ->map(function ($details, $productId) {
                    $product = Product::with(['productPhotos', 'brand', 'discounts', 'subKindProduct.discounts'])->find($productId);

                    if (!$product) {
                        return null;
                    }

                    return (object) [
                        'product' => $product,
                        'quantity' => $details['quantity'] ?? 1,
                        'price' => $product->final_price,
                    ];
                })
                ->filter()
                ->values();
        }

        return view('cart.index', ['cartItems' => $cartItems]);
    }

    public function addToCart(Request $request, Product $product)
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id(), 'active' => 1],
                ['sum' => 0, 'pricediscount' => 0, 'total' => 0]
            );

            $cartItem = CartItems::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity');
            } else {
                CartItems::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'price' => $product->final_price,
                    'pricediscount' => max($product->price - $product->final_price, 0),
                    'quantity' => 1,
                ]);
            }

            $this->refreshCartTotals($cart);
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity']++;
            } else {
                $cart[$product->id] = ['quantity' => 1];
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('carts.index')->with('success', 'Товар додано до кошика');
    }

    public function clearCart(Request $request)
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->where('active', 1)
                ->first();

            if ($cart) {
                CartItems::where('cart_id', $cart->id)->delete();
                $this->refreshCartTotals($cart);
            }
        } else {
            session()->forget('cart');
        }

        return redirect()->route('carts.index')->with('success', 'Кошик очищено');
    }

    public function removeItem(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('carts.index');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('active', 1)
            ->first();

        if ($cart && $request->filled('cart_item_id')) {
            CartItems::where('cart_id', $cart->id)
                ->where('id', $request->input('cart_item_id'))
                ->delete();

            $this->refreshCartTotals($cart);
        }

        return redirect()->route('carts.index')->with('success', 'Товар видалено з кошика');
    }

    public function removeItemGuest($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('carts.index')->with('success', 'Товар видалено з кошика');
    }

    private function refreshCartTotals(Cart $cart): void
    {
        $items = CartItems::where('cart_id', $cart->id)->get();
        $sum = $items->sum(fn ($item) => $item->price * $item->quantity);
        $discount = $items->sum(fn ($item) => $item->pricediscount * $item->quantity);

        $cart->sum = $sum;
        $cart->pricediscount = $discount;
        $cart->total = max($sum - $discount, 0);
        $cart->save();
    }
}

