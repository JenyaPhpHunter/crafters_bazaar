<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Promotion extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'show_in_header',
        'show_on_homepage',
        'sort_order',
        'url',
        'active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'active'           => 'boolean',
        'show_in_header'   => 'boolean',
        'show_on_homepage' => 'boolean',
        'starts_at'        => 'datetime',
        'ends_at'          => 'datetime',
        'sort_order'       => 'integer',
    ];

    // ===== Scopes =====

    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('active', true)
            ->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn($q) => $q->whereNull('ends_at')->orWhere('ends_at', '>=', now()));
    }

    public function scopeForHeader(Builder $query): Builder
    {
        return $query->where('show_in_header', true)->orderBy('sort_order');
    }

    public function scopeForHomepage(Builder $query): Builder
    {
        return $query->where('show_on_homepage', true)->orderBy('sort_order');
    }

    // ===== Хелпери =====

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path
            ? Storage::disk('public')->url($this->image_path)
            : null;
    }

    public function isExpired(): bool
    {
        return $this->ends_at && $this->ends_at->isPast();
    }
}
