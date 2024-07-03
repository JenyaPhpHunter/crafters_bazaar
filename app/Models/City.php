<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name', 'index', 'region', 'latitude', 'longitude', 'warehouse'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
