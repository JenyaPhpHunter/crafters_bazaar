<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'filename',
        'ext',
        'path',
        'link',
        'queue',
        'hover_filename',
        'hover_ext',
        'hover_path',
        'zoom_filename',
        'zoom_ext',
        'zoom_path',
        'small_filename',
        'small_ext',
        'small_path',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
