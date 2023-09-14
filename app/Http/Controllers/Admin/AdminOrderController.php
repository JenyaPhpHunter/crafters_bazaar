<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Delivery;
use App\Models\AdminOrder;
use App\Models\KindPayment;
use App\Models\Product;
use App\Models\StatusOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use App\Mail\OrderConfirmation;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status_orders_id = $request->input('status_orders');
        $baskets = Basket::query()->orderBy('id', 'desc')->get();
        $users = User::all();
        $deliveries = Delivery::all();
        $payment_kinds = KindPayment::all();
        if(isset($status_orders_id)){
            $status_orders = StatusOrder::query()->where('id',$status_orders_id)->first();
            $orders = AdminOrder::query()->where('status_order_id', $status_orders_id)->get();
            return view('admin.orders.index',[
                "orders" => $orders,
                "users" => $users,
                "baskets" => $baskets,
                "deliveries" => $deliveries,
                "payment_kinds" => $payment_kinds,
                "status_orders" => $status_orders,
            ]);
        } else {
            $orders = AdminOrder::all();
            $statuses_orders = StatusOrder::all();

            return view('admin.orders.index',[
                "orders" => $orders,
                "users" => $users,
                "baskets" => $baskets,
                "deliveries" => $deliveries,
                "payment_kinds" => $payment_kinds,
                "statuses_orders" => $statuses_orders,
            ]);
        }
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
        $payment_kinds = KindPayment::all();

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

        $order = new AdminOrder();
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
        $order = AdminOrder::where('user_id', $user->id)->latest()->first();
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
