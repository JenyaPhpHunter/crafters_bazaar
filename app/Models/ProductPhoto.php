<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProductPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'queue',
        'is_main',
        'base',
        'ext',
        'disk',
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

    public function getSmallUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->paths['small'] ?? $this->paths['original']);
    }
}
