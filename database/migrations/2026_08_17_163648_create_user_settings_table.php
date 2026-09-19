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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Banking
            |--------------------------------------------------------------------------
            */

            // Banking
            $table->foreignId('bank_id')
                ->nullable()
                ->constrained('banks')
                ->nullOnDelete();

            // Currency
            $table->string('default_currency', 3)
                ->default('AUD');

            // Fiscal year
            // 1 = January, 2 = February ... 12 = December
            $table->unsignedTinyInteger('fiscal_year_start')
                ->default(1);

            // Tax
            $table->decimal('default_tax_rate', 5, 2)
                ->default(0.00);

            // Reconciliation
            $table->boolean('auto_reconciliation')
                ->default(true);

            // Bank feed
            $table->enum('bank_feed_sync_frequency', [
                'realtime',
                'hourly',
                'daily',
                'manual',
            ])->default('manual');

            /*
            |--------------------------------------------------------------------------
            | Customers / Clients
            |--------------------------------------------------------------------------
            */

            // Example: CLT-0001
            $table->string('client_id_format')
                ->default('CLT-0001');

            // Default credit limit
            $table->decimal('default_credit_limit', 12, 2)
                ->default(0.00);

            // Example:
            // ["company_name", "email", "phone"]
            $table->json('required_client_fields')
                ->nullable();

            // Enable client self-service portal
            $table->boolean('client_portal_access')
                ->default(false);

            // Automatically archive inactive clients
            $table->boolean('auto_archive_inactive_clients')
                ->default(false);

            // Number of months before archiving
            $table->unsignedTinyInteger('inactivity_threshold')
                ->default(6);

            // Example: en
            $table->string('default_communication_language', 10)
                ->default('en');

            /*
            |--------------------------------------------------------------------------
            | Documents
            |--------------------------------------------------------------------------
            */

            $table->enum('default_document_format', [
                'pdf',
                'docx',
                'html',
            ])->default('pdf');

            $table->string('file_naming_convention')
                ->default('Type_ClientName_Date');

            // Retention period in years
            $table->unsignedTinyInteger('document_retention_period')
                ->default(7);

            $table->enum('default_access_level', [
                'private',
                'team',
                'public',
            ])->default('private');

            $table->boolean('e_signature_required')
                ->default(false);

            $table->boolean('version_history')
                ->default(true);

            $table->string('cloud_storage_integration')
                ->default('billflow_cloud');

            $table->boolean('auto_attach_pdf_to_emails')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Integrations
            |--------------------------------------------------------------------------
            */

            // Connected applications
            // Example:
            // ["stripe", "quickbooks", "slack"]
            $table->json('connected_apps')
                ->nullable();

            // Accounting software
            $table->enum('accounting_software', [
                'none',
                'quickbooks',
                'xero',
            ])->default('none');

            // Sync direction
            $table->enum('sync_direction', [
                'billflow_to_accounting',
                'accounting_to_billflow',
                'two_way',
            ])->default('billflow_to_accounting');

            // Sync frequency
            $table->enum('sync_frequency', [
                '15_minutes',
                'hourly',
                'daily',
                'manual',
            ])->default('15_minutes');

            // REST API
            $table->boolean('rest_api_access')
                ->default(true);

            // Webhook events
            $table->boolean('webhook_events')
                ->default(false);

            // OAuth permissions
            $table->enum('oauth_app_permissions', [
                'read_only',
                'read_write',
            ])->default('read_only');

            // Auto-sync imported data
            $table->boolean('auto_sync_on_import')
                ->default(false);

            // Data export format
            $table->enum('data_export_format', [
                'json',
                'csv',
                'xml',
            ])->default('json');

            // Integration error alerts
            $table->enum('integration_error_alerts', [
                'none',
                'email',
                'in_app',
                'email_and_in_app',
            ])->default('email_and_in_app');

            /*
            |--------------------------------------------------------------------------
            | Invoices & Quotes
            |--------------------------------------------------------------------------
            */

            $table->string('invoice_number_prefix')
                ->default('INV-');

            $table->string('quote_number_prefix')
                ->default('QUO-');

            $table->string('default_payment_terms')
                ->default('Net 15');

            $table->unsignedSmallInteger('quote_expiry_days')
                ->default(30);

            $table->enum('default_invoice_template', [
                'classic',
                'modern',
                'compact',
                'detailed',
                'minimal',
            ])->default('classic');

            $table->boolean('late_payment_fee')
                ->default(false);

            $table->boolean('auto_send_reminders')
                ->default(true);

            $table->string('invoice_accent_color', 20)
                ->default('#00BFA6');

            /*
        |--------------------------------------------------------------------------
        | Items
        |--------------------------------------------------------------------------
        */

            $table->enum('default_item_type', [
                'service',
                'product',
                'subscription',
                'bundle',
            ])->default('service');

            $table->enum('pricing_model', [
                'fixed_price',
                'hourly',
                'quantity',
                'tiered',
            ])->default('fixed_price');

            $table->string('default_unit_of_measure')
                ->default('each');

            $table->string('item_code_format')
                ->default('ITEM-');

            $table->boolean('tax_inclusive_pricing')
                ->default(false);

            $table->boolean('inventory_tracking')
                ->default(false);

            // Store percentage, e.g. 10.00
            // NULL = No maximum
            $table->decimal('maximum_discount_allowed', 5, 2)
                ->nullable();

            $table->boolean('display_item_on_client_portal')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Notifications
            |--------------------------------------------------------------------------
            */

            $table->json('notification_channels')
                ->nullable();

            $table->enum('digest_frequency', [
                'instant',
                'daily',
                'weekly',
            ])->default('daily');

            $table->string('quiet_hours')
                ->nullable();

            $table->boolean('notify_all_admins')
                ->default(true);

            $table->boolean('in_app_sound')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Payments
            |--------------------------------------------------------------------------
            */

            $table->json('accepted_payment_methods')
                ->nullable();

            $table->enum('primary_payment_gateway', [
                'stripe',
                'paypal',
                'square',
                'razorpay',
                'none',
            ])->default('stripe');

            $table->enum('payout_schedule', [
                'daily',
                'weekly',
                'biweekly',
                'monthly',
                'manual',
            ])->default('daily');

            $table->boolean('allow_partial_payments')
                ->default(false);

            $table->boolean('auto_send_payment_receipt')
                ->default(true);

            $table->enum('surcharge_policy', [
                'none',
                'percentage',
                'fixed',
            ])->default('none');

            /*
            |--------------------------------------------------------------------------
            | Projects
            |--------------------------------------------------------------------------
            */
            $table->enum('default_project_billing_method', [
                'fixed_price',
                'time_materials',
                'milestone_based',
                'retainer',
            ])->default('fixed_price');

            $table->enum('default_project_status', [
                'draft',
                'active',
                'on_hold',
                'completed',
                'cancelled',
            ])->default('draft');

            $table->string('project_id_format')
                ->default('PRJ-');

            $table->enum('default_timeline_view', [
                'gantt',
                'kanban',
                'list',
                'calendar',
            ])->default('gantt');

            $table->boolean('project_time_tracking')
                ->default(true);

            $table->decimal('default_hourly_rate', 12, 2)
                ->default(100.00);

            $table->boolean('auto_invoice_on_milestone')
                ->default(false);

            $table->enum('budget_overage_alert', [
                'none',
                '50_percent',
                '80_percent',
                '90_percent',
                '100_percent',
            ])->default('80_percent');

            $table->boolean('project_client_visibility')
                ->default(true);

            $table->boolean('project_expense_tracking')
                ->default(true);

            $table->enum('default_task_priority', [
                'low',
                'medium',
                'high',
                'critical',
            ])->default('medium');

            // Number of days after completion before archive
            $table->unsignedInteger('archive_completed_projects_after')
                ->default(30);

            /*
            |--------------------------------------------------------------------------
            | Reports
            |--------------------------------------------------------------------------
            */

            // Selected dashboard reports
            $table->json('dashboard_default_reports')
                ->nullable();

            $table->enum('default_report_date_range', [
                'today',
                'this_week',
                'this_month',
                'this_quarter',
                'this_year',
                'last_month',
                'last_quarter',
                'custom',
            ])->default('this_month');

            $table->enum('default_report_export_format', [
                'pdf',
                'excel',
                'csv',
            ])->default('pdf');

            $table->enum('default_report_chart_style', [
                'bar',
                'line',
                'area',
                'donut',
            ])->default('bar');

            $table->boolean('scheduled_report_emails')
                ->default(false);

            $table->enum('report_schedule_frequency', [
                'daily',
                'weekly',
                'monthly',
            ])->default('weekly');

            $table->boolean('report_comparative_period')
                ->default(true);

            $table->enum('report_currency_display', [
                'symbol',
                'code',
                'name',
            ])->default('symbol');


            /*
            |--------------------------------------------------------------------------
            | Repository
            |--------------------------------------------------------------------------
            */
            $table->string('default_upload_folder')
                ->default('/Root');

            // Store limit in MB
            $table->unsignedInteger('max_file_size_limit')
                ->default(25);

            $table->json('allowed_file_types')
                ->nullable();

            $table->boolean('ai_auto_tagging')
                ->default(true);

            $table->boolean('duplicate_detection')
                ->default(true);

            $table->enum('default_sharing_permission', [
                'private',
                'team',
                'public',
            ])->default('private');


            $table->timestamps();

            // One settings record per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
