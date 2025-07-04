<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandInvitation extends Model
{
    protected $fillable = ['brand_id', 'email', 'invited_by', 'accepted_at'];

    protected $dates = ['last_sent_at'];

    protected $casts = [
        'last_sent_at' => 'datetime',
    ];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}

