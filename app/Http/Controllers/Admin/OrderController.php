<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\City;
use App\Models\Delivery;
use App\Models\KindPayment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

//use App\Mail\OrderConfirmation;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->where('status_order_id', 1)
            ->with('user')
            ->with('delivery')
            ->with('kind_payment')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.orders.index',[
            "orders" => $orders,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create(Request $request) //TODO зробити метод для створення замовлення по телефону
//    {

//    }
//
//    public function store(Request $request) //TODO зробити метод для запису створенного замовлення по телефону
//    {

//    }
//
//    public function show($id) //TODO зробити метод для перегляду замовлення співробітником
//    {
//        $order = Order::query()->where('id', $id)->first();
//
//        return view('orders.show', compact('order'));
//    }
//
//    public function edit($id) //TODO зробити метод для редагуквання замовлення співробітником
//    {
//        //
//    }
//
//    public function update(Request $request, $id) //TODO зробити метод для запису замовлення відредагованого співробітником
//    {
//        //
//    }

//    public function destroy($id)
//    {
//        //
//    }
}
