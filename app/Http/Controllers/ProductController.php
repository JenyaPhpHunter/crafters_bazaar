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
        $query = Product::query()->with(['productphotos']);

        // 🔎 SEARCH
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 📂 CATEGORIES
        if ($request->filled('categories')) {
            $query->whereHas('subKindProduct', function ($q) use ($request) {
                $q->whereIn('kind_product_id', $request->categories);
            });
        }

        // 🎨 COLORS (якщо використовуєш)
        if ($request->filled('filter_color')) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->whereIn('php_name', $request->filter_color);
            });
        }

        // 💰 PRICE
        if ($request->filled('filter_price')) {
            foreach ($request->filter_price as $range) {
                if ($range === 'all') continue;
                [$min, $max] = explode(';', $range);
                $query->where(function ($q) use ($min, $max) {
                    if ($max === '+') {
                        $q->where('price', '>=', $min);
                    } else {
                        $q->whereBetween('price', [$min, $max]);
                    }
                });
            }
        }

        // 🔽 SORT
        switch ($request->get('sort_by')) {
            case 'price_up':
                $query->orderBy('price', 'asc');
                break;
            case 'price_down':
                $query->orderBy('price', 'desc');
                break;
            case 'newness':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->latest();
        }

        // Кількість товарів на сторінці
        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage)->withQueryString();

        return view('products.index', [
            'products'        => $products,
            'kind_products'   => KindProduct::all(),
            'colors'          => Color::all(),
            'featured_products' => Product::where('featured', 1)->take(5)->get(),
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

        return redirect()->route('products.index')->with('success', 'Товар успішно створено!');
    }


    public function edit(Product $product): View
    {
        $this->authorize('update', $product);

        $user   = Auth::user();
        $brands = Brand::where('creator_id', $user->id)->get();

        // Формуємо масив $images з реальних фото продукту
        $images = $product->productphotos
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

        $selectedKind    = old('kind_product_id')    ?: $product->sub_kind_product?->kind_product_id;
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
            'productImages'         => $product->productphotos,
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
                    foreach ($product->productphotos()
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
                $activePhotos = $product->productphotos()
                    ->whereNull('deleted_at')
                    ->orderBy('queue')
                    ->get();

                if ($activePhotos->isNotEmpty()) {
                    // Скидаємо is_main у всіх активних фото
                    $product->productphotos()
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
        foreach ($product->productphotos as $photo) {
            foreach ($photo->paths as $path) {
                \Storage::disk($photo->disk ?? 'public')->delete($path);
            }
            $photo->forceDelete();
        }

        $product->forceDelete();

        return redirect()->route('products.index')->with('success', 'Товар остаточно видалено!');
    }
}
