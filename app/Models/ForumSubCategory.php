<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumSubCategory extends Model
{
    protected $fillable = ['name'];

    public function forum_category()
    {
        return $this->belongsTo(ForumCategory::class);
    }

    public function forum_topics()
    {
        return $this->hasMany(ForumTopic::class);
    }
}
