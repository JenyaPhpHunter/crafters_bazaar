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
    public function subkindproduct()
    {
        return $this->belongsTo(SubKindProduct::class);
    }
}
