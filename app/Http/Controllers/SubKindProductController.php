<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KindProduct;
use App\Models\SubKindProduct;
use Illuminate\Http\Request;

class SubKindProductController extends Controller
{
//    public function index(Request $request)
//    {
//        $kind_product_id = $request->input('kind_product_id');
//        $kind_products = KindProduct::all();
//        if($kind_product_id){
//            $sub_kind_products = SubKindProduct::query()->with('kind_product')->where('kind_product_id',$kind_product_id)->orderBy('id')->get();
//            $KindProduct = KindProduct::find($kind_product_id);
//            return view('admin.sub_kind_products.index', compact('KindProduct','kind_products', 'sub_kind_products'));
//        } else {
//            $sub_kind_products = SubKindProduct::query()->with('kind_product')->orderBy('id')->get();
//            return view('admin.sub_kind_products.index', [
//                "sub_kind_products" => $sub_kind_products,
//                'kind_products' => $kind_products,
//
//            ]);
//        }
//    }
//
//    public function create(Request $request)
//    {
//        $kind_product_id = $request->input('kind_product_id');
//        $kind_products = KindProduct::all();
//        if($kind_product_id){
//            $KindProduct = KindProduct::find($kind_product_id);
//            return view('admin.sub_kind_products.create', compact('KindProduct','kind_products'));
//        } else {
//            return view('admin.sub_kind_products.create', [
//                'kind_products' => $kind_products,
//            ]);
//        }
//    }
//
//    public function store(Request $request)
//    {
//        $validated = $request->validate([
//            'name' => 'required|unique:sub_kind_products|max:35',
//            'kind_product_id' => 'required',
//        ]);
//        $sub_kind_product = new SubKindProduct();
//        $sub_kind_product->name = $request->post('name');
//        $sub_kind_product->kind_product_id = $request->post('kind_product_id');
//
//        $sub_kind_product->save();
//
//        return redirect(route('sub_kind_products.index'));
//    }
//
//    public function show($id)
//    {
//        $sub_kind_product= SubKindProduct::query()->with('kind_product')
//            ->where('id',$id)->first();
//        return view('admin.sub_kind_products.show',[
//            'sub_kind_product' => $sub_kind_product,
//        ]);
//    }
}
