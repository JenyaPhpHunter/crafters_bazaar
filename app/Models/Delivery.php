<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use softDeletes;

    protected $fillable = ['name', 'price', 'free_from'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
