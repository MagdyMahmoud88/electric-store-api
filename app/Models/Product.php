<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
protected $fillable = [
    'name',
    'description',
    'category_id',
    'brand_id',
    'image_url',
    'price',
    'stock',
    'discount',
];

/*
protected function imageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
{
    return \Illuminate\Database\Eloquent\Casts\Attribute::make(
        get: fn ($value) => $value ? asset('storage/' . $value) : null,
    );
}
*/


public function getImageAttribute($value)
{
    return asset('storage/' . $value);
}

    public function getDiscountedPriceAttribute()
    {
        return $this->price - ($this->price * $this->discount / 100);
    }

public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems():HasMany
    {
        return $this->hasMany(CartItem::class);
    }

     public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function brand():BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
  public function approvedReviews(): HasMany
{
    return $this->hasMany(Review::class)->where('is_approved', true);
}

// متوسط التقييم
public function getAverageRatingAttribute(): float
{
    return round($this->approvedReviews()->avg('rating') ?? 0, 1);
}

// عدد التقييمات
public function getRatingsCountAttribute(): int
{
    return $this->approvedReviews()->count();
}

}
