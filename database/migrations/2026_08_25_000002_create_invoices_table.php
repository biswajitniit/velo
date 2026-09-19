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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();

            // Client snapshot info (in case customer is ad-hoc or updated)
            $table->string('client_name');
            $table->string('client_email')->nullable();
            $table->string('contact_name')->nullable();
            $table->text('billing_address')->nullable();

            // Invoice identifiers
            $table->string('invoice_number'); // e.g. 0024
            $table->string('prefix')->default('INV-');
            $table->string('type')->default('REG'); // REG, REC, CM, DM
            $table->string('currency', 10)->default('USD');

            // Dates & status
            $table->date('issue_date');
            $table->date('due_date');
            $table->string('status')->default('draft'); // draft, sent, paid, overdue, ready

            // References
            $table->string('po_number')->nullable();
            $table->string('project_id')->nullable();
            $table->string('quote_id')->nullable();

            // Notes and Terms
            $table->text('notes')->nullable();
            $table->text('terms')->nullable();

            // Financial amounts
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->decimal('tax_amount', 12, 2)->default(0.00);
            $table->decimal('shipping_amount', 12, 2)->default(0.00);
            $table->decimal('handling_amount', 12, 2)->default(0.00);
            $table->decimal('discount_rate', 5, 2)->default(0.00);
            $table->decimal('discount_amount', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->decimal('paid_amount', 12, 2)->default(0.00);

            // Recurring settings
            $table->string('recurring_frequency')->nullable(); // weekly, biweekly, monthly, quarterly, semiannual, annual
            $table->date('recurring_start_date')->nullable();
            $table->date('recurring_end_date')->nullable();
            $table->boolean('recurring_auto_send')->default(false);
            $table->unsignedInteger('recurring_max_occurrences')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
