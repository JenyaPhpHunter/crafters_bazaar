<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KindProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
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
