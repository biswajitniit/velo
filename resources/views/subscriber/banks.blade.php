<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Velo — Bank Accounts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&display=swap"
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
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: rgba(255, 255, 255, 0.35);
            padding: 14px 12px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            color: rgba(255, 255, 255, 0.68);
            text-decoration: none;
            font-size: 0.83rem;
            font-weight: 500;
            transition: all 0.15s ease;
            position: relative;
        }

        .nav-item:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.07);
        }

        .nav-item.active {
            color: #fff;
            background: rgba(0, 184, 153, 0.18);
            font-weight: 600;
        }

        .nav-item.active .nav-icon {
            filter: drop-shadow(0 0 6px rgba(0, 184, 153, 0.8));
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            bottom: 6px;
            width: 3px;
            border-radius: 0 2px 2px 0;
            background: var(--teal);
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
            background: rgba(0, 184, 153, 0.2);
            color: var(--teal);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.4);
            flex-shrink: 0;
        }

        .sidebar-footer a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.15s;
        }

        .sidebar-footer a:hover {
            color: #fff;
        }

        /* ─── SHELL & TOPBAR ───────────────────────────────────── */
        .shell {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        .topbar {
            height: var(--topbar-h);
            background: rgba(245, 242, 235, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sidebar-toggle-btn {
            display: none;
            background: none;
            border: 1px solid var(--border);
            border-radius: 8px;
            width: 34px;
            height: 34px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-toggle-btn span {
            display: block;
            width: 16px;
            height: 2px;
            background: var(--ink);
            border-radius: 2px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--ink);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink);
            text-decoration: none;
            position: relative;
            cursor: pointer;
            transition: all 0.15s;
        }

        .topbar-btn:hover {
            background: var(--cream);
        }

        .topbar-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 7px;
            height: 7px;
            background: var(--teal);
            border-radius: 50%;
        }

        /* ─── MAIN CONTENT ─────────────────────────────────────── */
        .main {
            flex: 1;
            padding: 32px;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
        }

        /* Page Header */
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
            font-weight: 800;
            font-size: 1.85rem;
            letter-spacing: -0.03em;
            color: var(--ink);
            line-height: 1.15;
            margin-bottom: 6px;
        }

        .page-header-left p {
            color: var(--muted);
            font-size: 0.88rem;
        }

        .page-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all 0.18s ease;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--slate);
            color: #fff;
            box-shadow: 0 4px 14px rgba(30, 42, 56, 0.2);
        }

        .btn-primary:hover {
            background: var(--slate-hover);
            transform: translateY(-1px);
        }

        .btn-teal {
            background: var(--teal);
            color: #fff;
            box-shadow: 0 4px 14px rgba(0, 184, 153, 0.25);
        }

        .btn-teal:hover {
            background: var(--teal-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #fff;
            border-color: var(--border);
            color: var(--ink);
        }

        .btn-secondary:hover {
            background: var(--cream);
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 0.78rem;
            border-radius: 6px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--ink);
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-icon:hover {
            background: var(--cream);
            color: var(--teal-dark);
        }

        .btn-icon.danger:hover {
            background: var(--red-pale);
            color: var(--red-soft);
            border-color: var(--red-soft);
        }

        /* ─── KPI CARDS ────────────────────────────────────────── */
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
            padding: 20px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .kpi-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .kpi-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .kpi-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--muted);
        }

        .kpi-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .icon-teal { background: var(--teal-pale); color: var(--teal-dark); }
        .icon-slate { background: #e2e8f0; color: var(--slate); }
        .icon-amber { background: var(--amber-pale); color: var(--amber); }
        .icon-blue { background: var(--blue-pale); color: var(--blue); }

        .kpi-value {
            font-family: 'Syne', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--ink);
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .kpi-subtext {
            font-size: 0.78rem;
            color: var(--muted);
        }

        /* ─── CONTROLS & FILTER BAR ───────────────────────────── */
        .controls-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 20px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 240px;
            max-width: 360px;
        }

        .search-box input {
            width: 100%;
            height: 38px;
            padding: 0 14px 0 36px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.85rem;
            background: var(--paper);
            outline: none;
            transition: all 0.15s;
        }

        .search-box input:focus {
            background: #fff;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.12);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.85rem;
            pointer-events: none;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-select {
            height: 38px;
            padding: 0 28px 0 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.82rem;
            color: var(--ink);
            background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 5 5-5z' fill='%236b7280'/%3E%3C/svg%3E") no-repeat right 10px center;
            appearance: none;
            cursor: pointer;
            outline: none;
        }

        .filter-select:focus {
            border-color: var(--teal);
        }

        .view-toggle {
            display: flex;
            background: var(--paper);
            padding: 3px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            gap: 2px;
        }

        .view-btn {
            background: none;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .view-btn.active {
            background: #fff;
            color: var(--ink);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        }

        /* ─── BULK ACTION BAR ─────────────────────────────────── */
        .bulk-bar {
            display: none;
            background: var(--slate);
            color: #fff;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            align-items: center;
            justify-content: space-between;
            animation: fadeIn 0.2s ease;
        }

        .bulk-bar.visible {
            display: flex;
        }

        .bulk-info {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .bulk-actions {
            display: flex;
            gap: 8px;
        }

        /* ─── BANK CARDS (GRID VIEW) ──────────────────────────── */
        .bank-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .bank-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            padding: 22px;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .bank-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: rgba(0, 184, 153, 0.4);
        }

        .bank-card.is-primary {
            border-color: var(--teal);
            background: linear-gradient(180deg, #ffffff 0%, #f7fdfb 100%);
            box-shadow: 0 4px 20px rgba(0, 184, 153, 0.12);
        }

        .bank-card-visual {
            background: linear-gradient(135deg, #1e2a38 0%, #0f1620 100%);
            color: #fff;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 16px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(30, 42, 56, 0.25);
        }

        .bank-card-visual::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 184, 153, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }

        .card-visual-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .card-bank-name {
            font-family: 'Syne', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 190px;
        }

        .card-type-tag {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            background: rgba(255, 255, 255, 0.15);
            padding: 3px 8px;
            border-radius: 6px;
            color: #fff;
        }

        .card-chip {
            width: 32px;
            height: 24px;
            background: linear-gradient(135deg, #f5a623 0%, #ffd080 100%);
            border-radius: 5px;
            margin-bottom: 14px;
            position: relative;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .card-account-number {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            color: #fff;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .toggle-mask-btn {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            font-size: 0.9rem;
            padding: 2px 4px;
            border-radius: 4px;
            transition: color 0.15s;
        }

        .toggle-mask-btn:hover {
            color: #fff;
        }

        .card-visual-bottom {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            font-size: 0.72rem;
        }

        .card-holder-label {
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            font-size: 0.6rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .card-holder-name {
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 170px;
        }

        .card-currency-tag {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            color: var(--teal);
        }

        /* Card Meta Details */
        .bank-details-rows {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 18px;
            font-size: 0.82rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 6px;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.06);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-title {
            color: var(--muted);
            font-size: 0.78rem;
        }

        .detail-data {
            font-weight: 600;
            color: var(--ink);
            font-family: inherit;
        }

        .bank-card-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 14px;
            border-top: 1px solid var(--border);
            gap: 10px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.15s;
        }

        .status-pill.active {
            background: var(--green-pale);
            color: #15803d;
            border-color: rgba(34, 197, 94, 0.3);
        }

        .status-pill.inactive {
            background: #f1f5f9;
            color: #64748b;
            border-color: #cbd5e1;
        }

        .primary-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            background: var(--amber-pale);
            color: #b45309;
            padding: 3px 8px;
            border-radius: 6px;
            border: 1px solid rgba(245, 166, 35, 0.3);
        }

        .card-actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ─── TABLE VIEW ───────────────────────────────────────── */
        .table-wrap {
            display: none;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 32px;
        }

        .table-wrap.visible {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
            text-align: left;
        }

        thead {
            background: var(--paper);
            border-bottom: 1px solid var(--border);
        }

        th {
            padding: 14px 18px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--muted);
        }

        td {
            padding: 14px 18px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            vertical-align: middle;
            color: var(--ink);
        }

        tbody tr:hover {
            background: #faf8f5;
        }

        .col-check {
            width: 40px;
            text-align: center;
        }

        /* Empty State */
        .empty-state {
            display: none;
            text-align: center;
            padding: 64px 20px;
            background: var(--card);
            border: 1px dashed var(--border);
            border-radius: var(--radius);
            margin-bottom: 32px;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 16px;
        }

        .empty-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .empty-desc {
            font-size: 0.88rem;
            color: var(--muted);
            max-width: 440px;
            margin: 0 auto 20px;
        }

        /* ─── MODALS ───────────────────────────────────────────── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-container {
            background: #ffffff;
            border-radius: var(--radius);
            width: 100%;
            max-width: 580px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border);
            transform: scale(0.95);
            transition: transform 0.2s ease;
        }

        .modal-overlay.open .modal-container {
            transform: scale(1);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--ink);
        }

        .modal-close {
            background: transparent;
            border: none;
            font-size: 1.4rem;
            color: var(--muted);
            cursor: pointer;
            line-height: 1;
        }

        .modal-close:hover {
            color: var(--ink);
        }

        .modal-body {
            padding: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-full {
            grid-column: 1 / -1;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--ink);
        }

        .form-label span.req {
            color: var(--red-soft);
        }

        .form-control {
            height: 40px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.85rem;
            background: var(--paper);
            color: var(--ink);
            outline: none;
            transition: all 0.15s;
        }

        textarea.form-control {
            height: auto;
            min-height: 70px;
            padding: 10px 12px;
            resize: vertical;
        }

        .form-control:focus {
            background: #fff;
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.12);
        }

        .form-switch-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 14px;
            background: var(--paper);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
        }

        .switch-label-wrap {
            display: flex;
            flex-direction: column;
        }

        .switch-title {
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--ink);
        }

        .switch-sub {
            font-size: 0.74rem;
            color: var(--muted);
        }

        /* Toggle switch component */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #cbd5e1;
            transition: .25s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .25s;
            border-radius: 50%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        input:checked + .toggle-slider {
            background-color: var(--teal);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(20px);
        }

        .modal-footer {
            padding: 18px 24px;
            background: var(--paper);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        /* ─── TOAST ────────────────────────────────────────────── */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: var(--slate);
            color: #fff;
            padding: 12px 20px;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 500;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success { border-left: 4px solid var(--teal); }
        .toast.error { border-left: 4px solid var(--red-soft); }
        .toast.info { border-left: 4px solid var(--blue); }

        /* Responsive */
        @media (max-width: 1024px) {
            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .shell {
                margin-left: 0;
            }

            .sidebar-toggle-btn {
                display: flex;
            }

            .kpi-grid {
                grid-template-columns: 1fr;
            }

            .main {
                padding: 20px 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <!-- ─── SIDEBAR ─────────────────────────────────────────── -->
    @include('subscriber.includes.sidebar')

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:45;" onclick="toggleSidebar()"></div>

    <!-- ─── MAIN SHELL ──────────────────────────────────────── -->
    <div class="shell">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle-btn" type="button" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="page-title">Bank Accounts</div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('subscriber.notifications') }}" class="topbar-btn" title="Notifications">
                    🔔
                    <span class="topbar-dot"></span>
                </a>
                <a href="{{ route('settings.index') }}" class="topbar-btn" title="Settings">⚙️</a>
            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main class="main">

            <!-- PAGE HEADER -->
            <div class="page-header">
                <div class="page-header-left">
                    <h1>Bank Accounts 🏦</h1>
                    <p>Manage payout destinations, account types, wire instructions, and primary settlement banks.</p>
                </div>
                <div class="page-actions">
                    <button class="btn btn-secondary" onclick="openWireModal()">
                        <span>📋</span> Wire Transfer Info
                    </button>
                    <button class="btn btn-teal" onclick="openAddModal()">
                        <span>＋</span> Add Bank Account
                    </button>
                </div>
            </div>

            <!-- KPI STATS -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Total Accounts</span>
                        <div class="kpi-icon icon-slate">🏦</div>
                    </div>
                    <div class="kpi-value" id="kpiTotal">{{ $kpiTotal }}</div>
                    <div class="kpi-subtext">Configured payout methods</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Primary Account</span>
                        <div class="kpi-icon icon-amber">⭐</div>
                    </div>
                    <div class="kpi-value" id="kpiPrimary" style="font-size: 1.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $kpiPrimary ? $kpiPrimary->bank_name : 'Not Set' }}
                    </div>
                    <div class="kpi-subtext">Default for invoice transfers</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Active Status</span>
                        <div class="kpi-icon icon-teal">✓</div>
                    </div>
                    <div class="kpi-value" id="kpiActive">{{ $kpiActive }}</div>
                    <div class="kpi-subtext">Ready for settlements</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <span class="kpi-label">Currencies</span>
                        <div class="kpi-icon icon-blue">🌐</div>
                    </div>
                    <div class="kpi-value" id="kpiCurrencies">{{ $kpiCurrencies }}</div>
                    <div class="kpi-subtext">Supported currencies</div>
                </div>
            </div>

            <!-- CONTROLS & FILTER TOOLBAR -->
            <div class="controls-card">
                <div class="search-box">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="searchInput" placeholder="Search by bank, account holder, last 4 digits…" onkeyup="filterBanks()">
                </div>

                <div class="filter-group">
                    <select id="typeFilter" class="filter-select" onchange="filterBanks()">
                        <option value="all">All Account Types</option>
                        <option value="checking">Checking Accounts</option>
                        <option value="savings">Savings Accounts</option>
                    </select>

                    <select id="statusFilter" class="filter-select" onchange="filterBanks()">
                        <option value="all">All Statuses</option>
                        <option value="active">Active Only</option>
                        <option value="inactive">Inactive Only</option>
                    </select>

                    <select id="primaryFilter" class="filter-select" onchange="filterBanks()">
                        <option value="all">All Accounts</option>
                        <option value="primary">Primary Only</option>
                    </select>

                    <div class="view-toggle">
                        <button type="button" class="view-btn active" id="btnGridView" onclick="switchView('grid')">
                            ⊞ Cards
                        </button>
                        <button type="button" class="view-btn" id="btnTableView" onclick="switchView('table')">
                            ☰ Table
                        </button>
                    </div>
                </div>
            </div>

            <!-- BULK ACTIONS BAR -->
            <div class="bulk-bar" id="bulkBar">
                <div class="bulk-info"><span id="selectedCount">0</span> accounts selected</div>
                <div class="bulk-actions">
                    <button class="btn btn-secondary btn-sm" onclick="bulkAction('activate')">✓ Activate</button>
                    <button class="btn btn-secondary btn-sm" onclick="bulkAction('deactivate')">✕ Deactivate</button>
                    <button class="btn btn-secondary btn-sm" style="color:var(--red-soft);" onclick="bulkAction('delete')">🗑 Delete</button>
                </div>
            </div>

            <!-- GRID / CARD VIEW -->
            <div class="bank-grid" id="bankGrid">
                <!-- Rendered dynamically by JavaScript -->
            </div>

            <!-- TABLE VIEW -->
            <div class="table-wrap" id="bankTableWrap">
                <table>
                    <thead>
                        <tr>
                            <th class="col-check">
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th>Bank & Branch</th>
                            <th>Account Holder</th>
                            <th>Account Number</th>
                            <th>Type</th>
                            <th>Routing / SWIFT</th>
                            <th>Currency</th>
                            <th>Primary</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bankTableBody">
                        <!-- Rendered dynamically by JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- EMPTY STATE -->
            <div class="empty-state" id="emptyState">
                <div class="empty-icon">🏦</div>
                <div class="empty-title">No bank accounts found</div>
                <p class="empty-desc">Add your corporate or personal bank accounts to receive direct wire settlements and show wire instructions on client invoices.</p>
                <button class="btn btn-teal" onclick="openAddModal()">＋ Add Your First Bank Account</button>
            </div>

        </main>
    </div>

    <!-- ─── ADD / EDIT BANK MODAL ───────────────────────────── -->
    <div class="modal-overlay" id="bankModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-title" id="modalTitle">Add Bank Account</div>
                <button type="button" class="modal-close" onclick="closeModal('bankModal')">&times;</button>
            </div>
            <form id="bankForm" onsubmit="saveBank(event)">
                <input type="hidden" id="bankId" value="">
                <div class="modal-body">
                    <div class="form-grid">
                        
                        <div class="form-group form-full">
                            <label class="form-label">Bank Name <span class="req">*</span></label>
                            <input type="text" id="bankName" class="form-control" placeholder="e.g. JPMorgan Chase, Barclays, HDFC" required>
                        </div>

                        <div class="form-group form-full">
                            <label class="form-label">Account Holder Name <span class="req">*</span></label>
                            <input type="text" id="accountName" class="form-control" placeholder="e.g. Acme Corporation LLC / John Doe" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Account Number / IBAN <span class="req">*</span></label>
                            <input type="text" id="accountNumber" class="form-control" placeholder="e.g. 1029384756" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Account Type <span class="req">*</span></label>
                            <select id="accountType" class="form-control" required>
                                <option value="checking">Checking Account</option>
                                <option value="savings">Savings Account</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Routing / BSB / IFSC Code</label>
                            <input type="text" id="routingNumber" class="form-control" placeholder="e.g. 021000021">
                        </div>

                        <div class="form-group">
                            <label class="form-label">SWIFT / BIC Code</label>
                            <input type="text" id="swiftCode" class="form-control" placeholder="e.g. CHASUS33">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Currency <span class="req">*</span></label>
                            <select id="currency" class="form-control" required>
                                <option value="USD">USD ($)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="AUD">AUD ($)</option>
                                <option value="CAD">CAD ($)</option>
                                <option value="INR">INR (₹)</option>
                                <option value="SGD">SGD ($)</option>
                                <option value="AED">AED (د.إ)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Branch Name / City</label>
                            <input type="text" id="branchName" class="form-control" placeholder="e.g. Manhattan 5th Ave">
                        </div>

                        <div class="form-group form-full">
                            <div class="form-switch-row">
                                <div class="switch-label-wrap">
                                    <span class="switch-title">Set as Primary Account ⭐</span>
                                    <span class="switch-sub">Automatically featured on invoices and default payouts</span>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="isPrimary">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group form-full">
                            <div class="form-switch-row">
                                <div class="switch-label-wrap">
                                    <span class="switch-title">Account Active Status</span>
                                    <span class="switch-sub">Enable or disable settlements to this account</span>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="status" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group form-full">
                            <label class="form-label">Wire / Payment Notes (Optional)</label>
                            <textarea id="notes" class="form-control" placeholder="e.g. For international wire transfers only. Reference Invoice Number in memo field."></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('bankModal')">Cancel</button>
                    <button type="submit" class="btn btn-teal" id="btnSaveBank">Save Bank Account</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ─── DELETE CONFIRM MODAL ────────────────────────────── -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-container" style="max-width: 440px;">
            <div class="modal-header">
                <div class="modal-title" style="color:var(--red-soft);">Delete Bank Account</div>
                <button type="button" class="modal-close" onclick="closeModal('deleteModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p style="margin-bottom: 12px; color:var(--ink);">Are you sure you want to remove <strong id="deleteBankName"></strong>?</p>
                <p style="font-size: 0.82rem; color:var(--muted);">This will remove this bank account from your payout list. Existing invoice history will remain intact.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">Cancel</button>
                <button type="button" class="btn btn-secondary" style="background:var(--red-soft); color:#fff; border-color:var(--red-soft);" id="btnConfirmDelete">Delete Account</button>
            </div>
        </div>
    </div>

    <!-- ─── WIRE INSTRUCTIONS MODAL ─────────────────────────── -->
    <div class="modal-overlay" id="wireModal">
        <div class="modal-container" style="max-width: 520px;">
            <div class="modal-header">
                <div class="modal-title">Wire Transfer Instructions 📋</div>
                <button type="button" class="modal-close" onclick="closeModal('wireModal')">&times;</button>
            </div>
            <div class="modal-body">
                <p style="font-size: 0.85rem; color:var(--muted); margin-bottom: 16px;">
                    Select a bank account below to generate clean wire instructions formatted for emails or invoice attachments.
                </p>
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label">Select Bank Account</label>
                    <select id="wireBankSelect" class="form-control" onchange="renderWireText()">
                        <!-- Populated dynamically -->
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Wire Instructions Preview</label>
                    <textarea id="wireTextPreview" class="form-control" style="min-height: 140px; font-family: monospace; font-size: 0.8rem; background: #fff;" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('wireModal')">Close</button>
                <button type="button" class="btn btn-teal" onclick="copyWireInstructions()">📋 Copy All to Clipboard</button>
            </div>
        </div>
    </div>

    <!-- ─── TOAST NOTIFICATION ──────────────────────────────── -->
    <div id="toast" class="toast">
        <span id="toastIcon">✓</span>
        <span id="toastMsg">Operation completed successfully.</span>
    </div>

    <!-- ─── JAVASCRIPT ENGINE ───────────────────────────────── -->
    <script>
        // Initial Dataset passed from Laravel Controller
        let banks = @json($jsBanks);
        let currentView = 'grid';
        let unmaskedIds = new Set();
        let selectedBankIds = new Set();

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.addEventListener('DOMContentLoaded', () => {
            renderView();
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar) {
                sidebar.classList.toggle('open');
                if (overlay) {
                    overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
                }
            }
        }

        function switchView(view) {
            currentView = view;
            document.getElementById('btnGridView').classList.toggle('active', view === 'grid');
            document.getElementById('btnTableView').classList.toggle('active', view === 'table');
            
            document.getElementById('bankGrid').style.display = view === 'grid' ? 'grid' : 'none';
            document.getElementById('bankTableWrap').classList.toggle('visible', view === 'table');
        }

        function toggleMask(id, e) {
            if (e) e.stopPropagation();
            if (unmaskedIds.has(id)) {
                unmaskedIds.delete(id);
            } else {
                unmaskedIds.add(id);
            }
            renderView();
        }

        function getFilteredBanks() {
            const query = (document.getElementById('searchInput').value || '').toLowerCase().trim();
            const type = document.getElementById('typeFilter').value;
            const status = document.getElementById('statusFilter').value;
            const primary = document.getElementById('primaryFilter').value;

            return banks.filter(b => {
                const matchQuery = !query || 
                    b.bankName.toLowerCase().includes(query) ||
                    b.accountName.toLowerCase().includes(query) ||
                    b.accountNumber.includes(query) ||
                    (b.branchName && b.branchName.toLowerCase().includes(query));

                const matchType = type === 'all' || b.accountType === type;
                const matchStatus = status === 'all' || (status === 'active' ? b.status : !b.status);
                const matchPrimary = primary === 'all' || (primary === 'primary' ? b.isPrimary : true);

                return matchQuery && matchType && matchStatus && matchPrimary;
            });
        }

        function renderView() {
            const filtered = getFilteredBanks();
            const emptyState = document.getElementById('emptyState');
            const gridWrap = document.getElementById('bankGrid');
            const tableWrap = document.getElementById('bankTableWrap');
            const tableBody = document.getElementById('bankTableBody');

            // Update KPI stats dynamically
            const total = banks.length;
            const active = banks.filter(b => b.status).length;
            const primaryBank = banks.find(b => b.isPrimary);
            const currencies = new Set(banks.map(b => b.currency)).size;

            document.getElementById('kpiTotal').innerText = total;
            document.getElementById('kpiActive').innerText = active;
            document.getElementById('kpiPrimary').innerText = primaryBank ? primaryBank.bankName : 'Not Set';
            document.getElementById('kpiCurrencies').innerText = currencies;

            if (filtered.length === 0) {
                gridWrap.style.display = 'none';
                tableWrap.classList.remove('visible');
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            gridWrap.style.display = currentView === 'grid' ? 'grid' : 'none';
            tableWrap.classList.toggle('visible', currentView === 'table');

            // Render Cards
            gridWrap.innerHTML = filtered.map(b => {
                const isUnmasked = unmaskedIds.has(b.id);
                const displayNum = isUnmasked ? formatCardNumber(b.accountNumber) : b.maskedNumber;

                return `
                    <div class="bank-card ${b.isPrimary ? 'is-primary' : ''}">
                        <div class="bank-card-visual">
                            <div class="card-visual-top">
                                <span class="card-bank-name" title="${escapeHtml(b.bankName)}">${escapeHtml(b.bankName)}</span>
                                <span class="card-type-tag">${b.accountType}</span>
                            </div>
                            <div class="card-chip"></div>
                            <div class="card-account-number">
                                <span>${displayNum}</span>
                                <button type="button" class="toggle-mask-btn" onclick="toggleMask(${b.id}, event)" title="${isUnmasked ? 'Hide number' : 'Reveal number'}">
                                    ${isUnmasked ? '🙈' : '👁️'}
                                </button>
                            </div>
                            <div class="card-visual-bottom">
                                <div>
                                    <div class="card-holder-label">Account Holder</div>
                                    <div class="card-holder-name" title="${escapeHtml(b.accountName)}">${escapeHtml(b.accountName)}</div>
                                </div>
                                <div class="card-currency-tag">${b.currency}</div>
                            </div>
                        </div>

                        <div class="bank-details-rows">
                            ${b.routingNumber ? `
                                <div class="detail-row">
                                    <span class="detail-title">Routing / BSB</span>
                                    <span class="detail-data">${escapeHtml(b.routingNumber)}</span>
                                </div>
                            ` : ''}
                            ${b.swiftCode ? `
                                <div class="detail-row">
                                    <span class="detail-title">SWIFT / BIC</span>
                                    <span class="detail-data">${escapeHtml(b.swiftCode)}</span>
                                </div>
                            ` : ''}
                            ${b.branchName ? `
                                <div class="detail-row">
                                    <span class="detail-title">Branch</span>
                                    <span class="detail-data">${escapeHtml(b.branchName)}</span>
                                </div>
                            ` : ''}
                        </div>

                        <div class="bank-card-footer">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span class="status-pill ${b.status ? 'active' : 'inactive'}" onclick="toggleStatus(${b.id})" title="Click to toggle status">
                                    ${b.status ? '● Active' : '○ Inactive'}
                                </span>
                                ${b.isPrimary ? '<span class="primary-badge">⭐ Primary</span>' : ''}
                            </div>
                            <div class="card-actions">
                                ${!b.isPrimary ? `
                                    <button class="btn-icon" onclick="setPrimary(${b.id})" title="Set as Primary Account">⭐</button>
                                ` : ''}
                                <button class="btn-icon" onclick="editBank(${b.id})" title="Edit Account">✏️</button>
                                <button class="btn-icon danger" onclick="confirmDelete(${b.id})" title="Delete Account">🗑️</button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            // Render Table
            tableBody.innerHTML = filtered.map(b => {
                const isUnmasked = unmaskedIds.has(b.id);
                const displayNum = isUnmasked ? b.accountNumber : b.maskedNumber;
                const isChecked = selectedBankIds.has(b.id);

                return `
                    <tr>
                        <td class="col-check">
                            <input type="checkbox" class="row-checkbox" value="${b.id}" ${isChecked ? 'checked' : ''} onchange="toggleSelectBank(${b.id}, this.checked)">
                        </td>
                        <td>
                            <div style="font-weight:700; color:var(--ink);">${escapeHtml(b.bankName)}</div>
                            ${b.branchName ? `<div style="font-size:0.75rem; color:var(--muted);">${escapeHtml(b.branchName)}</div>` : ''}
                        </td>
                        <td>${escapeHtml(b.accountName)}</td>
                        <td>
                            <div style="display:flex; align-items:center; gap:6px; font-family:monospace;">
                                <span>${displayNum}</span>
                                <button type="button" style="background:none; border:none; cursor:pointer;" onclick="toggleMask(${b.id}, event)">
                                    ${isUnmasked ? '🙈' : '👁️'}
                                </button>
                            </div>
                        </td>
                        <td><span style="text-transform:capitalize; font-weight:600;">${b.accountType}</span></td>
                        <td>${escapeHtml(b.routingNumber || b.swiftCode || '—')}</td>
                        <td><strong style="color:var(--teal);">${b.currency}</strong></td>
                        <td>
                            ${b.isPrimary 
                                ? '<span class="primary-badge">⭐ Primary</span>' 
                                : `<button class="btn btn-secondary btn-sm" onclick="setPrimary(${b.id})">Set Primary</button>`}
                        </td>
                        <td>
                            <span class="status-pill ${b.status ? 'active' : 'inactive'}" onclick="toggleStatus(${b.id})">
                                ${b.status ? '● Active' : '○ Inactive'}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div style="display:inline-flex; gap:6px;">
                                <button class="btn-icon" onclick="editBank(${b.id})" title="Edit">✏️</button>
                                <button class="btn-icon danger" onclick="confirmDelete(${b.id})" title="Delete">🗑️</button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');

            updateBulkBar();
        }

        function formatCardNumber(num) {
            return num ? num.replace(/(.{4})/g, '$1 ').trim() : '';
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function filterBanks() {
            renderView();
        }

        /* Modal Functions */
        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
        }

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Add Bank Account';
            document.getElementById('bankId').value = '';
            document.getElementById('bankForm').reset();
            document.getElementById('status').checked = true;
            document.getElementById('isPrimary').checked = banks.length === 0;
            openModal('bankModal');
        }

        function editBank(id) {
            const b = banks.find(x => x.id === id);
            if (!b) return;

            document.getElementById('modalTitle').innerText = 'Edit Bank Account';
            document.getElementById('bankId').value = b.id;
            document.getElementById('bankName').value = b.bankName || '';
            document.getElementById('accountName').value = b.accountName || '';
            document.getElementById('accountNumber').value = b.accountNumber || '';
            document.getElementById('accountType').value = b.accountType || 'checking';
            document.getElementById('routingNumber').value = b.routingNumber || '';
            document.getElementById('swiftCode').value = b.swiftCode || '';
            document.getElementById('branchName').value = b.branchName || '';
            document.getElementById('currency').value = b.currency || 'USD';
            document.getElementById('isPrimary').checked = b.isPrimary;
            document.getElementById('status').checked = b.status;
            document.getElementById('notes').value = b.notes || '';

            openModal('bankModal');
        }

        /* Save Bank (Add / Edit) */
        async function saveBank(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSaveBank');
            btn.disabled = true;
            btn.innerText = 'Saving…';

            const id = document.getElementById('bankId').value;
            const isEdit = Boolean(id);

            const payload = {
                bank_name: document.getElementById('bankName').value,
                account_name: document.getElementById('accountName').value,
                account_number: document.getElementById('accountNumber').value,
                account_type: document.getElementById('accountType').value,
                routing_number: document.getElementById('routingNumber').value,
                swift_code: document.getElementById('swiftCode').value,
                branch_name: document.getElementById('branchName').value,
                currency: document.getElementById('currency').value,
                is_primary: document.getElementById('isPrimary').checked ? 1 : 0,
                status: document.getElementById('status').checked ? 1 : 0,
                notes: document.getElementById('notes').value,
            };

            const url = isEdit ? `/subscriber/banks/${id}` : '/subscriber/banks';
            const method = isEdit ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message || 'Saved successfully', 'success');
                    closeModal('bankModal');
                    // Reload fresh data from server
                    await reloadBanks();
                } else {
                    showToast(data.message || 'Validation error occurred', 'error');
                }
            } catch (err) {
                showToast('An unexpected network error occurred.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Save Bank Account';
            }
        }

        /* Delete confirmation */
        let deletingBankId = null;
        function confirmDelete(id) {
            deletingBankId = id;
            const b = banks.find(x => x.id === id);
            document.getElementById('deleteBankName').innerText = b ? b.bankName : 'this bank account';
            document.getElementById('btnConfirmDelete').onclick = performDelete;
            openModal('deleteModal');
        }

        async function performDelete() {
            if (!deletingBankId) return;
            const btn = document.getElementById('btnConfirmDelete');
            btn.disabled = true;
            btn.innerText = 'Deleting…';

            try {
                const res = await fetch(`/subscriber/banks/${deletingBankId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    showToast(data.message || 'Bank account deleted', 'success');
                    closeModal('deleteModal');
                    await reloadBanks();
                } else {
                    showToast(data.message || 'Could not delete bank account', 'error');
                }
            } catch (err) {
                showToast('Failed to delete account.', 'error');
            } finally {
                btn.disabled = false;
                btn.innerText = 'Delete Account';
            }
        }

        /* Set as Primary */
        async function setPrimary(id) {
            try {
                const res = await fetch(`/subscriber/banks/${id}/primary`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    showToast(data.message, 'success');
                    await reloadBanks();
                } else {
                    showToast(data.message || 'Could not set as primary', 'error');
                }
            } catch (err) {
                showToast('Failed to update primary bank.', 'error');
            }
        }

        /* Toggle Active/Inactive Status */
        async function toggleStatus(id) {
            try {
                const res = await fetch(`/subscriber/banks/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    showToast(data.message, 'success');
                    await reloadBanks();
                } else {
                    showToast(data.message || 'Could not toggle status', 'error');
                }
            } catch (err) {
                showToast('Failed to update status.', 'error');
            }
        }

        /* Reload banks via AJAX */
        async function reloadBanks() {
            try {
                const res = await fetch('/subscriber/banks', {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success && data.banks) {
                    banks = data.banks;
                    renderView();
                }
            } catch (e) {
                window.location.reload();
            }
        }

        /* Wire Instructions Modal */
        function openWireModal() {
            const select = document.getElementById('wireBankSelect');
            if (banks.length === 0) {
                showToast('Please add at least one bank account first.', 'info');
                return;
            }
            select.innerHTML = banks.map(b => `
                <option value="${b.id}" ${b.isPrimary ? 'selected' : ''}>
                    ${escapeHtml(b.bankName)} (${b.accountType.toUpperCase()} · ${b.currency}) ${b.isPrimary ? '⭐' : ''}
                </option>
            `).join('');

            renderWireText();
            openModal('wireModal');
        }

        function renderWireText() {
            const id = parseInt(document.getElementById('wireBankSelect').value, 10);
            const b = banks.find(x => x.id === id);
            if (!b) return;

            const text = [
                `BANK WIRE TRANSFER DETAILS`,
                `----------------------------------------`,
                `Bank Name       : ${b.bankName}`,
                `Account Holder  : ${b.accountName}`,
                `Account Number  : ${b.accountNumber}`,
                `Account Type    : ${b.accountType.toUpperCase()}`,
                `Currency        : ${b.currency}`,
                b.routingNumber ? `Routing / BSB   : ${b.routingNumber}` : null,
                b.swiftCode     ? `SWIFT / BIC Code: ${b.swiftCode}` : null,
                b.branchName    ? `Branch / City   : ${b.branchName}` : null,
                b.notes         ? `Notes / Memo    : ${b.notes}` : null,
                `----------------------------------------`,
                `Please include Invoice Reference Number in the transfer memo.`
            ].filter(Boolean).join('\n');

            document.getElementById('wireTextPreview').value = text;
        }

        function copyWireInstructions() {
            const text = document.getElementById('wireTextPreview').value;
            navigator.clipboard.writeText(text).then(() => {
                showToast('Wire transfer details copied to clipboard!', 'success');
                closeModal('wireModal');
            }).catch(() => {
                showToast('Could not copy to clipboard.', 'error');
            });
        }

        /* Bulk Actions */
        function toggleSelectAll(master) {
            const filtered = getFilteredBanks();
            if (master.checked) {
                filtered.forEach(b => selectedBankIds.add(b.id));
            } else {
                filtered.forEach(b => selectedBankIds.delete(b.id));
            }
            renderView();
        }

        function toggleSelectBank(id, checked) {
            if (checked) {
                selectedBankIds.add(id);
            } else {
                selectedBankIds.delete(id);
            }
            updateBulkBar();
        }

        function updateBulkBar() {
            const count = selectedBankIds.size;
            document.getElementById('selectedCount').innerText = count;
            document.getElementById('bulkBar').classList.toggle('visible', count > 0 && currentView === 'table');
            
            const selectAll = document.getElementById('selectAll');
            if (selectAll) {
                const filtered = getFilteredBanks();
                selectAll.checked = filtered.length > 0 && filtered.every(b => selectedBankIds.has(b.id));
            }
        }

        async function bulkAction(action) {
            if (selectedBankIds.size === 0) return;
            const ids = Array.from(selectedBankIds);

            if (action === 'delete' && !confirm(`Are you sure you want to delete ${ids.length} bank accounts?`)) {
                return;
            }

            try {
                const res = await fetch('/subscriber/banks/bulk-action', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ids, action })
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    showToast(data.message, 'success');
                    selectedBankIds.clear();
                    await reloadBanks();
                } else {
                    showToast(data.message || 'Bulk operation failed', 'error');
                }
            } catch (err) {
                showToast('Network error during bulk action.', 'error');
            }
        }

        /* Toast display */
        let toastTimeout;
        function showToast(msg, type = 'success') {
            const toast = document.getElementById('toast');
            const msgEl = document.getElementById('toastMsg');
            const iconEl = document.getElementById('toastIcon');

            clearTimeout(toastTimeout);
            toast.className = `toast ${type}`;
            msgEl.innerText = msg;
            iconEl.innerText = type === 'success' ? '✓' : (type === 'error' ? '✕' : 'ℹ');

            toast.classList.add('show');
            toastTimeout = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }
    </script>
</body>

</html>
