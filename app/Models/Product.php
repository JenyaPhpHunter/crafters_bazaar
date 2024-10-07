<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'sub_kind_product_id',
        'content',
        'links_networks',
        'price',
        'discount',
        'stock_balance',
        'color_id',
        'term_creation',
        'status_product_id',
        'user_id',
        'new',
        'featured',
        'active',
        'del',
        'date_put_up_for_sale',
        'date_approve_sale',
        'admin_id',
        'additional_information',
    ];

    public function sub_kind_product()
    {
        return $this->belongsTo(SubKindProduct::class);
    }
    public function kind_product()
    {
        return $this->hasOneThrough(
            KindProduct::class,
            SubKindProduct::class,
            'id',                    // Foreign key on SubKindProduct table
            'id',                    // Foreign key on KindProduct table
            'sub_kind_product_id',   // Local key on Product table
            'kind_product_id'        // Local key on SubKindProduct table
        );
    }

    public function status_product()
    {
        return $this->belongsTo(StatusProduct::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function admin()
    {
        return $this->belongsTo(User::class);
    }
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function productphotos()
    {
        return $this->HasMany(ProductPhoto::class);
    }
}
