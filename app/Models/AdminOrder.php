<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminOrder extends Model
{
use HasFactory;

    protected $fillable = ['baskettmp_created', 'name', 'phone', 'email', 'delivery', 'paymentkind', 'card', 'shop',
        'city', 'address', 'np_address', 'user', 'promocode', 'sum', 'pricedelivery', 'discount', 'discounttotal',
        'quantity', 'total', 'textdelivery',
        ];
    protected $table = 'orders';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status_order()
    {
        return $this->belongsTo(StatusProduct::class);
    }
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function kind_payment()
    {
        return $this->belongsTo(KindPayment::class);
    }
}
