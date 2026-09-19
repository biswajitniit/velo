<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velo — Payments</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --ink: #0d0d0d;
            --paper: #f5f2eb;
            --cream: #ede9de;
            --slate: #1e2a38;
            --slate-light: #253447;
            --slate-hover: #2e3f55;
            --teal: #00b899;
            --teal-dark: #009e82;
            --teal-pale: #d6f5ef;
            --amber: #f5a623;
            --amber-pale: #fef3d8;
            --red-soft: #f05454;
            --red-pale: #fde8e8;
            --blue: #3b82f6;
            --blue-pale: #dbeafe;
            --purple: #8b5cf6;
            --purple-pale: #ede9fe;
            --green: #22c55e;
            --green-pale: #dcfce7;
            --muted: #6b7280;
            --border: #ddd8cc;
            --border-dark: rgba(255, 255, 255, 0.08);
            --card: #ffffff;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.10);
            --shadow-lg: 0 24px 64px rgba(0, 0, 0, 0.13);
            --radius: 16px;
            --radius-sm: 10px;
            --sidebar-w: 260px;
            --topbar-h: 64px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            color: var(--ink);
            font-size: 15px;
            line-height: 1.6;
            overflow-x: hidden;
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR ───────────────────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: var(--slate);
            display: flex;
            flex-direction: column;
            z-index: 50;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -80px;
            left: -80px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 184, 153, 0.18) 0%, transparent 65%);
            pointer-events: none;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            bottom: 60px;
            right: -60px;
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, rgba(245, 166, 35, 0.12) 0%, transparent 65%);
            pointer-events: none;
        }

        .sidebar-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 22px 22px;
            pointer-events: none;
        }

        .sidebar-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 0;
        }

        .sidebar-logo {
            padding: 22px 24px 20px;
            border-bottom: 1px solid var(--border-dark);
            flex-shrink: 0;
        }

        .sidebar-logo a {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.35rem;
            letter-spacing: -0.04em;
            color: #fff;
            text-decoration: none;
        }

        .sidebar-logo a span {
            color: var(--teal);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-dark);
            flex-shrink: 0;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), var(--teal-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
            color: #fff;
            flex-shrink: 0;
        }

        .user-details {
            min-width: 0;
        }

        .user-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-plan {
            font-size: 0.7rem;
            color: var(--teal);
            font-weight: 500;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 0;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
            padding: 14px 24px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 20px 9px 24px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.875rem;
            font-weight: 400;
            text-decoration: none;
            transition: background .15s, color .15s;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.9);
        }

        .nav-item.active {
            background: rgba(0, 184, 153, 0.14);
            color: var(--teal);
            font-weight: 600;
            border-left-color: var(--teal);
        }

        .nav-item .nav-icon {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item .nav-label {
            flex: 1;
        }

        /* Sub-menu */
        .nav-sub {
            display: flex;
            flex-direction: column;
        }

        .nav-sub-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 20px 7px 52px;
            font-size: 0.82rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: background .15s, color .15s;
            position: relative;
        }

        .nav-sub-item::before {
            content: '';
            position: absolute;
            left: 36px;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-sub-item:hover {
            background: rgba(255, 255, 255, 0.04);
            color: rgba(255, 255, 255, 0.85);
        }

        .nav-sub-item:hover::before {
            background: rgba(255, 255, 255, 0.5);
        }

        .nav-sub-item.active {
            color: var(--teal);
            border-left-color: var(--teal);
            font-weight: 600;
        }

        .nav-sub-item.active::before {
            background: var(--teal);
        }

        .nav-badge {
            font-size: 0.6rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 99px;
            background: var(--amber);
            color: var(--slate);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .nav-badge.red {
            background: var(--red-soft);
            color: #fff;
        }

        .nav-count {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 99px;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-dark);
            flex-shrink: 0;
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.82rem;
            text-decoration: none;
            transition: background .15s, color .15s;
        }

        .sidebar-footer a:hover {
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.8);
        }

        /* ─── LAYOUT ─────────────────────────────────────────────── */
        .shell {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            height: var(--topbar-h);
            background: rgba(245, 242, 235, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            gap: 16px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--slate);
            letter-spacing: -0.02em;
        }

        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: 99px;
            padding: 7px 16px;
            min-width: 220px;
            transition: border-color .2s;
        }

        .topbar-search:focus-within {
            border-color: var(--teal);
        }

        .topbar-search input {
            border: none;
            outline: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--ink);
            width: 100%;
        }

        .topbar-search input::placeholder {
            color: var(--muted);
        }

        .search-icon {
            font-size: 0.85rem;
            color: var(--muted);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: var(--card);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: var(--muted);
            transition: border-color .2s, color .2s, background .2s;
            position: relative;
            text-decoration: none;
        }

        .topbar-btn:hover {
            border-color: var(--teal);
            color: var(--teal);
            background: var(--teal-pale);
        }

        .topbar-dot {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 7px;
            height: 7px;
            background: var(--red-soft);
            border-radius: 50%;
            border: 1.5px solid var(--paper);
        }

        /* Access banner */
        .access-banner {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--amber-pale);
            border: 1.5px solid var(--amber);
            border-radius: var(--radius-sm);
            padding: 10px 18px;
            margin-bottom: 24px;
            font-size: 0.82rem;
            color: var(--slate);
        }

        .access-banner strong {
            font-weight: 600;
        }

        .access-badge-row {
            display: flex;
            gap: 6px;
            margin-left: auto;
        }

        .role-chip {
            font-size: 0.67rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 99px;
            background: var(--slate);
            color: #fff;
        }

        .role-chip.sub {
            background: var(--teal);
        }

        .role-chip.admin {
            background: var(--slate);
        }

        .role-chip.mgr {
            background: var(--blue);
        }

        /* ─── MAIN ───────────────────────────────────────────────── */
        .main {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
        }

        /* Page header */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header-left h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--slate);
            letter-spacing: -0.03em;
        }

        .page-header-left p {
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .page-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            border-radius: 99px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            border: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--teal);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0, 184, 153, 0.35);
        }

        .btn-secondary {
            background: var(--card);
            border: 1.5px solid var(--border);
            color: var(--ink);
        }

        .btn-secondary:hover {
            border-color: var(--slate);
            background: var(--cream);
        }

        .btn-ghost {
            background: transparent;
            border: 1.5px solid var(--border);
            color: var(--muted);
        }

        .btn-ghost:hover {
            border-color: var(--muted);
            color: var(--ink);
            background: var(--cream);
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 0.75rem;
        }

        /* KPI strip */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .kpi-card {
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 22px;
            box-shadow: var(--shadow-sm);
            transition: box-shadow .2s;
        }

        .kpi-card:hover {
            box-shadow: var(--shadow-md);
        }

        .kpi-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .kpi-label {
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .kpi-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .icon-teal {
            background: var(--teal-pale);
        }

        .icon-amber {
            background: var(--amber-pale);
        }

        .icon-red {
            background: var(--red-pale);
        }

        .icon-blue {
            background: var(--blue-pale);
        }

        .kpi-value {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--slate);
            letter-spacing: -0.03em;
        }

        .kpi-change {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .kpi-change.up {
            color: var(--teal);
        }

        .kpi-change.down {
            color: var(--red-soft);
        }

        /* ─── FILTER BAR ───────────────────────────────────────── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .tab-group {
            display: flex;
            gap: 4px;
        }

        .tab-btn {
            padding: 7px 14px;
            border-radius: 99px;
            border: 1.5px solid transparent;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--muted);
            cursor: pointer;
            transition: all .15s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tab-btn:hover {
            background: var(--cream);
            color: var(--slate);
        }

        .tab-btn.active {
            background: var(--slate);
            color: #fff;
            border-color: var(--slate);
        }

        .tab-btn .count {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 99px;
            background: rgba(255, 255, 255, 0.18);
        }

        .tab-btn:not(.active) .count {
            background: var(--border);
            color: var(--muted);
        }

        .filter-spacer {
            flex: 1;
        }

        .filter-select {
            padding: 7px 12px;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            background: var(--card);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            color: var(--ink);
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }

        .filter-select:focus {
            border-color: var(--teal);
        }

        .search-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: 99px;
            padding: 7px 14px;
            transition: border-color .2s;
            min-width: 240px;
        }

        .search-wrap:focus-within {
            border-color: var(--teal);
        }

        .search-wrap input {
            border: none;
            outline: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.8rem;
            color: var(--ink);
            width: 100%;
        }

        .search-wrap input::placeholder {
            color: var(--muted);
        }

        /* ─── TABLE CARD ────────────────────────────────────────── */
        .card {
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--slate);
            letter-spacing: -0.01em;
        }

        .card-action {
            font-size: 0.78rem;
            color: var(--teal);
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }

        .card-action:hover {
            color: var(--teal-dark);
        }

        /* Table */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 11px 16px;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--muted);
            background: var(--cream);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
        }

        thead th:hover {
            color: var(--slate);
        }

        thead th.sort-asc::after {
            content: ' ↑';
            color: var(--teal);
        }

        thead th.sort-desc::after {
            content: ' ↓';
            color: var(--teal);
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .1s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--teal-pale);
            cursor: pointer;
        }

        td {
            padding: 13px 16px;
            font-size: 0.845rem;
            color: var(--ink);
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Status / match badges — plain text only */
        .badge {
            font-size: 0.845rem;
            color: var(--ink);
        }

        .badge::before {
            display: none;
        }

        .badge-paid,
        .badge-pending,
        .badge-refunded,
        .badge-matched,
        .badge-unmatched,
        .badge-partial {
            background: none;
            color: var(--ink);
        }

        .badge-failed {
            background: none;
            color: var(--red-soft);
        }

        /* Source — plain text, no pill */
        .source-pill {
            font-size: 0.845rem;
            color: var(--ink);
            background: none;
            border: none;
            padding: 0;
        }

        .source-pill.stripe,
        .source-pill.manual {
            background: none;
            color: var(--ink);
            border: none;
        }

        /* Row actions */
        .row-actions {
            display: flex;
            gap: 4px;
            justify-content: flex-end;
        }

        .row-btn {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            color: var(--muted);
            transition: all .15s;
        }

        .row-btn:hover {
            border-color: var(--teal);
            color: var(--teal);
            background: var(--teal-pale);
        }

        .row-btn.danger:hover {
            border-color: var(--red-soft);
            color: var(--red-soft);
            background: var(--red-pale);
        }

        /* Invoice ref link */
        .inv-link {
            font-family: 'Syne', sans-serif;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--teal);
            text-decoration: none;
            letter-spacing: -0.01em;
        }

        .inv-link:hover {
            color: var(--teal-dark);
            text-decoration: underline;
        }

        .no-inv {
            font-size: 0.78rem;
            color: var(--muted);
            font-style: italic;
        }

        /* Ref code */
        .ref-code {
            font-family: 'Syne', sans-serif;
            font-size: 0.78rem;
            color: var(--slate);
            letter-spacing: 0.02em;
        }

        /* Currency code — plain text */
        .curr-code {
            font-size: 0.845rem;
            color: var(--ink);
            background: none;
            border: none;
            padding: 0;
        }

        /* Amount */
        .amount-cell {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--slate);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 32px;
            color: var(--muted);
        }

        .empty-icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }

        .empty-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--slate);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 0.82rem;
        }

        /* Pagination */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            font-size: 0.8rem;
            color: var(--muted);
        }

        .pag-btns {
            display: flex;
            gap: 4px;
        }

        .pag-btn {
            min-width: 32px;
            height: 32px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: var(--card);
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .pag-btn:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        .pag-btn.active {
            background: var(--slate);
            border-color: var(--slate);
            color: #fff;
        }

        /* ─── MODALS ─────────────────────────────────────────────── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(3px);
            z-index: 200;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 540px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalIn .2s ease;
        }

        .modal-wide {
            max-width: 700px;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .modal-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--slate);
        }

        .modal-subtitle {
            font-size: 0.78rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-size: 1rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .modal-close:hover {
            border-color: var(--red-soft);
            color: var(--red-soft);
            background: var(--red-pale);
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            background: var(--cream);
            border-radius: 0 0 var(--radius) var(--radius);
        }

        /* Form fields */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-grid .span2 {
            grid-column: span 2;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .field-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--slate);
        }

        .field-hint {
            font-size: 0.72rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .field input,
        .field select,
        .field textarea {
            padding: 9px 12px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.845rem;
            color: var(--ink);
            background: var(--card);
            outline: none;
            transition: border-color .2s;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: var(--teal);
        }

        .field input.error,
        .field select.error {
            border-color: var(--red-soft);
        }

        .req {
            color: var(--red-soft);
        }

        .field-error {
            font-size: 0.72rem;
            color: var(--red-soft);
            display: none;
        }

        .field-error.show {
            display: block;
        }

        .amount-prefix {
            position: relative;
        }

        .amount-prefix span {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.85rem;
            font-weight: 600;
            pointer-events: none;
        }

        .amount-prefix input {
            padding-left: 26px;
        }

        /* Match modal */
        .match-search-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--cream);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 14px;
            transition: border-color .2s;
            margin-bottom: 14px;
        }

        .match-search-wrap:focus-within {
            border-color: var(--teal);
        }

        .match-search-wrap input {
            border: none;
            outline: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--ink);
            width: 100%;
        }

        .invoice-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 320px;
            overflow-y: auto;
        }

        .invoice-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all .15s;
            background: var(--card);
        }

        .invoice-row:hover {
            border-color: var(--teal);
            background: var(--teal-pale);
        }

        .invoice-row.selected {
            border-color: var(--teal);
            background: var(--teal-pale);
        }

        .inv-radio {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid var(--border);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .invoice-row.selected .inv-radio {
            border-color: var(--teal);
            background: var(--teal);
        }

        .invoice-row.selected .inv-radio::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #fff;
        }

        .inv-info {
            flex: 1;
        }

        .inv-num {
            font-family: 'Syne', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--slate);
        }

        .inv-client {
            font-size: 0.75rem;
            color: var(--muted);
        }

        .inv-amount-col {
            text-align: right;
        }

        .inv-total {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--slate);
        }

        .inv-due {
            font-size: 0.72rem;
            color: var(--muted);
        }

        .inv-status-col {
            width: 80px;
        }

        /* Match summary bar */
        .match-summary {
            margin-top: 14px;
            padding: 12px 14px;
            background: var(--teal-pale);
            border: 1.5px solid var(--teal);
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            color: var(--teal-dark);
            display: none;
        }

        .match-summary.show {
            display: block;
        }

        .match-summary strong {
            font-weight: 700;
        }

        /* ─── TOAST ──────────────────────────────────────────────── */
        .toast-stack {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 999;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--slate);
            color: #fff;
            padding: 12px 18px;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 500;
            box-shadow: var(--shadow-md);
            animation: toastIn .25s ease;
            min-width: 240px;
        }

        .toast.success .toast-icon {
            color: var(--teal);
        }

        .toast.error .toast-icon {
            color: var(--red-soft);
        }

        .toast.info .toast-icon {
            color: var(--amber);
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* ─── SIDEBAR OVERLAY (mobile) ─────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 49;
        }

        /* ─── RESPONSIVE ─────────────────────────────────────────── */
        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s;
            }

            .sidebar.open {
                transform: none;
            }

            .sidebar-overlay {
                display: block;
            }

            .shell {
                margin-left: 0;
            }

            .kpi-grid {
                grid-template-columns: 1fr 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-grid .span2 {
                grid-column: span 1;
            }
        }

        @media (max-width: 600px) {
            .main {
                padding: 16px;
            }

            .kpi-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .topbar-search {
                display: none;
            }

            .access-banner {
                flex-wrap: wrap;
            }

            .access-badge-row {
                margin-left: 0;
                margin-top: 6px;
            }

            .filter-bar {
                gap: 6px;
            }

            .filter-spacer {
                display: none;
            }
        }
    </style>
</head>

<body class="dashboard-page">

    <div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>
    <!-- SIDEBAR -->
    @include('subscriber.includes.sidebar')
    <!-- ─── SHELL ─────────────────────────────────────────────────── -->
    <div class="shell">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle-btn" type="button" onclick="toggleDashboardSidebar()" aria-label="Toggle sidebar"
                    aria-expanded="true">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="page-title">Payments</div>
            </div>
            <div class="topbar-right">
                <a href="{{ route('subscriber.notifications') }}" class="topbar-btn" title="Notifications">
                    🔔
                    <span class="topbar-dot"></span>
                </a>
                <a href="#" class="topbar-btn" title="Help" onclick="event.preventDefault();">❓</a>
            </div>
        </header>

        <!-- Main -->
        <main class="main">

            <!-- Access Banner -->
            <div class="access-banner">
                <span>🔐</span>
                <div>
                    <strong>Restricted Access.</strong> This page is visible to users with the following roles only:
                </div>
                <div class="access-badge-row">
                    <span class="role-chip sub">Subscriber</span>
                    <span class="role-chip admin">Admin</span>
                    <span class="role-chip mgr">Manager</span>
                </div>
            </div>

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left">
                    <h1>Payments 💳</h1>
                    <p>Track processed payments, log manual entries and match payments to invoices.</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-secondary" onclick="openAutoMatch()">⚡ Auto-Match All</button>
                    <button class="btn btn-secondary" onclick="showToast('info','📥 Exporting payments…')">↓
                        Export</button>
                    <button class="btn btn-primary" onclick="openAddPayment()">＋ Add Payment</button>
                </div>
            </div>

            <!-- KPIs -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Total Collected</span>
                        <div class="kpi-icon icon-teal">💰</div>
                    </div>
                    <div class="kpi-value">$48,720</div>
                    <div class="kpi-change up">↑ 12% this month</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Unmatched</span>
                        <div class="kpi-icon icon-amber">🔗</div>
                    </div>
                    <div class="kpi-value" id="kpiUnmatched">3</div>
                    <div class="kpi-change down">Needs manual review</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Pending / Processing</span>
                        <div class="kpi-icon icon-blue">⏳</div>
                    </div>
                    <div class="kpi-value">2</div>
                    <div class="kpi-change">Awaiting confirmation</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Failed / Refunded</span>
                        <div class="kpi-icon icon-red">⚠️</div>
                    </div>
                    <div class="kpi-value">1</div>
                    <div class="kpi-change down">Requires action</div>
                </div>
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar">
                <div class="tab-group">
                    <button class="tab-btn active" id="tabAll" onclick="switchTab('all',this)">All <span
                            class="count" id="cntAll">12</span></button>
                    <button class="tab-btn" id="tabStripe" onclick="switchTab('stripe',this)">Stripe <span
                            class="count" id="cntStripe">8</span></button>
                    <button class="tab-btn" id="tabManual" onclick="switchTab('manual',this)">Manual <span
                            class="count" id="cntManual">4</span></button>
                    <button class="tab-btn" id="tabUnmatched" onclick="switchTab('unmatched',this)">Unmatched <span
                            class="count" id="cntUnmatched">3</span></button>
                </div>
                <div class="filter-spacer"></div>
                <select class="filter-select" id="statusFilter" onchange="applyFilters()">
                    <option value="">All Statuses</option>
                    <option value="paid">Paid</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
                <select class="filter-select" id="sourceFilter" onchange="applyFilters()">
                    <option value="">All Sources</option>
                    <option value="stripe-card">Credit Card (Stripe)</option>
                    <option value="stripe-ach">ACH / Bank (Stripe)</option>
                    <option value="check">Check</option>
                    <option value="wire">Wire Transfer</option>
                    <option value="cash">Cash</option>
                    <option value="debit">Debit Card</option>
                    <option value="other">Other</option>
                </select>
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="tableSearch" placeholder="Search ref, client, invoice…"
                        oninput="applyFilters()">
                </div>
            </div>

            <!-- Payments Table -->
            <div class="card">
                <div class="card-head">
                    <span class="card-title">Payment Register</span>
                    <a class="card-action" onclick="showToast('info','📊 Opening payment report…')">View Report →</a>
                </div>
                <div class="table-wrap">
                    <table id="paymentsTable">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="checkAll" onchange="toggleAll(this)"
                                        style="cursor:pointer;"></th>
                                <th data-col="ref" onclick="sortTable('ref')">Reference</th>
                                <th data-col="date" onclick="sortTable('date')">Pay Date</th>
                                <th data-col="client" onclick="sortTable('client')">Client</th>
                                <th data-col="source" onclick="sortTable('source')">Source</th>
                                <th data-col="amount" onclick="sortTable('amount')">Amount</th>
                                <th data-col="currency" onclick="sortTable('currency')">Curr</th>
                                <th data-col="status" onclick="sortTable('status')">Status</th>
                                <th data-col="match" onclick="sortTable('match')">Match Status</th>
                                <th data-col="invoice" onclick="sortTable('invoice')">Invoice</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"></tbody>
                    </table>
                    <div class="empty-state" id="emptyState" style="display:none;">
                        <div class="empty-icon">💳</div>
                        <div class="empty-title">No payments found</div>
                        <div class="empty-sub">Try adjusting your filters or add a payment manually.</div>
                    </div>
                </div>
                <div class="table-footer">
                    <div id="tableInfo">Showing 1–12 of 12 payments</div>
                    <div class="pag-btns" id="pagination"></div>
                </div>
            </div>

        </main>
    </div>

    <!-- ══════════════════════════════════════════════════════════
     MODAL: Add / Edit Payment
═══════════════════════════════════════════════════════════════ -->
    <div class="modal-overlay" id="paymentModal" onclick="handleOverlayClick(event,'paymentModal')">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title" id="payModalTitle">Add Manual Payment</div>
                    <div class="modal-subtitle">Record a check, wire, cash, debit, or other offline payment</div>
                </div>
                <button class="modal-close" onclick="closeModal('paymentModal')">✕</button>
            </div>
            <div class="modal-body">
                <div class="form-grid">
                    <!-- Reference -->
                    <div class="field span2">
                        <label class="field-label">Reference / Check Number <span class="req">*</span></label>
                        <input type="text" id="fRef" placeholder="e.g. CHK-00124 or WIRE-20260511">
                        <span class="field-error" id="fRefErr">Reference is required.</span>
                    </div>
                    <!-- Pay Date -->
                    <div class="field">
                        <label class="field-label">Pay Date <span class="req">*</span></label>
                        <input type="date" id="fPayDate">
                        <span class="field-error" id="fPayDateErr">Pay date is required.</span>
                    </div>
                    <!-- Applied Date -->
                    <div class="field">
                        <label class="field-label">Applied Date</label>
                        <input type="date" id="fAppliedDate">
                        <span class="field-hint">Defaults to today if blank.</span>
                    </div>
                    <!-- Amount -->
                    <div class="field">
                        <label class="field-label">Amount <span class="req">*</span></label>
                        <input type="number" id="fAmount" min="0.01" step="0.01" placeholder="0.00">
                        <span class="field-error" id="fAmountErr">Valid amount is required.</span>
                    </div>
                    <!-- Currency -->
                    <div class="field">
                        <label class="field-label">Currency</label>
                        <select id="fCurrency">
                            <option value="USD">USD — US Dollar</option>
                            <option value="EUR">EUR — Euro</option>
                            <option value="GBP">GBP — British Pound</option>
                            <option value="CAD">CAD — Canadian Dollar</option>
                            <option value="AUD">AUD — Australian Dollar</option>
                            <option value="JPY">JPY — Japanese Yen</option>
                            <option value="NGN">NGN — Nigerian Naira</option>
                            <option value="ZAR">ZAR — South African Rand</option>
                        </select>
                        <span class="field-hint">Defaults from Defaults &amp; Preferences.</span>
                    </div>
                    <!-- Source -->
                    <div class="field">
                        <label class="field-label">Payment Source <span class="req">*</span></label>
                        <select id="fSource">
                            <option value="">— Select source —</option>
                            <option value="check">Check</option>
                            <option value="wire">Wire Transfer</option>
                            <option value="cash">Cash</option>
                            <option value="debit">Debit Card</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="field-error" id="fSourceErr">Source is required.</span>
                    </div>
                    <!-- Status -->
                    <div class="field">
                        <label class="field-label">Status</label>
                        <select id="fStatus">
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <!-- Client -->
                    <div class="field">
                        <label class="field-label">Client</label>
                        <select id="fClient">
                            <option value="">— Unassigned —</option>
                            <option value="Acme Corp">Acme Corp</option>
                            <option value="Wavefront LLC">Wavefront LLC</option>
                            <option value="Nexus Media">Nexus Media</option>
                            <option value="Orinoco Labs">Orinoco Labs</option>
                            <option value="Stellar Brands">Stellar Brands</option>
                            <option value="Apex Digital">Apex Digital</option>
                            <option value="Blue River Co.">Blue River Co.</option>
                        </select>
                    </div>
                    <!-- Notes -->
                    <div class="field span2">
                        <label class="field-label">Notes</label>
                        <input type="text" id="fNotes" placeholder="Optional internal note…">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('paymentModal')">Cancel</button>
                <button class="btn btn-primary" id="payModalSaveBtn" onclick="savePayment()">Save Payment</button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════
     MODAL: Match Payment to Invoice
═══════════════════════════════════════════════════════════════ -->
    <div class="modal-overlay" id="matchModal" onclick="handleOverlayClick(event,'matchModal')">
        <div class="modal modal-wide">
            <div class="modal-header">
                <div>
                    <div class="modal-title">Match Payment to Invoice</div>
                    <div class="modal-subtitle" id="matchSubtitle">Select an invoice to apply this payment against
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('matchModal')">✕</button>
            </div>
            <div class="modal-body">
                <div class="match-search-wrap">
                    <span>🔍</span>
                    <input type="text" id="matchSearch" placeholder="Search by invoice #, client, or amount…"
                        oninput="filterInvoices(this.value)">
                </div>
                <div class="invoice-list" id="invoiceList"></div>
                <div class="match-summary" id="matchSummary"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('matchModal')">Cancel</button>
                <button class="btn btn-secondary" onclick="unmatchPayment()" id="btnUnmatch" style="display:none;">✕
                    Remove Match</button>
                <button class="btn btn-primary" id="btnApplyMatch" onclick="applyMatch()" disabled>Apply
                    Match</button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════
     MODAL: Auto-Match Confirm
═══════════════════════════════════════════════════════════════ -->
    <div class="modal-overlay" id="autoMatchModal" onclick="handleOverlayClick(event,'autoMatchModal')">
        <div class="modal" style="max-width:420px;">
            <div class="modal-header">
                <div>
                    <div class="modal-title">⚡ Auto-Match Payments</div>
                    <div class="modal-subtitle">Billflow will match payments to invoices automatically</div>
                </div>
                <button class="modal-close" onclick="closeModal('autoMatchModal')">✕</button>
            </div>
            <div class="modal-body">
                <p style="font-size:0.845rem;color:var(--muted);line-height:1.7;margin-bottom:16px;">
                    Auto-match scans all <strong style="color:var(--slate)">unmatched payments</strong> and attempts to
                    link each to an open invoice by comparing amount, client, and Stripe reference identifiers.
                </p>
                <div
                    style="background:var(--teal-pale);border:1.5px solid var(--teal);border-radius:var(--radius-sm);padding:12px 14px;font-size:0.82rem;color:var(--teal-dark);">
                    <strong>3 unmatched payments</strong> found. Billflow estimates it can auto-match <strong>2 of
                        3</strong> with high confidence. The remaining 1 will require manual review.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('autoMatchModal')">Cancel</button>
                <button class="btn btn-primary" onclick="runAutoMatch()">⚡ Run Auto-Match</button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════
     MODAL: View Payment Detail
═══════════════════════════════════════════════════════════════ -->
    <div class="modal-overlay" id="viewModal" onclick="handleOverlayClick(event,'viewModal')">
        <div class="modal">
            <div class="modal-header">
                <div>
                    <div class="modal-title" id="viewTitle">Payment Detail</div>
                    <div class="modal-subtitle" id="viewSubtitle"></div>
                </div>
                <button class="modal-close" onclick="closeModal('viewModal')">✕</button>
            </div>
            <div class="modal-body" id="viewBody"></div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('viewModal')">Close</button>
                <button class="btn btn-secondary" id="viewEditBtn" onclick="">✏️ Edit</button>
            </div>
        </div>
    </div>

    <!-- ─── TOAST STACK ────────────────────────────────────────── -->
    <div class="toast-stack" id="toastStack"></div>

    <script>
        // ──────────────────────────────────────────────────────────────
        // DATA
        // ──────────────────────────────────────────────────────────────
        let editingId = null;
        let matchingId = null;
        let selectedInvoiceId = null;
        let currentTab = 'all';
        let sortCol = 'date';
        let sortDir = 'desc';
        const PAGE_SIZE = 12;
        let currentPage = 1;

        const INVOICES = [{
                id: 'INV-0091',
                client: 'Acme Corp',
                total: 4200,
                balance: 4200,
                due: '2026-05-15',
                status: 'pending'
            },
            {
                id: 'INV-0092',
                client: 'Wavefront LLC',
                total: 1850,
                balance: 850,
                due: '2026-05-20',
                status: 'pending'
            },
            {
                id: 'INV-0093',
                client: 'Nexus Media',
                total: 3100,
                balance: 3100,
                due: '2026-05-10',
                status: 'overdue'
            },
            {
                id: 'INV-0094',
                client: 'Orinoco Labs',
                total: 2400,
                balance: 0,
                due: '2026-04-30',
                status: 'paid'
            },
            {
                id: 'INV-0095',
                client: 'Stellar Brands',
                total: 6750,
                balance: 6750,
                due: '2026-05-25',
                status: 'pending'
            },
            {
                id: 'INV-0096',
                client: 'Apex Digital',
                total: 980,
                balance: 980,
                due: '2026-05-18',
                status: 'pending'
            },
            {
                id: 'INV-0097',
                client: 'Blue River Co.',
                total: 5100,
                balance: 5100,
                due: '2026-05-30',
                status: 'pending'
            },
            {
                id: 'INV-0098',
                client: 'Acme Corp',
                total: 2200,
                balance: 2200,
                due: '2026-06-01',
                status: 'pending'
            },
        ];

        // Default currency sourced from Defaults & Preferences → Banking → Default Currency (ISO 4217)
        const DEFAULT_CURRENCY = 'USD';

        let payments = [{
                id: 1,
                ref: 'pi_3QxR4KLu9yBz1A2B',
                date: '2026-05-10',
                client: 'Acme Corp',
                source: 'stripe-card',
                amount: 4200.00,
                currency: 'USD',
                status: 'paid',
                match: 'matched',
                invoice: 'INV-0091',
                type: 'stripe',
                notes: ''
            },
            {
                id: 2,
                ref: 'pi_3QxU7NLu9yBz4C5D',
                date: '2026-05-09',
                client: 'Wavefront LLC',
                source: 'stripe-ach',
                amount: 1000.00,
                currency: 'USD',
                status: 'paid',
                match: 'partial',
                invoice: 'INV-0092',
                type: 'stripe',
                notes: 'Partial payment – balance $850'
            },
            {
                id: 3,
                ref: 'pi_3QxW1PLu9yBz8E9F',
                date: '2026-05-09',
                client: 'Nexus Media',
                source: 'stripe-card',
                amount: 3100.00,
                currency: 'USD',
                status: 'pending',
                match: 'unmatched',
                invoice: null,
                type: 'stripe',
                notes: ''
            },
            {
                id: 4,
                ref: 'CHK-00218',
                date: '2026-05-08',
                client: 'Stellar Brands',
                source: 'check',
                amount: 6750.00,
                currency: 'USD',
                status: 'paid',
                match: 'matched',
                invoice: 'INV-0095',
                type: 'manual',
                notes: 'Check deposited May 8'
            },
            {
                id: 5,
                ref: 'pi_3QxY3RLu9yBzABCD',
                date: '2026-05-07',
                client: 'Orinoco Labs',
                source: 'stripe-ach',
                amount: 2400.00,
                currency: 'USD',
                status: 'paid',
                match: 'matched',
                invoice: 'INV-0094',
                type: 'stripe',
                notes: ''
            },
            {
                id: 6,
                ref: 'WIRE-20260506',
                date: '2026-05-06',
                client: 'Apex Digital',
                source: 'wire',
                amount: 980.00,
                currency: 'EUR',
                status: 'paid',
                match: 'unmatched',
                invoice: null,
                type: 'manual',
                notes: 'Received via wire from Apex'
            },
            {
                id: 7,
                ref: 'pi_3QxA5TLu9yBzEFGH',
                date: '2026-05-05',
                client: 'Blue River Co.',
                source: 'stripe-card',
                amount: 5100.00,
                currency: 'USD',
                status: 'failed',
                match: 'unmatched',
                invoice: null,
                type: 'stripe',
                notes: 'Card declined – customer notified'
            },
            {
                id: 8,
                ref: 'CHK-00217',
                date: '2026-05-04',
                client: 'Acme Corp',
                source: 'check',
                amount: 2200.00,
                currency: 'USD',
                status: 'paid',
                match: 'matched',
                invoice: 'INV-0098',
                type: 'manual',
                notes: ''
            },
            {
                id: 9,
                ref: 'pi_3QxB6ULu9yBzIJKL',
                date: '2026-05-03',
                client: 'Nexus Media',
                source: 'stripe-card',
                amount: 3100.00,
                currency: 'USD',
                status: 'paid',
                match: 'matched',
                invoice: 'INV-0093',
                type: 'stripe',
                notes: ''
            },
            {
                id: 10,
                ref: 'CASH-20260502',
                date: '2026-05-02',
                client: 'Wavefront LLC',
                source: 'cash',
                amount: 850.00,
                currency: 'USD',
                status: 'paid',
                match: 'matched',
                invoice: 'INV-0092',
                type: 'manual',
                notes: 'Cash payment at office'
            },
            {
                id: 11,
                ref: 'pi_3QxC7VLu9yBzMNOP',
                date: '2026-04-30',
                client: 'Stellar Brands',
                source: 'stripe-ach',
                amount: 1200.00,
                currency: 'GBP',
                status: 'refunded',
                match: 'matched',
                invoice: 'INV-0095',
                type: 'stripe',
                notes: 'Refunded – duplicate charge'
            },
            {
                id: 12,
                ref: 'pi_3QxD8WLu9yBzQRST',
                date: '2026-04-28',
                client: 'Orinoco Labs',
                source: 'stripe-card',
                amount: 4500.00,
                currency: 'USD',
                status: 'paid',
                match: 'matched',
                invoice: 'INV-0094',
                type: 'stripe',
                notes: ''
            },
            {
                id: 13,
                ref: 'DBT-20260511',
                date: '2026-05-11',
                client: 'Apex Digital',
                source: 'debit',
                amount: 980.00,
                currency: 'USD',
                status: 'paid',
                match: 'unmatched',
                invoice: null,
                type: 'manual',
                notes: 'Debit card payment at counter'
            },
        ];

        let nextId = 14;

        // ──────────────────────────────────────────────────────────────
        // RENDER TABLE
        // ──────────────────────────────────────────────────────────────
        function getFiltered() {
            const tab = currentTab;
            const status = document.getElementById('statusFilter').value;
            const src = document.getElementById('sourceFilter').value;
            const q = document.getElementById('tableSearch').value.toLowerCase();

            return payments.filter(p => {
                if (tab === 'stripe' && p.type !== 'stripe') return false;
                if (tab === 'manual' && p.type !== 'manual') return false;
                if (tab === 'unmatched' && p.match !== 'unmatched') return false;
                if (status && p.status !== status) return false;
                if (src && p.source !== src) return false;
                if (q && !`${p.ref} ${p.client} ${p.invoice||''} ${p.amount}`.toLowerCase().includes(q))
                    return false;
                return true;
            });
        }

        function sorted(arr) {
            return [...arr].sort((a, b) => {
                let va = a[sortCol] ?? '',
                    vb = b[sortCol] ?? '';
                if (sortCol === 'amount') {
                    va = +va;
                    vb = +vb;
                }
                if (va < vb) return sortDir === 'asc' ? -1 : 1;
                if (va > vb) return sortDir === 'asc' ? 1 : -1;
                return 0;
            });
        }

        function sourceLabel(src) {
            const labels = {
                'stripe-card': 'Credit Card',
                'stripe-ach': 'ACH / Bank',
                'check': 'Check',
                'wire': 'Wire Transfer',
                'cash': 'Cash',
                'debit': 'Debit Card',
                'other': 'Other'
            };
            return labels[src] || src;
        }

        function sourcePill(p) {
            if (p.type === 'stripe') return `<span class="source-pill stripe">${sourceLabel(p.source)}</span>`;
            return `<span class="source-pill manual">${sourceLabel(p.source)}</span>`;
        }

        function statusBadge(s) {
            const map = {
                paid: 'badge-paid',
                pending: 'badge-pending',
                failed: 'badge-failed',
                refunded: 'badge-refunded'
            };
            const lbl = {
                paid: 'Paid',
                pending: 'Pending',
                failed: 'Failed',
                refunded: 'Refunded'
            };
            return `<span class="badge ${map[s]||''}">${lbl[s]||s}</span>`;
        }

        function matchBadge(m) {
            const map = {
                matched: 'badge-matched',
                unmatched: 'badge-unmatched',
                partial: 'badge-partial'
            };
            const lbl = {
                matched: 'Matched',
                unmatched: 'Unmatched',
                partial: 'Partial'
            };
            return `<span class="badge ${map[m]||''}">${lbl[m]||m}</span>`;
        }

        function renderTable() {
            const filtered = getFiltered();
            const data = sorted(filtered);
            const total = data.length;
            const start = (currentPage - 1) * PAGE_SIZE;
            const page = data.slice(start, start + PAGE_SIZE);

            const tbody = document.getElementById('tableBody');
            const empty = document.getElementById('emptyState');

            if (!page.length) {
                tbody.innerHTML = '';
                empty.style.display = '';
            } else {
                empty.style.display = 'none';
                tbody.innerHTML = page.map(p => `
      <tr style="cursor:pointer;" onclick="viewPayment(${p.id})">
        <td onclick="event.stopPropagation()"><input type="checkbox" class="row-check" value="${p.id}" style="cursor:pointer;"></td>
        <td><span class="ref-code">${p.ref}</span></td>
        <td>${fmtDate(p.date)}</td>
        <td>${p.client}</td>
        <td>${sourcePill(p)}</td>
        <td><span class="amount-cell">${p.status==='refunded'?'−':''}${(+p.amount).toLocaleString('en-US',{minimumFractionDigits:2})}</span></td>
        <td><span class="curr-code">${p.currency||DEFAULT_CURRENCY}</span></td>
        <td>${statusBadge(p.status)}</td>
        <td>${matchBadge(p.match)}</td>
        <td>${p.invoice
          ? `<a href="{{ route('subscriber.invoices') }}" class="inv-link" onclick="event.stopPropagation()">${p.invoice}</a>`
          : `<span class="no-inv">—</span>`
        }</td>
        <td onclick="event.stopPropagation()">
          <div class="row-actions">
            ${p.type==='manual'
              ? `<button class="row-btn" title="Edit" onclick="openEditPayment(${p.id})">✏️</button>`
              : `<button class="row-btn" title="View in Stripe" onclick="showToast('info','Opening Stripe dashboard…')">🔗</button>`
            }
            <button class="row-btn" title="Match to Invoice" onclick="openMatch(${p.id})">🔗</button>
            ${p.type==='manual'
              ? `<button class="row-btn danger" title="Delete" onclick="deletePayment(${p.id})">🗑</button>`
              : ''
            }
          </div>
        </td>
      </tr>
    `).join('');
            }

            document.getElementById('tableInfo').textContent =
                total ? `Showing ${start+1}–${Math.min(start+PAGE_SIZE, total)} of ${total} payment${total!==1?'s':''}` :
                '0 payments';

            renderPagination(total);
            updateCounts();
            updateKpiUnmatched();
        }

        function renderPagination(total) {
            const pages = Math.ceil(total / PAGE_SIZE);
            const pag = document.getElementById('pagination');
            if (pages <= 1) {
                pag.innerHTML = '';
                return;
            }
            let html =
                `<button class="pag-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}>‹</button>`;
            for (let i = 1; i <= pages; i++)
                html += `<button class="pag-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
            html +=
                `<button class="pag-btn" onclick="goPage(${currentPage+1})" ${currentPage===pages?'disabled':''}>›</button>`;
            pag.innerHTML = html;
        }

        function goPage(n) {
            const total = getFiltered().length;
            const pages = Math.ceil(total / PAGE_SIZE);
            if (n < 1 || n > pages) return;
            currentPage = n;
            renderTable();
        }

        function updateCounts() {
            const all = payments.length;
            const stripe = payments.filter(p => p.type === 'stripe').length;
            const manual = payments.filter(p => p.type === 'manual').length;
            const unmatched = payments.filter(p => p.match === 'unmatched').length;
            document.getElementById('cntAll').textContent = all;
            document.getElementById('cntStripe').textContent = stripe;
            document.getElementById('cntManual').textContent = manual;
            document.getElementById('cntUnmatched').textContent = unmatched;
        }

        function updateKpiUnmatched() {
            document.getElementById('kpiUnmatched').textContent =
                payments.filter(p => p.match === 'unmatched').length;
        }

        function switchTab(tab, btn) {
            currentTab = tab;
            currentPage = 1;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            renderTable();
        }

        function applyFilters() {
            currentPage = 1;
            renderTable();
        }

        function sortTable(col) {
            if (sortCol === col) sortDir = sortDir === 'asc' ? 'desc' : 'asc';
            else {
                sortCol = col;
                sortDir = 'asc';
            }
            document.querySelectorAll('thead th').forEach(th => {
                th.classList.remove('sort-asc', 'sort-desc');
                if (th.dataset.col === col) th.classList.add(sortDir === 'asc' ? 'sort-asc' : 'sort-desc');
            });
            renderTable();
        }

        function globalSearch(q) {
            document.getElementById('tableSearch').value = q;
            applyFilters();
        }

        function toggleAll(cb) {
            document.querySelectorAll('.row-check').forEach(c => c.checked = cb.checked);
        }

        function fmtDate(d) {
            const dt = new Date(d + 'T00:00:00');
            return dt.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }

        // ──────────────────────────────────────────────────────────────
        // ADD / EDIT PAYMENT MODAL
        // ──────────────────────────────────────────────────────────────
        function openAddPayment() {
            editingId = null;
            document.getElementById('payModalTitle').textContent = 'Add Manual Payment';
            clearPayForm();
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('fPayDate').value = today;
            document.getElementById('fAppliedDate').value = today;
            document.getElementById('fCurrency').value = DEFAULT_CURRENCY;
            document.getElementById('payModalSaveBtn').textContent = 'Save Payment';
            openModal('paymentModal');
        }

        function openEditPayment(id) {
            const p = payments.find(x => x.id === id);
            if (!p || p.type !== 'manual') return;
            editingId = id;
            document.getElementById('payModalTitle').textContent = `Edit Payment — ${p.ref}`;
            document.getElementById('fRef').value = p.ref;
            document.getElementById('fPayDate').value = p.date;
            document.getElementById('fAppliedDate').value = p.date;
            document.getElementById('fAmount').value = p.amount;
            document.getElementById('fCurrency').value = p.currency || DEFAULT_CURRENCY;
            document.getElementById('fSource').value = p.source;
            document.getElementById('fStatus').value = p.status;
            document.getElementById('fClient').value = p.client;
            document.getElementById('fNotes').value = p.notes || '';
            document.getElementById('payModalSaveBtn').textContent = 'Update Payment';
            openModal('paymentModal');
        }

        function clearPayForm() {
            ['fRef', 'fPayDate', 'fAppliedDate', 'fAmount', 'fNotes'].forEach(id => {
                document.getElementById(id).value = '';
                document.getElementById(id).classList.remove('error');
            });
            document.getElementById('fSource').value = '';
            document.getElementById('fStatus').value = 'paid';
            document.getElementById('fCurrency').value = DEFAULT_CURRENCY;
            document.getElementById('fClient').value = '';
            document.querySelectorAll('.field-error').forEach(e => e.classList.remove('show'));
        }

        function savePayment() {
            const ref = document.getElementById('fRef').value.trim();
            const date = document.getElementById('fPayDate').value;
            const amount = parseFloat(document.getElementById('fAmount').value);
            const currency = document.getElementById('fCurrency').value || DEFAULT_CURRENCY;
            const source = document.getElementById('fSource').value;
            const status = document.getElementById('fStatus').value;
            const client = document.getElementById('fClient').value;
            const notes = document.getElementById('fNotes').value.trim();
            let ok = true;

            function err(fId, eId, show) {
                document.getElementById(fId).classList.toggle('error', show);
                document.getElementById(eId).classList.toggle('show', show);
                if (show) ok = false;
            }
            err('fRef', 'fRefErr', !ref);
            err('fPayDate', 'fPayDateErr', !date);
            err('fAmount', 'fAmountErr', isNaN(amount) || amount <= 0);
            err('fSource', 'fSourceErr', !source);
            if (!ok) return;

            if (editingId) {
                const p = payments.find(x => x.id === editingId);
                Object.assign(p, {
                    ref,
                    date,
                    amount,
                    currency,
                    source,
                    status,
                    client,
                    notes
                });
                showToast('success', '✅ Payment updated.');
            } else {
                payments.unshift({
                    id: nextId++,
                    ref,
                    date,
                    client,
                    source,
                    amount,
                    currency,
                    status,
                    match: 'unmatched',
                    invoice: null,
                    type: 'manual',
                    notes
                });
                showToast('success', '✅ Manual payment added.');
            }
            closeModal('paymentModal');
            renderTable();
        }

        // ──────────────────────────────────────────────────────────────
        // MATCH MODAL
        // ──────────────────────────────────────────────────────────────
        function openMatch(id) {
            matchingId = id;
            selectedInvoiceId = null;
            const p = payments.find(x => x.id === id);
            document.getElementById('matchSubtitle').textContent =
                `Payment ${p.ref}  ·  $${(+p.amount).toLocaleString('en-US',{minimumFractionDigits:2})}  ·  ${p.client||'Unknown client'}`;
            document.getElementById('matchSearch').value = '';
            document.getElementById('btnApplyMatch').disabled = true;
            document.getElementById('btnUnmatch').style.display = p.invoice ? '' : 'none';
            document.getElementById('matchSummary').classList.remove('show');
            renderInvoiceList('');
            openModal('matchModal');
        }

        function renderInvoiceList(q) {
            const p = matchingId ? payments.find(x => x.id === matchingId) : null;
            const list = INVOICES.filter(inv => {
                if (inv.status === 'paid' && inv.id !== (p && p.invoice)) return false;
                if (!q) return true;
                return `${inv.id} ${inv.client} ${inv.total}`.toLowerCase().includes(q.toLowerCase());
            });

            document.getElementById('invoiceList').innerHTML = list.map(inv => {
                    const sel = selectedInvoiceId === inv.id;
                    const curr = p && p.invoice === inv.id;
                    const statusMap = {
                        pending: 'badge-pending',
                        overdue: 'badge-failed',
                        paid: 'badge-paid'
                    };
                    const statusLbl = {
                        pending: 'Pending',
                        overdue: 'Overdue',
                        paid: 'Paid'
                    };
                    return `
      <div class="invoice-row ${sel?'selected':''}" onclick="selectInvoice('${inv.id}',${inv.balance},${inv.total})">
        <div class="inv-radio"></div>
        <div class="inv-info">
          <div class="inv-num">${inv.id} ${curr?'<span style="font-size:0.7rem;font-weight:500;color:var(--teal);">· Currently matched</span>':''}</div>
          <div class="inv-client">${inv.client}</div>
        </div>
        <div class="inv-status-col"><span class="badge ${statusMap[inv.status]}">${statusLbl[inv.status]}</span></div>
        <div class="inv-amount-col">
          <div class="inv-total">$${inv.total.toLocaleString('en-US',{minimumFractionDigits:2})}</div>
          <div class="inv-due">Due ${fmtDate(inv.due)}</div>
        </div>
      </div>
    `;
                }).join('') ||
                '<div style="padding:24px;text-align:center;color:var(--muted);font-size:0.82rem;">No open invoices found.</div>';
        }

        function selectInvoice(invId, balance, total) {
            selectedInvoiceId = invId;
            document.getElementById('btnApplyMatch').disabled = false;
            renderInvoiceList(document.getElementById('matchSearch').value);

            const p = payments.find(x => x.id === matchingId);
            const amt = +p.amount;
            let msg = '';
            if (amt >= total) {
                msg =
                    `Payment of <strong>$${amt.toLocaleString('en-US',{minimumFractionDigits:2})}</strong> fully covers invoice total of <strong>$${total.toLocaleString('en-US',{minimumFractionDigits:2})}</strong>. Invoice will be marked <strong>Paid</strong>.`;
            } else {
                const rem = (total - amt).toFixed(2);
                msg =
                    `Payment of <strong>$${amt.toLocaleString('en-US',{minimumFractionDigits:2})}</strong> is a <strong>partial payment</strong>. Remaining balance: <strong>$${(+rem).toLocaleString('en-US',{minimumFractionDigits:2})}</strong>.`;
            }
            const sum = document.getElementById('matchSummary');
            sum.innerHTML = msg;
            sum.classList.add('show');
        }

        function filterInvoices(q) {
            renderInvoiceList(q);
        }

        function applyMatch() {
            if (!matchingId || !selectedInvoiceId) return;
            const p = payments.find(x => x.id === matchingId);
            const inv = INVOICES.find(x => x.id === selectedInvoiceId);
            p.invoice = selectedInvoiceId;
            p.match = (+p.amount >= inv.total) ? 'matched' : 'partial';
            p.client = p.client || inv.client;
            showToast('success', `✅ Payment matched to ${selectedInvoiceId}.`);
            closeModal('matchModal');
            renderTable();
        }

        function unmatchPayment() {
            const p = payments.find(x => x.id === matchingId);
            if (!p) return;
            p.invoice = null;
            p.match = 'unmatched';
            showToast('info', `ℹ️ Match removed from payment ${p.ref}.`);
            closeModal('matchModal');
            renderTable();
        }

        // ──────────────────────────────────────────────────────────────
        // AUTO-MATCH
        // ──────────────────────────────────────────────────────────────
        function openAutoMatch() {
            openModal('autoMatchModal');
        }

        function runAutoMatch() {
            let matched = 0;
            payments.forEach(p => {
                if (p.match !== 'unmatched') return;
                const inv = INVOICES.find(i =>
                    i.status !== 'paid' &&
                    i.client === p.client &&
                    (+p.amount === i.total || +p.amount === i.balance)
                );
                if (inv) {
                    p.invoice = inv.id;
                    p.match = +p.amount >= inv.total ? 'matched' : 'partial';
                    matched++;
                }
            });
            closeModal('autoMatchModal');
            renderTable();
            if (matched > 0) showToast('success', `⚡ Auto-matched ${matched} payment${matched!==1?'s':''} to invoices.`);
            else showToast('info', `ℹ️ No new matches found.`);
        }

        // ──────────────────────────────────────────────────────────────
        // VIEW DETAIL MODAL
        // ──────────────────────────────────────────────────────────────
        function viewPayment(id) {
            const p = payments.find(x => x.id === id);
            if (!p) return;
            document.getElementById('viewTitle').textContent = `Payment — ${p.ref}`;
            document.getElementById('viewSubtitle').textContent = `${fmtDate(p.date)} · ${p.client}`;
            document.getElementById('viewEditBtn').onclick = () => {
                closeModal('viewModal');
                if (p.type === 'manual') openEditPayment(id);
            };
            document.getElementById('viewEditBtn').style.display = p.type === 'manual' ? '' : 'none';

            const rows = [
                ['Reference', p.ref],
                ['Pay Date', fmtDate(p.date)],
                ['Client', p.client || '—'],
                ['Source', sourceLabel(p.source)],
                ['Amount',
                    `${p.status==='refunded'?'−':''}${(+p.amount).toLocaleString('en-US',{minimumFractionDigits:2})}`
                ],
                ['Currency', `<span class="curr-code">${p.currency||DEFAULT_CURRENCY}</span>`],
                ['Status', statusBadge(p.status)],
                ['Match Status', matchBadge(p.match)],
                ['Invoice', p.invoice ? `<a href="{{ route('subscriber.invoices') }}" class="inv-link">${p.invoice}</a>` : '—'],
                ['Type', p.type === 'stripe' ? '<span class="source-pill stripe">Stripe</span>' :
                    '<span class="source-pill manual">Manual</span>'
                ],
                ['Notes', p.notes || '—'],
            ];
            document.getElementById('viewBody').innerHTML = `
    <table style="width:100%;border-collapse:collapse;">
      ${rows.map(([k,v])=>`
                <tr>
                  <td style="padding:9px 0;font-size:0.78rem;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:0.05em;width:130px;vertical-align:top;">${k}</td>
                  <td style="padding:9px 0;font-size:0.845rem;color:var(--slate);">${v}</td>
                </tr>
              `).join('')}
    </table>
  `;
            openModal('viewModal');
        }

        // ──────────────────────────────────────────────────────────────
        // DELETE
        // ──────────────────────────────────────────────────────────────
        function deletePayment(id) {
            const p = payments.find(x => x.id === id);
            if (!p || p.type !== 'manual') return;
            if (!confirm(`Delete payment ${p.ref}? This cannot be undone.`)) return;
            payments = payments.filter(x => x.id !== id);
            showToast('info', '🗑 Payment deleted.');
            renderTable();
        }

        // ──────────────────────────────────────────────────────────────
        // MODAL HELPERS
        // ──────────────────────────────────────────────────────────────
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        function handleOverlayClick(e, id) {
            if (e.target === e.currentTarget) closeModal(id);
        }

        // ──────────────────────────────────────────────────────────────
        // TOAST
        // ──────────────────────────────────────────────────────────────
        function showToast(type, msg) {
            const el = document.createElement('div');
            el.className = `toast ${type}`;
            el.innerHTML =
                `<span class="toast-icon">${type==='success'?'✅':type==='error'?'❌':'ℹ️'}</span><span>${msg}</span>`;
            document.getElementById('toastStack').appendChild(el);
            setTimeout(() => el.remove(), 3500);
        }

        // ──────────────────────────────────────────────────────────────
        // SIDEBAR (mobile)
        // ──────────────────────────────────────────────────────────────
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('overlay').style.display = 'none';
        }

        // ──────────────────────────────────────────────────────────────
        // INIT
        // ──────────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            // default sort indicator
            const th = document.querySelector(`thead th[data-col="date"]`);
            if (th) th.classList.add('sort-desc');
            renderTable();
        });
    </script>
</body>

</html>
