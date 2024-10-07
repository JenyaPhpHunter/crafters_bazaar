<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'index', 'region', 'latitude', 'longitude', 'warehouse'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
