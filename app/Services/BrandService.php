<?php

namespace App\Services;

use App\Mail\BrandInvitationMail;
use App\Models\Brand;
use App\Exceptions\BrandCreationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;


class BrandService
{
    public static function createBrand(array $data): Brand
    {
        $authUserId = auth()->id();
        DB::beginTransaction();

        try {
            $brandData = [
                'title' => $data['title'],
                'content' => $data['content'] ?? null,
                'image_path' => $data['image_path'] ?? null,
                'rating' => $data['rating'] ?? null,
                'createdby' => $authUserId,
            ];

            $brand = Brand::create($brandData);

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
                'title' => $data['title'],
                'content' => $data['content'] ?? $brand->content,
                'rating' => $data['rating'] ?? $brand->rating,
                'createdby' => auth()->id(),
            ];

            if (isset($data['image_path'])) {
                $updateData['image_path'] = $data['image_path'];
            }

            $brand->update($updateData);

//            if (array_key_exists('user_ids', $data)) {
//                $brand->users()->sync($data['user_ids']);
//            }

            DB::commit();

            return $brand;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new BrandCreationException('Не вдалося оновити бренд: ' . $e->getMessage());
        }
    }

    public static function handleBrandImage(?UploadedFile $image): ?string
    {
        if (!$image?->isValid()) {
            return null;
        }

        // Зберігає у storage/app/public/brands і повертає шлях, наприклад brands/abc123.jpg
        return $image->store('brands', 'public');
    }


    public static function inviteUsersToBrand(array $emails, Brand $brand, EmailService $emailService): void
    {
        foreach ($emails as $email) {
            $trimmedEmail = trim($email);
            if (!filter_var($trimmedEmail, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            $emailService->sendEmail(new BrandInvitationMail($brand), $trimmedEmail);
        }
    }

}
