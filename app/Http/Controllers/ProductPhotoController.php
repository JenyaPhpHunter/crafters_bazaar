<?php

namespace App\Http\Controllers;

use App\Models\ProductPhoto;
use Illuminate\Http\Request;

class ProductPhotoController extends Controller
{
    public function upload(Request $request, $product_id)
    {
        // Обробити завантажені зображення
        if ($request->hasFile('product_photo')) {
            $photos = $request->file('product_photo');
            foreach ($photos as $photo) {
                // Зберегти кожне зображення
                $filename = $photo->store('photos'); // Зберегти зображення в папці "storage/app/products"
                // Тут ви також можете виконати будь-які додаткові операції з файлами, наприклад, зберегти шляхи до зображень в базі даних.
            }
        }
        if ($request->hasFile('product_photo')) {
            $photos = $request->file('product_photo');
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            foreach ($photos as $photo) {
                $image_extension = $photo->getClientOriginalExtension();
                if (in_array($image_extension, $allowedExtensions)) {
                    // Генерувати унікальне ім'я файлу, наприклад, на основі часу
                    $photo_name = date('Ymd_His') . '_' . $photo->getClientOriginalName();
                    // Зберегти файл на сервер
                    $photo->move(public_path('photos'), $photo_name);
                    // Зберегти ім'я файлу в базу даних, пов'язане з продуктом
                    $productPhoto = new ProductPhoto();
                    $productPhoto->filename = $photo_name; // Зберегти ім'я файлу
                    $productPhoto->ext = $image_extension; // Зберегти  розширення
                    $productPhoto->path = 'photos';
                    $productPhoto->link = '';
                    $productPhoto->queue = 1;
                    $productPhoto->product_id = $product_id; // Пов'язати із продуктом

                    $productPhoto->save();
                } else {
                    return false;
                }
            }
        }
        return true;
    }
}
