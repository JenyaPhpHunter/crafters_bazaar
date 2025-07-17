<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use softDeletes;


    protected $fillable = [
        'title',
        'content',
        'image_path',
        'rating',
        'creator_id'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function invitations()
    {
        return $this->hasMany(BrandInvitation::class);
    }
}
