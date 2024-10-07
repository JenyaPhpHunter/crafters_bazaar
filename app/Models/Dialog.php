<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'comment',
        'product_id',
        'answer_to',
        'queue',
        'user_id',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Встановлення відношення "належить" до себе ж
    public function answerTo()
    {
        return $this->belongsTo(Dialog::class, 'answer_to');
    }
}
