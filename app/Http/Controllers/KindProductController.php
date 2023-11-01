<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KindProduct;
use App\Models\Product;
use App\Models\SubKindProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KindProductController extends Controller
{
//    public function index()
//    {
//        $kind_products = KindProduct::query()->with('product')->orderBy('id')->get();
//        $sub_kind_products = SubKindProduct::all();
//        return view('admin.kind_products.index',[
//            "kind_products" => $kind_products,
//            "sub_kind_products" => $sub_kind_products,
//        ]);
//    }

//    public function store(Request $request)
//    {
//        $validated = $request->validate([
//            'name' => 'required|unique:kind_products|max:35',
//        ]);
//
//        $product_id = $request->input('product_id');
//        $kind_product = new KindProduct();
//        $kind_product->name = $request->post('name');
//        $kind_product->active = 0;
//
//        $kind_product->save();
//        $kind_product_id = $kind_product->id;
//// TODO відправка email адміну про запит на підтвердження
//        return redirect(route('products.edit', ['product' => $product_id]));
//    }

//    public function show($id)
//    {
//        $kind_product= KindProduct::query()->with('product')
//            ->where('id',$id)->first();
//        $sub_kind_products = SubKindProduct::query()->where('kind_product_id',$kind_product->id)->get();
//        return view('admin.kind_products.show',[
//            'kind_product' => $kind_product,
//            'sub_kind_products' => $sub_kind_products,
//        ]);
//    }
}
