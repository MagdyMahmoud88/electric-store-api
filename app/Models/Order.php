<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{

public $fillable = [
    'user_id',
    'total',
    'status',
    'notes',
];

public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    // في Order.php أضيف:

protected $casts = [
    'id' => 'string', // عشان الـ UUID
];

// ألوان وترجمة الحالات
public function getStatusLabelAttribute(): string
{
    return match($this->status) {
        'pending'    => 'قيد الانتظار',
        'processing' => 'قيد التجهيز',
        'shipped'    => 'تم الشحن',
        'delivered'  => 'تم التسليم',
        'cancelled'  => 'ملغي',
    };
}

public function getStatusColorAttribute(): string
{
    return match($this->status) {
        'pending'    => 'warning',
        'processing' => 'info',
        'shipped'    => 'primary',
        'delivered'  => 'success',
        'cancelled'  => 'error',
    };
}

}
