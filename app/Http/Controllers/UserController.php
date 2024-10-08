<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Delivery;
use App\Models\KindPayment;
use App\Models\Order;
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

        return view('users.show',[
            'user' => $user,
            'orders' => $orders,
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

    public function update(Request $request, $id)
    {
        $user_id = $request->post('user_id');
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        if ($validated->fails()) {
            return redirect()
                ->route('users.show', ['user' => $user_id, '#account-info'])
                ->withErrors($validated)
                ->withInput()
                ->with('hash', '#account-info');  // Додаємо цей рядок для збереження хешу
        }

        $user = User::query()->where('id',$user_id)->first();
        $user->email = $request->post('email');
        if($request->post('password')){
            $user->password =  Hash::make($request->post('password'));
        }
        $user->name = $request->post('name');
        $user->surname = $request->post('surname');
        $user->secondname = $request->post('secondname');
        $user->phone = $request->post('phone');
        $user->email = $request->post('email');

        $user->save();

        return redirect( route('welcome'));
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
}
