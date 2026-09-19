<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'num',
        'short_desc',
        'full_desc',
        'uom',
        'type',
        'price',
        'currency',
        'active',
        'tax_flag',
        'tax_source',
        'tax_rate',
        'tax_name',
        'tax_code',
        'ptc',
        'tax_category',
        'stripe_tax_code',
        'tax_behavior',
        'ext_tax_code',
        'status_effective_date',
        'last_updated_date',
        'last_updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'active' => 'boolean',
        'status_effective_date' => 'date',
        'last_updated_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
