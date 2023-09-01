<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

class BasketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $basketItems = $user->basketItems()->where('active',1)->with('product')->get();
        return view('booking.basket', compact('basketItems'));

    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $product = Product::findOrFail($request->input('product_id'));
//        $quantity = $request->input('quantity');
        $quantity = 1;
        $price = $product->price;
        $sum = $quantity * $price;
        $total = $sum;
        $existingBasketItem = $user->basketItems()->where('active',1)->where('product_id', $product->id)->first();
        if ($existingBasketItem) {
            $existingBasketItem->update([
                'quantity' => $existingBasketItem->quantity + $quantity,
                'sum' => $existingBasketItem->sum + $sum,
                'total' => $existingBasketItem->total + $total,
            ]);
        } else {
            $basketItem = new Basket([
                'quantity' => $quantity,
                'price' => $price,
                'sum' => $sum,
                'total' => $total
            ]);
            $basketItem->product()->associate($product);
            $user->basketItems()->save($basketItem);
        }

        return redirect()->route('booking.basket')->with('success', 'Товар додано до кошику!');
    }

//    public function update(Request $request, Basket $basketItem)
//    {
//        $quantity = $request->input('quantity');
//        $price = $basketItem->product->price;
//        $pricediscount = $basketItem->product->pricediscount;
//        $discount = $basketItem->product->discount;
//        $sum = $quantity * $price;
//        $total = $sum - $sum * $discount;
//        $basketItem->update([
//            'quantity' => $quantity,
//            'price' => $price,
//            'pricediscount' => $pricediscount,
//            'sum' => $sum,
//            'discount' => $discount,
//            'total' => $total
//        ]);
//        return redirect()->route('basket.index')->with('success', 'Кількість товару оновлено!');
//    }

    public function destroy(Basket $basketItem)
    {
        $basketItem->delete();
        return redirect()->back()->with('success', 'Товар успішно видалено з корзини!');
//        return redirect()->route('basket.index')->with('success', 'Товар видалено з кошика!');

    }

}

