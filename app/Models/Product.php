<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'content', 'price', 'stock_balance'
    ];

    public function kind_product()
    {
        return $this->belongsTo(KindProduct::class);
    }
    public function status_product()
    {
        return $this->belongsTo(StatusProduct::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
