<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumTopic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'forum_sub_category_id',
    ];

    public function forum_category()
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function forum_sub_category()
    {
        return $this->belongsTo(ForumSubCategory::class);
    }
    public function forum_posts()
    {
        return $this->hasMany(ForumPost::class);
    }
}
