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
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'user_code')) {
                $table->string('user_code', 20)->nullable()->after('client_id');
            }
            if (!Schema::hasColumn('customers', 'first_name')) {
                $table->string('first_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('customers', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('customers', 'type')) {
                $table->string('type', 20)->default('client')->after('email');
            }
            if (!Schema::hasColumn('customers', 'role')) {
                $table->string('role', 50)->default('Client')->after('type');
            }
            if (!Schema::hasColumn('customers', 'status')) {
                $table->string('status', 30)->default('new')->after('role');
            }
            if (!Schema::hasColumn('customers', 'is_subscriber')) {
                $table->boolean('is_subscriber')->default(false)->after('status');
            }
            if (!Schema::hasColumn('customers', 'two_fa')) {
                $table->boolean('two_fa')->default(false)->after('is_subscriber');
            }
            if (!Schema::hasColumn('customers', 'last_active')) {
                $table->string('last_active')->nullable()->after('two_fa');
            }
            if (!Schema::hasColumn('customers', 'av_class')) {
                $table->string('av_class', 50)->nullable()->after('color');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'user_code', 'first_name', 'last_name', 'type', 'role',
                'status', 'is_subscriber', 'two_fa', 'last_active', 'av_class'
            ]);
        });
    }
};
