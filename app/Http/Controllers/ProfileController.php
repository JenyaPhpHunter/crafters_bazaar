<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Delivery;
use App\Models\PaymentKind;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showProfile($id)
    {
//        $user = Auth::user();
        $user = User::query()->where('id',$id)->first();
        $baskets = Basket::query()
            ->where('user_id', $id)
            ->where('order_id', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();
        $baskets_without_order = Basket::query()
            ->where('user_id', $id)
            ->where('order_id', NULL)
            ->orderBy('id', 'desc')
            ->get();
        $deliveries = Delivery::all();
        $payment_kinds = PaymentKind::all();
        $sum_baskets_without_order = 0;
        if($baskets_without_order){
            foreach ($baskets_without_order as $basket_without_order){
                $sum_baskets_without_order +=$basket_without_order->sum;
            }
        }

        return view('auth.profile',[
            "user" => $user,
            "baskets_without_order" => $baskets_without_order,
            "sum_baskets_without_order" => $sum_baskets_without_order,
            "baskets" => $baskets,
            "deliveries" => $deliveries,
            "payment_kinds" => $payment_kinds,
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::query()->where('id',$id)->first();
        $user->email = $request->post('email');
        if($request->post('password')){
            $user->password =  Hash::make($request->post('password'));
        }
        $user->name = $request->post('name');
        $user->surname = $request->post('surname');
        $user->secondname = $request->post('secondname');
        $user->phone = $request->post('phone');
        $user->city = $request->post('city');
        $user->address = $request->post('address');
        $user->delivery_id = $request->post('delivery_id');
        $user->paymentkind_id = $request->post('paymentkind_id');
        $user->created_at = date("Y-m-d H:i:s");

        $user->save();

        return redirect( route('showprofile', ['user' => $id]));
    }
}
