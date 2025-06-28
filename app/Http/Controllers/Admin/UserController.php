<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryUser;
use App\Models\City;
use App\Models\Delivery;
use App\Models\KindPayment;
use App\Models\KindProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Support\Collection
     */
    public function index(Request $request)
    {
//        $this->seedie($request->all());
        $role_id = $request->input('role_id');
        if ($role_id){
            $query = User::query()->with(['role', 'category_user'])->where('role_id', $role_id)->whereNull('deleted_at')->orderBy('id', 'desc');
        } else {
            $query = User::query()->with(['role', 'category_user'])->whereNull('deleted_at')->orderBy('id', 'desc');
        }

        $users = $this->filter($query, $request)->get();
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $roles = Role::where('id', '>=', $user->role_id)->get();
        $categories = CategoryUser::where('id', '>=', $user->category_user_id)->get();

        $filters = $request->only([
            'pib',
            'email',
            'phone',
            'role_id',
            'category_user_id'
        ]);
        $filters['role_id'] = (array) ($filters['role_id'] ?? []);
        $filters['category_user_id'] = (array) ($filters['category_user_id'] ?? []);

        return view('admin.users.index',compact('users','roles', 'categories', 'filters'));
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
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereNull('deleted_at')
            ],
            'phone' => 'required',
            'role_id' => 'required',
            'category_user_id' => 'required',
        ]);

        $password = Str::random(7);

        $user = new User();
        $user->name = $request->post('name');
        $user->secondname = $request->post('secondname');
        $user->surname = $request->post('surname');
        $user->email = $request->post('email');
        $user->password = Hash::make($password);
        $user->phone = $request->post('phone');
        $user->role_id = $request->post('role_id');
        $user->category_user_id = $request->post('category_user_id');
        $user->created_at = date("Y-m-d H:i:s");
//        $user->city = $request->post('city');
//        $user->address = $request->post('address');
//        $user->delivery_id = $request->post('delivery_id');
//        $user->paymentkind_id = $request->post('paymentkind_id');

        $user->save();
        $email = $user->email;
        $sendEmail = new EmailService();
        $title = 'Вам створено користувача';
        $content = 'Ваш логін: ' . $email . "<br>" . 'Ваш пароль: ' . $password;

        try {
            $sendEmail->sendEmail($email, $title, $content);
             Log::info('Лист успішно відправлено', ['email' => $email]);
        } catch (\Exception $e) {
             Log::error('Помилка відправки листа', [
                 'email' => $email,
                 'error' => $e->getMessage(),
                 'trace' => $e->getTraceAsString() // Опціонально (для детального дебагу)
             ]);
             session()->flash('warning', 'Лист не вдалося відправити, але акаунт створено');
        }

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
        $user->deleted_at = now();
        $user->save();
        $email = $user->email;
        $sendEmail = new EmailService();
        $title = 'Вашого користувача видалено';
        $content = 'Вашого користувача з логіном ' . $email .
            ' видалено.' . '<br>' . ' Ви можете повторно зареєструватись на нашому сайті' .
            env('APP_URL');

        try {
            $sendEmail->sendEmail($email, $title, $content);
            Log::info('Лист успішно відправлено', ['email' => $email]);
        } catch (\Exception $e) {
            Log::error('Помилка відправки листа', [
                'email' => $email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString() // Опціонально (для детального дебагу)
            ]);
            session()->flash('warning', 'Лист не вдалося відправити, але акаунт створено');
        }
        return redirect(route('admin_users.index'))->with('success', 'Користувача успішно видалено');
    }

    public function sellersBuyers(Request $request)
    {
        $role_id = $request->input('role_id');
        $category_user_id = $request->input('category_user_id');
        $query_users = User::query()->whereNull('deleted_at');
        if ($role_id && $category_user_id){
            $users = $query_users->where('role_id', $role_id)->where('category_user_id', $category_user_id)->get();
        } else {
            $users = $query_users->where('role_id', '>', 4)->where('category_user_id', '>', 2)->get();
        }

        return view('admin.sellers_buyers.index', compact('users'));
    }

    public function searchusers(Request $request)
    {
        $search = $request->input('query');
        $users = User::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();
        return view('admin.users.index', compact('users'));
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

    protected function filter($query, $request)
    {
        return $query
            // Фільтр за ПІБ (наприклад, фільтр по суміщеному полю)
            ->when($request->input('pib'), function ($query, $pib) {
                $query->whereRaw("CONCAT(surname, ' ', name, ' ', secondname) LIKE ?", ["%$pib%"]);
            })
            // Фільтр за email
            ->when($request->input('email'), function ($query, $email) {
                $query->where('email', 'like', "%{$email}%");
            })
            // Фільтр за телефоном
            ->when($request->input('phone'), function ($query, $phone) {
                $query->where('phone', 'like', "%{$phone}%");
            })
            // Фільтр за роль
            ->when($request->input('role_id'), function ($query, $role_id) {
                $query->where('role_id', $role_id);
            })
            // Фільтр за категорію користувача
            ->when($request->input('category_user_id'), function ($query, $category_user_id) {
                $query->where('category_user_id', $category_user_id);
            });
    }

}
