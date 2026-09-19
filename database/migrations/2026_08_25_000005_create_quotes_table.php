<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();

            // Client snapshot info
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('contact_name')->nullable();
            $table->text('billing_address')->nullable();

            // Quote Details
            $table->string('quote_number')->index();
            $table->string('prefix', 20)->default('QUO-');
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('status', 30)->default('draft')->index(); // draft, sent, accepted, rejected, expired
            $table->string('currency', 10)->default('USD');

            // References
            $table->string('po_number')->nullable();
            $table->string('project_id')->nullable();

            // Notes & Terms
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();

            // Financials
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_rate', 5, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('shipping_amount', 12, 2)->default(0);
            $table->decimal('handling_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);

            // Conversion tracking
            $table->foreignId('converted_invoice_id')->nullable()->constrained('invoices')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
