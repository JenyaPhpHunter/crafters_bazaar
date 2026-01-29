<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductPhotoService
{
    public function storeMany(Product $product, array $files): void
    {
        foreach (array_values($files) as $i => $image) {
            if (!$image instanceof UploadedFile) {
                continue;
            }

            $queue = $i + 1;

            $ext = strtolower($image->getClientOriginalExtension() ?: 'jpg');
            $base = (string) Str::uuid();
            $filename = $base . '.' . $ext;

            // ORIGINAL
            $original = $image->storeAs('products/original', $filename, 'public');

            // SMALL
            $small = 'products/small/' . $filename;
            $this->saveFit($original, $small, 300, 400);

            // ZOOM
            $zoom = 'products/zoom/' . $filename;
            $this->saveResizeWidth($original, $zoom, 1200);

            $product->productphotos()->create([
                'queue'   => $queue,
                'is_main' => $queue === 1,
                'base'    => $base,
                'ext'     => $ext,
                'paths'   => [
                    'original' => $original,
                    'small'    => $small,
                    'zoom'     => $zoom,
                ],
            ]);
        }
    }

    private function absPublicPath(string $relativePath): string
    {
        return storage_path('app/public/' . ltrim($relativePath, '/'));
    }

    private function saveFit(string $sourceRelative, string $targetRelative, int $w, int $h): void
    {
        \Image::make($this->absPublicPath($sourceRelative))
            ->fit($w, $h)
            ->save($this->absPublicPath($targetRelative));
    }

    private function saveResizeWidth(string $sourceRelative, string $targetRelative, int $width): void
    {
        \Image::make($this->absPublicPath($sourceRelative))
            ->resize($width, null, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            })
            ->save($this->absPublicPath($targetRelative));
    }

    public function url(string $relativePath): string
    {
        return Storage::disk('public')->url($relativePath);
    }
}
