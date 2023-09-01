<?php

namespace App\Http\Controllers;

use App\Models\KindProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->with('kind_product')->orderBy('id', 'desc')->get();
        $kindProducts = KindProduct::all();
        return view('products.index', compact('products', 'kindProducts'));
//        return view('products.index',[
//            "products" => $products,
//            "kindProducts" => $kindProducts,
//        ]);
    }

    public function create()
    {
        $kind_products = KindProduct::all();
        return view('products.create', [
            'kind_products' => $kind_products,
        ]);
    }

    public function show($id)
    {
        $product = Product::query()->with('kind_product')->with('user')->where('id',$id)->first();
        return view('products.show',[
            'product' => $product,
        ]);
    }

//    public function indexProductsKindId($id)
//    {
//        $products = Product::query()->with('kind_product')->with('user')->where('kind_product_id',$id)->get();
//        return view('products.index', compact('products'));
//    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $validated = $request->validate([
            'name' => ['required', 'unique:products', 'regex:/^[^<>$%\/\\\[\]\^{|}]*$/i'],
            'kind_product_id' => 'required',
            'content' => 'required',
            'price' => 'required',
        ], $messages = [
            'required' => ':attribute является обязательным полем.',
        ]);

        $product = new Product();
        $product->name = $request->post('name');
        $product->kind_product_id = $request->post('kind_product_id');
        $product->content = $request->post('content');
        $product->price = $request->post('price');
        $product->stock_balance = $request->post('stock_balance');
        $product->user_id = $user->id;   // авторизований користувач
        $product->created_at = date("Y-m-d H:i:s");

        $product->save();

        return redirect(route('products.index'));
    }

    public function edit($id)
    {
        $product = Product::query()->with('kind_product')->where('id',$id)->first();
        $kind_products = KindProduct::pluck('name', 'id');
        if(!$product){
            throw new \Exception('Product not found');
        }
        return view('products.edit', [
            'product' => $product,
            'kind_products' => $kind_products,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:products|alpha_dash:ascii',
            'kind_product_id' => 'required',
            'content' => 'required',
            'price' => 'required',
        ], $messages = [
            'required' => ':attribute является обязательным полем.',
        ]);

        $product = Product::query()->with('kind_product')->where('id',$id)->first();
        if(!$product){
            throw new \Exception('User not found');
        }
        $product->name = $request->post('name');
        $product->kind_product_id = $request->post('kind_product_id');
        $product->content = $request->post('content');
        $product->price = $request->post('price');
        $product->stock_balance = $request->post('stock_balance');
        $product->user_id = "2";   // авторизований користувач
        $product->created_at = date("Y-m-d H:i:s");

        $product->save();

        return redirect( route('products.show', ['product' => $id]));
    }

    public function destroy($id)
    {
        $product = Product::query()->where('id',$id)->delete();
        return redirect( route('products.index'));
    }

    public function search(Request $request)
    {
        $search = $request->input('query');
        $products = Product::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('id', 'LIKE', "%{$search}%")
            ->orWhere('content', 'LIKE', "%{$search}%")
            ->get();
        $kindProducts = KindProduct::all();
        return view('home', compact('products', 'kindProducts'));

//        return view('products.index', compact('products', 'kindProducts'));
    }

    public function kindfilter(Request $request)
    {
        $query = Product::query();
        if ($request->has('kind_product_id')) {
            $query->where('kind_product_id', $request->input('kind_product_id'));
        }
        $products = $query->paginate(10);
        $kindProducts = KindProduct::all();

        return view('home', compact('products', 'kindProducts'));

//        return view('products.index', compact('products', 'kindProducts'));
    }




}
