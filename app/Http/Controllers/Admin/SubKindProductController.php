<?php

namespace App\Http\Controllers\Admin;

use App\Constants\ProductsConstants;
use App\Http\Controllers\Controller;
use App\Models\KindProduct;
use App\Models\SubKindProduct;
use App\Models\User;
use Illuminate\Http\Request;

class SubKindProductController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $kind_product_id = $request->input('kind_product_id');
        $kind_products = KindProduct::all();
        if($kind_product_id){
            $sub_kind_products = SubKindProduct::query()->with('kind_product')->where('kind_product_id',$kind_product_id)->orderBy('id')->get();
            $KindProduct = KindProduct::find($kind_product_id);
            return view('admin.sub_kind_products.index', compact('KindProduct','kind_products', 'sub_kind_products', 'user', 'not_checked'));
        } else {
            $not_checked = $request->input('not_checked');
            if ($not_checked){
                $sub_kind_products = SubKindProduct::query()->with('kind_product')->where('checked', 0)->orderBy('id')->get();
            } else {
                $sub_kind_products = SubKindProduct::query()->with('kind_product')->orderBy('id')->get();
            }

            return view('admin.sub_kind_products.index', compact('sub_kind_products', 'kind_products', 'user', 'not_checked'));
        }
    }

    public function create(Request $request)
    {
        $selected_kind_product_id = $request->input('kind_product_id');
        $action_types = ProductsConstants::ACTION_TYPES;
        $kind_products = KindProduct::all();

        return view('admin.sub_kind_products.create', compact('action_types', 'selected_kind_product_id', 'kind_products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:sub_kind_products|max:35',
            'kind_product_id' => 'required',
        ]);

        $sub_kind_product = new SubKindProduct();
        $sub_kind_product->name = $request->name;
        $sub_kind_product->kind_product_id = $request->kind_product_id;
        $sub_kind_product->user_id = $request->user_id;
        $sub_kind_product->checked = true;

        $sub_kind_product->save();

        return redirect(route('admin_sub_kind_products.index'));
    }

    public function show(Request $request, $id)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $sub_kind_product= SubKindProduct::query()->with('kind_product')
            ->where('id',$id)->first();
        return view('admin.sub_kind_products.show', compact('sub_kind_product','user'));
    }

    public function edit($id)
    {
        $sub_kind_product = SubKindProduct::query()->with('kind_product')->where('id',$id)->first();
        $kind_products = KindProduct::pluck('name', 'id');
        if(!$sub_kind_product){
            throw new \Exception('Subkind product not found');
        }
        $action_types = ProductsConstants::ACTION_TYPES;

        return view('admin.sub_kind_products.edit', compact('sub_kind_product', 'kind_products', 'action_types'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:sub_kind_products,name,'.$id,
            'kind_product_id' => 'required',
        ]);


        $sub_kind_product = SubKindProduct::query()->where('id',$id)->first();
        $sub_kind_product->name = $request->name;
        $sub_kind_product->kind_product_id = $request->kind_product_id;
        $sub_kind_product->checked = true;

        $sub_kind_product->save();

        return redirect( route('admin_sub_kind_products.show', ['admin_sub_kind_product' => $id]));
    }

    public function destroy($id)
    {
        $sub_kind_product = SubKindProduct::query()->where('id',$id)->delete();
        return redirect( route('sub_kind_products.index'));
    }
}
