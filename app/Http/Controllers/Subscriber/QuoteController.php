<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    private function getUser()
    {
        return Auth::user() ?? User::first();
    }

    public function index(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        // KPI Stats
        $quotesQuery = Quote::where('user_id', $userId);

        $totalQuotesAmount = (float) (clone $quotesQuery)->sum('total_amount');
        $totalQuotesCount = (clone $quotesQuery)->count();

        $acceptedAmount = (float) (clone $quotesQuery)->where('status', 'accepted')->sum('total_amount');
        $acceptedCount = (clone $quotesQuery)->where('status', 'accepted')->count();

        $awaitingAmount = (float) (clone $quotesQuery)->whereIn('status', ['sent', 'draft'])->sum('total_amount');
        $awaitingCount = (clone $quotesQuery)->whereIn('status', ['sent', 'draft'])->count();

        $expiredAmount = (float) (clone $quotesQuery)->whereIn('status', ['expired', 'rejected'])->sum('total_amount');
        $expiredCount = (clone $quotesQuery)->whereIn('status', ['expired', 'rejected'])->count();

        // Load Customers for JS Drawer & Selection
        $customers = Customer::where('user_id', $userId)->get();
        $clients = $customers->map(function ($c, $idx) {
            return [
                'id' => $c->client_id ?? ('CLT-' . str_pad($c->id, 3, '0', STR_PAD_LEFT)),
                'name' => $c->name,
                'email' => $c->email ?? '',
                'initials' => $c->initials,
                'color' => $c->color ?: 'linear-gradient(135deg,#00b899,#009e82)',
                'tags' => $c->tags ?? ['Client'],
            ];
        })->values()->all();

        // Load all quotes for data table
        $quotes = Quote::where('user_id', $userId)
            ->with(['customer', 'items'])
            ->orderBy('created_at', 'desc')
            ->get();

        $jsQuotes = $quotes->map(function ($q) use ($clients) {
            $clientIdx = 0;
            foreach ($clients as $idx => $cl) {
                if (strtolower($cl['name']) === strtolower($q->client_name)) {
                    $clientIdx = $idx;
                    break;
                }
            }

            return [
                'id' => $q->id,
                'q' => (string) $q->quote_number,
                'clientIdx' => $clientIdx,
                'client_name' => $q->client_name,
                'project' => $q->project_id ?: ($q->po_number ?: 'Proposal'),
                'issued' => $q->issue_date ? Carbon::parse($q->issue_date)->format('Y-m-d') : '',
                'valid' => $q->expiry_date ? Carbon::parse($q->expiry_date)->format('Y-m-d') : '',
                'discount' => (float) $q->discount_rate,
                'tax' => (float) $q->tax_rate,
                'notes' => $q->notes ?? '',
                'terms' => $q->terms ?? '',
                'status' => $q->status ?: 'draft',
                'items' => $q->items->map(function ($it) {
                    return [
                        'desc' => $it->description,
                        'qty' => (float) $it->quantity,
                        'rate' => (float) $it->unit_price,
                        'amount' => (float) $it->amount,
                    ];
                })->all(),
            ];
        })->values()->all();

        $lastQuote = Quote::where('user_id', $userId)->orderBy('id', 'desc')->first();
        $nextQuoteNumber = $lastQuote && is_numeric($lastQuote->quote_number)
            ? str_pad((int) $lastQuote->quote_number + 1, 4, '0', STR_PAD_LEFT)
            : '0037';

        $stats = [
            'total_amount' => '$' . number_format($totalQuotesAmount, 2),
            'total_count' => $totalQuotesCount . ' quote' . ($totalQuotesCount !== 1 ? 's' : ''),
            'accepted_amount' => '$' . number_format($acceptedAmount, 2),
            'accepted_count' => $acceptedCount . ' quote' . ($acceptedCount !== 1 ? 's' : '') . ' accepted',
            'awaiting_amount' => '$' . number_format($awaitingAmount, 2),
            'awaiting_count' => $awaitingCount . ' quote' . ($awaitingCount !== 1 ? 's' : '') . ' pending',
            'expired_amount' => '$' . number_format($expiredAmount, 2),
            'expired_count' => $expiredCount . ' quote' . ($expiredCount !== 1 ? 's' : '') . ' expired/rejected',
        ];

        return view('subscriber.quotes', [
            'stats' => $stats,
            'clients' => $clients,
            'jsQuotes' => $jsQuotes,
            'customers' => $customers,
            'nextQuoteNumber' => $nextQuoteNumber,
            'user' => $user,
        ]);
    }

    public function create(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $lastQuote = Quote::where('user_id', $userId)->orderBy('id', 'desc')->first();
        if ($lastQuote && is_numeric($lastQuote->quote_number)) {
            $nextQuoteNumber = str_pad((int) $lastQuote->quote_number + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextQuoteNumber = '0019';
        }

        $customers = Customer::where('user_id', $userId)->get();

        $allQuotes = Quote::where('user_id', $userId)->orderBy('id', 'desc')->get()->map(function ($q) {
            return [
                'inv' => $q->quote_number,
                'client' => $q->client_name,
                'clientId' => $q->customer ? ($q->customer->client_id ?? '') : '',
                'amount' => (float) $q->total_amount,
                'date' => $q->issue_date ? Carbon::parse($q->issue_date)->format('Y-m-d') : '',
                'due' => $q->expiry_date ? Carbon::parse($q->expiry_date)->format('Y-m-d') : '',
                'status' => $q->status,
                'po' => $q->po_number ?? '',
                'project' => $q->project_id ?? '',
                'quote' => $q->full_quote_number,
            ];
        });

        return view('subscriber.create-quotes', [
            'nextQuoteNumber' => $nextQuoteNumber,
            'customers' => $customers,
            'allQuotes' => $allQuotes,
        ]);
    }

    public function store(Request $request)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $validated = $request->validate([
            'client_name' => 'nullable|string|max:255',
            'customer_id' => 'nullable|integer',
            'clientIdx' => 'nullable|integer',
            'client_email' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string',
            'quote_number' => 'nullable|string|max:50',
            'q' => 'nullable|string|max:50',
            'issue_date' => 'nullable|date',
            'issued' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'valid' => 'nullable|date',
            'currency' => 'nullable|string|max:10',
            'po_number' => 'nullable|string|max:100',
            'project_id' => 'nullable|string|max:100',
            'project' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'status' => 'nullable|string|max:30',
            'tax_rate' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'discount_rate' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'shipping_amount' => 'nullable|numeric',
            'handling_amount' => 'nullable|numeric',
            'items' => 'nullable|array',
            'items.*.description' => 'nullable|string',
            'items.*.desc' => 'nullable|string',
            'items.*.reference' => 'nullable|string',
            'items.*.quantity' => 'nullable|numeric',
            'items.*.qty' => 'nullable|numeric',
            'items.*.unit_price' => 'nullable|numeric',
            'items.*.rate' => 'nullable|numeric',
        ]);

        return DB::transaction(function () use ($user, $userId, $validated, $request) {
            $clientName = $validated['client_name'] ?? null;
            $customer = null;

            if (!empty($validated['customer_id'])) {
                $customer = Customer::where('user_id', $userId)->find($validated['customer_id']);
                if ($customer) $clientName = $customer->name;
            }

            if (!$customer && isset($validated['clientIdx'])) {
                $customers = Customer::where('user_id', $userId)->get();
                if (isset($customers[$validated['clientIdx']])) {
                    $customer = $customers[$validated['clientIdx']];
                    $clientName = $customer->name;
                }
            }

            if (!$customer) {
                if (empty($clientName)) {
                    $firstCust = Customer::where('user_id', $userId)->first();
                    $clientName = $firstCust ? $firstCust->name : 'New Customer';
                }
                $customer = Customer::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'name' => $clientName,
                    ],
                    [
                        'email' => $validated['client_email'] ?? null,
                        'contact_name' => $validated['contact_name'] ?? null,
                        'billing_address' => $validated['billing_address'] ?? null,
                    ]
                );
            }

            // Quote Number
            $quoteNumber = $validated['quote_number'] ?? ($validated['q'] ?? null);
            if ($quoteNumber && str_starts_with($quoteNumber, 'QUO-')) {
                $quoteNumber = substr($quoteNumber, 4);
            }

            if (!$quoteNumber || $quoteNumber === 'NEW') {
                $last = Quote::where('user_id', $userId)->orderBy('id', 'desc')->first();
                $quoteNumber = $last && is_numeric($last->quote_number)
                    ? str_pad((int) $last->quote_number + 1, 4, '0', STR_PAD_LEFT)
                    : '0037';
            }

            // Calculations
            $subtotal = 0;
            $itemsData = $validated['items'] ?? [];
            foreach ($itemsData as $it) {
                $desc = $it['description'] ?? ($it['desc'] ?? '');
                $qty = (float) ($it['quantity'] ?? ($it['qty'] ?? 1));
                $rate = (float) ($it['unit_price'] ?? ($it['rate'] ?? 0));
                if (!empty($desc) || $rate > 0) {
                    $subtotal += ($qty * $rate);
                }
            }

            $taxRate = (float) ($validated['tax_rate'] ?? ($validated['tax'] ?? 0));
            $taxAmount = $subtotal * $taxRate / 100;
            $discountRate = (float) ($validated['discount_rate'] ?? ($validated['discount'] ?? 0));
            $discountAmount = $subtotal * $discountRate / 100;
            $shippingAmount = (float) ($validated['shipping_amount'] ?? 0);
            $handlingAmount = (float) ($validated['handling_amount'] ?? 0);
            $totalAmount = $subtotal + $taxAmount - $discountAmount + $shippingAmount + $handlingAmount;

            $status = $validated['status'] ?? 'draft';

            $quote = Quote::create([
                'user_id' => $userId,
                'customer_id' => $customer->id,
                'client_name' => $clientName,
                'client_email' => $validated['client_email'] ?? $customer->email,
                'contact_name' => $validated['contact_name'] ?? $customer->contact_name,
                'billing_address' => $validated['billing_address'] ?? $customer->billing_address,
                'quote_number' => $quoteNumber,
                'prefix' => 'QUO-',
                'issue_date' => $validated['issue_date'] ?? ($validated['issued'] ?? Carbon::now()->toDateString()),
                'expiry_date' => $validated['expiry_date'] ?? ($validated['valid'] ?? Carbon::now()->addDays(14)->toDateString()),
                'status' => $status,
                'currency' => $validated['currency'] ?? 'USD',
                'po_number' => $validated['po_number'] ?? null,
                'project_id' => $validated['project_id'] ?? ($validated['project'] ?? 'Proposal'),
                'notes' => $validated['notes'] ?? null,
                'terms' => $validated['terms'] ?? null,
                'subtotal' => $subtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'discount_rate' => $discountRate,
                'discount_amount' => $discountAmount,
                'shipping_amount' => $shippingAmount,
                'handling_amount' => $handlingAmount,
                'total_amount' => $totalAmount,
            ]);

            // Save line items
            foreach ($itemsData as $idx => $it) {
                $desc = $it['description'] ?? ($it['desc'] ?? 'Service item');
                $qty = (float) ($it['quantity'] ?? ($it['qty'] ?? 1));
                $rate = (float) ($it['unit_price'] ?? ($it['rate'] ?? 0));
                if (!empty($desc) || $rate > 0) {
                    QuoteItem::create([
                        'quote_id' => $quote->id,
                        'description' => $desc,
                        'reference' => $it['reference'] ?? '',
                        'quantity' => $qty,
                        'unit_price' => $rate,
                        'amount' => $qty * $rate,
                        'order' => $idx,
                    ]);
                }
            }

            if ($request->wantsJson() || $request->ajax()) {
                $formattedQuote = [
                    'id' => $quote->id,
                    'q' => (string) $quote->quote_number,
                    'client_name' => $quote->client_name,
                    'project' => $quote->project_id ?: 'Proposal',
                    'issued' => $quote->issue_date ? Carbon::parse($quote->issue_date)->format('Y-m-d') : '',
                    'valid' => $quote->expiry_date ? Carbon::parse($quote->expiry_date)->format('Y-m-d') : '',
                    'discount' => (float) $quote->discount_rate,
                    'tax' => (float) $quote->tax_rate,
                    'notes' => $quote->notes ?? '',
                    'terms' => $quote->terms ?? '',
                    'status' => $quote->status ?: 'draft',
                    'items' => $quote->items()->get()->map(function ($it) {
                        return [
                            'desc' => $it->description,
                            'qty' => (float) $it->quantity,
                            'rate' => (float) $it->unit_price,
                            'amount' => (float) $it->amount,
                        ];
                    })->all(),
                ];

                return response()->json([
                    'success' => true,
                    'message' => 'Quote QUO-' . $quoteNumber . ' created successfully!',
                    'quote_number' => $quoteNumber,
                    'quote' => $formattedQuote,
                ]);
            }

            return redirect()->route('subscriber.quotes')->with('success', 'Quote QUO-' . $quoteNumber . ' created successfully.');
        });
    }

    public function edit(Quote $quote)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $customers = Customer::where('user_id', $userId)->get();
        $allQuotes = Quote::where('user_id', $userId)->orderBy('id', 'desc')->get()->map(function ($q) {
            return [
                'inv' => $q->quote_number,
                'client' => $q->client_name,
                'clientId' => $q->customer ? ($q->customer->client_id ?? '') : '',
                'amount' => (float) $q->total_amount,
                'date' => $q->issue_date ? Carbon::parse($q->issue_date)->format('Y-m-d') : '',
                'due' => $q->expiry_date ? Carbon::parse($q->expiry_date)->format('Y-m-d') : '',
                'status' => $q->status,
                'po' => $q->po_number ?? '',
                'project' => $q->project_id ?? '',
                'quote' => $q->full_quote_number,
            ];
        });

        return view('subscriber.create-quotes', [
            'quote' => $quote->load('items'),
            'customers' => $customers,
            'allQuotes' => $allQuotes,
        ]);
    }

    public function update(Request $request, Quote $quote)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        $validated = $request->validate([
            'client_name' => 'nullable|string|max:255',
            'customer_id' => 'nullable|integer',
            'clientIdx' => 'nullable|integer',
            'client_email' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'billing_address' => 'nullable|string',
            'quote_number' => 'nullable|string|max:50',
            'q' => 'nullable|string|max:50',
            'issue_date' => 'nullable|date',
            'issued' => 'nullable|date',
            'expiry_date' => 'nullable|date',
            'valid' => 'nullable|date',
            'currency' => 'nullable|string|max:10',
            'po_number' => 'nullable|string|max:100',
            'project_id' => 'nullable|string|max:100',
            'project' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'status' => 'nullable|string|max:30',
            'tax_rate' => 'nullable|numeric',
            'tax' => 'nullable|numeric',
            'discount_rate' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'shipping_amount' => 'nullable|numeric',
            'handling_amount' => 'nullable|numeric',
            'items' => 'nullable|array',
            'items.*.description' => 'nullable|string',
            'items.*.desc' => 'nullable|string',
            'items.*.reference' => 'nullable|string',
            'items.*.quantity' => 'nullable|numeric',
            'items.*.qty' => 'nullable|numeric',
            'items.*.unit_price' => 'nullable|numeric',
            'items.*.rate' => 'nullable|numeric',
        ]);

        return DB::transaction(function () use ($quote, $userId, $validated, $request) {
            $clientName = $validated['client_name'] ?? $quote->client_name;
            $customer = null;

            if (!empty($validated['customer_id'])) {
                $customer = Customer::where('user_id', $userId)->find($validated['customer_id']);
                if ($customer) $clientName = $customer->name;
            }

            if (!$customer && isset($validated['clientIdx'])) {
                $customers = Customer::where('user_id', $userId)->get();
                if (isset($customers[$validated['clientIdx']])) {
                    $customer = $customers[$validated['clientIdx']];
                    $clientName = $customer->name;
                }
            }

            if (!$customer) {
                $customer = Customer::firstOrCreate(
                    [
                        'user_id' => $userId,
                        'name' => $clientName,
                    ],
                    [
                        'email' => $validated['client_email'] ?? null,
                        'contact_name' => $validated['contact_name'] ?? null,
                        'billing_address' => $validated['billing_address'] ?? null,
                    ]
                );
            }

            $subtotal = 0;
            $itemsData = $validated['items'] ?? [];
            foreach ($itemsData as $it) {
                $desc = $it['description'] ?? ($it['desc'] ?? '');
                $qty = (float) ($it['quantity'] ?? ($it['qty'] ?? 1));
                $rate = (float) ($it['unit_price'] ?? ($it['rate'] ?? 0));
                if (!empty($desc) || $rate > 0) {
                    $subtotal += ($qty * $rate);
                }
            }

            $taxRate = (float) ($validated['tax_rate'] ?? ($validated['tax'] ?? $quote->tax_rate));
            $taxAmount = $subtotal * $taxRate / 100;
            $discountRate = (float) ($validated['discount_rate'] ?? ($validated['discount'] ?? $quote->discount_rate));
            $discountAmount = $subtotal * $discountRate / 100;
            $shippingAmount = (float) ($validated['shipping_amount'] ?? $quote->shipping_amount);
            $handlingAmount = (float) ($validated['handling_amount'] ?? $quote->handling_amount);
            $totalAmount = $subtotal + $taxAmount - $discountAmount + $shippingAmount + $handlingAmount;

            $status = $validated['status'] ?? $quote->status;

            $quote->update([
                'customer_id' => $customer->id,
                'client_name' => $clientName,
                'client_email' => $validated['client_email'] ?? $customer->email,
                'contact_name' => $validated['contact_name'] ?? $customer->contact_name,
                'billing_address' => $validated['billing_address'] ?? $customer->billing_address,
                'issue_date' => $validated['issue_date'] ?? ($validated['issued'] ?? $quote->issue_date),
                'expiry_date' => $validated['expiry_date'] ?? ($validated['valid'] ?? $quote->expiry_date),
                'status' => $status,
                'currency' => $validated['currency'] ?? $quote->currency,
                'po_number' => $validated['po_number'] ?? $quote->po_number,
                'project_id' => $validated['project_id'] ?? ($validated['project'] ?? $quote->project_id),
                'notes' => $validated['notes'] ?? $quote->notes,
                'terms' => $validated['terms'] ?? $quote->terms,
                'subtotal' => $subtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'discount_rate' => $discountRate,
                'discount_amount' => $discountAmount,
                'shipping_amount' => $shippingAmount,
                'handling_amount' => $handlingAmount,
                'total_amount' => $totalAmount,
            ]);

            // Re-sync line items
            if ($request->has('items')) {
                $quote->items()->delete();
                foreach ($itemsData as $idx => $it) {
                    $desc = $it['description'] ?? ($it['desc'] ?? 'Service item');
                    $qty = (float) ($it['quantity'] ?? ($it['qty'] ?? 1));
                    $rate = (float) ($it['unit_price'] ?? ($it['rate'] ?? 0));
                    if (!empty($desc) || $rate > 0) {
                        QuoteItem::create([
                            'quote_id' => $quote->id,
                            'description' => $desc,
                            'reference' => $it['reference'] ?? '',
                            'quantity' => $qty,
                            'unit_price' => $rate,
                            'amount' => $qty * $rate,
                            'order' => $idx,
                        ]);
                    }
                }
            }

            if ($request->wantsJson() || $request->ajax()) {
                $formattedQuote = [
                    'id' => $quote->id,
                    'q' => (string) $quote->quote_number,
                    'client_name' => $quote->client_name,
                    'project' => $quote->project_id ?: 'Proposal',
                    'issued' => $quote->issue_date ? Carbon::parse($quote->issue_date)->format('Y-m-d') : '',
                    'valid' => $quote->expiry_date ? Carbon::parse($quote->expiry_date)->format('Y-m-d') : '',
                    'discount' => (float) $quote->discount_rate,
                    'tax' => (float) $quote->tax_rate,
                    'notes' => $quote->notes ?? '',
                    'terms' => $quote->terms ?? '',
                    'status' => $quote->status ?: 'draft',
                    'items' => $quote->items()->get()->map(function ($it) {
                        return [
                            'desc' => $it->description,
                            'qty' => (float) $it->quantity,
                            'rate' => (float) $it->unit_price,
                            'amount' => (float) $it->amount,
                        ];
                    })->all(),
                ];

                return response()->json([
                    'success' => true,
                    'message' => 'Quote QUO-' . $quote->quote_number . ' updated successfully!',
                    'quote_number' => $quote->quote_number,
                    'quote' => $formattedQuote,
                ]);
            }

            return redirect()->route('subscriber.quotes')->with('success', 'Quote QUO-' . $quote->quote_number . ' updated.');
        });
    }

    public function destroy(Quote $quote)
    {
        $num = $quote->quote_number;
        $quote->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Quote QUO-{$num} deleted successfully.",
            ]);
        }

        return redirect()->route('subscriber.quotes')->with('success', "Quote QUO-{$num} deleted.");
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $quoteNumbers = $request->input('quotes', []);

        $user = $this->getUser();
        $userId = $user->id ?? 1;

        if (empty($quoteNumbers)) {
            return response()->json(['success' => false, 'message' => 'No quotes selected.'], 422);
        }

        $quotes = Quote::where('user_id', $userId)->whereIn('quote_number', $quoteNumbers);

        switch ($action) {
            case 'send':
                $quotes->update(['status' => 'sent']);
                $msg = count($quoteNumbers) . ' quote(s) marked as sent.';
                break;
            case 'accept':
                $quotes->update(['status' => 'accepted']);
                $msg = count($quoteNumbers) . ' quote(s) marked as accepted.';
                break;
            case 'delete':
                $quotes->delete();
                $msg = count($quoteNumbers) . ' quote(s) deleted successfully.';
                break;
            default:
                $msg = 'Action completed.';
                break;
        }

        return response()->json(['success' => true, 'message' => $msg]);
    }

    public function updateStatus(Request $request, Quote $quote)
    {
        $status = $request->input('status');
        if (in_array($status, ['draft', 'sent', 'accepted', 'rejected', 'expired'])) {
            $quote->update(['status' => $status]);
            return response()->json(['success' => true, 'message' => "Quote status updated to {$status}."]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid status.'], 422);
    }

    public function convertToInvoice(Quote $quote)
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        return DB::transaction(function () use ($quote, $userId) {
            $lastInv = Invoice::where('user_id', $userId)->orderBy('id', 'desc')->first();
            $nextInvNum = $lastInv && is_numeric($lastInv->invoice_number)
                ? str_pad((int) $lastInv->invoice_number + 1, 4, '0', STR_PAD_LEFT)
                : '0025';

            $invoice = Invoice::create([
                'user_id' => $userId,
                'customer_id' => $quote->customer_id,
                'client_name' => $quote->client_name,
                'client_email' => $quote->client_email,
                'contact_name' => $quote->contact_name,
                'billing_address' => $quote->billing_address,
                'invoice_number' => $nextInvNum,
                'prefix' => 'INV-',
                'issue_date' => Carbon::now()->toDateString(),
                'due_date' => Carbon::now()->addDays(30)->toDateString(),
                'status' => 'draft',
                'type' => 'REG',
                'currency' => $quote->currency,
                'po_number' => $quote->po_number,
                'project_id' => $quote->project_id,
                'quote_id' => $quote->full_quote_number,
                'notes' => $quote->notes,
                'terms' => $quote->terms,
                'subtotal' => $quote->subtotal,
                'tax_rate' => $quote->tax_rate,
                'tax_amount' => $quote->tax_amount,
                'discount_rate' => $quote->discount_rate,
                'discount_amount' => $quote->discount_amount,
                'shipping_amount' => $quote->shipping_amount,
                'handling_amount' => $quote->handling_amount,
                'total_amount' => $quote->total_amount,
            ]);

            foreach ($quote->items as $it) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $it->description,
                    'reference' => $it->reference,
                    'quantity' => $it->quantity,
                    'unit_price' => $it->unit_price,
                    'amount' => $it->amount,
                    'order' => $it->order,
                ]);
            }

            $quote->update([
                'status' => 'accepted',
                'converted_invoice_id' => $invoice->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Quote QUO-{$quote->quote_number} successfully converted to Invoice INV-{$nextInvNum}!",
                'invoice_id' => $invoice->id,
                'invoice_number' => $nextInvNum,
                'redirect_url' => route('subscriber.invoices.edit', $invoice->id),
            ]);
        });
    }
}
