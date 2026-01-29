<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPhoto;
use App\Services\ProductPhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends Controller
{
    // Додати фото до існуючого продукту (наприклад з edit-сторінки)
    public function store(Request $request, Product $product, ProductPhotoService $photoService)
    {
        $request->validate([
            'product_photo' => 'required|array|max:10',
            'product_photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // якщо хочеш гарантію "після коміту", робимо транзакцію для reorder/інших дій
        DB::transaction(function () use ($request, $product, $photoService) {
            DB::afterCommit(function () use ($request, $product, $photoService) {
                $photoService->storeMany($product, $request->file('product_photo'));
            });
        });

        return back()->with('success', 'Фото додано');
    }

    // Видалити фото (soft delete) + прибрати файли (опціонально)
    public function destroy(Product $product, ProductPhoto $photo)
    {
        // захист: фото має належати цьому продукту
        abort_unless($photo->product_id === $product->id, 404);

        // якщо хочеш видаляти файли фізично — роби тут:
        // (якщо тобі треба лишати файли — просто прибери цей блок)
        $paths = array_filter([
            $photo->path,
            $photo->small_path,
            $photo->hover_path,
            $photo->zoom_path,
        ]);

        foreach ($paths as $p) {
            Storage::disk('public')->delete($p);
        }

        $photo->delete(); // soft delete

        return back()->with('success', 'Фото видалено');
    }

    // Переставити порядок фото (queue) — може знадобитись для drag&drop
    public function reorder(Request $request, Product $product)
    {
        $data = $request->validate([
            'photo_ids' => 'required|array|min:1',
            'photo_ids.*' => 'integer',
        ]);

        $ids = $data['photo_ids'];

        DB::transaction(function () use ($product, $ids) {
            foreach ($ids as $i => $id) {
                ProductPhoto::query()
                    ->where('product_id', $product->id)
                    ->where('id', $id)
                    ->update(['queue' => $i + 1]);
            }
        });

        return response()->json(['ok' => true]);
    }
}
