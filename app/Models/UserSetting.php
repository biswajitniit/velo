<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_id',

        // Banking
        'default_currency',
        'fiscal_year_start',
        'default_tax_rate',
        'auto_reconciliation',
        'bank_feed_sync_frequency',

        // Customers / Clients
        'client_id_format',
        'default_credit_limit',
        'required_client_fields',
        'client_portal_access',
        'auto_archive_inactive_clients',
        'inactivity_threshold',
        'default_communication_language',

        // Documents
        'default_document_format',
        'file_naming_convention',
        'document_retention_period',
        'default_access_level',
        'e_signature_required',
        'version_history',
        'cloud_storage_integration',
        'auto_attach_pdf_to_emails',

        // Integrations
        'connected_apps',
        'accounting_software',
        'sync_direction',
        'sync_frequency',
        'rest_api_access',
        'webhook_events',
        'oauth_app_permissions',
        'auto_sync_on_import',
        'data_export_format',
        'integration_error_alerts',

        // Invoices & Quotes
        'invoice_number_prefix',
        'quote_number_prefix',
        'default_payment_terms',
        'quote_expiry_days',
        'default_invoice_template',
        'late_payment_fee',
        'auto_send_reminders',
        'invoice_accent_color',

        // Items
        'default_item_type',
        'pricing_model',
        'default_unit_of_measure',
        'item_code_format',
        'tax_inclusive_pricing',
        'inventory_tracking',
        'maximum_discount_allowed',
        'display_item_on_client_portal',

        // Notifications
        'notification_channels',
        'digest_frequency',
        'quiet_hours',
        'notify_all_admins',
        'in_app_sound',

        // Payments
        'accepted_payment_methods',
        'primary_payment_gateway',
        'payout_schedule',
        'allow_partial_payments',
        'auto_send_payment_receipt',
        'surcharge_policy',

        // Projects
        'default_project_billing_method',
        'default_project_status',
        'project_id_format',
        'default_timeline_view',
        'project_time_tracking',
        'default_hourly_rate',
        'auto_invoice_on_milestone',
        'budget_overage_alert',
        'project_client_visibility',
        'project_expense_tracking',
        'default_task_priority',
        'archive_completed_projects_after',

        // Reports
        'dashboard_default_reports',
        'default_report_date_range',
        'default_report_export_format',
        'default_report_chart_style',
        'scheduled_report_emails',
        'report_schedule_frequency',
        'report_comparative_period',
        'report_currency_display',

        // Repository
        'default_upload_folder',
        'max_file_size_limit',
        'allowed_file_types',
        'ai_auto_tagging',
        'duplicate_detection',
        'default_sharing_permission',
    ];

    protected function casts(): array
    {
        return [
            // Banking
            'fiscal_year_start' => 'integer',
            'default_tax_rate' => 'decimal:2',
            'auto_reconciliation' => 'boolean',

            // Customers / Clients
            'default_credit_limit' => 'decimal:2',
            'required_client_fields' => 'array',
            'client_portal_access' => 'boolean',
            'auto_archive_inactive_clients' => 'boolean',
            'inactivity_threshold' => 'integer',

            // Documents
            'document_retention_period' => 'integer',
            'e_signature_required' => 'boolean',
            'version_history' => 'boolean',
            'auto_attach_pdf_to_emails' => 'boolean',

            // Integrations
            'connected_apps' => 'array',
            'rest_api_access' => 'boolean',
            'webhook_events' => 'boolean',
            'auto_sync_on_import' => 'boolean',

            // Invoices & Quotes
            'quote_expiry_days' => 'integer',
            'late_payment_fee' => 'boolean',
            'auto_send_reminders' => 'boolean',

            // Items
            'maximum_discount_allowed' => 'decimal:2',
            'tax_inclusive_pricing' => 'boolean',
            'inventory_tracking' => 'boolean',
            'display_item_on_client_portal' => 'boolean',

            // Notifications
            'notification_channels' => 'array',
            'notify_all_admins' => 'boolean',
            'in_app_sound' => 'boolean',

            // Payments
            'accepted_payment_methods' => 'array',
            'allow_partial_payments' => 'boolean',
            'auto_send_payment_receipt' => 'boolean',

            // Projects
            'default_hourly_rate' => 'decimal:2',
            'project_time_tracking' => 'boolean',
            'auto_invoice_on_milestone' => 'boolean',
            'project_client_visibility' => 'boolean',
            'project_expense_tracking' => 'boolean',
            'archive_completed_projects_after' => 'integer',

            // Reports
            'dashboard_default_reports' => 'array',
            'scheduled_report_emails' => 'boolean',
            'report_comparative_period' => 'boolean',

            // Repository
            'max_file_size_limit' => 'integer',
            'allowed_file_types' => 'array',
            'ai_auto_tagging' => 'boolean',
            'duplicate_detection' => 'boolean',
        ];
    }

    /**
     * User who owns these settings.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Primary bank account.
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
