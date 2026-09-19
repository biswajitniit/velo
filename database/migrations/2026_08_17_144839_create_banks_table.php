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
        Schema::create('banks', function (Blueprint $table) {
            $table->id();

            // Owner
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Bank details
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('routing_number')->nullable();

            // Currency
            $table->string('currency', 3)->default('USD');

            // Account type
            $table->enum('account_type', [
                'checking',
                'savings',
            ])->default('checking');

            // Primary bank account
            $table->boolean('is_primary')->default(false);

            // Status
            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->index('user_id');
            $table->index('is_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
