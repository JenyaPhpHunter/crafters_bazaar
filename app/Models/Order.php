<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['card', 'address', 'promocode', 'pricedelivery', 'comment','sum_order'];

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
}
