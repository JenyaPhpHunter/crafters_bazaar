<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\PaymentKind;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $baskets = Basket::query()->where('user_id', $user->id)->orderBy('id', 'desc')->get();
        $deliveries = Delivery::all();
        $payment_kinds = PaymentKind::all();

        return view('orders.index',[
            "user" => $user,
            "baskets" => $baskets,
            "deliveries" => $deliveries,
            "payment_kinds" => $payment_kinds,
        ]);
//        $user = Auth::user();
//        $orders = Order::query()->where('user_id',$user->id)->orderBy('id', 'desc')->get();
//        $booking = [];
//        $user_order = User::query()->where('id',$user->id)->first();
//        foreach ($orders as $order){
//            $booking[] = [
//                'order' => $order,
//                'basket' => Basket::query()->where('order_id',$order->id)->orderBy('id', 'desc')->get(),
//                'user' => $user_order,
//            ];
//        }
//        echo "<pre>";
//        print_r($booking);
//        echo "</pre>";
//        die();
        return view('orders.index', compact('booking'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $baskets = Basket::query()->where('active',1)->where('user_id', $user->id)->get();
        $deliveries = Delivery::all();
        $payment_kinds = PaymentKind::all();

        return view('orders.create',[
            "user" => $user,
            "baskets" => $baskets,
            "deliveries" => $deliveries,
            "payment_kinds" => $payment_kinds,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $validated = $request->validate([
//            'name' => ['required', 'unique:products', 'regex:/^[^<>$%\/\\\[\]\^{|}]*$/i'],
//            'kind_product_id' => 'required',
//            'content' => 'required',
//            'price' => 'required',
//        ], $messages = [
//            'required' => ':attribute является обязательным полем.',
//        ]);
        $user = Auth::user();
        $basket = new Basket();
        $basket = $basket->getBasketProductsUser($user->id);
        $sum_order = 0;
        $data_order = [];
        foreach ($basket as $item){
            $sum_order +=  $item->total;
//            $product = Product::query()->where('id',$item->product_id)->first();
        }

        $order = new Order();
        $order->created_at = date("Y-m-d H:i:s");
        $order->email = $request->post('email');
        $order->user_id =  $user->id;
        $order->phone = $request->post('phone');
        $order->delivery_id = $request->post('delivery_id');
        $order->paymentkind_id = $request->post('paymentkind_id');
        $order->card = $request->post('card');
        $order->city = $request->post('city');
        $order->address = $request->post('address');
        $order->np_address = $request->post('np_address');
        $order->promocode = $request->post('promocode');
        $order->pricedelivery = $request->post('pricedelivery');
        $order->discounttotal = $request->post('discounttotal');
        $order->total = $sum_order;
        $order->comment = $request->post('comment');

        $user = User::query()->where('id',$user->id)->first();
        $user->surname = $request->post('surname');
        $user->name = $request->post('name');
        $user->secondname = $request->post('secondname');
        $user->phone = $request->post('phone');
        $user->city = $request->post('city');
        $user->address = $request->post('address');
        $user->delivery_id = $request->post('delivery_id');
        $user->paymentkind_id = $request->post('paymentkind_id');

        $order->save();
        $user->save();


// Відправлення листа користувачу та адміністратору
        $admin_data = [
            'mail_user' => 0,
            'order' => $order->id,
            'client' => $request->post('surname'). " " . $request->post('name'). " " .$request->post('secondname'),
            'phone_client' => $request->post('phone'),
            'city_client' => $request->post('city'),
            'address_client' => $request->post('address'),
            'comment' => $request->post('comment'),
            'sum_order' => $sum_order,
        ];
        $data_user = [
            'mail_user' => 1,
            'name' => $request->post('surname'). " " . $request->post('name'). " " .$request->post('secondname'),
            'sum_order' => $sum_order,
        ];
        foreach ($basket as $item) {
            $product = Product::find($item->product_id);
            $product_name = $product->name;
            $data_user['basket'][] = [
                'product' => $product_name,
                'quantity' => $item->quantity,
                'total' => $item->total,
            ];
            $admin_data['basket'][] = [
                    'product' => $product_name,
                    'quantity' => $item->quantity,
                    'total' => $item->total,
            ];
            Basket::find($item->id)->update([
                'active' => 0,
                'order_id' => $order->id
            ]);
        }

//        echo "<pre>";
//        print_r($data_user);
//        echo "</pre>";
//        die();
        Mail::to($order->email)->send(new OrderConfirmation($data_user));

        Mail::to('bulic2@ukr.net')->send(new OrderConfirmation($admin_data));

        return redirect( route('orders.show', ['order' => $order->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->latest()->first();
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
