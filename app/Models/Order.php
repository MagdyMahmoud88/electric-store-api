<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use App\Notifications\LowStockNotification;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'payment_method',
        'subtotal', 'tax', 'shipping', 'discount', 'total',
        'status',
        'coupon_id',
        'payment_status',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'paid_at'  => 'datetime',
        'subtotal' => 'float',
        'tax'      => 'float',
        'shipping' => 'float',
        'discount' => 'float',
        'total'    => 'float',
    ];

    // ══════════════════════════════════════════════════════════
    //  Relations
    // ══════════════════════════════════════════════════════════

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(OrderAddress::class);
    }

    // ══════════════════════════════════════════════════════════
    //  Accessors
    // ══════════════════════════════════════════════════════════

    public function getFullNameAttribute(): string
    {
        return trim(
            ($this->address?->first_name ?? '') . ' ' .
            ($this->address?->last_name  ?? '')
        );
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'        => 'قيد الانتظار',
            'processing'     => 'قيد التجهيز',
            'shipped'        => 'تم الشحن',
            'delivered'      => 'تم التسليم',
            'cancelled'      => 'ملغي',
            'payment_failed' => 'فشل الدفع',
            default          => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'        => 'warning',
            'processing'     => 'info',
            'shipped'        => 'primary',
            'delivered'      => 'success',
            'cancelled'      => 'error',
            'payment_failed' => 'error',
            default          => 'ghost',
        };
    }


    public function arabicText(?string $text): string
    {
        if (empty($text)) return '';

        try {
            $arabic = new \ArPHP\I18N\Arabic();

            // بيحدد مواقع الأجزاء العربية في النص
            $positions = $arabic->arIdentify($text);

            // بيعمل reshaping لكل جزء عربي
            for ($i = count($positions) - 1; $i >= 0; $i -= 2) {
                $start  = $positions[$i - 1];
                $length = $positions[$i] - $positions[$i - 1];

                $arabicPart  = substr($text, $start, $length);
                $reshaped    = $arabic->utf8Glyphs($arabicPart);

                $text = substr_replace($text, $reshaped, $start, $length);
            }

            return $text;

        } catch (\Exception $e) {
            Log::error('ArPHP error: ' . $e->getMessage());
            return $text; // ارجع النص الأصلي لو فيه مشكلة
        }
    }

    // ══════════════════════════════════════════════════════════
    //  Business Logic
    // ══════════════════════════════════════════════════════════

    public function deductStock(): void
    {
        foreach ($this->items as $item) {
            $product = $item->product;

            if (! $product) {
                Log::warning("المنتج غير موجود في الطلب #{$this->id}");
                continue;
            }

            if ($product->stock < $item->quantity) {
                Log::warning("مخزون غير كافٍ للمنتج ID: {$product->id}");
                continue;
            }

            $product->decrement('stock', $item->quantity);
            $product->refresh();

            if ($product->stock <= 10) {
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    try {
                        $admin->notify(new LowStockNotification($product));
                    } catch (\Exception $e) {
                        Log::error("فشل إرسال إشعار: " . $e->getMessage());
                    }
                }
            }
        }
    }

    public function shippingAddress(): HasOne
    {
        return $this->hasOne(\App\Models\OrderAddress::class);
    }
}
