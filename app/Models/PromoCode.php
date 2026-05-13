<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class PromoCode extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'type',
        'percent',
        'fixed_amount',
        'usage_limit',
        'usage_count',
        'usage_limit_per_user',
        'min_order_amount',
        'active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'active'               => 'boolean',
        'percent'              => 'integer',
        'fixed_amount'         => 'integer',
        'usage_limit'          => 'integer',
        'usage_count'          => 'integer',
        'usage_limit_per_user' => 'integer',
        'min_order_amount'     => 'integer',
        'starts_at'            => 'datetime',
        'ends_at'              => 'datetime',
    ];

    // ===== Відносини =====

    public function usages()
    {
        return $this->hasMany(PromoCodeUsage::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, PromoCodeUsage::class, 'promo_code_id', 'id', 'id', 'user_id');
    }

    // ===== Scopes =====

    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('active', true)
            ->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }

    // ===== Хелпери =====

    // Перевірити чи промокод взагалі можна використати
    public function isAvailable(): bool
    {
        if (!$this->active) return false;
        if ($this->starts_at && $this->starts_at->isFuture()) return false;
        if ($this->ends_at && $this->ends_at->isPast()) return false;
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) return false;

        return true;
    }

    // Перевірити чи конкретний користувач може використати промокод
    public function isAvailableForUser(int $userId): bool
    {
        if (!$this->isAvailable()) return false;

        if ($this->usage_limit_per_user) {
            $userUsages = $this->usages()->where('user_id', $userId)->count();
            if ($userUsages >= $this->usage_limit_per_user) return false;
        }

        return true;
    }

    // Перевірити мінімальну суму замовлення
    public function isApplicableToAmount(int $orderAmount): bool
    {
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    // Розрахувати суму знижки для переданої суми замовлення (в копійках)
    public function calculateDiscount(int $orderAmount): int
    {
        if (!$this->isApplicableToAmount($orderAmount)) return 0;

        if ($this->type === 'percent' && $this->percent) {
            return (int) round($orderAmount * $this->percent / 100);
        }

        if ($this->type === 'fixed' && $this->fixed_amount) {
            return min($this->fixed_amount, $orderAmount);
        }

        return 0;
    }

    // Збільшити лічильник використань
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }
}
