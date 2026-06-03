<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int         $id
 * @property string      $code
 * @property string      $type             percentage|fixed
 * @property float       $value
 * @property float       $min_order_amount
 * @property float|null  $max_discount
 * @property int|null    $usage_limit
 * @property int|null    $usage_limit_per_user
 * @property int         $used_count
 * @property bool        $is_active
 * @property \Carbon\Carbon|null $starts_at
 * @property \Carbon\Carbon|null $expires_at
 * @property \Carbon\Carbon      $created_at
 * @property \Carbon\Carbon      $updated_at
 *
 * @method static Builder active()
 * @method static static|null find(mixed $id)
 * @method static static findOrFail(mixed $id)
 * @method static Builder where(string $column, mixed $value)
 */
class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_amount', 'max_discount',
        'usage_limit', 'usage_limit_per_user', 'is_active',
        'starts_at', 'expires_at', 'used_count',
    ];

    protected $casts = [
        'is_active'            => 'boolean',
        'starts_at'            => 'datetime',
        'expires_at'           => 'datetime',
        'value'                => 'decimal:2',
        'min_order_amount'     => 'decimal:2',
        'max_discount'         => 'decimal:2',
        'usage_limit'          => 'integer',
        'usage_limit_per_user' => 'integer',
        'used_count'           => 'integer',
    ];

    // ── العلاقات ──────────────────────────────────────────

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'coupon_usage')->withTimestamps();
    }

    // ── Scopes ────────────────────────────────────────────

    /**
     * الكوبونات النشطة فقط
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(fn($q) => $q->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()));
    }

    // ── Helpers ───────────────────────────────────────────

    /**
     * هل الكوبون صالح للاستخدام؟
     */
    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && $this->starts_at->isFuture()) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }

    /**
     * هل اليوزر استخدم الكوبون قبل كده؟
     */
    public function usedByUser(int $userId): bool
    {
        if ($this->usage_limit_per_user === null) return false;

        $count = $this->users()->where('user_id', $userId)->count();
        return $count >= $this->usage_limit_per_user;
    }

    /**
     * حساب قيمة الخصم بناءً على المجموع
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_order_amount) return 0;

        if ($this->type === 'percentage') {
            $discount = $subtotal * ($this->value / 100);
            if ($this->max_discount) {
                $discount = min($discount, (float) $this->max_discount);
            }
            return round($discount, 2);
        }

        // fixed
        return (float) min($this->value, $subtotal);
    }

    /**
     * وصف الكوبون للعرض
     */
    public function getDescriptionAttribute(): string
    {
        if ($this->type === 'percentage') {
            $desc = "خصم {$this->value}%";
            if ($this->max_discount) {
                $desc .= " (بحد أقصى " . number_format($this->max_discount, 0) . " ج.م)";
            }
        } else {
            $desc = "خصم " . number_format($this->value, 0) . " ج.م";
        }

        if ($this->min_order_amount > 0) {
            $desc .= " على طلبات أكثر من " . number_format($this->min_order_amount, 0) . " ج.م";
        }

        return $desc;
    }
}
