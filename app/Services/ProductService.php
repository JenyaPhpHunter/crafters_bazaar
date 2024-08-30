<?php

namespace App\Services;

use App\Http\Controllers\ProductPhotoController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductService
{
    public function createProduct($request, $function_name, $action, $id = NULL)
    {
        $data = $request->all();

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
                $validator = Validator::make($data, [
                    'name' => 'required',
                    'sub_kind_product_id' => 'required',
                    'content' => 'required',
                    'price' => 'required',
                    'stock_balance' => 'required',
                    'color_id' => 'required',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $product->date_put_up_for_sale = date("Y-m-d H:i:s");
                $product->status_product_id = ($user->role_id > 4) ? 2 : 3;
            }

            $product->name = $data['name'];
            if (isset($data['sub_kind_product_id'])){
                $product->sub_kind_product_id = $data['sub_kind_product_id'];
            }
            $product->content = $data['content'];
            $product->price = $data['price'];
            $product->stock_balance = $data['stock_balance'];
            $product->color_id = $data['color_id'];
            $product->term_creation = $data['term_creation'];
            $product->status_product_id = 1;
            $product->user_id = $data['user_id'];
            $product->created_at = date("Y-m-d H:i:s");

            $product->save();

            if($request->product_photo){
                $product_photo = new ProductPhotoController();
                $product_photo->upload($request, $product->id);
            }

//            // Обробити завантажені зображення
//            if ($request->hasFile('product_photo')) {
//                $photos = $request->file('product_photo');
//                foreach ($photos as $photo) {
//                    // Зберегти кожне зображення
//                    $filename = $photo->store('photos'); // Зберегти зображення в папці "storage/app/products"
//                    // Тут ви також можете виконати будь-які додаткові операції з файлами, наприклад, зберегти шляхи до зображень в базі даних.
//                }
//            }


        } elseif ($function_name = 'update'){
            $product = Product::query()->where('id',$id)->first();
            if(!$product){
                throw new \Exception('Product not found');
            }
            if ($action == 'put_up_for_sale') {

                $validator = Validator::make($data, [
                    'name' => 'required',
                    'sub_kind_product_id' => 'required',
                    'content' => 'required',
                    'price' => 'required',
                    'stock_balance' => 'required',
                    'color_id' => 'required',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $product->date_put_up_for_sale = date("Y-m-d H:i:s");
                $product->status_product_id = ($user->role_id > 4) ? 2 : 3;
            } elseif ($action == 'put_for_sale_from_show'){
                $data['name'] = $product->name;
                $data['sub_kind_product_id'] = $product->sub_kind_product_id;
                $data['content'] = $product->content;
                $data['price'] = $product->price;
                $data['stock_balance'] = $product->stock_balance;
                $data['color_id'] = $product->color_id;
                $data['term_creation'] = $product->term_creation;

                $validator = Validator::make($data, [
                    'name' => 'required',
                    'sub_kind_product_id' => 'required',
                    'content' => 'required',
                    'price' => 'required',
                    'stock_balance' => 'required',
                    'color_id' => 'required',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }

                $product->date_put_up_for_sale = date("Y-m-d H:i:s");
                $product->status_product_id = ($user->role_id > 4) ? 2 : 3;
            }

            $product->name = $data['name'];
            $product->sub_kind_product_id = $data['sub_kind_product_id'];
            $product->content = $data['content'];
            $product->price = $data['price'];
            $product->stock_balance = $data['stock_balance'];
            $product->color_id = $data['color_id'];
            $product->term_creation = $data['term_creation'];
            $product->user_id = $data['user_id'];
            $product->updated_at = date("Y-m-d H:i:s");

            $product->save();

            if($request->product_photo){
                $product_photo = new ProductPhotoController();
                $product_photo->upload($request, $product->id);
            }
        }
//        echo "<pre>";
//        print_r($product);
//        echo "<pre>";
//        exit();
        return $product;
    }
}
