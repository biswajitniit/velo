<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'display_company_name',
        'industry',
        'street_address',
        'city',
        'state_province',
        'zip_postal_code',
        'country',
        'country_code',
        'mobile_number',
        'sms_notifications',
        'logo',
    ];

    protected $casts = [
        'display_company_name' => 'boolean',
        'sms_notifications' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return !empty($this->company_name)
            && !empty($this->industry)
            && !empty($this->street_address)
            && !empty($this->city)
            && !empty($this->country)
            && !empty($this->mobile_number);
    }
}
