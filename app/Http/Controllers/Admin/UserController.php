<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Basket;
use App\Models\Delivery;
use App\Models\KindPayment;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Support\Collection
     */
    public function index()
    {
        $users = User::query()->with('role')->orderBy('id', 'desc')->get();

        return view('admin.users.index',[
            "users" => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    protected function create()
    {
        $deliveries = Delivery::all();
        $kind_payments = KindPayment::all();
        $roles = Role::all();

        return view('admin.users.create', [
            "deliveries" => $deliveries,
            "payment_kinds" => $kind_payments,
            "roles" => $roles,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'created_at' => 'nullable|date_format:Y-m-d H:i:s',
            'role_id' => 'required',
        ]);

        $user = new User();
        $user->email = $request->post('email');
        $user->password =  Hash::make($request->post('password'));
        $user->name = $request->post('name');
        $user->surname = $request->post('surname');
        $user->secondname = $request->post('secondname');
        $user->phone = $request->post('phone');
        $user->city = $request->post('city');
        $user->address = $request->post('address');
        $user->delivery_id = $request->post('delivery_id');
        $user->paymentkind_id = $request->post('paymentkind_id');
        $user->created_at = date("Y-m-d H:i:s");
        $user->role_id = $request->post('role_id');

        $user->save();

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::query()->with('role')->with('delivery')->with('paymentkind')
            ->where('id',$id)->first();
        $products = Product::all();
        return view('admin.users.show',[
            'user' => $user,
            'products' => $products,
            'excludeProducts' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::query()->where('id',$id)->first();
        if(!$user){
            throw new \Exception('User not found');
        }
        $deliveries = Delivery::pluck('name', 'id');
        $kind_payments = KindPayment::pluck('name', 'id');
        $roles = Role::pluck('name', 'id');
        return view('admin.users.edit', [
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
        $validated = $request->validate([
            'email' => 'required',
            'role_id' => 'required',
        ]);

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
        $user->role_id = $request->post('role_id');

        $user->save();

        return redirect( route('showprofile', ['user' => $id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $user = User::query()->where('id',$id)->delete();
        return redirect( route('admin.users.index'));
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
