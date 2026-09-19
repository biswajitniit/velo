<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Get current user (or fallback for development)
     */
    protected function getUser()
    {
        return Auth::user() ?? User::first();
    }

    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return redirect()->route('login');
        }

        // Fetch all invoices for user with customer and items relations
        $rawInvoices = Invoice::with(['customer', 'items', 'payments'])
            ->where('user_id', $user->id)
            ->orderBy('issue_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Calculate dynamic stats
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        $totalOutstanding = 0;
        $totalOutstandingCount = 0;
        $overdueTotal = 0;
        $overdueCount = 0;
        $awaitingTotal = 0;
        $awaitingCount = 0;
        $paidThisMonth = 0;
        $paidThisMonthCount = 0;

        foreach ($rawInvoices as $inv) {
            $isPaid = ($inv->status === 'paid');
            $isOverdue = ($inv->status === 'overdue' || (!$isPaid && $inv->due_date && Carbon::parse($inv->due_date)->isPast()));
            $isSent = ($inv->status === 'sent');

            if (!$isPaid) {
                $totalOutstanding += (float) ($inv->total_amount - $inv->paid_amount);
                $totalOutstandingCount++;
            }

            if ($isOverdue && !$isPaid) {
                $overdueTotal += (float) ($inv->total_amount - $inv->paid_amount);
                $overdueCount++;
            }

            if ($isSent && !$isOverdue && !$isPaid) {
                $awaitingTotal += (float) ($inv->total_amount - $inv->paid_amount);
                $awaitingCount++;
            }

            if ($isPaid) {
                $paidThisMonth += (float) $inv->total_amount;
                $paidThisMonthCount++;
            }
        }

        $stats = [
            'total_outstanding' => $totalOutstanding,
            'total_outstanding_count' => $totalOutstandingCount,
            'overdue' => $overdueTotal,
            'overdue_count' => $overdueCount,
            'awaiting_payment' => $awaitingTotal,
            'awaiting_payment_count' => $awaitingCount,
            'paid_this_month' => $paidThisMonth,
            'paid_this_month_count' => $paidThisMonthCount,
        ];

        // Format clients & invoices for JavaScript reactive UI (table, search, filters, drilldown)
        $customers = Customer::where('user_id', $user->id)->get();
        $avatarColors = [
            'linear-gradient(135deg,#00b899,#009e82)',
            'linear-gradient(135deg,#3b82f6,#2563eb)',
            'linear-gradient(135deg,#f5a623,#e8991a)',
            'linear-gradient(135deg,#8b5cf6,#7c3aed)',
            'linear-gradient(135deg,#f05454,#dc2626)',
            'linear-gradient(135deg,#ec4899,#db2777)',
            'linear-gradient(135deg,#14b8a6,#0d9488)',
            'linear-gradient(135deg,#f97316,#ea580c)',
        ];

        $clients = [];
        $clientIndexMap = [];

        foreach ($customers as $index => $c) {
            $clientIndexMap[$c->name] = count($clients);
            $clients[] = [
                'id' => $c->client_id ?: ('CLT-' . str_pad($c->id, 3, '0', STR_PAD_LEFT)),
                'db_id' => $c->id,
                'name' => $c->name,
                'email' => $c->email ?? '',
                'initials' => $c->initials,
                'color' => $c->color ?: $avatarColors[$index % count($avatarColors)],
                'tags' => is_array($c->tags) ? $c->tags : ['Client'],
            ];
        }

        $jsInvoices = [];
        foreach ($rawInvoices as $inv) {
            $clientName = $inv->client_name;
            if (!isset($clientIndexMap[$clientName])) {
                $idx = count($clients);
                $clientIndexMap[$clientName] = $idx;
                $clients[] = [
                    'id' => 'CLT-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                    'db_id' => null,
                    'name' => $clientName,
                    'email' => $inv->client_email ?? '',
                    'initials' => strtoupper(substr($clientName, 0, 2)),
                    'color' => $avatarColors[$idx % count($avatarColors)],
                    'tags' => ['Client'],
                ];
            }

            // Detect overdue dynamically
            $status = $inv->status;
            if ($status !== 'paid' && $inv->due_date && Carbon::parse($inv->due_date)->isPast()) {
                $status = 'overdue';
            }

            $jsInvoices[] = [
                'id' => $inv->id,
                'inv' => $inv->invoice_number,
                'clientIdx' => $clientIndexMap[$clientName],
                'project' => $inv->project_id ?: 'General Services',
                'po' => $inv->po_number ?: '',
                'issued' => $inv->issue_date ? Carbon::parse($inv->issue_date)->format('Y-m-d') : '',
                'due' => $inv->due_date ? Carbon::parse($inv->due_date)->format('Y-m-d') : '',
                'amount' => (float) $inv->total_amount,
                'status' => $status,
                'type' => $inv->type,
                'quote' => $inv->quote_id ?: '',
            ];
        }

        return view('subscriber.Invoices', compact('rawInvoices', 'stats', 'clients', 'jsInvoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return redirect()->route('login');
        }

        $customers = Customer::where('user_id', $user->id)->orderBy('name')->get();
        $userSettings = $user->settings;

        // Auto calculate next invoice number
        $lastInvoice = Invoice::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextNum = 1;
        if ($lastInvoice && preg_match('/(\d+)/', $lastInvoice->invoice_number, $matches)) {
            $nextNum = intval($matches[1]) + 1;
        }
        $nextInvoiceNumber = str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        // Preload invoices for the search overlay in create view
        $allInvoices = Invoice::where('user_id', $user->id)
            ->orderBy('issue_date', 'desc')
            ->get()
            ->map(function ($inv) {
                return [
                    'inv' => $inv->invoice_number,
                    'client' => $inv->client_name,
                    'clientId' => $inv->customer?->client_id ?: ('C-' . str_pad($inv->customer_id ?? 1, 3, '0', STR_PAD_LEFT)),
                    'amount' => (float) $inv->total_amount,
                    'date' => $inv->issue_date ? Carbon::parse($inv->issue_date)->format('Y-m-d') : '',
                    'due' => $inv->due_date ? Carbon::parse($inv->due_date)->format('Y-m-d') : '',
                    'status' => $inv->status,
                    'po' => $inv->po_number ?: '',
                    'project' => $inv->project_id ?: '',
                    'quote' => $inv->quote_id ?: '',
                ];
            });

        return view('subscriber.create-invoices', compact('customers', 'nextInvoiceNumber', 'userSettings', 'allInvoices'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'billing_address' => ['nullable', 'string'],
            'invoice_number' => ['nullable', 'string', 'max:50'],
            'prefix' => ['nullable', 'string', 'max:20'],
            'type' => ['nullable', 'string', 'max:20'],
            'currency' => ['nullable', 'string', 'max:10'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['nullable', 'string', 'max:30'],
            'po_number' => ['nullable', 'string', 'max:100'],
            'project_id' => ['nullable', 'string', 'max:255'],
            'quote_id' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'terms' => ['nullable', 'string', 'max:1000'],
            'subtotal' => ['nullable', 'numeric', 'min:0'],
            'tax_rate' => ['nullable', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'shipping_amount' => ['nullable', 'numeric', 'min:0'],
            'handling_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_rate' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'recurring_frequency' => ['nullable', 'string', 'max:50'],
            'recurring_start_date' => ['nullable', 'date'],
            'recurring_end_date' => ['nullable', 'date'],
            'recurring_auto_send' => ['nullable'],
            'recurring_max_occurrences' => ['nullable', 'integer', 'min:1'],
            'items' => ['nullable', 'array'],
            'payments' => ['nullable', 'array'],
        ]);

        return DB::transaction(function () use ($user, $validated, $request) {
            // Find or create customer
            $customer = null;
            if (!empty($validated['client_name'])) {
                $customer = Customer::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'name' => $validated['client_name'],
                    ],
                    [
                        'email' => $validated['client_email'] ?? null,
                        'contact_name' => $validated['contact_name'] ?? null,
                        'billing_address' => $validated['billing_address'] ?? null,
                        'client_id' => 'CLT-' . rand(100, 999),
                    ]
                );
            }

            // Determine invoice number
            $invoiceNumber = $validated['invoice_number'] ?? null;
            if (empty($invoiceNumber) || $invoiceNumber === 'NEW') {
                $lastInvoice = Invoice::where('user_id', $user->id)->orderBy('id', 'desc')->first();
                $nextNum = 1;
                if ($lastInvoice && preg_match('/(\d+)/', $lastInvoice->invoice_number, $matches)) {
                    $nextNum = intval($matches[1]) + 1;
                }
                $invoiceNumber = str_pad($nextNum, 4, '0', STR_PAD_LEFT);
            }

            $status = $validated['status'] ?? 'draft';
            if ($status === 'NEW' || empty($status)) {
                $status = 'ready';
            }

            $invoice = Invoice::create([
                'user_id' => $user->id,
                'customer_id' => $customer?->id,
                'client_name' => $validated['client_name'],
                'client_email' => $validated['client_email'] ?? $customer?->email,
                'contact_name' => $validated['contact_name'] ?? $customer?->contact_name,
                'billing_address' => $validated['billing_address'] ?? $customer?->billing_address,
                'invoice_number' => $invoiceNumber,
                'prefix' => $validated['prefix'] ?? 'INV-',
                'type' => $validated['type'] ?? 'REG',
                'currency' => $validated['currency'] ?? 'USD',
                'issue_date' => $validated['issue_date'],
                'due_date' => $validated['due_date'],
                'status' => $status,
                'po_number' => $validated['po_number'] ?? null,
                'project_id' => $validated['project_id'] ?? null,
                'quote_id' => $validated['quote_id'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
                'subtotal' => $validated['subtotal'] ?? 0.00,
                'tax_rate' => $validated['tax_rate'] ?? 0.00,
                'tax_amount' => $validated['tax_amount'] ?? 0.00,
                'shipping_amount' => $validated['shipping_amount'] ?? 0.00,
                'handling_amount' => $validated['handling_amount'] ?? 0.00,
                'discount_rate' => $validated['discount_rate'] ?? 0.00,
                'discount_amount' => $validated['discount_amount'] ?? 0.00,
                'total_amount' => $validated['total_amount'] ?? 0.00,
                'paid_amount' => ($status === 'paid') ? ($validated['total_amount'] ?? 0.00) : 0.00,
                'recurring_frequency' => $validated['recurring_frequency'] ?? null,
                'recurring_start_date' => $validated['recurring_start_date'] ?? null,
                'recurring_end_date' => $validated['recurring_end_date'] ?? null,
                'recurring_auto_send' => !empty($validated['recurring_auto_send']) && in_array($validated['recurring_auto_send'], ['yes', '1', 1, true], true),
                'recurring_max_occurrences' => $validated['recurring_max_occurrences'] ?? null,
            ]);

            // Save line items
            if (!empty($validated['items']) && is_array($validated['items'])) {
                foreach ($validated['items'] as $index => $item) {
                    if (empty($item['description']) && empty($item['unit_price'])) {
                        continue;
                    }
                    $qty = floatval($item['quantity'] ?? 1);
                    $price = floatval($item['unit_price'] ?? 0);
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => $item['description'] ?? '',
                        'reference' => $item['reference'] ?? null,
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'amount' => $qty * $price,
                        'order' => $index,
                    ]);
                }
            }

            // Save payments if present
            if (!empty($validated['payments']) && is_array($validated['payments'])) {
                foreach ($validated['payments'] as $p) {
                    if (empty($p['amount'])) {
                        continue;
                    }
                    InvoicePayment::create([
                        'invoice_id' => $invoice->id,
                        'status' => $p['status'] ?? 'receivable',
                        'reference' => $p['reference'] ?? null,
                        'payment_date' => $p['payment_date'] ?? null,
                        'applied_date' => $p['applied_date'] ?? null,
                        'source' => $p['source'] ?? null,
                        'amount' => floatval($p['amount'] ?? 0),
                    ]);
                }
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice saved successfully.',
                    'invoice' => $invoice,
                    'invoice_number' => $invoice->invoice_number,
                    'redirect' => route('subscriber.invoices'),
                ]);
            }

            return redirect()->route('subscriber.invoices')->with('success', 'Invoice ' . $invoice->full_invoice_number . ' created successfully.');
        });
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        $user = $this->getUser();
        if (!$user || $invoice->user_id !== $user->id) {
            abort(403);
        }

        $invoice->load(['items', 'payments', 'customer']);
        $customers = Customer::where('user_id', $user->id)->orderBy('name')->get();
        $nextInvoiceNumber = $invoice->invoice_number;

        return view('subscriber.create-invoices', compact('invoice', 'customers', 'nextInvoiceNumber'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $user = $this->getUser();
        if (!$user || $invoice->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'billing_address' => ['nullable', 'string'],
            'invoice_number' => ['required', 'string', 'max:50'],
            'type' => ['nullable', 'string', 'max:20'],
            'currency' => ['nullable', 'string', 'max:10'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'status' => ['nullable', 'string', 'max:30'],
            'po_number' => ['nullable', 'string', 'max:100'],
            'project_id' => ['nullable', 'string', 'max:255'],
            'quote_id' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'terms' => ['nullable', 'string', 'max:1000'],
            'subtotal' => ['nullable', 'numeric', 'min:0'],
            'tax_rate' => ['nullable', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'shipping_amount' => ['nullable', 'numeric', 'min:0'],
            'handling_amount' => ['nullable', 'numeric', 'min:0'],
            'discount_rate' => ['nullable', 'numeric', 'min:0'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'recurring_frequency' => ['nullable', 'string', 'max:50'],
            'recurring_start_date' => ['nullable', 'date'],
            'recurring_end_date' => ['nullable', 'date'],
            'recurring_auto_send' => ['nullable'],
            'recurring_max_occurrences' => ['nullable', 'integer', 'min:1'],
            'items' => ['nullable', 'array'],
            'payments' => ['nullable', 'array'],
        ]);

        return DB::transaction(function () use ($invoice, $validated, $request) {
            $invoice->update([
                'client_name' => $validated['client_name'],
                'client_email' => $validated['client_email'] ?? $invoice->client_email,
                'contact_name' => $validated['contact_name'] ?? $invoice->contact_name,
                'billing_address' => $validated['billing_address'] ?? $invoice->billing_address,
                'invoice_number' => $validated['invoice_number'],
                'type' => $validated['type'] ?? $invoice->type,
                'currency' => $validated['currency'] ?? $invoice->currency,
                'issue_date' => $validated['issue_date'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'] ?? $invoice->status,
                'po_number' => $validated['po_number'] ?? null,
                'project_id' => $validated['project_id'] ?? null,
                'quote_id' => $validated['quote_id'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
                'subtotal' => $validated['subtotal'] ?? $invoice->subtotal,
                'tax_rate' => $validated['tax_rate'] ?? $invoice->tax_rate,
                'tax_amount' => $validated['tax_amount'] ?? $invoice->tax_amount,
                'shipping_amount' => $validated['shipping_amount'] ?? $invoice->shipping_amount,
                'handling_amount' => $validated['handling_amount'] ?? $invoice->handling_amount,
                'discount_rate' => $validated['discount_rate'] ?? $invoice->discount_rate,
                'discount_amount' => $validated['discount_amount'] ?? $invoice->discount_amount,
                'total_amount' => $validated['total_amount'] ?? $invoice->total_amount,
                'recurring_frequency' => $validated['recurring_frequency'] ?? null,
                'recurring_start_date' => $validated['recurring_start_date'] ?? null,
                'recurring_end_date' => $validated['recurring_end_date'] ?? null,
                'recurring_auto_send' => !empty($validated['recurring_auto_send']) && in_array($validated['recurring_auto_send'], ['yes', '1', 1, true], true),
                'recurring_max_occurrences' => $validated['recurring_max_occurrences'] ?? null,
            ]);

            // Sync items
            if (isset($validated['items'])) {
                $invoice->items()->delete();
                foreach ($validated['items'] as $index => $item) {
                    if (empty($item['description']) && empty($item['unit_price'])) {
                        continue;
                    }
                    $qty = floatval($item['quantity'] ?? 1);
                    $price = floatval($item['unit_price'] ?? 0);
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'description' => $item['description'] ?? '',
                        'reference' => $item['reference'] ?? null,
                        'quantity' => $qty,
                        'unit_price' => $price,
                        'amount' => $qty * $price,
                        'order' => $index,
                    ]);
                }
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice updated successfully.',
                    'invoice' => $invoice,
                ]);
            }

            return redirect()->route('subscriber.invoices')->with('success', 'Invoice updated successfully.');
        });
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Request $request, Invoice $invoice)
    {
        $user = $this->getUser();
        if (!$user || $invoice->user_id !== $user->id) {
            abort(403);
        }

        $invNum = $invoice->full_invoice_number;
        $invoice->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Invoice {$invNum} deleted successfully.",
            ]);
        }

        return redirect()->route('subscriber.invoices')->with('success', "Invoice {$invNum} deleted successfully.");
    }

    /**
     * Update status of an individual invoice.
     */
    public function updateStatus(Request $request, Invoice $invoice)
    {
        $user = $this->getUser();
        if (!$user || $invoice->user_id !== $user->id) {
            abort(403);
        }

        $status = $request->input('status');
        if (in_array($status, ['draft', 'sent', 'paid', 'overdue', 'ready'])) {
            $invoice->status = $status;
            if ($status === 'paid') {
                $invoice->paid_amount = $invoice->total_amount;
            }
            $invoice->save();

            return response()->json([
                'success' => true,
                'message' => "Invoice status updated to {$status}.",
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid status.'], 400);
    }

    /**
     * Perform bulk actions on selected invoices.
     */
    public function bulkAction(Request $request)
    {
        $user = $this->getUser();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $action = $request->input('action');
        $invoiceNumbers = $request->input('invoices', []);

        if (empty($invoiceNumbers)) {
            return response()->json(['success' => false, 'message' => 'No invoices selected.'], 400);
        }

        $invoices = Invoice::where('user_id', $user->id)
            ->whereIn('invoice_number', $invoiceNumbers)
            ->get();

        if ($action === 'delete') {
            foreach ($invoices as $inv) {
                $inv->delete();
            }
            return response()->json(['success' => true, 'message' => count($invoices) . ' invoices deleted successfully.']);
        } elseif ($action === 'mark-paid') {
            foreach ($invoices as $inv) {
                $inv->status = 'paid';
                $inv->paid_amount = $inv->total_amount;
                $inv->save();
            }
            return response()->json(['success' => true, 'message' => count($invoices) . ' invoices marked as paid.']);
        } elseif ($action === 'send') {
            foreach ($invoices as $inv) {
                if ($inv->status !== 'paid') {
                    $inv->status = 'sent';
                    $inv->save();
                }
            }
            return response()->json(['success' => true, 'message' => count($invoices) . ' invoices sent.']);
        }

        return response()->json(['success' => true, 'message' => 'Bulk action completed.']);
    }
}
