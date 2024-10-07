<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    public function forum_sub_categories()
    {
        return $this->hasMany(ForumSubCategory::class);
    }
}
