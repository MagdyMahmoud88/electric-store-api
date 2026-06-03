<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'status',
        // ❌ products_count شيلناها — تتحسب دايماً بـ withCount() مش تتخزن يدوياً
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // ══════════════════════════════════════════════════════════════
    //  Boot — توليد الـ slug تلقائياً
    // ══════════════════════════════════════════════════════════════

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            // نعيد توليد الـ slug فقط لو الـ name تغير وما فيش slug مخصوص
            if ($category->isDirty('name') && ! $category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ══════════════════════════════════════════════════════════════
    //  العلاقات
    // ══════════════════════════════════════════════════════════════

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // ══════════════════════════════════════════════════════════════
    //  Scopes
    // ══════════════════════════════════════════════════════════════

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // ══════════════════════════════════════════════════════════════
    //  Accessors
    // ══════════════════════════════════════════════════════════════

    /**
     * للتوافق مع أي كود قديم يستخدم $category->is_active
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }
}
