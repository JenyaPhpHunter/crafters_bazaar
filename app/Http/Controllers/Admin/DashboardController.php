<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KindProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $products = Product::all();
        $kindProducts = KindProduct::all();
        return view('admin.dashboard',[
            "products" => $products,
            "kindProducts" => $kindProducts,
            "user" => $user,
        ]);
    }
}
