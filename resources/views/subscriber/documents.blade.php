<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billflow — Documents</title>
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
            --blue: #4f8ef7;
            --blue-pale: #e8f0fe;
            --purple: #9b72cf;
            --purple-pale: #f0eafd;
            --green: #2ecc71;
            --green-pale: #d4f7e7;
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

        /* Submenu */
        .nav-item-parent {
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
            user-select: none;
        }

        .nav-item-parent:hover {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.9);
        }

        .nav-item-parent.open {
            color: rgba(255, 255, 255, 0.9);
        }

        .nav-item-parent .nav-icon {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item-parent .nav-label {
            flex: 1;
        }

        .nav-chevron {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.3);
            transition: transform .2s;
            line-height: 1;
        }

        .nav-item-parent.open .nav-chevron {
            transform: rotate(90deg);
        }

        .nav-submenu {
            overflow: hidden;
            max-height: 0;
            transition: max-height .25s ease;
        }

        .nav-submenu.open {
            max-height: 120px;
        }

        .nav-sub-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 20px 7px 47px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.82rem;
            font-weight: 400;
            text-decoration: none;
            transition: background .15s, color .15s;
            border-left: 3px solid transparent;
            position: relative;
        }

        .nav-sub-item::before {
            content: '';
            position: absolute;
            left: 36px;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transition: background .15s;
        }

        .nav-sub-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.85);
        }

        .nav-sub-item:hover::before {
            background: rgba(255, 255, 255, 0.5);
        }

        .nav-sub-item.active {
            color: var(--teal);
            font-weight: 600;
            border-left-color: var(--teal);
            background: rgba(0, 184, 153, 0.1);
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

        /* ─── LAYOUT SHELL ─────────────────────────────────────── */
        .shell {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── TOP BAR ───────────────────────────────────────────── */
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

        .page-subtitle {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 1px;
        }

        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: 99px;
            padding: 7px 16px;
            min-width: 360px;
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
            text-decoration: none;
            position: relative;
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
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            background: var(--card);
            color: var(--slate);
            border: 1.5px solid var(--border);
            border-radius: 99px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .btn-secondary:hover {
            border-color: var(--teal);
            background: var(--teal-pale);
            color: var(--teal-dark);
        }

        /* ─── MAIN ──────────────────────────────────────────────── */
        .main {
            flex: 1;
            padding: 32px;
            max-width: 1400px;
        }

        /* ─── PAGE HEADER ───────────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .inline-search-row {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header-left h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--slate);
            letter-spacing: -0.03em;
            margin-bottom: 4px;
        }

        .page-header-left p {
            color: var(--muted);
            font-size: 0.875rem;
        }

        .page-header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ─── CATEGORY SUMMARY CARDS ────────────────────────────── */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: 14px;
            margin-bottom: 32px;
        }

        .cat-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            padding: 18px 20px;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s, transform .15s;
            position: relative;
            overflow: hidden;
        }

        .cat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--cat-color, var(--teal));
            border-radius: 4px 4px 0 0;
        }

        .cat-card:hover {
            border-color: var(--cat-color, var(--teal));
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .cat-card.active-filter {
            border-color: var(--cat-color, var(--teal));
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.06);
            background: var(--cat-bg, var(--teal-pale));
        }

        .cat-card-icon {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .cat-card-count {
            font-family: 'Syne', sans-serif;
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--cat-color, var(--teal));
            line-height: 1;
            margin-bottom: 4px;
        }

        .cat-card-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--slate);
            margin-bottom: 2px;
        }

        .cat-card-sub {
            font-size: 0.7rem;
            color: var(--muted);
        }

        /* ─── FILTER BAR ─────────────────────────────────────────── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            flex-shrink: 0;
        }

        .filter-chips {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .chip {
            padding: 5px 14px;
            border-radius: 99px;
            border: 1.5px solid var(--border);
            background: var(--card);
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--muted);
            cursor: pointer;
            transition: all .15s;
        }

        .chip:hover,
        .chip.active {
            border-color: var(--teal);
            background: var(--teal-pale);
            color: var(--teal-dark);
        }

        .filter-right {
            margin-left: auto;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .sort-select {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 7px 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            color: var(--ink);
            background: var(--card);
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }

        .sort-select:focus {
            border-color: var(--teal);
        }

        .view-toggle {
            display: flex;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .view-btn {
            padding: 7px 12px;
            background: var(--card);
            border: none;
            font-size: 0.85rem;
            cursor: pointer;
            color: var(--muted);
            transition: background .15s, color .15s;
        }

        .view-btn.active {
            background: var(--slate);
            color: #fff;
        }

        /* ─── TABLE ──────────────────────────────────────────────── */
        .table-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--cream);
        }

        .table-head-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--slate);
        }

        .record-count {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 2px 9px;
            border-radius: 99px;
            background: rgba(0, 0, 0, 0.07);
            color: var(--muted);
        }

        .bulk-actions {
            display: none;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--teal-pale);
            border-bottom: 1px solid rgba(0, 184, 153, 0.2);
        }

        .bulk-actions.visible {
            display: flex;
        }

        .bulk-count {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--teal-dark);
        }

        .bulk-btn {
            padding: 5px 12px;
            border-radius: 99px;
            border: 1.5px solid rgba(0, 184, 153, 0.4);
            background: #fff;
            font-size: 0.78rem;
            font-weight: 500;
            color: var(--teal-dark);
            cursor: pointer;
            transition: all .15s;
        }

        .bulk-btn:hover {
            background: var(--teal);
            color: #fff;
            border-color: var(--teal);
        }

        .bulk-btn.danger {
            border-color: rgba(240, 84, 84, 0.4);
            color: var(--red-soft);
        }

        .bulk-btn.danger:hover {
            background: var(--red-soft);
            color: #fff;
            border-color: var(--red-soft);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--cream);
        }

        thead th {
            padding: 11px 16px;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
            cursor: pointer;
            user-select: none;
            transition: color .15s;
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

        thead th:first-child {
            padding-left: 20px;
            width: 36px;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background .12s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:nth-child(even) {
            background: rgba(0, 0, 0, 0.015);
        }

        tbody tr:hover {
            background: var(--teal-pale);
        }

        td {
            padding: 13px 16px;
            font-size: 0.84rem;
            vertical-align: middle;
        }

        td:first-child {
            padding-left: 20px;
        }

        .td-check input[type=checkbox] {
            cursor: pointer;
            width: 15px;
            height: 15px;
            accent-color: var(--teal);
        }

        /* File type icon cell */
        .doc-file-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .file-icon {
            width: 34px;
            height: 40px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            position: relative;
            font-family: 'Syne', sans-serif;
            letter-spacing: 0.02em;
        }

        .file-icon::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 8px 8px 0;
            border-color: transparent rgba(255, 255, 255, 0.35) transparent transparent;
        }

        .file-icon.pdf {
            background: #e74c3c;
        }

        .file-icon.docx {
            background: #2b7de9;
        }

        .file-icon.xlsx {
            background: #1a7a4a;
        }

        .file-icon.pptx {
            background: #d44f20;
        }

        .file-icon.png,
        .file-icon.jpg,
        .file-icon.jpeg {
            background: #9b72cf;
        }

        .file-icon.zip {
            background: #8d6e63;
        }

        .file-icon.csv {
            background: #00897b;
        }

        .file-icon.txt {
            background: #90a4ae;
        }

        .file-icon.other {
            background: #78909c;
        }

        .doc-name-info {
            min-width: 0;
        }

        .doc-filename {
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--slate);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        .doc-description {
            font-size: 0.74rem;
            color: var(--muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        /* Client cell */
        .client-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .client-dot {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), var(--teal-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .client-name {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--slate);
        }

        .client-id {
            font-size: 0.7rem;
            color: var(--muted);
        }

        /* Category badge */
        .cat-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .cat-badge .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.7;
        }

        /* File size */
        .file-size {
            font-size: 0.78rem;
            color: var(--muted);
        }

        /* Status badge */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .status-badge.shared {
            background: var(--teal-pale);
            color: var(--teal-dark);
        }

        .status-badge.private {
            background: var(--amber-pale);
            color: #c47b00;
        }

        .status-badge.archived {
            background: var(--cream);
            color: var(--muted);
        }

        /* Locked badge */
        .locked-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            font-family: 'Syne', sans-serif;
            letter-spacing: 0.04em;
            border: 1.5px solid transparent;
        }

        .locked-badge.N {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }

        .locked-badge.Y {
            background: #fef9c3;
            color: #a16207;
            border-color: #fde68a;
        }

        .locked-badge.P {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .locked-badge.H {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* Locked option tiles in modal */
        .locked-options {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 6px;
        }

        .locked-option {
            padding: 10px 8px;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            text-align: center;
            transition: all .15s;
        }

        .locked-option.selected {
            border-color: var(--slate);
            background: var(--cream);
        }

        .locked-option.disabled {
            opacity: 0.35;
            pointer-events: none;
        }

        .locked-option-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.82rem;
            font-weight: 800;
            font-family: 'Syne', sans-serif;
            margin-bottom: 5px;
        }

        .locked-option-badge.N {
            background: #f0fdf4;
            color: #16a34a;
        }

        .locked-option-badge.Y {
            background: #fef9c3;
            color: #a16207;
        }

        .locked-option-badge.P {
            background: #eff6ff;
            color: #2563eb;
        }

        .locked-option-badge.H {
            background: #fef2f2;
            color: #dc2626;
        }

        .locked-option-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--slate);
            margin-bottom: 2px;
        }

        .locked-option-sub {
            font-size: 0.65rem;
            color: var(--muted);
            line-height: 1.3;
        }

        /* Actions cell */
        .row-actions {
            display: flex;
            align-items: center;
            gap: 4px;
            opacity: 0;
            transition: opacity .15s;
        }

        tbody tr:hover .row-actions {
            opacity: 1;
        }

        .row-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background: #fff;
            cursor: pointer;
            color: #374151;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
            padding: 0;
        }

        .row-btn svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .row-btn:hover {
            background: #111827;
            color: #fff;
            border-color: #111827;
        }

        .row-btn.danger {
            color: #374151;
        }

        .row-btn.danger:hover {
            background: #111827;
            border-color: #111827;
            color: #fff;
        }

        /* ─── GRID VIEW ──────────────────────────────────────────── */
        .doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
            padding: 20px;
        }

        .doc-grid-item {
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 16px;
            cursor: pointer;
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .doc-grid-item:hover {
            border-color: var(--teal);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .doc-grid-check {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .doc-grid-check input {
            width: 15px;
            height: 15px;
            accent-color: var(--teal);
            cursor: pointer;
        }

        .grid-file-icon {
            width: 52px;
            height: 62px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
            position: relative;
            font-family: 'Syne', sans-serif;
        }

        .grid-file-icon::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 12px 12px 0;
            border-color: transparent rgba(255, 255, 255, 0.3) transparent transparent;
        }

        .grid-doc-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--slate);
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .grid-doc-desc {
            font-size: 0.72rem;
            color: var(--muted);
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .grid-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .grid-client-name {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--teal-dark);
        }

        .grid-date {
            font-size: 0.7rem;
            color: var(--muted);
        }

        .grid-actions {
            display: flex;
            gap: 4px;
            margin-top: 10px;
            opacity: 0;
            transition: opacity .15s;
        }

        .doc-grid-item:hover .grid-actions {
            opacity: 1;
        }

        /* ─── EMPTY STATE ────────────────────────────────────────── */
        .empty-state {
            padding: 64px 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 12px;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 4px;
        }

        .empty-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--slate);
        }

        .empty-text {
            font-size: 0.875rem;
            color: var(--muted);
            max-width: 320px;
        }

        /* ─── MODALS ─────────────────────────────────────────────── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(3px);
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px) scale(0.98);
            transition: transform .25s;
        }

        .modal-overlay.open .modal {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 28px 18px;
            border-bottom: 1px solid var(--border);
        }

        .modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--slate);
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: transparent;
            font-size: 1rem;
            cursor: pointer;
            color: var(--muted);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
        }

        .modal-close:hover {
            background: var(--red-pale);
            border-color: var(--red-soft);
            color: var(--red-soft);
        }

        .modal-body {
            padding: 24px 28px;
        }

        .modal-footer {
            padding: 16px 28px 22px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            border-top: 1px solid var(--border);
        }

        /* Form elements */
        .form-group {
            margin-bottom: 18px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--slate);
            margin-bottom: 6px;
            letter-spacing: 0.01em;
        }

        label .req {
            color: var(--red-soft);
            margin-left: 2px;
        }

        input[type=text],
        input[type=date],
        select,
        textarea {
            width: 100%;
            padding: 9px 14px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            color: var(--ink);
            background: var(--card);
            outline: none;
            transition: border-color .2s;
        }

        input[type=text]:focus,
        input[type=date]:focus,
        select:focus,
        textarea:focus {
            border-color: var(--teal);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Drop zone */
        .drop-zone {
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            padding: 36px 24px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            background: var(--paper);
        }

        .drop-zone:hover,
        .drop-zone.drag-over {
            border-color: var(--teal);
            background: var(--teal-pale);
        }

        .drop-zone-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .drop-zone-text {
            font-size: 0.875rem;
            color: var(--muted);
        }

        .drop-zone-text strong {
            color: var(--teal);
        }

        .drop-zone-sub {
            font-size: 0.75rem;
            color: var(--muted);
            margin-top: 4px;
        }

        .drop-zone input[type=file] {
            display: none;
        }

        .selected-file {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: var(--teal-pale);
            border: 1.5px solid rgba(0, 184, 153, 0.3);
            border-radius: var(--radius-sm);
            margin-top: 10px;
        }

        .selected-file-name {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--slate);
            flex: 1;
        }

        .selected-file-size {
            font-size: 0.72rem;
            color: var(--muted);
        }

        .selected-file-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 0.8rem;
            padding: 2px 4px;
            transition: color .15s;
        }

        .selected-file-remove:hover {
            color: var(--red-soft);
        }

        /* Visibility toggle */
        .visibility-options {
            display: flex;
            gap: 10px;
            margin-top: 6px;
        }

        .vis-option {
            flex: 1;
            padding: 10px 14px;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            text-align: center;
            transition: all .15s;
        }

        .vis-option.selected {
            border-color: var(--teal);
            background: var(--teal-pale);
        }

        .vis-option-icon {
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .vis-option-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--slate);
        }

        .vis-option-sub {
            font-size: 0.68rem;
            color: var(--muted);
        }

        /* ─── TOAST ──────────────────────────────────────────────── */
        .toast {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 999;
            background: var(--slate);
            color: #fff;
            padding: 13px 20px;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 10px;
            transform: translateY(80px);
            opacity: 0;
            transition: transform .3s cubic-bezier(0.34, 1.56, 0.64, 1), opacity .3s;
            pointer-events: none;
            max-width: 320px;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast-icon {
            font-size: 1rem;
        }

        /* ─── CONFIRM DIALOG ─────────────────────────────────────── */
        .confirm-modal {
            max-width: 400px;
        }

        .confirm-icon {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 10px;
        }

        .confirm-msg {
            text-align: center;
            font-size: 0.875rem;
            color: var(--muted);
            line-height: 1.6;
        }

        .confirm-title {
            text-align: center;
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--slate);
            margin-bottom: 8px;
        }

        /* ─── PREVIEW PANEL ──────────────────────────────────────── */
        .preview-modal {
            max-width: 680px;
        }

        .preview-header-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .preview-file-block {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            background: var(--paper);
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            margin-bottom: 20px;
        }

        .preview-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .preview-detail {}

        .preview-detail-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--muted);
            margin-bottom: 3px;
        }

        .preview-detail-value {
            font-size: 0.875rem;
            color: var(--slate);
            font-weight: 500;
        }

        .preview-desc-block {
            padding: 14px 16px;
            background: var(--paper);
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            margin-bottom: 20px;
        }

        .preview-desc-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .preview-desc-text {
            font-size: 0.875rem;
            color: var(--slate);
            line-height: 1.6;
        }

        /* ─── TABLE FOOTER ───────────────────────────────────────── */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: var(--cream);
            font-size: 0.8rem;
            color: var(--muted);
        }

        .pagination {
            display: flex;
            gap: 4px;
        }

        .page-btn {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: var(--card);
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            color: var(--slate);
            transition: all .15s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .page-btn:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        .page-btn.active {
            background: var(--slate);
            color: #fff;
            border-color: var(--slate);
        }

        /* ─── RESPONSIVE ─────────────────────────────────────────── */
        @media (max-width: 900px) {
            .category-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .col-hide-md {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .shell {
                margin-left: 0;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main {
                padding: 16px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 0 16px;
            }

            .topbar-search {
                display: none;
            }

            .col-hide-sm {
                display: none;
            }

            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }
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

        /* Documents responsive refinements */
        .shell,
        .main,
        .table-card,
        #tableView,
        #gridView {
            min-width: 0;
        }

        @media (max-width: 1200px) {
            .main {
                width: 100%;
                max-width: none;
                padding: 28px 24px;
            }

            .category-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 12px;
            }

            .filter-bar {
                align-items: flex-start;
            }

            .filter-right {
                width: 100%;
                margin-left: 0;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            #tableView {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            #tableView table {
                min-width: 920px;
            }

            .doc-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 960px) {
            .main {
                padding: 22px 18px;
            }

            .page-header {
                margin-bottom: 20px;
            }

            .inline-search-row {
                width: 100%;
                align-items: stretch;
            }

            .inline-search-row>span {
                width: 100%;
            }

            .page-header .topbar-search {
                display: flex;
                width: 100%;
                min-width: 0 !important;
                border-radius: 10px;
            }

            .category-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                margin-bottom: 22px;
            }

            .cat-card {
                padding: 16px;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .filter-label {
                width: 100%;
            }

            .filter-chips {
                width: 100%;
                gap: 7px;
            }

            .chip {
                flex: 1 1 calc(25% - 7px);
                text-align: center;
                white-space: nowrap;
            }

            .filter-right {
                justify-content: stretch;
            }

            .sort-select {
                flex: 1;
                min-width: 180px;
            }

            .table-head {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding: 14px 16px;
            }

            .table-head-left {
                justify-content: space-between;
            }

            .bulk-actions.visible {
                flex-wrap: wrap;
            }

            .bulk-count {
                width: 100%;
            }

            .bulk-btn {
                flex: 1 1 120px;
                justify-content: center;
            }

            .row-actions,
            .grid-actions {
                opacity: 1;
            }

            .doc-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
                padding: 16px;
            }

            .modal {
                max-width: min(560px, calc(100vw - 32px));
                max-height: calc(100vh - 32px);
            }

            .locked-options {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .preview-details-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .main {
                padding: 16px 12px;
            }

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

            .category-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .cat-card {
                display: grid;
                grid-template-columns: 36px 1fr auto;
                align-items: center;
                gap: 10px;
                padding: 14px;
            }

            .cat-card-icon {
                margin-bottom: 0;
                font-size: 1.25rem;
            }

            .cat-card-count {
                order: 3;
                margin-bottom: 0;
                font-size: 1.35rem;
            }

            .cat-card-label,
            .cat-card-sub {
                grid-column: 2;
            }

            .chip {
                flex: 1 1 calc(50% - 7px);
                padding: 7px 10px;
                white-space: normal;
            }

            .filter-right {
                flex-direction: column;
                align-items: stretch;
            }

            .sort-select,
            .view-toggle {
                width: 100%;
            }

            .view-btn {
                flex: 1;
            }

            .table-card {
                border-radius: 12px;
            }

            #tableView table {
                min-width: 760px;
            }

            thead th {
                padding: 10px 12px;
                font-size: 0.64rem;
            }

            td {
                padding: 11px 12px;
                font-size: 0.78rem;
            }

            .doc-filename {
                max-width: 220px;
            }

            .doc-description {
                max-width: 260px;
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

            .doc-grid {
                grid-template-columns: 1fr;
                padding: 12px;
            }

            .modal-overlay {
                padding: 12px;
                align-items: flex-start;
            }

            .modal-header,
            .modal-body,
            .modal-footer {
                padding-left: 16px;
                padding-right: 16px;
            }

            .modal-footer {
                flex-direction: column-reverse;
            }

            .modal-footer .btn-primary,
            .modal-footer .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .visibility-options {
                flex-direction: column;
            }

            .locked-options {
                grid-template-columns: 1fr;
            }

            .preview-file-block {
                align-items: flex-start;
            }

            .toast {
                left: 12px;
                right: 12px;
                bottom: 16px;
                max-width: none;
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

            .chip {
                flex-basis: 100%;
            }

            .cat-card {
                grid-template-columns: 32px 1fr;
            }

            .cat-card-count {
                grid-column: 2;
                order: initial;
            }

            #tableView table {
                min-width: 700px;
            }
        }
    </style>
</head>

<body class="dashboard-page">

    <!-- ─── SIDEBAR ─────────────────────────────────────────────── -->
    @include('subscriber.includes.sidebar')

    <!-- Overlay (mobile) -->
    <div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

    <!-- ─── SHELL ────────────────────────────────────────────────── -->
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
                <div class="page-title">Documents</div>
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
                <a href="#" class="topbar-btn" title="Help" onclick="event.preventDefault();">❓</a>
            </div>
        </header>

        <!-- Main -->
        <main class="main">

            <!-- Page Header -->
            <div class="page-header">
                <div class="page-header-left">
                    <div class="inline-search-row">
                        <span
                            style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:700;color:var(--slate);">Documents</span>
                        <div class="topbar-search" style="min-width:360px;">
                            <span class="search-icon">🔍</span>
                            <input type="text" id="globalSearch" placeholder="Search documents, clients…"
                                oninput="filterDocs()">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Summary Cards -->
            <div class="category-grid" id="categoryGrid">
                <!-- Injected by JS -->
            </div>

            <!-- Filter Bar -->
            <div class="filter-bar">
                <span class="filter-label">Category</span>
                <div class="filter-chips" id="filterChips">
                    <div class="chip active" onclick="setFilter('all', this)">All Documents</div>
                    <div class="chip" onclick="setFilter('Contract', this)">Contracts</div>
                    <div class="chip" onclick="setFilter('Invoice', this)">Invoices</div>
                    <div class="chip" onclick="setFilter('Proposal', this)">Proposals</div>
                    <div class="chip" onclick="setFilter('Report', this)">Reports</div>
                    <div class="chip" onclick="setFilter('Tax', this)">Tax</div>
                    <div class="chip" onclick="setFilter('Legal', this)">Legal</div>
                    <div class="chip" onclick="setFilter('Other', this)">Other</div>
                </div>
                <div class="filter-right">
                    <select class="sort-select" onchange="sortDocs(this.value)">
                        <option value="date-desc">Newest First</option>
                        <option value="date-asc">Oldest First</option>
                        <option value="name-asc">Name A–Z</option>
                        <option value="name-desc">Name Z–A</option>
                        <option value="size-desc">Largest First</option>
                        <option value="client-asc">Client A–Z</option>
                    </select>
                    <div class="view-toggle">
                        <button class="view-btn active" id="viewTable" onclick="setView('table')"
                            title="Table View">☰</button>
                        <button class="view-btn" id="viewGrid" onclick="setView('grid')" title="Grid View">⊞</button>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="table-card">

                <div class="table-head">
                    <div class="table-head-left">
                        <span class="table-title">Documents</span>
                        <span class="record-count" id="recordCount">0 records</span>
                    </div>
                    <div style="display:flex;gap:8px;">
                        <button class="btn-secondary" style="font-size:0.78rem;padding:6px 13px;"
                            onclick="exportDocs()">⬇ Export CSV</button>
                    </div>
                </div>

                <!-- Bulk Actions Bar -->
                <div class="bulk-actions" id="bulkActions">
                    <span class="bulk-count" id="bulkCount">0 selected</span>
                    <button class="bulk-btn" onclick="bulkShare()">📤 Share Selected</button>
                    <button class="bulk-btn" onclick="bulkArchive()">🗄 Archive</button>
                    <button class="bulk-btn" onclick="bulkDownload()">⬇ Download</button>
                    <button class="bulk-btn danger" onclick="bulkDelete()">🗑 Delete</button>
                    <button class="bulk-btn" onclick="clearSelection()" style="margin-left:auto;">✕ Clear</button>
                </div>

                <!-- Table View -->
                <div id="tableView">
                    <table>
                        <thead>
                            <tr>
                                <th class="td-check"><input type="checkbox" id="selectAll"
                                        onchange="toggleAll(this)"></th>
                                <th onclick="sortDocs('name-asc')">Document</th>
                                <th onclick="sortDocs('client-asc')" class="col-hide-md">Client</th>
                                <th onclick="sortDocs('cat-asc')">Category</th>
                                <th class="col-hide-md">Upload Date</th>
                                <th class="col-hide-md">Size</th>
                                <th>Visibility</th>
                                <th>Locked</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="docsTableBody">
                        </tbody>
                    </table>

                    <div id="tableEmpty" class="empty-state" style="display:none;">
                        <div class="empty-icon">📭</div>
                        <div class="empty-title">No documents found</div>
                        <div class="empty-text">Try adjusting your filters or upload a new document to get started.
                        </div>
                        <button class="btn-primary" style="margin-top:8px;" onclick="openUploadModal()">＋ Upload
                            Document</button>
                    </div>
                </div>

                <!-- Grid View -->
                <div id="gridView" style="display:none;">
                    <div class="doc-grid" id="docsGrid"></div>
                    <div id="gridEmpty" class="empty-state" style="display:none;">
                        <div class="empty-icon">📭</div>
                        <div class="empty-title">No documents found</div>
                        <div class="empty-text">Adjust your filters or upload a new document.</div>
                        <button class="btn-primary" style="margin-top:8px;" onclick="openUploadModal()">＋ Upload
                            Document</button>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="table-footer">
                    <span id="pageInfo">Showing 1–10 of 0</span>
                    <div class="pagination" id="pagination"></div>
                </div>
            </div>

        </main>
    </div>

    <!-- ══════════════════════════════════════════════════════════
     UPLOAD / EDIT MODAL
════════════════════════════════════════════════════════════ -->
    <div class="modal-overlay" id="uploadModal">
        <div class="modal">
            <div class="modal-header">
                <span class="modal-title" id="uploadModalTitle">Upload Document</span>
                <button class="modal-close" onclick="closeModal('uploadModal')">✕</button>
            </div>
            <div class="modal-body">

                <!-- Drop zone (hidden in edit mode) -->
                <div class="form-group" id="dropZoneGroup">
                    <label>File <span class="req">*</span></label>
                    <div class="drop-zone" id="dropZone" onclick="document.getElementById('fileInput').click()"
                        ondragover="dragOver(event)" ondragleave="dragLeave(event)" ondrop="dropFile(event)">
                        <div class="drop-zone-icon">📁</div>
                        <div class="drop-zone-text"><strong>Click to browse</strong> or drag &amp; drop</div>
                        <div class="drop-zone-sub">PDF, DOCX, XLSX, PPTX, PNG, JPG, ZIP, CSV, TXT · Max 50 MB</div>
                        <input type="file" id="fileInput"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.png,.jpg,.jpeg,.gif,.zip,.csv,.txt,.rtf,.odt,.ods"
                            onchange="fileSelected(this)">
                    </div>
                    <div id="selectedFileDisplay" style="display:none;"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Client <span class="req">*</span></label>
                        <select id="uploadClient">
                            <option value="">— Select client —</option>
                            <option value="CLT-001">Vertex Digital (CLT-001)</option>
                            <option value="CLT-002">Northbridge Consulting (CLT-002)</option>
                            <option value="CLT-003">Luminary Labs (CLT-003)</option>
                            <option value="CLT-004">Ironclad Systems (CLT-004)</option>
                            <option value="CLT-005">Harborview Group (CLT-005)</option>
                            <option value="CLT-006">Clearpath Analytics (CLT-006)</option>
                            <option value="CLT-007">BlueSky Media (CLT-007)</option>
                            <option value="internal">— Internal / No Client —</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category <span class="req">*</span></label>
                        <select id="uploadCategory" onchange="updateLockedOptionsForCategory(this.value)">
                            <option value="">— Select —</option>
                            <option value="Contract">Contract</option>
                            <option value="Invoice">Invoice</option>
                            <option value="Proposal">Proposal</option>
                            <option value="Report">Report</option>
                            <option value="Tax">Tax</option>
                            <option value="Legal">Legal</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Document Description</label>
                    <textarea id="uploadDesc" placeholder="Briefly describe this document (optional)…" rows="3"></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Document Date</label>
                        <input type="date" id="uploadDate">
                    </div>
                    <div class="form-group">
                        <label>Linked Project / Invoice</label>
                        <input type="text" id="uploadRef" placeholder="e.g. INV-0025, PRJ-012">
                    </div>
                </div>

                <div class="form-group">
                    <label>Visibility</label>
                    <div class="visibility-options">
                        <div class="vis-option selected" id="vis-private" onclick="selectVisibility('private')">
                            <div class="vis-option-icon">🔒</div>
                            <div class="vis-option-label">Private</div>
                            <div class="vis-option-sub">Only you can see</div>
                        </div>
                        <div class="vis-option" id="vis-shared" onclick="selectVisibility('shared')">
                            <div class="vis-option-icon">🔗</div>
                            <div class="vis-option-label">Shared</div>
                            <div class="vis-option-sub">Client can access</div>
                        </div>
                        <div class="vis-option" id="vis-archived" onclick="selectVisibility('archived')">
                            <div class="vis-option-icon">🗄</div>
                            <div class="vis-option-label">Archived</div>
                            <div class="vis-option-sub">Hidden, retained</div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Portal Lock Status <span style="font-weight:400;color:var(--muted);font-size:0.72rem;">—
                            controls client portal access</span></label>
                    <div class="locked-options" id="lockedOptions">
                        <div class="locked-option selected" id="lock-N" onclick="selectLocked('N')">
                            <div class="locked-option-badge N">N</div>
                            <div class="locked-option-label">Open</div>
                            <div class="locked-option-sub">Shared &amp; downloadable on portal</div>
                        </div>
                        <div class="locked-option" id="lock-Y" onclick="selectLocked('Y')">
                            <div class="locked-option-badge Y">Y</div>
                            <div class="locked-option-label">Shared Only</div>
                            <div class="locked-option-sub">Shared but hidden from portal</div>
                        </div>
                        <div class="locked-option" id="lock-P" onclick="selectLocked('P')">
                            <div class="locked-option-badge P">P</div>
                            <div class="locked-option-label">Payment Req.</div>
                            <div class="locked-option-sub">Download blocked until invoice paid</div>
                        </div>
                        <div class="locked-option" id="lock-H" onclick="selectLocked('H')">
                            <div class="locked-option-badge H">H</div>
                            <div class="locked-option-label">Hold</div>
                            <div class="locked-option-sub">Admin hold — not accessible</div>
                        </div>
                    </div>
                    <div id="lockedHint"
                        style="margin-top:8px;font-size:0.75rem;color:var(--muted);line-height:1.5;padding:8px 12px;background:var(--paper);border-radius:var(--radius-sm);border:1px solid var(--border);">
                    </div>
                </div>

                <div class="form-group">
                    <label>Tags <span style="font-weight:400;color:var(--muted);">(comma-separated)</span></label>
                    <input type="text" id="uploadTags" placeholder="e.g. Q1, renewal, signed">
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal('uploadModal')">Cancel</button>
                <button class="btn-primary" onclick="saveDocument()">💾 Save Document</button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════
     PREVIEW MODAL
════════════════════════════════════════════════════════════ -->
    <div class="modal-overlay" id="previewModal">
        <div class="modal preview-modal">
            <div class="modal-header">
                <span class="modal-title">Document Details</span>
                <button class="modal-close" onclick="closeModal('previewModal')">✕</button>
            </div>
            <div class="modal-body" id="previewContent"></div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal('previewModal')">Close</button>
                <button class="btn-secondary" onclick="editFromPreview()">✏️ Edit</button>
                <button class="btn-primary" onclick="downloadFromPreview()">⬇ Download</button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════
     CONFIRM DELETE MODAL
════════════════════════════════════════════════════════════ -->
    <div class="modal-overlay" id="confirmModal">
        <div class="modal confirm-modal">
            <div class="modal-header">
                <span class="modal-title">Confirm Delete</span>
                <button class="modal-close" onclick="closeModal('confirmModal')">✕</button>
            </div>
            <div class="modal-body">
                <div class="confirm-icon">🗑️</div>
                <div class="confirm-title">Delete this document?</div>
                <div class="confirm-msg" id="confirmMsg">This action cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeModal('confirmModal')">Cancel</button>
                <button class="btn-primary" style="background:var(--red-soft);"
                    onclick="confirmDeleteAction()">Delete</button>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <span class="toast-icon" id="toastIcon">✅</span>
        <span id="toastMsg">Done.</span>
    </div>

    <script>
        // ═══════════════════════════════════════
        //  DATA
        // ═══════════════════════════════════════

        const CATEGORIES = [{
                key: 'Contract',
                label: 'Contracts',
                icon: '📝',
                color: '#4f8ef7',
                bg: '#e8f0fe'
            },
            {
                key: 'Invoice',
                label: 'Invoices',
                icon: '🧾',
                color: '#00b899',
                bg: '#d6f5ef'
            },
            {
                key: 'Proposal',
                label: 'Proposals',
                icon: '💼',
                color: '#9b72cf',
                bg: '#f0eafd'
            },
            {
                key: 'Report',
                label: 'Reports',
                icon: '📊',
                color: '#f5a623',
                bg: '#fef3d8'
            },
            {
                key: 'Tax',
                label: 'Tax',
                icon: '🏦',
                color: '#2ecc71',
                bg: '#d4f7e7'
            },
            {
                key: 'Legal',
                label: 'Legal',
                icon: '⚖️',
                color: '#e67e22',
                bg: '#fef0e0'
            },
            {
                key: 'Other',
                label: 'Other',
                icon: '📎',
                color: '#78909c',
                bg: '#eceff1'
            },
        ];

        const CLIENTS = {
            'CLT-001': {
                name: 'Vertex Digital',
                initials: 'VD',
                color: '#4f8ef7'
            },
            'CLT-002': {
                name: 'Northbridge Consulting',
                initials: 'NC',
                color: '#9b72cf'
            },
            'CLT-003': {
                name: 'Luminary Labs',
                initials: 'LL',
                color: '#f5a623'
            },
            'CLT-004': {
                name: 'Ironclad Systems',
                initials: 'IS',
                color: '#e74c3c'
            },
            'CLT-005': {
                name: 'Harborview Group',
                initials: 'HG',
                color: '#2ecc71'
            },
            'CLT-006': {
                name: 'Clearpath Analytics',
                initials: 'CA',
                color: '#00b899'
            },
            'CLT-007': {
                name: 'BlueSky Media',
                initials: 'BM',
                color: '#e67e22'
            },
            'internal': {
                name: 'Internal',
                initials: 'IN',
                color: '#78909c'
            },
        };

        let docs = [{
                id: 'DOC-001',
                name: 'Service_Agreement_2026.pdf',
                ext: 'pdf',
                client: 'CLT-001',
                category: 'Contract',
                desc: 'Annual service agreement for web development retainer.',
                date: '2026-01-15',
                size: 245000,
                visibility: 'shared',
                locked: 'N',
                ref: 'PRJ-008',
                tags: ['signed', 'retainer']
            },
            {
                id: 'DOC-002',
                name: 'INV-0025_Vertex_Digital.pdf',
                ext: 'pdf',
                client: 'CLT-001',
                category: 'Invoice',
                desc: 'Invoice for January milestone delivery.',
                date: '2026-02-01',
                size: 124000,
                visibility: 'shared',
                locked: 'P',
                ref: 'INV-0025',
                tags: ['q1']
            },
            {
                id: 'DOC-003',
                name: 'Q1_Strategy_Proposal.docx',
                ext: 'docx',
                client: 'CLT-002',
                category: 'Proposal',
                desc: 'Q1 digital transformation strategy proposal.',
                date: '2026-01-22',
                size: 390000,
                visibility: 'private',
                locked: 'N',
                ref: '',
                tags: ['draft']
            },
            {
                id: 'DOC-004',
                name: 'Financial_Report_2025.xlsx',
                ext: 'xlsx',
                client: 'CLT-003',
                category: 'Report',
                desc: 'Full-year 2025 financial performance summary.',
                date: '2026-02-10',
                size: 812000,
                visibility: 'shared',
                locked: 'N',
                ref: '',
                tags: ['annual', '2025']
            },
            {
                id: 'DOC-005',
                name: 'Tax_Return_2025.pdf',
                ext: 'pdf',
                client: 'CLT-001',
                category: 'Tax',
                desc: 'Federal and state tax return filing.',
                date: '2026-03-15',
                size: 540000,
                visibility: 'private',
                locked: 'H',
                ref: '',
                tags: ['tax', '2025']
            },
            {
                id: 'DOC-006',
                name: 'NDA_Ironclad_Systems.pdf',
                ext: 'pdf',
                client: 'CLT-004',
                category: 'Legal',
                desc: 'Mutual non-disclosure agreement, effective Jan 2026.',
                date: '2026-01-10',
                size: 210000,
                visibility: 'shared',
                locked: 'Y',
                ref: '',
                tags: ['signed', 'nda']
            },
            {
                id: 'DOC-007',
                name: 'Brand_Guidelines_v3.pdf',
                ext: 'pdf',
                client: 'CLT-007',
                category: 'Other',
                desc: 'BlueSky brand identity and usage guidelines version 3.',
                date: '2026-02-28',
                size: 3400000,
                visibility: 'shared',
                locked: 'N',
                ref: 'PRJ-011',
                tags: ['brand']
            },
            {
                id: 'DOC-008',
                name: 'Project_Scope_Harborview.docx',
                ext: 'docx',
                client: 'CLT-005',
                category: 'Contract',
                desc: 'Scope of work and deliverables for website redesign.',
                date: '2026-01-30',
                size: 178000,
                visibility: 'private',
                locked: 'H',
                ref: 'PRJ-009',
                tags: ['sow']
            },
            {
                id: 'DOC-009',
                name: 'Q4_2025_Campaign_Report.pptx',
                ext: 'pptx',
                client: 'CLT-006',
                category: 'Report',
                desc: 'Q4 digital marketing campaign results presentation.',
                date: '2026-01-08',
                size: 2100000,
                visibility: 'shared',
                locked: 'N',
                ref: '',
                tags: ['q4', '2025']
            },
            {
                id: 'DOC-010',
                name: 'Vendor_Invoice_Adobe.pdf',
                ext: 'pdf',
                client: 'internal',
                category: 'Invoice',
                desc: 'Adobe Creative Cloud annual subscription invoice.',
                date: '2026-02-18',
                size: 95000,
                visibility: 'private',
                locked: 'P',
                ref: '',
                tags: ['vendor']
            },
            {
                id: 'DOC-011',
                name: 'Client_Onboarding_Checklist.xlsx',
                ext: 'xlsx',
                client: 'CLT-002',
                category: 'Other',
                desc: 'Standard onboarding checklist for new project kick-off.',
                date: '2026-03-01',
                size: 68000,
                visibility: 'shared',
                locked: 'N',
                ref: 'PRJ-010',
                tags: ['onboarding']
            },
            {
                id: 'DOC-012',
                name: 'Logo_Assets_BlueSky.zip',
                ext: 'zip',
                client: 'CLT-007',
                category: 'Other',
                desc: 'Full logo asset pack including SVG, PNG and EPS formats.',
                date: '2026-03-05',
                size: 8900000,
                visibility: 'shared',
                locked: 'Y',
                ref: 'PRJ-011',
                tags: ['brand', 'assets']
            },
            {
                id: 'DOC-013',
                name: 'Proposal_Clearpath_Analytics.pdf',
                ext: 'pdf',
                client: 'CLT-006',
                category: 'Proposal',
                desc: 'Data analytics platform proposal — revised version.',
                date: '2026-03-12',
                size: 421000,
                visibility: 'private',
                locked: 'N',
                ref: '',
                tags: ['revised']
            },
            {
                id: 'DOC-014',
                name: 'Payroll_Summary_Feb2026.csv',
                ext: 'csv',
                client: 'internal',
                category: 'Report',
                desc: 'February 2026 payroll breakdown.',
                date: '2026-03-03',
                size: 44000,
                visibility: 'private',
                locked: 'H',
                ref: '',
                tags: ['payroll']
            },
            {
                id: 'DOC-015',
                name: 'Meeting_Notes_Luminary.txt',
                ext: 'txt',
                client: 'CLT-003',
                category: 'Other',
                desc: 'Discovery meeting notes – brand refresh project.',
                date: '2026-03-10',
                size: 18000,
                visibility: 'private',
                locked: 'N',
                ref: 'PRJ-012',
                tags: ['notes']
            },
        ];

        // ═══════════════════════════════════════
        //  STATE
        // ═══════════════════════════════════════
        let activeFilter = 'all';
        let activeSort = 'date-desc';
        let activeView = 'table';
        let currentPage = 1;
        const PAGE_SIZE = 10;
        let selectedIds = new Set();
        let editingId = null;
        let deleteTargetId = null;
        let previewDocId = null;
        let selectedVisibility = 'private';
        let selectedLocked = 'N';

        // ═══════════════════════════════════════
        //  RENDER CATEGORY CARDS
        // ═══════════════════════════════════════
        function renderCategoryCards() {
            const grid = document.getElementById('categoryGrid');
            const total = docs.length;

            let html = `<div class="cat-card" style="--cat-color:#1e2a38;--cat-bg:#e8eaf0;" onclick="setFilterByKey('all')" id="cat-all">
    <div class="cat-card-icon">📂</div>
    <div class="cat-card-count">${total}</div>
    <div class="cat-card-label">All Documents</div>
    <div class="cat-card-sub">${docs.filter(d=>d.visibility==='shared').length} shared</div>
  </div>`;

            CATEGORIES.forEach(cat => {
                const count = docs.filter(d => d.category === cat.key).length;
                const sharedCount = docs.filter(d => d.category === cat.key && d.visibility === 'shared').length;
                html += `<div class="cat-card" style="--cat-color:${cat.color};--cat-bg:${cat.bg};" onclick="setFilterByKey('${cat.key}')" id="cat-${cat.key}">
      <div class="cat-card-icon">${cat.icon}</div>
      <div class="cat-card-count">${count}</div>
      <div class="cat-card-label">${cat.label}</div>
      <div class="cat-card-sub">${sharedCount} shared</div>
    </div>`;
            });

            grid.innerHTML = html;
            updateCatCardActive();
        }

        function updateCatCardActive() {
            document.querySelectorAll('.cat-card').forEach(c => c.classList.remove('active-filter'));
            const key = activeFilter === 'all' ? 'all' : activeFilter;
            const card = document.getElementById('cat-' + key);
            if (card) card.classList.add('active-filter');
        }

        function setFilterByKey(key) {
            activeFilter = key;
            currentPage = 1;
            updateCatCardActive();
            // sync chips
            document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            const chips = document.querySelectorAll('.chip');
            chips.forEach(c => {
                if ((key === 'all' && c.textContent === 'All Documents') ||
                    c.textContent.trim() === key + 's' ||
                    c.textContent.trim() === key) {
                    c.classList.add('active');
                }
            });
            render();
        }

        // ═══════════════════════════════════════
        //  FILTER / SORT
        // ═══════════════════════════════════════
        function setFilter(val, el) {
            activeFilter = val;
            currentPage = 1;
            document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            el.classList.add('active');
            updateCatCardActive();
            render();
        }

        function sortDocs(val) {
            activeSort = val;
            render();
        }

        function filterDocs() {
            currentPage = 1;
            render();
        }

        function getFiltered() {
            const q = document.getElementById('globalSearch').value.toLowerCase();
            return docs.filter(d => {
                const matchCat = activeFilter === 'all' || d.category === activeFilter;
                const matchQ = !q ||
                    d.name.toLowerCase().includes(q) ||
                    d.desc.toLowerCase().includes(q) ||
                    (CLIENTS[d.client]?.name || '').toLowerCase().includes(q) ||
                    d.id.toLowerCase().includes(q) ||
                    d.category.toLowerCase().includes(q) ||
                    d.tags.some(t => t.toLowerCase().includes(q));
                return matchCat && matchQ;
            }).sort((a, b) => {
                switch (activeSort) {
                    case 'date-desc':
                        return new Date(b.date) - new Date(a.date);
                    case 'date-asc':
                        return new Date(a.date) - new Date(b.date);
                    case 'name-asc':
                        return a.name.localeCompare(b.name);
                    case 'name-desc':
                        return b.name.localeCompare(a.name);
                    case 'size-desc':
                        return b.size - a.size;
                    case 'client-asc':
                        return (CLIENTS[a.client]?.name || '').localeCompare(CLIENTS[b.client]?.name || '');
                    default:
                        return 0;
                }
            });
        }

        // ═══════════════════════════════════════
        //  RENDER TABLE / GRID
        // ═══════════════════════════════════════
        function render() {
            renderCategoryCards();
            const filtered = getFiltered();
            const total = filtered.length;
            const start = (currentPage - 1) * PAGE_SIZE;
            const paged = filtered.slice(start, start + PAGE_SIZE);

            document.getElementById('recordCount').textContent = total + ' record' + (total !== 1 ? 's' : '');
            const end = Math.min(start + PAGE_SIZE, total);
            document.getElementById('pageInfo').textContent = total === 0 ? 'No results' :
                `Showing ${start+1}–${end} of ${total}`;

            if (activeView === 'table') renderTable(paged, total);
            else renderGrid(paged, total);

            renderPagination(total);
        }

        function fileIconEl(ext) {
            const e = ext.toLowerCase();
            return `<div class="file-icon ${e}">${e.toUpperCase()}</div>`;
        }

        function gridFileIconEl(ext) {
            const e = ext.toLowerCase();
            return `<div class="grid-file-icon ${e}">${e.toUpperCase()}</div>`;
        }

        function catBadge(key) {
            const cat = CATEGORIES.find(c => c.key === key);
            if (!cat) return key;
            return `<span class="cat-badge" style="background:${cat.bg};color:${cat.color};">
    <span class="dot"></span>${cat.label}
  </span>`;
        }

        function visBadge(v) {
            return `<span class="status-badge ${v}">${v.charAt(0).toUpperCase()+v.slice(1)}</span>`;
        }

        function lockedBadge(l) {
            const labels = {
                N: 'Open',
                Y: 'Shared Only',
                P: 'Payment Req.',
                H: 'Hold'
            };
            return `<span class="locked-badge ${l}" title="${lockedTooltip(l)}">${l}</span>`;
        }

        function lockedTooltip(l) {
            const tips = {
                N: 'N — Visible and downloadable on client portal',
                Y: 'Y — Shared but hidden from client portal',
                P: 'P — Visible but download requires invoice payment',
                H: 'H — Manually held by admin; not accessible on portal'
            };
            return tips[l] || l;
        }

        function fmtSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(0) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        }

        function fmtDate(d) {
            if (!d) return '—';
            return new Date(d + 'T00:00:00').toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function renderTable(paged, total) {
            const tbody = document.getElementById('docsTableBody');
            const empty = document.getElementById('tableEmpty');

            if (paged.length === 0) {
                tbody.innerHTML = '';
                empty.style.display = '';
                return;
            }
            empty.style.display = 'none';

            tbody.innerHTML = paged.map(doc => {
                const cl = CLIENTS[doc.client] || {
                    name: doc.client,
                    initials: '?',
                    color: '#999'
                };
                const checked = selectedIds.has(doc.id) ? 'checked' : '';
                return `<tr>
      <td class="td-check"><input type="checkbox" ${checked} onchange="toggleRow('${doc.id}', this)"></td>
      <td>
        <div class="doc-file-cell">
          ${fileIconEl(doc.ext)}
          <div class="doc-name-info">
            <div class="doc-filename" title="${doc.name}">${doc.name}</div>
            <div class="doc-description">${doc.desc || '<em style="color:var(--muted)">No description</em>'}</div>
          </div>
        </div>
      </td>
      <td class="col-hide-md">
        <div class="client-cell">
          <div class="client-dot" style="background:linear-gradient(135deg,${cl.color},${cl.color}cc)">${cl.initials}</div>
          <div>
            <div class="client-name">${cl.name}</div>
            <div class="client-id">${doc.client}</div>
          </div>
        </div>
      </td>
      <td>${catBadge(doc.category)}</td>
      <td class="col-hide-md" style="color:var(--muted);font-size:0.8rem;">${fmtDate(doc.date)}</td>
      <td class="col-hide-md"><span class="file-size">${fmtSize(doc.size)}</span></td>
      <td>${visBadge(doc.visibility)}</td>
      <td>${lockedBadge(doc.locked || 'N')}</td>
      <td style="text-align:right;">
        <div class="row-actions">
          <button class="row-btn" title="Preview" onclick="previewDoc('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
          <button class="row-btn" title="Download" onclick="downloadDoc('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
          <button class="row-btn" title="Share" onclick="shareDoc('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg></button>
          <button class="row-btn" title="Edit" onclick="editDoc('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
          <button class="row-btn danger" title="Delete" onclick="confirmDelete('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
        </div>
      </td>
    </tr>`;
            }).join('');
        }

        function renderGrid(paged, total) {
            const grid = document.getElementById('docsGrid');
            const empty = document.getElementById('gridEmpty');

            if (paged.length === 0) {
                grid.innerHTML = '';
                empty.style.display = '';
                return;
            }
            empty.style.display = 'none';

            grid.innerHTML = paged.map(doc => {
                const cl = CLIENTS[doc.client] || {
                    name: doc.client,
                    initials: '?',
                    color: '#999'
                };
                const cat = CATEGORIES.find(c => c.key === doc.category);
                const checked = selectedIds.has(doc.id) ? 'checked' : '';
                return `<div class="doc-grid-item">
      <div class="doc-grid-check"><input type="checkbox" ${checked} onchange="toggleRow('${doc.id}', this)"></div>
      ${gridFileIconEl(doc.ext)}
      <div class="grid-doc-name" title="${doc.name}">${doc.name}</div>
      <div class="grid-doc-desc">${doc.desc || 'No description provided.'}</div>
      <div class="grid-meta">
        <span class="grid-client-name">${cl.name}</span>
        <span class="grid-date">${fmtDate(doc.date)}</span>
      </div>
      ${cat ? `<div style="margin-top:8px;">${catBadge(doc.category)}</div>` : ''}
      <div class="grid-actions">
        <button class="row-btn" title="Preview" onclick="previewDoc('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
        <button class="row-btn" title="Download" onclick="downloadDoc('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></button>
        <button class="row-btn" title="Edit" onclick="editDoc('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
        <button class="row-btn danger" title="Delete" onclick="confirmDelete('${doc.id}')"><svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
      </div>
    </div>`;
            }).join('');
        }

        // ═══════════════════════════════════════
        //  PAGINATION
        // ═══════════════════════════════════════
        function renderPagination(total) {
            const pages = Math.ceil(total / PAGE_SIZE);
            const el = document.getElementById('pagination');
            if (pages <= 1) {
                el.innerHTML = '';
                return;
            }

            let html =
                `<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}>‹</button>`;
            for (let i = 1; i <= pages; i++) {
                if (pages > 7 && Math.abs(i - currentPage) > 2 && i !== 1 && i !== pages) {
                    if (i === 2 || i === pages - 1) html += `<button class="page-btn" disabled>…</button>`;
                    continue;
                }
                html += `<button class="page-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
            }
            html +=
                `<button class="page-btn" onclick="goPage(${currentPage+1})" ${currentPage===pages?'disabled':''}>›</button>`;
            el.innerHTML = html;
        }

        function goPage(p) {
            const total = getFiltered().length;
            const pages = Math.ceil(total / PAGE_SIZE);
            if (p < 1 || p > pages) return;
            currentPage = p;
            render();
        }

        // ═══════════════════════════════════════
        //  VIEW TOGGLE
        // ═══════════════════════════════════════
        function setView(v) {
            activeView = v;
            document.getElementById('tableView').style.display = v === 'table' ? '' : 'none';
            document.getElementById('gridView').style.display = v === 'grid' ? '' : 'none';
            document.getElementById('viewTable').classList.toggle('active', v === 'table');
            document.getElementById('viewGrid').classList.toggle('active', v === 'grid');
            render();
        }

        // ═══════════════════════════════════════
        //  SELECTION
        // ═══════════════════════════════════════
        function toggleRow(id, cb) {
            if (cb.checked) selectedIds.add(id);
            else selectedIds.delete(id);
            updateBulkBar();
        }

        function toggleAll(masterCb) {
            const filtered = getFiltered();
            const start = (currentPage - 1) * PAGE_SIZE;
            const paged = filtered.slice(start, start + PAGE_SIZE);
            paged.forEach(d => {
                if (masterCb.checked) selectedIds.add(d.id);
                else selectedIds.delete(d.id);
            });
            render();
            updateBulkBar();
        }

        function clearSelection() {
            selectedIds.clear();
            render();
            updateBulkBar();
        }

        function updateBulkBar() {
            const bar = document.getElementById('bulkActions');
            const n = selectedIds.size;
            if (n > 0) {
                bar.classList.add('visible');
                document.getElementById('bulkCount').textContent = n + ' selected';
            } else {
                bar.classList.remove('visible');
            }
        }

        // ═══════════════════════════════════════
        //  UPLOAD / EDIT MODAL
        // ═══════════════════════════════════════
        function openUploadModal() {
            editingId = null;
            selectedVisibility = 'private';
            selectedLocked = 'N';
            document.getElementById('uploadModalTitle').textContent = 'Upload Document';
            document.getElementById('dropZoneGroup').style.display = '';
            document.getElementById('uploadClient').value = '';
            document.getElementById('uploadCategory').value = '';
            document.getElementById('uploadDesc').value = '';
            document.getElementById('uploadDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('uploadRef').value = '';
            document.getElementById('uploadTags').value = '';
            document.getElementById('selectedFileDisplay').style.display = 'none';
            selectVisibility('private');
            selectLocked('N');
            updateLockedOptionsForCategory('');
            openModal('uploadModal');
        }

        function editDoc(id) {
            const doc = docs.find(d => d.id === id);
            if (!doc) return;
            editingId = id;
            document.getElementById('uploadModalTitle').textContent = 'Edit Document';
            document.getElementById('dropZoneGroup').style.display = 'none';
            document.getElementById('uploadClient').value = doc.client;
            document.getElementById('uploadCategory').value = doc.category;
            document.getElementById('uploadDesc').value = doc.desc;
            document.getElementById('uploadDate').value = doc.date;
            document.getElementById('uploadRef').value = doc.ref;
            document.getElementById('uploadTags').value = doc.tags.join(', ');
            selectVisibility(doc.visibility);
            selectLocked(doc.locked || 'N');
            updateLockedOptionsForCategory(doc.category);
            closeModal('previewModal');
            openModal('uploadModal');
        }

        function editFromPreview() {
            if (previewDocId) editDoc(previewDocId);
        }

        function saveDocument() {
            const client = document.getElementById('uploadClient').value;
            const category = document.getElementById('uploadCategory').value;
            const desc = document.getElementById('uploadDesc').value.trim();
            const date = document.getElementById('uploadDate').value;
            const ref = document.getElementById('uploadRef').value.trim();
            const tagsRaw = document.getElementById('uploadTags').value;
            const tags = tagsRaw.split(',').map(t => t.trim()).filter(Boolean);

            if (!editingId && !category) {
                toast('Please select a category.', '⚠️');
                return;
            }

            if (editingId) {
                const doc = docs.find(d => d.id === editingId);
                if (doc) {
                    doc.client = client || doc.client;
                    doc.category = category || doc.category;
                    doc.desc = desc;
                    doc.date = date || doc.date;
                    doc.ref = ref;
                    doc.tags = tags;
                    doc.visibility = selectedVisibility;
                    doc.locked = selectedLocked;
                }
                toast('Document updated successfully.', '✅');
            } else {
                if (!client) {
                    toast('Please select a client.', '⚠️');
                    return;
                }
                const fi = document.getElementById('fileInput');
                const file = fi.files[0];
                const name = file ? file.name : 'Uploaded_Document.pdf';
                const ext = name.split('.').pop().toLowerCase();
                const size = file ? file.size : 100000;
                const newId = 'DOC-' + String(docs.length + 1).padStart(3, '0');
                docs.unshift({
                    id: newId,
                    name,
                    ext,
                    client,
                    category,
                    desc,
                    date: date || new Date().toISOString().split('T')[0],
                    size,
                    visibility: selectedVisibility,
                    locked: selectedLocked,
                    ref,
                    tags
                });
                toast('Document uploaded successfully.', '✅');
            }

            closeModal('uploadModal');
            render();
        }

        // ═══════════════════════════════════════
        //  DRAG & DROP
        // ═══════════════════════════════════════
        function dragOver(e) {
            e.preventDefault();
            e.currentTarget.classList.add('drag-over');
        }

        function dragLeave(e) {
            e.currentTarget.classList.remove('drag-over');
        }

        function dropFile(e) {
            e.preventDefault();
            e.currentTarget.classList.remove('drag-over');
            if (e.dataTransfer.files[0]) showSelectedFile(e.dataTransfer.files[0]);
        }

        function fileSelected(input) {
            if (input.files[0]) showSelectedFile(input.files[0]);
        }

        function showSelectedFile(file) {
            const el = document.getElementById('selectedFileDisplay');
            el.style.display = '';
            el.innerHTML = `<div class="selected-file">
    <span style="font-size:1.2rem;">${getFileEmoji(file.name)}</span>
    <span class="selected-file-name">${file.name}</span>
    <span class="selected-file-size">${fmtSize(file.size)}</span>
    <button class="selected-file-remove" onclick="clearFile()">✕</button>
  </div>`;
        }

        function clearFile() {
            document.getElementById('selectedFileDisplay').style.display = 'none';
            document.getElementById('fileInput').value = '';
        }

        function getFileEmoji(name) {
            const ext = name.split('.').pop().toLowerCase();
            const map = {
                pdf: '📕',
                docx: '📘',
                doc: '📘',
                xlsx: '📗',
                xls: '📗',
                pptx: '📙',
                ppt: '📙',
                png: '🖼',
                jpg: '🖼',
                jpeg: '🖼',
                zip: '🗜',
                csv: '📊',
                txt: '📄'
            };
            return map[ext] || '📎';
        }

        // ═══════════════════════════════════════
        //  VISIBILITY
        // ═══════════════════════════════════════
        function selectVisibility(v) {
            selectedVisibility = v;
            ['private', 'shared', 'archived'].forEach(o => {
                document.getElementById('vis-' + o).classList.toggle('selected', o === v);
            });
        }

        // ═══════════════════════════════════════
        //  LOCKED STATUS
        // ═══════════════════════════════════════
        const LOCKED_HINTS = {
            N: '✅ <strong>Open (N)</strong> — Document is visible on the client portal and fully downloadable.',
            Y: '🔒 <strong>Shared Only (Y)</strong> — Document is shared with the client but will not appear on the client portal.',
            P: '💳 <strong>Payment Required (P)</strong> — Document is visible on the portal but download is blocked until the linked invoice is paid.',
            H: '🚫 <strong>Hold (H)</strong> — Admin-placed hold. Document is not accessible on the client portal for any reason until manually released.'
        };

        function selectLocked(v) {
            selectedLocked = v;
            ['N', 'Y', 'P', 'H'].forEach(o => {
                const el = document.getElementById('lock-' + o);
                if (el) el.classList.toggle('selected', o === v);
            });
            const hint = document.getElementById('lockedHint');
            if (hint) hint.innerHTML = LOCKED_HINTS[v] || '';
        }

        function updateLockedOptionsForCategory(category) {
            const hOption = document.getElementById('lock-H');
            if (!hOption) return;
            const noH = ['Invoice', 'Quote'].includes(category);
            hOption.classList.toggle('disabled', noH);
            // if currently set to H and category disallows it, reset to N
            if (noH && selectedLocked === 'H') selectLocked('N');
        }

        // ═══════════════════════════════════════
        //  PREVIEW
        // ═══════════════════════════════════════
        function previewDoc(id) {
            const doc = docs.find(d => d.id === id);
            if (!doc) return;
            previewDocId = id;
            const cl = CLIENTS[doc.client] || {
                name: doc.client,
                initials: '?',
                color: '#999'
            };
            const cat = CATEGORIES.find(c => c.key === doc.category);

            document.getElementById('previewContent').innerHTML = `
    <div class="preview-file-block">
      ${fileIconEl(doc.ext)}
      <div>
        <div style="font-size:0.95rem;font-weight:600;color:var(--slate);margin-bottom:4px;">${doc.name}</div>
        <div style="font-size:0.78rem;color:var(--muted);">${fmtSize(doc.size)} · ${doc.ext.toUpperCase()} file · ${doc.id}</div>
      </div>
    </div>
    <div class="preview-details-grid">
      <div class="preview-detail">
        <div class="preview-detail-label">Client</div>
        <div class="preview-detail-value">${cl.name} (${doc.client})</div>
      </div>
      <div class="preview-detail">
        <div class="preview-detail-label">Category</div>
        <div class="preview-detail-value">${catBadge(doc.category)}</div>
      </div>
      <div class="preview-detail">
        <div class="preview-detail-label">Upload Date</div>
        <div class="preview-detail-value">${fmtDate(doc.date)}</div>
      </div>
      <div class="preview-detail">
        <div class="preview-detail-label">Visibility</div>
        <div class="preview-detail-value">${visBadge(doc.visibility)}</div>
      </div>
      <div class="preview-detail">
        <div class="preview-detail-label">Portal Lock</div>
        <div class="preview-detail-value">${lockedBadge(doc.locked || 'N')} <span style="font-size:0.72rem;color:var(--muted);margin-left:6px;">${lockedTooltip(doc.locked||'N').split('—')[1]?.trim()||''}</span></div>
      </div>
      <div class="preview-detail">
        <div class="preview-detail-label">Linked Ref.</div>
        <div class="preview-detail-value">${doc.ref || '—'}</div>
      </div>
      <div class="preview-detail">
        <div class="preview-detail-label">Tags</div>
        <div class="preview-detail-value">${doc.tags.length ? doc.tags.map(t=>`<span style="background:var(--cream);padding:2px 7px;border-radius:99px;font-size:0.72rem;margin-right:4px;">${t}</span>`).join('') : '—'}</div>
      </div>
    </div>
    <div class="preview-desc-block">
      <div class="preview-desc-label">Description</div>
      <div class="preview-desc-text">${doc.desc || 'No description provided.'}</div>
    </div>
  `;
            openModal('previewModal');
        }

        function downloadFromPreview() {
            if (previewDocId) downloadDoc(previewDocId);
        }

        // ═══════════════════════════════════════
        //  ROW ACTIONS
        // ═══════════════════════════════════════
        function downloadDoc(id) {
            const doc = docs.find(d => d.id === id);
            toast(`Downloading ${doc?.name || 'document'}…`, '⬇️');
        }

        function shareDoc(id) {
            const doc = docs.find(d => d.id === id);
            if (!doc) return;
            doc.visibility = 'shared';
            render();
            toast('Document shared with client.', '📤');
        }

        function confirmDelete(id) {
            deleteTargetId = id;
            const doc = docs.find(d => d.id === id);
            document.getElementById('confirmMsg').textContent =
                `"${doc?.name}" will be permanently deleted and cannot be recovered.`;
            openModal('confirmModal');
        }

        function confirmDeleteAction() {
            if (deleteTargetId) {
                docs = docs.filter(d => d.id !== deleteTargetId);
                selectedIds.delete(deleteTargetId);
                deleteTargetId = null;
                closeModal('confirmModal');
                render();
                updateBulkBar();
                toast('Document deleted.', '🗑️');
            }
        }

        // ═══════════════════════════════════════
        //  BULK ACTIONS
        // ═══════════════════════════════════════
        function bulkShare() {
            selectedIds.forEach(id => {
                const d = docs.find(x => x.id === id);
                if (d) d.visibility = 'shared';
            });
            toast(`${selectedIds.size} documents shared.`, '📤');
            clearSelection();
        }

        function bulkArchive() {
            selectedIds.forEach(id => {
                const d = docs.find(x => x.id === id);
                if (d) d.visibility = 'archived';
            });
            toast(`${selectedIds.size} documents archived.`, '🗄️');
            clearSelection();
        }

        function bulkDownload() {
            toast(`Downloading ${selectedIds.size} documents…`, '⬇️');
            clearSelection();
        }

        function bulkDelete() {
            const n = selectedIds.size;
            if (!confirm(`Delete ${n} selected document${n!==1?'s':''}? This cannot be undone.`)) return;
            docs = docs.filter(d => !selectedIds.has(d.id));
            selectedIds.clear();
            render();
            updateBulkBar();
            toast(`${n} document${n!==1?'s':''} deleted.`, '🗑️');
        }

        // ═══════════════════════════════════════
        //  EXPORT
        // ═══════════════════════════════════════
        function exportDocs() {
            const filtered = getFiltered();
            const header =
                'ID,Name,Extension,Client ID,Client Name,Category,Description,Date,Size (bytes),Visibility,Locked,Reference,Tags';
            const rows = filtered.map(d => [
                d.id, `"${d.name}"`, d.ext, d.client,
                `"${CLIENTS[d.client]?.name||d.client}"`,
                d.category, `"${d.desc}"`,
                d.date, d.size, d.visibility, d.locked || 'N', d.ref,
                `"${d.tags.join('; ')}"`
            ].join(','));
            const csv = [header, ...rows].join('\n');
            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'billflow_documents.csv';
            a.click();
            toast('CSV exported.', '⬇️');
        }

        // ═══════════════════════════════════════
        //  MODAL HELPERS
        // ═══════════════════════════════════════
        function openModal(id) {
            document.getElementById(id).classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
            document.body.style.overflow = '';
        }

        // Close modal on overlay click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });

        // ═══════════════════════════════════════
        //  TOAST
        // ═══════════════════════════════════════
        let toastTimer;

        function toast(msg, icon = '✅') {
            const el = document.getElementById('toast');
            document.getElementById('toastMsg').textContent = msg;
            document.getElementById('toastIcon').textContent = icon;
            el.classList.add('show');
            clearTimeout(toastTimer);
            toastTimer = setTimeout(() => el.classList.remove('show'), 3000);
        }

        // ═══════════════════════════════════════
        //  SIDEBAR SUBMENU
        // ═══════════════════════════════════════
        function toggleDocSubmenu(el) {
            el.classList.toggle('open');
            document.getElementById('docSubmenu').classList.toggle('open');
        }

        // ═══════════════════════════════════════
        //  INIT
        // ═══════════════════════════════════════
        render();
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
