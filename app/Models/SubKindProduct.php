<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKindProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'kind_product_id',
        'user_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'sub_kind_product_id');
    }

    public function kind_product()
    {
        return $this->belongsTo(KindProduct::class, 'kind_product_id');
    }

}
