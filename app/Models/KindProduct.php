<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KindProduct extends Model
{
    protected $fillable = [
        'name'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function sub_kind_products()
    {
        return $this->hasMany(SubKindProduct::class);
    }
}
