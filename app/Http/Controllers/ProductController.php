<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\KindProduct;
use App\Models\ProductPhoto;
use App\Models\SubKindProduct;
use App\Services\ProductPhotoService;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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
        $query = Product::query()->with([
            'productPhotos',
            'discounts'                  => fn($q) => $q->active()->where('type', 'product'),
            'subKindProduct.discounts'   => fn($q) => $q->active()->where('type', 'category'),
        ]);

        // 🔎 SEARCH
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 📂 CATEGORIES
        if ($request->filled('categories')) {
            $query->whereHas('subKindProduct', function ($q) use ($request) {
                $q->whereIn('kind_product_id', (array) $request->categories);
            });
        }

        // 🎨 COLORS
        if ($request->filled('filter_color')) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->whereIn('php_name', (array) $request->filter_color);
            });
        }

        // 💰 PRICE
        if ($request->filled('filter_price')) {
            foreach ((array) $request->filter_price as $range) {
                if ($range === 'all') continue;
                [$min, $max] = explode(';', $range);
                if ($max === '+') {
                    $query->where('price', '>=', (int)$min * 100);
                } else {
                    $query->whereBetween('price', [(int)$min * 100, (int)$max * 100]);
                }
            }
        }

        match ($request->input('tab')) {
            'featured' => $query->where('featured', 1),
            'new' => $query->whereNotNull('date_approve_sale')
                ->where('date_approve_sale', '>=', now()->subDays(Product::NEW_DAYS)),
            'sale' => $query->where(function ($q) {
                // знижка на конкретний товар
                $q->whereHas('discounts', fn($sub) => $sub->active()->where('type', 'product'))
                    // АБО знижка на категорію до якої належить товар
                    ->orWhereHas('subKindProduct.discounts', fn($sub) => $sub->active()->where('type', 'category'));
            }),
            default    => null,
        };

        // 🔽 SORT
        switch ($request->input('sort_by')) {
            case 'price_up':   $query->orderBy('price', 'asc');       break;
            case 'price_down': $query->orderBy('price', 'desc');      break;
            case 'newness':    $query->orderBy('created_at', 'desc'); break;
            default:           $query->latest();
        }

        // 📄 PER PAGE — cols × 3 рядки
        $cols    = max(3, min(5, (int) $request->input('cols', 4)));
        $default = $cols * 3;
        $allowed = [8, 9, 12, 15, 16, 20, 24, 32];
        $perPage = in_array((int) $request->input('per_page'), $allowed)
            ? (int) $request->input('per_page')
            : $default;

        $products = $query->paginate($perPage)->withQueryString();

        // === ПІДРАХУНОК ТОВАРІВ У КАТЕГОРІЯХ ===
        $kind_products = KindProduct::with(['subKindProducts' => function ($q) {
            $q->withCount('products');
        }])
            ->get()
            ->map(function ($kind) {
                $kind->product_count = $kind->subKindProducts->sum('products_count');
                return $kind;
            });

        // === ПІДРАХУНОК ПО ЦІНІ ===
        $priceCounts = [
            '0;100'    => Product::whereBetween('price', [0,       10000])->count(),
            '100;500'  => Product::whereBetween('price', [10000,   50000])->count(),
            '500;1000' => Product::whereBetween('price', [50000,  100000])->count(),
            '1000;+'   => Product::where('price', '>=', 100000)->count(),
        ];

        $featured_products = Product::where('featured', 1)->where('status_product_id', '>' , 2)->with('productPhotos')->take(5)->get();
        return view('products.index', [
            'products'          => $products,
            'kind_products'     => $kind_products,
            'price_counts'      => $priceCounts,
            'colors'            => Color::all(),
            'featured_products' => $featured_products,
            'current_sort'      => $request->input('sort_by', 'menu_order'),
            'current_per_page'  => $perPage,
            'current_cols'      => $cols,
            'current_tab'       => $request->input('tab', ''),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', Product::class);
        $user = Auth::user();
        $brands = Brand::where('creator_id', $user->id)->get();
        $images = $this->getDemoImages();

        $arr_kind_products     = KindProduct::pluck('title')->toArray();
        $arr_sub_kind_products = SubKindProduct::pluck('title')->toArray();

        $selectedKind    = old('kind_product_id')    ?: $request->input('kind_product_id');
        $selectedSubKind = old('sub_kind_product_id') ?: $request->input('sub_kind_product_id');

        return view('products.form', [
            'product' => null,
            'action'  => route('products.store'),
            'method'  => 'POST',
            'title'   => 'Додати новий товар',
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

        } catch (\Exception $e) {
            \Log::error('store error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }

        return redirect()->route('products.show', $product->id)->with('success', 'Товар успішно створено!');
    }

    public function show(Product $product)
    {
        $product->load(['brand', 'subKindProduct.kindProduct', 'colors', 'productPhotos']);

        $images = $product->productPhotos
            ->sortBy('queue')
            ->map(fn ($photo) => [
                'id'    => $photo->id,
                'src'   => Storage::disk('public')->url($photo->paths['zoom'] ?? $photo->paths['original']),
                'main'  => Storage::disk('public')->url($photo->paths['original'] ?? ''),
                'thumb' => Storage::disk('public')->url($photo->paths['small'] ?? $photo->paths['original']),
                'w'     => 1200,
                'h'     => 1600,
            ])
            ->values()
            ->toArray();

        return view('products.show', [
            'product' => $product,
            'images'  => $images,
        ]);
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        $user   = Auth::user();
        $brands = Brand::where('creator_id', $user->id)->get();

        // Формуємо масив $images з реальних фото продукту
        $images = $product->productPhotos
            ->sortBy('queue')
            ->map(fn ($photo) => [
                'id'    => $photo->id,
                'src'   => Storage::disk('public')->url($photo->paths['zoom']    ?? $photo->paths['original']),
                'main'  => Storage::disk('public')->url($photo->paths['original'] ?? ''),
                'thumb' => Storage::disk('public')->url($photo->paths['small']   ?? $photo->paths['original']),
                'w'     => 1200,
                'h'     => 1600,
            ])
            ->values()
            ->toArray();

        $arr_kind_products     = KindProduct::pluck('title')->toArray();
        $arr_sub_kind_products = SubKindProduct::pluck('title')->toArray();

        $selectedKind    = old('kind_product_id')    ?: $product->subKindProduct?->kind_product_id;
        $selectedSubKind = old('sub_kind_product_id') ?: $product->sub_kind_product_id;

        return view('products.form', [
            'product'                      => $product,
            'action'                       => route('products.update', $product),
            'method'                       => 'PUT',
            'title'                        => 'Редагувати товар',
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
            'productId'             => $product->id,
            'user'                  => $user,
            'productImages'         => $product->productPhotos,
            'arr_kind_products'     => $arr_kind_products,
            'arr_sub_kind_products' => $arr_sub_kind_products,
            'colors'                => Color::all(),
        ]);
    }
    public function update(ProductRequest $request, Product $product, ProductService $service, ProductPhotoService $photoService)
    {
        $this->authorize('update', $product);

        $data = $request->validated();
        $mainPhotoIndex = (int) $request->input('main_photo_index', 0);

        try {
            DB::transaction(function () use ($data, $service, $product, $request, $photoService, $mainPhotoIndex) {

                $service->update($product, $data);

                // === ОБРОБКА ФОТОГРАФІЙ ТОВАРУ ===
                // 1. Soft-delete фото, які користувач видалив хрестиком
                if (!empty($data['deleted_photo_ids'])) {
                    foreach ($product->productPhotos()
                                 ->whereIn('id', $data['deleted_photo_ids'])
                                 ->get() as $photo) {

                        // Видаляємо файли з диска
                        foreach ($photo->paths as $path) {
                            Storage::disk('public')->delete($path);
                        }
                        $photo->delete(); // soft delete
                    }
                }

                // 2. Додаємо нові фото (через сервіс)
                if ($request->hasFile('product_photo')) {
                    $files = $request->file('product_photo');
                    $files = is_array($files) ? $files : [$files];
                    $photoService->storeMany($product, $files, $mainPhotoIndex);
                }

                // 3. Встановлюємо головне фото за індексом з форми
                $activePhotos = $product->productPhotos()
                    ->whereNull('deleted_at')
                    ->orderBy('queue')
                    ->get();

                if ($activePhotos->isNotEmpty()) {
                    // Скидаємо is_main у всіх активних фото
                    $product->productPhotos()
                        ->whereNull('deleted_at')
                        ->update(['is_main' => false]);

                    // Встановлюємо нове головне
                    if (isset($activePhotos[$mainPhotoIndex])) {
                        $activePhotos[$mainPhotoIndex]->update(['is_main' => true]);
                    } else {
                        $activePhotos[0]->update(['is_main' => true]);
                    }
                }
            });

        } catch (\Exception $e) {
            \Log::error('update error', ['message' => $e->getMessage()]);
            throw $e;
        }

        return redirect()->route('products.index')->with('success', 'Товар успішно оновлено!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);

        $product->delete(); // soft delete — просто заповнює deleted_at

        return redirect()->route('products.index')->with('success', 'Товар успішно видалено!');
    }

    // Відновити після soft delete
    public function restore(int $id): RedirectResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $this->authorize('restore', $product);

        $product->restore();

        return redirect()->route('products.index')->with('success', 'Товар відновлено!');
    }

// Видалити назавжди
    public function forceDestroy(int $id): RedirectResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $product);

        // Видаляємо фото з диску перед видаленням
        foreach ($product->productPhotos as $photo) {
            foreach ($photo->paths as $path) {
                \Storage::disk($photo->disk ?? 'public')->delete($path);
            }
            $photo->forceDelete();
        }

        $product->forceDelete();

        return redirect()->route('products.index')->with('success', 'Товар остаточно видалено!');
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

    public function byTag(string $tag)
    {
        $products = Product::where('tags', 'LIKE', "%{$tag}%")
            ->with(['productPhotos', 'brand', 'subKindProduct'])
            ->latest()
            ->paginate(12);

        // === ПІДРАХУНОК ТОВАРІВ У КАТЕГОРІЯХ (щоб сайдбар працював) ===
        $kind_products = KindProduct::with(['subKindProducts' => function ($q) {
            $q->withCount('products');
        }])
            ->get()
            ->map(function ($kind) {
                $kind->product_count = $kind->subKindProducts->sum('products_count');
                return $kind;
            });

        // === ПІДРАХУНОК ПО ЦІНІ ===
        $priceCounts = [
            '0;100'    => Product::whereBetween('price', [0,       10000])->count(),
            '100;500'  => Product::whereBetween('price', [10000,   50000])->count(),
            '500;1000' => Product::whereBetween('price', [50000,  100000])->count(),
            '1000;+'   => Product::where('price', '>=', 100000)->count(),
        ];

        $featured_products = Product::where('featured', 1)
            ->where('status_product_id', '>' , 2)
            ->with('productphotos')->take(5)
            ->get();

        return view('products.index', [
            'products'          => $products,
            'kind_products'     => $kind_products,
            'price_counts'      => $priceCounts,
            'colors'            => Color::all(),
            'current_tag'       => $tag,           // для відображення активного тегу
            'title'             => 'Товари з тегом #' . $tag,
            'current_sort'      => 'newness',
            'current_per_page'  => 12,
            'current_cols'      => 4,
            'current_tab'       => '',
            'featured_products' => $featured_products,
        ]);
    }

    public function suggest(Request $request): \Illuminate\Http\JsonResponse
    {
        $q = trim($request->input('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json([]);
        }
        $products = Product::query()
            ->with(['productPhotos' => fn($q) => $q->where('is_main', true)->limit(1)])
            ->where('title', 'like', '%' . $q . '%')
            ->where('status_product_id', '>', 2)
            ->orderBy('title')
            ->limit(6)
            ->get(['id', 'title', 'price']);

        return response()->json(
            $products->map(fn($p) => [
                'id'    => $p->id,
                'title' => $p->title,
                'price' => number_format($p->price / 100, 2, '.', ' '),
                'photo' => $p->productPhotos->first()?->paths['small']
                    ? asset('storage/' . $p->productPhotos->first()->paths['small'])
                    : null,
                'url'   => route('products.show', $p->id),
            ])
        );
    }
}
