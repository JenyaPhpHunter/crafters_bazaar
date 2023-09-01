<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
use HasFactory;

    protected $fillable = ['baskettmp_created', 'name', 'phone', 'email', 'delivery', 'paymentkind', 'card', 'shop',
        'city', 'address', 'np_address', 'user', 'promocode', 'sum', 'pricedelivery', 'discount', 'discounttotal',
        'quantity', 'total', 'textdelivery',
        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }
}
