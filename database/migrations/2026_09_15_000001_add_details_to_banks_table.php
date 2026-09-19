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
        Schema::table('banks', function (Blueprint $table) {
            if (!Schema::hasColumn('banks', 'swift_code')) {
                $table->string('swift_code')->nullable()->after('routing_number');
            }
            if (!Schema::hasColumn('banks', 'iban')) {
                $table->string('iban')->nullable()->after('swift_code');
            }
            if (!Schema::hasColumn('banks', 'branch_name')) {
                $table->string('branch_name')->nullable()->after('iban');
            }
            if (!Schema::hasColumn('banks', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn(['swift_code', 'iban', 'branch_name', 'notes']);
        });
    }
};
