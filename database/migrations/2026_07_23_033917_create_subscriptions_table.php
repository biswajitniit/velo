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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('stripe_customer_id');
            $table->string('stripe_subscription_id')->unique()->nullable();
            $table->string('stripe_price_id');
            $table->string('stripe_product_id')->nullable();

            $table->string('plan_name');
            $table->decimal('amount', 10, 2);

            $table->enum('billing_cycle', ['monthly', 'yearly']);

            $table->enum('status', [
                'pending',
                'active',
                'trialing',
                'past_due',
                'canceled',
                'unpaid',
            ])->default('pending');

            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
