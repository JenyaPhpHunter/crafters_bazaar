<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
         'filename', 'ext', 'path', 'link', 'queqe', 'hover_filename', 'hover_ext', 'hover_path',
         'zoom_filename', 'zoom_ext', 'zoom_path', 'small_filename', 'small_ext', 'small_path',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
