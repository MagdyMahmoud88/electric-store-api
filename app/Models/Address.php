<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
    'first_name',
    'last_name',
    'phone',
    'street_address',
    'area',
    'building_number',
    'city',
    'governorate',
    'is_default',
    'user_id',
    ];
    public function user ():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
