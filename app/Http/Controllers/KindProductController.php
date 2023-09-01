<?php

namespace App\Http\Controllers;

use App\Models\KindProduct;
use Illuminate\Http\Request;

class KindProductController extends Controller
{
    public function index()
    {
        $kind_products = KindProduct::query()->with('product')->orderBy('id')->get();
        return view('kind_products.index',[
            "kind_products" => $kind_products,
        ]);
    }

    public function create()
    {
        return view('kind_products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:kind_products|max:35',
        ]);

        $kind_product = new KindProduct();
        $kind_product->name = $request->post('name');

        $kind_product->save();

        return redirect(route('kind_products.index'));
    }

    public function show($id)
    {
        $kind_product= KindProduct::query()->with('product')
            ->where('id',$id)->first();
        return view('kind_products.show',[
            'kind_product' => $kind_product,
        ]);
    }

    public function edit($id)
    {
        $kind_product = KindProduct::query()->with('product')->where('id',$id)->first();
        if(!$kind_product){
            throw new \Exception('User not found');
        }
        return view('kind_products.edit', ['kind_product' => $kind_product]);
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
