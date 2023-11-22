<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishItems extends Model
{
use HasFactory;

    protected $fillable = ['active', 'del', 'user_id', 'product_id', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
