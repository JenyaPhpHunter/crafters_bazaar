<?php

namespace App\Services;

use App\Http\Controllers\ProductPhotoController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    public function createProduct($request, $function_name, $action, $id = NULL)
    {
//        echo "<pre>";
//        print_r($function_name);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($action);
//        echo "</pre>";
//        echo "<pre>";
//        print_r($request->all());
//        echo "</pre>";
//        die();
        $user = User::find($request->input('user_id'));
        $action = $request->input('action');
        if ($function_name == 'store') {
            $product = new Product();
            if ($action == 'put_up_for_sale') {
                $validated = $request->validate([
                    'name' => 'required',
                    'sub_kind_product_id' => 'required',
                    'content' => 'required',
                    'price' => 'required',
                    'stock_balance' => 'required',
                    'color' => 'required',
                ]);

                $product->date_put_up_for_sale = date("Y-m-d H:i:s");
                $product->status_product_id = ($user->role_id > 4) ? 2 : 3;
            }

            $product->name = $request->input('name');
            $product->sub_kind_product_id = $request->input('sub_kind_product_id');
            $product->content = $request->input('content');
            $product->price = $request->input('price');
            $product->stock_balance = $request->input('stock_balance');
            $product->color_id = $request->input('color_id');
            $product->term_creation = $request->input('term_creation');
            $product->status_product_id = 1;
            $product->user_id = $request->input('user_id');
            $product->created_at = date("Y-m-d H:i:s");

            $product->save();

            // Обробити завантажені зображення
            if ($request->hasFile('product_photo')) {
                $photos = $request->file('product_photo');
                foreach ($photos as $photo) {
                    // Зберегти кожне зображення
                    $filename = $photo->store('photos'); // Зберегти зображення в папці "storage/app/products"
                    // Тут ви також можете виконати будь-які додаткові операції з файлами, наприклад, зберегти шляхи до зображень в базі даних.
                }
            }

        } elseif ($function_name = 'update'){
            $product = Product::query()->where('id',$id)->first();
            if(!$product){
                throw new \Exception('Product not found');
            }
            if ($action == 'put_up_for_sale') {
                $validated = $request->validate([
                    'name' => 'required',
                    'sub_kind_product_id' => 'required',
                    'content' => 'required',
                    'price' => 'required',
                    'stock_balance' => 'required',
                    'color_id' => 'required',
                ]);

                $product->date_put_up_for_sale = date("Y-m-d H:i:s");
                $product->status_product_id = ($user->role_id > 4) ? 2 : 3;
            }

            $product->name = $request->input('name');
            $product->sub_kind_product_id = $request->input('sub_kind_product_id');
            $product->content = $request->input('content');
            $product->price = $request->input('price');
            $product->stock_balance = $request->input('stock_balance');
            $product->color_id = $request->input('color_id');
            $product->term_creation = $request->input('term_creation');
            $product->status_product_id = 1;
            $product->user_id = $request->input('user_id');
            $product->updated_at = date("Y-m-d H:i:s");

            $product->save();
//            echo "<pre>";
//            print_r($request->product_photo);
//            echo "</pre>";
//            die();
            if($request->product_photo){
                $product_photo = new ProductPhotoController();
                $product_photo->upload($request, $product->id);
            }
        }

//        var_dump($product); exit();
        return $product;
    }
}
