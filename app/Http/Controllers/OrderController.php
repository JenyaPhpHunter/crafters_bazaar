<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $orders = Order::query()->where('user_id', $user_id)->orderBy('id', 'desc')->get();

        return view('orders.index',[
//            "user" => $user,
            "orders" => $orders,
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
            ->where('carts.active', 1)
            ->get();
        $countries = [
            'UA' => 'Україна',
            'PL' => 'Польща',
            'UK' => 'Англія',
        ];
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
        $collator = collator_create('uk_UA'); // Створюємо колатор для української мови
        collator_sort($collator, $arr_region_cities); // Виконуємо сортування

        $deliveries = Delivery::all();
        $payment_kinds = KindPayment::all();

        $user_email = $user->email;
        if (preg_match('/@user\.com$/', $user_email)) {
            $user_email = '';
        }

        $addressParts = explode(', ', $user->address);

        $address = [
            'street' => $addressParts[0] ?? null,
            'home' => $addressParts[1] ?? null,
            'apartment' => $addressParts[2] ?? null,
        ];

        return view('orders.create',[
            'cartItems' => $cartItems,
            'countries' => $countries,
            'arr_cities' => $arr_cities,
            'arr_region_cities' => $arr_region_cities,
            "user" => $user,
            "address" => $address,
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
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'delivery_id' => 'required',
            'region' => 'required',
            'city' => 'required',
            'street' => 'required',
            'home' => 'required',
            'payment_type' => 'required',
        ], [], [
            'name' => 'Ім\'я',
            'surname' => '\'Прізвище\'',
            'email' => '\'Електронна пошта\'',
            'phone' => '\'телефон\'',
            'region' => '\'Регіон\'',
            'city' => '\'місто\'',
            'home' => '\'номер будинку\'',
            'street' => '\'вулиця\'',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $old_user = $user;
        if($request->input('email') != $user->email && $user->role_id != 7){
            Auth::logout();
            $user = User::query()->where('email', $request->input('email'))->first();
            if (!$user){
                $user = new User;
                $user->email = $request->input('email');
                $user->password = Str::random(10);      // TODO відправити лист з паролем + спливаюче вікно з паролем
                $user->role_id = 6;
            }
        }
        if($user->role_id == 7) {
            $old_user = $user;
            $user = User::query()->where('email', $request->input('email'))->first();
            if (!$user) {
                $user = $old_user;
                $user->email = $request->input('email');
                $user->password = Str::random(10);   // TODO відправити лист з паролем + спливаюче вікно з паролем
                $user->role_id = 6;
            } else {
                $old_user->delete();
            }
        }
        if($user->category_users_id == 1){
            $user->category_users_id = 2;
        }
        $user->name =  $request->post('name');
        $user->secondname =  $request->post('secondname');
        $user->surname =  $request->post('surname');
        $user->phone = $request->post('phone');
        $user->delivery_id = $request->post('delivery_id');
        $region = Region::query()->where('name',$request->input('region'))->first();
        $city = City::query()->where('name',$request->input('city'))->where('region_id',$region->id)->first();
        $user->region_id = $region->id;
        $user->city_id = $city->id;
        $user->kind_payment_id = $request->post('payment_type');
        $user->address = $request->post('street') . ', ' . $request->post('home') . ', ' . $request->post('apartment');
        $user->updated_at = date("Y-m-d H:i:s");

        $user->save();

        // Автентифікувати користувача
        Auth::login($user);
        Cookie::queue('user_id', $user->id, 60); // 60 - це час у хвилинах, на який ви хочете встановити куку

        $order = new Order();
        $order->user_id =  $user->id;
        $order->delivery_id = $request->post('delivery_id');
        $order->kind_payment_id = $request->post('payment_type');
//        $order->card = $request->post('card');
        $order->region_id = $user->region_id;
        $order->city_id = $user->city_id;
        $order->address = $user->address;
//        $order->newpost_id = $request->post('newpost_id');
//        $order->promocode = $request->post('promocode');
//        $order->pricedelivery = $request->post('pricedelivery');
        $order->comment = $request->post('bdOrderNote');
        $cart = Cart::query()
            ->where('user_id', $old_user->id)
            ->where('active', 1)
            ->latest()  // Сортування за спаданням дати створення
            ->first();
        $cart->user_id = $user->id;
        $cart->active = 0;

        $cart->save();
        $order->cart_id = $cart->id;
        $order->sum_order = $cart->total;
        $order->status_order_id = 1;
        $order->created_at = date("Y-m-d H:i:s");

        $order->save();

// Відправлення листа користувачу та адміністратору
        $admin_data = [
            'mail_user' => 0,
            'order' => $order->id,
            'client' => $user->surname . " " . $user->name . " " . $user->secondname,
            'phone_client' => $user->phone,
            'city_client' => $request->post('city'),
            'address_client' => $request->post('address'),
            'comment' => $order->comment,
            'sum_order' => $order->sum_order,
        ];
        $data_user = [
            'mail_user' => 1,
            'name' => $user->surname . " " . $user->name . " " . $user->secondname,
            'sum_order' => $order->sum_order,
        ];
        $cartitems = CartItems::query()->where('cart_id', $cart->id)->get();
        foreach ($cartitems as $item) {
            $product = Product::find($item->product_id);
            $product_name = $product->name;
            $data_user['cart'][] = [
                'product' => $product_name,
                'quantity' => $item->quantity,
                'total' => $item->total,
            ];
            $admin_data['cart'][] = [
                    'product' => $product_name,
                    'quantity' => $item->quantity,
                    'total' => $item->total,
            ];
            CartItems::find($item->id)->update([
                'active' => 0,
            ]);
        }
//
//        Mail::to($order->email)->send(new OrderConfirmation($data_user));
//
//        Mail::to('bulic2@ukr.net')->send(new OrderConfirmation($admin_data));

        if($user->role_id < 5){
            return redirect(route('admin_users.show', ['admin_user' => $user->id]).'#orders');
        } else {
            return redirect(route('users.show', ['user' => $user->id]).'#orders');
        }
    }

    public function show($id, Request $request)
    {
        $user_id = $request->input('user_id');
        $cartItems = CartItems::query()
            ->join('carts', 'cart_items.cart_id', '=', 'carts.id')->with('product')
            ->where('carts.user_id', $user_id)
            ->where('carts.active', 1)
            ->get();

        $order = Order::query()->where('id', $id)->first();

        return view('orders.show', compact('order', 'cartItems'));
    }

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
