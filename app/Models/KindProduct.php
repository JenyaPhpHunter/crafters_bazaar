<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KindProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'user_id',
        'checked',
    ];

//    public function products()
//    {
//        return $this->hasMany(Product::class);
//    }
    public function subKindProducts()
    {
        return $this->hasMany(SubKindProduct::class);
    }
}
