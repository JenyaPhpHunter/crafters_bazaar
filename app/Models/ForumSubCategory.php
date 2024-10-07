<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumSubCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'forum_category_id',
    ];

    public function forum_category()
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function forum_topics()
    {
        return $this->hasMany(ForumTopic::class);
    }
}
