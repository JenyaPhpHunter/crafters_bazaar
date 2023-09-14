<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Basket extends Model
{
use HasFactory;

    protected $fillable = ['active','user_id','order_id', 'product_id', 'quantity', 'price', 'pricediscount', 'sum', 'discount', 'total',];

    public function product()
    {
    return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(AdminOrder::class);
    }

    public function getBasketProductsUser($user_id)
    {
        $basket = DB::table('baskets')
        ->select('id','product_id', 'quantity', 'price', 'total')
            ->where('user_id', $user_id)
            ->where('active', 1)
            ->get();

        return $basket;
    }

}
