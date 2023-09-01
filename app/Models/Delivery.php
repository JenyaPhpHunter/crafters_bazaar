<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Delivery extends Model
{
use HasFactory;

    protected $fillable = ['name', 'price', 'free_from'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
