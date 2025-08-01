<?php

namespace App\Http\Controllers;

use App\Constants\ProductsConstants;
use App\Models\Color;
use App\Models\Dialog;
use App\Models\KindProduct;
use App\Models\Product;
use App\Models\ProductPhoto;
use App\Models\Review;
use App\Models\SubKindProduct;
use App\Models\User;
use App\Services\ApiService;
use App\Services\EmailService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ProductController extends Controller
{
    public function index()
    {
        $data = [];
        $baseQuery = Product::query()
            ->where('status_product_id', 3)
            ->with(['sub_kind_product', 'productphotos']);
        $products = $baseQuery->get();
        $featured_products = (clone $baseQuery)->where('featured', 1)->get();
        $data['featured_products'] = $featured_products;

        $products = $products->sortByDesc(function ($product) {
            return $product->stock_balance == 0 ? -1 : $product->id;
        });
        $data['products'] = $products;
        $kind_products = KindProduct::query()
            ->join('sub_kind_products', 'kind_products.id', '=', 'sub_kind_products.kind_product_id')
            ->join('products', 'sub_kind_products.id', '=', 'products.sub_kind_product_id')
            ->where('products.status_product_id', '=', 3)
            ->select('kind_products.id', 'kind_products.title', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.title')
            ->get();
        $data['kind_products'] = $kind_products;

        $colors = Color::query()
            ->join('products', 'colors.id', '=', 'products.color_id')
            ->where('products.status_product_id', '=', 3)
            ->get();
        $data['colors'] = $colors;

        return view('products.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find($request->user_id);
        if(!empty($request->input('kind_product_id'))){
            $selected_kind_product_id = $request->input('kind_product_id');
        } else {
            $selected_kind_product_id = 1;
        }
        if(!empty($request->input('sub_kind_product_id'))){
            $selected_sub_kind_product_id = $request->input('sub_kind_product_id');
            $selected_sub_kind_product = SubKindProduct::find($selected_sub_kind_product_id);
            $selected_kind_product_id = $selected_sub_kind_product->kind_product_id;
        } else {
            $selected_sub_kind_product_id = 1;
        }
        $colors = Color::all();
        $action_types = ProductsConstants::ACTION_TYPES;

        if(empty($request->input('product_id'))){
            $kind_products = KindProduct::all();        // TODO ->where('kind_products.id', '!=', 1);
            $sub_kind_products = SubKindProduct::all();     // TODO ->where('sub_kind_products.id', '!=', 1);

            return view('products.create', compact(
                'selected_kind_product_id',
                'kind_products',
                'selected_sub_kind_product_id',
                'sub_kind_products',
                'colors',
                'user',
                'action_types',
            ))->with([/*'includeRecommendedProducts' => true, 'excludeProducts' => true*/]);
        } else {
            $product_id = $request->input('product_id');

            return redirect( route('products.createkindsubkind', [
                'product_id' => $product_id,
                'colors' => $colors,
                'user' => $user,
                'action_types' => $action_types,
            ]));
        }
    }

//    public function store(ProductRequest $request): RedirectResponse
//    {
//        $data = $request->validated();
//
//        $product = app(ProductService::class)->create($data);
//
//        return redirect()->route('products.index')
//            ->with('success', 'Товар успішно створено');
//    }

    public function store(Request $request)
    {
        $function_name = __FUNCTION__;
        $action = $request->input('action');
        $user_id = $request->post('user_id');

        try {
            $product = (new ProductService())->createProduct($request, $function_name);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }

        $user = User::query()->where('id',$user_id)->first();
//        if ($user->role_id > 6) {
//            $user->category_user_id = 2;
//        }
        $user->save();

        if ($action === 'save') {
            return redirect()->route('products.edit', ['product' => $product->id]);
        } elseif ($action === 'add_kind' || $action === 'add_sub_kind') {
            return redirect()->route('products.createkindsubkind', [
                'product' => $product,
                'uri' => $product->id,
            ]);
        } elseif ($action === 'put_up_for_sale') {
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
                    ->with('errorFields', $errorFields)
                    ->with('activeTab', 'account-info');
            }

            try {
                $emailService = new EmailService();
                $emailService->sendProductForSaleEmail($product);
            } catch (\Exception $e) {
                return view('emails.error',[
                ])->with('message', 'Помилка з\'єднання з сервером. Перевірте ваше інтернет-з\'єднання та спробуйте ще раз.');
            }

            $product->date_put_up_for_sale = date("Y-m-d H:i:s");
            if ($user->role_id > 4){
                $product->status_product_id = 2;
            } else {
                $product->status_product_id = 3;
                $product->date_approve_sale = date("Y-m-d H:i:s");
                $$product->admiin_id = $user->id;
            }
            $product->save();

            return redirect( route('products.show', [
                'product' => $product,
                'colors',
            ]));
        }
    }

    public function show($product, Request $request)
    {
        $user_id = $request->input('user_id');
        $product->load(['sub_kind_product.kind_product', 'color', 'status_product', 'user']);
        if ($product) {
            $filters = session()->get('filters', []);
            $query = Product::query()->where('status_product_id', 3);
            if (!empty($filters)) {
                if (!empty($filters['filter_price']) && is_array($filters['filter_price'])) {
                    foreach ($filters['filter_price'] as $priceRange) {
                        [$min, $max] = explode(';', $priceRange);
                        $query->whereBetween('price', [(float) $min, (float) $max]);
                    }
                }
                if (!empty($filters['categories']) && is_array($filters['categories'])) {
                    $subKindProductIds = KindProduct::whereIn('id', $filters['categories'])
                        ->with('sub_kind_products:id,kind_product_id')
                        ->get()
                        ->flatMap(fn($kindProduct) => $kindProduct->sub_kind_products->pluck('id'))
                        ->toArray();
                    $query->whereIn('sub_kind_product_id', $subKindProductIds);
                }
                if (!empty($filters['sub_categories']) && is_array($filters['sub_categories'])) {
                    $query->whereIn('sub_kind_product_id', $filters['sub_categories']);
                }
                if (!empty($filters['filter_color']) && is_array($filters['filter_color'])) {
                    $query->whereIn('color_id', $filters['filter_color']);
                }

            }
            $previousProductQuery = clone $query;
            $previousProductCount = $previousProductQuery->where('id', '<', $product->id)->count();
            if ($previousProductCount > 0) {
                $previous_product = $previousProductQuery->where('id', '<', $product->id)
                    ->orderBy('id', 'desc')
                    ->first();
            } else {
                $previous_product = null;
            }
            $previous_product_id = $previous_product ? $previous_product->id : null;

            $nextProductQuery = clone $query;
            $nextProductCount = $nextProductQuery->where('id', '>', $product->id)->count();
            if ($nextProductCount > 0){
                $next_product = $nextProductQuery->where('id', '>', $product->id)
                    ->orderBy('id', 'asc')
                    ->first();
            } else {
                $next_product = null;
            }
            $next_product_id = $next_product ? $next_product->id : null;
        }
        $dialogs = Dialog::where('product_id', $product->id)
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

        $creator = ($product->creator_id == $user_id) ;
        $photos = ProductPhoto::query()->where('product_id', $product->id)->get();
        $kind_products = KindProduct::all();
        $featured_products = Product::query()->with('productphotos')->where('featured',1)->get();
        $action_types = ProductsConstants::ACTION_TYPES;
        $reviews = Review::query()->where('product_id', $product->id)->get();
        $averageRating = $reviews->avg('rating') ?? 0; // Середній рейтинг
        $user = User::find($user_id);
        $api_gpt = new ApiService(env('OPENAI_API_KEY'));
//        $ai_comment = $api_gpt->beautifyComment($product->comment);
//        var_dump($ai_comment); die();

        return view('products.show',[
            'product' => $product,
            'previous_product_id' => $previous_product_id,
            'next_product_id' => $next_product_id,
            'photos' => $photos,
            'kind_products' => $kind_products,
            'featured_products' => $featured_products,
            'dialogs' => $dialogs,
            'dialogs_with_answers' => $dialogs_with_answers,
            'creator' => $creator,
            'user' => $user,
            'action_types' => $action_types,
            'reviews' => $reviews,
        ]);
    }

    public function edit($id, Request $request)
    {
//        $this->seedie($id);
        $product = Product::query()
            ->with(['kind_product', 'sub_kind_product', 'productphotos'])
            ->where('id', $id)
            ->first();
        $user = User::find($request->user_id);
        $isProductNew = $product->status_product_id == 1;
        $isAdminUser = isset($user) && $user->role_id < 5 && $product->status_product_id != 4;
        if($isProductNew || $isAdminUser){
            $colors = Color::all();
            $kind_products = KindProduct::all();
            $sub_kind_products = SubKindProduct::all();
            $photos = ProductPhoto::query()->where('product_id', $id)->get();
            $action_types = ProductsConstants::ACTION_TYPES;

            return view('products.edit',[
                'product' => $product,
                'photos' => $photos,
                'user' => $user,
                'kind_products' => $kind_products,
                'sub_kind_products' => $sub_kind_products,
                'colors' => $colors,
                'action_types' => $action_types,
            ]);
        } else {
            if ($user->role_id > 4) {
                return redirect()->route('products.show', ['product' => $product->id])
                    ->with('error', 'Корегування даних товару заборонено тому що товар вже відправили на продаж. За необхідності зв \'яжіться з вашим менеджером ' .
                        $product->admin->name . ' ' . $product->admin->phone .
                        '. В зв\'язку з тим, що ваш товар відправлнений на продаж, Вам відправлений лист на пощшту з контактами вашого менеджера');
            } else {
                return redirect()->route('products.show', ['product' => $product->id])
                    ->with('error', 'Корегування даних товару заборонено, тому що його купили');
            }
        }
    }

    public function update(Request $request, $id)
    {
//        $this->seedie($request->all());
        $function_name = __FUNCTION__;
        $user = User::find($request->user_id);
        $action = $request->input('action');
        $product = Product::find($id);
        if (($user->role_id > 4 && $product->status_product_id < 3) || ($user->role_id < 5 && $product->status_product_id < 4)){
            try {
                $product = (new ProductService())->createProduct($request, $function_name, $id);
            } catch (ValidationException $e) {
                return redirect()
                    ->route('products.edit', ['product' => $id])
                    ->withErrors($e->validator)
                    ->withInput();
            }

            if ($user->role_id > 4){
                $user->category_user_id = 3;
                $user->save();
            }
            if ($action === 'put_up_for_sale' || $action === 'put_for_sale_from_show') {
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
                    return redirect()->route('users.show', ['user' => $request->user_id])
                        ->withErrors($validated_user)
                        ->with('errorFields', $errorFields)
                        ->with('activeTab', 'account-info')
                        ->with('previous_page', url()->current());
                }
                $product->date_put_up_for_sale = date("Y-m-d H:i:s");
                if ($user->role_id > 4) {
                    $product->status_product_id = 2;

//                $apiService = new ApiService();
//                $beautifiedCommentResponse = $apiService->beautifyComment($product->content);
//                $this->seedie($beautifiedCommentResponse);
//                if ($beautifiedCommentResponse->status() == 200) {
//                    $beautifiedComment = $beautifiedCommentResponse->getData()->beautifyComment;
                    // Можна зберегти покращений коментар у базі або вивести на екран
                    // $product->description = $beautifiedComment; // наприклад, оновити опис товару
//                } else {
//                    return back()->withErrors(['error' => 'Не вдалося покращити коментар']);
//                }
                    try {
                        $emailService = new EmailService();
                        $emailService->sendProductForSaleEmail($product);
                    } catch (\Exception $e) {
                        return view('emails.error')
                            ->with('message', 'Помилка з\'єднання з сервером. Перевірте ваше інтернет-з\'єднання та спробуйте ще раз.');
                    }
                } else {
                    $product->status_product_id = 3;
                    $product->date_approve_sale = date("Y-m-d H:i:s");
                    $product->admin_id = $user->id;
//                    try {
//                        $emailService = new EmailService();
//                        $emailService->sendPutUpForSaleEmail($product);
//                    } catch (\Exception $e) {
//                        return view('emails.error')
//                            ->with('message', 'Помилка з\'єднання з сервером. Перевірте ваше інтернет-з\'єднання та спробуйте ще раз.');
//                    }
                }
                $product->save();

                return redirect( route('products.show', [
                    'product' => $product->id,
                ]))->with('success', 'Товар успішно відправлено на продаж!');
            } elseif ($action === 'add_kind' || $action === 'add_sub_kind') {

                return redirect()->route('products.createkindsubkind', [
                    'product' => $product,
                    'uri' => $product->id,
                ]);
            } elseif ($action === 'save') {
                $kind_products = KindProduct::all();
                $sub_kind_products = SubKindProduct::all();
                $colors = Color::all();

                return redirect()->route('products.edit', ['product' => $product->id])
                    ->with([
                        'kind_products' => $kind_products,
                        'sub_kind_products' => $sub_kind_products,
                        'colors' => $colors,
                    ]);
            }
        } else {
            if ($user->role_id > 4) {
                return redirect()->route('products.show', ['product' => $product->id])
                    ->with('error', 'Корегування даних товару заборонено тому що товар вже відправили на продаж. За необхідності зв \'яжіться з вашим менеджером ' .
                        $product->admin->name . ' ' . $product->admin->phone .
                        '. В зв\'язку з тим, що ваш товар відправлнений на продаж, Вам відправлений лист на пощшту з контактами вашого менеджера');
            } else {
                return redirect()->route('products.show', ['product' => $product->id])
                    ->with('error', 'Корегування даних товару заборонено, тому що його купили');
            }

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
        $arr_kind_products = [];
        $arr_sub_kind_products = [];
        if(!$all_kind_products->isEmpty()){
            foreach ($all_kind_products as $kind_product){
                $arr_kind_products[] = $kind_product->title;
            }
        } else {
            $arr_kind_products[] = false;
        }
        if(!$all_sub_kind_products->isEmpty()){
            foreach ($all_sub_kind_products as $sub_kind_product){
                $arr_sub_kind_products[] = $sub_kind_product->title;
            }
        } else {
            $arr_sub_kind_products[] = false;
        }

        return view('products.create_kind_subkind',[
            'product_id' => $id,
            'arr_kind_products' => $arr_kind_products,
            'arr_sub_kind_products' => $arr_sub_kind_products,
        ]);
    }
    public function storekindsubkind(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_kind_product' => 'required',
            'title_sub_kind_product' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $user_id = $request->input('user_id');
        $title_kind_product = $request->post('title_kind_product');
        $title_sub_kind_product = $request->post('title_sub_kind_product');

        $kind_product = KindProduct::query()
            ->whereRaw('LOWER(title) = ?', [strtolower($title_kind_product)])
            ->first();
        if(empty($kind_product)){
            $kind_product = new KindProduct();
            $kind_product->title = $title_kind_product;
            $kind_product->user_id = $user_id;
            $kind_product->checked = false;
            $kind_product->created_at = date("Y-m-d H:i:s");
            $kind_product->save();
        }

        $sub_kind_product = SubKindProduct::query()
            ->whereRaw('LOWER(title) = ?', [strtolower($title_sub_kind_product)])
            ->first();
        if(empty($sub_kind_product)){
            $sub_kind_product = new SubKindProduct();
            $sub_kind_product->title = $title_sub_kind_product;
            $sub_kind_product->kind_product_id = $kind_product->id;
            $sub_kind_product->user_id = $user_id;
            $sub_kind_product->checked = false;
            $sub_kind_product->created_at = date("Y-m-d H:i:s");
            $sub_kind_product->save();
        }
        $product_id = $request->input('product_id');
        $product = Product::query()->where('id',$product_id)->first();
        $product->sub_kind_product_id = $sub_kind_product->id;
        $product->save();

//        $EmailService = new EmailService();
//        $EmailService->sendApproveKindSubkind($kind_product, $sub_kind_product, $product_id);

        return redirect()->route('products.edit', ['product' => $product_id])
            ->with([
                'kind_product' => $kind_product,
                'sub_kind_product' => $sub_kind_product,
            ]);
    }

    public function productsKind($kind)
    {
        $products = Product::query()
            ->where('status_product_id', 3)
            ->whereHas('sub_kind_product', function ($query) use ($kind) {
                $query->where('kind_product_id', $kind);
            })
            ->with('sub_kind_product.kind_product')
            ->get();

        $sub_kind_products_kind = SubKindProduct::query()
            ->where('kind_product_id', $kind)
            ->with('products')
            ->get();

        $kind_products = KindProduct::query()
            ->join('sub_kind_products', 'kind_products.id', '=', 'sub_kind_products.kind_product_id')
            ->join('products', 'sub_kind_products.id', '=', 'products.sub_kind_product_id')
            ->where('products.status_product_id', 3)
            ->select('kind_products.id', 'kind_products.title', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.title')
            ->get();

        $all_kind_products = KindProduct::all();
        $sub_kind_products = SubKindProduct::all();
        $colors = Color::all();
        $featured_products = Product::query()
            ->where('status_product_id', 3)
            ->with('productphotos')
            ->where('featured', 1)
            ->get();

        return view('products.index', [
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
            ->with('sub_kind_product.kind_product')
            ->where('sub_kind_product_id',$subkind)
            ->get();
//        $kind_products = KindProduct::query()
//            ->join('products', 'kind_products.id', '=', 'products.kind_product_id')
//            ->where('products.status_product_id', '=', 3)
//            ->select('kind_products.id', 'kind_products.name', \DB::raw('COUNT(products.id) as product_count'))
//            ->groupBy('kind_products.id', 'kind_products.name')
//            ->get();

        $kind_products = KindProduct::all();
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

    public function approve($product)
    {

//        $emailService = new EmailService();
//        $emailService->sendPutUpForSaleEmail('bulic2012@gmail.com', $product);
    }

    public function filter(Request $request)
    {
        $filters = $request->only(['filter_price', 'categories', 'sub_categories', 'filter_color']);
        if (!empty(array_filter($filters))) {
            session()->put('filters', $filters);
        }
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
        $filterStatus = $request->input('status_product');
        if (isset($filterStatus)){
            $query = Product::query()->where('status_product_id', $filterStatus);
        } else {
            $query = Product::query()->where('status_product_id', 3);
        }
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
            ->join('sub_kind_products', 'kind_products.id', '=', 'sub_kind_products.kind_product_id')
            ->join('products', 'sub_kind_products.id', '=', 'products.sub_kind_product_id')
            ->where('products.status_product_id', '=', 3)
            ->select('kind_products.id', 'kind_products.title', \DB::raw('COUNT(products.id) as product_count'))
            ->groupBy('kind_products.id', 'kind_products.title')
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
            if ($product->kind_product->id) {
                // Перевірка, чи ідентифікатор категорії товару є в обраному списку категорій
                return in_array($product->kind_product->id, $selectedCategories);
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
            return mb_stripos($product->title, $filterSearch) !== false;
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
