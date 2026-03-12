<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\KindProduct;
use App\Models\SubKindProduct;
use App\Services\ProductPhotoService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function customButtons(string $routeName, $parameter = null): array
    {
        if ($routeName === 'products.show' && $parameter) {
            return [
                [
                    'name' => 'Додати до кошика',
                    'route' => route('carts.add', $parameter),
                    'icon' => 'fas fa-cart-plus',
                ],
            ];
        }
        return [];
    }

    public function index(Request $request)
    {
        // Сортування
        $sort_by = $request->get('sort_by', 'menu_order');

        $products = Product::query();

        // ФІЛЬТРИ -----------------------------------------------------

        // Пошук
        if ($request->filled('search')) {
            $products->where('title', 'LIKE', '%' . $request->search . '%');
        }

        // Категорії
        if ($request->filled('categories')) {
            $products->whereIn('kind_product_id', $request->categories);
        }

        // Фільтр по ціні
        if ($request->filled('filter_price')) {
            foreach ($request->filter_price as $filter) {

                if ($filter == 'all') continue;

                [$min, $max] = explode(';', $filter);

                if ($max === '+') {
                    $products->where('price', '>=', $min);
                } else {
                    $products->whereBetween('price', [$min, $max]);
                }
            }
        }

        // Фільтр по кольору
        if ($request->filled('filter_color')) {
            $products->whereHas('productcolors', function ($q) use ($request) {
                $q->whereIn('php_name', $request->filter_color);
            });
        }

        // Сортування ---------------------------------------------------

        switch ($sort_by) {
            case 'popularity':
                $products->orderBy('views', 'desc');
                break;
            case 'rating':
                $products->orderBy('rating', 'desc');
                break;
            case 'newness':
                $products->orderBy('created_at', 'desc');
                break;
            case 'price_up':
                $products->orderBy('price', 'asc');
                break;
            case 'price_down':
                $products->orderBy('price', 'desc');
                break;
            default:
                $products->orderBy('id', 'desc');
        }

        // Виконуємо запит
        $products = $products->get();

        // Додаткові дані для фільтрів
        $kind_products = KindProduct::withCount('products')->get();
        $colors = Color::all();
        $featured_products = Product::where('featured', 1)->limit(5)->get();

        return view('products.index', compact(
            'products',
            'kind_products',
            'colors',
            'featured_products',
            'sort_by'
        ));
    }

    public function create(Request $request): View
    {
        $user = Auth::user();
        $brands = Brand::where('creator_id', $user->id)->get();
        $images = $this->getDemoImages();

        $arr_kind_products     = KindProduct::pluck('title')->toArray();
        $arr_sub_kind_products = SubKindProduct::pluck('title')->toArray();

        $selectedKind    = old('kind_product_id')    ?: $request->input('kind_product_id');
        $selectedSubKind = old('sub_kind_product_id') ?: $request->input('sub_kind_product_id');

        return view('products.create', [
            'brands'                       => $brands,
            'images'                       => $images,
            'selected_kind_product_id'     => $selectedKind,
            'selected_sub_kind_product_id' => $selectedSubKind,
            'action_types'                 => [
                'add_kind'        => 'Додати вид',
                'add_sub_kind'    => 'Додати підвид',
                'put_up_for_sale' => 'Виставити на продаж',
                'save'            => 'Зберегти як чернетку',
            ],
            'productId'             => 0,
            'user'                  => $user,
            'productImages'         => collect(),
            'arr_kind_products'     => $arr_kind_products,
            'arr_sub_kind_products' => $arr_sub_kind_products,
        ]);
    }

    // Допоміжний метод для демо
    private function getDemoImages()
    {
        return [
            ["src" => asset('images/product/single/1/product-zoom-1.webp'), "w" => 700, "h" => 1100, "main" => asset('images/product/single/1/product-1.webp'), "thumb" => asset('images/product/single/1/product-thumb-1.webp')],
            ["src" => asset('images/product/single/1/product-zoom-2.webp'), "w" => 700, "h" => 1100, "main" => asset('images/product/single/1/product-2.webp'), "thumb" => asset('images/product/single/1/product-thumb-2.webp')],
            ["src" => asset('images/product/single/1/product-zoom-3.webp'), "w" => 700, "h" => 1100, "main" => asset('images/product/single/1/product-3.webp'), "thumb" => asset('images/product/single/1/product-thumb-3.webp')],
            ["src" => asset('images/product/single/1/product-zoom-4.webp'), "w" => 700, "h" => 1100, "main" => asset('images/product/single/1/product-4.webp'), "thumb" => asset('images/product/single/1/product-thumb-4.webp')],
        ];
    }

    public function store(ProductRequest $request, ProductService $service, ProductPhotoService $photoService)
    {
        $data = $request->validated();
        \Log::debug('store validated data', $data);

        $mainPhotoIndex = (int) $request->input('main_photo_index', 0);

        try {
            $product = DB::transaction(function () use ($data, $service, $request, $photoService, $mainPhotoIndex) {
                $product = $service->create($data);

                DB::afterCommit(function () use ($request, $product, $photoService, $mainPhotoIndex) {
                    if (!$request->hasFile('product_photo')) return;

                    $files = $request->file('product_photo');
                    $files = is_array($files) ? $files : [$files];
                    $photoService->storeMany($product, $files, $mainPhotoIndex);
                });

                return $product;
            });

            \Log::debug('product created', ['id' => $product->id]);

        } catch (\Exception $e) {
            \Log::error('store error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }

        return redirect()->route('products.index')->with('success', 'Товар успішно створено!');
    }


    public function edit(Product $product): View
    {
        $productImages = $product?->productphotos ?? collect();

        return view('products.edit', [
            'product' => $product,
            'productImages' => $productImages,
        ]);
    }

    public function update(StoreProductRequest $request, Product $product): RedirectResponse
    {
        ProductService::update($request, $product);

        return redirect()->route('products.edit', $product->id)
            ->with('success', 'Товар оновлено.');
    }

    public function storekindsubkind(Request $request)
    {
        $request->validate([
            'kind_product_id'    => 'required',
            'title_kind_product' => 'nullable|string|max:255',
        ]);

        $userId = auth()->id();

        // ── Визначаємо або створюємо вид ──
        $kindInput = trim($request->kind_product_id);
        $kind      = null;
        $kindId    = null;

        if (is_numeric($kindInput)) {
            $kindId = (int) $kindInput;
            $kind   = KindProduct::find($kindId);

            if (!$kind) {
                return response()->json(['success' => false, 'message' => 'Вид товару не знайдено'], 422);
            }
        } else {
            // kind_product_id прийшов як текст — це нова назва виду
            $titleKind = trim($request->title_kind_product ?: $kindInput);

            if (!$titleKind) {
                return response()->json(['success' => false, 'message' => 'Вкажіть назву виду товару'], 422);
            }

            $kind = KindProduct::firstOrCreate(
                ['title' => $titleKind],
                ['user_id' => $userId, 'checked' => true]
            );
            $kindId = $kind->id;
        }

        // ── Підвид — якщо заповнений ──
        $subkind      = null;
        $subInput     = trim($request->sub_kind_product_id ?? '');
        $titleSubkind = trim($request->title_sub_kind_product ?? '');

        // Tom Select може передати текст нового підвиду в sub_kind_product_id
        if (!$titleSubkind && $subInput && !is_numeric($subInput)) {
            $titleSubkind = $subInput;
        }

        if ($titleSubkind) {
            // Новий або існуючий підвид за назвою
            $subkind = SubKindProduct::firstOrCreate(
                ['title' => $titleSubkind, 'kind_product_id' => $kindId],
                ['user_id' => $userId, 'checked' => true]
            );
        } elseif (is_numeric($subInput) && $subInput) {
            // Обраний існуючий підвид по числовому id
            $subkind = SubKindProduct::find((int) $subInput);
        }

        // ── Відповідь ──
        if ($subkind) {
            if ($subkind->wasRecentlyCreated && $kind->wasRecentlyCreated) {
                $message = 'Вид та підвид успішно створено';
            } elseif ($subkind->wasRecentlyCreated) {
                $message = 'Підвид успішно створено';
            } else {
                $message = 'Дані заповнено';
            }
        } else {
            $message = $kind->wasRecentlyCreated ? 'Вид успішно створено' : 'Дані заповнено';
        }

        return response()->json([
            'success'    => true,
            'message'    => $message,
            'newKind'    => [
                'id'    => $kind->id,
                'title' => $kind->title,
            ],
            'newSubkind' => $subkind ? [
                'id'              => $subkind->id,
                'title'           => $subkind->title,
                'kind_product_id' => $kindId,
            ] : null,
        ]);
    }
}
