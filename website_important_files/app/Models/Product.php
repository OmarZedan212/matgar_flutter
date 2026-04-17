<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['seller_id', 'image_path','category_id','name','slug','description','price', 'cost','qty','thumbnail'];

    protected $casts = [
        'price' => 'decimal:2',
        'qty' => 'integer',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function booted()
    {
        static::creating(function (Product $p) {
            if (empty($p->slug)) {
                $p->slug = Str::slug($p->name) . '-' . Str::random(6);
            }
        });
    }
}
