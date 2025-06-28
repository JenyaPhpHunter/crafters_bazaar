<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItems;
use App\Models\City;
use App\Models\Delivery;
use App\Models\KindPayment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Region;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $orders = Order::query()
            ->with('cart.cartitems') // Додати зв'язок cart_items до моделі Cart
            ->with('status_order')
            ->where('user_id', $user_id)
            ->get();

        return view('orders.status', ['orders' => $orders]);
    }

    public function create(Request $request)
    {
        if ($request->input('user_id')) {
            $user_id = $request->input('user_id');
        } elseif (request()->cookie('user_id') != NULL) {
            $user_id = request()->cookie('user_id');
        }
        $user = User::find($user_id);
        $user_email = $user->email;
        $addressParts = explode(', ', $user->address);
        $address = [
            'street' => $addressParts[0] ?? null,
            'home' => $addressParts[1] ?? null,
            'apartment' => $addressParts[2] ?? null,
        ];
        $cart = session()->get('cart', []);
        if (!empty($cart)){
            $cart_obj = Cart::firstOrNew(['user_id' => $user_id, 'active' => 1]);
            $cart_obj->save();
            foreach ($cart as $key => $cartItem) {
                $product = Product::find($key); // Отримуємо товар за ідентифікатором
                if ($product) {
                    $cartItemObj = new CartItems();
                    $cartItemObj->cart_id = $cart_obj->id;
                    $cartItemObj->product_id = $product->id;
                    $cartItemObj->quantity = $cartItem['quantity'];
                    $cartItemObj->price = $product->price;
                    $cartItemObj->active = 1;
                    $cartItemObj->save();
                }
            }
            $cart_sum = $cart_obj->cartitems()->sum('price');

            $cart_obj->sum = $cart_sum;
            $cart_obj->total = $cart_sum - $cart_obj->pricediscount;
            $cart_obj->user_id = $user_id;
            $cart_obj->save();
        }
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
            $arr_cities[] = $city->title;
            if (!isset($arr_region_cities[$city->region_id])) {
                $region = Region::query()->find($city->region_id);
                $arr_region_cities[$city->region_id]['region_title'] = $region->title;
                $arr_region_cities[$city->region_id]['cities'] = [];
            }
            $arr_region_cities[$city->region_id]['cities'][] = $city->title;
        }
        $collator = collator_create('uk_UA'); // Створюємо колатор для української мови
        collator_sort($collator, $arr_region_cities); // Виконуємо сортування

        $deliveries = Delivery::all();
        $payment_kinds = KindPayment::all();

        return view('orders.create', [
            'cartItems' => $cartItems,
            'countries' => $countries,
            'arr_cities' => $arr_cities,
            'arr_region_cities' => $arr_region_cities,
            'user' => $user,
            'address' => $address,
            'user_email' => $user_email,
            'deliveries' => $deliveries,
            'payment_kinds' => $payment_kinds,
        ]);
    }

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
        if($user->category_user_id == 5){
            $user->category_user_id = 4;
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

//        Cookie::queue('user_id', $user->id, 60); // 60 - це час у хвилинах, на який ви хочете встановити куку

        $cart = Cart::query()
            ->where('user_id', $user_id)
            ->where('active', 1)
            ->latest()  // Сортування за спаданням дати створення
            ->first();
        $cart->active = 0;
        $cart->save();

        $order = new Order();
        $order->user_id =  $user_id;
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
            $product_name = $product->title;
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

//        Mail::to($user->email)->send(new OrderConfirmation($data_user));
//
//        Mail::to('bulic2@ukr.net')->send(new OrderConfirmation($admin_data));

        session()->forget('cart'); // Видаляє лише ключ 'cart'
        if($user->role_id < 5){
            return redirect(route('admin_users.show', ['admin_user' => $user->id]).'#orders');
        } else {
            return redirect(route('users.show', ['user' => $user->id]).'#orders');
        }
    }

    public function show($id)
    {
//        $user_id = $request->input('user_id');

        $cartItems = CartItems::query()
            ->join('carts', 'cart_items.cart_id', '=', 'carts.id')
            ->join('orders', 'carts.id', '=', 'orders.cart_id')
            ->where('orders.id', $id)
            ->get();

        $order = Order::query()->where('id', $id)->first();

        return view('orders.show', compact('order', 'cartItems'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
