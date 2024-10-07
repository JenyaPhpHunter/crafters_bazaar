<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    use SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'surname',
        'name',
        'secondname',
        'phone',
        'role_id',
        'category_user_id',
        'brand_id',
        'gender',
        'birthday',
        'region_id',
        'city_id',
        'address',
        'delivery_id',
        'newpost_id',
        'kind_payment_id',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function kindpayment()
    {
        return $this->belongsTo(KindPayment::class);
    }

    public function orders()
    {
        return $this->hasMany(AdminOrder::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function forum_posts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function category_user()
    {
        return $this->belongsTo(CategoryUser::class);
    }
}
