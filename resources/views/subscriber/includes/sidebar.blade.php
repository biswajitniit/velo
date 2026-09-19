<aside class="sidebar" id="sidebar">
    <div class="sidebar-grid"></div>
    <div class="sidebar-inner">

        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="{{ route('subscriber.dashboard') }}">Velo<span>.</span></a>
        </div>

        <!-- User -->
        @php
            $authUsr = Auth::user();
            $initials = 'U';
            if ($authUsr && !empty($authUsr->name)) {
                $parts = preg_split('/\s+/', trim($authUsr->name));
                $initials = count($parts) >= 2 
                    ? strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1))
                    : strtoupper(substr($parts[0], 0, 2));
            }
            $activeInvoicesCount = 0;
            $activeQuotesCount = 0;
            try {
                if ($authUsr && class_exists(\App\Models\Invoice::class)) {
                    $activeInvoicesCount = \App\Models\Invoice::where('user_id', $authUsr->id)->whereIn('status', ['sent', 'overdue', 'pending'])->count();
                }
                if ($authUsr && class_exists(\App\Models\Quote::class)) {
                    $activeQuotesCount = \App\Models\Quote::where('user_id', $authUsr->id)->whereIn('status', ['sent', 'draft', 'pending'])->count();
                }
            } catch (\Throwable $e) {
                // Fallback gracefully
            }
        @endphp
        <div class="sidebar-user">
            <div class="user-avatar">{{ $initials }}</div>
            <div class="user-details">
                <div class="user-name" title="{{ $authUsr->name ?? 'User' }}">{{ $authUsr->name ?? 'User' }}</div>
                <div class="user-plan">{{ $authUsr->subscription->plan_name ?? 'Pro Plan · Active' }}</div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>

            <a href="{{ route('subscriber.dashboard') }}"
                class="nav-item {{ request()->routeIs('subscriber.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">📊</span>
                <span class="nav-label">Dashboard</span>
            </a>
            <a href="{{ route('subscriber.invoices') }}"
                class="nav-item {{ request()->routeIs('subscriber.invoices*') ? 'active' : '' }}">
                <span class="nav-icon">🧾</span>
                <span class="nav-label">Invoices</span>
                @if($activeInvoicesCount > 0)
                    <span class="nav-count">{{ $activeInvoicesCount }}</span>
                @endif
            </a>
            <a href="{{ route('subscriber.quotes') }}"
                class="nav-item {{ request()->routeIs('subscriber.quotes*') ? 'active' : '' }}">
                <span class="nav-icon">📄</span>
                <span class="nav-label">Quotes</span>
                @if($activeQuotesCount > 0)
                    <span class="nav-count">{{ $activeQuotesCount }}</span>
                @endif
            </a>

            <div class="nav-section-label">Manage</div>

            <a href="{{ route('subscriber.customers') }}"
                class="nav-item {{ request()->routeIs('subscriber.customers*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span>
                <span class="nav-label">Customers</span>
            </a>
            <a href="{{ route('subscriber.projects') }}"
                class="nav-item {{ request()->routeIs('subscriber.projects*') ? 'active' : '' }}">
                <span class="nav-icon">📁</span>
                <span class="nav-label">Projects</span>
                <span class="nav-badge">New</span>
            </a>
            <a href="{{ route('subscriber.items') }}"
                class="nav-item {{ request()->routeIs('subscriber.items*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span>
                <span class="nav-label">Items</span>
            </a>
            <a href="{{ route('subscriber.documents') }}"
                class="nav-item {{ request()->routeIs('subscriber.documents*') ? 'active' : '' }}">
                <span class="nav-icon">📎</span>
                <span class="nav-label">Documents</span>
            </a>

            <div class="nav-section-label">Finance</div>
            <a href="{{ route('subscriber.payments') }}"
                class="nav-item {{ request()->routeIs('subscriber.payments*') ? 'active' : '' }}">
                <span class="nav-icon">💳</span>
                <span class="nav-label">Payments</span>
            </a>
            <a href="{{ route('subscriber.banks') }}"
                class="nav-item {{ request()->routeIs('subscriber.banks*') ? 'active' : '' }}">
                <span class="nav-icon">🏦</span>
                <span class="nav-label">Bank Accounts</span>
            </a>

            <div class="nav-section-label">Tools</div>

            <a href="{{ route('subscriber.notifications') }}"
                class="nav-item {{ request()->routeIs('subscriber.notifications*') ? 'active' : '' }}">
                <span class="nav-icon">🔔</span>
                <span class="nav-label">Notifications</span>
            </a>

            <div class="nav-section-label">Account</div>

            <a href="{{ route('settings.index') }}"
                class="nav-item {{ request()->routeIs('settings*') ? 'active' : '' }}">
                <span class="nav-icon">⚙️</span>
                <span class="nav-label">Settings</span>
            </a>
        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <a href="mailto:support@velo.app">
                <span>❓</span> Help &amp; Support
            </a>

            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span>🚪</span> Sign out
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

    </div>
</aside>
