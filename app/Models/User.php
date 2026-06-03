<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    // ══════════════════════════════════════════════════════════
    //  Role Constants
    // ══════════════════════════════════════════════════════════

    const ROLE_USER  = 'user';
    const ROLE_ADMIN = 'admin';

    // ══════════════════════════════════════════════════════════
    //  Fillable / Hidden / Casts
    // ══════════════════════════════════════════════════════════

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'otp',
        'otp_expires_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'otp_expires_at',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at'    => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ══════════════════════════════════════════════════════════
    //  Role Helpers
    // ══════════════════════════════════════════════════════════

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    // ══════════════════════════════════════════════════════════
    //  Status Helpers
    // ══════════════════════════════════════════════════════════

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    // ══════════════════════════════════════════════════════════
    //  OTP Helpers
    // ══════════════════════════════════════════════════════════

    public function hasValidOtp(string $otp): bool
    {
        return $this->otp === $otp
            && $this->otp_expires_at !== null
            && $this->otp_expires_at->isFuture();
    }

    public function clearOtp(): void
    {
        $this->update([
            'otp'            => null,
            'otp_expires_at' => null,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    //  Relations
    // ══════════════════════════════════════════════════════════

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress(): HasOne
    {
        return $this->hasOne(Address::class)
            ->where('is_default', true)
            ->latestOfMany();
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function returnRequests(): HasMany
    {
        return $this->hasMany(ReturnRequest::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(UserActivityLog::class)->latest();
    }

    // ══════════════════════════════════════════════════════════
    //  Scopes
    // ══════════════════════════════════════════════════════════

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    public function scopeUsers($query)
    {
        return $query->where('role', self::ROLE_USER);
    }

    // ══════════════════════════════════════════════════════════
    //  Helper Methods
    // ══════════════════════════════════════════════════════════

    public function hasInWishlist(int $productId): bool
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }

    public function hasReviewed(int $productId): bool
    {
        return $this->reviews()->where('product_id', $productId)->exists();
    }

    public function totalSpent(): float
    {
        return (float) $this->orders()
            ->where('status', 'delivered')
            ->sum('total_price');
    }

    public function hasActiveOrders(): bool
    {
        return $this->orders()
            ->whereNotIn('status', ['delivered', 'cancelled', 'refunded'])
            ->exists();
    }
}
