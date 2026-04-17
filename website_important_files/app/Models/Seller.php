<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'approved',
        'shop_name',
        'slug',
        'logo',
        'description',
        'business_email',
        'support_phone',
        'address',
        'facebook_page',
        'instagram_profile',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // توليد/تحديث slug تلقائيًا لو مش مبعوت
    protected static function booted()
    {
        static::creating(function (Seller $seller) {
            if (empty($seller->slug)) {
                $seller->slug = Str::slug($seller->shop_name) . '-' . Str::random(6);
            }
        });
        static::updating(function (Seller $seller) {
            if ($seller->isDirty('shop_name') && empty($seller->slug)) {
                $seller->slug = Str::slug($seller->shop_name) . '-' . Str::random(6);
            }
        });
    }
}
