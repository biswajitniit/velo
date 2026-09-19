<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velo — Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="dashboard-page">

    <!-- ─── SIDEBAR ─────────────────────────────────────────────── -->
    @include('subscriber.includes.sidebar')

    <!-- Overlay (mobile) -->
    <div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

    <!-- ─── SHELL ─────────────────────────────────────────────────── -->
    <div class="shell">

        <!-- Top Bar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle-btn" type="button" onclick="toggleDashboardSidebar()"
                    aria-label="Toggle sidebar" aria-expanded="true">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="page-title">Dashboard</div>
                <div class="topbar-search">
                    <span class="search-icon">🔍</span>
                    <input type="text" placeholder="Search invoices, customers…" onkeydown="if(event.key==='Enter'){ window.location.href='{{ route('subscriber.invoices') }}?q='+encodeURIComponent(this.value); }">
                </div>
            </div>
            <div class="topbar-right">
                <a href="{{ route('subscriber.notifications') }}" class="topbar-btn" title="Notifications">
                    🔔
                    <span class="topbar-dot"></span>
                </a>
                <a href="#" class="topbar-btn" title="Help">❓</a>
            </div>
        </header>

        <!-- Main -->
        <main class="main">

            <!-- Greeting -->
            <div class="greeting-row">
                <div class="greeting-text">
                    <h1>{{ $greeting }}</h1>
                    <p>{{ $todayFormatted }} · Here's what's happening with your business today.</p>
                </div>
                <div class="greeting-actions">
                    <button class="btn-secondary" onclick="showInlineToast('Quote draft feature coming soon!')">+ New Quote</button>
                    <button class="btn-new-invoice" onclick="window.location.href='{{ route('subscriber.invoices.create') }}'">＋ New
                        Invoice</button>
                </div>
            </div>

            <!-- KPIs -->
            <div class="kpi-grid">
                <div class="kpi-card" onclick="window.location.href='{{ route('subscriber.invoices') }}'" style="cursor:pointer;">
                    <div class="kpi-header">
                        <span class="kpi-label">Total Revenue</span>
                        <div class="kpi-icon icon-teal">💰</div>
                    </div>
                    <div class="kpi-value">{{ $kpis['totalRevenue'] }}</div>
                    <div class="kpi-change {{ $kpis['revenueChangeIsUp'] ? 'up' : 'down' }}">{{ $kpis['revenueChangeIsUp'] ? '↑' : '↓' }} {{ $kpis['revenueChangePct'] }} this month</div>
                </div>
                <div class="kpi-card" onclick="window.location.href='{{ route('subscriber.invoices') }}'" style="cursor:pointer;">
                    <div class="kpi-header">
                        <span class="kpi-label">Outstanding</span>
                        <div class="kpi-icon icon-amber">⏳</div>
                    </div>
                    <div class="kpi-value">{{ $kpis['outstanding'] }}</div>
                    <div class="kpi-change down">↓ {{ $kpis['outstandingCount'] }} invoice{{ $kpis['outstandingCount'] !== 1 ? 's' : '' }} due</div>
                </div>
                <div class="kpi-card" onclick="window.location.href='{{ route('subscriber.invoices') }}'" style="cursor:pointer;">
                    <div class="kpi-header">
                        <span class="kpi-label">Quotes & Active</span>
                        <div class="kpi-icon icon-slate">📄</div>
                    </div>
                    <div class="kpi-value">{{ $kpis['quotesSent'] }}</div>
                    <div class="kpi-change up">↑ {{ $kpis['quotesThisWeek'] }} this week</div>
                </div>
                <div class="kpi-card" onclick="window.location.href='{{ route('subscriber.customers') }}'" style="cursor:pointer;">
                    <div class="kpi-header">
                        <span class="kpi-label">Active Clients</span>
                        <div class="kpi-icon icon-teal">👥</div>
                    </div>
                    <div class="kpi-value">{{ $kpis['activeClients'] }}</div>
                    <div class="kpi-change up">↑ {{ $kpis['newClientsThisMonth'] }} new this month</div>
                </div>
            </div>

            <!-- Mid row: chart + activity -->
            <div class="mid-row">

                <!-- Revenue Chart -->
                <div class="card chart-card">
                    <div class="card-head">
                        <span class="card-title">Revenue — Last 6 Months</span>
                        <a href="{{ route('subscriber.invoices') }}" class="card-action">View Report →</a>
                    </div>
                    <div class="chart-area">
                        <div class="chart-bars">
                            @foreach($chartBars as $bar)
                                <div class="chart-col">
                                    <div class="bar-val">{{ $bar['formatted'] }}</div>
                                    <div class="bar {{ $bar['is_current'] ? '' : 'muted' }}" style="height: {{ $bar['percent'] }}%;"></div>
                                    <div class="bar-label">{{ $bar['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-dot legend-current"></div>
                                Current month
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot legend-previous"></div>
                                Previous months
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="card activity-card">
                    <div class="card-head">
                        <span class="card-title">Recent Activity</span>
                        <a href="{{ route('subscriber.invoices') }}" class="card-action">View all →</a>
                    </div>
                    <div class="activity-list">
                        @forelse($activityList as $act)
                            <div class="activity-item">
                                <div class="act-icon {{ $act['icon_class'] }}">{{ $act['icon'] }}</div>
                                <div class="act-body">
                                    <div class="act-text">{!! $act['text'] !!}</div>
                                    <div class="act-time">{{ $act['time'] }}</div>
                                </div>
                            </div>
                        @empty
                            <div style="padding: 24px; text-align:center; color: var(--muted); font-size: 0.82rem;">No recent activity</div>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Bottom row: invoices + tasks -->
            <div class="bottom-row">

                <!-- Recent Invoices -->
                <div class="card invoices-card">
                    <div class="card-head">
                        <span class="card-title">Recent Invoices</span>
                        <a href="{{ route('subscriber.invoices') }}" class="card-action">View all →</a>
                    </div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Amount</th>
                                    <th>Due</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInvoices as $inv)
                                    @php
                                        $badgeClass = match($inv->status) {
                                            'paid' => 'badge-paid',
                                            'overdue' => 'badge-overdue',
                                            'sent', 'ready' => 'badge-pending',
                                            default => 'badge-draft'
                                        };
                                        $statusLabel = match($inv->status) {
                                            'sent', 'ready' => 'Pending',
                                            default => ucfirst($inv->status)
                                        };
                                    @endphp
                                    <tr onclick="window.location.href='{{ route('subscriber.invoices.edit', $inv->id) }}'" style="cursor:pointer;">
                                        <td>
                                            <div class="inv-client">{{ $inv->client_name }}</div>
                                            <div class="inv-num">INV-{{ $inv->invoice_number }}</div>
                                        </td>
                                        <td><span class="inv-amount">${{ number_format($inv->total_amount, 2) }}</span></td>
                                        <td><span class="inv-due">{{ $inv->due_date ? \Carbon\Carbon::parse($inv->due_date)->format('M j') : '—' }}</span></td>
                                        <td><span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center; padding: 24px; color: var(--muted);">No invoices created yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Tasks -->
                <div class="card tasks-card">
                    <div class="card-head">
                        <span class="card-title">Quick Tasks</span>
                        <a href="{{ route('subscriber.invoices.create') }}" class="card-action">+ Add invoice →</a>
                    </div>
                    <div class="task-list">
                        @foreach($tasks as $t)
                            <div class="task-item {{ $t['done'] ? 'task-done' : '' }}" onclick="toggleTask(this)">
                                <div class="task-check">✓</div>
                                <span class="task-text">{{ $t['text'] }}</span>
                                <span class="task-tag {{ $t['tag_class'] }}">{{ $t['tag'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Mobile FAB disabled: topbar menu button now handles mobile sidebar toggle.
<button class="mobile-menu-btn" id="menuBtn" onclick="toggleSidebar()">☰</button>
-->

    <!-- Toast -->
    <div id="toast" class="dashboard-toast"></div>

    <script src="{{ asset('assets/js/bootstrap.min.js') }} "></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
