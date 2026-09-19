<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'client_name',
        'client_email',
        'contact_name',
        'billing_address',
        'quote_number',
        'prefix',
        'issue_date',
        'expiry_date',
        'status',
        'currency',
        'po_number',
        'project_id',
        'notes',
        'terms',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_rate',
        'discount_amount',
        'shipping_amount',
        'handling_amount',
        'total_amount',
        'converted_invoice_id',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'handling_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class)->orderBy('order', 'asc');
    }

    public function convertedInvoice()
    {
        return $this->belongsTo(Invoice::class, 'converted_invoice_id');
    }

    public function getFullQuoteNumberAttribute()
    {
        return ($this->prefix ?? 'QUO-') . $this->quote_number;
    }

    public function getIsExpiredAttribute()
    {
        if ($this->status === 'accepted' || $this->status === 'rejected') {
            return false;
        }
        return $this->expiry_date && Carbon::parse($this->expiry_date)->isPast();
    }
}
