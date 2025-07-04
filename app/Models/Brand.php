<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Brand extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image_path',
        'rating',
        'createdby'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'brand_user');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'createdby');
    }

    public function invitations()
    {
        return $this->hasMany(BrandInvitation::class);
    }

}
