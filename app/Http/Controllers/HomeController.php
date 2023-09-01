<?php

namespace App\Http\Controllers;

use App\Models\KindProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function welcome()
    {
        $user = Auth::user();
        $products = Product::all();
        $kindProducts = KindProduct::all();
        return view('welcome',[
            "products" => $products,
            "kindProducts" => $kindProducts,
            "user" => $user,
        ]);
    }
}
