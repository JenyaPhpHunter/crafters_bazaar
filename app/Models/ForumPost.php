<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content',
        'forum_topic_id',
        'user_id',
        'answer_to',
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
