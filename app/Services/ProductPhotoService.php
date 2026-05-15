<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductPhotoService
{
    private ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    /**
     * Додає нові фото з урахуванням soft-delete та правильного queue
     */
    public function storeMany(Product $product, array $files, int $mainIndex = 0, int $offset = 0): void
    {
        $maxQueue = $product->productPhotos()
            ->withTrashed()
            ->max('queue') ?? 0;
        foreach (array_values($files) as $i => $image) {
            if (!$image instanceof UploadedFile) continue;

            $queue  = $maxQueue + $i + 1;
            $isMain = ($offset + $i === $mainIndex); // ← враховуємо зсув

            $ext      = strtolower($image->getClientOriginalExtension() ?: 'jpg');
            $base     = (string) Str::uuid();
            $filename = $base . '.' . $ext;

            $original = $image->storeAs('products/original', $filename, 'public');

            $small = 'products/small/' . $filename;
            $this->saveFit($original, $small, 300, 400);

            $zoom = 'products/zoom/' . $filename;
            $this->saveResizeWidth($original, $zoom, 1200);

            $product->productPhotos()->create([
                'queue'   => $queue,
                'is_main' => $isMain,
                'base'    => $base,
                'ext'     => $ext,
                'disk'    => 'public',
                'paths'   => [
                    'original' => $original,
                    'small'    => $small,
                    'zoom'     => $zoom,
                ],
            ]);
        }
    }

    // === допоміжні методи (залишаються без змін) ===
    private function absPublicPath(string $relativePath): string
    {
        return storage_path('app/public/' . ltrim($relativePath, '/'));
    }

    private function saveFit(string $sourceRelative, string $targetRelative, int $w, int $h): void
    {
        $this->imageManager->read($this->absPublicPath($sourceRelative))
            ->cover($w, $h)
            ->save($this->absPublicPath($targetRelative));
    }

    private function saveResizeWidth(string $sourceRelative, string $targetRelative, int $width): void
    {
        $this->imageManager->read($this->absPublicPath($sourceRelative))
            ->scaleDown(width: $width)
            ->save($this->absPublicPath($targetRelative));
    }

    public function url(string $relativePath): string
    {
        return Storage::disk('public')->url($relativePath);
    }
}
