<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKindProduct extends Model
{
    protected $fillable = [
        'name'
    ];

    public function kind_product()
    {
        return $this->belongsTo(KindProduct::class);
    }
}
