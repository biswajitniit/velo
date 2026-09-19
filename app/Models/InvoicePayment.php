<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'status',
        'reference',
        'payment_date',
        'applied_date',
        'source',
        'amount',
    ];

    protected $casts = [
        'payment_date' => 'date:Y-m-d',
        'applied_date' => 'date:Y-m-d',
        'amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
