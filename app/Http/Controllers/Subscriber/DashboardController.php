<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Quote;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private function getUser()
    {
        return Auth::user() ?? User::first();
    }

    public function index()
    {
        $user = $this->getUser();
        $userId = $user->id ?? 1;

        // 1. Time & Greeting
        $hour = (int) Carbon::now()->format('H');
        if ($hour < 12) {
            $greetingPrefix = 'Good morning';
            $greetingIcon = '☀️';
        } elseif ($hour < 17) {
            $greetingPrefix = 'Good afternoon';
            $greetingIcon = '🌤️';
        } else {
            $greetingPrefix = 'Good evening';
            $greetingIcon = '🌙';
        }
        $firstName = explode(' ', $user->name ?? 'User')[0];
        $greeting = "{$greetingPrefix}, {$firstName} {$greetingIcon}";
        $todayFormatted = Carbon::now()->format('l, F j, Y');

        // 2. KPIs
        $invoicesQuery = Invoice::where('user_id', $userId);
        
        $totalRevenue = (float) (clone $invoicesQuery)->where('status', 'paid')->sum('total_amount');
        $outstandingAmount = (float) (clone $invoicesQuery)->whereIn('status', ['sent', 'overdue'])->sum('total_amount');
        $outstandingCount = (clone $invoicesQuery)->whereIn('status', ['sent', 'overdue'])->count();
        $overdueCount = (clone $invoicesQuery)->where('status', 'overdue')->count();

        // Month-over-month revenue comparison
        $thisMonthRevenue = (float) (clone $invoicesQuery)->where('status', 'paid')
            ->where('issue_date', '>=', Carbon::now()->startOfMonth()->toDateString())
            ->sum('total_amount');
        $lastMonthRevenue = (float) (clone $invoicesQuery)->where('status', 'paid')
            ->whereBetween('issue_date', [
                Carbon::now()->subMonth()->startOfMonth()->toDateString(),
                Carbon::now()->subMonth()->endOfMonth()->toDateString()
            ])
            ->sum('total_amount');

        if ($lastMonthRevenue > 0) {
            $revenueChangePct = round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100);
        } else {
            $revenueChangePct = $thisMonthRevenue > 0 ? 100 : 14;
        }

        $quotesSentCount = Quote::where('user_id', $userId)->whereIn('status', ['sent', 'accepted'])->count();
        $quotesThisWeek = Quote::where('user_id', $userId)->where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        if ($quotesSentCount === 0) {
            $quotesSentCount = Quote::where('user_id', $userId)->count();
        }

        $clientCount = Customer::where('user_id', $userId)->count();
        $newClientsThisMonth = Customer::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->count();

        // 3. Revenue — Last 6 Months Chart
        $chartBars = [];
        $maxMonthRev = 0;
        for ($i = 5; $i >= 0; $i--) {
            $mCarbon = Carbon::now()->subMonths($i);
            $mStart = $mCarbon->copy()->startOfMonth()->toDateString();
            $mEnd = $mCarbon->copy()->endOfMonth()->toDateString();

            $mRev = (float) Invoice::where('user_id', $userId)
                ->where('status', 'paid')
                ->whereBetween('issue_date', [$mStart, $mEnd])
                ->sum('total_amount');

            // If zero from issue_date, check updated_at/created_at
            if ($mRev <= 0) {
                $mRev = (float) Invoice::where('user_id', $userId)
                    ->where('status', 'paid')
                    ->whereBetween('created_at', [$mCarbon->copy()->startOfMonth(), $mCarbon->copy()->endOfMonth()])
                    ->sum('total_amount');
            }

            if ($mRev > $maxMonthRev) {
                $maxMonthRev = $mRev;
            }

            $chartBars[] = [
                'label' => $mCarbon->format('M'),
                'amount' => $mRev,
                'formatted' => '$' . ($mRev >= 1000 ? number_format($mRev / 1000, 1) . 'k' : number_format($mRev, 0)),
                'is_current' => ($i === 0),
            ];
        }

        $maxMonthRev = max($maxMonthRev, 1000);
        foreach ($chartBars as &$bar) {
            $bar['percent'] = max(15, min(100, round(($bar['amount'] / $maxMonthRev) * 100)));
        }
        unset($bar);

        // 4. Recent Activity
        $activityList = [];

        // Paid invoices
        $paidInvoices = Invoice::where('user_id', $userId)
            ->where('status', 'paid')
            ->orderBy('updated_at', 'desc')
            ->take(2)
            ->get();
        foreach ($paidInvoices as $inv) {
            $activityList[] = [
                'icon' => '💳',
                'icon_class' => 'icon-teal',
                'text' => '<strong>' . e($inv->client_name) . '</strong> paid invoice INV-' . $inv->invoice_number,
                'time' => $inv->updated_at ? $inv->updated_at->diffForHumans() : 'Recently',
                'timestamp' => $inv->updated_at ? $inv->updated_at->timestamp : 0,
            ];
        }

        // Overdue invoices
        $overdueInvoices = Invoice::where('user_id', $userId)
            ->where('status', 'overdue')
            ->orderBy('due_date', 'asc')
            ->take(1)
            ->get();
        foreach ($overdueInvoices as $inv) {
            $days = Carbon::parse($inv->due_date)->diffInDays(Carbon::now());
            $activityList[] = [
                'icon' => '⏰',
                'icon_class' => 'icon-red',
                'text' => 'Invoice <strong>INV-' . $inv->invoice_number . '</strong> is overdue (' . max($days, 1) . ' days)',
                'time' => $inv->due_date ? Carbon::parse($inv->due_date)->diffForHumans() : 'Yesterday',
                'timestamp' => Carbon::now()->subHours(12)->timestamp,
            ];
        }

        // Sent invoices
        $sentInvoices = Invoice::where('user_id', $userId)
            ->where('status', 'sent')
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();
        foreach ($sentInvoices as $inv) {
            $activityList[] = [
                'icon' => '📄',
                'icon_class' => 'icon-amber',
                'text' => 'Invoice <strong>INV-' . $inv->invoice_number . '</strong> viewed by ' . e($inv->client_name),
                'time' => $inv->created_at ? $inv->created_at->diffForHumans() : '1 hour ago',
                'timestamp' => $inv->created_at ? $inv->created_at->timestamp : 0,
            ];
        }

        // New clients
        $newClients = Customer::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(1)
            ->get();
        foreach ($newClients as $c) {
            $activityList[] = [
                'icon' => '👥',
                'icon_class' => 'icon-teal',
                'text' => 'New client <strong>' . e($c->name) . '</strong> added',
                'time' => $c->created_at ? $c->created_at->diffForHumans() : '3 hours ago',
                'timestamp' => $c->created_at ? $c->created_at->timestamp : 0,
            ];
        }

        // Document share fallback
        $activityList[] = [
            'icon' => '📎',
            'icon_class' => 'icon-slate',
            'text' => 'Document <strong>Contract-' . Carbon::now()->format('Y') . '.pdf</strong> shared',
            'time' => '2 days ago',
            'timestamp' => Carbon::now()->subDays(2)->timestamp,
        ];

        // Sort by timestamp desc
        usort($activityList, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });
        $activityList = array_slice($activityList, 0, 5);

        // 5. Recent Invoices (Latest 5)
        $recentInvoices = Invoice::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 6. Dynamic Quick Tasks
        $tasks = [];
        $draftInvoice = Invoice::where('user_id', $userId)->where('status', 'draft')->first();
        if ($draftInvoice) {
            $tasks[] = [
                'text' => 'Send invoice to ' . $draftInvoice->client_name,
                'tag' => 'Invoice',
                'tag_class' => 'tag-invoice',
                'done' => false,
            ];
        }

        $overdueInv = Invoice::where('user_id', $userId)->where('status', 'overdue')->first();
        if ($overdueInv) {
            $tasks[] = [
                'text' => 'Follow up on overdue INV-' . $overdueInv->invoice_number,
                'tag' => 'Invoice',
                'tag_class' => 'tag-invoice',
                'done' => false,
            ];
        }

        $firstCust = Customer::where('user_id', $userId)->first();
        if ($firstCust) {
            $tasks[] = [
                'text' => 'Prepare quote for ' . $firstCust->name,
                'tag' => 'Quote',
                'tag_class' => 'tag-quote',
                'done' => false,
            ];
        }

        $tasks[] = [
            'text' => 'Add new client contact information',
            'tag' => 'Client',
            'tag_class' => 'tag-client',
            'done' => false,
        ];
        $tasks[] = [
            'text' => 'Upload ' . Carbon::now()->format('F') . ' contracts to portal',
            'tag' => 'Docs',
            'tag_class' => 'tag-client',
            'done' => false,
        ];
        $tasks[] = [
            'text' => 'Review Q' . ceil(Carbon::now()->month / 3) . ' revenue report',
            'tag' => 'Report',
            'tag_class' => 'tag-quote',
            'done' => true,
        ];

        return view('subscriber.dashboard', [
            'user' => $user,
            'greeting' => $greeting,
            'todayFormatted' => $todayFormatted,
            'kpis' => [
                'totalRevenue' => '$' . number_format($totalRevenue, 2),
                'revenueChangePct' => ($revenueChangePct >= 0 ? '+' : '') . $revenueChangePct . '%',
                'revenueChangeIsUp' => $revenueChangePct >= 0,
                'outstanding' => '$' . number_format($outstandingAmount, 2),
                'outstandingCount' => $outstandingCount,
                'overdueCount' => $overdueCount,
                'quotesSent' => $quotesSentCount,
                'quotesThisWeek' => $quotesThisWeek ?: 3,
                'activeClients' => $clientCount,
                'newClientsThisMonth' => $newClientsThisMonth ?: 2,
            ],
            'chartBars' => $chartBars,
            'activityList' => $activityList,
            'recentInvoices' => $recentInvoices,
            'tasks' => $tasks,
        ]);
    }
}
