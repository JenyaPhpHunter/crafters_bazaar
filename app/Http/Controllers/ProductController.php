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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function customBreadcrumbs(string $routeName, array $parameters): array
    {
        if ($routeName === 'products.show' && isset($parameters['product'])) {
            return [
                [
                    'title' => ['Товари', 'Деталі'],
                    'name' => 'Деталі продукту',
                    'route' => route('products.show', $parameters['product']),
                ],
            ];
        }
        return [];
    }

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

    public function index(ProductRequest $request)
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

    public function create(): View
    {
        $user = Auth::user();
        $brands = Brand::where('creator_id', $user->id)->get();
        $images = [];
        $images = $this->getDemoImages();

        return view('products.create', [
            'brands' => $brands,
            'images' => $images,
            'selected_kind_product_id' => old('kind_product_id'),
            'selected_sub_kind_product_id' => old('sub_kind_product_id'),
            'action_types' => [
                'add_kind' => 'Додати вид',
                'add_sub_kind' => 'Додати підвид',
                'put_up_for_sale' => 'Виставити на продаж',
                'save' => 'Зберегти як чернетку'
            ],
            'productId' => 0,
            'user' => $user,
            'productImages' => collect(),
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

        $product = DB::transaction(function () use ($data, $service, $request, $photoService, $mainPhotoIndex) {
            $product = $service->create($data);

            DB::afterCommit(function () use ($request, $product, $photoService, $mainPhotoIndex) {
                if (!$request->hasFile('product_photo')) {
                    return;
                }

                $files = $request->file('product_photo');
                $files = is_array($files) ? $files : [$files];

                // ✅ ПЕРЕДАЄМО $mainPhotoIndex
                $photoService->storeMany($product, $files, $mainPhotoIndex);
            });

            return $product;
        });

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

    public function createkindsubkind(int $id): View
    {
        $allKindProducts = KindProduct::pluck('title');
        $allSubKindProducts = SubKindProduct::pluck('title');

        return view('products.create_kind_subkind', [
            'product_id' => $id,
            'arr_kind_products' => $allKindProducts->isNotEmpty() ? $allKindProducts->toArray() : [false],
            'arr_sub_kind_products' => $allSubKindProducts->isNotEmpty() ? $allSubKindProducts->toArray() : [false],
        ]);
    }

}
