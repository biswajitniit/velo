<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Velo — Projects</title>
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
            --violet: #7c5cfc;
            --violet-pale: #ede8ff;
            --sky: #0ea5e9;
            --sky-pale: #e0f2fe;
            --muted: #6b7280;
            --border: #ddd8cc;
            --border-dark: rgba(255, 255, 255, 0.08);
            --card: #ffffff;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.10);
            --shadow-lg: 0 24px 64px rgba(0, 0, 0, 0.18);
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
            transition: transform .28s cubic-bezier(.22, 1, .36, 1), box-shadow .28s ease;
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

        .portal-badge {
            display: inline-block;
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: rgba(0, 184, 153, 0.2);
            color: var(--teal);
            padding: 2px 8px;
            border-radius: 4px;
            margin-top: 4px;
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
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), var(--teal-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.82rem;
            color: #fff;
            flex-shrink: 0;
            border: 2px solid rgba(0, 184, 153, 0.4);
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

        .user-company {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.45);
            margin-top: 1px;
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

        .nav-icon {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-label {
            flex: 1;
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

        /* ─── LAYOUT SHELL ────────────────────────────────────── */
        .shell {
            margin-left: var(--sidebar-w);
            width: calc(100% - var(--sidebar-w));
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left .28s cubic-bezier(.22, 1, .36, 1), width .28s cubic-bezier(.22, 1, .36, 1);
        }

        body.sidebar-collapsed {
            --sidebar-w: 0px;
        }

        body.sidebar-collapsed .sidebar {
            transform: translateX(-260px);
            box-shadow: none;
        }

        body.sidebar-collapsed .shell {
            margin-left: 0;
            width: 100%;
        }

        body.sidebar-collapsed::before {
            left: 0;
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
            gap: 16px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
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

        .sidebar-toggle-btn {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: var(--slate);
            cursor: pointer;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: background .18s, color .18s;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn:hover {
            background: var(--cream);
            color: var(--teal);
        }

        .sidebar-toggle-btn span {
            width: 23px;
            height: 2px;
            border-radius: 99px;
            background: currentColor;
            display: block;
        }

        .btn-pay {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: 99px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            white-space: nowrap;
        }

        .btn-pay:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0, 184, 153, 0.35);
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

        .btn-primary {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: 99px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .15s, box-shadow .2s;
            white-space: nowrap;
        }

        .btn-primary:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(0, 184, 153, 0.35);
        }

        .btn-secondary {
            padding: 8px 18px;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: 99px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--ink);
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .btn-secondary:hover {
            border-color: var(--slate);
            background: var(--cream);
        }

        /* ─── MAIN ────────────────────────────────────────────── */
        .main {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
        }

        /* ─── PAGE HEADER ─────────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 20px;
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
            margin-top: 3px;
        }

        .page-header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ─── KPI GRID ────────────────────────────────────────── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .kpi-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 22px;
            box-shadow: var(--shadow-sm);
            animation: fadeUp .4s ease both;
        }

        .kpi-card:nth-child(1) {
            animation-delay: .05s;
        }

        .kpi-card:nth-child(2) {
            animation-delay: .10s;
        }

        .kpi-card:nth-child(3) {
            animation-delay: .15s;
        }

        .kpi-card:nth-child(4) {
            animation-delay: .20s;
        }

        .kpi-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .kpi-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .kpi-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
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

        .icon-violet {
            background: var(--violet-pale);
        }

        .kpi-value {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--slate);
            letter-spacing: -0.03em;
            line-height: 1;
        }

        .kpi-change {
            font-size: 0.75rem;
            margin-top: 6px;
            font-weight: 500;
        }

        .kpi-change.up {
            color: var(--teal);
        }

        .kpi-change.warn {
            color: var(--amber);
        }

        .kpi-change.neutral {
            color: var(--muted);
        }

        /* ─── FILTER / TOOLBAR ────────────────────────────────── */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .filter-listbox {
            padding: 7px 32px 7px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--card);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--ink);
            cursor: pointer;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b7280' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: border-color .2s, box-shadow .2s;
            min-width: 160px;
        }

        .filter-listbox:focus,
        .filter-listbox:hover {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.10);
        }

        .toolbar-right {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .toolbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: 99px;
            padding: 6px 14px;
            min-width: 400px;
            transition: border-color .2s;
        }

        .toolbar-search:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.10);
        }

        .toolbar-search input {
            border: none;
            outline: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--ink);
            width: 100%;
        }

        .toolbar-search input::placeholder {
            color: var(--muted);
        }

        .view-toggle {
            display: flex;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
        }

        .view-btn {
            padding: 6px 12px;
            border: none;
            background: var(--card);
            cursor: pointer;
            font-size: 0.9rem;
            color: var(--muted);
            transition: background .15s, color .15s;
        }

        .view-btn.active {
            background: var(--slate);
            color: #fff;
        }

        .sort-select {
            padding: 7px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            background: var(--card);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.78rem;
            color: var(--ink);
            cursor: pointer;
            outline: none;
        }

        /* ─── TABLE ───────────────────────────────────────────── */
        .table-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            animation: fadeUp .4s .25s ease both;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 12px 16px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--muted);
            background: var(--cream);
            text-align: left;
            white-space: nowrap;
            border-bottom: 1px solid var(--border);
            user-select: none;
            cursor: pointer;
        }

        thead th:hover {
            color: var(--ink);
        }

        thead th.sorted {
            color: var(--slate);
        }

        thead th .sort-arrow {
            display: inline-block;
            margin-left: 5px;
            font-size: 0.65rem;
            color: var(--muted);
            vertical-align: middle;
            transition: color .15s;
        }

        thead th.sorted .sort-arrow {
            color: var(--slate);
        }

        thead th.sort-asc .sort-arrow::after {
            content: ' ↑';
        }

        thead th.sort-desc .sort-arrow::after {
            content: ' ↓';
        }

        thead th:not(.sort-asc):not(.sort-desc) .sort-arrow::after {
            content: ' ↕';
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .12s;
            cursor: pointer;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #faf9f5;
        }

        td {
            padding: 13px 16px;
            vertical-align: middle;
        }

        .proj-id {
            font-family: 'Syne', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--slate);
            letter-spacing: 0.02em;
        }

        .proj-name {
            font-weight: 500;
            color: var(--ink);
            font-size: 0.88rem;
        }

        .proj-desc {
            font-size: 0.78rem;
            color: var(--muted);
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .client-tag {
            font-size: 0.82rem;
            color: var(--ink);
            font-weight: 400;
        }

        .client-multi-link {
            font-size: 0.82rem;
            color: var(--ink);
            font-weight: 400;
            cursor: pointer;
            border: none;
            background: none;
            padding: 0;
            font-family: 'DM Sans', sans-serif;
            transition: color .15s;
        }

        .client-multi-link:hover {
            color: var(--teal);
        }

        #clientTooltip {
            position: fixed;
            z-index: 300;
            pointer-events: none;
            background: var(--slate);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 5px 11px;
            border-radius: 6px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.22);
            white-space: nowrap;
            opacity: 0;
            transition: opacity .15s;
        }

        #clientTooltip.visible {
            opacity: 1;
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            background: none;
            padding: 0;
        }

        .type-internal {
            color: var(--violet);
        }

        .type-external {
            color: #b56a00;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            font-size: 0.82rem;
            font-weight: 400;
            color: var(--ink);
            background: none;
            padding: 0;
        }

        .status-pending,
        .status-open,
        .status-hold,
        .status-closed,
        .status-cancelled {
            color: var(--ink);
        }

        .perf-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 600;
            background: none;
            padding: 0;
        }

        .perf-on-time {
            color: var(--teal-dark);
        }

        .perf-behind {
            color: var(--red-soft);
        }

        .perf-ahead {
            color: #b56a00;
        }

        .perf-just-in-time {
            color: var(--violet);
        }

        .amount-cell {
            font-weight: 600;
            color: var(--slate);
            font-size: 0.88rem;
            font-variant-numeric: tabular-nums;
        }

        .gl-cell {
            font-size: 0.72rem;
            color: var(--muted);
            font-variant-numeric: tabular-nums;
            line-height: 1.4;
        }

        .gl-cell span {
            display: block;
        }

        .action-menu-btn {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: transparent;
            cursor: pointer;
            font-size: 1rem;
            color: var(--muted);
            transition: background .12s, color .12s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-menu-btn:hover {
            background: var(--cream);
            color: var(--ink);
        }

        .pm-cell {
            font-size: 0.8rem;
        }

        .pm-name {
            font-weight: 500;
            color: var(--ink);
            cursor: pointer;
            display: inline;
            border-bottom: 1px dashed var(--border);
            transition: color .15s, border-color .15s;
        }

        .pm-name:hover {
            color: var(--teal);
            border-bottom-color: var(--teal);
        }

        .pm-name.empty {
            cursor: default;
            border-bottom: none;
        }

        .pm-email {
            color: var(--muted);
            font-size: 0.72rem;
        }

        /* PM Contact Card popup */
        #pmCard {
            position: fixed;
            z-index: 400;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 300px;
            padding: 0;
            overflow: hidden;
            display: none;
            animation: fadeUp .18s ease;
        }

        #pmCard.visible {
            display: block;
        }

        .pm-card-header {
            background: var(--slate);
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .pm-card-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--teal), var(--teal-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            color: #fff;
        }

        .pm-card-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: .95rem;
            color: #fff;
        }

        .pm-card-role {
            font-size: .72rem;
            color: rgba(255, 255, 255, .5);
            margin-top: 1px;
        }

        .pm-card-body {
            padding: 8px 0;
        }

        .pm-card-action {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            cursor: pointer;
            text-decoration: none;
            transition: background .12s;
            border: none;
            width: 100%;
            background: transparent;
            text-align: left;
        }

        .pm-card-action:hover {
            background: var(--cream);
        }

        .pm-card-action:hover .pm-card-action-label {
            color: var(--teal);
        }

        .pm-card-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .pm-icon-email {
            background: var(--teal-pale);
        }

        .pm-icon-voice {
            background: var(--sky-pale);
        }

        .pm-icon-sms {
            background: var(--amber-pale);
        }

        .pm-card-action-text {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .pm-card-action-type {
            font-size: .67rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .pm-card-action-label {
            font-size: .82rem;
            color: var(--ink);
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: color .12s;
        }

        .pm-card-action-cta {
            margin-left: auto;
            font-size: .7rem;
            font-weight: 600;
            color: var(--muted);
            flex-shrink: 0;
            transition: color .12s;
        }

        .pm-card-action:hover .pm-card-action-cta {
            color: var(--teal);
        }

        .pm-card-divider {
            height: 1px;
            background: var(--border);
            margin: 0 18px;
        }

        .pm-card-empty {
            font-size: .78rem;
            color: var(--muted);
            font-style: italic;
            padding: 14px 18px;
        }

        .pm-card-footer {
            padding: 9px 18px;
            background: var(--cream);
            border-top: 1px solid var(--border);
            font-size: .71rem;
            color: var(--muted);
        }

        .date-cell {
            font-size: 0.8rem;
            color: var(--muted);
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        /* checkbox */
        .cb-cell {
            width: 36px;
        }

        input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--teal);
            cursor: pointer;
        }

        /* table footer */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            border-top: 1px solid var(--border);
            background: var(--cream);
        }

        .table-footer-left {
            font-size: 0.78rem;
            color: var(--muted);
        }

        .pagination {
            display: flex;
            gap: 4px;
        }

        .pg-btn {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: var(--card);
            cursor: pointer;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .pg-btn:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        .pg-btn.active {
            background: var(--slate);
            border-color: var(--slate);
            color: #fff;
        }

        /* ─── EMPTY STATE ─────────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 64px 24px;
            display: none;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            color: var(--slate);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 0.85rem;
            color: var(--muted);
            margin-bottom: 20px;
        }

        /* ─── MODAL OVERLAY ───────────────────────────────────── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(14, 20, 30, 0.55);
            backdrop-filter: blur(4px);
            z-index: 200;
            align-items: flex-start;
            justify-content: center;
            overflow-y: auto;
            padding: 40px 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 780px;
            overflow: hidden;
            animation: modalIn .25s ease;
            flex-shrink: 0;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: translateY(-16px) scale(0.98);
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
            padding: 22px 28px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--slate) 0%, var(--slate-light) 100%);
        }

        .modal-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(0, 184, 153, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
        }

        .modal-subtitle {
            font-size: 0.77rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 1px;
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            background: transparent;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s, color .15s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        /* Tab nav inside modal */
        .modal-tabs {
            display: flex;
            border-bottom: 1px solid var(--border);
            background: var(--cream);
            padding: 0 28px;
        }

        .modal-tab {
            padding: 12px 18px;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--muted);
            cursor: pointer;
            border-bottom: 2.5px solid transparent;
            transition: color .15s, border-color .15s;
            white-space: nowrap;
        }

        .modal-tab.active {
            color: var(--teal);
            border-bottom-color: var(--teal);
            font-weight: 600;
        }

        .modal-body {
            padding: 28px;
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        /* ─── FORM STYLES ─────────────────────────────────────── */
        .section-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--teal);
            margin-bottom: 14px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--teal-pale);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 22px;
        }

        .form-grid.cols-3 {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .form-row {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-row.span-2 {
            grid-column: span 2;
        }

        .form-row.span-3 {
            grid-column: span 3;
        }

        label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--slate);
            letter-spacing: 0.02em;
        }

        label .req {
            color: var(--red-soft);
            margin-left: 2px;
        }

        label .opt {
            font-weight: 400;
            color: var(--muted);
            font-size: 0.7rem;
            margin-left: 4px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        select,
        textarea {
            padding: 9px 13px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--paper);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            color: var(--ink);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            width: 100%;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.12);
            background: #fff;
        }

        input.error {
            border-color: var(--red-soft);
        }

        .field-hint {
            font-size: 0.72rem;
            color: var(--muted);
            margin-top: 2px;
        }

        .field-error {
            font-size: 0.72rem;
            color: var(--red-soft);
            margin-top: 2px;
            display: none;
        }

        .field-error.visible {
            display: block;
        }

        textarea {
            resize: vertical;
            min-height: 72px;
        }

        .char-counter {
            font-size: 0.7rem;
            color: var(--muted);
            text-align: right;
            margin-top: 2px;
        }

        .char-counter.warn {
            color: var(--amber);
        }

        .char-counter.over {
            color: var(--red-soft);
        }

        /* Radio groups */
        .radio-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all .15s;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--muted);
            flex: 1;
        }

        .radio-option input {
            display: none;
        }

        .radio-option:hover {
            border-color: var(--teal);
            color: var(--ink);
        }

        .radio-option.selected {
            border-color: var(--teal);
            background: var(--teal-pale);
            color: var(--teal-dark);
            font-weight: 600;
        }

        .radio-option .radio-icon {
            font-size: 1rem;
        }

        /* Toggle / Switch */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed var(--border);
        }

        .toggle-row:last-child {
            border-bottom: none;
        }

        .toggle-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--ink);
        }

        .toggle-sub {
            font-size: 0.75rem;
            color: var(--muted);
        }

        .toggle {
            position: relative;
            width: 40px;
            height: 22px;
            flex-shrink: 0;
        }

        .toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: var(--border);
            border-radius: 99px;
            transition: background .2s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            left: 3px;
            top: 3px;
            transition: transform .2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
        }

        .toggle input:checked+.toggle-slider {
            background: var(--teal);
        }

        .toggle input:checked+.toggle-slider::before {
            transform: translateX(18px);
        }

        /* Client multi-select chips */
        .client-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            padding: 8px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--paper);
            min-height: 44px;
            cursor: text;
            transition: border-color .2s;
        }

        .client-chips:focus-within {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.12);
            background: #fff;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            background: var(--sky-pale);
            color: var(--sky);
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .chip-remove {
            cursor: pointer;
            font-size: 0.85rem;
            line-height: 1;
            color: var(--sky);
            transition: color .1s;
        }

        .chip-remove:hover {
            color: var(--red-soft);
        }

        .chip-input {
            border: none;
            outline: none;
            background: transparent;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--ink);
            flex: 1;
            min-width: 80px;
        }

        .chip-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 50;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-md);
            max-height: 180px;
            overflow-y: auto;
            display: none;
        }

        .chip-dropdown.open {
            display: block;
        }

        .chip-option {
            padding: 9px 14px;
            font-size: 0.82rem;
            cursor: pointer;
            transition: background .1s;
        }

        .chip-option:hover {
            background: var(--cream);
        }

        .chip-field {
            position: relative;
        }

        /* GL Coding */
        .gl-section {
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 16px;
            margin-top: 4px;
        }

        .gl-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }

        /* Modal footer */
        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 28px;
            border-top: 1px solid var(--border);
            background: var(--cream);
        }

        .modal-footer-left {
            font-size: 0.78rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .modal-footer-right {
            display: flex;
            gap: 10px;
        }

        .btn-danger {
            padding: 9px 20px;
            background: var(--red-pale);
            color: var(--red-soft);
            border: 1.5px solid var(--red-soft);
            border-radius: 99px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-danger:hover {
            background: var(--red-soft);
            color: #fff;
        }

        /* ─── DETAIL DRAWER ───────────────────────────────────── */
        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(14, 20, 30, 0.35);
            z-index: 150;
        }

        .drawer-overlay.open {
            display: block;
        }

        .drawer {
            position: fixed;
            top: 0;
            right: -520px;
            bottom: 0;
            width: 520px;
            background: var(--card);
            box-shadow: -8px 0 48px rgba(0, 0, 0, 0.15);
            z-index: 160;
            display: flex;
            flex-direction: column;
            transition: right .3s cubic-bezier(.4, 0, .2, 1);
            overflow: hidden;
        }

        .drawer.open {
            right: 0;
        }

        .drawer-header {
            padding: 22px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--slate);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .drawer-title-area {}

        .drawer-proj-id {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--teal);
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .drawer-proj-name {
            font-family: 'Syne', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
        }

        .drawer-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            background: transparent;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .drawer-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 24px;
        }

        .drawer-section {
            margin-bottom: 24px;
        }

        .drawer-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--teal);
            padding-bottom: 8px;
            border-bottom: 1px solid var(--teal-pale);
            margin-bottom: 12px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .info-item {}

        .info-key {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 2px;
        }

        .info-val {
            font-size: 0.88rem;
            color: var(--ink);
            font-weight: 500;
        }

        .drawer-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 10px;
            flex-shrink: 0;
        }

        /* progress bar */
        .progress-wrap {
            margin-top: 8px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            margin-bottom: 5px;
        }

        .progress-bar {
            height: 6px;
            background: var(--cream);
            border-radius: 99px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--teal), var(--teal-dark));
            transition: width .6s ease;
        }

        .progress-fill.warn {
            background: linear-gradient(90deg, var(--amber), #e08000);
        }

        .progress-fill.danger {
            background: linear-gradient(90deg, var(--red-soft), #c03030);
        }

        /* ─── DROPDOWN ────────────────────────────────────────── */
        .dropdown-wrap {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 4px);
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            box-shadow: var(--shadow-md);
            min-width: 160px;
            z-index: 90;
            overflow: hidden;
        }

        .dropdown-menu.open {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 14px;
            font-size: 0.82rem;
            color: var(--ink);
            cursor: pointer;
            transition: background .1s;
        }

        .dropdown-item:hover {
            background: var(--cream);
        }

        .dropdown-item.danger {
            color: var(--red-soft);
        }

        .dropdown-item.danger:hover {
            background: var(--red-pale);
        }

        .di-icon {
            font-size: 0.85rem;
            width: 16px;
            text-align: center;
        }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        /* ─── TOAST ───────────────────────────────────────────── */
        #toast {
            position: fixed;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: var(--slate);
            color: #fff;
            padding: 12px 24px;
            border-radius: 99px;
            font-size: 0.83rem;
            font-weight: 500;
            z-index: 999;
            pointer-events: none;
            transition: transform .3s ease, opacity .3s ease;
            opacity: 0;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ─── ANIMATIONS ──────────────────────────────────────── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ─── MOBILE ──────────────────────────────────────────── */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 60;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--slate);
            color: #fff;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            box-shadow: var(--shadow-md);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 45;
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay.visible {
                display: block;
            }

            .shell {
                margin-left: 0;
                width: 100%;
            }

            .mobile-menu-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-grid.cols-3 {
                grid-template-columns: 1fr;
            }

            .form-row.span-2 {
                grid-column: span 1;
            }

            .form-row.span-3 {
                grid-column: span 1;
            }

            .gl-grid {
                grid-template-columns: 1fr;
            }

            .drawer {
                width: 100%;
                right: -100%;
            }
        }

        @media (max-width: 600px) {
            .main {
                padding: 16px;
            }

            .topbar {
                padding: 0 16px;
            }

            .kpi-grid {
                grid-template-columns: 1fr 1fr;
            }

            .page-header-left h1 {
                font-size: 1.3rem;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* Role-locked: manager/admin only ribbon */
        .role-info {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            background: var(--amber-pale);
            border: 1px solid #f0c060;
            border-radius: var(--radius-sm);
            font-size: 0.78rem;
            color: #7a4a00;
            margin-bottom: 20px;
        }

        .role-info strong {
            font-weight: 700;
        }
    </style>
</head>

<body class="dashboard-page">

    <!-- Sidebar overlay (mobile) -->
    <div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    @include('subscriber.includes.sidebar')

    <!-- ─── MAIN SHELL ─────────────────────────────────────── -->
    <div class="shell">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle-btn" type="button" onclick="toggleDesktopSidebar()"
                    aria-label="Toggle sidebar" aria-expanded="true">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="page-title">Projects</div>
                <div class="topbar-search">
                    <span class="search-icon">🔍</span>
                    <input type="text" placeholder="Search invoices, quotes, documents…">
                </div>
            </div>
            <div class="topbar-right">
                <a href="{{ route('subscriber.notifications') }}" class="topbar-btn" title="Notifications">
                    🔔
                    <span class="topbar-dot"></span>
                </a>
                <a href="#" class="topbar-btn" title="Help" onclick="event.preventDefault();toast('📁 Project management and timeline tracking.');">❓</a>
            </div>
        </header>

        <!-- Main -->
        <main class="main">

            <!-- Page header -->
            <div class="page-header">
                <div class="page-header-left">
                    <h1>Manage Projects</h1>
                    <p>Track project costs, GL coding, timelines, and performance benchmarks across clients.</p>
                </div>
                <div class="page-header-actions">
                    <button class="btn-secondary" onclick="toast('📤 Export started')">⬇ Export CSV</button>
                    <button class="btn-primary" onclick="openCreateModal()">＋ New Project</button>
                </div>
            </div>

            <!-- KPI Grid -->
            <div class="kpi-grid" id="kpiGrid">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Total Projects</span>
                        <div class="kpi-icon icon-teal">🗂️</div>
                    </div>
                    <div class="kpi-value" id="kpiTotal">11</div>
                    <div class="kpi-change neutral">across all clients</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Active</span>
                        <div class="kpi-icon icon-teal">✅</div>
                    </div>
                    <div class="kpi-value" id="kpiActive">8</div>
                    <div class="kpi-change up">↑ 2 this month</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Behind Schedule</span>
                        <div class="kpi-icon icon-red">⚠️</div>
                    </div>
                    <div class="kpi-value" id="kpiBehind">2</div>
                    <div class="kpi-change warn">needs attention</div>
                </div>
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Est. Budget Total</span>
                        <div class="kpi-icon icon-violet">💰</div>
                    </div>
                    <div class="kpi-value" id="kpiBudget">$2.4M</div>
                    <div class="kpi-change neutral">across active projects</div>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="toolbar">
                <div style="display:flex;align-items:center;gap:8px">
                    <span style="font-size:0.82rem;font-weight:500;color:var(--muted)">Show</span>
                    <select class="filter-listbox" id="filterListbox" onchange="setFilter(this.value)">
                        <option value="all" selected>All Projects</option>
                        <optgroup label="── Status ──────────────">
                            <option value="pending">Pending</option>
                            <option value="open">Open</option>
                            <option value="hold">Hold</option>
                            <option value="closed">Closed</option>
                            <option value="cancelled">Cancelled</option>
                        </optgroup>
                        <optgroup label="── Type ────────────────">
                            <option value="external">External</option>
                            <option value="internal">Internal</option>
                        </optgroup>
                        <optgroup label="── Performance ─────────">
                            <option value="behind">Behind Schedule</option>
                        </optgroup>
                    </select>
                </div>
                <div class="toolbar-right">
                    <div class="toolbar-search">
                        <span style="color:var(--muted);font-size:.85rem;flex-shrink:0">🔍</span>
                        <input type="text" placeholder="Search projects…" id="searchInput"
                            oninput="filterProjects()">
                    </div>
                    <select class="sort-select" onchange="sortProjects(this.value)">
                        <option value="id">Sort: Project ID</option>
                        <option value="name">Sort: Name</option>
                        <option value="start">Sort: Start Date</option>
                        <option value="end">Sort: End Date</option>
                        <option value="budget">Sort: Budget</option>
                        <option value="status">Sort: Status</option>
                        <option value="client">Sort: Client</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="table-card">
                <div class="table-wrap">
                    <table id="projectTable">
                        <thead>
                            <tr>
                                <th class="cb-cell"><input type="checkbox" id="selectAll"
                                        onchange="toggleAll(this)"></th>
                                <th data-col="id" class="sorted sort-asc">Project ID<span class="sort-arrow"></span>
                                </th>
                                <th data-col="name">Name / Description<span class="sort-arrow"></span></th>
                                <th data-col="type">Type<span class="sort-arrow"></span></th>
                                <th data-col="client">Client(s)<span class="sort-arrow"></span></th>
                                <th data-col="status">Status<span class="sort-arrow"></span></th>
                                <th data-col="perf">Performance<span class="sort-arrow"></span></th>
                                <th data-col="start">Start Date<span class="sort-arrow"></span></th>
                                <th data-col="end">End Date<span class="sort-arrow"></span></th>
                                <th data-col="budget">Est. Budget<span class="sort-arrow"></span></th>
                                <th data-col="pm">PM<span class="sort-arrow"></span></th>
                                <th style="width:44px"></th>
                            </tr>
                        </thead>
                        <tbody id="projectBody">
                        </tbody>
                    </table>
                    <div class="empty-state" id="emptyState">
                        <div class="empty-icon">🗂️</div>
                        <h3>No projects found</h3>
                        <p>Try adjusting your search or filter, or create your first project.</p>
                        <button class="btn-primary" onclick="openCreateModal()">＋ New Project</button>
                    </div>
                </div>
                <div class="table-footer">
                    <div class="table-footer-left" id="tableFooterLabel">Showing 11 of 11 projects</div>
                    <div class="pagination">
                        <button class="pg-btn active">1</button>
                        <button class="pg-btn">2</button>
                        <button class="pg-btn">›</button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- ─── CREATE / EDIT MODAL ────────────────────────────── -->
    <div class="modal-overlay" id="projectModal" onclick="handleModalClick(event)">
        <div class="modal" id="modalBox">
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-header-icon">🗂️</div>
                    <div>
                        <div class="modal-title" id="modalTitle">New Project</div>
                        <div class="modal-subtitle" id="modalSubtitle">Admin &amp; Manager access required to create
                            projects</div>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal()">✕</button>
            </div>

            <div class="modal-tabs">
                <div class="modal-tab active" onclick="switchTab(0,this)">📋 Core Details</div>
                <div class="modal-tab" onclick="switchTab(1,this)">🏢 GL Coding</div>
                <div class="modal-tab" onclick="switchTab(2,this)">👤 Team &amp; Contacts</div>
                <div class="modal-tab" onclick="switchTab(3,this)">⚙️ Settings</div>
            </div>

            <div class="modal-body">

                <!-- TAB 0: Core Details -->
                <div class="tab-panel active" id="tab0">
                    <div class="section-label">🔑 Project Identification</div>
                    <div class="form-grid">
                        <div class="form-row">
                            <label>Project ID <span class="req">*</span> <span class="opt">(max 10
                                    chars)</span></label>
                            <input type="text" id="fProjectId" maxlength="10" placeholder="e.g. PROJ-001"
                                oninput="idCounter()">
                            <div class="char-counter" id="idCounter">0 / 10</div>
                            <div class="field-error" id="errProjectId">Project ID is required (max 10 characters)
                            </div>
                        </div>
                        <div class="form-row">
                            <label>Client ID <span class="req">*</span></label>
                            <select id="fClientId" onchange="handleClientChange()">
                                <option value="">— Select Client —</option>
                                <option value="CLI001">CLI001 · Acme Corp</option>
                                <option value="CLI002">CLI002 · TechNova Ltd</option>
                                <option value="CLI003">CLI003 · Greenfield Inc</option>
                                <option value="CLI004">CLI004 · Stellar Media</option>
                                <option value="CLI005">CLI005 · Harbor Finance</option>
                                <option value="CLI006">CLI006 · Summit Partners</option>
                                <option value="INTERNAL">— Internal (No Client) —</option>
                            </select>
                            <div class="field-error" id="errClientId">Client ID is required</div>
                        </div>
                        <div class="form-row">
                            <label>Short Description <span class="req">*</span></label>
                            <input type="text" id="fShortDesc" maxlength="50" placeholder="Brief one-liner"
                                oninput="shortDescCounter()">
                            <div class="char-counter" id="shortDescCounter">0 / 50</div>
                            <div class="field-error" id="errShortDesc">Short description is required</div>
                        </div>
                        <div class="form-row">
                            <label>Project Type <span class="req">*</span></label>
                            <div class="radio-group" id="fProjectType">
                                <label class="radio-option selected" id="radioExternal">
                                    <input type="radio" name="projType" value="external" checked>
                                    <span class="radio-icon">🌐</span> External
                                </label>
                                <label class="radio-option" id="radioInternal">
                                    <input type="radio" name="projType" value="internal">
                                    <span class="radio-icon">🏢</span> Internal
                                </label>
                            </div>
                        </div>
                        <div class="form-row span-2">
                            <label>Full Description <span class="opt">(optional)</span></label>
                            <textarea id="fDescription" rows="3" placeholder="Detailed project description, scope, objectives…"></textarea>
                        </div>
                    </div>

                    <!-- Internal multi-client section -->
                    <div id="multiClientSection" style="display:none;margin-bottom:22px;">
                        <div class="section-label">👥 Associated Clients <span
                                style="font-size:.7rem;font-weight:400;color:var(--muted);text-transform:none;letter-spacing:0">(Internal
                                projects may link to multiple clients)</span></div>
                        <div class="chip-field">
                            <div class="client-chips" id="chipBox"
                                onclick="document.getElementById('chipInput').focus()">
                                <input class="chip-input" id="chipInput" placeholder="Type to add clients…"
                                    oninput="filterChipDropdown()" onfocus="openChipDropdown()"
                                    onblur="closeChipDropdownDelay()">
                            </div>
                            <div class="chip-dropdown" id="chipDropdown"></div>
                        </div>
                        <div class="field-hint">Internal projects can be associated with one or more clients.</div>
                    </div>

                    <div class="section-label">📍 Location &amp; Timeline</div>
                    <div class="form-grid cols-3">
                        <div class="form-row span-3">
                            <label>Location <span class="req">*</span></label>
                            <input type="text" id="fLocation" placeholder="City, State / Region or Remote">
                            <div class="field-error" id="errLocation">Location is required</div>
                        </div>
                        <div class="form-row">
                            <label>Start Date <span class="req">*</span></label>
                            <input type="date" id="fStartDate">
                            <div class="field-error" id="errStartDate">Start date is required</div>
                        </div>
                        <div class="form-row">
                            <label>End Date <span class="req">*</span></label>
                            <input type="date" id="fEndDate">
                            <div class="field-error" id="errEndDate">End date is required</div>
                        </div>
                        <div class="form-row">
                            <label>Status <span class="req">*</span></label>
                            <select id="fStatus">
                                <option value="pending">Pending — Not yet started / Backlog</option>
                                <option value="open">Open — In Progress / Active</option>
                                <option value="hold">Hold — Temporarily paused</option>
                                <option value="closed">Closed — All work finished</option>
                                <option value="cancelled">Cancelled — Work stopped permanently</option>
                            </select>
                        </div>
                    </div>

                    <div class="section-label">💰 Budget</div>
                    <div class="form-grid">
                        <div class="form-row">
                            <label>Estimated Amount <span class="opt">(optional)</span></label>
                            <input type="number" id="fAmount" placeholder="0.00" min="0" step="0.01">
                            <div class="field-hint">Estimated monetary value of this project</div>
                        </div>
                        <div class="form-row">
                            <label>Currency</label>
                            <select id="fCurrency">
                                <option value="USD">USD — US Dollar</option>
                                <option value="EUR">EUR — Euro</option>
                                <option value="GBP">GBP — British Pound</option>
                                <option value="CAD">CAD — Canadian Dollar</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- TAB 1: GL Coding -->
                <div class="tab-panel" id="tab1">
                    <div class="role-info">
                        <span>🔒</span>
                        <span>Default GL coding is applied at the <strong>invoice header level</strong> and cascades to
                            all distribution lines. It can also be overridden per line item.</span>
                    </div>

                    <div class="section-label">🏦 Default Accounting GL Coding</div>
                    <div class="gl-section">
                        <div class="gl-grid">
                            <div class="form-row">
                                <label>Business Unit (BU) <span class="req">*</span></label>
                                <input type="text" id="fBU" placeholder="e.g. BU-100">
                                <div class="field-hint">Organizational business unit</div>
                            </div>
                            <div class="form-row">
                                <label>Operating Unit <span class="req">*</span></label>
                                <input type="text" id="fOU" placeholder="e.g. OP-200">
                                <div class="field-hint">Operational unit or cost center</div>
                            </div>
                            <div class="form-row">
                                <label>Department <span class="req">*</span></label>
                                <input type="text" id="fDept" placeholder="e.g. DEPT-300">
                                <div class="field-hint">Department code</div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:24px">
                        <div class="section-label">📄 Invoice &amp; Quote Coding Behavior</div>
                        <div
                            style="background:var(--cream);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px">
                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-label">Auto-apply Project ID at Invoice Header</div>
                                    <div class="toggle-sub">When creating an invoice, default the Project ID at header
                                        level to cascade GL coding to all line items</div>
                                </div>
                                <label class="toggle"><input type="checkbox" id="fAutoHeader" checked><span
                                        class="toggle-slider"></span></label>
                            </div>
                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-label">Allow Per-Line Project Override</div>
                                    <div class="toggle-sub">Users can assign a different Project ID on individual
                                        invoice line items for split-coded distributions</div>
                                </div>
                                <label class="toggle"><input type="checkbox" id="fLineOverride" checked><span
                                        class="toggle-slider"></span></label>
                            </div>
                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-label">Apply to Quotes</div>
                                    <div class="toggle-sub">Also default this project's GL coding when creating quotes
                                        linked to this project</div>
                                </div>
                                <label class="toggle"><input type="checkbox" id="fApplyQuotes" checked><span
                                        class="toggle-slider"></span></label>
                            </div>
                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-label">Apply to Document Uploads</div>
                                    <div class="toggle-sub">Tag uploaded documents with this project ID for subledger
                                        aggregation</div>
                                </div>
                                <label class="toggle"><input type="checkbox" id="fApplyDocs"><span
                                        class="toggle-slider"></span></label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: Team & Contacts -->
                <div class="tab-panel" id="tab2">
                    <div class="section-label">👤 Project Manager</div>
                    <div class="form-grid">
                        <div class="form-row">
                            <label>PM Name <span class="opt">(optional)</span></label>
                            <input type="text" id="fPMName" placeholder="Full name">
                        </div>
                        <div class="form-row">
                            <label>PM Email <span class="opt">(optional)</span></label>
                            <input type="email" id="fPMEmail" placeholder="pm@company.com">
                        </div>
                        <div class="form-row">
                            <label>PM Voice / Phone <span class="opt">(optional)</span></label>
                            <input type="text" id="fPMVoice" placeholder="+1 (555) 000-0000">
                            <div class="field-hint">Direct dial or office line</div>
                        </div>
                        <div class="form-row">
                            <label>PM SMS / Mobile <span class="opt">(optional)</span></label>
                            <input type="text" id="fPMSms" placeholder="+1 (555) 000-0000">
                            <div class="field-hint">Mobile number for text messages</div>
                        </div>
                    </div>

                    <div class="section-label" style="margin-top:8px">📞 Additional Contacts</div>
                    <div class="form-grid">
                        <div class="form-row">
                            <label>Secondary Contact</label>
                            <input type="text" id="fContact2" placeholder="Name">
                        </div>
                        <div class="form-row">
                            <label>Secondary Email</label>
                            <input type="email" id="fContact2Email" placeholder="email@company.com">
                        </div>
                        <div class="form-row">
                            <label>Secondary Voice</label>
                            <input type="text" id="fContact2Voice" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="form-row">
                            <label>Secondary SMS</label>
                            <input type="text" id="fContact2Sms" placeholder="+1 (555) 000-0000">
                        </div>
                    </div>

                    <div class="section-label" style="margin-top:8px">📊 Performance Benchmarks</div>
                    <div
                        style="background:var(--cream);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px">
                        <div class="form-grid cols-3">
                            <div class="form-row">
                                <label>Target On-Time %</label>
                                <input type="number" id="fTargetPct" placeholder="100" min="0"
                                    max="100" value="100">
                                <div class="field-hint">% of milestones on time</div>
                            </div>
                            <div class="form-row">
                                <label>Milestone Count</label>
                                <input type="number" id="fMilestones" placeholder="0" min="0"
                                    value="0">
                                <div class="field-hint">Total project milestones</div>
                            </div>
                            <div class="form-row">
                                <label>Priority</label>
                                <select id="fPriority">
                                    <option value="normal">Normal</option>
                                    <option value="high">High</option>
                                    <option value="critical">Critical</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: Settings -->
                <div class="tab-panel" id="tab3">
                    <div class="section-label">🔑 Access &amp; Visibility</div>
                    <div
                        style="background:var(--cream);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px">
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">Visible in Client Portal</div>
                                <div class="toggle-sub">Allow linked clients to see project status and progress in
                                    their portal</div>
                            </div>
                            <label class="toggle"><input type="checkbox" id="fPortalVisible"><span
                                    class="toggle-slider"></span></label>
                        </div>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">Lock GL Coding after First Invoice</div>
                                <div class="toggle-sub">Prevent GL code changes once the first invoice is posted
                                    against this project</div>
                            </div>
                            <label class="toggle"><input type="checkbox" id="fLockGL"><span
                                    class="toggle-slider"></span></label>
                        </div>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-label">Require Project ID on All Invoices</div>
                                <div class="toggle-sub">Mandate that every invoice linked to this client must carry a
                                    Project ID</div>
                            </div>
                            <label class="toggle"><input type="checkbox" id="fRequireID"><span
                                    class="toggle-slider"></span></label>
                        </div>
                    </div>

                    <div class="section-label" style="margin-top:24px">📝 Notes</div>
                    <textarea id="fNotes" rows="4" placeholder="Internal notes, special instructions, scope caveats…"></textarea>
                </div>

            </div><!-- /modal-body -->

            <div class="modal-footer">
                <div class="modal-footer-left">
                    <span>🔒</span> Admin &amp; Manager access only
                </div>
                <div class="modal-footer-right">
                    <button class="btn-secondary" onclick="closeModal()">Cancel</button>
                    <button class="btn-danger" id="btnDeleteProject" style="display:none"
                        onclick="deleteCurrentProject()">🗑 Delete</button>
                    <button class="btn-primary" onclick="saveProject()">💾 Save Project</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── DETAIL DRAWER ──────────────────────────────────── -->
    <div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
    <div class="drawer" id="detailDrawer">
        <div class="drawer-header">
            <div class="drawer-title-area">
                <div class="drawer-proj-id" id="drawerProjId">—</div>
                <div class="drawer-proj-name" id="drawerProjName">—</div>
            </div>
            <button class="drawer-close" onclick="closeDrawer()">✕</button>
        </div>
        <div class="drawer-body" id="drawerBody">
            <!-- populated by JS -->
        </div>
        <div class="drawer-footer">
            <button class="btn-primary" onclick="editFromDrawer()" style="flex:1">✏️ Edit Project</button>
            <button class="btn-secondary" onclick="toast('📋 Project ID copied!')">📋 Copy ID</button>
            <button class="btn-secondary" onclick="closeDrawer()">✕ Close</button>
        </div>
    </div>

    <!-- ─── PROJECT CLIENTS SUBPAGE MODAL ─────────────────── -->
    <div class="modal-overlay" id="clientsSubpageOverlay" onclick="handleClientsOverlayClick(event)">
        <div class="modal" id="clientsSubpageBox" style="max-width:560px">
            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-header-icon">👥</div>
                    <div>
                        <div class="modal-title" id="cspTitle">Project Clients</div>
                        <div class="modal-subtitle" id="cspSubtitle">Associated clients for this internal project
                        </div>
                    </div>
                </div>
                <button class="modal-close" onclick="closeClientsSubpage()">✕</button>
            </div>
            <div class="modal-body" style="padding:0">
                <div
                    style="padding:16px 28px 10px;background:var(--cream);border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                    <span class="type-badge type-internal" style="font-size:.72rem">iNT</span>
                    <span id="cspProjName"
                        style="font-family:'Syne',sans-serif;font-weight:700;font-size:.95rem;color:var(--slate)"></span>
                    <span id="cspClientCount" style="font-size:.75rem;color:var(--muted);margin-left:auto"></span>
                </div>
                <div style="overflow-x:auto">
                    <table style="width:100%;border-collapse:collapse" id="cspTable">
                        <thead>
                            <tr>
                                <th
                                    style="padding:11px 24px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);background:var(--cream);text-align:left;border-bottom:1px solid var(--border);white-space:nowrap">
                                    Client ID</th>
                                <th
                                    style="padding:11px 24px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);background:var(--cream);text-align:left;border-bottom:1px solid var(--border);white-space:nowrap">
                                    Client Name</th>
                                <th
                                    style="padding:11px 24px;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);background:var(--cream);text-align:left;border-bottom:1px solid var(--border);white-space:nowrap">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody id="cspBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="modal-footer-left" style="font-size:.78rem;color:var(--muted)">Internal projects may span
                    multiple clients</div>
                <div class="modal-footer-right">
                    <button class="btn-secondary" onclick="closeClientsSubpage()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ─── PM CONTACT CARD ────────────────────────────────── -->
    <div id="pmCard">
        <div class="pm-card-header">
            <div class="pm-card-avatar" id="pmCardAvatar">—</div>
            <div>
                <div class="pm-card-name" id="pmCardName">—</div>
                <div class="pm-card-role">Project Manager</div>
            </div>
        </div>
        <div class="pm-card-body" id="pmCardBody"></div>
        <div class="pm-card-footer" id="pmCardProject"></div>
    </div>

    <!-- ─── CLIENT COUNT TOOLTIP ───────────────────────────── -->
    <div id="clientTooltip"></div>
    <!-- ─── STATUS TOOLTIP ────────────────────────────────── -->
    <div id="statusTooltip"
        style="position:fixed;z-index:300;pointer-events:none;background:var(--slate);color:#fff;font-family:'DM Sans',sans-serif;font-size:.73rem;font-weight:500;padding:6px 12px;border-radius:6px;box-shadow:0 4px 14px rgba(0,0,0,.22);max-width:240px;line-height:1.45;opacity:0;transition:opacity .15s;white-space:normal">
    </div>

    <!-- ─── TOAST ──────────────────────────────────────────── -->
    <div id="toast">✅ <span id="toastMsg"></span></div>

    <!-- Mobile menu -->
    <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>

    <script>
        /* ─── DATA ────────────────────────────────────────────── */
        const CLIENTS_MAP = {
            'CLI001': 'Acme Corp',
            'CLI002': 'TechNova Ltd',
            'CLI003': 'Greenfield Inc',
            'CLI004': 'Stellar Media',
            'CLI005': 'Harbor Finance',
            'CLI006': 'Summit Partners',
            'INTERNAL': 'Internal'
        };

        let projects = [{
                id: 'WEBSITEV2',
                clientId: 'CLI001',
                clients: ['CLI001'],
                shortDesc: 'Website Redesign v2',
                desc: 'Full redesign of corporate website including UX overhaul, new CMS, and SEO optimization.',
                type: 'external',
                location: 'Los Angeles, CA',
                startDate: '2025-01-15',
                endDate: '2025-06-30',
                status: 'open',
                perf: 'on-time',
                amount: 125000,
                currency: 'USD',
                bu: 'BU-100',
                ou: 'OP-210',
                dept: 'MKTG-01',
                pmName: 'Sarah Chen',
                pmEmail: 'schen@acmecorp.com',
                pmVoice: '+1 (310) 555-0182',
                pmSms: '+1 (310) 555-0183',
                notes: '',
                priority: 'high',
                autoHeader: true,
                lineOverride: true,
                applyQuotes: true,
                applyDocs: false,
                portalVisible: true,
                lockGL: false,
                requireID: false
            },
            {
                id: 'INFRA2025',
                clientId: 'CLI002',
                clients: ['CLI002'],
                shortDesc: 'Cloud Infrastructure Upgrade',
                desc: 'Migrate on-prem servers to AWS. Includes VPC setup, CI/CD pipelines, and staff training.',
                type: 'external',
                location: 'Remote',
                startDate: '2025-03-01',
                endDate: '2025-09-30',
                status: 'hold',
                perf: 'behind',
                amount: 480000,
                currency: 'USD',
                bu: 'BU-200',
                ou: 'OP-220',
                dept: 'ENG-02',
                pmName: 'James Okonkwo',
                pmEmail: 'jokonkwo@technova.com',
                pmVoice: '+1 (415) 555-0244',
                pmSms: '+1 (415) 555-0245',
                notes: 'Blocked on security audit clearance.',
                priority: 'critical',
                autoHeader: true,
                lineOverride: true,
                applyQuotes: true,
                applyDocs: true,
                portalVisible: false,
                lockGL: true,
                requireID: true
            },
            {
                id: 'MKTCMPGN',
                clientId: 'CLI004',
                clients: ['CLI004'],
                shortDesc: 'Q3 Marketing Campaign',
                desc: 'Full-funnel digital campaign for Q3 product launch.',
                type: 'external',
                location: 'New York, NY',
                startDate: '2025-07-01',
                endDate: '2025-09-30',
                status: 'open',
                perf: 'just-in-time',
                amount: 95000,
                currency: 'USD',
                bu: 'BU-100',
                ou: 'OP-210',
                dept: 'MKTG-03',
                pmName: 'Lisa Huang',
                pmEmail: 'lhuang@stellarmedia.com',
                notes: '',
                priority: 'high',
                autoHeader: true,
                lineOverride: false,
                applyQuotes: true,
                applyDocs: false,
                portalVisible: true,
                lockGL: false,
                requireID: false
            },
            {
                id: 'FINAUDIT',
                clientId: 'CLI005',
                clients: ['CLI005'],
                shortDesc: 'Annual Financial Audit Support',
                desc: 'Provide data, reconciliations and documentation for annual audit cycle.',
                type: 'external',
                location: 'Chicago, IL',
                startDate: '2025-01-01',
                endDate: '2025-03-31',
                status: 'closed',
                perf: 'on-time',
                amount: 60000,
                currency: 'USD',
                bu: 'BU-300',
                ou: 'OP-310',
                dept: 'FIN-01',
                pmName: 'Derek Walsh',
                pmEmail: 'dwalsh@harborfinance.com',
                notes: 'Completed on schedule.',
                priority: 'normal',
                autoHeader: true,
                lineOverride: true,
                applyQuotes: false,
                applyDocs: true,
                portalVisible: false,
                lockGL: true,
                requireID: false
            },
            {
                id: 'INTOPS01',
                clientId: 'INTERNAL',
                clients: ['CLI001', 'CLI003', 'CLI005'],
                shortDesc: 'Internal Ops Modernisation',
                desc: 'Upgrade internal tooling, workflows, and automations to improve team efficiency across multiple client engagements.',
                type: 'internal',
                location: 'Remote',
                startDate: '2025-02-01',
                endDate: '2025-12-31',
                status: 'open',
                perf: 'on-time',
                amount: 200000,
                currency: 'USD',
                bu: 'BU-400',
                ou: 'OP-400',
                dept: 'OPS-01',
                pmName: 'Alex Torres',
                pmEmail: 'atorres@company.com',
                pmVoice: '+1 (512) 555-0391',
                pmSms: '+1 (512) 555-0392',
                notes: 'Multi-client ops alignment project.',
                priority: 'normal',
                autoHeader: true,
                lineOverride: true,
                applyQuotes: true,
                applyDocs: true,
                portalVisible: false,
                lockGL: false,
                requireID: true
            },
            {
                id: 'CRMIMPL',
                clientId: 'CLI006',
                clients: ['CLI006'],
                shortDesc: 'CRM Implementation',
                desc: 'Salesforce CRM rollout including data migration, integrations, and end-user training.',
                type: 'external',
                location: 'Austin, TX',
                startDate: '2025-04-01',
                endDate: '2025-10-31',
                status: 'hold',
                perf: 'behind',
                amount: 340000,
                currency: 'USD',
                bu: 'BU-200',
                ou: 'OP-230',
                dept: 'ENG-04',
                pmName: 'Priya Nair',
                pmEmail: 'pnair@summitpartners.com',
                notes: 'Integration delays with legacy ERP.',
                priority: 'critical',
                autoHeader: true,
                lineOverride: true,
                applyQuotes: true,
                applyDocs: true,
                portalVisible: true,
                lockGL: false,
                requireID: true
            },
            {
                id: 'GREENRPT',
                clientId: 'CLI003',
                clients: ['CLI003'],
                shortDesc: 'ESG Reporting 2025',
                desc: 'Annual sustainability and ESG reporting package for regulatory compliance.',
                type: 'external',
                location: 'Denver, CO',
                startDate: '2025-05-01',
                endDate: '2025-07-31',
                status: 'open',
                perf: 'on-time',
                amount: 45000,
                currency: 'USD',
                bu: 'BU-300',
                ou: 'OP-320',
                dept: 'COMP-02',
                pmName: 'Hannah Moore',
                pmEmail: 'hmoore@greenfieldinc.com',
                notes: '',
                priority: 'normal',
                autoHeader: false,
                lineOverride: true,
                applyQuotes: false,
                applyDocs: true,
                portalVisible: false,
                lockGL: false,
                requireID: false
            },
            {
                id: 'INTTRAIN',
                clientId: 'INTERNAL',
                clients: ['CLI001', 'CLI002', 'CLI004', 'CLI006'],
                shortDesc: 'Staff Training Initiative',
                desc: 'Cross-functional training program covering new billing system and project management tools.',
                type: 'internal',
                location: 'Remote',
                startDate: '2025-01-01',
                endDate: '2025-06-30',
                status: 'closed',
                perf: 'just-in-time',
                amount: 30000,
                currency: 'USD',
                bu: 'BU-400',
                ou: 'OP-410',
                dept: 'HR-01',
                pmName: 'Marco Lee',
                pmEmail: 'mlee@company.com',
                notes: 'Completed June 2025.',
                priority: 'low',
                autoHeader: false,
                lineOverride: false,
                applyQuotes: false,
                applyDocs: false,
                portalVisible: false,
                lockGL: false,
                requireID: false
            },
            {
                id: 'PORTDEV1',
                clientId: 'CLI001',
                clients: ['CLI001'],
                shortDesc: 'Client Portal Development',
                desc: 'Build bespoke self-service portal for Acme Corp with real-time invoice access.',
                type: 'external',
                location: 'Los Angeles, CA',
                startDate: '2025-06-01',
                endDate: '2026-01-31',
                status: 'open',
                perf: 'on-time',
                amount: 220000,
                currency: 'USD',
                bu: 'BU-200',
                ou: 'OP-240',
                dept: 'ENG-05',
                pmName: 'Sarah Chen',
                pmEmail: 'schen@acmecorp.com',
                notes: '',
                priority: 'high',
                autoHeader: true,
                lineOverride: true,
                applyQuotes: true,
                applyDocs: true,
                portalVisible: true,
                lockGL: false,
                requireID: true
            },
            {
                id: 'DATAMIGRN',
                clientId: 'CLI002',
                clients: ['CLI002'],
                shortDesc: 'Legacy Data Migration',
                desc: 'Extract, clean, and migrate 8 years of legacy billing data into new system.',
                type: 'external',
                location: 'Remote',
                startDate: '2025-08-01',
                endDate: '2025-11-30',
                status: 'pending',
                perf: 'on-time',
                amount: 175000,
                currency: 'USD',
                bu: 'BU-200',
                ou: 'OP-250',
                dept: 'ENG-06',
                pmName: 'James Okonkwo',
                pmEmail: 'jokonkwo@technova.com',
                notes: '',
                priority: 'high',
                autoHeader: true,
                lineOverride: true,
                applyQuotes: false,
                applyDocs: true,
                portalVisible: false,
                lockGL: false,
                requireID: true
            },
            {
                id: 'SECAUDIT',
                clientId: 'CLI005',
                clients: ['CLI005'],
                shortDesc: 'Cybersecurity Audit',
                desc: 'Comprehensive pen-testing, vulnerability assessment, and compliance review.',
                type: 'external',
                location: 'Chicago, IL',
                startDate: '2025-09-01',
                endDate: '2026-02-28',
                status: 'open',
                perf: 'on-time',
                amount: 620000,
                currency: 'USD',
                bu: 'BU-300',
                ou: 'OP-330',
                dept: 'SEC-01',
                pmName: 'Derek Walsh',
                pmEmail: 'dwalsh@harborfinance.com',
                notes: '',
                priority: 'critical',
                autoHeader: true,
                lineOverride: true,
                applyQuotes: true,
                applyDocs: true,
                portalVisible: false,
                lockGL: true,
                requireID: true
            }
        ];

        let filteredProjects = [...projects];
        let currentFilter = 'all';
        let currentSearch = '';
        let editingId = null;
        let drawerProject = null;

        /* ─── STATUS META ─────────────────────────────────────── */
        const STATUS_META = {
            pending: {
                label: 'Pending',
                cls: 'status-pending',
                tip: 'Not Open — Started / Backlog: Approved but not yet begun.'
            },
            open: {
                label: 'Open',
                cls: 'status-open',
                tip: 'Active — In Progress: Currently being worked on.'
            },
            hold: {
                label: 'Hold',
                cls: 'status-hold',
                tip: 'On Hold / Pending: Temporarily paused.'
            },
            closed: {
                label: 'Closed',
                cls: 'status-closed',
                tip: 'Completed / Done: All work finished.'
            },
            cancelled: {
                label: 'Cancelled',
                cls: 'status-cancelled',
                tip: 'Archived: Work stopped permanently.'
            }
        };

        function statusBadge(status) {
            const s = STATUS_META[status] || STATUS_META['open'];
            return `<span class="status-badge ${s.cls}" title="${s.tip}" onmouseenter="showStatusTooltip(event,'${s.tip.replace(/'/g,"&#39;")}')" onmouseleave="hideStatusTooltip()">${s.label}</span>`;
        }

        /* ─── RENDER TABLE ────────────────────────────────────── */
        function renderTable() {
            const tbody = document.getElementById('projectBody');
            tbody.innerHTML = '';
            if (!filteredProjects.length) {
                document.getElementById('emptyState').style.display = 'block';
                document.getElementById('tableFooterLabel').textContent = 'No projects found';
                return;
            }
            document.getElementById('emptyState').style.display = 'none';
            document.getElementById('tableFooterLabel').textContent =
                `Showing ${filteredProjects.length} of ${projects.length} projects`;

            filteredProjects.forEach(p => {
                const isMulti = p.type === 'internal' && p.clients.length > 1;
                const firstClientName = CLIENTS_MAP[p.clients[0]] || p.clients[0];
                const clientCell = isMulti ?
                    `<button class="client-multi-link" onclick="openClientsSubpage(event,'${p.id}')" title="${p.clients.length} clients linked" onmouseenter="showClientTooltip(event,${p.clients.length})" onmouseleave="hideClientTooltip()">.....</button>` :
                    `<span class="client-tag">${firstClientName}</span>`;
                const graphIcon = (color) =>
                    `<svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0"><polyline points="1,10 4,6 7,8 10,3 13,5 15,2" stroke="${color}" stroke-width="1.7" stroke-linejoin="round" stroke-linecap="round" fill="none"/></svg>`;
                const perfMap = {
                    'on-time': `<span class="perf-badge perf-on-time">${graphIcon('var(--teal-dark)')} On Time</span>`,
                    'behind': `<span class="perf-badge perf-behind">${graphIcon('var(--red-soft)')} Behind</span>`,
                    'ahead': `<span class="perf-badge perf-ahead">${graphIcon('#b56a00')} Ahead</span>`,
                    'just-in-time': `<span class="perf-badge perf-just-in-time">${graphIcon('var(--violet)')} Just-In-Time</span>`
                };
                const tr = document.createElement('tr');
                tr.innerHTML = `
      <td class="cb-cell"><input type="checkbox" onclick="event.stopPropagation()"></td>
      <td><div class="proj-id">${p.id}</div></td>
      <td>
        <div class="proj-name">${p.shortDesc}</div>
        <div class="proj-desc">${p.desc}</div>
      </td>
      <td><span class="type-badge ${p.type === 'internal' ? 'type-internal' : 'type-external'}">${p.type === 'internal' ? 'iNT' : 'CLT'}</span></td>
      <td>${clientCell}</td>
      <td>${statusBadge(p.status)}</td>
      <td>${perfMap[p.perf] || '—'}</td>
      <td class="date-cell">${p.startDate}</td>
      <td class="date-cell">${p.endDate}</td>
      <td class="amount-cell">${p.amount ? formatAmount(p.amount, p.currency) : '—'}</td>
      <td class="pm-cell" onclick="event.stopPropagation()">
        ${p.pmName
          ? `<div class="pm-name" onclick="openPMCard(event,'${p.id}')">${p.pmName}</div><div class="pm-email">${p.pmEmail || ''}</div>`
          : `<div class="pm-name empty" style="color:var(--muted);font-weight:400">—</div>`
        }
      </td>
      <td>
        <div class="dropdown-wrap">
          <button class="action-menu-btn" onclick="toggleDropdown(event,'dd_${p.id}')">⋯</button>
          <div class="dropdown-menu" id="dd_${p.id}">
            <div class="dropdown-item" onclick="viewProject('${p.id}')"><span class="di-icon">👁</span> View Details</div>
            <div class="dropdown-item" onclick="editProject('${p.id}')"><span class="di-icon">✏️</span> Edit</div>
            <div class="dropdown-item" onclick="toast('📋 ${p.id} copied to clipboard!')"><span class="di-icon">📋</span> Copy ID</div>
            <div class="dropdown-divider"></div>
            <div class="dropdown-item danger" onclick="confirmDelete('${p.id}')"><span class="di-icon">🗑</span> Delete</div>
          </div>
        </div>
      </td>
    `;
                tr.addEventListener('click', (e) => {
                    if (e.target.closest('input[type="checkbox"]') || e.target.closest('.dropdown-wrap'))
                        return;
                    viewProject(p.id);
                });
                tbody.appendChild(tr);
            });
        }

        function formatAmount(n, currency = 'USD') {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency,
                maximumFractionDigits: 0
            }).format(n);
        }

        /* ─── FILTER ──────────────────────────────────────────── */
        function setFilter(f) {
            currentFilter = f;
            applyFilter();
        }

        function filterProjects() {
            currentSearch = document.getElementById('searchInput').value.toLowerCase();
            applyFilter();
        }

        function applyFilter() {
            filteredProjects = projects.filter(p => {
                const matchSearch = !currentSearch ||
                    p.id.toLowerCase().includes(currentSearch) ||
                    p.shortDesc.toLowerCase().includes(currentSearch) ||
                    p.desc.toLowerCase().includes(currentSearch) ||
                    p.clients.some(c => (CLIENTS_MAP[c] || '').toLowerCase().includes(currentSearch)) ||
                    (p.pmName || '').toLowerCase().includes(currentSearch);
                const matchFilter =
                    currentFilter === 'all' ? true :
                    currentFilter === 'external' ? p.type === 'external' :
                    currentFilter === 'internal' ? p.type === 'internal' :
                    currentFilter === 'behind' ? p.perf === 'behind' :
                    p.status === currentFilter;
                return matchSearch && matchFilter;
            });
            _applySortAndRender();
        }

        let sortKey = 'id';
        let sortDir = 'asc';

        function sortProjects(key) {
            if (sortKey === key) {
                sortDir = sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                sortKey = key;
                sortDir = 'asc';
            }
            _applySortAndRender();
        }

        function _applySortAndRender() {
            const dir = sortDir === 'asc' ? 1 : -1;
            filteredProjects.sort((a, b) => {
                let va, vb;
                switch (sortKey) {
                    case 'id':
                        va = a.id;
                        vb = b.id;
                        break;
                    case 'name':
                        va = a.shortDesc;
                        vb = b.shortDesc;
                        break;
                    case 'type':
                        va = a.type;
                        vb = b.type;
                        break;
                    case 'client':
                        va = (CLIENTS_MAP[a.clients[0]] || a.clients[0]);
                        vb = (CLIENTS_MAP[b.clients[0]] || b.clients[0]);
                        break;
                    case 'status':
                        va = a.status;
                        vb = b.status;
                        break;
                    case 'perf':
                        va = a.perf;
                        vb = b.perf;
                        break;
                    case 'start':
                        va = a.startDate;
                        vb = b.startDate;
                        break;
                    case 'end':
                        va = a.endDate;
                        vb = b.endDate;
                        break;
                    case 'budget':
                        va = a.amount || 0;
                        vb = b.amount || 0;
                        break;
                    case 'pm':
                        va = a.pmName || '';
                        vb = b.pmName || '';
                        break;
                    default:
                        return 0;
                }
                if (typeof va === 'number') return (va - vb) * dir;
                return va.localeCompare(vb) * dir;
            });
            _updateSortHeaders();
            renderTable();
        }

        function _updateSortHeaders() {
            document.querySelectorAll('thead th[data-col]').forEach(th => {
                th.classList.remove('sorted', 'sort-asc', 'sort-desc');
                if (th.dataset.col === sortKey) {
                    th.classList.add('sorted', sortDir === 'asc' ? 'sort-asc' : 'sort-desc');
                }
            });
        }

        // Wire header clicks once DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('thead th[data-col]').forEach(th => {
                th.addEventListener('click', () => sortProjects(th.dataset.col));
            });
        });

        /* ─── CREATE MODAL ────────────────────────────────────── */
        function openCreateModal() {
            editingId = null;
            document.getElementById('modalTitle').textContent = 'New Project';
            document.getElementById('modalSubtitle').textContent = 'Admin & Manager access required';
            document.getElementById('btnDeleteProject').style.display = 'none';
            resetForm();
            switchTab(0, document.querySelectorAll('.modal-tab')[0]);
            document.getElementById('projectModal').classList.add('open');
        }

        function editProject(id) {
            closeDropdowns();
            const p = projects.find(x => x.id === id);
            if (!p) return;
            editingId = id;
            document.getElementById('modalTitle').textContent = `Edit Project — ${id}`;
            document.getElementById('modalSubtitle').textContent = 'Modifying existing project';
            document.getElementById('btnDeleteProject').style.display = 'inline-flex';
            populateForm(p);
            switchTab(0, document.querySelectorAll('.modal-tab')[0]);
            document.getElementById('projectModal').classList.add('open');
        }

        function closeModal() {
            document.getElementById('projectModal').classList.remove('open');
        }

        function handleModalClick(e) {
            if (e.target === e.currentTarget) closeModal();
        }

        function resetForm() {
            ['fProjectId', 'fShortDesc', 'fDescription', 'fLocation', 'fStartDate', 'fEndDate',
                'fPMName', 'fPMEmail', 'fPMVoice', 'fPMSms', 'fContact2', 'fContact2Email', 'fContact2Voice',
                'fContact2Sms', 'fNotes',
                'fBU', 'fOU', 'fDept'
            ].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            document.getElementById('fAmount').value = '';
            document.getElementById('fStatus').value = 'pending';
            document.getElementById('fCurrency').value = 'USD';
            document.getElementById('fPriority').value = 'normal';
            document.getElementById('fTargetPct').value = '100';
            document.getElementById('fMilestones').value = '0';
            document.getElementById('fClientId').value = '';
            document.getElementById('fAutoHeader').checked = true;
            document.getElementById('fLineOverride').checked = true;
            document.getElementById('fApplyQuotes').checked = true;
            document.getElementById('fApplyDocs').checked = false;
            document.getElementById('fPortalVisible').checked = false;
            document.getElementById('fLockGL').checked = false;
            document.getElementById('fRequireID').checked = false;
            setProjectType('external');
            clearChips();
            idCounter();
            shortDescCounter();
            document.querySelectorAll('.field-error').forEach(el => el.classList.remove('visible'));
            document.querySelectorAll('input.error').forEach(el => el.classList.remove('error'));
        }

        function populateForm(p) {
            document.getElementById('fProjectId').value = p.id;
            document.getElementById('fClientId').value = p.clientId;
            document.getElementById('fShortDesc').value = p.shortDesc;
            document.getElementById('fDescription').value = p.desc || '';
            document.getElementById('fLocation').value = p.location;
            document.getElementById('fStartDate').value = p.startDate;
            document.getElementById('fEndDate').value = p.endDate;
            document.getElementById('fStatus').value = p.status;
            document.getElementById('fAmount').value = p.amount || '';
            document.getElementById('fCurrency').value = p.currency || 'USD';
            document.getElementById('fBU').value = p.bu;
            document.getElementById('fOU').value = p.ou;
            document.getElementById('fDept').value = p.dept;
            document.getElementById('fPMName').value = p.pmName || '';
            document.getElementById('fPMEmail').value = p.pmEmail || '';
            document.getElementById('fPMVoice').value = p.pmVoice || '';
            document.getElementById('fPMSms').value = p.pmSms || '';
            document.getElementById('fNotes').value = p.notes || '';
            document.getElementById('fPriority').value = p.priority || 'normal';
            document.getElementById('fAutoHeader').checked = p.autoHeader;
            document.getElementById('fLineOverride').checked = p.lineOverride;
            document.getElementById('fApplyQuotes').checked = p.applyQuotes;
            document.getElementById('fApplyDocs').checked = p.applyDocs;
            document.getElementById('fPortalVisible').checked = p.portalVisible;
            document.getElementById('fLockGL').checked = p.lockGL;
            document.getElementById('fRequireID').checked = p.requireID;
            setProjectType(p.type);
            if (p.type === 'internal') {
                clearChips();
                p.clients.filter(c => c !== 'INTERNAL').forEach(c => addChip(c, CLIENTS_MAP[c] || c));
            }
            idCounter();
            shortDescCounter();
        }

        /* ─── FORM VALIDATION & SAVE ──────────────────────────── */
        function saveProject() {
            let valid = true;

            function validate(fieldId, errId, condition) {
                const field = document.getElementById(fieldId);
                const err = document.getElementById(errId);
                if (!condition) {
                    field.classList.add('error');
                    err.classList.add('visible');
                    valid = false;
                } else {
                    field.classList.remove('error');
                    err.classList.remove('visible');
                }
            }
            const pid = document.getElementById('fProjectId').value.trim();
            validate('fProjectId', 'errProjectId', pid.length > 0 && pid.length <= 10);
            validate('fClientId', 'errClientId', document.getElementById('fClientId').value !== '');
            validate('fShortDesc', 'errShortDesc', document.getElementById('fShortDesc').value.trim().length > 0);
            validate('fLocation', 'errLocation', document.getElementById('fLocation').value.trim().length > 0);
            validate('fStartDate', 'errStartDate', document.getElementById('fStartDate').value !== '');
            validate('fEndDate', 'errEndDate', document.getElementById('fEndDate').value !== '');

            if (!valid) {
                switchTab(0, document.querySelectorAll('.modal-tab')[0]);
                return;
            }

            const type = document.querySelector('input[name="projType"]:checked').value;
            const clientId = document.getElementById('fClientId').value;
            let clients = type === 'internal' ? getChips() : [clientId];
            if (!clients.length) clients = [clientId];

            const proj = {
                id: pid.toUpperCase(),
                clientId,
                clients,
                shortDesc: document.getElementById('fShortDesc').value.trim(),
                desc: document.getElementById('fDescription').value.trim(),
                type,
                location: document.getElementById('fLocation').value.trim(),
                startDate: document.getElementById('fStartDate').value,
                endDate: document.getElementById('fEndDate').value,
                status: document.getElementById('fStatus').value,
                perf: 'on-time',
                amount: parseFloat(document.getElementById('fAmount').value) || 0,
                currency: document.getElementById('fCurrency').value,
                bu: document.getElementById('fBU').value.trim(),
                ou: document.getElementById('fOU').value.trim(),
                dept: document.getElementById('fDept').value.trim(),
                pmName: document.getElementById('fPMName').value.trim(),
                pmEmail: document.getElementById('fPMEmail').value.trim(),
                pmVoice: document.getElementById('fPMVoice').value.trim(),
                pmSms: document.getElementById('fPMSms').value.trim(),
                notes: document.getElementById('fNotes').value.trim(),
                priority: document.getElementById('fPriority').value,
                autoHeader: document.getElementById('fAutoHeader').checked,
                lineOverride: document.getElementById('fLineOverride').checked,
                applyQuotes: document.getElementById('fApplyQuotes').checked,
                applyDocs: document.getElementById('fApplyDocs').checked,
                portalVisible: document.getElementById('fPortalVisible').checked,
                lockGL: document.getElementById('fLockGL').checked,
                requireID: document.getElementById('fRequireID').checked
            };

            if (editingId) {
                const idx = projects.findIndex(p => p.id === editingId);
                if (idx > -1) projects[idx] = proj;
                toast('✅ Project updated successfully');
            } else {
                const exists = projects.find(p => p.id === proj.id);
                if (exists) {
                    toast('⚠️ Project ID already exists');
                    return;
                }
                projects.unshift(proj);
                toast('🎉 Project created successfully');
            }

            closeModal();
            applyFilter();
        }

        function deleteCurrentProject() {
            if (!editingId) return;
            if (confirm(`Delete project ${editingId}? This action cannot be undone.`)) {
                projects = projects.filter(p => p.id !== editingId);
                closeModal();
                applyFilter();
                toast('🗑 Project deleted');
            }
        }

        function confirmDelete(id) {
            closeDropdowns();
            if (confirm(`Delete project ${id}? This action cannot be undone.`)) {
                projects = projects.filter(p => p.id !== id);
                applyFilter();
                toast('🗑 Project deleted');
            }
        }

        /* ─── TABS ────────────────────────────────────────────── */
        function switchTab(idx, el) {
            document.querySelectorAll('.modal-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('tab' + idx).classList.add('active');
        }

        /* ─── PROJECT TYPE TOGGLE ─────────────────────────────── */
        function setProjectType(type) {
            const rExt = document.getElementById('radioExternal');
            const rInt = document.getElementById('radioInternal');
            const multi = document.getElementById('multiClientSection');
            if (type === 'internal') {
                rExt.classList.remove('selected');
                rInt.classList.add('selected');
                rInt.querySelector('input').checked = true;
                multi.style.display = 'block';
            } else {
                rInt.classList.remove('selected');
                rExt.classList.add('selected');
                rExt.querySelector('input').checked = true;
                multi.style.display = 'none';
            }
        }
        document.querySelectorAll('.radio-option').forEach(opt => {
            opt.addEventListener('click', () => {
                const val = opt.querySelector('input').value;
                setProjectType(val);
            });
        });

        function handleClientChange() {
            // no special logic needed for single client
        }

        /* ─── COUNTERS ────────────────────────────────────────── */
        function idCounter() {
            const v = document.getElementById('fProjectId').value.length;
            const el = document.getElementById('idCounter');
            el.textContent = `${v} / 10`;
            el.className = 'char-counter' + (v >= 10 ? ' over' : v >= 8 ? ' warn' : '');
        }

        function shortDescCounter() {
            const v = document.getElementById('fShortDesc').value.length;
            const el = document.getElementById('shortDescCounter');
            el.textContent = `${v} / 50`;
            el.className = 'char-counter' + (v >= 50 ? ' over' : v >= 40 ? ' warn' : '');
        }

        /* ─── CHIP MULTI-SELECT ───────────────────────────────── */
        const clientOptions = Object.entries(CLIENTS_MAP).filter(([k]) => k !== 'INTERNAL');
        let chips = [];

        function clearChips() {
            chips = [];
            const box = document.getElementById('chipBox');
            box.querySelectorAll('.chip').forEach(c => c.remove());
        }

        function getChips() {
            return chips;
        }

        function addChip(id, label) {
            if (chips.includes(id)) return;
            chips.push(id);
            const box = document.getElementById('chipBox');
            const c = document.createElement('span');
            c.className = 'chip';
            c.dataset.id = id;
            c.innerHTML = `${label} <span class="chip-remove" onclick="removeChip('${id}')">×</span>`;
            box.insertBefore(c, document.getElementById('chipInput'));
        }

        function removeChip(id) {
            chips = chips.filter(c => c !== id);
            const box = document.getElementById('chipBox');
            box.querySelector(`.chip[data-id="${id}"]`)?.remove();
        }

        function filterChipDropdown() {
            const q = document.getElementById('chipInput').value.toLowerCase();
            renderChipDropdown(q);
        }

        function openChipDropdown() {
            renderChipDropdown('');
        }

        function renderChipDropdown(q) {
            const dd = document.getElementById('chipDropdown');
            dd.innerHTML = '';
            clientOptions.filter(([id, name]) => (!q || name.toLowerCase().includes(q) || id.toLowerCase().includes(q)) && !
                    chips.includes(id))
                .forEach(([id, name]) => {
                    const div = document.createElement('div');
                    div.className = 'chip-option';
                    div.textContent = `${id} · ${name}`;
                    div.onmousedown = (e) => {
                        e.preventDefault();
                        addChip(id, name);
                        document.getElementById('chipInput').value = '';
                        renderChipDropdown('');
                    };
                    dd.appendChild(div);
                });
            dd.classList.toggle('open', dd.children.length > 0);
        }

        function closeChipDropdownDelay() {
            setTimeout(() => document.getElementById('chipDropdown').classList.remove('open'), 200);
        }

        /* ─── DETAIL DRAWER ───────────────────────────────────── */
        function viewProject(id) {
            closeDropdowns();
            const p = projects.find(x => x.id === id);
            if (!p) return;
            drawerProject = p;
            document.getElementById('drawerProjId').textContent = p.id;
            document.getElementById('drawerProjName').textContent = p.shortDesc;

            const clientNames = p.clients.map(c => CLIENTS_MAP[c] || c).join(', ');
            const perfLabels = {
                'on-time': '✅ On Time',
                'behind': '⚠️ Behind Schedule',
                'ahead': '⚡ Ahead of Schedule',
                'just-in-time': '⏱ Just-In-Time'
            };

            // Calculate timeline progress
            const start = new Date(p.startDate),
                end = new Date(p.endDate),
                now = new Date();
            const total = end - start,
                elapsed = Math.min(Math.max(now - start, 0), total);
            const pct = total > 0 ? Math.round((elapsed / total) * 100) : 0;
            const fillClass = p.perf === 'behind' ? 'danger' : p.perf === 'just-in-time' ? 'warn' : '';

            document.getElementById('drawerBody').innerHTML = `
    <div class="drawer-section">
      <div class="drawer-section-title">Project Overview</div>
      <p style="font-size:.85rem;color:var(--muted);margin-bottom:14px">${p.desc || 'No description provided.'}</p>
      <div class="info-grid">
        <div class="info-item"><div class="info-key">Type</div><div class="info-val">${p.type === 'internal' ? '🏢 Internal' : '🌐 External'}</div></div>
        <div class="info-item"><div class="info-key">Status</div><div class="info-val">${STATUS_META[p.status]?.label || p.status}</div></div>
        <div class="info-item"><div class="info-key">Client(s)</div><div class="info-val">${clientNames}</div></div>
        <div class="info-item"><div class="info-key">Location</div><div class="info-val">${p.location}</div></div>
        <div class="info-item"><div class="info-key">Performance</div><div class="info-val">${perfLabels[p.perf] || '—'}</div></div>
        <div class="info-item"><div class="info-key">Priority</div><div class="info-val">${p.priority?.charAt(0).toUpperCase() + p.priority?.slice(1) || 'Normal'}</div></div>
        <div class="info-item"><div class="info-key">Est. Budget</div><div class="info-val" style="font-weight:700;color:var(--slate)">${p.amount ? formatAmount(p.amount, p.currency) : '—'}</div></div>
      </div>
    </div>
    <div class="drawer-section">
      <div class="drawer-section-title">Timeline</div>
      <div class="info-grid">
        <div class="info-item"><div class="info-key">Start Date</div><div class="info-val">${p.startDate}</div></div>
        <div class="info-item"><div class="info-key">End Date</div><div class="info-val">${p.endDate}</div></div>
      </div>
      <div class="progress-wrap">
        <div class="progress-label"><span style="font-size:.73rem;color:var(--muted)">Progress</span><span style="font-size:.73rem;font-weight:700;color:var(--slate)">${pct}%</span></div>
        <div class="progress-bar"><div class="progress-fill ${fillClass}" style="width:${pct}%"></div></div>
      </div>
    </div>
    <div class="drawer-section">
      <div class="drawer-section-title">Default GL Coding</div>
      <div class="info-grid">
        <div class="info-item"><div class="info-key">Business Unit</div><div class="info-val" style="font-family:monospace">${p.bu || '—'}</div></div>
        <div class="info-item"><div class="info-key">Operating Unit</div><div class="info-val" style="font-family:monospace">${p.ou || '—'}</div></div>
        <div class="info-item"><div class="info-key">Department</div><div class="info-val" style="font-family:monospace">${p.dept || '—'}</div></div>
      </div>
      <div style="margin-top:12px;font-size:.76rem;color:var(--muted);background:var(--cream);padding:10px 12px;border-radius:8px;border:1px solid var(--border)">
        ${p.autoHeader ? '✅ Auto-applied at invoice header · ' : '❌ No auto-header · '}
        ${p.lineOverride ? '✅ Per-line override allowed' : '❌ Line override locked'}
      </div>
    </div>
    <div class="drawer-section">
      <div class="drawer-section-title">Project Manager</div>
      <div class="info-grid">
        <div class="info-item"><div class="info-key">Name</div><div class="info-val">${p.pmName || '—'}</div></div>
        <div class="info-item"><div class="info-key">Email</div><div class="info-val" style="word-break:break-all">${p.pmEmail || '—'}</div></div>
        <div class="info-item"><div class="info-key">Voice</div><div class="info-val">${p.pmVoice || '—'}</div></div>
        <div class="info-item"><div class="info-key">SMS</div><div class="info-val">${p.pmSms || '—'}</div></div>
      </div>
    </div>
    
    ${p.notes ? `<div class="drawer-section"><div class="drawer-section-title">Notes</div><p style="font-size:.82rem;color:var(--muted)">${p.notes}</p></div>` : ''}
  `;
            document.getElementById('drawerOverlay').classList.add('open');
            document.getElementById('detailDrawer').classList.add('open');
        }

        function closeDrawer() {
            document.getElementById('drawerOverlay').classList.remove('open');
            document.getElementById('detailDrawer').classList.remove('open');
            drawerProject = null;
        }

        function editFromDrawer() {
            if (!drawerProject) return;
            closeDrawer();
            editProject(drawerProject.id);
        }

        /* ─── DROPDOWN MENUS ──────────────────────────────────── */
        function toggleDropdown(e, id) {
            e.stopPropagation();
            closeDropdowns();
            document.getElementById(id)?.classList.add('open');
        }

        function closeDropdowns() {
            document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('open'));
        }
        document.addEventListener('click', closeDropdowns);

        /* ─── SELECT ALL ──────────────────────────────────────── */
        function toggleAll(cb) {
            document.querySelectorAll('#projectBody input[type="checkbox"]').forEach(c => c.checked = cb.checked);
        }

        /* ─── TOAST ───────────────────────────────────────────── */
        function toast(msg) {
            const t = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            t.style.opacity = '1';
            t.style.transform = 'translateX(-50%) translateY(0)';
            setTimeout(() => {
                t.style.opacity = '0';
                t.style.transform = 'translateX(-50%) translateY(80px)';
            }, 2800);
        }

        /* ─── PM CONTACT CARD ─────────────────────────────────── */
        function openPMCard(e, projId) {
            e.stopPropagation();
            const p = projects.find(x => x.id === projId);
            if (!p || !p.pmName) return;

            const initials = p.pmName.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
            document.getElementById('pmCardAvatar').textContent = initials;
            document.getElementById('pmCardName').textContent = p.pmName;
            document.getElementById('pmCardProject').textContent = `${p.id} — ${p.shortDesc}`;

            // Build only rows that have a value
            const rows = [];

            if (p.pmEmail) {
                rows.push(`<a class="pm-card-action" href="mailto:${p.pmEmail}">
      <div class="pm-card-icon pm-icon-email">📧</div>
      <div class="pm-card-action-text">
        <span class="pm-card-action-type">Email</span>
        <span class="pm-card-action-label">${p.pmEmail}</span>
      </div>
      <span class="pm-card-action-cta">Send →</span>
    </a>`);
            }

            if (p.pmVoice) {
                const tel = p.pmVoice.replace(/[\s\-().]/g, '');
                rows.push(`<a class="pm-card-action" href="tel:${tel}">
      <div class="pm-card-icon pm-icon-voice">📞</div>
      <div class="pm-card-action-text">
        <span class="pm-card-action-type">Voice</span>
        <span class="pm-card-action-label">${p.pmVoice}</span>
      </div>
      <span class="pm-card-action-cta">Call →</span>
    </a>`);
            }

            if (p.pmSms) {
                const sms = p.pmSms.replace(/[\s\-().]/g, '');
                rows.push(`<a class="pm-card-action" href="sms:${sms}">
      <div class="pm-card-icon pm-icon-sms">💬</div>
      <div class="pm-card-action-text">
        <span class="pm-card-action-type">SMS</span>
        <span class="pm-card-action-label">${p.pmSms}</span>
      </div>
      <span class="pm-card-action-cta">Text →</span>
    </a>`);
            }

            document.getElementById('pmCardBody').innerHTML = rows.length ?
                rows.join('<div class="pm-card-divider"></div>') :
                '<div class="pm-card-empty">No contact details on file.</div>';

            const card = document.getElementById('pmCard');
            card.classList.add('visible');

            // Position near click, keep within viewport
            const margin = 12;
            let left = e.clientX + margin;
            let top = e.clientY + margin;
            card.style.left = '0';
            card.style.top = '0';
            const cw = card.offsetWidth || 300,
                ch = card.offsetHeight || 200;
            if (left + cw > window.innerWidth - margin) left = e.clientX - cw - margin;
            if (top + ch > window.innerHeight - margin) top = e.clientY - ch - margin;
            card.style.left = Math.max(margin, left) + 'px';
            card.style.top = Math.max(margin, top) + 'px';
        }

        function closePMCard() {
            document.getElementById('pmCard').classList.remove('visible');
        }

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#pmCard') && !e.target.closest('.pm-name')) closePMCard();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closePMCard();
        });

        /* ─── STATUS TOOLTIP ──────────────────────────────────── */
        function showStatusTooltip(e, msg) {
            const tip = document.getElementById('statusTooltip');
            tip.textContent = msg;
            tip.style.opacity = '1';
            positionStatusTooltip(e);
            document.addEventListener('mousemove', _trackStatusTooltip);
        }

        function hideStatusTooltip() {
            document.getElementById('statusTooltip').style.opacity = '0';
            document.removeEventListener('mousemove', _trackStatusTooltip);
        }

        function _trackStatusTooltip(e) {
            positionStatusTooltip(e);
        }

        function positionStatusTooltip(e) {
            const tip = document.getElementById('statusTooltip');
            tip.style.left = (e.clientX + 12) + 'px';
            tip.style.top = (e.clientY - 36) + 'px';
        }

        /* ─── CLIENT COUNT TOOLTIP ────────────────────────────── */
        function showClientTooltip(e, count) {
            const tip = document.getElementById('clientTooltip');
            tip.textContent = `${count} client${count !== 1 ? 's' : ''} linked`;
            tip.classList.add('visible');
            positionTooltip(e);
            document.addEventListener('mousemove', _trackTooltip);
        }

        function hideClientTooltip() {
            const tip = document.getElementById('clientTooltip');
            tip.classList.remove('visible');
            document.removeEventListener('mousemove', _trackTooltip);
        }

        function _trackTooltip(e) {
            positionTooltip(e);
        }

        function positionTooltip(e) {
            const tip = document.getElementById('clientTooltip');
            tip.style.left = (e.clientX + 12) + 'px';
            tip.style.top = (e.clientY - 28) + 'px';
        }

        /* ─── SIDEBAR MOBILE ──────────────────────────────────── */

        /* ─── PROJECT CLIENTS SUBPAGE ─────────────────────────── */
        function openClientsSubpage(e, projId) {
            e.stopPropagation();
            const p = projects.find(x => x.id === projId);
            if (!p) return;
            document.getElementById('cspTitle').textContent = `Project Clients — ${projId}`;
            document.getElementById('cspSubtitle').textContent = `Associated clients for internal project`;
            document.getElementById('cspProjName').textContent = p.shortDesc;
            document.getElementById('cspClientCount').textContent =
                `${p.clients.length} client${p.clients.length !== 1 ? 's' : ''} linked`;
            const tbody = document.getElementById('cspBody');
            tbody.innerHTML = '';
            const relevantClients = p.clients.filter(c => c !== 'INTERNAL');
            relevantClients.forEach((cid, i) => {
                const name = CLIENTS_MAP[cid] || cid;
                const tr = document.createElement('tr');
                tr.style.borderBottom = i < relevantClients.length - 1 ? '1px solid var(--border)' : 'none';
                tr.style.transition = 'background .12s';
                tr.onmouseenter = () => tr.style.background = '#faf9f5';
                tr.onmouseleave = () => tr.style.background = '';
                tr.innerHTML = `
      <td style="padding:13px 24px;font-family:'Syne',sans-serif;font-weight:700;font-size:.82rem;color:var(--slate);letter-spacing:.02em">${cid}</td>
      <td style="padding:13px 24px;font-size:.88rem;color:var(--ink);font-weight:500">${name}</td>
      <td style="padding:13px 24px"><span style="display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;background:var(--teal-pale);color:var(--teal-dark);font-size:.72rem;font-weight:600"><span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block"></span>Active</span></td>
    `;
                tbody.appendChild(tr);
            });
            document.getElementById('clientsSubpageOverlay').classList.add('open');
        }

        function closeClientsSubpage() {
            document.getElementById('clientsSubpageOverlay').classList.remove('open');
        }

        function handleClientsOverlayClick(e) {
            if (e.target === e.currentTarget) closeClientsSubpage();
        }

        /* ─── INIT ────────────────────────────────────────────── */
        filteredProjects = [...projects];
        _applySortAndRender();
    </script>

    <script>
        function toggleDesktopSidebar() {
            if (window.matchMedia('(max-width: 960px)').matches) {
                toggleSidebar();
                return;
            }
            const collapsed = document.body.classList.toggle('sidebar-collapsed');
            document.querySelector('.sidebar-toggle-btn')?.setAttribute('aria-expanded', String(!collapsed));
        }

        function toggleSidebar() {
            document.getElementById('sidebar')?.classList.toggle('open');
            document.getElementById('sidebarOverlay')?.classList.toggle('visible');
        }

        function closeSidebar() {
            document.getElementById('sidebar')?.classList.remove('open');
            document.getElementById('sidebarOverlay')?.classList.remove('visible');
        }
    </script>

</body>

</html>
