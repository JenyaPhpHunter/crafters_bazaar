<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKindProduct extends Model
{
    protected $fillable = [
        'name'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_kind_product_id');
    }

    public function kind_product()
    {
        return $this->belongsTo(KindProduct::class);
    }

}
