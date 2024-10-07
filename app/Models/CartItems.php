<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItems extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'pricediscount',
        'active',
    ];


    public function cart()
    {
    return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
