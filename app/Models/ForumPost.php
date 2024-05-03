<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{

    protected $fillable = [
       'content', 'answer_to'
    ];

    public function forum_topic()
    {
        return $this->belongsTo(ForumTopic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answerTo()
    {
        return $this->belongsTo(ForumPost::class, 'answer_to');
    }
}
