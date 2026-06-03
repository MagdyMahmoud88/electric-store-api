<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderAddress extends Model
{
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'governorate',
        'city',
        'area',
        'street_address',
        'building_number',
        'floor',
        'apartment',
        'postal_code',
        'landmark',
        'country',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->street_address,
            $this->area,
            $this->city,
            $this->governorate,
        ])->filter()->implode('، ');
    }
}
