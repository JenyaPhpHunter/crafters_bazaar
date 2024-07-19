<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    protected $fillable = [
        'name', 'content', 'price', 'stock_balance',
    ];

    public function sub_kind_product()
    {
        return $this->belongsTo(SubKindProduct::class);
    }
    public function kind_product()
    {
        return $this->hasOneThrough(KindProduct::class, SubKindProduct::class, 'id', 'id', 'sub_kind_product_id', 'kind_product_id');
    }
    public function status_product()
    {
        return $this->belongsTo(StatusProduct::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function productphotos()
    {
        return $this->HasMany(ProductPhoto::class);
    }
}
