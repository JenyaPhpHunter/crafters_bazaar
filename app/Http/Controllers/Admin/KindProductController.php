<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KindProduct;
use App\Models\SubKindProduct;
use Illuminate\Http\Request;

class KindProductController extends Controller
{
    public function index()
    {
        $kind_products = KindProduct::query()->with('products')->orderBy('id')->get();
        $sub_kind_products = SubKindProduct::all();
        return view('admin.kind_products.index',[
            "kind_products" => $kind_products,
            "sub_kind_products" => $sub_kind_products,
        ]);
    }

    public function create()
    {

        return view('admin.kind_products.create',[
            'excludeProducts' => true,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:kind_products|max:35',
        ]);


        $kind_product = new KindProduct();
        $kind_product->name = $request->post('name');
        $kind_product->user_id = $request->user_id;

        $kind_product->save();

        return redirect(route('admin_kind_products.index'));
    }

    public function show($id)
    {
        $kind_product= KindProduct::query()->with('products')
            ->where('id',$id)->first();
        $sub_kind_products = SubKindProduct::query()->where('kind_product_id',$kind_product->id)->get();
        return view('admin.kind_products.show',[
            'kind_product' => $kind_product,
            'sub_kind_products' => $sub_kind_products,
        ]);
    }

    public function edit($id)
    {
        $kind_product = KindProduct::query()->with('product')->where('id',$id)->first();
        if(!$kind_product){
            throw new \Exception('User not found');
        }
        return view('admin.kind_products.edit', ['kind_product' => $kind_product]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:kind_products|max:35',
        ]);

        $kind_product = KindProduct::query()->where('id',$id)->first();
        $kind_product->name = $request->post('name');

        $kind_product->save();

        return redirect( route('kind_products.show', ['kind_product' => $id]));
    }

    public function destroy($id)
    {
        $kind_product = KindProduct::query()->where('id',$id)->delete();
        return redirect( route('kind_products.index'));
    }
}
