<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BrandImageService
{
    public static function handle(?UploadedFile $image): ?string
    {
        return $image?->isValid() ? $image->store('brands', 'public') : null;
    }

    public static function processForUpdate(Request $request, Brand $brand): array
    {
        $validated = $request->validated();

        if ($request->boolean('remove_image') && $brand->image_path) {
            Storage::disk('public')->delete($brand->image_path);
            $validated['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($brand->image_path) {
                Storage::delete('public/' . $brand->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('brands', 'public');
        }

        return $validated;
    }

    public static function delete(Brand $brand): void
    {
        if ($brand->image_path) {
            Storage::disk('public')->delete($brand->image_path);
            $brand->image_path = null;
            $brand->save();
        }
    }
}
