<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'queue',
        'is_main',
        'base',
        'ext',
        'paths',
    ];

    protected $casts = [
        'paths' => 'array',
        'is_main' => 'boolean',
        'queue' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
