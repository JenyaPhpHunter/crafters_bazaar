<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\CartItems;
use App\Models\City;
use App\Models\Delivery;
use App\Models\AdminOrder;
use App\Models\KindPayment;
use App\Models\Product;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

//use App\Mail\OrderConfirmation;


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
        $payment_kinds = KindPayment::all();

        return view('orders.index',[
            "user" => $user,
            "baskets" => $baskets,
            "deliveries" => $deliveries,
            "payment_kinds" => $payment_kinds,
        ]);

        return view('orders.index', compact('booking'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->input('user_id')) {
            $user_id = $request->input('user_id');
        } elseif (request()->cookie('user_id') != NULL) {
            $user_id = request()->cookie('user_id');
        }

        $user = User::find($user_id);
        $cartItems = CartItems::query()
            ->join('carts', 'carts.id', '=', 'cart_items.cart_id')
            ->where('carts.user_id', $user_id)
            ->get();
        $countries = [
            'UA' => 'Україна',
            'PL' => 'Польща',
            'UK' => 'Англія',
        ];

//        $cities = City::all();
//        $arr_cities = [];
//        $region_ids = [];
//        $arr_region_cities = [];
//
//        foreach ($cities as $city) {
//            $arr_cities[] = $city->name;
//
//            if (!in_array($city->region_id, $region_ids)) {
//                $region_ids[] = $city->region_id;
//                $region = Region::find($city->region_id);
//                $arr_region_cities[$city->region_id]['region_name'] = $region->name;
//                $arr_region_cities[$city->region_id]['cities'][] = $city->name;
//            } else {
//                $arr_region_cities[$city->region_id]['cities'][] = $city->name;
//            }
//        }
        $cities = City::all();
        $arr_cities = [];
        $arr_region_cities = [];

        foreach ($cities as $city) {
            $arr_cities[] = $city->name;

            if (!isset($arr_region_cities[$city->region_id])) {
                $region = Region::query()->find($city->region_id);
                $arr_region_cities[$city->region_id]['region_name'] = $region->name;
                $arr_region_cities[$city->region_id]['cities'] = [];
            }

            $arr_region_cities[$city->region_id]['cities'][] = $city->name;
        }
//        echo "<pre>";
//        print_r($arr_region_cities);
//        echo "</pre>";
//        die();
        $collator = collator_create('uk_UA'); // Створюємо колатор для української мови
        collator_sort($collator, $arr_region_cities); // Виконуємо сортування

        $deliveries = Delivery::all();
        $payment_kinds = KindPayment::all();

        $user_email = $user->email;
        if (preg_match('/@user\.com$/', $user_email)) {
            $user_email = '';
        }

        return view('orders.create',[
            'cartItems' => $cartItems,
            'countries' => $countries,
            'arr_cities' => $arr_cities,
            'arr_region_cities' => $arr_region_cities,
            "user" => $user,
            "user_email" => $user_email,
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
        $payment_kinds = KindPayment::all();
        $paymentTypesExist = false;
        for ($i = 1; $i <= $payment_kinds->count(); $i++) {
            if ($request->has("payment_type_$i")) {
                $paymentTypesExist = true;
                break;
            }
        }
        if ($paymentTypesExist) {

        } elseif ($request->has('bdOrderNote')) {
            // Логіка для обробки вибору методу оплати
        }

        if ($request->input('user_id')) {
            $user_id = $request->input('user_id');
        } else {
            $user_id = request()->cookie('user_id');
        }
        $user = User::query()->where('id', $user_id)->first();
        $user->name =  $request->post('name');
        $user->secondname =  $request->post('secondname');
        $user->surname =  $request->post('surname');
        $user->email = $request->post('email');
        $user->phone = $request->post('phone');
        $user->region_id = $request->post('region');
        $user->city_id = $request->post('city');
        $user->address = $request->post('street') . $request->post('street') . $request->post('apartment');

        $user->save();

        $order = new Order();
        $order->user_id =  $user->id;
        $order->delivery_id = $request->post('delivery_id');
        $order->kind_payment_id = $request->post('kind_payment_id');
        $order->card = $request->post('card');
        $order->city = $request->post('city');
        $order->address = $request->post('address');
        $order->np_address = $request->post('np_address');
        $order->promocode = $request->post('promocode');
        $order->pricedelivery = $request->post('pricedelivery');
        $order->discounttotal = $request->post('discounttotal');
        $order->total = $sum_order;
        $order->comment = $request->post('comment');
        $order->created_at = date("Y-m-d H:i:s");

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
