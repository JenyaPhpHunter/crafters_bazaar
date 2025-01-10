<?php

namespace App\Http\Controllers\Admin;

use App\Constants\OthersConstants;
use App\Constants\ProductsConstants;
use App\Http\Controllers\Controller;
use App\Models\KindProduct;
use App\Models\SubKindProduct;
use App\Models\User;
use App\Services\UrlService;
use Illuminate\Http\Request;

class KindProductController extends Controller
{

    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $not_checked = $request->input('not_checked');
        if ($not_checked){
            $kind_products = KindProduct::query()->with('sub_kind_products')->where('checked', 0)->orderBy('id')->get();
        } else {
            $kind_products = KindProduct::query()->with('sub_kind_products')->orderBy('id')->get();
        }
        $sub_kind_products = SubKindProduct::all();

        return view('admin.kind_products.index',compact('kind_products','sub_kind_products', 'user'));
    }

    public function create()
    {
        $action_types = ProductsConstants::ACTION_TYPES;
        return view('admin.kind_products.create',[
            'action_types' => $action_types,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:kind_products|max:35',
        ]);

        $kind_product = new KindProduct();
        $kind_product->title = $request->post('title');
        $kind_product->user_id = $request->user_id;
        $kind_product->checked = true;

        $kind_product->save();

        return redirect(route('admin_kind_products.index'));
    }

    public function show(Request $request,$id)
    {
        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $kind_product= KindProduct::query()->with('sub_kind_products')
            ->where('id',$id)->first();

        return view('admin.kind_products.show',[
            'kind_product' => $kind_product,
            'user' => $user,
        ]);
    }

    public function edit($id)
    {
        $kind_product = KindProduct::query()->with('sub_kind_products')->where('id',$id)->first();
        if(!$kind_product){
            throw new \Exception('User not found');
        }
        $action_types = ProductsConstants::ACTION_TYPES;

        return view('admin.kind_products.edit', compact('kind_product', 'action_types'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|unique:kind_products,title,' . $id . '|max:35',
        ]);

        $kind_product = KindProduct::query()->where('id',$id)->first();
        $kind_product->title = $request->title;
        $kind_product->user_id = $request->user_id;
        $kind_product->checked = true;

        $kind_product->save();

        return redirect( route('admin_kind_products.index'))
            ->with('success', 'Вид товару успішно затверджено');
    }

    public function destroy($id)
    {
        $kind_product = KindProduct::query()->where('id',$id)->delete();
        return redirect( route('admin_kind_products.index'));
    }
}
