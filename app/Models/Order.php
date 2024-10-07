<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'sum_order',
        'card',
        'cart_id',
        'kind_payment_id',
        'comment',
        'delivery_id',
        'region_id',
        'city_id',
        'address',
        'newpost_id',
        'promocode',
        'pricedelivery',
        'status_order_id',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function kind_payment()
    {
        return $this->belongsTo(KindPayment::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function status_order()
    {
        return $this->belongsTo(StatusOrder::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
