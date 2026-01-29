<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'price',
        'sub_kind_product_id',
        'stock_balance',
        'term_creation',
        'brand_id',
        'content',
        'tags',
        'social_links',
        'additional_information',
        'status_product_id',
        'creator_id',
        'admin_id',
        'date_put_up_for_sale',
        'date_approve_sale',
        'rating_avg',
        'rating_count',
        'featured',
        // ❌ 'color_ids' прибери — це НЕ колонка таблиці products
    ];

    protected $casts = [
        // числа
        'price' => 'integer',          // в БД копійки
        'stock_balance' => 'integer',
        'term_creation' => 'integer',
        'brand_id' => 'integer',
        'sub_kind_product_id' => 'integer',
        'status_product_id' => 'integer',
        'creator_id' => 'integer',
        'admin_id' => 'integer',
        'rating_avg' => 'integer',
        'rating_count' => 'integer',

        // булеве
        'featured' => 'boolean',

        // дати (включно з soft delete)
        'date_put_up_for_sale' => 'datetime',
        'date_approve_sale' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // --- Relations ---
    public function sub_kind_product()
    {
        return $this->belongsTo(SubKindProduct::class, 'sub_kind_product_id');
    }

    public function kind_product()
    {
        return $this->hasOneThrough(
            KindProduct::class,
            SubKindProduct::class,
            'id',                 // sub_kind_products.id
            'id',                 // kind_products.id
            'sub_kind_product_id',// products.sub_kind_product_id
            'kind_product_id'     // sub_kind_products.kind_product_id
        );
    }

    public function status_product()
    {
        return $this->belongsTo(StatusProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class); // color_product
    }

    public function productphotos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    // --- Price accessor/mutator ---
    // у БД: копійки (int)
    // у коді: гривні (float)
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => (int) round(((float) $value) * 100),
        );
    }

    // (опціонально) Зручні "віртуальні" поля
    // 1) ціна в копійках, якщо десь треба напряму без accessor
    public function getPriceCentsAttribute(): int
    {
        return (int) ($this->attributes['price'] ?? 0);
    }

    // 2) tags як масив (бо у БД string "a, b, c")
    public function getTagsArrayAttribute(): array
    {
        $raw = (string) ($this->attributes['tags'] ?? '');
        if (trim($raw) === '') return [];
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }

    // 3) social_links як масив (розділення комами)
    public function getSocialLinksArrayAttribute(): array
    {
        $raw = (string) ($this->attributes['social_links'] ?? '');
        if (trim($raw) === '') return [];
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }
}
