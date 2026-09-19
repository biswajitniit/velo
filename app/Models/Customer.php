<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'user_code',
        'name',
        'first_name',
        'last_name',
        'email',
        'type',
        'role',
        'status',
        'is_subscriber',
        'two_fa',
        'last_active',
        'contact_name',
        'billing_address',
        'initials',
        'color',
        'av_class',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_subscriber' => 'boolean',
        'two_fa' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    /**
     * Compute initials if not explicitly set.
     */
    public function getInitialsAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if (!empty($this->first_name) || !empty($this->last_name)) {
            return strtoupper(substr($this->first_name ?? '', 0, 1) . substr($this->last_name ?? '', 0, 1));
        }

        $words = preg_split('/\s+/', trim($this->name ?? ''));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return strtoupper(substr($this->name ?? 'CL', 0, 2));
    }
}
