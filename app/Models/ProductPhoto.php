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

    public function getUrlAttribute()
    {
        // Формуємо повний шлях: path/filename.ext
        return asset('storage/products/' . $this->path . '/' . $this->filename . '.' . $this->ext);
    }

    public function getZoomUrlAttribute()
    {
        $zoomPath = $this->zoom_path . '/' . $this->zoom_filename . '.' . $this->zoom_ext;
        $fullPath = public_path('storage/products/' . $zoomPath);
        return file_exists($fullPath)
            ? asset('storage/products/' . $zoomPath)
            : $this->url;
    }

    public function getThumbUrlAttribute()
    {
        $thumbPath = $this->small_path . '/' . $this->small_filename . '.' . $this->small_ext;
        $fullPath = public_path('storage/products/' . $thumbPath);
        return file_exists($fullPath)
            ? asset('storage/products/' . $thumbPath)
            : $this->url;
    }

}
