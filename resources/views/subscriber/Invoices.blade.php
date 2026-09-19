<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Billflow — Invoices</title>
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
            --blue-pale: #eff6ff;
            --muted: #6b7280;
            --border: #ddd8cc;
            --border-dark: rgba(255, 255, 255, 0.08);
            --card: #ffffff;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.10);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.15);
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
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR ─────────────────────────────────────────── */
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

        .user-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: #fff;
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

        .nav-badge {
            font-size: 0.68rem;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 99px;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        .nav-badge.alert {
            background: rgba(240, 84, 84, 0.2);
            color: var(--red-soft);
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

        /* ─── SHELL ───────────────────────────────────────────── */
        .shell {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── TOPBAR ──────────────────────────────────────────── */
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
            gap: 12px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: var(--muted);
        }

        .breadcrumb a {
            color: var(--muted);
            text-decoration: none;
            transition: color .15s;
        }

        .breadcrumb a:hover {
            color: var(--teal);
        }

        .breadcrumb-sep {
            color: var(--border);
        }

        .breadcrumb-current {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--slate);
            letter-spacing: -0.02em;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ─── BUTTONS ─────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            border: none;
            text-decoration: none;
        }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1.5px solid var(--border);
        }

        .btn-ghost:hover {
            background: var(--cream);
            color: var(--ink);
            border-color: #ccc8bc;
        }

        .btn-outline {
            background: transparent;
            color: var(--slate);
            border: 1.5px solid var(--border);
        }

        .btn-outline:hover {
            background: var(--cream);
            border-color: #ccc8bc;
        }

        .btn-primary {
            background: var(--teal);
            color: #fff;
            border: 1.5px solid var(--teal);
        }

        .btn-primary:hover {
            background: var(--teal-dark);
            border-color: var(--teal-dark);
        }

        .btn-amber {
            background: var(--amber);
            color: var(--slate);
            border: 1.5px solid var(--amber);
            font-weight: 700;
        }

        .btn-amber:hover {
            background: #e8991a;
            border-color: #e8991a;
        }

        /* ─── MAIN ────────────────────────────────────────────── */
        .main {
            flex: 1;
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ─── PAGE HEADER ─────────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--slate);
            letter-spacing: -0.04em;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 0.85rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .page-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        /* ─── STATS ROW ───────────────────────────────────────── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            padding: 20px 22px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            cursor: pointer;
            transition: box-shadow .2s, transform .15s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .stat-card.active {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.12), var(--shadow-sm);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .stat-card.all::before {
            background: var(--slate);
        }

        .stat-card.overdue::before {
            background: var(--red-soft);
        }

        .stat-card.pending::before {
            background: var(--amber);
        }

        .stat-card.paid::before {
            background: var(--teal);
        }

        .stat-label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .stat-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .stat-amount {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--slate);
            letter-spacing: -0.03em;
        }

        .stat-meta {
            font-size: 0.75rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stat-count {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 99px;
            background: var(--paper);
            color: var(--muted);
        }

        /* ─── FILTERS ROW ─────────────────────────────────────── */
        .filters-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .filters-left {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filters-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 0;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            transition: border-color .2s, box-shadow .2s;
            min-width: 280px;
        }

        .search-bar:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.12);
        }

        .search-icon {
            padding: 0 10px 0 13px;
            color: var(--muted);
            font-size: 0.85rem;
        }

        .search-input {
            border: none !important;
            background: transparent !important;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            color: var(--ink);
            padding: 9px 12px 9px 0;
            flex: 1;
            min-width: 0;
            box-shadow: none !important;
        }

        .search-input::placeholder {
            color: var(--muted);
        }

        .filter-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 13px;
            border-radius: 99px;
            border: 1.5px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            transition: all .15s;
        }

        .filter-chip:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        .filter-chip.active {
            border-color: var(--teal);
            color: var(--teal);
            background: var(--teal-pale);
        }

        .filter-chip .chip-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .sort-select {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--muted);
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 8px 32px 8px 12px;
            cursor: pointer;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath fill='%236b7280' d='M5 7L0 0h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
        }

        .sort-select:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.12);
        }

        .view-toggle {
            display: flex;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .view-btn {
            padding: 7px 11px;
            cursor: pointer;
            background: transparent;
            border: none;
            color: var(--muted);
            font-size: 0.9rem;
            transition: all .15s;
        }

        .view-btn.active {
            background: var(--slate);
            color: #fff;
        }

        .view-btn:hover:not(.active) {
            background: var(--cream);
        }

        /* ─── TABLE ───────────────────────────────────────────── */
        .table-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-header-row {
            display: grid;
            grid-template-columns: 24px 140px 1fr 160px 130px 120px 110px 100px;
            gap: 12px;
            align-items: center;
            padding: 13px 20px;
            background: var(--paper);
            border-bottom: 1.5px solid var(--border);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .th-sort {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            user-select: none;
        }

        .th-sort:hover {
            color: var(--slate);
        }

        .th-sort.sorted {
            color: var(--teal);
        }

        .sort-icon {
            font-size: 0.6rem;
        }

        .table-row {
            display: grid;
            grid-template-columns: 24px 140px 1fr 160px 130px 120px 110px 100px;
            gap: 12px;
            align-items: center;
            padding: 14px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            cursor: pointer;
            transition: background .12s;
            animation: rowIn .25s ease both;
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .table-row:hover {
            background: var(--paper);
        }

        .table-row:hover .row-actions {
            opacity: 1;
        }

        @keyframes rowIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .row-check {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid var(--border);
            background: transparent;
            cursor: pointer;
            flex-shrink: 0;
            appearance: none;
        }

        .row-check:checked {
            background: var(--teal);
            border-color: var(--teal);
        }

        .row-check:checked::after {
            content: '✓';
            display: block;
            text-align: center;
            font-size: 0.6rem;
            color: #fff;
            line-height: 1.1;
        }

        .inv-num {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.82rem;
            color: var(--slate);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .inv-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--teal-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            flex-shrink: 0;
        }

        .client-cell {
            display: flex;
            align-items: center;
            gap: 9px;
            min-width: 0;
        }

        .client-avatar-sm {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: #fff;
        }

        .client-info {
            min-width: 0;
        }

        .client-name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .client-id {
            font-size: 0.72rem;
            color: var(--muted);
        }

        .project-cell {
            font-size: 0.82rem;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .date-cell {
            font-size: 0.82rem;
            color: var(--muted);
        }

        .date-cell.overdue {
            color: var(--red-soft);
            font-weight: 600;
        }

        .amount-cell {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--ink);
            text-align: right;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: capitalize;
            white-space: nowrap;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .badge-draft {
            background: rgba(107, 114, 128, 0.12);
            color: var(--muted);
        }

        .badge-draft .badge-dot {
            background: var(--muted);
        }

        .badge-sent {
            background: var(--blue-pale);
            color: var(--blue);
        }

        .badge-sent .badge-dot {
            background: var(--blue);
        }

        .badge-paid {
            background: var(--teal-pale);
            color: var(--teal-dark);
        }

        .badge-paid .badge-dot {
            background: var(--teal);
        }

        .badge-overdue {
            background: var(--red-pale);
            color: var(--red-soft);
        }

        .badge-overdue .badge-dot {
            background: var(--red-soft);
        }

        .row-actions {
            display: flex;
            align-items: center;
            gap: 4px;
            justify-content: flex-end;
            opacity: 0;
            transition: opacity .15s;
        }

        .action-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: transparent;
            cursor: pointer;
            color: var(--muted);
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .action-btn:hover {
            background: var(--paper);
            color: var(--ink);
            border-color: #ccc8bc;
        }

        .action-btn.danger:hover {
            background: var(--red-pale);
            border-color: var(--red-soft);
            color: var(--red-soft);
        }

        /* ─── CLIENT DRILL-DOWN PANEL ─────────────────────────── */
        .drilldown-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 100;
            background: rgba(13, 13, 13, 0.35);
            backdrop-filter: blur(4px);
        }

        .drilldown-backdrop.open {
            display: block;
        }

        .drilldown-panel {
            position: fixed;
            top: 0;
            right: -520px;
            bottom: 0;
            width: 520px;
            background: var(--card);
            border-left: 1px solid var(--border);
            box-shadow: -8px 0 40px rgba(0, 0, 0, 0.12);
            z-index: 101;
            display: flex;
            flex-direction: column;
            transition: right .3s cubic-bezier(.4, 0, .2, 1);
            overflow: hidden;
        }

        .drilldown-panel.open {
            right: 0;
        }

        .drilldown-header {
            padding: 24px 28px 20px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .drilldown-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .drilldown-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            background: transparent;
            cursor: pointer;
            color: var(--muted);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .drilldown-close:hover {
            background: var(--paper);
            color: var(--ink);
        }

        .client-profile {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .client-avatar-lg {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
        }

        .client-profile-info .name {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--slate);
            letter-spacing: -0.02em;
        }

        .client-profile-info .email {
            font-size: 0.8rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .client-profile-info .tags {
            display: flex;
            gap: 6px;
            margin-top: 6px;
            flex-wrap: wrap;
        }

        .client-tag {
            font-size: 0.68rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 99px;
            background: var(--paper);
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .client-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 16px;
        }

        .client-stat {
            background: var(--paper);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            text-align: center;
        }

        .client-stat .cstat-val {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--slate);
        }

        .client-stat .cstat-label {
            font-size: 0.68rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .drilldown-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 28px;
        }

        .drilldown-section-label {
            font-family: 'Syne', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 12px;
            margin-top: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .drilldown-section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .drilldown-section-label:first-child {
            margin-top: 0;
        }

        .dd-inv-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            margin-bottom: 8px;
            cursor: pointer;
            transition: all .15s;
            background: var(--card);
        }

        .dd-inv-row:hover {
            border-color: var(--teal);
            background: var(--paper);
            box-shadow: 0 2px 8px rgba(0, 184, 153, 0.08);
        }

        .dd-inv-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: var(--teal-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .dd-inv-main {
            flex: 1;
            min-width: 0;
        }

        .dd-inv-num {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.82rem;
            color: var(--slate);
        }

        .dd-inv-proj {
            font-size: 0.75rem;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .dd-inv-right {
            text-align: right;
            flex-shrink: 0;
        }

        .dd-inv-amount {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--ink);
        }

        .dd-inv-date {
            font-size: 0.72rem;
            color: var(--muted);
            margin-top: 1px;
        }

        .drilldown-footer {
            padding: 16px 28px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        .drilldown-footer .btn {
            flex: 1;
            justify-content: center;
        }

        /* ─── EMPTY STATE ─────────────────────────────────────── */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 72px 32px;
            text-align: center;
            gap: 12px;
        }

        .empty-icon {
            font-size: 2.5rem;
            opacity: 0.4;
        }

        .empty-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--slate);
        }

        .empty-sub {
            font-size: 0.85rem;
            color: var(--muted);
            max-width: 320px;
        }

        /* ─── TABLE FOOTER ────────────────────────────────────── */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: var(--paper);
            font-size: 0.8rem;
            color: var(--muted);
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-btn {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1.5px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-size: 0.8rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
            font-family: 'DM Sans', sans-serif;
        }

        .page-btn:hover {
            background: var(--cream);
            color: var(--ink);
        }

        .page-btn.active {
            background: var(--slate);
            color: #fff;
            border-color: var(--slate);
        }

        /* ─── BULK BAR ────────────────────────────────────────── */
        .bulk-bar {
            display: none;
            position: fixed;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--slate);
            border-radius: var(--radius);
            padding: 14px 20px;
            box-shadow: var(--shadow-lg);
            z-index: 90;
            align-items: center;
            gap: 16px;
            min-width: 440px;
            animation: bulkIn .2s ease;
        }

        .bulk-bar.visible {
            display: flex;
        }

        @keyframes bulkIn {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        .bulk-count {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            color: #fff;
            font-size: 0.85rem;
        }

        .bulk-actions {
            display: flex;
            gap: 8px;
            margin-left: auto;
        }

        .bulk-btn {
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.8);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
        }

        .bulk-btn:hover {
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
        }

        .bulk-btn.danger {
            border-color: rgba(240, 84, 84, 0.4);
            color: rgba(240, 84, 84, 0.9);
        }

        .bulk-btn.danger:hover {
            background: rgba(240, 84, 84, 0.12);
        }

        .bulk-close {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            background: transparent;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: all .15s;
        }

        .bulk-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        /* ─── SEARCH OVERLAY ──────────────────────────────────── */
        .search-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 200;
            background: rgba(13, 13, 13, 0.45);
            backdrop-filter: blur(4px);
            align-items: flex-start;
            justify-content: center;
            padding-top: 80px;
        }

        .search-overlay.open {
            display: flex;
        }

        .search-modal {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-lg);
            width: 680px;
            max-width: calc(100vw - 40px);
            max-height: calc(100vh - 140px);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: modalIn .18s ease;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .search-modal-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .search-modal-icon {
            color: var(--muted);
            font-size: 1rem;
        }

        .search-modal-input {
            flex: 1;
            border: none !important;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            color: var(--ink);
            background: transparent !important;
            box-shadow: none !important;
            padding: 0;
        }

        .search-modal-input::placeholder {
            color: var(--muted);
        }

        .search-modal-close {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: transparent;
            cursor: pointer;
            color: var(--muted);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .search-modal-close:hover {
            background: var(--paper);
            color: var(--ink);
        }

        .search-results-body {
            overflow-y: auto;
            flex: 1;
            padding: 12px 0;
        }

        .search-quick-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background .12s;
            font-size: 0.85rem;
        }

        .search-quick-item:hover {
            background: var(--paper);
        }

        .sq-icon {
            font-size: 0.9rem;
            width: 24px;
            text-align: center;
        }

        .sq-label {
            flex: 1;
            font-weight: 500;
            color: var(--ink);
        }

        .sq-meta {
            font-size: 0.75rem;
            color: var(--muted);
        }

        /* ─── TOPBAR SEARCH BAR ───────────────────────────────── */
        .inv-search-wrap {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: visible;
            transition: border-color .2s, box-shadow .2s;
            min-width: 380px;
            flex: 1;
            cursor: pointer;
        }

        .inv-search-wrap:hover {
            border-color: #ccc8bc;
        }

        .inv-search-icon {
            padding: 0 10px 0 14px;
            color: var(--muted);
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .inv-search-input {
            border: none !important;
            background: transparent !important;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            color: var(--ink);
            padding: 9px 0;
            flex: 1;
            min-width: 0;
            box-shadow: none !important;
            cursor: pointer;
        }

        .inv-search-input::placeholder {
            color: var(--muted);
        }

        .inv-search-kbd {
            padding: 0 12px;
            font-size: 0.65rem;
            color: var(--muted);
            flex-shrink: 0;
        }

        .inv-search-kbd kbd {
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 2px 5px;
            font-family: inherit;
        }


        /* Dashboard header/sidebar standardization */
        :root {
            --sidebar-w: 260px;
            --topbar-h: 64px;
        }

        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

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

        .nav-count {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 99px;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
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
            font-size: 0.68rem;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 99px;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        .nav-badge.red {
            background: var(--red-soft);
            color: #fff;
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

        .shell {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        body.dashboard-sidebar-collapsed .sidebar {
            transform: translateX(-100%);
        }

        body.dashboard-sidebar-collapsed .shell {
            margin-left: 0;
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
            overflow: visible;
        }

        .topbar::before,
        .topbar::after {
            content: none;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: var(--card);
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            cursor: pointer;
            transition: all .15s;
        }

        .sidebar-toggle-btn:hover {
            border-color: var(--teal);
            background: var(--teal-pale);
        }

        .sidebar-toggle-btn span {
            display: block;
            width: 16px;
            height: 2px;
            border-radius: 99px;
            background: var(--slate);
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--slate);
            letter-spacing: -0.02em;
            white-space: nowrap;
        }

        .topbar-search {
            min-width: 260px;
            height: 38px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: var(--card);
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 12px;
        }

        .topbar-search:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.1);
        }

        .topbar-search input {
            border: none;
            outline: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            width: 100%;
            color: var(--ink);
        }

        .search-icon {
            color: var(--muted);
            font-size: 0.85rem;
        }

        .topbar-btn {
            position: relative;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: var(--card);
            color: var(--slate);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            transition: all .15s;
            font-size: 1rem;
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

        .btn-new-invoice {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 18px;
            border-radius: 10px;
            background: var(--teal);
            color: #fff;
            border: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap;
        }

        .btn-new-invoice:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13, 13, 13, 0.45);
            backdrop-filter: blur(3px);
            z-index: 45;
        }

        .sidebar-overlay.open,
        .sidebar-overlay.visible {
            display: block;
        }

        @media (max-width: 960px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .shell,
            body.dashboard-sidebar-collapsed .shell {
                margin-left: 0;
            }

            .topbar {
                padding: 0 16px;
            }

            .topbar-search {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .page-title {
                font-size: 1rem;
            }

            .btn-new-invoice {
                padding: 9px 12px;
                font-size: 0.78rem;
            }
        }

        /* Invoice page responsive layout */
        .shell,
        .main,
        .table-card,
        #tableBody {
            min-width: 0;
        }

        @media (max-width: 1280px) {
            .stats-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .table-card {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-header-row,
            .table-row {
                min-width: 980px;
            }
        }

        @media (max-width: 960px) {
            .main {
                padding: 24px 18px;
                gap: 20px;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .page-header-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            .page-header-actions .btn {
                flex: 1 1 180px;
                justify-content: center;
            }

            .filters-row {
                flex-direction: column;
                align-items: stretch;
            }

            .filters-left,
            .filters-right {
                width: 100%;
            }

            .search-bar {
                width: 100%;
                min-width: 0;
                flex: 1 1 100%;
            }

            .sort-select {
                flex: 1;
                min-width: 0;
            }

            .bulk-bar {
                left: 18px;
                right: 18px;
                transform: none;
                min-width: 0;
                width: auto;
                flex-wrap: wrap;
            }

            .bulk-actions {
                width: 100%;
                order: 3;
                margin-left: 0;
                flex-wrap: wrap;
            }

            .bulk-btn {
                flex: 1 1 130px;
                justify-content: center;
            }

            .drilldown-panel {
                width: min(520px, 100vw);
                right: -100vw;
            }
        }

        @media (max-width: 720px) {
            .topbar-btn[title="Help"] {
                display: none;
            }

            .topbar .btn-new-invoice {
                font-size: 0;
                padding: 9px 12px;
            }

            .topbar .btn-new-invoice::after {
                content: 'New';
                font-size: 0.78rem;
            }

            .main {
                padding: 18px 12px;
                gap: 16px;
            }

            .stats-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-amount {
                font-size: 1.35rem;
            }

            .filters-left {
                gap: 7px;
            }

            .filter-chip {
                flex: 1 1 calc(50% - 7px);
                justify-content: center;
                padding: 8px 10px;
            }

            .filters-right {
                gap: 8px;
            }

            .view-toggle {
                display: none;
            }

            .table-card {
                overflow-x: auto;
                overflow-y: hidden;
                background: var(--card);
                border: 1px solid var(--border);
                box-shadow: var(--shadow-sm);
                border-radius: 12px;
                -webkit-overflow-scrolling: touch;
            }

            .table-header-row,
            .table-row {
                min-width: 820px;
                grid-template-columns: 24px 112px 158px 140px 104px 104px 96px 92px;
                gap: 8px;
                padding-left: 12px;
                padding-right: 12px;
            }

            .table-header-row {
                display: grid;
                position: sticky;
                top: 0;
                z-index: 2;
            }

            .table-row {
                display: grid;
                padding-top: 12px;
                padding-bottom: 12px;
            }

            .inv-num {
                font-size: 0.76rem;
            }

            .inv-icon {
                width: 24px;
                height: 24px;
                font-size: 0.65rem;
            }

            .client-avatar-sm {
                width: 26px;
                height: 26px;
            }

            .client-name,
            .project-cell,
            .date-cell,
            .status-badge {
                font-size: 0.74rem;
            }

            .amount-cell {
                font-size: 0.82rem;
            }

            .row-actions {
                opacity: 1;
            }

            .table-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                text-align: center;
            }

            .pagination {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 420px) {
            .topbar {
                gap: 8px;
            }

            .topbar-btn {
                width: 34px;
                height: 34px;
            }

            .filter-chip {
                flex-basis: 100%;
            }

            .table-header-row,
            .table-row {
                min-width: 760px;
                grid-template-columns: 22px 104px 146px 124px 92px 92px 84px 82px;
                gap: 7px;
                padding-left: 10px;
                padding-right: 10px;
            }

            .table-header-row {
                font-size: 0.58rem;
            }

            .status-badge {
                padding: 4px 8px;
                font-size: 0.68rem;
            }

            .action-btn {
                width: 26px;
                height: 26px;
            }
        }
    </style>
</head>

<body class="dashboard-page">

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- SIDEBAR                                                  -->
    <!-- ═══════════════════════════════════════════════════════ -->
    @include('subscriber.includes.sidebar')

    <!-- Overlay (mobile) -->
    <div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- SHELL                                                    -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <div class="shell">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle-btn" type="button" onclick="toggleDashboardSidebar()"
                    aria-label="Toggle sidebar" aria-expanded="true">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="page-title">Invoices</div>
                <div class="topbar-search">
                    <span class="search-icon">🔍</span>
                    <input type="text" placeholder="Search invoices, customers...">
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

        <!-- MAIN -->
        <main class="main">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <div>
                    <div class="page-title">Invoices</div>
                    <div class="page-subtitle">Manage and track all your client invoices</div>
                </div>
                <div class="page-header-actions">
                    <button class="btn btn-ghost" onclick="alert('Import CSV coming soon')">⬆ Import</button>
                    <button class="btn btn-primary" onclick="newInvoice()">＋ New Invoice</button>
                </div>
            </div>

            <!-- STATS CARDS -->
            <div class="stats-row">
                <div class="stat-card all active" onclick="filterByStatus('all', this)">
                    <div class="stat-label"><span class="stat-dot" style="background:var(--slate)"></span>Total
                        Outstanding</div>
                    <div class="stat-amount">${{ number_format($stats['total_outstanding'], 2) }}</div>
                    <div class="stat-meta"><span class="stat-count">{{ $stats['total_outstanding_count'] }} invoices</span> this quarter</div>
                </div>
                <div class="stat-card overdue" onclick="filterByStatus('overdue', this)">
                    <div class="stat-label"><span class="stat-dot" style="background:var(--red-soft)"></span>Overdue
                    </div>
                    <div class="stat-amount" style="color:var(--red-soft)">${{ number_format($stats['overdue'], 2) }}</div>
                    <div class="stat-meta"><span class="stat-count">{{ $stats['overdue_count'] }} invoices</span> need action</div>
                </div>
                <div class="stat-card pending" onclick="filterByStatus('sent', this)">
                    <div class="stat-label"><span class="stat-dot" style="background:var(--amber)"></span>Awaiting
                        Payment</div>
                    <div class="stat-amount" style="color:var(--amber)">${{ number_format($stats['awaiting_payment'], 2) }}</div>
                    <div class="stat-meta"><span class="stat-count">{{ $stats['awaiting_payment_count'] }} invoices</span> sent</div>
                </div>
                <div class="stat-card paid" onclick="filterByStatus('paid', this)">
                    <div class="stat-label"><span class="stat-dot" style="background:var(--teal)"></span>Paid This
                        Month</div>
                    <div class="stat-amount" style="color:var(--teal)">${{ number_format($stats['paid_this_month'], 2) }}</div>
                    <div class="stat-meta"><span class="stat-count">{{ $stats['paid_this_month_count'] }} invoices</span> collected</div>
                </div>
            </div>

            <!-- FILTERS -->
            <div class="filters-row">
                <div class="filters-left">
                    <div class="search-bar">
                        <span class="search-icon">🔍</span>
                        <input class="search-input" id="tableSearch" placeholder="Filter invoices…"
                            oninput="filterTable(this.value)">
                    </div>
                    <button class="filter-chip active" onclick="setStatusFilter('all', this)">All</button>
                    <button class="filter-chip" onclick="setStatusFilter('draft', this)">
                        <span class="chip-dot" style="background:var(--muted)"></span>Draft
                    </button>
                    <button class="filter-chip" onclick="setStatusFilter('sent', this)">
                        <span class="chip-dot" style="background:var(--blue)"></span>Sent
                    </button>
                    <button class="filter-chip" onclick="setStatusFilter('overdue', this)">
                        <span class="chip-dot" style="background:var(--red-soft)"></span>Overdue
                    </button>
                    <button class="filter-chip" onclick="setStatusFilter('paid', this)">
                        <span class="chip-dot" style="background:var(--teal)"></span>Paid
                    </button>
                </div>
                <div class="filters-right">
                    <select class="sort-select" onchange="sortTable(this.value)">
                        <option value="date-desc">Newest first</option>
                        <option value="date-asc">Oldest first</option>
                        <option value="amount-desc">Highest amount</option>
                        <option value="amount-asc">Lowest amount</option>
                        <option value="due-asc">Due soonest</option>
                        <option value="client">Client A–Z</option>
                    </select>
                    <div class="view-toggle">
                        <button class="view-btn active" title="Table view">☰</button>
                        <button class="view-btn" title="Card view"
                            onclick="alert('Card view coming soon')">⊞</button>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-card">
                <div class="table-header-row">
                    <div><input type="checkbox" class="row-check" id="selectAll" onchange="toggleSelectAll(this)">
                    </div>
                    <div class="th-sort sorted" onclick="sortTable('inv-num')">Invoice # <span
                            class="sort-icon">▲</span></div>
                    <div class="th-sort" onclick="sortTable('client')">Client <span class="sort-icon">↕</span></div>
                    <div class="th-sort" onclick="sortTable('project')">Project / PO</div>
                    <div class="th-sort" onclick="sortTable('date-desc')">Issue Date <span class="sort-icon">↕</span>
                    </div>
                    <div class="th-sort" onclick="sortTable('due-asc')">Due Date <span class="sort-icon">↕</span>
                    </div>
                    <div class="th-sort" onclick="sortTable('amount-desc')">Amount <span class="sort-icon">↕</span>
                    </div>
                    <div>Status</div>
                </div>
                <div id="tableBody">
                    <!-- rows injected by JS -->
                </div>
                <div class="table-footer">
                    <span id="tableCount">Showing 10 of 24 invoices</span>
                    <div class="pagination">
                        <button class="page-btn">‹</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">›</button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- BULK ACTION BAR                                          -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <div class="bulk-bar" id="bulkBar">
        <span class="bulk-count" id="bulkCount">0 selected</span>
        <div class="bulk-actions">
            <button class="bulk-btn" onclick="bulkAction('send')">✉ Send</button>
            <button class="bulk-btn" onclick="bulkAction('pdf')">⬇ Download PDF</button>
            <button class="bulk-btn" onclick="bulkAction('mark-paid')">✓ Mark Paid</button>
            <button class="bulk-btn danger" onclick="bulkAction('delete')">✕ Delete</button>
        </div>
        <button class="bulk-close" onclick="clearSelection()">✕</button>
    </div>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- CLIENT DRILL-DOWN PANEL                                  -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <div class="drilldown-backdrop" id="ddBackdrop" onclick="closeDrilldown()"></div>
    <div class="drilldown-panel" id="ddPanel">
        <div class="drilldown-header">
            <div class="drilldown-title-row">
                <div
                    style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.78rem;letter-spacing:0.06em;text-transform:uppercase;color:var(--muted);">
                    Client Details</div>
                <button class="drilldown-close" onclick="closeDrilldown()">✕</button>
            </div>
            <div class="client-profile" id="ddClientProfile">
                <!-- injected -->
            </div>
            <div class="client-stats" id="ddClientStats">
                <!-- injected -->
            </div>
        </div>
        <div class="drilldown-body" id="ddBody">
            <!-- injected -->
        </div>
        <div class="drilldown-footer">
            <button class="btn btn-ghost" onclick="closeDrilldown()">Close</button>
            <button class="btn btn-outline" onclick="alert('Client profile coming soon')">View Profile →</button>
            <button class="btn btn-primary" onclick="newInvoiceForClient()">＋ New Invoice</button>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- SEARCH OVERLAY                                           -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <div class="search-overlay" id="searchOverlay" onclick="closeSearch(event)">
        <div class="search-modal">
            <div class="search-modal-header">
                <span class="search-modal-icon">🔍</span>
                <input class="search-modal-input" id="searchModalInput"
                    placeholder="Search invoices, clients, PO, project…" oninput="runGlobalSearch(this.value)"
                    autofocus>
                <span style="font-size:0.72rem;color:var(--muted);" id="searchModalCount"></span>
                <button class="search-modal-close" onclick="closeSearch()">✕</button>
            </div>
            <div class="search-results-body" id="searchModalBody">
                <div style="padding:40px 20px;text-align:center;">
                    <div style="font-size:1.8rem;opacity:0.3;margin-bottom:8px;">🔍</div>
                    <div style="font-size:0.85rem;color:var(--muted);">Start typing to search invoices</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════ -->
    <!-- JAVASCRIPT                                               -->
    <!-- ═══════════════════════════════════════════════════════ -->
    <script>
        const avatarColors = [
            'linear-gradient(135deg,#00b899,#009e82)',
            'linear-gradient(135deg,#3b82f6,#2563eb)',
            'linear-gradient(135deg,#f5a623,#e8991a)',
            'linear-gradient(135deg,#8b5cf6,#7c3aed)',
            'linear-gradient(135deg,#f05454,#dc2626)',
            'linear-gradient(135deg,#ec4899,#db2777)',
            'linear-gradient(135deg,#14b8a6,#0d9488)',
            'linear-gradient(135deg,#f97316,#ea580c)',
        ];

        let clients = @json($clients);
        let invoices = @json($jsInvoices);

        let activeStatusFilter = 'all';
        let selectedRows = new Set();
        let currentClientIdx = null;

        // ─── RENDER TABLE ──────────────────────────────────────────
        function fmt$(n) {
            return '$' + n.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function fmtDate(d) {
            const [y, m, day] = d.split('-');
            return new Date(y, m - 1, day).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function isDue(d) {
            return new Date(d) < new Date();
        }

        function badgeClass(s) {
            return {
                draft: 'badge-draft',
                sent: 'badge-sent',
                paid: 'badge-paid',
                overdue: 'badge-overdue'
            } [s];
        }

        function badgeLabel(s) {
            return {
                draft: 'Draft',
                sent: 'Sent',
                paid: 'Paid',
                overdue: 'Overdue'
            } [s];
        }

        function renderTable(list) {
            const tbody = document.getElementById('tableBody');
            if (!list.length) {
                tbody.innerHTML =
                    `<div class="empty-state"><div class="empty-icon">🧾</div><div class="empty-title">No invoices found</div><div class="empty-sub">Try a different filter or create your first invoice.</div></div>`;
                document.getElementById('tableCount').textContent = '0 invoices';
                return;
            }
            document.getElementById('tableCount').textContent = `Showing ${list.length} of ${invoices.length} invoices`;
            tbody.innerHTML = list.map((inv, i) => {
                const cl = clients[inv.clientIdx];
                const due = isDue(inv.due) && inv.status !== 'paid';
                return `
      <div class="table-row" style="animation-delay:${i * 0.03}s" onclick="handleRowClick(event, ${invoices.indexOf(inv)})">
        <div><input type="checkbox" class="row-check" data-idx="${invoices.indexOf(inv)}" onclick="event.stopPropagation()" onchange="handleCheckbox(this)"></div>
        <div class="inv-num">
          <div class="inv-icon">🧾</div>
          INV-${inv.inv}
        </div>
        <div class="client-cell">
          <div class="client-avatar-sm" style="background:${cl.color}">${cl.initials}</div>
          <div class="client-info">
            <div class="client-name">${cl.name}</div>
            <div class="client-id">${cl.id}</div>
          </div>
        </div>
        <div class="project-cell" title="${inv.project}${inv.po ? ' · '+inv.po : ''}">${inv.project}${inv.po ? '<span style="color:var(--muted);font-size:0.72rem;"> · '+inv.po+'</span>' : ''}</div>
        <div class="date-cell">${fmtDate(inv.issued)}</div>
        <div class="date-cell ${due ? 'overdue' : ''}">${due ? '⚠ ' : ''}${fmtDate(inv.due)}</div>
        <div class="amount-cell">${fmt$(inv.amount)}</div>
        <div style="display:flex;align-items:center;gap:8px;justify-content:space-between;">
          <span class="status-badge ${badgeClass(inv.status)}">
            <span class="badge-dot"></span>${badgeLabel(inv.status)}
          </span>
          <div class="row-actions" onclick="event.stopPropagation()">
            <button class="action-btn" title="Edit" onclick="editInvoice(${invoices.indexOf(inv)})">✎</button>
            <button class="action-btn" title="Download PDF" onclick="downloadPDF(${invoices.indexOf(inv)})">⬇</button>
            <button class="action-btn danger" title="Delete" onclick="deleteInvoice(${invoices.indexOf(inv)})">✕</button>
          </div>
        </div>
      </div>`;
            }).join('');
        }

        // ─── FILTERING ─────────────────────────────────────────────
        function getFiltered() {
            const q = document.getElementById('tableSearch').value.trim().toLowerCase();
            return invoices.filter(inv => {
                const cl = clients[inv.clientIdx];
                if (activeStatusFilter !== 'all' && inv.status !== activeStatusFilter) return false;
                if (!q) return true;
                return (
                    inv.inv.includes(q) ||
                    cl.name.toLowerCase().includes(q) ||
                    cl.id.toLowerCase().includes(q) ||
                    inv.project.toLowerCase().includes(q) ||
                    inv.po.toLowerCase().includes(q) ||
                    inv.status.includes(q)
                );
            });
        }

        function filterTable() {
            renderTable(getFiltered());
        }

        function setStatusFilter(status, btn) {
            activeStatusFilter = status;
            document.querySelectorAll('.filters-left .filter-chip').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            renderTable(getFiltered());
        }

        function filterByStatus(status, card) {
            activeStatusFilter = status;
            document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            // sync chip
            document.querySelectorAll('.filters-left .filter-chip').forEach(c => {
                c.classList.toggle('active', c.textContent.trim().toLowerCase() === status || (status === 'all' && c
                    .textContent.trim() === 'All'));
            });
            renderTable(getFiltered());
        }

        function sortTable(mode) {
            const sorted = [...getFiltered()];
            if (mode === 'date-desc') sorted.sort((a, b) => b.issued.localeCompare(a.issued));
            else if (mode === 'date-asc') sorted.sort((a, b) => a.issued.localeCompare(b.issued));
            else if (mode === 'amount-desc') sorted.sort((a, b) => b.amount - a.amount);
            else if (mode === 'amount-asc') sorted.sort((a, b) => a.amount - b.amount);
            else if (mode === 'due-asc') sorted.sort((a, b) => a.due.localeCompare(b.due));
            else if (mode === 'client') sorted.sort((a, b) => clients[a.clientIdx].name.localeCompare(clients[b.clientIdx]
                .name));
            renderTable(sorted);
        }

        // ─── ROW INTERACTION ───────────────────────────────────────
        function handleRowClick(e, idx) {
            if (e.target.classList.contains('row-check')) return;
            openDrilldown(clients[invoices[idx].clientIdx], invoices[idx].clientIdx);
        }

        // ─── CHECKBOXES / BULK ─────────────────────────────────────
        function handleCheckbox(cb) {
            const idx = parseInt(cb.dataset.idx);
            if (cb.checked) selectedRows.add(idx);
            else selectedRows.delete(idx);
            updateBulkBar();
        }

        function toggleSelectAll(master) {
            const boxes = document.querySelectorAll('.row-check[data-idx]');
            boxes.forEach(cb => {
                cb.checked = master.checked;
                const idx = parseInt(cb.dataset.idx);
                if (master.checked) selectedRows.add(idx);
                else selectedRows.delete(idx);
            });
            updateBulkBar();
        }

        function updateBulkBar() {
            const bar = document.getElementById('bulkBar');
            const n = selectedRows.size;
            if (n > 0) {
                bar.classList.add('visible');
                document.getElementById('bulkCount').textContent = `${n} invoice${n !== 1 ? 's' : ''} selected`;
            } else {
                bar.classList.remove('visible');
            }
        }

        function clearSelection() {
            selectedRows.clear();
            document.querySelectorAll('.row-check').forEach(c => c.checked = false);
            updateBulkBar();
        }

        function bulkAction(action) {
            const n = selectedRows.size;
            if (n === 0) return;
            const labels = {
                send: `Send ${n} invoice(s)?`,
                pdf: `Download ${n} PDF(s)?`,
                'mark-paid': `Mark ${n} invoice(s) as paid?`,
                delete: `Delete ${n} invoice(s)?`
            };
            if (confirm(labels[action] || `Perform action on ${n} invoice(s)?`)) {
                if (action === 'pdf') {
                    alert('Generating batch PDF for ' + n + ' invoice(s)...');
                    clearSelection();
                    return;
                }
                const selectedInvNums = Array.from(selectedRows).map(idx => invoices[idx]?.inv).filter(Boolean);
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                fetch("{{ route('subscriber.invoices.bulk') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ action: action, invoices: selectedInvNums })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        if (action === 'delete') {
                            invoices = invoices.filter(inv => !selectedInvNums.includes(inv.inv));
                        } else if (action === 'mark-paid') {
                            invoices.forEach(inv => {
                                if (selectedInvNums.includes(inv.inv)) inv.status = 'paid';
                            });
                        } else if (action === 'send') {
                            invoices.forEach(inv => {
                                if (selectedInvNums.includes(inv.inv) && inv.status !== 'paid') inv.status = 'sent';
                            });
                        }
                        clearSelection();
                        renderTable(getFiltered());
                        if (window.toast) window.toast(data.message || 'Action completed');
                    } else {
                        alert(data.message || 'Error executing action');
                    }
                })
                .catch(err => {
                    console.error(err);
                    clearSelection();
                });
            }
        }

        // ─── DRILLDOWN PANEL ───────────────────────────────────────
        function openDrilldown(cl, clientIdx) {
            currentClientIdx = clientIdx;
            const clientInvoices = invoices.filter(inv => inv.clientIdx === clientIdx);
            const totalBilled = clientInvoices.reduce((s, i) => s + i.amount, 0);
            const paid = clientInvoices.filter(i => i.status === 'paid').reduce((s, i) => s + i.amount, 0);
            const outstanding = totalBilled - paid;

            document.getElementById('ddClientProfile').innerHTML = `
    <div class="client-avatar-lg" style="background:${cl.color}">${cl.initials}</div>
    <div class="client-profile-info">
      <div class="name">${cl.name}</div>
      <div class="email">${cl.email}</div>
      <div class="tags">${cl.id} ${cl.tags.map(t => `<span class="client-tag">${t}</span>`).join('')}</div>
    </div>`;

            document.getElementById('ddClientStats').innerHTML =
                `
    <div class="client-stat"><div class="cstat-val">${clientInvoices.length}</div><div class="cstat-label">Invoices</div></div>
    <div class="client-stat"><div class="cstat-val" style="color:var(--teal)">${fmt$(paid)}</div><div class="cstat-label">Paid</div></div>
    <div class="client-stat"><div class="cstat-val" style="color:${outstanding > 0 ? 'var(--amber)' : 'var(--muted)'}">${fmt$(outstanding)}</div><div class="cstat-label">Outstanding</div></div>`;

            const byStatus = {
                overdue: [],
                sent: [],
                draft: [],
                paid: []
            };
            clientInvoices.forEach(inv => {
                (byStatus[inv.status] || byStatus.draft).push(inv);
            });
            const order = ['overdue', 'sent', 'draft', 'paid'];
            const labels = {
                overdue: 'Overdue',
                sent: 'Awaiting Payment',
                draft: 'Draft',
                paid: 'Paid'
            };

            let html = '';
            order.forEach(key => {
                if (!byStatus[key].length) return;
                html += `<div class="drilldown-section-label">${labels[key]}</div>`;
                byStatus[key].forEach(inv => {
                    const due = isDue(inv.due) && inv.status !== 'paid';
                    html += `
        <div class="dd-inv-row" onclick="editInvoice(${invoices.indexOf(inv)})">
          <div class="dd-inv-icon">🧾</div>
          <div class="dd-inv-main">
            <div class="dd-inv-num">INV-${inv.inv}</div>
            <div class="dd-inv-proj">${inv.project}${inv.po ? ' · '+inv.po : ''}</div>
          </div>
          <div style="margin-left:auto;display:flex;align-items:center;gap:10px;">
            <span class="status-badge ${badgeClass(inv.status)}"><span class="badge-dot"></span>${badgeLabel(inv.status)}</span>
          </div>
          <div class="dd-inv-right">
            <div class="dd-inv-amount">${fmt$(inv.amount)}</div>
            <div class="dd-inv-date ${due ? 'overdue' : ''}">${due ? '⚠ ' : ''}Due ${fmtDate(inv.due)}</div>
          </div>
        </div>`;
                });
            });

            document.getElementById('ddBody').innerHTML = html;
            document.getElementById('ddBackdrop').classList.add('open');
            document.getElementById('ddPanel').classList.add('open');
        }

        function closeDrilldown() {
            document.getElementById('ddBackdrop').classList.remove('open');
            document.getElementById('ddPanel').classList.remove('open');
            currentClientIdx = null;
        }

        // ─── ACTIONS ───────────────────────────────────────────────
        function newInvoice() {
            window.location.href = "{{ route('subscriber.invoices.create') }}";
        }

        function newInvoiceForClient() {
            closeDrilldown();
            const client = (currentClientIdx !== null && clients[currentClientIdx]) ? clients[currentClientIdx].name : '';
            window.location.href = "{{ route('subscriber.invoices.create') }}" + (client ? ('?client=' + encodeURIComponent(client)) : '');
        }

        function editInvoice(idx) {
            closeDrilldown();
            const inv = invoices[idx];
            if (inv && inv.id) {
                window.location.href = "/subscriber/invoices/" + inv.id + "/edit";
            } else {
                window.location.href = "{{ route('subscriber.invoices.create') }}";
            }
        }

        function downloadPDF(idx) {
            const inv = invoices[idx];
            alert('PDF download initiated for INV-' + (inv ? inv.inv : ''));
        }

        function deleteInvoice(idx) {
            const inv = invoices[idx];
            if (!inv) return;
            if (confirm('Delete INV-' + inv.inv + '?')) {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch('/subscriber/invoices/' + inv.id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        invoices.splice(idx, 1);
                        renderTable(getFiltered());
                        if (window.toast) window.toast(data.message || 'Invoice deleted');
                    } else {
                        alert(data.message || 'Error deleting invoice');
                    }
                })
                .catch(err => {
                    console.error(err);
                    invoices.splice(idx, 1);
                    renderTable(getFiltered());
                });
            }
        }

        function exportInvoices() {
            alert('Exporting invoices to CSV…');
        }

        // ─── GLOBAL SEARCH ─────────────────────────────────────────
        function openSearch() {
            document.getElementById('searchOverlay').classList.add('open');
            setTimeout(() => document.getElementById('searchModalInput').focus(), 80);
        }

        function closeSearch(e) {
            if (e && e.target !== document.getElementById('searchOverlay')) return;
            document.getElementById('searchOverlay').classList.remove('open');
            document.getElementById('searchModalInput').value = '';
            document.getElementById('searchModalCount').textContent = '';
            document.getElementById('searchModalBody').innerHTML =
                `<div style="padding:40px 20px;text-align:center;"><div style="font-size:1.8rem;opacity:0.3;margin-bottom:8px;">🔍</div><div style="font-size:0.85rem;color:var(--muted);">Start typing to search invoices</div></div>`;
        }

        function runGlobalSearch(q) {
            const body = document.getElementById('searchModalBody');
            if (!q.trim()) {
                body.innerHTML =
                    `<div style="padding:40px 20px;text-align:center;"><div style="font-size:1.8rem;opacity:0.3;margin-bottom:8px;">🔍</div><div style="font-size:0.85rem;color:var(--muted);">Start typing to search invoices</div></div>`;
                document.getElementById('searchModalCount').textContent = '';
                return;
            }
            const ql = q.trim().toLowerCase();
            const filtered = invoices.filter(inv => {
                const cl = clients[inv.clientIdx];
                return inv.inv.includes(ql) || cl.name.toLowerCase().includes(ql) || inv.project.toLowerCase()
                    .includes(ql) || inv.po.toLowerCase().includes(ql) || inv.status.includes(ql);
            });
            document.getElementById('searchModalCount').textContent = filtered.length ?
                `${filtered.length} result${filtered.length !== 1 ? 's' : ''}` : '';
            if (!filtered.length) {
                body.innerHTML =
                    `<div style="padding:40px 20px;text-align:center;"><div style="font-size:1.8rem;opacity:0.3;margin-bottom:8px;">😶</div><div style="font-size:0.85rem;color:var(--muted);">No invoices match "${q}"</div></div>`;
                return;
            }
            const hl = (str) => str.replace(new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`, 'gi'),
                '<mark style="background:var(--teal-pale);color:var(--teal-dark);border-radius:2px;padding:0 2px;">$1</mark>'
            );
            body.innerHTML = filtered.map(inv => {
                const cl = clients[inv.clientIdx];
                return `
      <div class="search-quick-item" onclick="editInvoice(${invoices.indexOf(inv)});document.getElementById('searchOverlay').classList.remove('open')">
        <div style="width:34px;height:34px;border-radius:8px;background:var(--teal-pale);display:flex;align-items:center;justify-content:center;font-size:0.8rem;flex-shrink:0;">🧾</div>
        <div style="flex:1;min-width:0;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;color:var(--slate);">${hl('INV-'+inv.inv)}</div>
          <div style="font-size:0.75rem;color:var(--muted);">${hl(cl.name)} · ${hl(inv.project)}</div>
        </div>
        <span class="status-badge ${badgeClass(inv.status)}" style="flex-shrink:0;"><span class="badge-dot"></span>${badgeLabel(inv.status)}</span>
        <div style="text-align:right;flex-shrink:0;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;">${fmt$(inv.amount)}</div>
          <div style="font-size:0.72rem;color:var(--muted);">Due ${fmtDate(inv.due)}</div>
        </div>
      </div>`;
            }).join('');
        }

        document.addEventListener('keydown', e => {
            if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                e.preventDefault();
                openSearch();
            }
            if (e.key === 'Escape') {
                document.getElementById('searchOverlay').classList.remove('open');
                closeDrilldown();
            }
        });

        // ─── INIT ──────────────────────────────────────────────────
        renderTable(invoices);
    </script>

    <script>
        (function() {
            function byId(id) {
                return document.getElementById(id);
            }
            window.setActive = window.setActive || function(element) {
                document.querySelectorAll('.nav-item').forEach(function(item) {
                    item.classList.remove('active');
                });
                if (element) element.classList.add('active');
            };
            window.closeSidebar = window.closeSidebar || function() {
                var sidebar = byId('sidebar');
                var overlay = byId('overlay');
                if (sidebar) sidebar.classList.remove('open');
                if (overlay) {
                    overlay.classList.remove('open');
                    overlay.classList.remove('visible');
                }
            };
            window.toggleDashboardSidebar = window.toggleDashboardSidebar || function() {
                if (window.matchMedia('(max-width: 960px)').matches) {
                    var sidebar = byId('sidebar');
                    var overlay = byId('overlay');
                    if (sidebar) sidebar.classList.toggle('open');
                    if (overlay) overlay.classList.toggle('visible');
                    return;
                }
                document.body.classList.toggle('dashboard-sidebar-collapsed');
            };
            window.toast = window.toast || function(message) {
                var toast = byId('toast');
                if (!toast) {
                    toast = document.createElement('div');
                    toast.id = 'toast';
                    toast.style.cssText =
                        'position:fixed;left:50%;bottom:24px;z-index:9999;transform:translateX(-50%);background:#1e2a38;color:#fff;padding:10px 16px;border-radius:10px;box-shadow:0 12px 32px rgba(0,0,0,.18);opacity:0;transition:opacity .2s, transform .2s;';
                    document.body.appendChild(toast);
                }
                toast.textContent = message;
                toast.style.opacity = '1';
                toast.style.transform = 'translateX(-50%) translateY(0)';
                clearTimeout(window.__layoutToastTimer);
                window.__layoutToastTimer = setTimeout(function() {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(-50%) translateY(16px)';
                }, 2200);
            };
        }());
    </script>

</body>

</html>
