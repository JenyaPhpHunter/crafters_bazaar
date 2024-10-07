<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KindPayment extends Model
{
    use softDeletes;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
