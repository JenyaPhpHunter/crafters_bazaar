<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WishItems extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'price',
        'active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
