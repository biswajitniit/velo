<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_name',
        'account_number',
        'routing_number',
        'swift_code',
        'iban',
        'branch_name',
        'account_type',
        'currency',
        'is_primary',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
            'status' => 'boolean',
        ];
    }

    /**
     * User who owns this bank account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Masked account number for security preview
     */
    public function getMaskedAccountNumberAttribute(): string
    {
        $num = trim($this->account_number ?? '');
        if (strlen($num) <= 4) {
            return $num;
        }
        return '•••• ' . substr($num, -4);
    }
}
