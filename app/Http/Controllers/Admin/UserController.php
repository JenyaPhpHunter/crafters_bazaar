<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryUser;
use App\Models\City;
use App\Models\Delivery;
use App\Models\KindPayment;
use App\Models\KindProduct;
use App\Models\Product;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $products = Product::all();
        $users = User::query()->with('role','category_user')->where('del', 0)->orderBy('id', 'desc')->get();

        return view('admin.users.index',[
            "users" => $users,
            "products" => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    protected function create()
    {
        $user = Auth::user();
//        $deliveries = Delivery::all();
//        $kind_payments = KindPayment::all();
        $roles = Role::where('id', '>', $user->role_id)->get();
        $categories_user = CategoryUser::where('id', '>', $user->category_user_id)->get();

        $products = Product::all();
//        $kindProducts = KindProduct::all();
//        $countries = [
//            'UA' => 'Україна',
//            'PL' => 'Польща',
//            'UK' => 'Англія',
//        ];
//        $cities = City::all();
//        $arr_cities = [];
//        $arr_region_cities = [];
//        foreach ($cities as $city) {
//            $arr_cities[] = $city->name;
//            if (!isset($arr_region_cities[$city->region_id])) {
//                $region = Region::query()->find($city->region_id);
//                $arr_region_cities[$city->region_id]['region_name'] = $region->name;
//                $arr_region_cities[$city->region_id]['cities'] = [];
//            }
//            $arr_region_cities[$city->region_id]['cities'][] = $city->name;
//        }
//        $collator = collator_create('uk_UA'); // Створюємо колатор для української мови
//        collator_sort($collator, $arr_region_cities); // Виконуємо сортування

        return view('admin.users.create', [
//            'countries' => $countries,
//            'arr_cities' => $arr_cities,
//            'arr_region_cities' => $arr_region_cities,
//            "deliveries" => $deliveries,
//            "payment_kinds" => $kind_payments,
            "categories_user" => $categories_user,
            "roles" => $roles,
            "products" => $products,
//            "kindProducts" => $kindProducts,
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
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'phone' => 'required',
            'role_id' => 'required',
            'category_user_id' => 'required',
        ]);

        $user = new User();
        $user->name = $request->post('name');
        $user->secondname = $request->post('secondname');
        $user->surname = $request->post('surname');
        $user->email = $request->post('email');
        $user->password =  Hash::make($request->post('password'));
        $user->phone = $request->post('phone');
        $user->role_id = $request->post('role_id');
        $user->category_user_id = $request->post('category_user_id');
        $user->created_at = date("Y-m-d H:i:s");
//        $user->city = $request->post('city');
//        $user->address = $request->post('address');
//        $user->delivery_id = $request->post('delivery_id');
//        $user->paymentkind_id = $request->post('paymentkind_id');

        $user->save();

        return redirect(route('admin_users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $auth_user = Auth::user();
        $user = User::query()->where('id',$id)->first();
        if(!$user){
            throw new \Exception('User not found');
        }
        $roles = Role::where('id', '>', $auth_user->role_id)->get();
        $categories_user = CategoryUser::where('id', '>', $auth_user->category_user_id)->get();
        $products = Product::all();

        return view('admin.users.show', [
            "user" => $user,
            "categories_user" => $categories_user,
            "roles" => $roles,
            "products" => $products,
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
        $auth_user = Auth::user();
        $user = User::query()->where('id',$id)->first();
        if(!$user){
            throw new \Exception('User not found');
        }
        $roles = Role::where('id', '>', $auth_user->role_id)->get();
        $categories_user = CategoryUser::where('id', '>', $auth_user->category_user_id)->get();
        $products = Product::all();

//        echo $user->id; die();
        return view('admin.users.edit', [
            "user" => $user,
            "categories_user" => $categories_user,
            "roles" => $roles,
            "products" => $products,
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
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|unique:users,email,'.$id, // Унікальний email з виключенням поточного користувача
            'phone' => 'required',
            'role_id' => 'required',
            'category_user_id' => 'required',
        ]);

        $user = User::find($id);

        $user->name = $request->post('name');
        $user->secondname = $request->post('secondname');
        $user->surname = $request->post('surname');
        $user->email = $request->post('email');
        $user->phone = $request->post('phone');
        $user->role_id = $request->post('role_id');
        $user->category_user_id = $request->post('category_user_id');
        $user->created_at = date("Y-m-d H:i:s");
        if ($request->filled('password')) {
            $user->password = Hash::make($request->post('password'));
        }

        $user->save();

        return redirect(route('admin_users.index'))->with('success', 'Користувача успішно оновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $user = User::query()->where('id',$id)->first();
        $user->del = 1;
        $user->save();
        return redirect(route('admin_users.index'))->with('success', 'Користувача успішно видалено');
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

    public function getDetails($id)
    {
        $user = User::query()->with('role')->with('delivery')->with('kindpayment')
            ->where('id',$id)->first();
        $products = Product::all();
//        echo $user->id; die();
        return view('admin.users.details',[
            'user' => $user,
            'products' => $products,
        ]);
    }

//    public function choiceSellerAdmin()
//    {
//        $seller_admin = User::query()::where('role_id', 3)->first();
//
//        return $seller_admin;
//    }

}
