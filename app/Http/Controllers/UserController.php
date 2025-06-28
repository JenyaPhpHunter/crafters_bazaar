<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\City;
use App\Models\Delivery;
use App\Models\KindPayment;
use App\Models\Order;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function show($id)
    {
        $user = User::query()->with('role')
            ->with('delivery')
            ->with('kindpayment')
            ->with('region')
            ->with('city')
            ->where('id',$id)->first();
        $orders = Order::query()->where('user_id', $user->id)->with('status_order')->get();

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
        $addressParts = explode(', ', $user->address);
        $address = [
            'street' => $addressParts[0] ?? null,
            'home' => $addressParts[1] ?? null,
            'apartment' => $addressParts[2] ?? null,
        ];
        return view('users.show',[
            'user' => $user,
            'orders' => $orders,
            'arr_cities' => $arr_cities,
            'arr_region_cities' => $arr_region_cities,
            'address' => $address,
        ]);
    }
    public function edit($id)
    {
        $user = User::query()->where('id',$id)->first();
        if(!$user){
            throw new \Exception('User not found');
        }
        $deliveries = Delivery::pluck('name', 'id');
        $kind_payments = KindPayment::pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        return view('users.edit', [
            'user' => $user,
            "deliveries" => $deliveries,
            "payment_kinds" => $kind_payments,
            "roles" => $roles,
        ]);
    }

    public function update(Request $request)
    {
        $user_id = $request->post('user_id');
        $address = filter_var($request->input('address'), FILTER_VALIDATE_BOOLEAN);
        $user = User::query()->where('id',$user_id)->first();
        if ($address) {
            $validated = Validator::make($request->all(), [
                'region' => 'required',
                'city' => 'required',
                'street' => 'required',
                'home' => 'required',
            ]);
            if ($validated->fails()) {
                return redirect()
                    ->route('users.show', ['user' => $user_id])
                    ->withErrors($validated)
                    ->withInput()
                    ->with('activeTab', 'address');
            }

            $region = Region::query()->where('title', $request->input('region'))->first();
            $user->region_id = $region->id;
            $city = City::query()->where('title', $request->input('city'))->first();
            $user->city_id = $city->id;
            $addressParts = [
                $request->post('street'),
                $request->post('home'),
                $request->post('apartment') ? 'кв. ' . $request->post('apartment') : null,
            ];

            $user->address = implode(', ', array_filter($addressParts));

            $user->save();
        } else {
            $validated = Validator::make($request->all(), [
                'name' => 'required',
                'surname' => 'required',
                'phone' => 'required',
                'email' => 'required',
            ]);
            if ($validated->fails()) {
                return redirect()
                    ->route('users.show', ['user' => $user_id])
                    ->withErrors($validated)
                    ->withInput()
                    ->with('activeTab', 'account-info');
            }
            if($request->post('password')){
                $user->password =  Hash::make($request->post('password'));
            }
            $user->forceFill([
                'name' => $request->post('name') ?? $user->name,
                'surname' => $request->post('surname') ?? $user->surname,
                'secondname' => $request->post('secondname') ?? $user->secondname,
                'phone' => $request->post('phone') ?? $user->phone,
                'email' => $request->post('email') ?? $user->email,
            ]);

            $user->save();
        }

        $previous_page = $request->post('previous_page', route('products.index')); // За замовчуванням на список товарів
        return redirect()->to($previous_page)->with('success', 'Дані користувача успішно оновлено!');
    }

    public function searchusers(Request $request)
    {
        $search = $request->input('query');
        $users = User::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();
        return view('users.index', compact('users'));
    }

    public function toggleSubscriptionStatus(Request $request)
    {
        $email = $request->input('email');
        $user = User::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->first();

        if (!$user) {
            $user = new User();
            $user->email = $email;
            $user->password = Hash::make(random_int(10000000, 99999999));
            $user->is_subscribed = true;
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();
        } else {
            // Перемикаємо статус підписки
            $user->is_subscribed = !$user->is_subscribed;
            $user->save();
        }
        return redirect()->back()->with(
            'success',
            $user->is_subscribed ? 'Ви успішно підписалися!' : 'Ви успішно відписалися!'
        );
    }
}
