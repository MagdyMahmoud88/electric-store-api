<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRequest extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'order_item_id',
        'product_id',
        'reason',
        'description',
        'status',
        'admin_note',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    // ══════════════════════════════════════
    //  العلاقات
    // ══════════════════════════════════════

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ══════════════════════════════════════
    //  Helpers
    // ══════════════════════════════════════

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    // ترجمة الأسباب
    public static function reasonLabels(): array
    {
        return [
            'defective'        => 'منتج تالف',
            'wrong_item'       => 'منتج مختلف عن المطلوب',
            'not_as_described' => 'مش زي ما وصفناه في الموقع',
            'changed_mind'     => 'غيّرت رأيي',
            'other'            => 'سبب آخر',
        ];
    }

    public function reasonLabel(): string
    {
        return self::reasonLabels()[$this->reason] ?? $this->reason;
    }

    // ترجمة الحالات
    public static function statusLabels(): array
    {
        return [
            'pending'   => 'في الانتظار',
            'approved'  => 'موافق عليه',
            'rejected'  => 'مرفوض',
            'completed' => 'تم الإرجاع',
        ];
    }

    public function statusLabel(): string
    {
        return self::statusLabels()[$this->status] ?? $this->status;
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'approved'  => 'info',
            'rejected'  => 'error',
            'completed' => 'success',
            default     => 'ghost',
        };
    }
}
