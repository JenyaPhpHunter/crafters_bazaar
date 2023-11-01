<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
use HasFactory;

    protected $fillable = ['active', 'del', 'cart_id', 'product_id', 'quantity', 'price', 'pricediscount'];

    public function cartitems()
    {
    return $this->HasMany(CartItems::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
