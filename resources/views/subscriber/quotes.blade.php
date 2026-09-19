<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Velo — Quotes</title>
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
    --blue: #3b82f6;
    --blue-pale: #eff6ff;
    --muted: #6b7280;
    --border: #ddd8cc;
    --border-dark: rgba(255,255,255,0.08);
    --card: #ffffff;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
    --shadow-md: 0 8px 32px rgba(0,0,0,0.10);
    --shadow-lg: 0 20px 60px rgba(0,0,0,0.15);
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
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
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
    transition: transform .25s ease;
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
    display: flex; flex-direction: column; height: 100%; padding: 0;
  }
  .sidebar-logo {
    padding: 22px 24px 20px;
    border-bottom: 1px solid var(--border-dark);
    flex-shrink: 0;
  }
  .sidebar-logo a {
    font-family: 'Syne', sans-serif;
    font-weight: 800; font-size: 1.35rem;
    letter-spacing: -0.04em; color: #fff; text-decoration: none;
    display: flex; align-items: center; gap: 8px;
  }
  .sidebar-logo a span { color: var(--teal); }
  .sidebar-user {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 24px; border-bottom: 1px solid var(--border-dark); flex-shrink: 0;
  }
  .user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--teal), var(--teal-dark));
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.8rem; color: #fff; flex-shrink: 0;
  }
  .user-details { min-width: 0; }
  .user-name { font-size: 0.82rem; font-weight: 600; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .user-plan { font-size: 0.7rem; color: var(--teal); font-weight: 500; }
  .sidebar-nav {
    flex: 1; overflow-y: auto; padding: 12px 0;
    scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.1) transparent;
  }
  .nav-section-label {
    font-size: 0.65rem; font-weight: 600; letter-spacing: 0.1em;
    text-transform: uppercase; color: rgba(255,255,255,0.3); padding: 14px 24px 6px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 11px;
    padding: 9px 20px 9px 24px; cursor: pointer;
    color: rgba(255,255,255,0.65); font-size: 0.875rem; font-weight: 400;
    text-decoration: none; transition: background .15s, color .15s;
    border-left: 3px solid transparent;
  }
  .nav-item:hover { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.9); }
  .nav-item.active {
    background: rgba(0,184,153,0.14); color: var(--teal);
    font-weight: 600; border-left-color: var(--teal);
  }
  .nav-item .nav-icon { font-size: 1rem; width: 20px; text-align: center; flex-shrink: 0; }
  .nav-item .nav-label { flex: 1; }
  .nav-count {
    font-size: 0.7rem; font-weight: 600; padding: 1px 7px; border-radius: 99px;
    background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.5);
  }
  .nav-badge {
    font-size: 0.68rem; font-weight: 600; padding: 1px 7px;
    border-radius: 99px; background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.5);
  }
  .nav-badge.alert, .nav-badge.red { background: rgba(240,84,84,0.2); color: var(--red-soft); }
  .sidebar-footer {
    padding: 16px 24px; border-top: 1px solid var(--border-dark); flex-shrink: 0;
  }
  .sidebar-footer a {
    display: flex; align-items: center; gap: 10px; padding: 9px 12px;
    border-radius: var(--radius-sm); color: rgba(255,255,255,0.5);
    font-size: 0.82rem; text-decoration: none; transition: background .15s, color .15s;
  }
  .sidebar-footer a:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.8); }
  .sidebar-overlay {
    display: none; position: fixed; inset: 0; background: rgba(13,13,13,0.45);
    backdrop-filter: blur(3px); z-index: 45;
  }
  .sidebar-overlay.open, .sidebar-overlay.visible { display: block; }

  /* ─── SHELL ───────────────────────────────────────────── */
  .shell {
    margin-left: var(--sidebar-w);
    flex: 1; display: flex; flex-direction: column; min-height: 100vh;
    transition: margin-left .25s ease;
  }
  body.dashboard-sidebar-collapsed .sidebar { transform: translateX(-100%); }
  body.dashboard-sidebar-collapsed .shell { margin-left: 0; }

  /* ─── TOPBAR ──────────────────────────────────────────── */
  .topbar {
    position: sticky; top: 0; z-index: 40;
    height: var(--topbar-h);
    background: rgba(245,242,235,0.92); backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 32px; gap: 16px; overflow: visible;
  }
  .topbar-left { display: flex; align-items: center; gap: 16px; min-width: 0; }
  .topbar-right { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
  .sidebar-toggle-btn {
    width: 38px; height: 38px; border-radius: 10px; border: 1.5px solid var(--border); background: var(--card);
    display: inline-flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; cursor: pointer; transition: all .15s;
  }
  .sidebar-toggle-btn:hover { border-color: var(--teal); background: var(--teal-pale); }
  .sidebar-toggle-btn span { display: block; width: 16px; height: 2px; border-radius: 99px; background: var(--slate); }
  .page-title {
    font-family: 'Syne', sans-serif; font-size: 1.15rem; font-weight: 700;
    color: var(--slate); letter-spacing: -0.02em; white-space: nowrap;
  }
  .topbar-search {
    min-width: 260px; height: 38px; border: 1.5px solid var(--border); border-radius: 10px;
    background: var(--card); display: flex; align-items: center; gap: 8px; padding: 0 12px; cursor: pointer;
  }
  .topbar-search:focus-within { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(0,184,153,0.1); }
  .topbar-search input { border: none; outline: none; background: transparent; font-family: 'DM Sans', sans-serif; font-size: 0.85rem; width: 100%; color: var(--ink); cursor: pointer; }
  .search-icon { color: var(--muted); font-size: 0.85rem; }
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

  /* ─── BUTTONS ─────────────────────────────────────────── */
  .btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 600;
    cursor: pointer; transition: all .15s; border: none; text-decoration: none;
  }
  .btn-ghost {
    background: transparent; color: var(--muted);
    border: 1.5px solid var(--border);
  }
  .btn-ghost:hover { background: var(--cream); color: var(--ink); border-color: #ccc8bc; }
  .btn-outline {
    background: transparent; color: var(--slate);
    border: 1.5px solid var(--border);
  }
  .btn-outline:hover { background: var(--cream); border-color: #ccc8bc; }
  .btn-primary {
    background: var(--teal); color: #fff; border: 1.5px solid var(--teal);
  }
  .btn-primary:hover { background: var(--teal-dark); border-color: var(--teal-dark); }
  .btn-amber {
    background: var(--amber); color: var(--slate); border: 1.5px solid var(--amber);
    font-weight: 700;
  }
  .btn-amber:hover { background: #e8991a; border-color: #e8991a; }

  /* ─── MAIN ────────────────────────────────────────────── */
  .main { flex: 1; padding: 32px; display: flex; flex-direction: column; gap: 24px; min-width: 0; }

  /* ─── PAGE HEADER ─────────────────────────────────────── */
  .page-header {
    display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;
  }
  .page-header .page-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.6rem; font-weight: 800; color: var(--slate);
    letter-spacing: -0.04em; line-height: 1.2;
  }
  .page-subtitle { font-size: 0.85rem; color: var(--muted); margin-top: 4px; }
  .page-header-actions { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }

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
    display: flex; flex-direction: column; gap: 8px;
    cursor: pointer; transition: box-shadow .2s, transform .15s, border-color .15s;
    position: relative; overflow: hidden;
  }
  .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-1px); }
  .stat-card.active { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(0,184,153,0.12), var(--shadow-sm); }
  .stat-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
    border-radius: var(--radius) var(--radius) 0 0;
  }
  .stat-card.all::before { background: var(--slate); }
  .stat-card.pending::before { background: var(--amber); }
  .stat-card.paid::before { background: var(--teal); }
  .stat-card.overdue::before { background: var(--red-soft); }
  .stat-label {
    font-size: 0.7rem; font-weight: 600; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--muted);
    display: flex; align-items: center; gap: 7px;
  }
  .stat-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
  .stat-amount {
    font-family: 'Syne', sans-serif;
    font-size: 1.5rem; font-weight: 800; color: var(--slate); letter-spacing: -0.03em;
  }
  .stat-meta { font-size: 0.75rem; color: var(--muted); display: flex; align-items: center; gap: 6px; }
  .stat-count {
    font-size: 0.72rem; font-weight: 600; padding: 2px 8px; border-radius: 99px;
    background: var(--paper); color: var(--muted);
  }

  /* ─── FILTERS ROW ─────────────────────────────────────── */
  .filters-row {
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
  }
  .filters-left { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
  .filters-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

  .search-bar {
    display: flex; align-items: center; gap: 0;
    background: var(--card); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
    min-width: 280px;
  }
  .search-bar:focus-within {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(0,184,153,0.12);
  }
  .search-bar .search-icon { padding: 0 10px 0 13px; color: var(--muted); font-size: 0.85rem; }
  .search-input {
    border: none !important; background: transparent !important;
    outline: none; font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem; color: var(--ink); padding: 9px 12px 9px 0;
    flex: 1; min-width: 0;
    box-shadow: none !important;
  }
  .search-input::placeholder { color: var(--muted); }

  .filter-chip {
    display: flex; align-items: center; gap: 6px;
    padding: 6px 13px; border-radius: 99px;
    border: 1.5px solid var(--border);
    background: transparent; cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem; font-weight: 600; color: var(--muted);
    transition: all .15s;
  }
  .filter-chip:hover { border-color: var(--teal); color: var(--teal); }
  .filter-chip.active { border-color: var(--teal); color: var(--teal); background: var(--teal-pale); }
  .filter-chip .chip-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }

  .sort-select {
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 500;
    color: var(--muted); background: var(--card);
    border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    padding: 8px 32px 8px 12px; cursor: pointer; outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath fill='%236b7280' d='M5 7L0 0h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center;
  }
  .sort-select:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(0,184,153,0.12); }

  .view-toggle { display: flex; background: var(--card); border: 1.5px solid var(--border); border-radius: var(--radius-sm); overflow: hidden; }
  .view-btn { padding: 7px 11px; cursor: pointer; background: transparent; border: none; color: var(--muted); font-size: 0.9rem; transition: all .15s; }
  .view-btn.active { background: var(--slate); color: #fff; }
  .view-btn:hover:not(.active) { background: var(--cream); }

  /* ─── TABLE ───────────────────────────────────────────── */
  .table-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    min-width: 0;
  }
  .table-header-row {
    display: grid;
    grid-template-columns: 24px 140px 1fr 160px 130px 120px 110px 100px;
    gap: 12px; align-items: center;
    padding: 13px 20px;
    background: var(--paper);
    border-bottom: 1.5px solid var(--border);
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--muted);
  }
  .th-sort { cursor: pointer; display: flex; align-items: center; gap: 5px; user-select: none; }
  .th-sort:hover { color: var(--slate); }
  .th-sort.sorted { color: var(--teal); }
  .sort-icon { font-size: 0.6rem; }

  .table-row {
    display: grid;
    grid-template-columns: 24px 140px 1fr 160px 130px 120px 110px 100px;
    gap: 12px; align-items: center;
    padding: 14px 20px;
    border-bottom: 1px solid rgba(0,0,0,0.04);
    cursor: pointer; transition: background .12s;
    animation: rowIn .25s ease both;
  }
  .table-row:last-child { border-bottom: none; }
  .table-row:hover { background: var(--paper); }
  .table-row:hover .row-actions { opacity: 1; }
  @keyframes rowIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
  }
  #tableBody { min-width: 0; }

  .row-check { width: 16px; height: 16px; border-radius: 4px; border: 1.5px solid var(--border); background: transparent; cursor: pointer; flex-shrink: 0; appearance: none; }
  .row-check:checked { background: var(--teal); border-color: var(--teal); }
  .row-check:checked::after { content: '✓'; display: block; text-align: center; font-size: 0.6rem; color: #fff; line-height: 1.1; }

  .inv-num {
    font-family: 'Syne', sans-serif;
    font-weight: 700; font-size: 0.82rem; color: var(--slate);
    display: flex; align-items: center; gap: 7px;
  }
  .inv-icon {
    width: 28px; height: 28px; border-radius: 7px; background: var(--teal-pale);
    display: flex; align-items: center; justify-content: center; font-size: 0.7rem; flex-shrink: 0;
  }

  .client-cell { display: flex; align-items: center; gap: 9px; min-width: 0; }
  .client-avatar-sm {
    width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem; font-weight: 700; color: #fff;
  }
  .client-info { min-width: 0; }
  .client-name { font-weight: 600; font-size: 0.85rem; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .client-id { font-size: 0.72rem; color: var(--muted); }

  .project-cell { font-size: 0.82rem; color: var(--muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

  .date-cell { font-size: 0.82rem; color: var(--muted); }
  .date-cell.overdue { color: var(--red-soft); font-weight: 600; }

  .amount-cell {
    font-family: 'Syne', sans-serif;
    font-weight: 700; font-size: 0.95rem; color: var(--ink); text-align: right;
  }

  .status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 99px;
    font-size: 0.7rem; font-weight: 700; letter-spacing: 0.04em;
    text-transform: capitalize; white-space: nowrap;
  }
  .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
  .badge-draft { background: rgba(107,114,128,0.12); color: var(--muted); }
  .badge-draft .badge-dot { background: var(--muted); }
  .badge-sent { background: var(--blue-pale); color: var(--blue); }
  .badge-sent .badge-dot { background: var(--blue); }
  .badge-paid, .badge-accepted { background: var(--teal-pale); color: var(--teal-dark); }
  .badge-paid .badge-dot, .badge-accepted .badge-dot { background: var(--teal); }
  .badge-overdue, .badge-declined, .badge-rejected { background: var(--red-pale); color: var(--red-soft); }
  .badge-overdue .badge-dot, .badge-declined .badge-dot, .badge-rejected .badge-dot { background: var(--red-soft); }
  .badge-expired { background: var(--amber-pale); color: #92610f; }
  .badge-expired .badge-dot { background: var(--amber); }

  .row-actions {
    display: flex; align-items: center; gap: 4px;
    justify-content: flex-end; opacity: 0; transition: opacity .15s;
  }
  .action-btn {
    width: 28px; height: 28px; border-radius: 6px;
    border: 1.5px solid var(--border); background: transparent;
    cursor: pointer; color: var(--muted); font-size: 0.8rem;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s;
  }
  .action-btn:hover { background: var(--paper); color: var(--ink); border-color: #ccc8bc; }
  .action-btn.danger:hover { background: var(--red-pale); border-color: var(--red-soft); color: var(--red-soft); }
  .action-btn.teal:hover { background: var(--teal-pale); border-color: var(--teal); color: var(--teal-dark); }

  /* ─── EMPTY STATE ─────────────────────────────────────── */
  .empty-state {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 72px 32px; text-align: center; gap: 12px;
  }
  .empty-icon { font-size: 2.5rem; opacity: 0.4; }
  .empty-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1rem; color: var(--slate); }
  .empty-sub { font-size: 0.85rem; color: var(--muted); max-width: 320px; }

  /* ─── TABLE FOOTER ────────────────────────────────────── */
  .table-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px; border-top: 1px solid var(--border);
    background: var(--paper); font-size: 0.8rem; color: var(--muted);
  }
  .pagination { display: flex; align-items: center; gap: 4px; }
  .page-btn {
    width: 30px; height: 30px; border-radius: 7px;
    border: 1.5px solid var(--border); background: transparent;
    cursor: pointer; font-size: 0.8rem; color: var(--muted);
    display: flex; align-items: center; justify-content: center;
    transition: all .15s; font-family: 'DM Sans', sans-serif;
  }
  .page-btn:hover { background: var(--cream); color: var(--ink); }
  .page-btn.active { background: var(--slate); color: #fff; border-color: var(--slate); }

  /* ─── BULK BAR ────────────────────────────────────────── */
  .bulk-bar {
    display: none; position: fixed; bottom: 32px; left: 50%; transform: translateX(-50%);
    background: var(--slate); border-radius: var(--radius); padding: 14px 20px;
    box-shadow: var(--shadow-lg); z-index: 90;
    align-items: center; gap: 16px; min-width: 440px;
    animation: bulkIn .2s ease;
  }
  .bulk-bar.visible { display: flex; }
  @keyframes bulkIn {
    from { opacity: 0; transform: translateX(-50%) translateY(12px); }
    to { opacity: 1; transform: translateX(-50%) translateY(0); }
  }
  .bulk-count { font-family: 'Syne', sans-serif; font-weight: 700; color: #fff; font-size: 0.85rem; }
  .bulk-actions { display: flex; gap: 8px; margin-left: auto; }
  .bulk-btn {
    padding: 7px 14px; border-radius: var(--radius-sm);
    border: 1.5px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.8);
    font-family: 'DM Sans', sans-serif; font-size: 0.78rem; font-weight: 600;
    cursor: pointer; transition: all .15s;
  }
  .bulk-btn:hover { background: rgba(255,255,255,0.14); color: #fff; }
  .bulk-btn.danger { border-color: rgba(240,84,84,0.4); color: rgba(240,84,84,0.9); }
  .bulk-btn.danger:hover { background: rgba(240,84,84,0.12); }
  .bulk-close {
    width: 28px; height: 28px; border-radius: 6px;
    border: 1.5px solid rgba(255,255,255,0.15);
    background: transparent; cursor: pointer; color: rgba(255,255,255,0.5);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; transition: all .15s;
  }
  .bulk-close:hover { background: rgba(255,255,255,0.1); color: #fff; }

  /* ─── SEARCH OVERLAY ──────────────────────────────────── */
  .search-overlay {
    display: none; position: fixed; inset: 0; z-index: 200;
    background: rgba(13,13,13,0.45); backdrop-filter: blur(4px);
    align-items: flex-start; justify-content: center;
    padding-top: 80px;
  }
  .search-overlay.open { display: flex; }
  .search-modal {
    background: var(--card); border-radius: var(--radius);
    border: 1px solid var(--border); box-shadow: var(--shadow-lg);
    width: 680px; max-width: calc(100vw - 40px);
    max-height: calc(100vh - 140px);
    display: flex; flex-direction: column; overflow: hidden;
    animation: modalIn .18s ease;
  }
  @keyframes modalIn {
    from { opacity: 0; transform: translateY(-10px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
  }
  .search-modal-header {
    display: flex; align-items: center; gap: 10px;
    padding: 16px 20px; border-bottom: 1px solid var(--border); flex-shrink: 0;
  }
  .search-modal-icon { color: var(--muted); font-size: 1rem; }
  .search-modal-input {
    flex: 1; border: none !important; outline: none;
    font-family: 'DM Sans', sans-serif; font-size: 1rem;
    color: var(--ink); background: transparent !important;
    box-shadow: none !important; padding: 0;
  }
  .search-modal-input::placeholder { color: var(--muted); }
  .search-modal-close {
    width: 28px; height: 28px; border-radius: 6px;
    border: 1.5px solid var(--border); background: transparent;
    cursor: pointer; color: var(--muted); font-size: 0.85rem;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s;
  }
  .search-modal-close:hover { background: var(--paper); color: var(--ink); }
  .search-results-body { overflow-y: auto; flex: 1; padding: 12px 0; }
  .search-quick-item {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 20px; cursor: pointer; transition: background .12s;
    font-size: 0.85rem;
  }
  .search-quick-item:hover { background: var(--paper); }

  /* ─── DRILLDOWN / SLIDE PANEL SHELL ──────────────────────── */
  .drilldown-backdrop {
    display: none; position: fixed; inset: 0; z-index: 100;
    background: rgba(13,13,13,0.35); backdrop-filter: blur(4px);
  }
  .drilldown-backdrop.open { display: block; }
  .drilldown-panel {
    position: fixed; top: 0; right: -640px; bottom: 0;
    width: 640px; background: var(--card);
    border-left: 1px solid var(--border);
    box-shadow: -8px 0 40px rgba(0,0,0,0.12);
    z-index: 101; display: flex; flex-direction: column;
    transition: right .3s cubic-bezier(.4,0,.2,1);
    overflow: hidden;
  }
  .drilldown-panel.open { right: 0; }

  .drilldown-header {
    padding: 24px 28px 20px;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
  }
  .drilldown-title-row {
    display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;
  }
  .drilldown-close {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1.5px solid var(--border); background: transparent;
    cursor: pointer; color: var(--muted); font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s;
  }
  .drilldown-close:hover { background: var(--paper); color: var(--ink); }
  .qf-eyebrow {
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.78rem;
    letter-spacing: 0.06em; text-transform: uppercase; color: var(--teal-dark);
  }
  .qf-title {
    font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.2rem;
    color: var(--slate); letter-spacing: -0.02em; margin-top: 2px;
  }
  .qf-subtitle { font-size: 0.82rem; color: var(--muted); margin-top: 4px; }

  .drilldown-body { flex: 1; overflow-y: auto; padding: 22px 28px; }
  .drilldown-footer {
    padding: 16px 28px;
    border-top: 1px solid var(--border);
    display: flex; gap: 10px; flex-shrink: 0;
  }
  .drilldown-footer .btn { flex: 1; justify-content: center; }

  /* ─── QUOTE FORM ──────────────────────────────────────── */
  .form-section-label {
    font-family: 'Syne', sans-serif;
    font-size: 0.7rem; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--muted);
    margin: 24px 0 12px;
    display: flex; align-items: center; gap: 8px;
  }
  .form-section-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }
  .form-section-label:first-child { margin-top: 0; }

  .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
  .form-group { margin-bottom: 14px; }
  .form-group:last-child { margin-bottom: 0; }
  .form-label { display: block; font-size: 0.75rem; font-weight: 600; color: var(--slate); margin-bottom: 6px; }
  .form-input, .form-select, .form-textarea {
    width: 100%; font-family: 'DM Sans', sans-serif; font-size: 0.85rem; color: var(--ink);
    background: var(--card); border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    padding: 9px 12px; outline: none; transition: border-color .15s, box-shadow .15s;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--teal); box-shadow: 0 0 0 3px rgba(0,184,153,0.12);
  }
  .form-input[readonly] { background: var(--paper); color: var(--muted); }
  .form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' viewBox='0 0 10 7'%3E%3Cpath fill='%236b7280' d='M5 7L0 0h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 12px center; padding-right: 32px;
    cursor: pointer;
  }
  .form-textarea { resize: vertical; font-family: inherit; }
  .form-hint { font-size: 0.72rem; color: var(--muted); margin-top: 5px; }

  .line-items-card { border: 1.5px solid var(--border); border-radius: var(--radius-sm); overflow: hidden; }
  .line-items-head {
    display: grid; grid-template-columns: 1fr 52px 88px 88px 26px; gap: 8px;
    padding: 10px 14px; background: var(--paper);
    font-size: 0.64rem; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase; color: var(--muted);
  }
  .line-items-head span:nth-child(2), .line-items-head span:nth-child(3), .line-items-head span:nth-child(4) { text-align: right; }
  .line-item-row {
    display: grid; grid-template-columns: 1fr 52px 88px 88px 26px; gap: 8px; align-items: center;
    padding: 8px 14px; border-top: 1px solid var(--border);
  }
  .li-input {
    width: 100%; font-family: 'DM Sans', sans-serif; font-size: 0.82rem;
    border: 1.5px solid transparent; background: transparent; border-radius: 6px;
    padding: 6px 7px; outline: none; transition: all .15s; color: var(--ink);
  }
  .li-input:hover { border-color: var(--border); }
  .li-input:focus { border-color: var(--teal); background: var(--card); box-shadow: 0 0 0 2px rgba(0,184,153,0.1); }
  .li-num { text-align: right; }
  .li-amount { text-align: right; font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.82rem; color: var(--ink); }
  .li-remove {
    width: 24px; height: 24px; border-radius: 6px; border: 1.5px solid var(--border);
    background: transparent; color: var(--muted); cursor: pointer; font-size: 0.68rem;
    display: flex; align-items: center; justify-content: center; transition: all .15s;
  }
  .li-remove:hover { background: var(--red-pale); border-color: var(--red-soft); color: var(--red-soft); }
  .add-line-btn {
    width: 100%; padding: 10px; border: none; border-top: 1px solid var(--border);
    background: var(--paper); color: var(--teal-dark); font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: background .15s;
  }
  .add-line-btn:hover { background: var(--teal-pale); }

  .totals-box {
    background: var(--paper); border-radius: var(--radius-sm); padding: 14px 16px;
    margin-top: 16px; display: flex; flex-direction: column; gap: 8px;
  }
  .totals-row { display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--muted); }
  .totals-row.total {
    padding-top: 8px; border-top: 1px solid var(--border);
    font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.05rem; color: var(--slate);
  }

  .qf-status-pills { display: flex; gap: 8px; flex-wrap: wrap; }
  .qf-status-pill {
    padding: 7px 14px; border-radius: 99px; border: 1.5px solid var(--border);
    background: transparent; cursor: pointer; font-family: 'DM Sans', sans-serif;
    font-size: 0.78rem; font-weight: 600; color: var(--muted); transition: all .15s;
    display: flex; align-items: center; gap: 6px;
  }
  .qf-status-pill:hover { border-color: var(--teal); color: var(--teal); }
  .qf-status-pill.active { border-color: var(--teal); color: var(--teal-dark); background: var(--teal-pale); }

  /* ─── RESPONSIVE ──────────────────────────────────────── */
  @media (max-width: 960px) {
    .sidebar { transform: translateX(-100%); transition: transform .25s; }
    .sidebar.open { transform: translateX(0); }
    .shell, body.dashboard-sidebar-collapsed .shell { margin-left: 0; }
    .topbar { padding: 0 16px; }
    .topbar-search { display: none; }
  }
  @media (max-width: 640px) {
    .page-title { font-size: 1rem; }
    .btn-new-invoice { padding: 9px 12px; font-size: 0.78rem; }
  }

  @media (max-width: 1280px) {
    .stats-row { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .table-card { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .table-header-row, .table-row { min-width: 980px; }
  }

  @media (max-width: 960px) {
    .main { padding: 24px 18px; gap: 20px; }
    .stats-row { grid-template-columns: 1fr; }
    .page-header { flex-direction: column; align-items: stretch; }
    .page-header-actions { width: 100%; flex-wrap: wrap; }
    .page-header-actions .btn { flex: 1 1 180px; justify-content: center; }
    .filters-row { flex-direction: column; align-items: stretch; }
    .filters-left, .filters-right { width: 100%; }
    .search-bar { width: 100%; min-width: 0; flex: 1 1 100%; }
    .sort-select { flex: 1; min-width: 0; }
    .bulk-bar { left: 18px; right: 18px; transform: none; min-width: 0; width: auto; flex-wrap: wrap; }
    .bulk-actions { width: 100%; order: 3; margin-left: 0; flex-wrap: wrap; }
    .bulk-btn { flex: 1 1 130px; justify-content: center; }
    .drilldown-panel { width: min(640px, 100vw); right: -100vw; }
    .form-grid-2 { grid-template-columns: 1fr; gap: 0; }
  }

  @media (max-width: 720px) {
    .topbar-btn[title="Help"] { display: none; }
    .topbar .btn-new-invoice { font-size: 0; padding: 9px 12px; }
    .topbar .btn-new-invoice::after { content: 'New'; font-size: 0.78rem; }
    .main { padding: 18px 12px; gap: 16px; }
    .stats-row { grid-template-columns: 1fr; gap: 12px; }
    .stat-card { padding: 16px; }
    .stat-amount { font-size: 1.35rem; }
    .filters-left { gap: 7px; }
    .filter-chip { flex: 1 1 calc(50% - 7px); justify-content: center; padding: 8px 10px; }
    .filters-right { gap: 8px; }
    .view-toggle { display: none; }
    .table-card {
      overflow-x: auto; overflow-y: hidden; background: var(--card); border: 1px solid var(--border);
      box-shadow: var(--shadow-sm); border-radius: 12px; -webkit-overflow-scrolling: touch;
    }
    .table-header-row, .table-row {
      min-width: 820px; grid-template-columns: 24px 112px 158px 140px 104px 104px 96px 92px;
      gap: 8px; padding-left: 12px; padding-right: 12px;
    }
    .table-header-row { display: grid; position: sticky; top: 0; z-index: 2; }
    .table-row { display: grid; padding-top: 12px; padding-bottom: 12px; }
    .inv-num { font-size: 0.76rem; }
    .inv-icon { width: 24px; height: 24px; font-size: 0.65rem; }
    .client-avatar-sm { width: 26px; height: 26px; }
    .client-name, .project-cell, .date-cell, .status-badge { font-size: 0.74rem; }
    .amount-cell { font-size: 0.82rem; }
    .row-actions { opacity: 1; }
    .table-footer { flex-direction: column; align-items: stretch; gap: 10px; text-align: center; }
    .pagination { justify-content: center; flex-wrap: wrap; }
  }

  @media (max-width: 420px) {
    .topbar { gap: 8px; }
    .topbar-btn { width: 34px; height: 34px; }
    .filter-chip { flex-basis: 100%; }
    .table-header-row, .table-row {
      min-width: 760px; grid-template-columns: 22px 104px 146px 124px 92px 92px 84px 82px;
      gap: 7px; padding-left: 10px; padding-right: 10px;
    }
    .table-header-row { font-size: 0.58rem; }
    .status-badge { padding: 4px 8px; font-size: 0.68rem; }
    .action-btn { width: 26px; height: 26px; }
  }
</style>
</head>
<body class="dashboard-page">

<!-- Overlay (mobile) -->
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- SIDEBAR                                                  -->
<!-- ═══════════════════════════════════════════════════════ -->
@include('subscriber.includes.sidebar')

<!-- ═══════════════════════════════════════════════════════ -->
<!-- SHELL                                                    -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="shell">

  <!-- TOPBAR -->
  <header class="topbar">
    <div class="topbar-left">
      <button class="sidebar-toggle-btn" type="button" onclick="toggleDashboardSidebar()" aria-label="Toggle sidebar">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="page-title">Quotes</div>
      <div class="topbar-search" onclick="openSearch()">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search quotes, customers... (Ctrl+K)" readonly>
      </div>
    </div>
    <div class="topbar-right">
      <a href="{{ route('subscriber.notifications') }}" class="topbar-btn" title="Notifications">
        🔔
        <span class="topbar-dot"></span>
      </a>
      <a href="#" class="topbar-btn" title="Help" onclick="event.preventDefault();toast('Velo Quotes: Create, manage, and convert quotes.');">❓</a>
    </div>
  </header>

  <!-- MAIN -->
  <main class="main">

    <!-- PAGE HEADER -->
    <div class="page-header">
      <div>
        <div class="page-title">Quotes</div>
        <div class="page-subtitle">Create, send, and track quotes before they become invoices</div>
      </div>
      <div class="page-header-actions">
        <button class="btn btn-ghost" onclick="exportQuotes()">⬆ Export CSV</button>
        <button class="btn btn-primary" onclick="openQuoteForm(null)">＋ New Quote</button>
      </div>
    </div>

    <!-- STATS CARDS -->
    <div class="stats-row">
      <div class="stat-card all active" onclick="filterByStatus('all', this)">
        <div class="stat-label"><span class="stat-dot" style="background:var(--slate)"></span>Total Quoted</div>
        <div class="stat-amount" id="statTotalAmt">{{ $stats['total_amount'] ?? '$0' }}</div>
        <div class="stat-meta"><span class="stat-count" id="statTotalCount">{{ $stats['total_count'] ?? '0 quotes' }}</span> this quarter</div>
      </div>
      <div class="stat-card pending" onclick="filterByStatus('sent', this)">
        <div class="stat-label"><span class="stat-dot" style="background:var(--amber)"></span>Awaiting Response</div>
        <div class="stat-amount" style="color:var(--amber)" id="statPendingAmt">{{ $stats['awaiting_amount'] ?? '$0' }}</div>
        <div class="stat-meta"><span class="stat-count" id="statPendingCount">{{ $stats['awaiting_count'] ?? '0 quotes' }}</span></div>
      </div>
      <div class="stat-card paid" onclick="filterByStatus('accepted', this)">
        <div class="stat-label"><span class="stat-dot" style="background:var(--teal)"></span>Accepted</div>
        <div class="stat-amount" style="color:var(--teal)" id="statAcceptedAmt">{{ $stats['accepted_amount'] ?? '$0' }}</div>
        <div class="stat-meta"><span class="stat-count" id="statAcceptedCount">{{ $stats['accepted_count'] ?? '0 quotes' }}</span></div>
      </div>
      <div class="stat-card overdue" onclick="filterByStatus('lost', this)">
        <div class="stat-label"><span class="stat-dot" style="background:var(--red-soft)"></span>Declined / Expired</div>
        <div class="stat-amount" style="color:var(--red-soft)" id="statLostAmt">{{ $stats['expired_amount'] ?? '$0' }}</div>
        <div class="stat-meta"><span class="stat-count" id="statLostCount">{{ $stats['expired_count'] ?? '0 quotes' }}</span></div>
      </div>
    </div>

    <!-- FILTERS -->
    <div class="filters-row">
      <div class="filters-left">
        <div class="search-bar">
          <span class="search-icon">🔍</span>
          <input class="search-input" id="tableSearch" placeholder="Filter quotes…" oninput="filterTable()">
        </div>
        <button class="filter-chip active" onclick="setStatusFilter('all', this)">All</button>
        <button class="filter-chip" onclick="setStatusFilter('draft', this)">
          <span class="chip-dot" style="background:var(--muted)"></span>Draft
        </button>
        <button class="filter-chip" onclick="setStatusFilter('sent', this)">
          <span class="chip-dot" style="background:var(--blue)"></span>Sent
        </button>
        <button class="filter-chip" onclick="setStatusFilter('accepted', this)">
          <span class="chip-dot" style="background:var(--teal)"></span>Accepted
        </button>
        <button class="filter-chip" onclick="setStatusFilter('declined', this)">
          <span class="chip-dot" style="background:var(--red-soft)"></span>Declined
        </button>
        <button class="filter-chip" onclick="setStatusFilter('expired', this)">
          <span class="chip-dot" style="background:var(--amber)"></span>Expired
        </button>
      </div>
      <div class="filters-right">
        <select class="sort-select" onchange="sortTable(this.value)">
          <option value="date-desc">Newest first</option>
          <option value="date-asc">Oldest first</option>
          <option value="amount-desc">Highest amount</option>
          <option value="amount-asc">Lowest amount</option>
          <option value="valid-asc">Expiring soonest</option>
          <option value="client">Client A–Z</option>
        </select>
        <div class="view-toggle">
          <button class="view-btn active" title="Table view">☰</button>
          <button class="view-btn" title="Card view" onclick="toast('Card view mode coming soon')">⊞</button>
        </div>
      </div>
    </div>

    <!-- TABLE -->
    <div class="table-card">
      <div class="table-header-row">
        <div><input type="checkbox" class="row-check" id="selectAll" onchange="toggleSelectAll(this)"></div>
        <div class="th-sort sorted" onclick="sortTable('quote-num')">Quote # <span class="sort-icon">▲</span></div>
        <div class="th-sort" onclick="sortTable('client')">Client <span class="sort-icon">↕</span></div>
        <div class="th-sort" onclick="sortTable('project')">Project</div>
        <div class="th-sort" onclick="sortTable('date-desc')">Issue Date <span class="sort-icon">↕</span></div>
        <div class="th-sort" onclick="sortTable('valid-asc')">Valid Until <span class="sort-icon">↕</span></div>
        <div class="th-sort" onclick="sortTable('amount-desc')">Amount <span class="sort-icon">↕</span></div>
        <div>Status</div>
      </div>
      <div id="tableBody">
        <!-- rows injected by JS -->
      </div>
      <div class="table-footer">
        <span id="tableCount">Showing 0 of 0 quotes</span>
        <div class="pagination">
          <button class="page-btn">‹</button>
          <button class="page-btn active">1</button>
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
    <button class="bulk-btn" onclick="bulkAction('accept')">✓ Mark Accepted</button>
    <button class="bulk-btn danger" onclick="bulkAction('delete')">✕ Delete</button>
  </div>
  <button class="bulk-close" onclick="clearSelection()">✕</button>
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- QUOTE CREATE / EDIT FORM PANEL                           -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="drilldown-backdrop" id="qfBackdrop" onclick="closeQuoteForm()"></div>
<div class="drilldown-panel" id="qfPanel">
  <div class="drilldown-header">
    <div class="drilldown-title-row">
      <div>
        <div class="qf-eyebrow" id="qfEyebrow">New Quote</div>
        <div class="qf-title" id="qfTitle">Create a quote</div>
      </div>
      <button class="drilldown-close" onclick="closeQuoteForm()">✕</button>
    </div>
    <div class="qf-subtitle" id="qfSubtitle">Fill in the client, line items, and terms below.</div>
  </div>

  <div class="drilldown-body">

    <div class="form-section-label">Quote Details</div>
    <div class="form-grid-2">
      <div class="form-group">
        <label class="form-label">Client</label>
        <select class="form-select" id="qfClient"></select>
      </div>
      <div class="form-group">
        <label class="form-label">Quote Number</label>
        <input class="form-input" id="qfNumber" readonly>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Project / Title</label>
      <input class="form-input" id="qfProject" placeholder="e.g. Brand Identity Package">
    </div>
    <div class="form-grid-2">
      <div class="form-group">
        <label class="form-label">Issue Date</label>
        <input type="date" class="form-input" id="qfIssued">
      </div>
      <div class="form-group">
        <label class="form-label">Valid Until</label>
        <input type="date" class="form-input" id="qfValid">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Status</label>
      <div class="qf-status-pills" id="qfStatusPills"></div>
    </div>

    <div class="form-section-label">Line Items</div>
    <div class="line-items-card">
      <div class="line-items-head">
        <span>Description</span><span>Qty</span><span>Rate</span><span>Amount</span><span></span>
      </div>
      <div id="qfLineItems"><!-- rows injected --></div>
      <button class="add-line-btn" type="button" onclick="addLineItem()">＋ Add Line Item</button>
    </div>

    <div class="form-section-label">Adjustments</div>
    <div class="form-grid-2">
      <div class="form-group">
        <label class="form-label">Discount (%)</label>
        <input type="number" class="form-input" id="qfDiscount" value="0" min="0" max="100" oninput="recalcTotals()">
      </div>
      <div class="form-group">
        <label class="form-label">Tax (%)</label>
        <input type="number" class="form-input" id="qfTax" value="0" min="0" max="100" oninput="recalcTotals()">
      </div>
    </div>

    <div class="totals-box">
      <div class="totals-row"><span>Subtotal</span><span id="qfSubtotal">$0.00</span></div>
      <div class="totals-row"><span>Discount</span><span id="qfDiscountAmt">−$0.00</span></div>
      <div class="totals-row"><span>Tax</span><span id="qfTaxAmt">+$0.00</span></div>
      <div class="totals-row total"><span>Total</span><span id="qfTotal">$0.00</span></div>
    </div>

    <div class="form-section-label">Notes &amp; Terms</div>
    <div class="form-group">
      <textarea class="form-textarea" id="qfNotes" rows="3" placeholder="Payment terms, validity conditions, additional notes…"></textarea>
      <div class="form-hint">Shown to the client at the bottom of the quote.</div>
    </div>

  </div>

  <div class="drilldown-footer">
    <button class="btn btn-ghost" onclick="closeQuoteForm()">Cancel</button>
    <button class="btn btn-outline" id="btnSaveDraft" onclick="saveQuote('draft')">Save Draft</button>
    <button class="btn btn-primary" id="btnSaveSend" onclick="saveQuote('sent')">Save &amp; Send ✓</button>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- SEARCH OVERLAY                                           -->
<!-- ═══════════════════════════════════════════════════════ -->
<div class="search-overlay" id="searchOverlay" onclick="closeSearch(event)">
  <div class="search-modal">
    <div class="search-modal-header">
      <span class="search-modal-icon">🔍</span>
      <input class="search-modal-input" id="searchModalInput" placeholder="Search quotes, clients, project…" oninput="runGlobalSearch(this.value)" autofocus>
      <span style="font-size:0.72rem;color:var(--muted);" id="searchModalCount"></span>
      <button class="search-modal-close" onclick="closeSearch()">✕</button>
    </div>
    <div class="search-results-body" id="searchModalBody">
      <div style="padding:40px 20px;text-align:center;">
        <div style="font-size:1.8rem;opacity:0.3;margin-bottom:8px;">🔍</div>
        <div style="font-size:0.85rem;color:var(--muted);">Start typing to search quotes</div>
      </div>
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════ -->
<!-- JAVASCRIPT                                               -->
<!-- ═══════════════════════════════════════════════════════ -->
<script>
// ─── DATA FROM BACKEND ────────────────────────────────────
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
let quotes = @json($jsQuotes);
let nextQuoteNum = {{ (int) filter_var($nextQuoteNumber ?? '0037', FILTER_SANITIZE_NUMBER_INT) ?: 37 }};

// Fallback clients if empty
if (!clients || !clients.length) {
  clients = [
    { id: 'CLT-001', name: 'Nexus Design Co.', email: 'billing@nexusdesign.com', initials: 'ND', color: avatarColors[0], tags: ['Retainer'] }
  ];
}

let activeStatusFilter = 'all';
let selectedRows = new Set();
let editingIdx = null;   // null = creating a new quote
let formItems = [];      // working line items for the open form
let liIdSeq = 1;

// ─── HELPERS ────────────────────────────────────────────────
function fmt$(n) {
  return '$' + (Number(n) || 0).toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2});
}
function fmtDate(d) {
  if (!d) return '—';
  const parts = String(d).split('T')[0].split('-');
  if (parts.length < 3) return d;
  const [y,m,day] = parts;
  return new Date(y,m-1,day).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
}
function isPast(d) {
  if (!d) return false;
  return new Date(d) < new Date();
}

function badgeClass(s) {
  s = (s || '').toLowerCase();
  return { draft:'badge-draft', sent:'badge-sent', accepted:'badge-accepted', declined:'badge-declined', rejected:'badge-declined', expired:'badge-expired' }[s] || 'badge-draft';
}
function badgeLabel(s) {
  s = (s || '').toLowerCase();
  return { draft:'Draft', sent:'Sent', accepted:'Accepted', declined:'Declined', rejected:'Declined', expired:'Expired' }[s] || (s.charAt(0).toUpperCase() + s.slice(1));
}
function calcTotal(items, discount, tax) {
  const list = items || [];
  const subtotal = list.reduce((s,i) => s + (Number(i.qty)||0) * (Number(i.rate)||0), 0);
  const discAmt = subtotal * (Number(discount)||0) / 100;
  const taxable = subtotal - discAmt;
  const taxAmt = taxable * (Number(tax)||0) / 100;
  return { subtotal, discAmt, taxAmt, total: taxable + taxAmt };
}

// ─── RENDER TABLE ──────────────────────────────────────────
function renderTable(list) {
  const tbody = document.getElementById('tableBody');
  if (!list || !list.length) {
    tbody.innerHTML = `<div class="empty-state"><div class="empty-icon">📄</div><div class="empty-title">No quotes found</div><div class="empty-sub">Try a different filter or create your first quote.</div></div>`;
    document.getElementById('tableCount').textContent = '0 quotes';
    return;
  }
  document.getElementById('tableCount').textContent = `Showing ${list.length} of ${quotes.length} quotes`;
  tbody.innerHTML = list.map((qt, i) => {
    let cl = clients[qt.clientIdx];
    if (!cl) {
      cl = clients.find(c => c.name.toLowerCase() === (qt.client_name || '').toLowerCase()) || {
        id: 'CLT-000',
        name: qt.client_name || 'Client',
        initials: (qt.client_name || 'CL').slice(0,2).toUpperCase(),
        color: avatarColors[i % avatarColors.length]
      };
    }
    const idx = quotes.indexOf(qt);
    const t = calcTotal(qt.items, qt.discount, qt.tax);
    const flagExpiring = (qt.status === 'sent') && isPast(qt.valid);
    const isChecked = selectedRows.has(idx) ? 'checked' : '';

    return `
      <div class="table-row" style="animation-delay:${i * 0.02}s" onclick="handleRowClick(event, ${idx})">
        <div><input type="checkbox" class="row-check" data-idx="${idx}" ${isChecked} onclick="event.stopPropagation()" onchange="handleCheckbox(this)"></div>
        <div class="inv-num">
          <div class="inv-icon">📄</div>
          QUO-${qt.q}
        </div>
        <div class="client-cell">
          <div class="client-avatar-sm" style="background:${cl.color || avatarColors[0]}">${cl.initials || 'CL'}</div>
          <div class="client-info">
            <div class="client-name">${cl.name}</div>
            <div class="client-id">${cl.id || ''}</div>
          </div>
        </div>
        <div class="project-cell" title="${qt.project || 'Proposal'}">${qt.project || 'Proposal'}</div>
        <div class="date-cell">${fmtDate(qt.issued)}</div>
        <div class="date-cell ${flagExpiring ? 'overdue' : ''}">${flagExpiring ? '⚠ ' : ''}${fmtDate(qt.valid)}</div>
        <div class="amount-cell">${fmt$(t.total)}</div>
        <div style="display:flex;align-items:center;gap:8px;justify-content:space-between;">
          <span class="status-badge ${badgeClass(qt.status)}">
            <span class="badge-dot"></span>${badgeLabel(qt.status)}
          </span>
          <div class="row-actions" onclick="event.stopPropagation()">
            <button class="action-btn" title="Edit" onclick="openQuoteForm(${idx})">✎</button>
            ${qt.status === 'accepted' ? `<button class="action-btn teal" title="Convert to Invoice" onclick="convertToInvoice(${idx})">⇄</button>` : ''}
            <button class="action-btn" title="Duplicate" onclick="duplicateQuote(${idx})">⧉</button>
            <button class="action-btn danger" title="Delete" onclick="deleteQuote(${idx})">✕</button>
          </div>
        </div>
      </div>`;
  }).join('');
}

// ─── STATS ─────────────────────────────────────────────────
function renderStats() {
  const totals = quotes.map(qt => calcTotal(qt.items, qt.discount, qt.tax).total);
  const sum = arr => arr.reduce((a,b) => a+b, 0);

  const all = quotes.map((qt,i) => ({qt, total: totals[i]}));
  const pending = all.filter(x => x.qt.status === 'sent' || x.qt.status === 'draft');
  const accepted = all.filter(x => x.qt.status === 'accepted');
  const lost = all.filter(x => x.qt.status === 'declined' || x.qt.status === 'rejected' || x.qt.status === 'expired');

  document.getElementById('statTotalAmt').textContent = fmt$(sum(totals)).replace('.00','');
  document.getElementById('statTotalCount').textContent = `${quotes.length} quote${quotes.length !== 1 ? 's' : ''}`;

  document.getElementById('statPendingAmt').textContent = fmt$(sum(pending.map(x=>x.total))).replace('.00','');
  document.getElementById('statPendingCount').textContent = `${pending.length} quote${pending.length !== 1 ? 's' : ''}`;

  document.getElementById('statAcceptedAmt').textContent = fmt$(sum(accepted.map(x=>x.total))).replace('.00','');
  document.getElementById('statAcceptedCount').textContent = `${accepted.length} quote${accepted.length !== 1 ? 's' : ''}`;

  document.getElementById('statLostAmt').textContent = fmt$(sum(lost.map(x=>x.total))).replace('.00','');
  document.getElementById('statLostCount').textContent = `${lost.length} quote${lost.length !== 1 ? 's' : ''}`;

  const navCount = document.getElementById('navQuoteCount');
  if (navCount) navCount.textContent = quotes.length;
}

// ─── FILTERING / SORTING ───────────────────────────────────
function getFiltered() {
  const q = (document.getElementById('tableSearch').value || '').trim().toLowerCase();
  return quotes.filter(qt => {
    let cl = clients[qt.clientIdx];
    if (!cl) {
      cl = clients.find(c => c.name.toLowerCase() === (qt.client_name || '').toLowerCase()) || { name: qt.client_name || '', id: '' };
    }
    if (activeStatusFilter === 'lost') {
      if (qt.status !== 'declined' && qt.status !== 'rejected' && qt.status !== 'expired') return false;
    } else if (activeStatusFilter !== 'all') {
      if (activeStatusFilter === 'declined' && (qt.status === 'rejected' || qt.status === 'declined')) {
        // match
      } else if (qt.status !== activeStatusFilter) {
        return false;
      }
    }
    if (!q) return true;
    return (
      (qt.q && String(qt.q).toLowerCase().includes(q)) ||
      (cl.name && cl.name.toLowerCase().includes(q)) ||
      (cl.id && cl.id.toLowerCase().includes(q)) ||
      (qt.project && qt.project.toLowerCase().includes(q)) ||
      (qt.status && qt.status.toLowerCase().includes(q))
    );
  });
}

function filterTable() { renderTable(getFiltered()); }

function setStatusFilter(status, btn) {
  activeStatusFilter = status;
  document.querySelectorAll('.filters-left .filter-chip').forEach(c => c.classList.remove('active'));
  if (btn) btn.classList.add('active');
  document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
  renderTable(getFiltered());
}

function filterByStatus(status, card) {
  activeStatusFilter = status;
  document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
  if (card) card.classList.add('active');
  document.querySelectorAll('.filters-left .filter-chip').forEach(c => {
    const label = c.textContent.trim().toLowerCase();
    c.classList.toggle('active', label === status || (status === 'all' && label === 'all'));
  });
  renderTable(getFiltered());
}

function sortTable(mode) {
  const sorted = [...getFiltered()];
  if (mode === 'date-desc') sorted.sort((a,b) => (b.issued||'').localeCompare(a.issued||''));
  else if (mode === 'date-asc') sorted.sort((a,b) => (a.issued||'').localeCompare(b.issued||''));
  else if (mode === 'amount-desc') sorted.sort((a,b) => calcTotal(b.items,b.discount,b.tax).total - calcTotal(a.items,a.discount,a.tax).total);
  else if (mode === 'amount-asc') sorted.sort((a,b) => calcTotal(a.items,a.discount,a.tax).total - calcTotal(b.items,b.discount,b.tax).total);
  else if (mode === 'valid-asc') sorted.sort((a,b) => (a.valid||'').localeCompare(b.valid||''));
  else if (mode === 'quote-num') sorted.sort((a,b) => (b.q||'').localeCompare(a.q||''));
  else if (mode === 'client') {
    sorted.sort((a,b) => {
      const na = (clients[a.clientIdx]?.name || a.client_name || '').toLowerCase();
      const nb = (clients[b.clientIdx]?.name || b.client_name || '').toLowerCase();
      return na.localeCompare(nb);
    });
  }
  renderTable(sorted);
}

// ─── ROW INTERACTION ───────────────────────────────────────
function handleRowClick(e, idx) {
  if (e.target.classList.contains('row-check') || e.target.closest('.row-actions')) return;
  openQuoteForm(idx);
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
    document.getElementById('bulkCount').textContent = `${n} quote${n !== 1 ? 's' : ''} selected`;
  } else {
    bar.classList.remove('visible');
  }
}
function clearSelection() {
  selectedRows.clear();
  const selectAllBox = document.getElementById('selectAll');
  if (selectAllBox) selectAllBox.checked = false;
  document.querySelectorAll('.row-check').forEach(c => c.checked = false);
  updateBulkBar();
}

function bulkAction(action) {
  const n = selectedRows.size;
  if (n === 0) return;

  const selectedQuotes = Array.from(selectedRows).map(idx => quotes[idx]).filter(Boolean);
  const quoteNumbers = selectedQuotes.map(q => q.q);

  if (action === 'pdf') {
    toast(`Preparing PDF export for ${n} quote(s)...`);
    exportQuotes();
    clearSelection();
    return;
  }

  const actionLabels = {
    send: `Mark ${n} quote(s) as sent?`,
    accept: `Mark ${n} quote(s) as accepted?`,
    delete: `Permanently delete ${n} quote(s)? This cannot be undone.`
  };

  if (!confirm(actionLabels[action] || `Perform ${action} on ${n} quotes?`)) return;

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  fetch("{{ route('subscriber.quotes.bulk') }}", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify({ action: action, quotes: quoteNumbers })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      toast(data.message || 'Action completed');
      if (action === 'delete') {
        selectedQuotes.forEach(sq => {
          const pos = quotes.indexOf(sq);
          if (pos > -1) quotes.splice(pos, 1);
        });
      } else if (action === 'send') {
        selectedQuotes.forEach(sq => sq.status = 'sent');
      } else if (action === 'accept') {
        selectedQuotes.forEach(sq => sq.status = 'accepted');
      }
      clearSelection();
      renderStats();
      renderTable(getFiltered());
    } else {
      alert(data.message || 'Action failed');
    }
  })
  .catch(err => {
    console.error(err);
    alert('Server error during bulk operation.');
  });
}

// ─── ACTIONS ───────────────────────────────────────────────
function duplicateQuote(idx) {
  const original = quotes[idx];
  if (!original) return;

  const nextNum = String(nextQuoteNum++).padStart(4, '0');
  const duplicated = {
    ...JSON.parse(JSON.stringify(original)),
    id: null,
    q: nextNum,
    project: (original.project || 'Quote') + ' (Copy)',
    issued: new Date().toISOString().slice(0,10),
    status: 'draft'
  };

  // Open drawer with duplicated quote
  openQuoteFormWithData(duplicated);
  toast('Created copy as QUO-' + nextNum + '. Review and save.');
}

function deleteQuote(idx) {
  const qt = quotes[idx];
  if (!qt) return;
  if (!confirm(`Delete Quote QUO-${qt.q}? This action cannot be undone.`)) return;

  if (qt.id) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    fetch("{{ url('subscriber/quotes') }}/" + qt.id, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        toast(`Quote QUO-${qt.q} deleted`);
        quotes.splice(idx, 1);
        renderStats();
        renderTable(getFiltered());
      } else {
        alert(data.message || 'Delete failed');
      }
    })
    .catch(err => {
      console.error(err);
      quotes.splice(idx, 1);
      renderStats();
      renderTable(getFiltered());
      toast(`Quote QUO-${qt.q} deleted`);
    });
  } else {
    quotes.splice(idx, 1);
    renderStats();
    renderTable(getFiltered());
    toast(`Quote QUO-${qt.q} deleted`);
  }
}

function convertToInvoice(idx) {
  const qt = quotes[idx];
  if (!qt) return;
  if (!confirm(`Convert Quote QUO-${qt.q} directly into a new Invoice?`)) return;

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  if (qt.id) {
    fetch("{{ url('subscriber/quotes') }}/" + qt.id + "/convert-to-invoice", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        toast(data.message || 'Quote converted to Invoice!');
        qt.status = 'accepted';
        renderStats();
        renderTable(getFiltered());
        if (data.redirect_url) {
          setTimeout(() => window.location.href = data.redirect_url, 900);
        }
      } else {
        alert(data.message || 'Conversion failed');
      }
    })
    .catch(err => {
      console.error(err);
      alert('Could not convert quote.');
    });
  } else {
    alert('Please save the quote first before converting.');
  }
}

function exportQuotes() {
  let csv = "Quote,Client,Project,Issued,Valid,Subtotal,Discount,Tax,Total,Status\n";
  quotes.forEach(qt => {
    const cl = clients[qt.clientIdx]?.name || qt.client_name || '';
    const t = calcTotal(qt.items, qt.discount, qt.tax);
    csv += `QUO-${qt.q},"${cl.replace(/"/g, '""')}","${(qt.project||'').replace(/"/g, '""')}",${qt.issued},${qt.valid},${t.subtotal},${qt.discount}%,${qt.tax}%,${t.total},${qt.status}\n`;
  });
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.setAttribute('href', url);
  a.setAttribute('download', `Velo_Quotes_${new Date().toISOString().slice(0,10)}.csv`);
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  toast('Quotes CSV exported successfully');
}

// ─── QUOTE FORM: OPEN / CLOSE ───────────────────────────────
function populateClientSelect() {
  const sel = document.getElementById('qfClient');
  sel.innerHTML = clients.map((c,i) => `<option value="${i}">${c.name} (${c.id || 'Client'})</option>`).join('');
}

function renderStatusPills(selected) {
  const statuses = ['draft','sent','accepted','declined','expired'];
  const wrap = document.getElementById('qfStatusPills');
  wrap.innerHTML = statuses.map(s => `
    <button type="button" class="qf-status-pill ${s === selected ? 'active' : ''}" data-status="${s}" onclick="selectStatusPill(this)">
      <span class="badge-dot" style="width:6px;height:6px;border-radius:50%;background:currentColor;"></span>${badgeLabel(s)}
    </button>`).join('');
}
function selectStatusPill(btn) {
  document.querySelectorAll('.qf-status-pill').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
}
function getSelectedStatusPill() {
  const active = document.querySelector('.qf-status-pill.active');
  return active ? active.dataset.status : 'draft';
}

function openQuoteForm(idx) {
  editingIdx = idx;
  populateClientSelect();

  if (idx === null) {
    const nextNum = String(nextQuoteNum).padStart(4,'0');
    document.getElementById('qfEyebrow').textContent = 'New Quote';
    document.getElementById('qfTitle').textContent = 'Create a quote';
    document.getElementById('qfSubtitle').textContent = 'Fill in the client, line items, and terms below.';
    document.getElementById('qfNumber').value = 'QUO-' + nextNum;
    document.getElementById('qfClient').value = 0;
    document.getElementById('qfProject').value = '';
    document.getElementById('qfIssued').value = new Date().toISOString().slice(0,10);
    const validDate = new Date(); validDate.setDate(validDate.getDate() + 14);
    document.getElementById('qfValid').value = validDate.toISOString().slice(0,10);
    document.getElementById('qfDiscount').value = 0;
    document.getElementById('qfTax').value = 0;
    document.getElementById('qfNotes').value = 'Thank you for considering our proposal. Valid for 14 days.';
    formItems = [{ id: liIdSeq++, desc:'', qty:1, rate:0 }];
    renderStatusPills('draft');
  } else {
    const qt = quotes[idx];
    document.getElementById('qfEyebrow').textContent = 'Edit Quote';
    document.getElementById('qfTitle').textContent = 'QUO-' + qt.q;
    document.getElementById('qfSubtitle').textContent = 'Update the details below and save your changes.';
    document.getElementById('qfNumber').value = 'QUO-' + qt.q;
    document.getElementById('qfClient').value = (qt.clientIdx !== undefined && qt.clientIdx >= 0) ? qt.clientIdx : 0;
    document.getElementById('qfProject').value = qt.project || '';
    document.getElementById('qfIssued').value = qt.issued || new Date().toISOString().slice(0,10);
    document.getElementById('qfValid').value = qt.valid || '';
    document.getElementById('qfDiscount').value = qt.discount || 0;
    document.getElementById('qfTax').value = qt.tax || 0;
    document.getElementById('qfNotes').value = qt.notes || '';
    formItems = (qt.items && qt.items.length) ? qt.items.map(i => ({ id: liIdSeq++, desc:i.desc, qty:i.qty, rate:i.rate })) : [{ id: liIdSeq++, desc:'', qty:1, rate:0 }];
    renderStatusPills(qt.status || 'draft');
  }

  renderLineItems();
  recalcTotals();
  document.getElementById('qfBackdrop').classList.add('open');
  document.getElementById('qfPanel').classList.add('open');
}

function openQuoteFormWithData(qtData) {
  editingIdx = null;
  populateClientSelect();
  document.getElementById('qfEyebrow').textContent = 'New Quote (Copy)';
  document.getElementById('qfTitle').textContent = 'QUO-' + qtData.q;
  document.getElementById('qfSubtitle').textContent = 'Review duplicated quote and save.';
  document.getElementById('qfNumber').value = 'QUO-' + qtData.q;
  document.getElementById('qfClient').value = (qtData.clientIdx !== undefined) ? qtData.clientIdx : 0;
  document.getElementById('qfProject').value = qtData.project || '';
  document.getElementById('qfIssued').value = qtData.issued || new Date().toISOString().slice(0,10);
  document.getElementById('qfValid').value = qtData.valid || '';
  document.getElementById('qfDiscount').value = qtData.discount || 0;
  document.getElementById('qfTax').value = qtData.tax || 0;
  document.getElementById('qfNotes').value = qtData.notes || '';
  formItems = (qtData.items && qtData.items.length) ? qtData.items.map(i => ({ id: liIdSeq++, desc:i.desc, qty:i.qty, rate:i.rate })) : [{ id: liIdSeq++, desc:'', qty:1, rate:0 }];
  renderStatusPills(qtData.status || 'draft');
  renderLineItems();
  recalcTotals();
  document.getElementById('qfBackdrop').classList.add('open');
  document.getElementById('qfPanel').classList.add('open');
}

function closeQuoteForm() {
  document.getElementById('qfBackdrop').classList.remove('open');
  document.getElementById('qfPanel').classList.remove('open');
  editingIdx = null;
}

// ─── QUOTE FORM: LINE ITEMS ──────────────────────────────────
function renderLineItems() {
  const wrap = document.getElementById('qfLineItems');
  wrap.innerHTML = formItems.map(item => `
    <div class="line-item-row" data-id="${item.id}">
      <input class="li-input" placeholder="Item description" value="${item.desc || ''}" oninput="updateLineItem(${item.id},'desc',this.value)">
      <input type="number" class="li-input li-num" value="${item.qty}" min="0" step="any" oninput="updateLineItem(${item.id},'qty',this.value)">
      <input type="number" class="li-input li-num" value="${item.rate}" min="0" step="any" oninput="updateLineItem(${item.id},'rate',this.value)">
      <div class="li-amount">${fmt$((Number(item.qty)||0) * (Number(item.rate)||0))}</div>
      <button type="button" class="li-remove" onclick="removeLineItem(${item.id})" title="Remove">✕</button>
    </div>`).join('');
}
function addLineItem() {
  formItems.push({ id: liIdSeq++, desc:'', qty:1, rate:0 });
  renderLineItems();
  recalcTotals();
}
function removeLineItem(id) {
  if (formItems.length === 1) { toast('A quote needs at least one line item.'); return; }
  formItems = formItems.filter(i => i.id !== id);
  renderLineItems();
  recalcTotals();
}
function updateLineItem(id, field, value) {
  const item = formItems.find(i => i.id === id);
  if (!item) return;
  item[field] = field === 'desc' ? value : Number(value);
  recalcTotals();
  const row = document.querySelector(`.line-item-row[data-id="${id}"] .li-amount`);
  if (row) row.textContent = fmt$((Number(item.qty)||0) * (Number(item.rate)||0));
}

// ─── QUOTE FORM: TOTALS ───────────────────────────────────────
function recalcTotals() {
  const discount = Number(document.getElementById('qfDiscount').value) || 0;
  const tax = Number(document.getElementById('qfTax').value) || 0;
  const t = calcTotal(formItems, discount, tax);
  document.getElementById('qfSubtotal').textContent = fmt$(t.subtotal);
  document.getElementById('qfDiscountAmt').textContent = '−' + fmt$(t.discAmt);
  document.getElementById('qfTaxAmt').textContent = '+' + fmt$(t.taxAmt);
  document.getElementById('qfTotal').textContent = fmt$(t.total);
}

// ─── QUOTE FORM: SAVE TO SERVER ───────────────────────────────
function saveQuote(defaultStatus) {
  const clientIdx = Number(document.getElementById('qfClient').value) || 0;
  const clientObj = clients[clientIdx] || { name: 'Client' };
  const project = document.getElementById('qfProject').value.trim() || 'Proposal';
  const quoteNumber = document.getElementById('qfNumber').value.replace('QUO-', '').trim();
  const issued = document.getElementById('qfIssued').value || new Date().toISOString().slice(0,10);
  const valid = document.getElementById('qfValid').value || issued;
  const discount = Number(document.getElementById('qfDiscount').value) || 0;
  const tax = Number(document.getElementById('qfTax').value) || 0;
  const notes = document.getElementById('qfNotes').value;
  const status = getSelectedStatusPill() || defaultStatus;

  const validItems = formItems
    .filter(i => (i.desc && i.desc.trim() !== '') || Number(i.rate) > 0)
    .map(i => ({
      desc: (i.desc || 'Service Item').trim(),
      qty: Number(i.qty) || 1,
      rate: Number(i.rate) || 0,
      amount: (Number(i.qty) || 1) * (Number(i.rate) || 0)
    }));

  if (!validItems.length) {
    alert('Please enter at least one line item with a description and rate.');
    return;
  }

  const payload = {
    client_name: clientObj.name,
    clientIdx: clientIdx,
    project: project,
    quote_number: quoteNumber,
    issued: issued,
    valid: valid,
    discount: discount,
    tax: tax,
    notes: notes,
    status: status,
    items: validItems
  };

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
  const isEdit = (editingIdx !== null && quotes[editingIdx] && quotes[editingIdx].id);
  const url = isEdit
    ? "{{ url('subscriber/quotes') }}/" + quotes[editingIdx].id
    : "{{ route('subscriber.quotes.store') }}";
  const method = isEdit ? 'PUT' : 'POST';

  const btnDraft = document.getElementById('btnSaveDraft');
  const btnSend = document.getElementById('btnSaveSend');
  if (btnDraft) btnDraft.disabled = true;
  if (btnSend) btnSend.disabled = true;

  fetch(url, {
    method: method,
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
      'Accept': 'application/json'
    },
    body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(data => {
    if (btnDraft) btnDraft.disabled = false;
    if (btnSend) btnSend.disabled = false;

    if (data.success) {
      const returnedQuote = data.quote || {
        id: data.quote_number,
        q: quoteNumber,
        clientIdx: clientIdx,
        client_name: clientObj.name,
        project: project,
        issued: issued,
        valid: valid,
        items: validItems,
        discount: discount,
        tax: tax,
        notes: notes,
        status: status
      };
      returnedQuote.clientIdx = clientIdx;

      if (isEdit) {
        quotes[editingIdx] = { ...quotes[editingIdx], ...returnedQuote };
      } else {
        quotes.unshift(returnedQuote);
        nextQuoteNum++;
      }

      closeQuoteForm();
      renderStats();
      renderTable(getFiltered());
      toast(data.message || (isEdit ? 'Quote updated successfully' : 'Quote created successfully'));
    } else {
      alert(data.message || 'Error saving quote.');
    }
  })
  .catch(err => {
    console.error(err);
    if (btnDraft) btnDraft.disabled = false;
    if (btnSend) btnSend.disabled = false;

    // Fallback local update
    const localQuote = {
      id: isEdit ? quotes[editingIdx].id : null,
      q: quoteNumber,
      clientIdx: clientIdx,
      client_name: clientObj.name,
      project: project,
      issued: issued,
      valid: valid,
      items: validItems,
      discount: discount,
      tax: tax,
      notes: notes,
      status: status
    };
    if (isEdit) {
      quotes[editingIdx] = localQuote;
    } else {
      quotes.unshift(localQuote);
      nextQuoteNum++;
    }
    closeQuoteForm();
    renderStats();
    renderTable(getFiltered());
    toast(isEdit ? 'Quote updated' : 'Quote saved');
  });
}

// ─── GLOBAL SEARCH ─────────────────────────────────────────
function openSearch() {
  document.getElementById('searchOverlay').classList.add('open');
  setTimeout(() => document.getElementById('searchModalInput').focus(), 80);
}
function closeSearch(e) {
  if (e && e.target !== document.getElementById('searchOverlay') && !e.target.classList.contains('search-modal-close')) return;
  document.getElementById('searchOverlay').classList.remove('open');
  document.getElementById('searchModalInput').value = '';
  document.getElementById('searchModalCount').textContent = '';
  document.getElementById('searchModalBody').innerHTML = `<div style="padding:40px 20px;text-align:center;"><div style="font-size:1.8rem;opacity:0.3;margin-bottom:8px;">🔍</div><div style="font-size:0.85rem;color:var(--muted);">Start typing to search quotes</div></div>`;
}
function runGlobalSearch(q) {
  const body = document.getElementById('searchModalBody');
  if (!q.trim()) {
    body.innerHTML = `<div style="padding:40px 20px;text-align:center;"><div style="font-size:1.8rem;opacity:0.3;margin-bottom:8px;">🔍</div><div style="font-size:0.85rem;color:var(--muted);">Start typing to search quotes</div></div>`;
    document.getElementById('searchModalCount').textContent = '';
    return;
  }
  const ql = q.trim().toLowerCase();
  const filtered = quotes.filter(qt => {
    const cl = clients[qt.clientIdx] || { name: qt.client_name || '' };
    return (
      (qt.q && String(qt.q).toLowerCase().includes(ql)) ||
      (cl.name && cl.name.toLowerCase().includes(ql)) ||
      (qt.project && qt.project.toLowerCase().includes(ql)) ||
      (qt.status && qt.status.toLowerCase().includes(ql))
    );
  });
  document.getElementById('searchModalCount').textContent = filtered.length ? `${filtered.length} result${filtered.length !== 1 ? 's' : ''}` : '';
  if (!filtered.length) {
    body.innerHTML = `<div style="padding:40px 20px;text-align:center;"><div style="font-size:1.8rem;opacity:0.3;margin-bottom:8px;">😶</div><div style="font-size:0.85rem;color:var(--muted);">No quotes match "${q}"</div></div>`;
    return;
  }
  body.innerHTML = filtered.map(qt => {
    const cl = clients[qt.clientIdx] || { name: qt.client_name || 'Client' };
    const t = calcTotal(qt.items, qt.discount, qt.tax);
    return `
      <div class="search-quick-item" onclick="openQuoteForm(${quotes.indexOf(qt)});document.getElementById('searchOverlay').classList.remove('open')">
        <div style="width:34px;height:34px;border-radius:8px;background:var(--teal-pale);display:flex;align-items:center;justify-content:center;font-size:0.8rem;flex-shrink:0;">📄</div>
        <div style="flex:1;min-width:0;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.82rem;color:var(--slate);">QUO-${qt.q}</div>
          <div style="font-size:0.75rem;color:var(--muted);">${cl.name} · ${qt.project || 'Proposal'}</div>
        </div>
        <span class="status-badge ${badgeClass(qt.status)}" style="flex-shrink:0;"><span class="badge-dot"></span>${badgeLabel(qt.status)}</span>
        <div style="text-align:right;flex-shrink:0;">
          <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:0.88rem;">${fmt$(t.total)}</div>
          <div style="font-size:0.72rem;color:var(--muted);">Valid ${fmtDate(qt.valid)}</div>
        </div>
      </div>`;
  }).join('');
}

document.addEventListener('keydown', e => {
  if ((e.metaKey || e.ctrlKey) && e.key === 'k') { e.preventDefault(); openSearch(); }
  if (e.key === 'Escape') {
    document.getElementById('searchOverlay').classList.remove('open');
    closeQuoteForm();
  }
});

// ─── TOAST NOTIFICATION ────────────────────────────────────
window.toast = function(message) {
  let t = document.getElementById('toast');
  if (!t) {
    t = document.createElement('div');
    t.id = 'toast';
    t.style.cssText = 'position:fixed;left:50%;bottom:24px;z-index:9999;transform:translateX(-50%);background:#1e2a38;color:#fff;padding:11px 20px;border-radius:10px;box-shadow:0 12px 32px rgba(0,0,0,.22);font-size:0.85rem;font-weight:600;opacity:0;transition:opacity .2s, transform .2s;pointer-events:none;';
    document.body.appendChild(t);
  }
  t.textContent = message;
  t.style.opacity = '1';
  t.style.transform = 'translateX(-50%) translateY(0)';
  clearTimeout(window.__layoutToastTimer);
  window.__layoutToastTimer = setTimeout(() => {
    t.style.opacity = '0';
    t.style.transform = 'translateX(-50%) translateY(16px)';
  }, 2400);
};

// ─── SIDEBAR TOGGLE ────────────────────────────────────────
window.closeSidebar = function() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  if (sidebar) sidebar.classList.remove('open');
  if (overlay) overlay.classList.remove('open', 'visible');
};

window.toggleDashboardSidebar = function() {
  if (window.matchMedia('(max-width: 960px)').matches) {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (sidebar) sidebar.classList.toggle('open');
    if (overlay) overlay.classList.toggle('visible');
    return;
  }
  document.body.classList.toggle('dashboard-sidebar-collapsed');
};

// ─── INIT ──────────────────────────────────────────────────
renderStats();
renderTable(quotes);
</script>

</body>
</html>
