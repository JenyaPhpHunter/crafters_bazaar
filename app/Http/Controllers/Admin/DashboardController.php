<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminOrder;
use App\Models\Basket;
use App\Models\KindProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\StatusOrder;
use App\Models\SubKindProduct;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        $orders = AdminOrder::all();
        $statuses_orders = StatusOrder::all();
        $roles = Role::all();
        $kind_products = KindProduct::all();
        $sub_kind_products = SubKindProduct::all();
        $products = Product::all();
        return view('admin.dashboard',[
            "users" => $users,
            "orders" => $orders,
            "statuses_orders" => $statuses_orders,
            "roles" => $roles,
            "kind_products" => $kind_products,
            "sub_kind_products" => $sub_kind_products,
            "products" => $products,
            'excludeProducts' => true,
        ]);
    }
}
