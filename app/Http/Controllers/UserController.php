<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Delivery;
use App\Models\KindPayment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function showSeller($id)
    {
        $user = User::query()->with('role')->with('delivery')->with('paymentkind')
            ->where('id',$id)->first();
        return view('users.show_seller',[
            'user' => $user,
            'excludeProducts' => true,
        ]);
    }

    public function showBuyer($id)
    {
        $user = User::query()->with('role')->with('delivery')->with('paymentkind')
            ->where('id',$id)->first();
        return view('users.show_buyer',[
            'user' => $user,
            'excludeProducts' => true,
        ]);
    }

    public function show($id)
    {
        $user = User::query()->with('role')->with('delivery')->with('paymentkind')
            ->where('id',$id)->first();
        return view('users.show',[
            'user' => $user,
            'excludeProducts' => true,
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
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
                ->route('users.show_seller', ['user' => $user_id, '#account-info'])
                ->withErrors($validated)
                ->withInput();
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

        //        echo "<pre>";
//        print_r($validated->fails());
//        echo "</pre>";
//        die();
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

    public function basketItems()
    {
//    Витягуємо всі товари, що додані в корзину для поточного користувача з таблиці basket.
//        Завантажуємо пов'язану модель product з таблиці products для кожного товару з кошика, використовуючи метод with().
        $basketItems = Basket::where('user_id', auth()->id())->with('product')->get();
//        Обчислюємо загальну ціну всіх товарів в корзині, знаходячи добуток кількості товару на ціну з урахуванням знижки для кожного товару в корзині.
        $totalPrice = $basketItems->sum(function ($item) {
            return $item->quantity * $item->pricediscount;
        });
//        Обчислюємо загальну знижку, знаходячи добуток знижки на кількість товару для кожного товару в корзині.
        $discount = $basketItems->sum(function ($item) {
            return $item->discount * $item->quantity;
        });
//        Обчислюємо загальну суму з урахуванням знижки, віднімаючи загальну знижку від загальної ціни.
        $total = $totalPrice - $discount;
//        Повертаємо вид, який відображає всі товари в корзині та загальну ціну, знижку та загальну суму.
        return view('basket.index', compact('basketItems', 'totalPrice', 'discount', 'total'));
    }
}
