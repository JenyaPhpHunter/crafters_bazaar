<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
use HasFactory;

    protected $fillable = ['active', 'del', 'cart_id', 'product_id', 'quantity', 'price', 'pricediscount'];

    public function cart()
    {
    return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
