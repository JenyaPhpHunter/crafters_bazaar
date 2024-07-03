<?php

namespace App\Http\Controllers;

use App\Mail\NewProductMail;
use App\Models\Color;
use App\Models\Dialog;
use App\Models\KindProduct;
use App\Models\Product;
use App\Models\ProductPhoto;
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
//    protected $products;
    protected $kind_products;
    protected $sub_kind_products;
    protected $color;

    public function __construct()
    {
//        $this->products = Product::all();
        $this->kind_products = KindProduct::all();
        $this->sub_kind_products = SubKindProduct::all();
        $this->colors = Color::all();
    }

    public function index()
    {
        $data = [];
        $data['all_kind_products'] = $this->kind_products;
        $data['sub_kind_products'] = $this->sub_kind_products;
        $data['colors'] = $this->colors;
        $baseQuery = Product::query()
            ->where('status_product_id', 3)
            ->with(['kind_product', 'productphotos']);
        $products = $baseQuery->get();

        $featured_products = (clone $baseQuery)->where('featured', 1)->get();
        $data['featured_products'] = $featured_products;

        $products = $products->sortByDesc(function ($product) {
            return $product->stock_balance == 0 ? -1 : $product->id;
        });
        $data['products'] = $products;
        $kind_products = KindProduct::query()
            ->join('products', 'kind_products.id', '=', 'products.kind_product_id')
            ->where('products.status_product_id', '=', 3)
            ->select('kind_products.id', 'kind_products.name', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.name')
            ->get();
        $data['kind_products'] = $kind_products;
//        $all_kind_products = KindProduct::query()->with('products')->get();
//var_dump($data);
        return view('products.index', $data);
    }

    public function create(Request $request)
    {
        $user = User::find($request->user_id);
        if(!empty($request->input('kind_product_id'))){
            $selected_kind_product_id = $request->input('kind_product_id');
        } else {
            $selected_kind_product_id = 1;
        }
        if(!empty($request->input('sub_kind_product_id'))){
            $selected_sub_kind_product_id = $request->input('sub_kind_product_id');
        } else {
            $selected_sub_kind_product_id = 1;
        }
        if(empty($user)){
            return view('auth.login-register',[
//                'includeRecommendedProducts' => true,
//                'excludeProducts' => true,
//                'createProduct' => 'createProduct',
            ]);
        }
        $colors = Color::all();
        if(empty($request->input('product_id'))){
            $kind_products = KindProduct::all();
            $sub_kind_products = SubKindProduct::all();
//            $baseQuery = Product::query()
//                ->where('status_product_id', 3)
//                ->with(['kind_product', 'productphotos']);

            return view('products.create', compact(
                'selected_kind_product_id',
                'kind_products',
                'selected_sub_kind_product_id',
                'sub_kind_products',
                'colors',
                'user',
            ))->with([/*'includeRecommendedProducts' => true, 'excludeProducts' => true*/]);
        } else {
            $product_id = $request->input('product_id');
            return redirect( route('products.createkindsubkind', [
                'product_id' => $product_id,
                'colors' => $colors,
                'user' => $user,
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
        $product->color_id = $request->input('color');
        $product->term_creation = $request->input('term_creation');
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
        $user->category_users_id = 2;
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

            if ($user->role_id > 4){
                $product->status_product_id = 2;
            } else {
                $product->status_product_id = 3;
            }
            $product->save();

//            try {
//                Mail::to('bulic2@ukr.net')->send(new NewProductMail($product));
//            } catch (\Exception $e) {
//                return view('emails.error',[
//                    'excludeProducts' => true,
//                ])->with('message', 'Помилка з\'єднання з сервером. Перевірте ваше інтернет-з\'єднання та спробуйте ще раз.');
//            }

            return redirect( route('products.show', [
                'product' => $product,
                'colors',
//                'includeRecommendedProducts' => true,
//                'excludeProducts' => true,
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

        $dialogs = Dialog::where('product_id', $id)
            ->with('user')
            ->orderByRaw('CASE WHEN answer_to IS NULL THEN 1 ELSE 0 END, answer_to')
            ->get();

        $dialogs_with_answers = [];
        foreach ($dialogs as $dialog) {
            if ($dialog->answer_to) {
                $question = Dialog::find($dialog->answer_to);
                if ($question) {
                    if (!isset($dialogs_with_answers[$question->id])) {
                        // Додати питання до масиву
                        $dialogs_with_answers[$question->id] = $question;
                    }
                    // Додати відповідь на це питання до масиву
                    $dialogs_with_answers[$dialog->id] = $dialog;
                }
            } else {
                // Якщо немає відповіді, просто додайте питання до масиву
                if (!isset($dialogs_with_answers[$dialog->id])) {
                    $dialogs_with_answers[$dialog->id] = $dialog;
                }
            }
        }

        $creator = ($product->user_id == $user_id) ;
        var_dump($creator);
        $photos = ProductPhoto::query()->where('product_id', $id)->get();
        $kind_products = KindProduct::all();
        $featured_products = Product::query()->with('productphotos')->where('featured',1)->get();

        return view('products.show',[
            'product' => $product,
            'photos' => $photos,
            'kind_products' => $kind_products,
            'featured_products' => $featured_products,
            'dialogs' => $dialogs,
            'dialogs_with_answers' => $dialogs_with_answers,
            'creator' => $creator,
            'user_id' => $user_id,
        ]);
    }

    public function edit($id, Request $request)
    {
        $user = User::find($request->user_id);
        $colors = Color::all();
        $kind_products = KindProduct::all();
        $sub_kind_products = SubKindProduct::all();
        $product = Product::query()->with('kind_product')->with('productphotos')->where('id',$id)->first();
        $photos = ProductPhoto::query()->where('product_id', $id)->get();

        return view('products.edit',[
            'product' => $product,
            'photos' => $photos,
            'user' => $user,
            'kind_products' => $kind_products,
            'sub_kind_products' => $sub_kind_products,
            'colors' => $colors,
//            'includeRecommendedProducts' => true,
//            'excludeProducts' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user_id = $request->user_id;
        $action = $request->input('action');
        $product = Product::query()->where('id',$id)->first();
        if(!$product){
            throw new \Exception('Product not found');
        }
//        if ($action !== 'Виставити на продаж з перегляду') {
//            $product->name = $request->post('name');
//            $product->kind_product_id = $request->post('kind_product_id');
//            $product->sub_kind_product_id = $request->post('sub_kind_product_id');
//            $product->content = $request->post('content');
//            $product->price = $request->post('price');
//            $product->stock_balance = $request->post('stock_balance');
//            $product->color_id = $request->post('product_color');
//            $product->term_creation = $request->input('term_creation');
//            $product->status_product_id = 1;
//            $product->user_id = $user_id;
//            $product->active = 0;
//            $product->updated_at = date("Y-m-d H:i:s");
//
//            $product->save();
//        }
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

            return redirect()->route('products.edit', ['product' => $product])
                ->with([
                    'kind_products' => $kind_products,
                    'sub_kind_products' => $sub_kind_products,
                    'colors' => $colors,
//                    'includeRecommendedProducts' => true,
//                    'excludeProducts' => true,
                ]);
        } elseif ($action === 'Додати вид товару' || $action === 'Додати підвид товару') {

            return redirect()->route('products.createkindsubkind', [
                'product' => $product,
                'uri' => $product->id,
            ]);
        } elseif ($action === 'Виставити на продаж' || $action === 'Виставити на продаж з перегляду') {
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
                return redirect()->route('users.show', ['user' => $user_id])
                    ->withErrors($validated_user)
                    ->with('errorFields', $errorFields);
            }
            if ($user->role_id > 4){
                $product->status_product_id = 2;
            } else {
                $product->status_product_id = 3;
            }

            $product->save();
            if ($user->role_id > 4) {
                try {
                    Mail::to('bulic2@ukr.net')->send(new NewProductMail($product));
                } catch (\Exception $e) {
                    return view('emails.error', [
                        'excludeProducts' => true,
                    ])->with('message', 'Помилка з\'єднання з сервером. Перевірте ваше інтернет-з\'єднання та спробуйте ще раз.');
                }
            }

            return redirect( route('products.show', [
                'product' => $product,
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
        $all_sub_kind_products = $this->sub_kind_products;
        $all_kind_products = $this->kind_products;
        $arr_kind_products = [];
        $arr_sub_kind_products = [];
        if(!$all_kind_products->isEmpty()){
            foreach ($all_kind_products as $kind_product){
                $arr_kind_products[] = $kind_product->name;
            }
        } else {
            $arr_kind_products[] = false;
        }
        if(!$all_sub_kind_products->isEmpty()){
            foreach ($all_sub_kind_products as $sub_kind_product){
                $arr_sub_kind_products[] = $sub_kind_product->name;
            }
        } else {
            $arr_sub_kind_products[] = false;
        }

        return view('products.create_kind_subkind',[
            'product_id' => $id,
            'arr_kind_products' => $arr_kind_products,
            'arr_sub_kind_products' => $arr_sub_kind_products,
//            'includeRecommendedProducts' => true,
//            'excludeProducts' => true,
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
        $products = Product::query()
            ->where('status_product_id',3)
            ->with('kind_product')
            ->where('kind_product_id',$kind)
            ->get();
        $sub_kind_products_kind = SubKindProduct::query()
            ->join('kind_products', 'sub_kind_products.id', '=', 'kind_products.id')
            ->join('products', 'kind_products.id', '=', 'products.kind_product_id')
            ->where('status_product_id',3)
            ->where('sub_kind_products.kind_product_id',$kind)
            ->get();
        $kind_products = KindProduct::query()
            ->join('products', 'kind_products.id', '=', 'products.kind_product_id')
            ->where('products.status_product_id', '=', 3)
            ->select('kind_products.id', 'kind_products.name', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.name')
            ->get();
        $all_kind_products = KindProduct::all();
        $sub_kind_products = SubKindProduct::all();
        $colors = Color::all();
        $featured_products = Product::query()
            ->where('status_product_id',3)
            ->with('productphotos')
            ->where('featured',1)
            ->get();

        return view('products.index',[
            'products' => $products,
            'kind_products' => $kind_products,
            'all_kind_products' => $all_kind_products,
            'sub_kind_products' => $sub_kind_products,
            'colors' => $colors,
            'featured_products' => $featured_products,
            'sub_kind_products_kind' => $sub_kind_products_kind,
        ]);
    }
    public function productsKindSubkind($subkind)
    {
        $products = Product::query()
            ->where('status_product_id',3)
            ->with('kind_product')
            ->with('sub_kind_product')
            ->where('sub_kind_product_id',$subkind)
            ->get();
        $kind_products = KindProduct::query()
            ->join('products', 'kind_products.id', '=', 'products.kind_product_id')
            ->where('products.status_product_id', '=', 3)
            ->select('kind_products.id', 'kind_products.name', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.name')
            ->get();
        $sub_kind_products = SubKindProduct::all();
        $colors = Color::all();
        $featured_products = Product::query()
            ->where('status_product_id',3)
            ->with('productphotos')
            ->where('featured',1)
            ->get();

        return view('products.index',[
            'products' => $products,
            'kind_products' => $kind_products,
            'sub_kind_products' => $sub_kind_products,
            'colors' => $colors,
            'featured_products' => $featured_products,
        ]);
    }

    public function filter(Request $request)
    {
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

        $query = Product::query()->where('status_product_id', 3);
        $products = $query->get();

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

        $all_kind_products = KindProduct::all();
        $kind_products = KindProduct::query()
            ->join('products', 'kind_products.id', '=', 'products.kind_product_id')
            ->where('products.status_product_id', '=', 3)
            ->select('kind_products.id', 'kind_products.name', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.name')
            ->get();

        $featured_products = Product::query()
            ->where('status_product_id',3)
            ->with('productphotos')
            ->where('featured',1)
            ->get();

        return view('products.index', [
            'products' => $products,
            'featured_products' => $featured_products,
            'all_kind_products' => $all_kind_products,
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

    function sendquestion(Request $request, $product_id)
    {
        $user_id = $request->user_id;
        if (! empty($request->input('questionText'))){
            $questionText = $request->input('questionText');
        }
        if (! empty($request->input('replyText'))){
            $replyText = $request->input('replyText');
            $replyDialogId = $request->input('dialogId');

        }
        if(empty($user_id)){
            return view('auth.login',[
                'sendquestion' => 'sendquestion',
                'product_id' => $product_id,
            ]);
        }

        $dialog = new Dialog();
        $dialog->type = 'show_product';
        $dialog->product_id = $product_id;
        if (isset($questionText)) {
            $dialog->comment = $questionText;
            $dialog->queue = 1;
//            $dialog->queue = $lastQueue ? $lastQueue + 1 : 1;
        }
        if (isset($replyText)) {
            $replyDialog = Dialog::find($replyDialogId);
            $dialog->comment = $replyText;
            $dialog->queue = 1;
            $dialog->answer_to = $replyDialog->id;
        }
        $dialog->user_id = $user_id;
        $dialog->created_at = now();

        $dialog->save();

        $product = Product::query()->where('id', $product_id)->first();
        return redirect( route('products.show', [
            'product' => $product,
        ]));
    }
}
