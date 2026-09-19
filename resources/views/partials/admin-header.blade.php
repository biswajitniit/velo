<!-- Overlay (mobile) -->
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- ─── SHELL ─────────────────────────────────────────────────── -->
<div class="shell">

    <!-- Top Bar -->
    <header class="topbar">
        <div class="topbar-left">
            <button class="sidebar-toggle-btn" type="button" onclick="toggleDashboardSidebar()" aria-label="Toggle sidebar"
                aria-expanded="true">
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
