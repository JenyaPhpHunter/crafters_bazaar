<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductPhotoController;
use App\Mail\NewProductMail;
use App\Mail\SentSaleProductMail;
use App\Models\Color;
use App\Models\KindProduct;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\SubKindProduct;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::query()
            ->with('kind_product')
            ->with('productphotos')
            ->where('status_product_id', 3)
            ->get();
        $featured_products = Product::query()->with('productphotos')->where('featured',1)->get();

        $products = $products->sortByDesc(function ($product) {
            return $product->stock_balance == 0 ? -1 : $product->id;
        });
        $kind_products = KindProduct::query()
            ->join('products', 'kind_products.id', '=', 'products.kind_product_id')
            ->where('products.status_product_id', '=', 3)
            ->select('kind_products.id', 'kind_products.name', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.name')
            ->get();
        $colors = Color::all();
        $all_kind_products = KindProduct::all();
        $excludeProducts = true;

        return view('admin.products.index',
            compact(
                'products',
                'kind_products',
                'all_kind_products',
                'colors',
                'excludeProducts',
                'featured_products'
            )
        );
    }

    public function create(Request $request)
    {
        $user_id = $request->user_id;
        if(empty($user_id)){
            return view('auth.login',[
//                'includeRecommendedProducts' => true,
//                'excludeProducts' => true,
            ]);
        }
        $colors = Color::all();
        if(empty($request->input('product_id'))){
            $kind_products = KindProduct::all();
            $sub_kind_products = SubKindProduct::all();
            $kind_product_obj = null;
            $sub_kind_product_obj = null;
            $kind_product_id = $request->input('kind_product_id');
            $sub_kind_product_id = $request->input('sub_kind_product_id');
            if ($kind_product_id) {
                $kind_product_obj = KindProduct::find($kind_product_id);
            }
            if ($sub_kind_product_id) {
                $sub_kind_product_obj = SubKindProduct::find($sub_kind_product_id);
            }

            return view('admin.products.create', compact(
                'kind_products',
                'sub_kind_products',
                'kind_product_obj',
                'sub_kind_product_obj',
                'colors',
                'user_id',
            ))->with(['includeRecommendedProducts' => false, 'excludeProducts' => true]);
        } else {
            $product_id = $request->input('product_id');
            return redirect( route('admin.products.createkindsubkind', [
                'product_id' => $product_id,
                'colors' => $colors,
                'user_id' => $user_id,
            ]));
        }
    }

    public function show($id, Request $request)
    {
        $user_id = $request->input('user_id');
        $product = Product::query()
            ->with('kind_product')
            ->with('color')
            ->with('status_product')
            ->with('user')
            ->where('id',$id)
            ->first();
        $photos = ProductPhoto::query()->where('product_id', $id)->get();
        $kind_products = KindProduct::all();
        $featured_products = Product::query()->with('productphotos')->where('featured',1)->get();

        return view('admin.products.show',[
            'product' => $product,
            'photos' => $photos,
            'kind_products' => $kind_products,
            'featured_products' => $featured_products,
            'user_id' => $user_id,
            'includeRecommendedProducts' => false,
            'excludeProducts' => true,
        ]);
    }

    public function store(Request $request)
    {
        $action = $request->input('action');
        $user_id = $request->post('user_id');
        $product = new Product();

        $product->name = $request->input('name');
        $product->kind_product_id = $request->input('kind_product_id');
        $product->sub_kind_product_id = $request->input('sub_kind_product_id');
        $product->content = $request->input('content');
        $product->price = $request->input('price');
        $product->stock_balance = $request->input('stock_balance');
        $product->color_id = $request->input('color');
        $product->status_product_id = 1;
        $product->user_id = $request->input('user_id');
        $product->active = 0;
        $product->created_at = date("Y-m-d H:i:s");

        $product->save();

        // Обробити завантажені зображення
        if ($request->hasFile('product_photo')) {
            $photos = $request->file('product_photo');
            foreach ($photos as $photo) {
                // Зберегти кожне зображення
                $filename = $photo->store('photos'); // Зберегти зображення в папці "storage/app/products"
                // Тут ви також можете виконати будь-які додаткові операції з файлами, наприклад, зберегти шляхи до зображень в базі даних.
            }
        }

        $user = User::query()->where('id',$user_id)->first();
        $user->category_users_id = 3;
        $user->save();

        if ($action === 'Зберегти') {
            return redirect()->route('admin_products.edit', ['admin_product' => $product]);
        } elseif ($action === 'Додати вид товару' || $action === 'Додати підвид товару') {

            return redirect()->route('admin.products.createkindsubkind', [
                'admin_product' => $product,
                'uri' => $product->id,
            ]);
        } elseif ($action === 'Виставити на продаж') {
            $validated = Validator::make($request->all(), [
                'name' => 'required',
                'kind_product_id' => 'required',
                'sub_kind_product_id' => 'required',
                'content' => 'required',
                'price' => 'required',
                'stock_balance' => 'required',
                'color' => 'required',
            ]);
            if ($validated->fails()) {
                return redirect()->route('admin.products.edit', ['admin_product' => $product->id])
                    ->withErrors($validated)
                    ->withInput();
            }
            $validated_user = Validator::make([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ], [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);

            if ($validated_user->fails()) {
                $errors = $validated_user->errors();
                $errorFields = array_keys($errors->toArray());

                return redirect()->route('users.show_seller', ['user' => $user_id])
                    ->withErrors($validated_user)
                    ->with('errorFields', $errorFields);
            }

            $product->status_product_id = 2;

            $product->save();

            try {
                Mail::to('bulic2@ukr.net')->send(new NewProductMail($product));
            } catch (\Exception $e) {
                return view('emails.error',[
                    'excludeProducts' => true,
                ])->with('message', 'Помилка з\'єднання з сервером. Перевірте ваше інтернет-з\'єднання та спробуйте ще раз.');
            }

            return redirect( route('admin.products.show', [
                'admin_product' => $product,
                'colors',
                'includeRecommendedProducts' => true,
                'excludeProducts' => true,
            ]));
        }
    }

    public function edit($id, Request $request)
    {
        $user_id = $request->input('user_id');
        $kind_product_obj = session('kind_product_obj');
        $sub_kind_product_obj = session('sub_kind_product_obj');
        $colors = Color::all();
        $kind_products = KindProduct::all();
        $sub_kind_products = SubKindProduct::all();
        $product = Product::query()->with('kind_product')->with('productphotos')->where('id',$id)->first();
        if(empty($kind_product_obj)){
            $kind_product_obj = KindProduct::query()->where('id',$product->kind_product_id)->first();
        }
        if(empty($sub_kind_product_obj)){
            $sub_kind_product_obj = SubKindProduct::query()->where('id',$product->sub_kind_product_id)->first();
        }
//        $photos = ProductPhoto::query()->where('product_id', $id)->get();


        return view('admin.products.edit',[
            'product' => $product,
            'user_id' => $user_id,
            'kind_product_obj' => $kind_product_obj,
            'kind_products' => $kind_products,
            'sub_kind_product_obj' => $sub_kind_product_obj,
            'sub_kind_products' => $sub_kind_products,
            'colors' => $colors,
            'includeRecommendedProducts' => false,
            'excludeProducts' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user_id = $request->post('user_id');
        $action = $request->input('action');
        $product = Product::query()->where('id',$id)->first();
        if(!$product){
            throw new \Exception('Product not found');
        }
        $product->name = $request->post('name');
        $product->kind_product_id = $request->post('kind_product_id');
        $product->sub_kind_product_id = $request->post('sub_kind_product_id');
        $product->content = $request->post('content');
        $product->price = $request->post('price');
        $product->stock_balance = $request->post('stock_balance');
        $product->color_id = $request->post('product_color');
        $product->status_product_id = 1;
        $product->user_id = $user_id;
        $product->active = 0;
        $product->updated_at = date("Y-m-d H:i:s");

        $product->save();

        if($request->product_photo){
            $product_photo = new ProductPhotoController();
            $product_photo->upload($request, $product->id);
        }

        $user = User::query()->where('id',$user_id)->first();
        $user->category_users_id = 3;
        $user->save();

        if ($action === 'Зберегти') {
            $kind_products = KindProduct::all();
            $sub_kind_products = SubKindProduct::all();
            $colors = Color::all();
            $kind_product_obj = KindProduct::query()->where('id',$product->kind_product_id)->first();
            $sub_kind_product_obj = SubKindProduct::query()->where('id',$product->sub_kind_product_id)->first();

            return redirect()->route('admin.products.edit', ['product' => $product])
                ->with([
                    'kind_product_obj' => $kind_product_obj,
                    'sub_kind_product_obj' => $sub_kind_product_obj,
                    'kind_products' => $kind_products,
                    'sub_kind_products' => $sub_kind_products,
                    'colors' => $colors,
//                    'includeRecommendedProducts' => true,
                    'excludeProducts' => true,
                ]);
        } elseif ($action === 'Додати вид товару' || $action === 'Додати підвид товару') {

            return redirect()->route('admin.products.createkindsubkind', [
                'product' => $product,
                'uri' => $product->id,
            ]);
        } elseif ($action === 'Виставити на продаж') {
            $validated = Validator::make($request->all(), [
                'name' => 'required',
                'kind_product_id' => 'required',
                'sub_kind_product_id' => 'required',
                'content' => 'required',
                'price' => 'required',
                'stock_balance' => 'required',
                'product_color' => 'required',
            ]);

            if ($validated->fails()) {
                return redirect()->route('admin.products.edit', ['product' => $id])
                    ->withErrors($validated)
                    ->withInput();
            }

            $validated_user = Validator::make([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ], [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
            ]);

            if ($validated_user->fails()) {
                $errors = $validated_user->errors();
                $errorFields = array_keys($errors->toArray());

                return redirect()->route('users.show_seller', ['user' => $user_id])
                    ->withErrors($validated_user)
                    ->with('errorFields', $errorFields);
            }

            $product->status_product_id = 2;

            $product->save();

            try {
                Mail::to('bulic2@ukr.net')->send(new NewProductMail($product));
            } catch (\Exception $e) {
                return view('emails.error',[
                    'excludeProducts' => true,
                ])->with('message', 'Помилка з\'єднання з сервером. Перевірте ваше інтернет-з\'єднання та спробуйте ще раз.');
            }

            return redirect( route('admin.products.show', [
                'admin_product' => $product,
                'colors',
                'includeRecommendedProducts' => false,
                'excludeProducts' => true,
            ]));
        }
    }

    public function destroy($id)
    {
        $product = Product::query()->where('id',$id)->delete();
        return redirect( route('admin.products.index'));
    }

    public function createkindsubkind($id)
    {
        $all_sub_kind_products = SubKindProduct::all();
        $all_kind_products = KindProduct::all();
        if(!$all_kind_products->isEmpty()){
            foreach ($all_kind_products as $kind_product){
                $kind_products[] = $kind_product->name;
            }
        } else {
            $kind_products[] = false;
        }
        if(!$all_sub_kind_products->isEmpty()){
            foreach ($all_sub_kind_products as $sub_kind_product){
                $sub_kind_products[] = $sub_kind_product->name;
            }
        } else {
            $sub_kind_products[] = false;
        }

        return view('admin.products.create_kind_subkind',[
            'product_id' => $id,
            'kind_products' => $kind_products,
            'sub_kind_products' => $sub_kind_products,
            'excludeProducts' => true,
        ]);
    }
    public function storekindsubkind(Request $request)
    {
        $user = Auth::user();
        $all_kind_products = KindProduct::all();
        $name_kind_product = $request->post('name_kind_product');
        if(isset($name_kind_product)){
            $names_kind_products = [];
            foreach ($all_kind_products as $one_kind_product){
                $names_kind_products[] = $one_kind_product->name;
            }
            if(!in_array($name_kind_product, $names_kind_products)){
                $kind_product = new KindProduct();
                $kind_product->name = $name_kind_product;
                $kind_product->user_id = $user->id;
                $kind_product->active = 0;
                $kind_product->created_at = date("Y-m-d H:i:s");
                $kind_product->save();
            } else {
                $kind_product = KindProduct::query()->where('name', $name_kind_product)->first();
            }
        } else {
            $kind_product = null;
        }
        $all_sub_kind_products = SubKindProduct::all();
        $name_sub_kind_product = $request->post('name_sub_kind_product');
        if(isset($name_kind_product)){
            $names_sub_kind_products = [];
            foreach ($all_sub_kind_products as $one_sub_kind_product){
                $names_sub_kind_products[] = $one_sub_kind_product->name;
            }
            if(!in_array($name_sub_kind_product, $names_sub_kind_products)){
                $sub_kind_product = new SubKindProduct();
                $sub_kind_product->name = $request->post('name_sub_kind_product');
                $sub_kind_product->kind_product_id = $kind_product->id;
                $sub_kind_product->user_id = $user->id;
                $sub_kind_product->active = 0;
                $sub_kind_product->created_at = date("Y-m-d H:i:s");
                $sub_kind_product->save();
            } else {
                $sub_kind_product = SubKindProduct::query()->where('name', $request->post('name_sub_kind_product'))->first();
            }
        } else {
            $sub_kind_product = null;
        }
        $product_id = $request->input('product_id');
        $product = Product::query()->where('id',$product_id)->first();

        return redirect()->route('admin_products.edit', ['admin_product' => $product])
            ->with([
                'kind_product_obj' => $kind_product,
                'sub_kind_product_obj' => $sub_kind_product,
            ]);
    }

    public function productsKind($kind)
    {
        $products = Product::query()->with('kind_product')->where('kind_product_id',$kind)->get();
        $kind_products = KindProduct::all();
        $sub_kind_products_kind = SubKindProduct::query()->where('kind_product_id',$kind)->get();

        return view('admin.products.index',[
            'products' => $products,
            'kind_products' => $kind_products,
            'sub_kind_products_kind' => $sub_kind_products_kind,
            'excludeProducts' => true,
        ]);
    }
    public function productsKindSubkind($kind,$subkind)
    {
        $products = Product::query()
            ->with('kind_product')
            ->with('sub_kind_product')
            ->where('kind_product_id',$kind)
            ->where('sub_kind_product_id',$subkind)
            ->get();
        return view('admin_products.index',[
            'products' => $products,
            'excludeProducts' => true,
        ]);
    }

    public function sendForSale($product, Request $request)
    {
        $user_id = $request->input('user_id');
        $product = Product::query()->where('id',$product)->first();

        $product->status_product_id = 3;
        $product->admin_id = $user_id;
        $product->date_start_sale = date("Y-m-d H:i:s");

        $product->save();
        // email продавцю про виставлення на продаж його товару

        return redirect()->route('admin_products.index');
    }

    public function filter(Request $request)
    {
        $filterStatus = $request->input('status_product');

        // Отримати всі товари
        $products = Product::query()->get();

//         Фільтрація за статусом товару
        if ($filterStatus) {
            $products = $this->filterByStatus($products, $filterStatus);
        }
        
        $featured_products = Product::query()->with('productphotos')->where('featured',1)->get();

        $products = $products->sortByDesc(function ($product) {
            return $product->stock_balance == 0 ? -1 : $product->id;
        });
        $kind_products = KindProduct::query()
            ->join('products', 'kind_products.id', '=', 'products.kind_product_id')
            ->where('products.status_product_id', '=', $filterStatus)
            ->select('kind_products.id', 'kind_products.name', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.name')
            ->get();
        $colors = Color::all();
        $all_kind_products = KindProduct::all();

        return view('admin.products.index', [
            'products' => $products,
            'featured_products' => $featured_products,
            'all_kind_products' => $all_kind_products,
            'kind_products' => $kind_products,
            'colors' => $colors,
        ]);
    }

    private function filterByStatus($products, $filterStatus)
    {
        $products = $products->filter(function ($product) use ($filterStatus) {
            // Перевірка, чи статус продукту співпадає з вказаним $filterStatus
            return $product->status_product_id == $filterStatus;
        });

        return $products;
    }


}
