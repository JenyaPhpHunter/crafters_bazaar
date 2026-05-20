<?php

namespace App\Services;

use App\Models\Brand;
use App\Exceptions\BrandCreationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandService
{
    public static function createBrand(array $data): Brand
    {
        $authUserId = auth()->id();
        DB::beginTransaction();

        try {
            $brand = Brand::create([
                'title'      => $data['title'],
                'content'    => $data['content'] ?? null,
                'image_path' => $data['image_path'] ?? null,
                'creator_id' => $authUserId,
                // rating_avg і rating_count — програмні поля, не з форми
            ]);

            $brand->users()->syncWithoutDetaching([$authUserId]);

            DB::commit();

            return $brand;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new BrandCreationException('Не вдалося створити бренд: ' . $e->getMessage());
        }
    }

    public static function updateBrand(Brand $brand, array $data): Brand
    {
        DB::beginTransaction();

        try {
            $updateData = [
                'title'   => $data['title'],
                'content' => $data['content'] ?? $brand->content,
            ];

            if (isset($data['image_path'])) {
                $updateData['image_path'] = $data['image_path'];
            }

            $brand->update($updateData);

            DB::commit();

            return $brand;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new BrandCreationException('Не вдалося оновити бренд: ' . $e->getMessage());
        }
    }

    public static function getFilteredBrands(Request $request): array
    {
        $query = Brand::with(['users:id,name'])->withCount('users');

        if ($request->boolean('with_trashed')) {
            $query->withTrashed()->where('creator_id', auth()->id());
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $validSortFields = ['title', 'created_at', 'updated_at', 'rating_avg', 'users_count'];
        $sortField     = in_array($request->input('sort_by'), $validSortFields)
            ? $request->input('sort_by')
            : 'created_at';
        $sortDirection = in_array($request->input('sort_dir'), ['asc', 'desc'])
            ? $request->input('sort_dir')
            : 'desc';

        $query->orderBy($sortField, $sortDirection);

        return [
            'brands'        => $query->paginate($request->input('per_page', 10))->appends($request->query()),
            'search'        => $search,
            'sortField'     => $sortField,
            'sortDirection' => $sortDirection,
            'perPage'       => $request->input('per_page', 10),
        ];
    }
}
