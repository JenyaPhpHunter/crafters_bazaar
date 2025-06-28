<?php

namespace App\Services;

use App\Http\Controllers\ProductPhotoController;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductService
{
    const VALIDATION_RULES = [
        'title' => 'nullable|string|max:255',
        'sub_kind_product_id' => 'nullable|integer|exists:sub_kind_products,id',
        'content' => 'nullable|string',
        'brand_id' => 'nullable|integer|exists:brands,id',
        'links_networks' => 'nullable|string',
        'price' => 'nullable|integer|min:0',
        'discount' => 'nullable|integer|min:0',
        'stock_balance' => 'nullable|integer|min:0',
        'color_id' => 'nullable|integer|exists:colors,id',
        'term_creation' => 'nullable|integer|min:0',
        'status_product_id' => 'required|integer|exists:status_products,id',
        'user_id' => 'required|integer|exists:users,id',
        'new' => 'nullable|boolean',
        'featured' => 'nullable|boolean',
        'active' => 'nullable|boolean',
        'date_put_up_for_sale' => 'nullable|date',
        'date_approve_sale' => 'nullable|date',
        'admin_id' => 'nullable|integer|exists:users,id',
        'additional_information' => 'nullable|string',
    ];

//class ProductService
//{
//    public const VALIDATION_RULES = [/* ... */];
//    public const VALIDATION_MESSAGES = [/* ... */];
//
//    public function create(array $data): Product
//    {
//        return Product::create($data);
//    }
//}

public function createProduct($request, $function_name, $id = NULL)
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        $action = $data['action'];
        if ($function_name == 'store') {
            $product = new Product();
            if ($action == 'put_up_for_sale') {
                $validator = Validator::make($data, [
                    'title' => 'required',
                    'sub_kind_product_id' => 'required',
                    'content' => 'required',
                    'price' => 'required',
                    'stock_balance' => 'required',
                    'color_id' => 'required',
                    'brand_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }
            } else {
                $product->status_product_id = 1;
            }
            if (isset($data['title'])){
                $product->title = $data['title'];
            }
            if (isset($data['sub_kind_product_id'])){
                $product->sub_kind_product_id = $data['sub_kind_product_id'];
            }
//            if ($request->file('brand_image') && $request->file('brand_image')->isValid()) {
//                $brandImage = $request->file('brand_image');
//            $brandImageName = 'brand_' . time() . '.' . $brandImage->getClientOriginalExtension();
//            $brandImage->move(public_path('images/brands'), $brandImageName);
//
//            // Збереження шляху в моделі (наприклад)
//            $product->brand_image = 'images/brands/' . $brandImageName;
//            }
            $product->content = $data['content'];
            $product->price = $data['price'];
            $product->stock_balance = $data['stock_balance'];
            $product->color_id = $data['color_id'];
            $product->term_creation = $data['term_creation'];
            $product->user_id = $data['user_id'];
            $product->created_at = date("Y-m-d H:i:s");

            $product->save();

            if($request->product_photo){
                $product_photo = new ProductPhotoController();
                $product_photo->upload($request, $product->id);
            }
        } elseif ($function_name = 'update'){
            $product = Product::query()->where('id',$id)->first();
            if(!$product){
                throw new \Exception('Product not found');
            }
            if ($action == 'put_up_for_sale' || $action == 'put_for_sale_from_show') {
                if ($action == 'put_for_sale_from_show'){
                    $data['title'] = $product->title;
                    $data['sub_kind_product_id'] = $product->sub_kind_product_id;
                    $data['content'] = $product->content;
                    $data['price'] = $product->price;
                    $data['stock_balance'] = $product->stock_balance;
                    $data['color_id'] = $product->color_id;
                    $data['term_creation'] = $product->term_creation;
                }

                $validator = Validator::make($data, [
                    'title' => 'required',
                    'sub_kind_product_id' => 'required',
                    'content' => 'required',
                    'price' => 'required',
                    'stock_balance' => 'required',
                    'color_id' => 'required',
                    'brand_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                if ($validator->fails()) {
                    throw new ValidationException($validator);
                }
            }

            if (isset($data['title'])){
                $product->title = $data['title'];
            }
            if ($request->file('brand_image') && $request->file('brand_image')->isValid()) {
                $brandImage = $request->file('brand_image');
                $brandImageName = 'brand_' . time() . '.' . $brandImage->getClientOriginalExtension();
                $brandImage->move(public_path('images/brands'), $brandImageName);
                $newBrandModel = new Brand();
                $newBrandModel->create();
    //TODO зберегти або оновити фото бренду

                // Збереження шляху в моделі (наприклад)
//                $product->brand_image = 'images/brands/' . $brandImageName;
            }
            $product->sub_kind_product_id = $data['sub_kind_product_id'];
            $product->content = $data['content'];
            $product->price = $data['price'];
            $product->stock_balance = $data['stock_balance'];
            $product->color_id = $data['color_id'];
            $product->term_creation = $data['term_creation'];
            if ($user->role_id > 4) {
                $product->user_id = $data['user_id'];
            } else {
                $product->admin_id = $data['user_id'];
            }
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

    private function saveBrand()
    {

    }
}
