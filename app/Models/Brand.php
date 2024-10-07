<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Brand
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'content',
        'path',
        'rating',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
