<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Velo — Items</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
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
    --muted: #6b7280;
    --border: #ddd8cc;
    --border-dark: rgba(255,255,255,0.08);
    --card: #ffffff;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
    --shadow-md: 0 8px 32px rgba(0,0,0,0.10);
    --shadow-lg: 0 24px 64px rgba(0,0,0,0.13);
    --radius: 16px;
    --radius-sm: 10px;
    --sidebar-w: 260px;
    --topbar-h: 64px;
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }

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
    top: 0; left: 0; bottom: 0;
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
    top: -80px; left: -80px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(0,184,153,0.18) 0%, transparent 65%);
    pointer-events: none;
  }
  .sidebar::after {
    content: '';
    position: absolute;
    bottom: 60px; right: -60px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(245,166,35,0.12) 0%, transparent 65%);
    pointer-events: none;
  }
  .sidebar-grid {
    position: absolute; inset: 0;
    background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
    background-size: 22px 22px;
    pointer-events: none;
  }
  .sidebar-inner {
    position: relative; z-index: 1;
    display: flex; flex-direction: column;
    height: 100%; padding: 0;
  }
  .sidebar-logo {
    padding: 22px 24px 20px;
    border-bottom: 1px solid var(--border-dark);
    flex-shrink: 0;
  }
  .sidebar-logo a {
    font-family: 'Syne', sans-serif;
    font-weight: 800; font-size: 1.35rem;
    letter-spacing: -0.04em; color: #fff;
    text-decoration: none;
  }
  .sidebar-logo a span { color: var(--teal); }
  .sidebar-user {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 24px;
    border-bottom: 1px solid var(--border-dark);
    flex-shrink: 0;
  }
  .user-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--teal), var(--teal-dark));
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.8rem; color: #fff;
    flex-shrink: 0;
  }
  .user-details { min-width: 0; }
  .user-name { font-size: 0.82rem; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .user-plan { font-size: 0.7rem; color: var(--teal); font-weight: 500; }

  .sidebar-nav {
    flex: 1; overflow-y: auto; padding: 12px 0;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.1) transparent;
  }
  .sidebar-nav::-webkit-scrollbar { width: 4px; }
  .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }
  .nav-section-label {
    font-size: 0.65rem; font-weight: 600;
    letter-spacing: 0.1em; text-transform: uppercase;
    color: rgba(255,255,255,0.3);
    padding: 14px 24px 6px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 11px;
    padding: 9px 20px 9px 24px;
    cursor: pointer; color: rgba(255,255,255,0.65);
    font-size: 0.875rem; font-weight: 400;
    text-decoration: none;
    transition: background .15s, color .15s;
    border-left: 3px solid transparent;
  }
  .nav-item:hover { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.9); }
  .nav-item.active {
    background: rgba(0,184,153,0.14);
    color: var(--teal); font-weight: 600;
    border-left-color: var(--teal);
  }
  .nav-item .nav-icon { font-size: 1rem; width: 20px; text-align: center; flex-shrink: 0; }
  .nav-item .nav-label { flex: 1; }
  .nav-badge {
    font-size: 0.6rem; font-weight: 700;
    padding: 2px 6px; border-radius: 99px;
    background: var(--amber); color: var(--slate);
    text-transform: uppercase; letter-spacing: 0.04em;
  }
  .nav-badge.red { background: var(--red-soft); color: #fff; }
  .nav-count {
    font-size: 0.7rem; font-weight: 600;
    padding: 1px 7px; border-radius: 99px;
    background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.5);
  }
  .sidebar-footer {
    padding: 16px 24px;
    border-top: 1px solid var(--border-dark);
    flex-shrink: 0;
  }
  .sidebar-footer a {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; border-radius: var(--radius-sm);
    color: rgba(255,255,255,0.5); font-size: 0.82rem;
    text-decoration: none;
    transition: background .15s, color .15s;
  }
  .sidebar-footer a:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.8); }

  /* ─── LAYOUT SHELL ────────────────────────────────────── */
  .shell { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
  body.dashboard-sidebar-collapsed .sidebar { transform: translateX(-100%); }
  body.dashboard-sidebar-collapsed .shell { margin-left: 0; }

  /* ─── TOP BAR ─────────────────────────────────────────── */
  .topbar {
    position: sticky; top: 0; z-index: 40;
    height: var(--topbar-h);
    background: rgba(245,242,235,0.92);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 0 32px; gap: 16px;
  }
  .topbar-left { display: flex; align-items: center; gap: 16px; min-width: 0; }
  .page-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.15rem; font-weight: 700;
    color: var(--slate); letter-spacing: -0.02em;
    white-space: nowrap;
  }
  .sidebar-toggle-btn {
    width: 38px; height: 38px; border-radius: 10px; border: 1.5px solid var(--border); background: var(--card);
    display: inline-flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; cursor: pointer; transition: all .15s;
  }
  .sidebar-toggle-btn:hover { border-color: var(--teal); background: var(--teal-pale); }
  .sidebar-toggle-btn span { display: block; width: 16px; height: 2px; border-radius: 99px; background: var(--slate); }

  .topbar-search {
    min-width: 260px; height: 38px; border: 1.5px solid var(--border); border-radius: 10px;
    background: var(--card); display: flex; align-items: center; gap: 8px; padding: 0 12px;
  }
  .topbar-search:focus-within { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(0,184,153,0.1); }
  .topbar-search input { border: none; outline: none; background: transparent; font-family: 'DM Sans', sans-serif; font-size: 0.85rem; width: 100%; color: var(--ink); }
  .search-icon { color: var(--muted); font-size: 0.85rem; }
  .topbar-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
  .topbar-btn {
    position: relative; width: 38px; height: 38px; border-radius: 10px; border: 1.5px solid var(--border);
    background: var(--card); color: var(--slate); display: flex; align-items: center; justify-content: center;
    text-decoration: none; cursor: pointer; transition: all .15s; font-size: 1rem;
  }
  .topbar-btn:hover { border-color: var(--teal); color: var(--teal); background: var(--teal-pale); }
  .topbar-dot { position: absolute; top: 5px; right: 5px; width: 7px; height: 7px; background: var(--red-soft); border-radius: 50%; border: 1.5px solid var(--paper); }
  .btn-new-invoice {
    display: inline-flex; align-items: center; gap: 7px; padding: 10px 18px; border-radius: 10px;
    background: var(--teal); color: #fff; border: none; font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem; font-weight: 700; cursor: pointer; transition: all .15s; white-space: nowrap;
  }
  .btn-new-invoice:hover { background: var(--teal-dark); transform: translateY(-1px); }

  /* ─── MAIN CONTENT ────────────────────────────────────── */
  .main { flex: 1; padding: 32px; overflow-y: auto; }

  .page-header {
    display: flex; align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 28px; gap: 20px; flex-wrap: wrap;
  }
  .page-header-left h1 {
    font-family: 'Syne', sans-serif;
    font-size: 1.6rem; font-weight: 700;
    color: var(--slate); letter-spacing: -0.03em;
  }
  .page-header-left p { font-size: 0.85rem; color: var(--muted); margin-top: 3px; }
  .page-header-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

  /* ─── BUTTONS ─────────────────────────────────────────── */
  .btn-primary {
    display: flex; align-items: center; gap: 7px;
    padding: 9px 20px;
    background: var(--teal); color: #fff;
    border: none; border-radius: 99px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem; font-weight: 600;
    cursor: pointer;
    transition: background .2s, transform .15s, box-shadow .2s;
    white-space: nowrap;
  }
  .btn-primary:hover {
    background: var(--teal-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(0,184,153,0.35);
  }
  .btn-secondary {
    padding: 9px 18px;
    background: var(--card);
    border: 1.5px solid var(--border);
    border-radius: 99px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem; font-weight: 500;
    color: var(--ink); cursor: pointer;
    transition: border-color .2s, background .2s;
    white-space: nowrap;
    display: flex; align-items: center; gap: 6px;
  }
  .btn-secondary:hover { border-color: var(--slate); background: var(--cream); }
  .btn-danger {
    padding: 9px 18px;
    background: var(--red-pale);
    border: 1.5px solid #f9c0c0;
    border-radius: 99px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem; font-weight: 600;
    color: var(--red-soft); cursor: pointer;
    transition: background .2s, border-color .2s;
    white-space: nowrap;
    display: flex; align-items: center; gap: 6px;
  }
  .btn-danger:hover { background: #fbd0d0; border-color: var(--red-soft); }

  /* ─── KPI CARDS ───────────────────────────────────────── */
  .kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 16px; margin-bottom: 28px;
  }
  .kpi-card {
    background: var(--card);
    border-radius: var(--radius);
    padding: 20px 22px;
    border: 1.5px solid var(--border);
    box-shadow: var(--shadow-sm);
    cursor: pointer;
  }
  .kpi-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
  .kpi-label { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.07em; color: var(--muted); }
  .kpi-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
  }
  .icon-teal { background: var(--teal-pale); }
  .icon-amber { background: var(--amber-pale); }
  .icon-red { background: var(--red-pale); }
  .icon-slate { background: var(--cream); }
  .kpi-value {
    font-family: 'Syne', sans-serif;
    font-size: 1.75rem; font-weight: 700;
    color: var(--slate); line-height: 1;
    margin-bottom: 6px;
  }
  .kpi-change { font-size: 0.72rem; font-weight: 500; }
  .kpi-change.up { color: var(--teal); }
  .kpi-change.neutral { color: var(--muted); }
  .kpi-change.down { color: var(--red-soft); }

  /* ─── TOOLBAR ─────────────────────────────────────────── */
  .toolbar {
    display: flex; align-items: center;
    justify-content: space-between;
    gap: 12px; margin-bottom: 16px; flex-wrap: wrap;
  }
  .toolbar-left { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
  .toolbar-right { display: flex; align-items: center; gap: 10px; }

  .filter-tabs { display: flex; gap: 4px; }
  .filter-tab {
    padding: 6px 14px;
    background: transparent;
    border: 1.5px solid var(--border);
    border-radius: 99px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem; font-weight: 500;
    color: var(--muted); cursor: pointer;
    transition: all .15s;
  }
  .filter-tab:hover { border-color: var(--slate); color: var(--slate); }
  .filter-tab.active {
    background: var(--slate); border-color: var(--slate);
    color: #fff; font-weight: 600;
  }

  .sort-select {
    padding: 7px 12px;
    border: 1.5px solid var(--border);
    border-radius: 99px;
    background: var(--card);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem; color: var(--ink);
    cursor: pointer; outline: none;
  }
  .sort-select:focus { border-color: var(--teal); }

  .type-select {
    padding: 7px 12px;
    border: 1.5px solid var(--border);
    border-radius: 99px;
    background: var(--card);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem; color: var(--ink);
    cursor: pointer; outline: none;
  }
  .type-select:focus { border-color: var(--teal); }

  /* ─── BULK BAR ────────────────────────────────────────── */
  .bulk-bar {
    display: none; align-items: center; gap: 10px;
    background: var(--slate);
    border-radius: var(--radius-sm);
    padding: 10px 18px;
    margin-bottom: 12px;
    color: rgba(255,255,255,0.8);
    font-size: 0.82rem; flex-wrap: wrap;
  }
  .bulk-bar.visible { display: flex; }
  .bulk-bar-count { font-weight: 700; color: var(--teal); }
  .bulk-bar-actions { display: flex; gap: 6px; margin-left: auto; flex-wrap: wrap; }
  .bulk-btn {
    padding: 5px 13px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 99px;
    color: rgba(255,255,255,0.85);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 500;
    cursor: pointer;
    transition: background .15s;
  }
  .bulk-btn:hover { background: rgba(255,255,255,0.2); }
  .bulk-btn.danger { color: #ff8a8a; border-color: rgba(240,84,84,0.4); }
  .bulk-btn.danger:hover { background: rgba(240,84,84,0.2); }

  /* ─── TABLE ───────────────────────────────────────────── */
  .table-card {
    background: var(--card);
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
  }
  .table-wrap { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; min-width: 860px; }
  thead tr { background: var(--cream); }
  th {
    padding: 11px 14px;
    font-size: 0.7rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--muted); text-align: left;
    border-bottom: 1.5px solid var(--border);
    white-space: nowrap; cursor: pointer;
    user-select: none;
  }
  th:first-child { padding-left: 18px; }
  th:last-child { padding-right: 18px; cursor: default; }
  .th-inner { display: flex; align-items: center; gap: 5px; }
  .sort-arrow { opacity: 0.4; font-size: 0.65rem; }
  th:hover .sort-arrow { opacity: 0.9; }

  tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background .12s;
  }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: #faf9f5; }
  tbody tr.selected { background: var(--teal-pale); }
  td {
    padding: 13px 14px;
    font-size: 0.85rem; color: var(--ink);
    vertical-align: middle;
  }
  td:first-child { padding-left: 18px; }
  td:last-child { padding-right: 18px; }

  .item-num {
    font-family: 'Syne', sans-serif;
    font-size: 0.78rem; font-weight: 700;
    color: var(--slate); letter-spacing: 0.02em;
  }
  .item-short-desc { font-weight: 500; color: var(--ink); }
  .item-full-desc {
    font-size: 0.78rem; color: var(--muted);
    margin-top: 2px; max-width: 260px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }

  .badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px; border-radius: 99px;
    font-size: 0.7rem; font-weight: 600;
    white-space: nowrap;
  }
  .badge-product { background: var(--amber-pale); color: #c77d0a; }
  .badge-service { background: var(--teal-pale); color: var(--teal-dark); }
  .badge-active { background: var(--teal-pale); color: var(--teal-dark); }
  .badge-inactive { background: var(--cream); color: var(--muted); }

  .unit-amount {
    font-family: 'Syne', sans-serif;
    font-weight: 600; color: var(--slate);
    font-size: 0.9rem;
  }

  .row-actions { display: flex; align-items: center; gap: 6px; }
  .row-btn {
    width: 30px; height: 30px;
    border: 1.5px solid var(--border);
    background: transparent; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; cursor: pointer;
    color: var(--muted);
    transition: all .15s;
  }
  .row-btn:hover { border-color: var(--slate); color: var(--slate); background: var(--cream); }
  .row-btn.del:hover { border-color: var(--slate); color: var(--slate); background: var(--cream); }

  /* Toggle switch */
  .toggle-wrap { display: flex; align-items: center; gap: 7px; }
  .toggle {
    position: relative; width: 34px; height: 18px;
    display: inline-block; cursor: pointer;
  }
  .toggle input { opacity: 0; width: 0; height: 0; }
  .toggle-slider {
    position: absolute; inset: 0;
    background: var(--border); border-radius: 99px;
    transition: background .2s;
  }
  .toggle-slider::before {
    content: '';
    position: absolute; top: 2px; left: 2px;
    width: 14px; height: 14px;
    background: #fff; border-radius: 50%;
    transition: transform .2s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
  }
  .toggle input:checked + .toggle-slider { background: var(--teal); }
  .toggle input:checked + .toggle-slider::before { transform: translateX(16px); }
  .toggle-label { font-size: 0.75rem; color: var(--muted); }

  /* Pagination */
  .pagination {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-top: 1px solid var(--border);
    font-size: 0.8rem; color: var(--muted);
    flex-wrap: wrap; gap: 10px;
  }
  .page-btns { display: flex; gap: 4px; }
  .page-btn {
    width: 32px; height: 32px;
    border: 1.5px solid var(--border);
    background: var(--card); border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem; cursor: pointer; color: var(--ink);
    display: flex; align-items: center; justify-content: center;
    transition: all .15s;
  }
  .page-btn:hover { border-color: var(--teal); color: var(--teal); }
  .page-btn.active { background: var(--slate); border-color: var(--slate); color: #fff; font-weight: 700; }
  .page-btn:disabled { opacity: 0.35; cursor: default; }

  /* Empty state */
  .empty-state {
    padding: 60px 32px; text-align: center;
  }
  .empty-icon { font-size: 2.8rem; margin-bottom: 14px; opacity: 0.5; }
  .empty-title { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: var(--slate); margin-bottom: 6px; }
  .empty-sub { font-size: 0.85rem; color: var(--muted); margin-bottom: 20px; }

  /* ─── MODAL ───────────────────────────────────────────── */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(14,22,32,0.55);
    backdrop-filter: blur(4px);
    z-index: 100;
    align-items: center; justify-content: center;
    padding: 20px;
  }
  .modal-overlay.open { display: flex; }

  .modal {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    width: 100%; max-width: 580px;
    max-height: 90vh;
    display: flex; flex-direction: column;
    animation: slideUp .22s ease;
  }
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .modal-header {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 22px 26px 0;
  }
  .modal-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.1rem; font-weight: 700;
    color: var(--slate);
  }
  .modal-subtitle { font-size: 0.82rem; color: var(--muted); padding: 4px 26px 16px; border-bottom: 1.5px solid var(--border); }
  .modal-close {
    width: 32px; height: 32px;
    background: var(--cream); border: none;
    border-radius: 50%; cursor: pointer;
    font-size: 0.75rem; color: var(--muted);
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, color .15s;
  }
  .modal-close:hover { background: var(--red-pale); color: var(--red-soft); }
  .modal-body { overflow-y: auto; padding: 22px 26px; flex: 1; }
  .modal-footer {
    padding: 16px 26px;
    border-top: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: flex-end; gap: 10px;
    flex-shrink: 0;
  }

  /* Form */
  .form-section { margin-bottom: 22px; }
  .form-section-title {
    font-size: 0.72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: var(--muted); margin-bottom: 14px;
    padding-bottom: 6px; border-bottom: 1px solid var(--border);
  }
  .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .form-grid.cols-1 { grid-template-columns: 1fr; }
  .form-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
  .form-row { display: flex; flex-direction: column; gap: 5px; }
  .form-row.span-2 { grid-column: span 2; }
  .form-row.span-3 { grid-column: span 3; }
  label { font-size: 0.78rem; font-weight: 500; color: var(--slate); }
  .req { color: var(--red-soft); }
  .form-input, .form-select, .form-textarea {
    padding: 9px 12px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem; color: var(--ink);
    background: var(--card);
    outline: none; transition: border-color .2s;
    width: 100%;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: var(--teal); }
  .form-textarea { resize: vertical; min-height: 80px; line-height: 1.5; }
  .form-hint { font-size: 0.72rem; color: var(--muted); margin-top: 2px; }

  .radio-group { display: flex; gap: 10px; }
  .radio-option {
    flex: 1; border: 2px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 12px 14px; cursor: pointer;
    transition: border-color .15s, background .15s;
    display: flex; align-items: center; gap: 10px;
  }
  .radio-option:hover { border-color: var(--teal); background: var(--teal-pale); }
  .radio-option.selected { border-color: var(--teal); background: var(--teal-pale); }
  .radio-option input { accent-color: var(--teal); }
  .radio-option-label { font-size: 0.85rem; font-weight: 600; color: var(--slate); }
  .radio-option-sub { font-size: 0.72rem; color: var(--muted); margin-top: 1px; }

  /* Change history */
  .change-history-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
  }
  .change-history-item {
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 11px 14px;
  }
  .change-history-label {
    font-size: 0.68rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.07em;
    color: var(--muted); margin-bottom: 5px;
  }
  .change-history-value {
    font-size: 0.82rem; font-weight: 500;
    color: var(--slate);
  }
  @media (max-width: 520px) {
    .change-history-grid { grid-template-columns: 1fr; }
  }

  /* Tax panel */
  .tax-panel {
    margin-top: 14px;
    background: var(--cream);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 16px 18px;
    display: none;
  }
  .tax-panel.visible { display: block; }
  .tax-panel-title {
    font-size: 0.72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.09em;
    color: var(--muted); margin-bottom: 14px;
  }

  /* Delete confirm modal */
  .delete-modal {
    background: var(--card);
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    width: 100%; max-width: 420px;
    padding: 32px;
    text-align: center;
    animation: slideUp .22s ease;
  }
  .delete-icon { font-size: 2.5rem; margin-bottom: 12px; }
  .delete-title { font-family: 'Syne', sans-serif; font-size: 1.1rem; font-weight: 700; color: var(--slate); margin-bottom: 8px; }
  .delete-sub { font-size: 0.85rem; color: var(--muted); margin-bottom: 24px; line-height: 1.5; }
  .delete-actions { display: flex; gap: 10px; justify-content: center; }

  /* Toast */
  .toast-container {
    position: fixed; bottom: 24px; right: 24px;
    z-index: 200; display: flex; flex-direction: column; gap: 8px;
  }
  .toast {
    background: var(--slate); color: #fff;
    padding: 12px 18px; border-radius: var(--radius-sm);
    font-size: 0.82rem; font-weight: 500;
    box-shadow: var(--shadow-md);
    animation: toastIn .2s ease;
    display: flex; align-items: center; gap: 8px;
    min-width: 220px;
  }
  .toast.success { border-left: 3px solid var(--teal); }
  .toast.error { border-left: 3px solid var(--red-soft); }
  .toast.info { border-left: 3px solid var(--amber); }
  @keyframes toastIn {
    from { opacity: 0; transform: translateX(20px); }
    to   { opacity: 1; transform: translateX(0); }
  }

  .sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(13,13,13,0.45);
    backdrop-filter: blur(3px); z-index: 45;
  }
  .sidebar-overlay.open, .sidebar-overlay.visible { display: block; }

  @media (max-width: 960px) {
    .sidebar { transform: translateX(-100%); transition: transform .25s; }
    .sidebar.open { transform: translateX(0); }
    .shell, body.dashboard-sidebar-collapsed .shell { margin-left: 0; }
    .topbar { padding: 0 16px; }
    .topbar-search { display: none; }
  }
  @media (max-width: 768px) {
    .kpi-grid { grid-template-columns: 1fr 1fr; }
    .form-grid { grid-template-columns: 1fr; }
    .form-grid.cols-3 { grid-template-columns: 1fr; }
    .form-row.span-2, .form-row.span-3 { grid-column: span 1; }
  }
</style>
</head>
<body>

<!-- ─── SIDEBAR ─────────────────────────────────────────── -->
@include('subscriber.includes.sidebar')

<!-- Overlay (mobile) -->
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- ─── MAIN SHELL ─────────────────────────────────────── -->
<div class="shell">

  <!-- Topbar -->
  <header class="topbar">
    <div class="topbar-left">
      <button class="sidebar-toggle-btn" type="button" onclick="toggleDashboardSidebar()" aria-label="Toggle sidebar" aria-expanded="true">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="page-title">Items</div>
      <div class="topbar-search">
        <span class="search-icon">🔍</span>
        <input type="text" id="searchInput" placeholder="Search catalog..." oninput="renderTable()">
      </div>
    </div>
    <div class="topbar-right">
      <a href="{{ route('subscriber.notifications') }}" class="topbar-btn" title="Notifications">
        🔔
        <span class="topbar-dot"></span>
      </a>
      <a href="#" class="topbar-btn" title="Help" onclick="event.preventDefault();toast('📦 Products and services catalog.');">❓</a>
    </div>
  </header>

  <!-- Main -->
  <main class="main">

    <!-- Page header -->
    <div class="page-header">
      <div class="page-header-left">
        <h1>Products &amp; Services</h1>
        <p>Manage your item catalog — products and services that can be added to any quote or invoice.</p>
      </div>
      <div class="page-header-actions">
        <button class="btn-secondary" onclick="exportCSV()">⬇ Export CSV</button>
        <button class="btn-primary" onclick="openAddModal()">＋ New Item</button>
      </div>
    </div>

    <!-- KPI Grid -->
    <div class="kpi-grid">
      <div class="kpi-card" onclick="setFilter('all', document.querySelector('.filter-tab:nth-child(1)'))">
        <div class="kpi-header">
          <span class="kpi-label">Total Items</span>
          <div class="kpi-icon icon-teal">📦</div>
        </div>
        <div class="kpi-value" id="kpiTotal">{{ $kpiTotal ?? 0 }}</div>
        <div class="kpi-change neutral" id="kpiTotalSub">Products &amp; Services</div>
      </div>
      <div class="kpi-card" onclick="setFilter('product', document.querySelector('.filter-tab:nth-child(2)'))">
        <div class="kpi-header">
          <span class="kpi-label">Products</span>
          <div class="kpi-icon icon-amber">🛒</div>
        </div>
        <div class="kpi-value" id="kpiProducts">{{ $kpiProducts ?? 0 }}</div>
        <div class="kpi-change neutral" id="kpiProductsSub">Physical &amp; digital goods</div>
      </div>
      <div class="kpi-card" onclick="setFilter('service', document.querySelector('.filter-tab:nth-child(3)'))">
        <div class="kpi-header">
          <span class="kpi-label">Services</span>
          <div class="kpi-icon icon-teal">⚡</div>
        </div>
        <div class="kpi-value" id="kpiServices">{{ $kpiServices ?? 0 }}</div>
        <div class="kpi-change neutral" id="kpiServicesSub">Billable services</div>
      </div>
      <div class="kpi-card" onclick="setFilter('active', document.querySelector('.filter-tab:nth-child(4)'))">
        <div class="kpi-header">
          <span class="kpi-label">Active</span>
          <div class="kpi-icon icon-teal">✅</div>
        </div>
        <div class="kpi-value" id="kpiActive">{{ $kpiActive ?? 0 }}</div>
        <div class="kpi-change up" id="kpiActiveSub">↑ Available for billing</div>
      </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
      <div class="toolbar-left">
        <div class="filter-tabs">
          <button class="filter-tab active" onclick="setFilter('all',this)">All</button>
          <button class="filter-tab" onclick="setFilter('product',this)">Products</button>
          <button class="filter-tab" onclick="setFilter('service',this)">Services</button>
          <button class="filter-tab" onclick="setFilter('active',this)">Active</button>
          <button class="filter-tab" onclick="setFilter('inactive',this)">Inactive</button>
        </div>
        <select class="type-select" id="sortSelect" onchange="renderTable()">
          <option value="num_asc">Sort: Item # ↑</option>
          <option value="num_desc">Sort: Item # ↓</option>
          <option value="name_asc">Sort: Name A–Z</option>
          <option value="name_desc">Sort: Name Z–A</option>
          <option value="price_asc">Sort: Price ↑</option>
          <option value="price_desc">Sort: Price ↓</option>
        </select>
      </div>
    </div>

    <!-- Bulk Action Bar -->
    <div class="bulk-bar" id="bulkBar">
      <span>Selected:</span>
      <span class="bulk-bar-count" id="bulkCount">0</span> items
      <div class="bulk-bar-actions">
        <button class="bulk-btn" onclick="bulkSetStatus(true)">✅ Set Active</button>
        <button class="bulk-btn" onclick="bulkSetStatus(false)">⏸ Set Inactive</button>
        <button class="bulk-btn danger" onclick="bulkDelete()">🗑 Delete</button>
        <button class="bulk-btn" onclick="clearSelection()">✕ Clear</button>
      </div>
    </div>

    <!-- Table -->
    <div class="table-card">
      <div class="table-wrap">
        <table id="itemTable">
          <thead>
            <tr>
              <th style="width:40px;cursor:default"><input type="checkbox" id="selectAll" onchange="toggleAll(this)"></th>
              <th onclick="sortBy('num')"><div class="th-inner">Item # <span class="sort-arrow">↕</span></div></th>
              <th onclick="sortBy('shortDesc')"><div class="th-inner">Short Description <span class="sort-arrow">↕</span></div></th>
              <th onclick="sortBy('fullDesc')" style="min-width:200px"><div class="th-inner">Full Description <span class="sort-arrow">↕</span></div></th>
              <th onclick="sortBy('uom')"><div class="th-inner">UOM <span class="sort-arrow">↕</span></div></th>
              <th onclick="sortBy('type')"><div class="th-inner">Type <span class="sort-arrow">↕</span></div></th>
              <th onclick="sortBy('price')"><div class="th-inner">Unit Amount <span class="sort-arrow">↕</span></div></th>
              <th onclick="sortBy('taxFlag')"><div class="th-inner">Tax <span class="sort-arrow">↕</span></div></th>
              <th onclick="sortBy('status')"><div class="th-inner">Status <span class="sort-arrow">↕</span></div></th>
              <th style="width:110px;cursor:default">Actions</th>
            </tr>
          </thead>
          <tbody id="itemBody"></tbody>
        </table>
      </div>
      <div class="empty-state" id="emptyState" style="display:none">
        <div class="empty-icon">📦</div>
        <div class="empty-title">No items found</div>
        <div class="empty-sub">Try adjusting your search or filters, or add your first item.</div>
        <button class="btn-primary" onclick="openAddModal()">＋ New Item</button>
      </div>
      <div class="pagination">
        <span id="paginationInfo">Showing 0 items</span>
        <div class="page-btns" id="pageBtns"></div>
      </div>
    </div>

  </main>
</div>

<!-- ─── ADD / EDIT ITEM MODAL ──────────────────────────── -->
<div class="modal-overlay" id="itemModal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="modalTitle">New Item</span>
      <button class="modal-close" onclick="closeModal('itemModal')">✕</button>
    </div>
    <p class="modal-subtitle" id="modalSubtitle">Fill in the details to add a new product or service to your catalog.</p>
    <div class="modal-body">

      <!-- Item Type -->
      <div class="form-section">
        <div class="form-section-title">Item Type</div>
        <div class="radio-group">
          <label class="radio-option selected" id="radioProduct" onclick="selectType('product')">
            <input type="radio" name="itemType" value="product" checked>
            <div>
              <div class="radio-option-label">Product</div>
              <div class="radio-option-sub">Physical or digital good</div>
            </div>
          </label>
          <label class="radio-option" id="radioService" onclick="selectType('service')">
            <input type="radio" name="itemType" value="service">
            <div>
              <div class="radio-option-label">Service</div>
              <div class="radio-option-sub">Billable labor or service</div>
            </div>
          </label>
        </div>
      </div>

      <!-- Core Info -->
      <div class="form-section">
        <div class="form-section-title">Item Details</div>
        <div class="form-grid cols-1">
          <div class="form-row">
            <label>Item Number <span class="req">*</span></label>
            <input class="form-input" type="text" placeholder="e.g. PROD-001 or SVC-001" id="f_num">
            <span class="form-hint">Unique identifier for this item — used on invoices and quotes.</span>
          </div>
        </div>
        <div class="form-grid cols-1" style="margin-top:12px">
          <div class="form-row">
            <label>Short Description <span class="req">*</span></label>
            <input class="form-input" type="text" placeholder="Brief name shown on invoice lines" id="f_shortDesc" maxlength="80">
            <span class="form-hint">Appears on invoice/quote line items. Keep it concise (max 80 chars).</span>
          </div>
        </div>
        <div class="form-grid cols-1" style="margin-top:12px">
          <div class="form-row">
            <label>Full Description</label>
            <textarea class="form-textarea" placeholder="Detailed description of the product or service…" id="f_fullDesc"></textarea>
            <span class="form-hint">Optional extended description for internal use or client-facing documents.</span>
          </div>
        </div>
      </div>

      <!-- Pricing & UOM -->
      <div class="form-section">
        <div class="form-section-title">Pricing &amp; Unit of Measure</div>
        <div class="form-grid cols-3">
          <div class="form-row">
            <label>Unit Amount <span class="req">*</span></label>
            <input class="form-input" type="number" placeholder="0.00" id="f_price" min="0" step="0.01">
          </div>
          <div class="form-row">
            <label>Currency</label>
            <select class="form-select" id="f_currency">
              <option value="USD">USD — $</option>
              <option value="EUR">EUR — €</option>
              <option value="GBP">GBP — £</option>
              <option value="CAD">CAD — C$</option>
              <option value="AUD">AUD — A$</option>
            </select>
          </div>
          <div class="form-row">
            <label>Unit of Measure <span class="req">*</span></label>
            <select class="form-select" id="f_uom">
              <option value="Each">Each</option>
              <option value="Hour">Hour</option>
              <option value="Day">Day</option>
              <option value="Month">Month</option>
              <option value="Year">Year</option>
              <option value="Project">Project</option>
              <option value="Sq Ft">Sq Ft</option>
              <option value="Linear Ft">Linear Ft</option>
              <option value="Lbs">Lbs</option>
              <option value="kg">kg</option>
              <option value="License">License</option>
              <option value="Seat">Seat</option>
              <option value="Unit">Unit</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tax -->
      <div class="form-section">
        <div class="form-section-title">Tax</div>
        <div class="radio-group">
          <label class="radio-option selected" id="radioTaxable" onclick="selectTax('taxable')">
            <input type="radio" name="taxFlag" value="taxable" checked>
            <div>
              <div class="radio-option-label">🧾 Taxable</div>
              <div class="radio-option-sub">Tax applies to this item</div>
            </div>
          </label>
          <label class="radio-option" id="radioExempt" onclick="selectTax('exempt')">
            <input type="radio" name="taxFlag" value="exempt">
            <div>
              <div class="radio-option-label">🚫 Tax Exempt</div>
              <div class="radio-option-sub">No tax charged</div>
            </div>
          </label>
        </div>

        <!-- Tax source panel -->
        <div class="tax-panel visible" id="taxPanel">
          <div class="tax-panel-title">Tax Calculation Source</div>
          <div class="form-grid" style="margin-bottom:14px">
            <div class="form-row span-2">
              <label>Tax Source <span class="req">*</span></label>
              <select class="form-select" id="f_taxSource" onchange="onTaxSourceChange()">
                <option value="">— Select source —</option>
                <option value="manual">Manual Rate — enter a fixed tax %</option>
                <option value="avatax">Avalara AvaTax — auto-calculate by address</option>
                <option value="taxjar">TaxJar — auto-calculate by address</option>
                <option value="stripe_tax">Stripe Tax — calculated at payment</option>
                <option value="custom">Custom / External API</option>
              </select>
              <span class="form-hint">Determines how tax is computed when this item appears on an invoice or quote.</span>
            </div>
          </div>

          <!-- Manual rate sub-panel -->
          <div id="taxManualPanel" style="display:none">
            <div class="form-grid cols-3">
              <div class="form-row">
                <label>Tax Rate (%) <span class="req">*</span></label>
                <input class="form-input" type="number" id="f_taxRate" placeholder="e.g. 8.25" min="0" max="100" step="0.01">
              </div>
              <div class="form-row">
                <label>Tax Name / Label</label>
                <input class="form-input" type="text" id="f_taxName" placeholder="e.g. Sales Tax, VAT, GST">
              </div>
              <div class="form-row">
                <label>Tax Code</label>
                <input class="form-input" type="text" id="f_taxCode" placeholder="e.g. TX-001">
              </div>
            </div>
          </div>

          <!-- Avalara / TaxJar sub-panel -->
          <div id="taxAutoPanel" style="display:none">
            <div class="form-grid">
              <div class="form-row">
                <label>Product Tax Code</label>
                <input class="form-input" type="text" id="f_ptc" placeholder="e.g. P0000000, SW054111">
                <span class="form-hint">Provider-specific code that classifies this item for tax rules.</span>
              </div>
              <div class="form-row">
                <label>Tax Category</label>
                <select class="form-select" id="f_taxCategory">
                  <option value="">— General / Default —</option>
                  <option value="software">Software / SaaS</option>
                  <option value="digital_goods">Digital Goods</option>
                  <option value="physical_goods">Physical Goods</option>
                  <option value="professional_services">Professional Services</option>
                  <option value="consulting">Consulting</option>
                  <option value="shipping">Shipping / Freight</option>
                  <option value="subscription">Subscription</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Stripe Tax sub-panel -->
          <div id="taxStripePanel" style="display:none">
            <div class="form-grid">
              <div class="form-row">
                <label>Stripe Tax Code</label>
                <input class="form-input" type="text" id="f_stripeTaxCode" placeholder="e.g. txcd_10000000">
                <span class="form-hint">Stripe product tax code. See Stripe's tax code reference.</span>
              </div>
              <div class="form-row">
                <label>Tax Behavior</label>
                <select class="form-select" id="f_taxBehavior">
                  <option value="exclusive">Exclusive — tax added on top</option>
                  <option value="inclusive">Inclusive — tax included in price</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Custom API sub-panel -->
          <div id="taxCustomPanel" style="display:none">
            <div class="form-grid cols-1">
              <div class="form-row">
                <label>External Tax Code / Reference</label>
                <input class="form-input" type="text" id="f_extTaxCode" placeholder="Reference code passed to your external tax API">
                <span class="form-hint">This value will be included in the tax calculation API request payload.</span>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Status -->
      <div class="form-section">
        <div class="form-section-title">Status</div>
        <div class="toggle-wrap">
          <label class="toggle">
            <input type="checkbox" id="f_active" checked>
            <span class="toggle-slider"></span>
          </label>
          <span class="toggle-label" id="statusLabel">Active — available for invoices &amp; quotes</span>
        </div>
      </div>

      <!-- Change History -->
      <div class="form-section" id="changeHistorySection" style="display:none;margin-bottom:0">
        <div class="form-section-title">Change History</div>
        <div class="change-history-grid">
          <div class="change-history-item">
            <div class="change-history-label">Status Effective Date</div>
            <div class="change-history-value" id="ch_statusDate">—</div>
          </div>
          <div class="change-history-item">
            <div class="change-history-label">Last Updated</div>
            <div class="change-history-value" id="ch_updatedDate">—</div>
          </div>
          <div class="change-history-item">
            <div class="change-history-label">Last Updated By</div>
            <div class="change-history-value" id="ch_updatedBy">—</div>
          </div>
        </div>
      </div>

    </div>
    <div class="modal-footer">
      <button class="btn-secondary" onclick="closeModal('itemModal')">Cancel</button>
      <button class="btn-primary" id="saveItemBtn" onclick="saveItem()">Save</button>
    </div>
  </div>
</div>

<!-- ─── DELETE CONFIRM MODAL ───────────────────────────── -->
<div class="modal-overlay" id="deleteModal">
  <div class="delete-modal">
    <div class="delete-icon">🗑️</div>
    <div class="delete-title">Delete Item?</div>
    <div class="delete-sub" id="deleteSubText">This will permanently remove this item from your catalog. It cannot be undone.</div>
    <div class="delete-actions">
      <button class="btn-secondary" onclick="closeModal('deleteModal')">Cancel</button>
      <button class="btn-danger" id="confirmDeleteBtn" onclick="confirmDelete()">Delete Item</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="toast-container" id="toastContainer"></div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ─── DATA LOADED FROM CONTROLLER ───────────────────────────
let items = @json($jsItems ?? []);
let nextItemNumDefault = @json($nextItemNum ?? 'ITEM-001');

let currentFilter = 'all';
let currentPage = 1;
const PAGE_SIZE = 10;
let selectedIds = new Set();
let editingId = null;
let deletingId = null;

// ─── RENDER ──────────────────────────────────────────────
function getFiltered() {
  const q = (document.getElementById('searchInput')?.value || '').toLowerCase();
  return items.filter(it => {
    if (currentFilter === 'product' && it.type !== 'product') return false;
    if (currentFilter === 'service' && it.type !== 'service') return false;
    if (currentFilter === 'active' && !it.active) return false;
    if (currentFilter === 'inactive' && it.active) return false;
    if (q) {
      return (it.num || '').toLowerCase().includes(q) ||
             (it.shortDesc || '').toLowerCase().includes(q) ||
             (it.fullDesc || '').toLowerCase().includes(q) ||
             (it.uom || '').toLowerCase().includes(q) ||
             (it.type || '').toLowerCase().includes(q);
    }
    return true;
  });
}

function getSorted(arr) {
  const s = document.getElementById('sortSelect')?.value || 'num_asc';
  return [...arr].sort((a,b) => {
    if (s === 'num_asc')   return (a.num || '').localeCompare(b.num || '');
    if (s === 'num_desc')  return (b.num || '').localeCompare(a.num || '');
    if (s === 'name_asc')  return (a.shortDesc || '').localeCompare(b.shortDesc || '');
    if (s === 'name_desc') return (b.shortDesc || '').localeCompare(a.shortDesc || '');
    if (s === 'price_asc') return (a.price || 0) - (b.price || 0);
    if (s === 'price_desc')return (b.price || 0) - (a.price || 0);
    return 0;
  });
}

function renderTable() {
  const filtered = getSorted(getFiltered());
  const totalPages = Math.max(1, Math.ceil(filtered.length / PAGE_SIZE));
  if (currentPage > totalPages) currentPage = totalPages;
  const start = (currentPage - 1) * PAGE_SIZE;
  const slice = filtered.slice(start, start + PAGE_SIZE);

  const tbody = document.getElementById('itemBody');
  const empty = document.getElementById('emptyState');

  if (filtered.length === 0) {
    tbody.innerHTML = '';
    empty.style.display = '';
  } else {
    empty.style.display = 'none';
    tbody.innerHTML = slice.map(it => `
      <tr id="row-${it.id}" class="${selectedIds.has(it.id) ? 'selected' : ''}">
        <td><input type="checkbox" class="row-check" ${selectedIds.has(it.id) ? 'checked' : ''} onchange="toggleRow(${it.id}, this)"></td>
        <td><span class="item-num">${esc(it.num)}</span></td>
        <td>
          <div class="item-short-desc">${esc(it.shortDesc)}</div>
        </td>
        <td><div class="item-full-desc" title="${esc(it.fullDesc)}">${esc(it.fullDesc) || '<span style="color:var(--border)">—</span>'}</div></td>
        <td><span style="font-size:.8rem;background:var(--cream);padding:3px 9px;border-radius:99px;font-weight:500">${uomAbbr(it.uom)}</span></td>
        <td><span class="badge ${it.type === 'product' ? 'badge-product' : 'badge-service'}">${it.type === 'product' ? 'Prod' : 'Svc'}</span></td>
        <td><span class="unit-amount">${fmtCurrency(it.price, it.currency)}</span></td>
        <td><span style="font-size:.82rem;font-weight:600;color:${it.taxFlag==='taxable'?'var(--ink)':'var(--muted)'}">${it.taxFlag==='taxable'?'Yes':'No'}</span>${it.taxFlag==='taxable'&&it.taxSource?`<div style="font-size:.68rem;color:var(--muted);margin-top:2px">${taxSourceLabel(it.taxSource)}${it.taxSource==='manual'&&it.taxRate?` &middot; ${it.taxRate}%`:''}</div>`:''}</td>
        <td>
          <label class="toggle" title="Toggle active/inactive" onclick="event.stopPropagation()">
            <input type="checkbox" ${it.active ? 'checked' : ''} onchange="toggleStatus(${it.id}, this)">
            <span class="toggle-slider"></span>
          </label>
        </td>
        <td>
          <div class="row-actions">
            <button class="row-btn" title="Edit" onclick="openEditModal(${it.id})">&#9998;</button>
            <button class="row-btn del" title="Delete" onclick="openDeleteModal(${it.id})">&#128465;</button>
          </div>
        </td>
      </tr>
    `).join('');
  }

  // Pagination
  const info = document.getElementById('paginationInfo');
  const s2 = filtered.length > 0 ? start + 1 : 0;
  const e2 = Math.min(start + PAGE_SIZE, filtered.length);
  info.textContent = filtered.length === 0 ? 'No items' : `Showing ${s2}–${e2} of ${filtered.length} items`;
  renderPagination(totalPages);

  // KPI
  updateKPI();
  updateBulkBar();
  document.getElementById('selectAll').checked = slice.length > 0 && slice.every(it => selectedIds.has(it.id));
}

function renderPagination(totalPages) {
  const container = document.getElementById('pageBtns');
  let html = `<button class="page-btn" onclick="prevPage()" ${currentPage===1?'disabled':''}>‹</button>`;
  for (let i=1;i<=totalPages;i++) {
    html += `<button class="page-btn ${currentPage===i?'active':''}" onclick="goPage(${i})">${i}</button>`;
  }
  html += `<button class="page-btn" onclick="nextPage()" ${currentPage===totalPages?'disabled':''}>›</button>`;
  container.innerHTML = html;
}

function updateKPI() {
  const all = items;
  const prods = all.filter(i=>i.type==='product').length;
  const svcs  = all.filter(i=>i.type==='service').length;
  const act   = all.filter(i=>i.active).length;
  document.getElementById('kpiTotal').textContent = all.length;
  document.getElementById('kpiProducts').textContent = prods;
  document.getElementById('kpiServices').textContent = svcs;
  document.getElementById('kpiActive').textContent = act;
}

function updateBulkBar() {
  const bar = document.getElementById('bulkBar');
  document.getElementById('bulkCount').textContent = selectedIds.size;
  bar.classList.toggle('visible', selectedIds.size > 0);
}

function fmtCurrency(n, cur) {
  const sym = {USD:'$',EUR:'€',GBP:'£',CAD:'C$',AUD:'A$'}[cur]||'$';
  return sym + Number(n||0).toLocaleString('en-US', {minimumFractionDigits:2,maximumFractionDigits:2});
}

function esc(s) {
  if (!s) return '';
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// ─── FILTER / SORT / PAGE ────────────────────────────────
function setFilter(f, el) {
  currentFilter = f;
  currentPage = 1;
  document.querySelectorAll('.filter-tab').forEach(t=>t.classList.remove('active'));
  if (el) el.classList.add('active');
  renderTable();
}

function sortBy(col) {
  const sel = document.getElementById('sortSelect');
  const map = { num:'num_asc', shortDesc:'name_asc', price:'price_asc' };
  if (map[col]) sel.value = map[col];
  renderTable();
}

function goPage(p) { currentPage = p; renderTable(); }
function prevPage() { if (currentPage > 1) { currentPage--; renderTable(); } }
function nextPage() {
  const total = Math.ceil(getFiltered().length / PAGE_SIZE);
  if (currentPage < total) { currentPage++; renderTable(); }
}

// ─── SELECTION ───────────────────────────────────────────
function toggleAll(cb) {
  const filtered = getSorted(getFiltered());
  const start = (currentPage-1)*PAGE_SIZE;
  const slice = filtered.slice(start, start+PAGE_SIZE);
  slice.forEach(it => {
    if (cb.checked) selectedIds.add(it.id);
    else selectedIds.delete(it.id);
  });
  renderTable();
}

function toggleRow(id, cb) {
  if (cb.checked) selectedIds.add(id);
  else selectedIds.delete(id);
  document.getElementById(`row-${id}`)?.classList.toggle('selected', cb.checked);
  updateBulkBar();
  const filtered = getSorted(getFiltered());
  const start = (currentPage-1)*PAGE_SIZE;
  const slice = filtered.slice(start, start+PAGE_SIZE);
  document.getElementById('selectAll').checked = slice.every(i=>selectedIds.has(i.id));
}

function clearSelection() { selectedIds.clear(); renderTable(); }

// ─── STATUS TOGGLE (AJAX) ────────────────────────────────
async function toggleStatus(id, cb) {
  const it = items.find(i=>i.id===id);
  if (!it) return;
  const prevActive = it.active;
  it.active = cb.checked;
  renderTable();

  try {
    const res = await fetch(`/subscriber/items/${id}/toggle`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ active: cb.checked })
    });
    const data = await res.json();
    if (data.success) {
      toast(cb.checked ? `✅ "${it.shortDesc}" set to Active` : `⏸ "${it.shortDesc}" set to Inactive`, cb.checked ? 'success' : 'info');
    } else {
      it.active = prevActive;
      renderTable();
      toast('⚠️ Failed to update status', 'error');
    }
  } catch (err) {
    it.active = prevActive;
    renderTable();
    toast('⚠️ Network error updating status', 'error');
  }
}

// ─── BULK ACTIONS (AJAX) ─────────────────────────────────
async function bulkSetStatus(active) {
  if (!selectedIds.size) return;
  const ids = Array.from(selectedIds);
  try {
    const res = await fetch('/subscriber/items/bulk-action', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        action: active ? 'activate' : 'deactivate',
        items: ids
      })
    });
    const data = await res.json();
    if (data.success) {
      items.forEach(it => { if (selectedIds.has(it.id)) it.active = active; });
      toast(`${active?'✅':'⏸'} ${ids.length} items set to ${active?'Active':'Inactive'}`, 'success');
      selectedIds.clear();
      renderTable();
    } else {
      toast(data.message || '⚠️ Bulk update failed', 'error');
    }
  } catch (err) {
    toast('⚠️ Network error', 'error');
  }
}

function bulkDelete() {
  if (!selectedIds.size) return;
  deletingId = null;
  document.getElementById('deleteSubText').textContent =
    `This will permanently delete ${selectedIds.size} selected item${selectedIds.size>1?'s':''} from your catalog. This cannot be undone.`;
  openModal('deleteModal');
}

async function confirmDelete() {
  const btn = document.getElementById('confirmDeleteBtn');
  btn.disabled = true;

  try {
    if (deletingId !== null) {
      const it = items.find(i=>i.id===deletingId);
      const res = await fetch(`/subscriber/items/${deletingId}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        }
      });
      const data = await res.json();
      if (data.success) {
        items = items.filter(i=>i.id!==deletingId);
        selectedIds.delete(deletingId);
        toast(`🗑 "${it?.shortDesc || 'Item'}" deleted`, 'info');
      } else {
        toast(data.message || '⚠️ Delete failed', 'error');
      }
    } else {
      const ids = Array.from(selectedIds);
      const res = await fetch('/subscriber/items/bulk-action', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json'
        },
        body: JSON.stringify({ action: 'delete', items: ids })
      });
      const data = await res.json();
      if (data.success) {
        items = items.filter(i=>!selectedIds.has(i.id));
        selectedIds.clear();
        toast(`🗑 ${ids.length} items deleted`, 'info');
      } else {
        toast(data.message || '⚠️ Bulk delete failed', 'error');
      }
    }
  } catch (err) {
    toast('⚠️ Network error deleting items', 'error');
  } finally {
    btn.disabled = false;
    closeModal('deleteModal');
    deletingId = null;
    renderTable();
  }
}

// ─── MODAL: ADD / EDIT ───────────────────────────────────
function openAddModal() {
  editingId = null;
  document.getElementById('modalTitle').textContent = 'New Item';
  document.getElementById('modalSubtitle').textContent = 'Fill in the details to add a new product or service to your catalog.';
  document.getElementById('changeHistorySection').style.display = 'none';
  clearForm();
  openModal('itemModal');
}

function openEditModal(id) {
  const it = items.find(i=>i.id===id);
  if (!it) return;
  editingId = id;
  document.getElementById('modalTitle').textContent = 'Edit Item';
  document.getElementById('modalSubtitle').textContent = `Editing: ${it.shortDesc}`;
  document.getElementById('f_num').value = it.num || '';
  document.getElementById('f_shortDesc').value = it.shortDesc || '';
  document.getElementById('f_fullDesc').value = it.fullDesc || '';
  document.getElementById('f_price').value = it.price || 0;
  document.getElementById('f_currency').value = it.currency || 'USD';
  document.getElementById('f_uom').value = it.uom || 'Each';
  document.getElementById('f_active').checked = it.active;
  selectType(it.type || 'product');
  selectTax(it.taxFlag || 'taxable');
  document.getElementById('f_taxSource').value = it.taxSource || '';
  document.getElementById('f_taxRate').value = it.taxRate || '';
  document.getElementById('f_taxName').value = it.taxName || '';
  document.getElementById('f_taxCode').value = it.taxCode || '';
  document.getElementById('f_ptc').value = it.ptc || '';
  document.getElementById('f_taxCategory').value = it.taxCategory || '';
  document.getElementById('f_stripeTaxCode').value = it.stripeTaxCode || '';
  document.getElementById('f_taxBehavior').value = it.taxBehavior || 'exclusive';
  document.getElementById('f_extTaxCode').value = it.extTaxCode || '';
  onTaxSourceChange();
  updateStatusLabel();

  document.getElementById('changeHistorySection').style.display = '';
  document.getElementById('ch_statusDate').textContent = fmtDate(it.statusEffectiveDate);
  document.getElementById('ch_updatedDate').textContent = fmtDate(it.lastUpdatedDate);
  document.getElementById('ch_updatedBy').textContent = it.lastUpdatedBy || '—';
  openModal('itemModal');
}

function clearForm() {
  document.getElementById('f_num').value = nextItemNumDefault;
  ['f_shortDesc','f_fullDesc','f_price','f_taxRate','f_taxName','f_taxCode','f_ptc','f_stripeTaxCode','f_extTaxCode'].forEach(id => document.getElementById(id).value = '');
  document.getElementById('f_currency').value = 'USD';
  document.getElementById('f_uom').value = 'Each';
  document.getElementById('f_active').checked = true;
  document.getElementById('f_taxSource').value = 'manual';
  document.getElementById('f_taxRate').value = '8.25';
  document.getElementById('f_taxName').value = 'Sales Tax';
  document.getElementById('f_taxCategory').value = '';
  document.getElementById('f_taxBehavior').value = 'exclusive';
  selectType('product');
  selectTax('taxable');
  onTaxSourceChange();
  updateStatusLabel();
}

function selectType(type) {
  document.querySelectorAll('input[name="itemType"]').forEach(r => r.checked = r.value === type);
  document.getElementById('radioProduct').classList.toggle('selected', type==='product');
  document.getElementById('radioService').classList.toggle('selected', type==='service');
}

function selectTax(flag) {
  document.querySelectorAll('input[name="taxFlag"]').forEach(r => r.checked = r.value === flag);
  document.getElementById('radioTaxable').classList.toggle('selected', flag==='taxable');
  document.getElementById('radioExempt').classList.toggle('selected', flag==='exempt');
  document.getElementById('taxPanel').classList.toggle('visible', flag==='taxable');
}

function onTaxSourceChange() {
  const src = document.getElementById('f_taxSource').value;
  document.getElementById('taxManualPanel').style.display  = src === 'manual'    ? '' : 'none';
  document.getElementById('taxAutoPanel').style.display    = (src === 'avatax' || src === 'taxjar') ? '' : 'none';
  document.getElementById('taxStripePanel').style.display  = src === 'stripe_tax'? '' : 'none';
  document.getElementById('taxCustomPanel').style.display  = src === 'custom'    ? '' : 'none';
}

function fmtDate(d) {
  if (!d) return '—';
  const dt = new Date(d + (d.includes('T') ? '' : 'T00:00:00'));
  return dt.toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric'});
}

function uomAbbr(uom) {
  return {Each:'ea',Hour:'hr',Day:'day',Month:'mo',Year:'yr',Project:'proj','Sq Ft':'sqft','Linear Ft':'lnft',Lbs:'lbs',kg:'kg',License:'lic',Seat:'seat',Unit:'unit',Other:'other'}[uom] || (uom || 'ea');
}

function taxSourceLabel(src) {
  return {manual:'Manual Rate', avatax:'Avalara AvaTax', taxjar:'TaxJar', stripe_tax:'Stripe Tax', custom:'Custom API'}[src] || src;
}

document.getElementById('f_active').addEventListener('change', updateStatusLabel);
function updateStatusLabel() {
  const lbl = document.getElementById('statusLabel');
  lbl.textContent = document.getElementById('f_active').checked
    ? 'Active — available for invoices & quotes'
    : 'Inactive — hidden from invoice/quote item picker';
}

async function saveItem() {
  const num = document.getElementById('f_num').value.trim();
  const shortDesc = document.getElementById('f_shortDesc').value.trim();
  const price = parseFloat(document.getElementById('f_price').value);
  const uom = document.getElementById('f_uom').value;
  const type = document.querySelector('input[name="itemType"]:checked')?.value || 'product';
  const taxFlag = document.querySelector('input[name="taxFlag"]:checked')?.value || 'taxable';
  const taxSource = taxFlag === 'taxable' ? document.getElementById('f_taxSource').value : '';

  if (!num) { toast('⚠️ Item Number is required', 'error'); return; }
  if (!shortDesc) { toast('⚠️ Short Description is required', 'error'); return; }
  if (isNaN(price) || price < 0) { toast('⚠️ Enter a valid Unit Amount', 'error'); return; }
  if (taxFlag === 'taxable' && !taxSource) { toast('⚠️ Select a Tax Calculation Source', 'error'); return; }
  if (taxFlag === 'taxable' && taxSource === 'manual') {
    const r = parseFloat(document.getElementById('f_taxRate').value);
    if (isNaN(r) || r < 0) { toast('⚠️ Enter a valid Tax Rate', 'error'); return; }
  }

  const dup = items.find(i => i.num === num && i.id !== editingId);
  if (dup) { toast(`⚠️ Item number "${num}" already exists`, 'error'); return; }

  const payload = {
    num, shortDesc,
    fullDesc: document.getElementById('f_fullDesc').value.trim(),
    price, currency: document.getElementById('f_currency').value,
    uom, type,
    active: document.getElementById('f_active').checked,
    taxFlag, taxSource,
    taxRate:       taxSource === 'manual'     ? (parseFloat(document.getElementById('f_taxRate').value)||0) : 0,
    taxName:       taxSource === 'manual'     ? document.getElementById('f_taxName').value.trim() : '',
    taxCode:       taxSource === 'manual'     ? document.getElementById('f_taxCode').value.trim() : '',
    ptc:           (taxSource==='avatax'||taxSource==='taxjar') ? document.getElementById('f_ptc').value.trim() : '',
    taxCategory:   (taxSource==='avatax'||taxSource==='taxjar') ? document.getElementById('f_taxCategory').value : '',
    stripeTaxCode: taxSource === 'stripe_tax' ? document.getElementById('f_stripeTaxCode').value.trim() : '',
    taxBehavior:   taxSource === 'stripe_tax' ? document.getElementById('f_taxBehavior').value : 'exclusive',
    extTaxCode:    taxSource === 'custom'     ? document.getElementById('f_extTaxCode').value.trim() : '',
  };

  const btn = document.getElementById('saveItemBtn');
  btn.disabled = true;
  btn.textContent = 'Saving…';

  try {
    const url = editingId ? `/subscriber/items/${editingId}` : '/subscriber/items';
    const method = editingId ? 'PUT' : 'POST';

    const res = await fetch(url, {
      method: method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify(payload)
    });

    const data = await res.json();
    if (data.success && data.item) {
      if (editingId) {
        const idx = items.findIndex(i => i.id === editingId);
        if (idx !== -1) items[idx] = data.item;
        toast(`✅ "${shortDesc}" updated`, 'success');
      } else {
        items.unshift(data.item);
        toast(`✅ "${shortDesc}" added to catalog`, 'success');
      }
      closeModal('itemModal');
      renderTable();
    } else {
      toast(data.message || '⚠️ Could not save item', 'error');
    }
  } catch (err) {
    toast('⚠️ Network error saving item', 'error');
  } finally {
    btn.disabled = false;
    btn.textContent = 'Save';
  }
}

// ─── DELETE ──────────────────────────────────────────────
function openDeleteModal(id) {
  deletingId = id;
  const it = items.find(i=>i.id===id);
  document.getElementById('deleteSubText').textContent =
    `This will permanently remove "${it?.shortDesc || 'this item'}" from your catalog. It cannot be undone.`;
  openModal('deleteModal');
}

// ─── MODAL HELPERS ───────────────────────────────────────
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(o => {
  o.addEventListener('click', e => { if (e.target === o) o.classList.remove('open'); });
});

// ─── EXPORT ──────────────────────────────────────────────
function exportCSV() {
  const rows = [['Item Number','Short Description','Full Description','UOM','Type','Unit Amount','Currency','Tax Flag','Tax Source','Tax Rate %','Tax Name','Tax Code','Status']];
  getFiltered().forEach(it => rows.push([
    it.num, it.shortDesc, it.fullDesc, it.uom, it.type, it.price, it.currency,
    it.taxFlag, it.taxSource||'', it.taxRate||'', it.taxName||'', it.taxCode||'', it.active?'Active':'Inactive'
  ]));
  const csv = rows.map(r => r.map(c => `"${String(c||'').replace(/"/g,'""')}"`).join(',')).join('\n');
  const a = document.createElement('a');
  a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
  a.download = 'velo-items.csv';
  a.click();
  toast('📥 CSV exported', 'success');
}

// ─── TOAST ───────────────────────────────────────────────
function toast(msg, type='success') {
  const el = document.createElement('div');
  el.className = `toast ${type}`;
  el.textContent = msg;
  document.getElementById('toastContainer').appendChild(el);
  setTimeout(() => el.remove(), 3200);
}

// ─── MOBILE SIDEBAR ──────────────────────────────────────
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('overlay').classList.toggle('open');
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('overlay').classList.remove('open');
}

// Init table
renderTable();
</script>

<script>
(function () {
  function byId(id) { return document.getElementById(id); }
  window.setActive = window.setActive || function (element) {
    document.querySelectorAll('.nav-item').forEach(function (item) { item.classList.remove('active'); });
    if (element) element.classList.add('active');
  };
  window.closeSidebar = window.closeSidebar || function () {
    var sidebar = byId('sidebar');
    var overlay = byId('overlay');
    if (sidebar) sidebar.classList.remove('open');
    if (overlay) { overlay.classList.remove('open'); overlay.classList.remove('visible'); }
  };
  window.toggleDashboardSidebar = window.toggleDashboardSidebar || function () {
    if (window.matchMedia('(max-width: 960px)').matches) {
      var sidebar = byId('sidebar');
      var overlay = byId('overlay');
      if (sidebar) sidebar.classList.toggle('open');
      if (overlay) overlay.classList.toggle('visible');
      return;
    }
    document.body.classList.toggle('dashboard-sidebar-collapsed');
  };
}());
</script>

</body>
</html>
