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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('client_id')->nullable(); // e.g. CLT-001 or C-001
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('contact_name')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('initials', 10)->nullable();
            $table->string('color', 255)->nullable(); // avatar background gradient/hex
            $table->json('tags')->nullable(); // e.g. ["Retainer", "Agency"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
