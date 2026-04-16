<?php

namespace App\Models;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cartItems():HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists():HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
   public function hasInWishlist(int $productId): bool
{
   return $this->wishlists()->where('product_id', $productId)->exists();
}

// ══ أضيف في User model ══

public function reviews(): HasMany
{
    return $this->hasMany(Review::class);
}

// هل اليوزر راجع المنتج ده قبل كده؟
public function hasReviewed(int $productId): bool
{
    return $this->reviews()->where('product_id', $productId)->exists();
}

public function addresses(): HasMany
{
    return $this->hasMany(Address::class);
}
}
