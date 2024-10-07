<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    protected $fillable = [
        'name'
    ];

    public function order()
    {
        return $this->belongsTo(AdminOrder::class);
    }
}
