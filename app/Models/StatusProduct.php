<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusProduct extends Model
{
    public const NEW = 1;
    public const APPROVED = 2;
    public const ON_SALE = 3;
    public const SOLD = 4;

    // Масив для форм і селектів
    public const LABELS = [
        self::NEW => 'Новий',
        self::APPROVED => 'На затвердженні',
        self::ON_SALE => 'В продажу',
        self::SOLD => 'Проданий',
    ];

    protected $fillable = [
        'name'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
