<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserActivityLog extends Model
{
    public $timestamps = false;

    // ══════════════════════════════════════════════════════════
    //  أنواع النشاط — ثوابت واضحة بدل magic strings
    // ══════════════════════════════════════════════════════════

    // Auth
    const TYPE_LOGIN          = 'login';
    const TYPE_LOGOUT         = 'logout';
    const TYPE_LOGIN_FAILED   = 'login_failed';
    const TYPE_PASSWORD_RESET = 'password_reset';
    const TYPE_EMAIL_VERIFIED = 'email_verified';

    // Orders
    const TYPE_ORDER_PLACED   = 'order_placed';
    const TYPE_ORDER_CANCELLED = 'order_cancelled';
    const TYPE_ORDER_RETURNED  = 'order_returned';

    // Reviews
    const TYPE_REVIEW_ADDED   = 'review_added';
    const TYPE_REVIEW_UPDATED = 'review_updated';
    const TYPE_REVIEW_DELETED = 'review_deleted';

    // Wishlist
    const TYPE_WISHLIST_ADDED   = 'wishlist_added';
    const TYPE_WISHLIST_REMOVED = 'wishlist_removed';

    // Profile
    const TYPE_PROFILE_UPDATED  = 'profile_updated';
    const TYPE_PASSWORD_CHANGED = 'password_changed';
    const TYPE_ADDRESS_ADDED    = 'address_added';

    // ──────────────────────────────────────────────────────────

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'loggable_type',
        'loggable_id',
        'metadata',
        'ip_address',
        'user_agent',
        'url',
    ];

    protected function casts(): array
    {
        return [
            'metadata'   => 'array',
            'created_at' => 'datetime',
        ];
    }

    // ══════════════════════════════════════════════════════════
    //  Relations
    // ══════════════════════════════════════════════════════════

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    // ══════════════════════════════════════════════════════════
    //  Scopes
    // ══════════════════════════════════════════════════════════

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ══════════════════════════════════════════════════════════
    //  Helpers
    // ══════════════════════════════════════════════════════════

    public function icon(): string
    {
        return match ($this->type) {
            self::TYPE_LOGIN          => '🔐',
            self::TYPE_LOGOUT         => '🚪',
            self::TYPE_LOGIN_FAILED   => '⛔',
            self::TYPE_PASSWORD_RESET => '🔑',
            self::TYPE_EMAIL_VERIFIED => '✅',
            self::TYPE_ORDER_PLACED   => '🛒',
            self::TYPE_ORDER_CANCELLED => '❌',
            self::TYPE_ORDER_RETURNED  => '↩️',
            self::TYPE_REVIEW_ADDED   => '⭐',
            self::TYPE_WISHLIST_ADDED => '❤️',
            self::TYPE_PROFILE_UPDATED => '✏️',
            default                   => '📌',
        };
    }

    public function color(): string
    {
        return match (true) {
            str_contains($this->type, 'failed')    => 'red',
            str_contains($this->type, 'cancelled') => 'orange',
            str_contains($this->type, 'login')     => 'blue',
            str_contains($this->type, 'order')     => 'green',
            str_contains($this->type, 'review')    => 'yellow',
            default                                => 'gray',
        };
    }
}
