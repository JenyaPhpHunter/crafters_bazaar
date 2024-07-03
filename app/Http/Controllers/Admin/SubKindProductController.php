<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KindProduct;
use App\Models\SubKindProduct;
use Illuminate\Http\Request;

class SubKindProductController extends Controller
{
    public function index(Request $request)
    {
        $kind_product_id = $request->input('kind_product_id');
        $kind_products = KindProduct::all();
        if($kind_product_id){
            $sub_kind_products = SubKindProduct::query()->with('kind_product')->where('kind_product_id',$kind_product_id)->orderBy('id')->get();
            $KindProduct = KindProduct::find($kind_product_id);
            return view('admin.sub_kind_products.index', compact('KindProduct','kind_products', 'sub_kind_products'));
        } else {
            $sub_kind_products = SubKindProduct::query()->with('kind_product')->orderBy('id')->get();
            return view('admin.sub_kind_products.index', [
                "sub_kind_products" => $sub_kind_products,
                'kind_products' => $kind_products,
                'excludeProducts' => true,
            ]);
        }
    }

    public function create(Request $request)
    {
//        $this->seedie($request->all());
        $kind_product_id = $request->input('admin_kind_product');
        $kind_products = KindProduct::all();
        if($kind_product_id){
            $KindProduct = KindProduct::find($kind_product_id);
            return view('admin.sub_kind_products.create', compact('KindProduct','kind_products'));
        } else {
            return view('admin.sub_kind_products.create', [
                'kind_products' => $kind_products,
                'excludeProducts' => true,
            ]);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:sub_kind_products|max:35',
            'kind_product_id' => 'required',
        ]);

        $sub_kind_product = new SubKindProduct();
        $sub_kind_product->name = $request->post('name');
        $sub_kind_product->kind_product_id = $request->post('kind_product_id');
        $sub_kind_product->user_id = $request->user_id;

        $sub_kind_product->save();

        return redirect(route('admin_sub_kind_products.index'));
    }

    public function show($id)
    {
        $sub_kind_product= SubKindProduct::query()->with('kind_product')
            ->where('id',$id)->first();
        return view('admin.sub_kind_products.show',[
            'sub_kind_product' => $sub_kind_product,
            'excludeProducts' => true,
        ]);
    }

    public function edit($id)
    {
        $sub_kind_product = SubKindProduct::query()->with('kind_product')->where('id',$id)->first();
        $kind_products = KindProduct::pluck('name', 'id');
        if(!$sub_kind_product){
            throw new \Exception('Subkind product not found');
        }
        return view('admin.sub_kind_products.edit', [
            'sub_kind_product' => $sub_kind_product,
            'kind_products' => $kind_products,
            'excludeProducts' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
//        $validated = $request->validate([
//            'name' => 'required|unique:kind_products|max:35',
//            'kind_product_id' => 'required',
//        ]);
        $validated = $request->validate([
            'name' => 'required|unique:sub_kind_products,name,'.$id,
            'kind_product_id' => 'required',
        ]);


        $sub_kind_product = SubKindProduct::query()->where('id',$id)->first();
        $sub_kind_product->name = $request->post('name');
        $sub_kind_product->kind_product_id = $request->post('kind_product_id');

        $sub_kind_product->save();

        return redirect( route('sub_kind_products.show', ['sub_kind_product' => $id, 'excludeProducts' => true]));
    }

    public function destroy($id)
    {
        $sub_kind_product = SubKindProduct::query()->where('id',$id)->delete();
        return redirect( route('sub_kind_products.index'));
    }
}
