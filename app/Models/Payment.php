<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'kashier_order_id',
        'transaction_id',
        'payment_ref',
        'status',
        'amount',
        'currency',
        'payment_method',
        'hash',
        'kashier_response',
        'notes',
    ];

    protected $casts = [
        'kashier_response' => 'array',
        'amount'           => 'decimal:2',
    ];

    // ── Relations ──────────────────────────────────────

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ─────────────────────────────────────────

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // ── Helpers ────────────────────────────────────────

    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    // ── Status Label (للعرض) ───────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'في الانتظار',
            'success'   => 'تم الدفع',
            'failed'    => 'فشل',
            'cancelled' => 'ملغي',
            'refunded'  => 'مسترجع',
            default     => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'success'   => 'success',
            'pending'   => 'warning',
            'failed'    => 'error',
            'cancelled' => 'ghost',
            'refunded'  => 'info',
            default     => 'ghost',
        };
    }
}