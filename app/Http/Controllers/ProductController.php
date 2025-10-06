<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\KindProduct;
use App\Models\SubKindProduct;
use App\Models\Color;
use App\Models\StatusProduct;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function create(): View
    {
        $user = Auth::user();
        $brands = Brand::where('creator_id', $user->id);

        return view('products.create', [
            'kindProducts' => KindProduct::all(),
            'subKindProducts' => SubKindProduct::all(),
            'colors' => Color::all(),
            'brands' => $brands,
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

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $request->validate([
            'image' => 'nullable|image|max:2048',
            'brand_id' => 'nullable|exists:brands,id',
            // Інші правила валідації...
        ]);

        $product = new Product();
        $brandId = $request->input('brand_id');

        if ($brandId) {
            $product->brand_id = $brandId;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('brands', 'public');

            // Оптимізація та обрізка до 70x70
            $img = Image::make(storage_path('app/public/' . $path))->fit(70, 70);
            $img->save();

            $product->image_path = $path;
        }

        $product->save();

        return redirect()->back()->with('success', 'Продукт створено!');
    }

    public function edit(Product $product): View
    {
        $productImages = $product?->productphotos ?? collect();

        return view('products.edit', [
            'product' => $product,
            'colors' => Color::all(),
            'kind_products' => KindProduct::all(),
            'sub_kind_products' => SubKindProduct::all(),
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
