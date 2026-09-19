<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'client_name',
        'client_email',
        'contact_name',
        'billing_address',
        'invoice_number',
        'prefix',
        'type',
        'currency',
        'issue_date',
        'due_date',
        'status',
        'po_number',
        'project_id',
        'quote_id',
        'notes',
        'terms',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'shipping_amount',
        'handling_amount',
        'discount_rate',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'recurring_frequency',
        'recurring_start_date',
        'recurring_end_date',
        'recurring_auto_send',
        'recurring_max_occurrences',
    ];

    protected $casts = [
        'issue_date' => 'date:Y-m-d',
        'due_date' => 'date:Y-m-d',
        'recurring_start_date' => 'date:Y-m-d',
        'recurring_end_date' => 'date:Y-m-d',
        'recurring_auto_send' => 'boolean',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'handling_amount' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
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
        return $this->hasMany(InvoiceItem::class)->orderBy('order');
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    /**
     * Full invoice number (e.g. INV-0024)
     */
    public function getFullInvoiceNumberAttribute(): string
    {
        return ($this->prefix ?? 'INV-') . $this->invoice_number;
    }

    /**
     * Check if invoice is overdue
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'paid') {
            return false;
        }

        if (!$this->due_date) {
            return false;
        }

        return Carbon::parse($this->due_date)->isPast();
    }
}
