<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name', 'description', 'category_id', 'brand_id',
        'image_url', 'price', 'stock', 'discount_percentage','is_active',
    ];

    public function getImageSrc(): string
    {
        return $this->image_url
            ? asset('storage/' . $this->image_url)
            : asset('images/placeholder.png');
    }
    public function getPlaceholder(): string
    {
        return asset('images/placeholder.png');
    }

    public function getEffectiveDiscountAttribute(): float
    {
        $productDiscount = $this->discount_percentage ?? 0;
        $brandDiscount   = $this->brand?->active_discount ?? 0;

        return max($productDiscount, $brandDiscount);
    }

    // ✅ السعر النهائي بعد الخصم
    public function getFinalPriceAttribute(): float
    {
        return round($this->price * (1 - $this->effective_discount / 100), 2);
    }

    // ✅ للتوافق مع الكود القديم
    public function getDiscountedPriceAttribute(): float
    {
        return $this->final_price;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function brand(): BelongsTo
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

    public function getAverageRatingAttribute(): float
    {
        return round($this->approved_reviews_avg_rating
            ?? $this->approvedReviews()->avg('rating')
            ?? 0, 1);
    }

    public function getRatingsCountAttribute(): int
    {
        return $this->approved_reviews_count
            ?? $this->approvedReviews()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
