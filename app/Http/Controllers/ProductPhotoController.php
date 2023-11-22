<?php

namespace App\Http\Controllers;

use App\Models\ProductPhoto;
use Illuminate\Http\Request;

class ProductPhotoController extends Controller
{
    public function upload(Request $request, $product_id)
    {
        if ($request->hasFile('product_photo')) {
            $photo = $request->file('product_photo')[0];
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $image_extension = $photo->getClientOriginalExtension();

            if (in_array($image_extension, $allowedExtensions)) {
                // Генерувати унікальне ім'я файлу, наприклад, на основі часу
                $original_name = date('Ymd_His') . '_' . $photo->getClientOriginalName();
                // Зберегти оригінальне зображення на сервер
                $photo->move(public_path('photos'), $original_name);

                // Зберегти інформацію про оригінальне зображення в базу даних, пов'язану з продуктом
                $productPhoto = new ProductPhoto();
                $productPhoto->filename = $original_name; // Зберегти ім'я файлу
                $productPhoto->ext = $image_extension; // Зберегти розширення
                $productPhoto->path = 'photos';
                $productPhoto->link = '';
                $productPhoto->queue = 1;
                $productPhoto->product_id = $product_id; // Пов'язати із продуктом

                $productPhoto->save();

                // Викликати функцію для зменшення розміру і збереження зменшеного зображення
                $this->resizeAndSaveImage($productPhoto);
            } else {
                return false;
            }
        }
        return true;
    }

// Функція для зменшення розміру зображення
    private function resizeAndSaveImage(ProductPhoto $productPhoto)
    {
        $newWidth = 137; // Бажана ширина

        // Завантаження оригінального зображення
        $originalImage = imagecreatefromjpeg(public_path('photos') . '/' . $productPhoto->filename);
        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        // Розрахунок нової висоти для збереження пропорцій
        $newHeight = ($originalHeight / $originalWidth) * $newWidth;

        // Створення пустого зображення заданого розміру
        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        // Зменшення розміру оригінального зображення до нового розміру
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        // Генерувати унікальне ім'я для зменшеного зображення
        $small_name = pathinfo($productPhoto->filename, PATHINFO_FILENAME) . '_small.' . $productPhoto->ext;

        // Збереження нового зображення на те саме місце з новим ім'ям
        imagejpeg($newImage, public_path('photos') . '/' . $small_name);

        // Зберегти інформацію про зменшене зображення в базу даних
        $productPhoto->small_filename = $small_name; // Зберегти ім'я файлу
        $productPhoto->small_ext = $productPhoto->ext; // Зберегти розширення
        $productPhoto->small_path = $productPhoto->path;
        $productPhoto->save();

        // Звільнення пам'яті
        imagedestroy($originalImage);
        imagedestroy($newImage);
    }

//    public function upload(Request $request, $product_id)
//    {
//        if ($request->hasFile('product_photo')) {
//            $photos = $request->file('product_photo');
//            foreach ($photos as $photo) {
//                $filename = $photo->store('photos');
//            }
//        }
//        if ($request->hasFile('product_photo')) {
//            $photos = $request->file('product_photo');
//            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
//            foreach ($photos as $photo) {
//                $image_extension = $photo->getClientOriginalExtension();
//                if (in_array($image_extension, $allowedExtensions)) {
//                    // Генерувати унікальне ім'я файлу, наприклад, на основі часу
//                    $photo_name = date('Ymd_His') . '_' . $photo->getClientOriginalName();
//                    // Зберегти файл на сервер
//                    $photo->move(public_path('photos'), $photo_name);
//                    // Зберегти ім'я файлу в базу даних, пов'язане з продуктом
//                    $productPhoto = new ProductPhoto();
//                    $productPhoto->filename = $photo_name; // Зберегти ім'я файлу
//                    $productPhoto->ext = $image_extension; // Зберегти  розширення
//                    $productPhoto->path = 'photos';
//                    $productPhoto->link = '';
//                    $productPhoto->queue = 1;
//                    $productPhoto->product_id = $product_id; // Пов'язати із продуктом
//
//                    $productPhoto->save();
//                } else {
//                    return false;
//                }
//            }
//        }
//        return true;
//    }
}
