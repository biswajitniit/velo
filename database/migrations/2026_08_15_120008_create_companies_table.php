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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            // Company owner
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('company_name');
            $table->boolean('display_company_name')->default(true);

            $table->string('industry')->nullable();

            $table->string('street_address');
            $table->string('city');
            $table->string('state_province')->nullable();
            $table->string('zip_postal_code')->nullable();
            $table->string('country');

            // Mobile & SMS
            $table->string('country_code', 10)->nullable();
            $table->string('mobile_number', 30)->nullable();
            $table->boolean('sms_notifications')->default(false);

            // Company logo
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
