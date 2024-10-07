<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'sum',
        'pricediscount',
        'total',
        'active',
    ];

    public function cartitems()
    {
    return $this->HasMany(CartItems::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

}
