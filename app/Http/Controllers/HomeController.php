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
        return view('welcome',[
            "products" => $products,
            "user" => $user,
        ]);
    }
}
