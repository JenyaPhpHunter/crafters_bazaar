<?php

namespace App\Http\Controllers;

use App\Mail\NewProductMail;
use App\Models\Color;
use App\Models\KindProduct;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Size;
use App\Models\SubKindProduct;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->with('kind_product')
            ->with('productphotos')
            ->get();
        $featured_products = Product::query()->with('productphotos')->where('featured',1)->get();

        $products = $products->sortByDesc(function ($product) {
            return $product->stock_balance == 0 ? -1 : $product->id;
        });
        $products = $products;
        $kind_products = KindProduct::all();
        $colors = Color::all();
//        $excludeProducts = true;
        $excludeProducts = false;

        return view('products.index', compact('products', 'kind_products', 'colors', 'excludeProducts','featured_products'));
    }

    public function create(Request $request)
    {
        $user_id = $request->user_id;
        if(empty($user_id)){
            return view('auth.login',[
                'includeRecommendedProducts' => true,
                'excludeProducts' => true,
            ]);
        }
        $sizes = Size::all();
        $colors = Color::all();
        if(empty($request->input('product_id'))){
            $kind_products = KindProduct::all();
            $sub_kind_products = SubKindProduct::all();

            return view('products.create', compact(
                'kind_products',
                'sub_kind_products',
                'sizes',
                'colors',
                'user_id',
            ))->with(['includeRecommendedProducts' => true, 'excludeProducts' => true]);
        } else {
            $product_id = $request->input('product_id');
            return redirect( route('products.createkindsubkind', [
                'product_id' => $product_id,
                'sizes' => $sizes,
                'colors' => $colors,
                'user_id' => $user_id,
            ]));
        }
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
        $product->size_id = $request->input('selected_size');
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
            return redirect()->route('products.edit', ['product' => $product]);
        } elseif ($action === 'Додати вид товару' || $action === 'Додати підвид товару') {

            return redirect()->route('products.createkindsubkind', [
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
                'selected_size' => 'required',
                'color' => 'required',
            ]);
            if ($validated->fails()) {
                return redirect()->route('products.edit', ['product' => $product->id])
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

            return redirect( route('products.show', [
                'product' => $product,
                'sizes',
                'colors',
                'includeRecommendedProducts' => true,
                'excludeProducts' => true,
            ]));
        }
    }

    public function show($id, Request $request)
    {
        $user_id = $request->input('user_id');
        $product = Product::query()
            ->with('kind_product')
            ->with('size')
            ->with('color')
            ->with('status_product')
            ->with('user')
            ->where('id',$id)
            ->first();
        $photos = ProductPhoto::query()->where('product_id', $id)->get();
        $kind_products = KindProduct::all();
        $featured_products = Product::query()->with('productphotos')->where('featured',1)->get();

        return view('products.show',[
            'product' => $product,
            'photos' => $photos,
            'kind_products' => $kind_products,
            'featured_products' => $featured_products,
            'user_id' => $user_id,
            'includeRecommendedProducts' => true,
            'excludeProducts' => true,
        ]);
    }

    public function edit($id, Request $request)
    {
        $user_id = $request->input('user_id');
        $sizes = Size::all();
        $colors = Color::all();
        $kind_products = KindProduct::all();
        $sub_kind_products = SubKindProduct::all();
        $product = Product::query()->with('kind_product')->with('productphotos')->where('id',$id)->first();
        $photos = ProductPhoto::query()->where('product_id', $id)->get();

        return view('products.edit',[
            'product' => $product,
            'photos' => $photos,
            'user_id' => $user_id,
            'kind_products' => $kind_products,
            'sub_kind_products' => $sub_kind_products,
            'sizes' => $sizes,
            'colors' => $colors,
            'includeRecommendedProducts' => true,
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
        $product->size_id = $request->post('selected_size');
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
            $sizes = Size::all();
            $colors = Color::all();

            return redirect()->route('products.edit', ['product' => $product])
                ->with([
                    'kind_products' => $kind_products,
                    'sub_kind_products' => $sub_kind_products,
                    'sizes' => $sizes,
                    'colors' => $colors,
                    'includeRecommendedProducts' => true,
                    'excludeProducts' => true,
                ]);
        } elseif ($action === 'Додати вид товару' || $action === 'Додати підвид товару') {

            return redirect()->route('products.createkindsubkind', [
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
                'selected_size' => 'required',
                'product_color' => 'required',
            ]);

            if ($validated->fails()) {
                return redirect()->route('products.edit', ['product' => $id])
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

            return redirect( route('products.show', [
                'product' => $product,
                'sizes',
                'colors',
                'includeRecommendedProducts' => true,
                'excludeProducts' => true,
            ]));
        }
    }

    public function destroy($id)
    {
        $product = Product::query()->where('id',$id)->delete();
        return redirect( route('products.index'));
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

        return view('products.create_kind_subkind',[
            'product_id' => $id,
            'kind_products' => $kind_products,
            'sub_kind_products' => $sub_kind_products,
            'includeRecommendedProducts' => true,
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
        $product->kind_product_id = $kind_product->id;
        $product->sub_kind_product_id = $sub_kind_product->id;

        $product->save();

        return redirect()->route('products.edit', ['product' => $product])
            ->with([
                'kind_product_obj' => $kind_product,
                'sub_kind_product_obj' => $sub_kind_product,
            ]);
    }

    public function productsKind($kind)
    {
        $products = Product::query()->with('kind_product')->where('kind_product_id',$kind)->get();
        $sub_kind_products_kind = SubKindProduct::query()->where('kind_product_id',$kind)->get();
        return view('products.index',[
            'products' => $products,
            'sub_kind_products_kind' => $sub_kind_products_kind,
            'excludeProducts' => true,
        ]);
    }
    public function productsKindSubkind($subkind)
    {
        $products = Product::query()
            ->with('kind_product')
            ->with('sub_kind_product')
            ->where('sub_kind_product_id',$subkind)
            ->get();
        return view('products.index',[
            'products' => $products,
            'excludeProducts' => true,
        ]);
    }

    public function filter(Request $request)
    {
//        echo "<pre>";
//        print_r($request->all());
//        echo "</pre>";
//        die();
        $sortBy = $request->input('sort_by');
        $filterPrice = $request->input('filter_price');
        if(isset($filterPrice)){
            foreach ($filterPrice as $key => $value) {
                if (strpos($value, '+') !== false) {
                    $filterPrice[$key] = str_replace('+', PHP_INT_MAX, $value);
                }
            }
        }
        $categories = $request->input('categories');
        $sub_categories = $request->input('sub_categories');
        $filterColor = $request->input('filter_color');
        $filterSearch = $request->input('search');

        // Отримати всі товари
        $products = Product::query()->get();

        // Фільтрація за назвою
        if ($filterSearch) {
            $products = $this->filterByName($products, $filterSearch);
        }

        // Фільтрація за ціною
        if ($filterPrice) {
            $products = $this->filterByPrice($products, $filterPrice);
        }
        // Фільтрація за категоріями
        if ($categories) {
            $products = $this->filterByCategories($products, $categories);
        }
        if ($sub_categories) {
            $products = $this->filterBySubCategories($products, $sub_categories);
        }
        // Фільтрація за кольором
        if ($filterColor) {
            $products = $this->filterByColor($products, $filterColor);
        }

        if($sortBy){
            $products = $this->sortProducts($products, $sortBy);
        } else {
            $products = $products->sortByDesc(function ($product) {
                return $product->stock_balance == 0 ? -1 : $product->id;
            });
        }

        $kind_products = KindProduct::all();
        $count_sorted_product = [];
        foreach ($products as $product){
            if(isset($count_sorted_product[$product->kind_product->id])){
                $count_sorted_product[$product->kind_product->id]++;
            } else {
                $count_sorted_product[$product->kind_product->id] = 1;
            }
        }
        $featured_products = Product::query()->with('productphotos')->where('featured',1)->get();

        return view('products.index', [
            'products' => $products,
            'count_sorted_product' => $count_sorted_product,
            'featured_products' => $featured_products,
            'kind_products' => $kind_products,
            'colors' => Color::all(),
        ]);
    }

    private function filterByPrice($products, $filterPrice)
    {
        $allProducts = []; // Загальний масив для зберігання всіх об'єктів
        foreach ($filterPrice as $value) {
            list($minPrice, $maxPrice) = array_map('intval', explode(';', $value));
            // Отримати товари за поточним діапазоном цін та додати їх до загального масиву
            $filteredProducts = $products->filter(function ($product) use ($minPrice, $maxPrice) {
                return $product->price >= $minPrice && $product->price <= $maxPrice;
            });
            $allProducts = array_merge($allProducts, $filteredProducts->all());
        }
        // Отримати унікальні об'єкти, використовуючи колекцію Eloquent
        $products = collect($allProducts)->unique('id')->values();

        return $products;
    }

        private function filterByCategories($products, $selectedCategories)
    {
        // Фільтрування товарів за категоріями
        $products = $products->filter(function ($product) use ($selectedCategories) {
            // Перевірка, чи у товару вказана категорія
            if ($product->kind_product_id) {
                // Перевірка, чи ідентифікатор категорії товару є в обраному списку категорій
                return in_array($product->kind_product_id, $selectedCategories);
            }
            // Якщо товар не має вказаної категорії, можливо, ви бажаєте ігнорувати його або додати спеціальну логіку.
            return false;
        });

        return $products;
    }

    private function filterBySubCategories($products, $selectedSubCategories)
    {
        $products = $products->filter(function ($product) use ($selectedSubCategories) {
            if ($product->sub_kind_product_id) {
                return in_array($product->sub_kind_product_id, $selectedSubCategories);
            }

            return false;
        });

        return $products;
    }

    private function filterByColor($products, $filterColor)
    {
        $products = $products->filter(function ($product) use ($filterColor) {
            // Перевірка, чи у товару є колір
            if ($product->color) {
                // Перевірка, чи колір товару є в списку обраних кольорів
                return in_array($product->color->php_name, $filterColor);
            }
            // Якщо товар не має колору, можливо, ви бажаєте ігнорувати його або додати спеціальну логіку.
            return false;
        });

        return $products;
    }

    private function filterByName($products, $filterSearch)
    {
        $products = $products->filter(function ($product) use ($filterSearch) {
            // Перевірка, чи назва товару містить значення $filterSearch (регістронезалежно)
            return mb_stripos($product->name, $filterSearch) !== false;
        });

        return $products;
    }


    private function sortProducts($products, $sortBy)
    {
        if ($sortBy == 'newness') {
            $products = $products->sortByDesc(function ($product) {
                return $product->stock_balance == 0 ? -1 : $product->new;
            });
        } elseif ($sortBy == 'price_up') {
            $products = $products->sortBy(function ($product) {
                return $product->stock_balance == 0 ? PHP_INT_MAX : $product->price;
            });
        } elseif ($sortBy == 'price_down') {
            $products = $products->sortByDesc(function ($product) {
                return $product->stock_balance == 0 ? -1 : $product->price;
            });
        } else {
            $products = $products->sortByDesc(function ($product) {
                return $product->stock_balance == 0 ? -1 : $product->id;
            });
        }

        return $products;
    }
}
