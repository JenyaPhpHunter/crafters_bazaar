<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $fillable = ['name'];
    public function forum_sub_categories()
    {
        return $this->hasMany(ForumSubCategory::class);
    }
}
