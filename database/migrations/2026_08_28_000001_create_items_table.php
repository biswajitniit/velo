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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('num')->index(); // e.g. ITEM-001 or SVC-001
            $table->string('short_desc'); // Short description / item name
            $table->text('full_desc')->nullable(); // Detailed description
            $table->string('uom')->default('Each'); // Each, Hour, Day, Month, Year, Project, Sq Ft, etc.
            $table->string('type', 20)->default('product'); // product or service
            $table->decimal('price', 12, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->boolean('active')->default(true)->index();

            // Tax Settings
            $table->string('tax_flag', 20)->default('taxable'); // taxable or exempt
            $table->string('tax_source', 30)->nullable(); // manual, avatax, taxjar, stripe_tax, custom
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->string('tax_name', 100)->nullable();
            $table->string('tax_code', 100)->nullable();
            $table->string('ptc', 100)->nullable();
            $table->string('tax_category', 100)->nullable();
            $table->string('stripe_tax_code', 100)->nullable();
            $table->string('tax_behavior', 20)->default('exclusive');
            $table->string('ext_tax_code', 100)->nullable();

            // Audit
            $table->date('status_effective_date')->nullable();
            $table->date('last_updated_date')->nullable();
            $table->string('last_updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
