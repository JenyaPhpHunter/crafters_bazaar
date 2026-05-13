<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Discount extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'product_id',
        'sub_kind_product_id',
        'percent',
        'fixed_amount',
        'active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'active'     => 'boolean',
        'starts_at'  => 'datetime',
        'ends_at'    => 'datetime',
        'percent'    => 'integer',
        'fixed_amount' => 'integer',
    ];

    // ===== Відносини =====

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function subKindProduct()
    {
        return $this->belongsTo(SubKindProduct::class);
    }

    // ===== Scopes =====

    // Тільки активні та в межах терміну дії
    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('active', true)
            ->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }

    public function scopeForProduct(Builder $query, int $productId): Builder
    {
        return $query->where('type', 'product')->where('product_id', $productId);
    }

    public function scopeForCategory(Builder $query, int $subKindProductId): Builder
    {
        return $query->where('type', 'category')->where('sub_kind_product_id', $subKindProductId);
    }

    // ===== Хелпери =====

    // Розрахувати суму знижки для переданої ціни (в копійках)
    public function calculateDiscount(int $price): int
    {
        if ($this->percent) {
            return (int) round($price * $this->percent / 100);
        }

        if ($this->fixed_amount) {
            return min($this->fixed_amount, $price); // знижка не може бути більше ціни
        }

        return 0;
    }

    // Отримати фінальну ціну після знижки
    public function applyTo(int $price): int
    {
        return max(0, $price - $this->calculateDiscount($price));
    }
}
