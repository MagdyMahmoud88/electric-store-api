<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EmailVerificationOtp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used'       => 'boolean',
    ];

    // ─── Scopes ───────────────────────────────────────────────

    /** كودات غير منتهية الصلاحية وغير مستخدمة */
    public function scopeValid($query, string $email): \Illuminate\Database\Eloquent\Builder
    {
        return $query
            ->where('email', $email)
            ->where('used', false)
            ->where('expires_at', '>', now());
    }

    // ─── Helpers ──────────────────────────────────────────────

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->used && !$this->isExpired();
    }
}
