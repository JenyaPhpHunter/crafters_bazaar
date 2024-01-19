<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewPost extends Model
{
    protected $fillable = [
        'name', 'address'
    ];
}
