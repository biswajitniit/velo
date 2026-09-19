<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Billflow — {{ isset($quote) ? 'Edit Quote QUO-' . $quote->quote_number : 'New Quote' }}</title>
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
  .user-name { font-size: 0.82rem; font-weight: 600; color: #fff; }
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
  .nav-item .nav-chevron {
    font-size: 0.6rem; color: rgba(255,255,255,0.3);
    transition: transform .2s; flex-shrink: 0;
  }
  .nav-item.open .nav-chevron { transform: rotate(90deg); }
  @keyframes panelPulse {
    0%   { box-shadow: 0 0 0 0 rgba(0,184,153,0.0); }
    30%  { box-shadow: 0 0 0 4px rgba(0,184,153,0.25); }
    100% { box-shadow: 0 0 0 0 rgba(0,184,153,0.0); }
  }
  .panel-highlight { animation: panelPulse 0.9s ease; border-radius: var(--radius); }

  .nav-count, .nav-badge {
    font-size: 0.7rem; font-weight: 600; padding: 1px 7px;
    border-radius: 99px; background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.5);
  }
  .nav-badge.red {
    background: var(--red-soft);
    color: #fff;
  }
  .sidebar-toggle-btn {
    width: 38px; height: 38px; border-radius: 10px;
    border: 1.5px solid var(--border); background: var(--card);
    display: inline-flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 4px; cursor: pointer; transition: all .15s; flex-shrink: 0;
  }
  .sidebar-toggle-btn:hover { border-color: var(--teal); background: var(--teal-pale); }
  .sidebar-toggle-btn span { display: block; width: 16px; height: 2px; border-radius: 99px; background: var(--slate); }
  .sidebar-overlay {
    display: none; position: fixed; inset: 0; background: rgba(13,13,13,0.45); backdrop-filter: blur(3px); z-index: 45;
  }
  .sidebar-overlay.open, .sidebar-overlay.visible { display: block; }
  body.dashboard-sidebar-collapsed .sidebar { transform: translateX(-100%); }
  body.dashboard-sidebar-collapsed .shell { margin-left: 0; }
  @media (max-width: 960px) {
    .sidebar { transform: translateX(-100%); transition: transform .25s; }
    .sidebar.open { transform: translateX(0); }
    .shell, body.dashboard-sidebar-collapsed .shell { margin-left: 0; }
  }
  .sidebar-footer {
    padding: 16px 24px; border-top: 1px solid var(--border-dark); flex-shrink: 0;
  }
  .sidebar-footer a {
    display: flex; align-items: center; gap: 10px; padding: 9px 12px;
    border-radius: var(--radius-sm); color: rgba(255,255,255,0.5);
    font-size: 0.82rem; text-decoration: none; transition: background .15s, color .15s;
  }
  .sidebar-footer a:hover { background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.8); }

  /* ─── SHELL ───────────────────────────────────────────── */
  .shell {
    margin-left: var(--sidebar-w);
    flex: 1; display: flex; flex-direction: column; min-height: 100vh;
  }

  /* ─── TOPBAR ──────────────────────────────────────────── */
  .topbar {
    position: sticky; top: 0; z-index: 40;
    height: var(--topbar-h);
    background: rgba(245,242,235,0.92); backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 32px; gap: 16px;
  }
  .topbar-left { display: flex; align-items: center; gap: 12px; }
  .breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 0.82rem; color: var(--muted);
  }
  .breadcrumb a { color: var(--muted); text-decoration: none; transition: color .15s; }
  .breadcrumb a:hover { color: var(--teal); }
  .breadcrumb-sep { color: var(--border); }
  .breadcrumb-current {
    font-family: 'Syne', sans-serif;
    font-weight: 700; font-size: 1rem; color: var(--slate); letter-spacing: -0.02em;
  }
  .topbar-actions { display: flex; align-items: center; gap: 10px; }
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
  .main {
    flex: 1; padding: 32px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    align-items: start;
  }

  /* ─── CARD ────────────────────────────────────────────── */
  .card {
    background: var(--card); border-radius: var(--radius);
    border: 1px solid var(--border); box-shadow: var(--shadow-sm);
    overflow: hidden;
  }
  .card-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
  }
  .card-title {
    font-family: 'Syne', sans-serif;
    font-size: 0.9rem; font-weight: 700; color: var(--slate); letter-spacing: -0.01em;
  }
  .card-body { padding: 24px; }

  /* ─── FORM ELEMENTS ───────────────────────────────────── */
  .form-row {
    display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;
  }
  .form-row.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
  .form-row.full { grid-template-columns: 1fr; }
  .form-group { display: flex; flex-direction: column; gap: 6px; }
  label {
    font-size: 0.75rem; font-weight: 600; color: var(--slate);
    letter-spacing: 0.02em; text-transform: uppercase;
  }
  input, select, textarea {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem; color: var(--ink);
    background: var(--paper); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); padding: 10px 14px;
    outline: none; transition: border-color .2s, box-shadow .2s;
    width: 100%;
  }
  input:focus, select:focus, textarea:focus {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(0,184,153,0.12);
    background: #fff;
  }
  input::placeholder, textarea::placeholder { color: #b0aca0; }
  select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%236b7280' d='M6 8L0 0h12z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
  textarea { resize: vertical; min-height: 80px; }

  /* ─── SECTION DIVIDER ─────────────────────────────────── */
  .section-label {
    font-family: 'Syne', sans-serif;
    font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--muted);
    margin-bottom: 14px; margin-top: 4px;
    display: flex; align-items: center; gap: 10px;
  }
  .section-label::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }

  /* ─── CLIENT SELECTOR ─────────────────────────────────── */
  .client-select-wrap { position: relative; }
  .client-select-wrap input { padding-left: 40px; }
  .client-select-wrap .client-icon {
    position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
    font-size: 1rem; color: var(--muted); pointer-events: none;
  }
  .client-dropdown {
    position: absolute; top: calc(100% + 6px); left: 0; right: 0;
    background: var(--card); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); box-shadow: var(--shadow-md);
    z-index: 20; overflow: hidden;
  }
  .client-option {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; cursor: pointer; transition: background .12s;
    font-size: 0.85rem;
  }
  .client-option:hover { background: var(--paper); }
  .client-avatar-sm {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, var(--teal), var(--teal-dark));
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem; font-weight: 700; color: #fff; flex-shrink: 0;
  }
  .client-meta { flex: 1; min-width: 0; }
  .client-name { font-weight: 600; color: var(--ink); }
  .client-email { font-size: 0.75rem; color: var(--muted); }

  /* ─── LINE ITEMS ──────────────────────────────────────── */
  .line-items-header {
    display: grid;
    grid-template-columns: 2fr 1fr 80px 120px 120px 44px;
    gap: 8px; padding: 0 0 8px;
    font-size: 0.7rem; font-weight: 600; letter-spacing: 0.06em;
    text-transform: uppercase; color: var(--muted);
    border-bottom: 1.5px solid var(--border); margin-bottom: 10px;
  }
  .line-item {
    display: grid;
    grid-template-columns: 2fr 1fr 80px 120px 120px 44px;
    gap: 8px; align-items: center; margin-bottom: 8px;
    animation: itemIn .2s ease;
  }
  @keyframes itemIn {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .line-item input { margin-bottom: 0; }
  .line-item .amount-display {
    background: var(--paper); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); padding: 10px 14px;
    font-size: 0.875rem; font-weight: 600; color: var(--slate);
    text-align: right;
  }
  .delete-btn {
    width: 36px; height: 36px;
    border-radius: 8px; border: 1.5px solid var(--border);
    background: transparent; cursor: pointer; color: var(--muted);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; transition: all .15s; flex-shrink: 0;
  }
  .delete-btn:hover { background: var(--red-pale); border-color: var(--red-soft); color: var(--red-soft); }
  .add-line-btn {
    display: inline-flex; align-items: center; gap: 7px;
    margin-top: 6px; padding: 8px 14px; border-radius: var(--radius-sm);
    border: 1.5px dashed var(--border); background: transparent;
    color: var(--muted); font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem; font-weight: 500; cursor: pointer;
    transition: all .15s;
  }
  .add-line-btn:hover {
    border-color: var(--teal); color: var(--teal); background: var(--teal-pale);
  }

  /* ─── SIDEBAR PANEL ───────────────────────────────────── */
  .side-panel { display: flex; flex-direction: column; gap: 16px; }

  /* ─── SUMMARY CARD ────────────────────────────────────── */
  .summary-rows { display: flex; flex-direction: column; gap: 0; }
  .summary-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 0; border-bottom: 1px solid var(--border);
    font-size: 0.875rem;
  }
  .summary-row:last-child { border-bottom: none; }
  .summary-row .label { color: var(--muted); }
  .summary-row .value { font-weight: 600; color: var(--ink); }
  .summary-row.total {
    padding-top: 14px; margin-top: 4px;
    border-top: 2px solid var(--ink);
    border-bottom: none;
  }
  .summary-row.total .label {
    font-family: 'Syne', sans-serif;
    font-weight: 700; font-size: 0.9rem; color: var(--slate);
  }
  .summary-row.total .value {
    font-family: 'Syne', sans-serif;
    font-weight: 800; font-size: 1.25rem; color: var(--teal);
  }

  /* ─── TAX ROW ─────────────────────────────────────────── */
  .tax-input-wrap {
    display: flex; align-items: center; gap: 8px;
  }
  .tax-input-wrap input {
    width: 70px; text-align: right; padding-right: 28px;
  }
  .tax-suffix {
    position: relative; display: inline-block;
  }
  .tax-suffix input { padding-right: 26px; }
  .tax-suffix::after {
    content: '%'; position: absolute; right: 10px; top: 50%;
    transform: translateY(-50%); font-size: 0.8rem; color: var(--muted);
    pointer-events: none;
  }

  /* ─── STATUS BADGE ────────────────────────────────────── */
  .status-wrap { padding: 16px 0 0; }
  .status-options { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
  .status-opt {
    display: flex; align-items: center; gap: 7px;
    padding: 8px 14px; border-radius: var(--radius-sm);
    border: 1.5px solid var(--border); cursor: pointer;
    font-size: 0.8rem; font-weight: 600; transition: all .15s;
    background: transparent; color: var(--muted);
  }
  .status-opt input[type=radio] { display: none; }
  .status-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: currentColor; flex-shrink: 0;
  }
  .status-opt.draft { --c: var(--muted); }
  .status-opt.sent { --c: #3b82f6; }
  .status-opt.paid { --c: var(--teal); }
  .status-opt.overdue { --c: var(--red-soft); }
  .status-opt.selected.draft { border-color: var(--muted); color: var(--muted); background: rgba(107,114,128,0.08); }
  .status-opt.selected.sent { border-color: #3b82f6; color: #3b82f6; background: rgba(59,130,246,0.08); }
  .status-opt.selected.paid { border-color: var(--teal); color: var(--teal); background: var(--teal-pale); }
  .status-opt.selected.overdue { border-color: var(--red-soft); color: var(--red-soft); background: var(--red-pale); }

  /* ─── ACTION AREA ─────────────────────────────────────── */
  .action-card .card-body {
    display: flex; flex-direction: column; gap: 10px; padding: 20px;
  }
  .action-card .btn { width: 100%; justify-content: center; padding: 11px 18px; }

  /* ─── NOTES ───────────────────────────────────────────── */
  .char-count {
    font-size: 0.72rem; color: var(--muted); text-align: right; margin-top: 4px;
  }

  /* ─── INVOICE SEARCH BAR ─────────────────────────────── */
  .inv-search-wrap {
    position: relative;
    display: flex; align-items: center; gap: 0;
    background: var(--card); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); overflow: visible;
    transition: border-color .2s, box-shadow .2s;
    min-width: 420px; flex: 1;
  }
  .topbar-btn-group {
    display: flex; align-items: center; gap: 10px;
    width: calc(320px + 24px);
    justify-content: flex-end;
    flex-shrink: 0;
  }
  .topbar-btn-group .btn-ghost {
    padding-left: 9px;
    padding-right: 27px;
  }
  .inv-search-wrap:focus-within {
    border-color: var(--teal);
    box-shadow: 0 0 0 3px rgba(0,184,153,0.12);
  }
  .inv-search-icon {
    padding: 0 12px 0 14px; color: var(--muted); font-size: 0.9rem; flex-shrink: 0;
  }
  .inv-search-input {
    border: none !important; background: transparent !important;
    outline: none; font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem; color: var(--ink); padding: 9px 0;
    flex: 1; min-width: 0;
    box-shadow: none !important;
  }
  .inv-search-input::placeholder { color: var(--muted); }
  .inv-search-kbd {
    padding: 0 12px; font-size: 0.65rem; color: var(--muted);
    font-family: 'DM Sans', sans-serif; flex-shrink: 0;
  }
  .inv-search-kbd kbd {
    background: var(--cream); border: 1px solid var(--border);
    border-radius: 4px; padding: 2px 5px; font-family: inherit;
  }

  /* ─── SEARCH RESULTS OVERLAY ──────────────────────────── */
  .search-overlay {
    display: none;
    position: fixed; inset: 0; z-index: 200;
    background: rgba(13,13,13,0.45); backdrop-filter: blur(4px);
    align-items: flex-start; justify-content: center;
    padding-top: 80px;
  }
  .search-overlay.open { display: flex; }
  .search-modal {
    background: var(--card);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-lg);
    width: 720px; max-width: calc(100vw - 40px);
    max-height: calc(100vh - 140px);
    display: flex; flex-direction: column;
    overflow: hidden;
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
  .search-modal-icon { color: var(--muted); font-size: 1rem; flex-shrink: 0; }
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
    transition: all .15s; flex-shrink: 0;
  }
  .search-modal-close:hover { background: var(--paper); color: var(--ink); }
  .search-filters {
    display: flex; gap: 8px; padding: 12px 20px;
    border-bottom: 1px solid var(--border); flex-shrink: 0; flex-wrap: wrap;
  }
  .filter-chip {
    display: flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 99px;
    border: 1.5px solid var(--border);
    background: transparent; cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem; font-weight: 600; color: var(--muted);
    transition: all .15s;
  }
  .filter-chip:hover { border-color: var(--teal); color: var(--teal); }
  .filter-chip.active { border-color: var(--teal); color: var(--teal); background: var(--teal-pale); }
  .search-results-body {
    overflow-y: auto; flex: 1;
    scrollbar-width: thin; scrollbar-color: var(--border) transparent;
  }
  .search-results-body::-webkit-scrollbar { width: 5px; }
  .search-results-body::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
  .search-group-label {
    padding: 12px 20px 6px;
    font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: var(--muted);
    position: sticky; top: 0; background: var(--card);
    border-bottom: 1px solid var(--border);
  }
  .search-result-row {
    display: grid; grid-template-columns: 40px 1fr 120px 110px 110px;
    gap: 12px; align-items: center;
    padding: 13px 20px; cursor: pointer;
    transition: background .12s; border-bottom: 1px solid rgba(0,0,0,0.04);
  }
  .search-result-row:hover { background: var(--paper); }
  .search-result-row:last-child { border-bottom: none; }
  .result-icon {
    width: 36px; height: 36px; border-radius: 8px;
    background: var(--teal-pale); display: flex; align-items: center;
    justify-content: center; font-size: 0.85rem; flex-shrink: 0;
  }
  .result-main { min-width: 0; }
  .result-inv-num {
    font-family: 'Syne', sans-serif; font-weight: 700;
    font-size: 0.82rem; color: var(--slate);
  }
  .result-client { font-size: 0.78rem; color: var(--muted); margin-top: 1px; }
  .result-ref { font-size: 0.75rem; color: var(--muted); margin-top: 1px; }
  .result-highlight { color: var(--teal); font-weight: 600; }
  .result-amount {
    font-family: 'Syne', sans-serif; font-weight: 700;
    font-size: 0.9rem; color: var(--ink); text-align: right;
  }
  .result-date { font-size: 0.75rem; color: var(--muted); text-align: right; }
  .result-status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 9px; border-radius: 99px;
    font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.04em; justify-content: center;
  }
  .badge-draft { background: rgba(107,114,128,0.1); color: var(--muted); }
  .badge-sent  { background: rgba(59,130,246,0.1); color: #3b82f6; }
  .badge-paid  { background: var(--teal-pale); color: var(--teal-dark); }
  .badge-overdue { background: var(--red-pale); color: var(--red-soft); }
  .search-empty {
    display: flex; flex-direction: column; align-items: center;
    padding: 48px 20px; gap: 10px; color: var(--muted);
  }
  .search-empty-icon { font-size: 2rem; opacity: 0.4; }
  .search-empty-text { font-size: 0.875rem; }
  .search-empty-sub { font-size: 0.78rem; opacity: 0.7; }
  .search-footer {
    padding: 10px 20px; border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0; background: var(--paper);
  }
  .search-footer-tip {
    font-size: 0.72rem; color: var(--muted);
    display: flex; align-items: center; gap: 6px;
  }
  .search-footer-tip kbd {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 4px; padding: 1px 5px; font-size: 0.65rem;
    font-family: 'DM Sans', sans-serif;
  }
  .search-count { font-size: 0.72rem; color: var(--muted); }
  /* ─── RECURRING FIELDS ────────────────────────────────── */
  #recurringFields {
    animation: itemIn .2s ease;
  }
  .recurring-divider {
    display: flex; align-items: center; gap: 10px;
    margin: 16px 0 14px;
    font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--teal);
  }
  .recurring-divider::before,
  .recurring-divider::after {
    content: ''; flex: 1; height: 1.5px;
    background: linear-gradient(to right, var(--teal-pale), var(--border));
  }
  .recurring-divider::before {
    background: linear-gradient(to left, var(--teal-pale), var(--border));
  }
  .req-star { color: var(--red-soft); font-size: 0.8rem; }

  /* ─── INVOICE STATUS BADGE ────────────────────────────── */
  .inv-status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; border-radius: 99px;
    font-family: 'Syne', sans-serif;
    font-size: 0.72rem; font-weight: 700;
    letter-spacing: 0.06em; text-transform: uppercase;
    transition: background .2s, color .2s;
  }
  .inv-status-badge::before {
    content: ''; width: 6px; height: 6px;
    border-radius: 50%; background: currentColor; flex-shrink: 0;
  }
  .status-new     { background: rgba(107,114,128,0.1); color: var(--muted); }
  .status-ready   { background: var(--teal-pale);      color: var(--teal-dark); }
  .status-sent    { background: rgba(59,130,246,0.1);  color: #2563eb; }
  .status-deleted { background: var(--red-pale);       color: var(--red-soft); }

  /* ─── TABS ────────────────────────────────────────────── */
  .tab-card { overflow: visible; }
  .tab-bar {
    display: flex; gap: 0;
    border-bottom: 1.5px solid var(--border);
    padding: 0 20px;
    background: var(--paper);
    border-radius: var(--radius) var(--radius) 0 0;
  }
  .tab-btn {
    font-family: 'Syne', sans-serif;
    font-size: 0.9rem; font-weight: 700; letter-spacing: -0.01em;
    color: var(--muted); background: transparent; border: none;
    padding: 13px 18px; cursor: pointer;
    position: relative; transition: color .15s;
    border-bottom: 2.5px solid transparent;
    margin-bottom: -1.5px;
  }
  .tab-btn:hover { color: var(--slate); }
  .tab-btn.active {
    color: var(--teal);
    border-bottom-color: var(--teal);
    background: transparent;
  }
  .tab-pane {
    display: none;
    padding: 20px;
    animation: itemIn .15s ease;
  }
  .tab-pane.active { display: block; }
  .tab-pane textarea { min-height: 96px; }

  /* ─── PAYMENTS GRID ───────────────────────────────────── */
  .pay-grid-header,
  .pay-row {
    display: grid;
    grid-template-columns: 130px 1fr 120px 120px 1fr 110px 36px;
    gap: 8px; align-items: center;
    padding: 8px 16px;
  }
  .pay-grid-header {
    background: var(--paper);
    border-bottom: 1.5px solid var(--border);
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--muted);
    padding-top: 10px; padding-bottom: 10px;
  }
  .pay-row {
    border-bottom: 1px solid rgba(0,0,0,0.04);
    animation: itemIn .18s ease;
  }
  .pay-row:last-child { border-bottom: none; }
  .pay-row input, .pay-row select {
    padding: 7px 10px; font-size: 0.8rem; border-radius: 7px;
  }
  .pay-row .amt-input { text-align: right; }
  .pay-status-sel {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath fill='%236b7280' d='M5 6L0 0h10z'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 8px center;
    padding-right: 24px !important; cursor: pointer; font-weight: 700;
    font-size: 0.75rem !important; letter-spacing: 0.02em;
  }
  .pay-status-sel.receivable { background-color: var(--amber-pale); color: #b97a0a; border-color: #f5c76a; }
  .pay-status-sel.paid       { background-color: var(--teal-pale);  color: var(--teal-dark); border-color: #7dd9c8; }
  .pay-status-sel.overdue    { background-color: var(--red-pale);   color: var(--red-soft);  border-color: #f7aaaa; }
  .pay-empty-state {
    padding: 22px 20px; color: var(--muted); font-size: 0.82rem;
    display: flex; align-items: center; gap: 8px;
  }
  .pay-add-inline {
    background: none; border: none; color: var(--teal);
    font-size: 0.82rem; font-weight: 600; cursor: pointer;
    font-family: 'DM Sans', sans-serif; padding: 0;
  }
  .pay-add-inline:hover { text-decoration: underline; }
  .pay-del-btn {
    width: 28px; height: 28px; border-radius: 6px;
    border: 1.5px solid var(--border); background: transparent;
    cursor: pointer; color: var(--muted);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; transition: all .15s;
  }
  .pay-del-btn:hover { background: var(--red-pale); border-color: var(--red-soft); color: var(--red-soft); }


  .invoice-number-wrap .prefix {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    font-size: 0.875rem; font-weight: 600; color: var(--muted);
    pointer-events: none;
  }
  .invoice-number-wrap input { padding-left: 54px; }


<body class="dashboard-page">

<!-- Overlay (mobile) -->
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- ─── SIDEBAR ──────────────────────────────────────────── -->

@include('subscriber.includes.sidebar')

<!-- ─── SHELL ─────────────────────────────────────────────── -->
<div class="shell">

  <!-- TOPBAR -->
  <header class="topbar">
    <div class="topbar-left">
      <button class="sidebar-toggle-btn" type="button" onclick="toggleDashboardSidebar()" aria-label="Toggle sidebar" aria-expanded="true">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="breadcrumb">
        <a href="{{ route('subscriber.quotes') }}">Quotes</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">{{ isset($quote) ? ('QUO-' . $quote->quote_number) : 'New Quote' }}</span>
      </div>
    </div>
    <div class="topbar-actions">
      <div class="inv-search-wrap" onclick="openSearch()">
        <span class="inv-search-icon">🔍</span>
        <input class="inv-search-input" placeholder="Search quotes, clients, references…" readonly>
        <span class="inv-search-kbd"><kbd>⌘K</kbd></span>
      </div>
      <div class="topbar-btn-group">
        <button class="btn btn-ghost" onclick="discardInvoice()">Discard</button>
        <button class="btn btn-primary" onclick="saveQuote()">Save</button>
      </div>
    </div>
  </header>

  <!-- MAIN -->
  <main class="main">

    <!-- LEFT COLUMN -->
    <div style="display:flex;flex-direction:column;gap:20px;">

      <!-- Quote Meta -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Quote Details</span>
          <div style="display:flex;align-items:center;gap:8px;">
            <span style="font-size:0.72rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:var(--muted);">Status</span>
            <span class="inv-status-badge {{ isset($quote) ? ('status-' . $quote->status) : 'status-new' }}" id="invStatusBadge">{{ isset($quote) ? ucfirst($quote->status) : 'New' }}</span>
          </div>
        </div>
        <div class="card-body">
          <div class="form-row" style="grid-template-columns: calc(50% - 8px) 1fr 1fr;">
            <div class="form-group">
              <label>Quote Number</label>
              <div class="invoice-number-wrap">
                <span class="prefix" id="invPrefix">{{ $quote->prefix ?? 'QUO-' }}</span>
                <input type="text" value="{{ $quote->quote_number ?? ($nextQuoteNumber ?? 'NEW') }}" id="invNum" readonly
                  style="font-weight:700;color:var(--muted);letter-spacing:0.05em;cursor:default;">
              </div>
              <div style="font-size:0.7rem;color:var(--muted);margin-top:4px;" id="invNumHint">
                {{ isset($quote) ? 'Quote ' . $quote->full_quote_number : 'Number assigned on save' }}
              </div>
            </div>
            <div class="form-group">
              <label>Type</label>
              <select id="invType" onchange="handleTypeChange(this.value)">
                <option value="REG" selected>Regular Proposal</option>
                <option value="EST">Estimate</option>
                <option value="SOW">Scope of Work</option>
              </select>
            </div>
            <div class="form-group">
              <label>Currency</label>
              <select id="currency">
                <option {{ (isset($quote) && $quote->currency === 'USD') ? 'selected' : '' }}>USD</option>
                <option {{ (isset($quote) && $quote->currency === 'EUR') ? 'selected' : '' }}>EUR</option>
                <option {{ (isset($quote) && $quote->currency === 'GBP') ? 'selected' : '' }}>GBP</option>
                <option {{ (isset($quote) && $quote->currency === 'CAD') ? 'selected' : '' }}>CAD</option>
                <option {{ (isset($quote) && $quote->currency === 'AUD') ? 'selected' : '' }}>AUD</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Quote Date</label>
              <input type="date" id="issueDate" value="{{ isset($quote) && $quote->issue_date ? \Carbon\Carbon::parse($quote->issue_date)->format('Y-m-d') : date('Y-m-d') }}">
            </div>
            <div class="form-group">
              <label>Valid Until (Expiry Date)</label>
              <input type="date" id="dueDate" value="{{ isset($quote) && $quote->expiry_date ? \Carbon\Carbon::parse($quote->expiry_date)->format('Y-m-d') : date('Y-m-d', strtotime('+30 days')) }}">
            </div>
          </div>

          <!-- Recurring / Schedule Fields — hidden unless Type = Recurring -->
          <div id="recurringFields" style="display:none;">
            <div class="recurring-divider">
              <span>Proposal Schedule</span>
            </div>
            <div class="form-row cols-3">
              <div class="form-group">
                <label>Frequency <span class="req-star">*</span></label>
                <select id="recFrequency">
                  <option value="">— Select —</option>
                  <option value="weekly">Weekly</option>
                  <option value="biweekly">Bi-Weekly</option>
                  <option value="monthly">Monthly</option>
                  <option value="quarterly">Quarterly</option>
                  <option value="annual">Annual</option>
                </select>
              </div>
              <div class="form-group">
                <label>Start Date <span class="req-star">*</span></label>
                <input type="date" id="recStartDate">
              </div>
              <div class="form-group">
                <label>End Date</label>
                <input type="date" id="recEndDate" placeholder="Optional">
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Client -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Bill To</span>
          <button class="btn btn-ghost" style="padding:6px 12px;font-size:0.75rem;" onclick="newClient()">+ New Client</button>
        </div>
        <div class="card-body">
          <div class="form-group" style="position:relative;">
            <label>Client</label>
            <div class="client-select-wrap">
              <span class="client-icon">🔍</span>
              <input type="text" placeholder="Search clients…" id="clientSearch" value="{{ $quote->client_name ?? request('client', '') }}" autocomplete="off" oninput="filterClients(this.value)" onfocus="showDropdown()" onblur="hideDropdown()">
            </div>
            <div class="client-dropdown" id="clientDropdown" style="display:none;">
              @forelse($customers as $c)
                <div class="client-option" onmousedown="selectClient('{{ addslashes($c->name) }}', '{{ addslashes($c->email ?? '') }}', '{{ $c->initials }}', '{{ addslashes($c->contact_name ?? '') }}', '{{ addslashes($c->billing_address ?? '') }}')">
                  <div class="client-avatar-sm" style="background:{{ $c->color ?: 'linear-gradient(135deg,#00b899,#009e82)' }};">{{ $c->initials }}</div>
                  <div class="client-meta">
                    <div class="client-name">{{ $c->name }}</div>
                    <div class="client-email">{{ $c->email ?? '' }}</div>
                  </div>
                </div>
              @empty
                <div style="padding:12px 16px;font-size:0.8rem;color:var(--muted);">No clients found. Type to add a new client.</div>
              @endforelse
            </div>
          </div>
          <div id="clientDetails" style="{{ (isset($quote) && !empty($quote->client_name)) || request('client') ? 'display:block;' : 'display:none;' }}margin-top:14px;">
            <div class="form-row">
              <div class="form-group">
                <label>Contact Name</label>
                <input type="text" id="contactName" placeholder="Full name" value="{{ $quote->contact_name ?? '' }}">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" id="contactEmail" placeholder="email@company.com" value="{{ $quote->client_email ?? '' }}">
              </div>
            </div>
            <div class="form-row full">
              <div class="form-group">
                <label>Billing Address</label>
                <input type="text" id="billingAddress" placeholder="Street address, city, state, zip" value="{{ $quote->billing_address ?? '' }}">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- References -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">References</span>
        </div>
        <div class="card-body">
          <div class="form-row cols-3">
            <div class="form-group">
              <label>PO Number</label>
              <input type="text" id="poNumber" placeholder="e.g. PO-2024-001" value="{{ $quote->po_number ?? '' }}">
            </div>
            <div class="form-group">
              <label>Project ID</label>
              <input type="text" id="projectId" placeholder="e.g. PROJ-042" value="{{ $quote->project_id ?? '' }}">
            </div>
            <div class="form-group">
              <label>Reference Code</label>
              <input type="text" id="quoteId" placeholder="e.g. REF-0018" value="{{ $quote->po_number ?? '' }}">
            </div>
          </div>
        </div>
      </div>

      <!-- Line Items -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Line Items</span>
        </div>
        <div class="card-body">
          <div class="line-items-header">
            <div>Description</div>
            <div>Reference</div>
            <div style="text-align:center;">Qty</div>
            <div style="text-align:right;">Unit Price</div>
            <div style="text-align:right;">Amount</div>
            <div></div>
          </div>
          <div id="lineItems">
            <!-- populated by JS -->
          </div>
          <button class="add-line-btn" onclick="addLineItem()">
            <span>＋</span> Add Line Item
          </button>
        </div>
      </div>

      <!-- Notes / Terms / Payment Tabs -->
      <div class="card tab-card">
        <div class="tab-bar">
          <button class="tab-btn active" onclick="switchTab(this,'tab-notes')">Notes</button>
          <button class="tab-btn" onclick="switchTab(this,'tab-terms')">Terms</button>
          <button class="tab-btn" onclick="switchTab(this,'tab-payment')">Estimated Schedule</button>
        </div>
        <div class="tab-pane active" id="tab-notes">
          <div class="form-group">
            <textarea id="notes" placeholder="Any additional information for your client…" oninput="countChars(this,'notesCount',300)">{{ $quote->notes ?? 'Thank you for considering our proposal. This quote is valid for 30 days.' }}</textarea>
            <div class="char-count"><span id="notesCount">0</span>/300</div>
          </div>
        </div>
        <div class="tab-pane" id="tab-terms">
          <div class="form-group">
            <textarea id="termsText" placeholder="e.g. 50% upfront payment upon acceptance. Final delivery within estimated timeline." oninput="countChars(this,'termsCount',300)">{{ $quote->terms ?? '50% upfront payment upon acceptance. Final delivery within estimated timeline.' }}</textarea>
            <div class="char-count"><span id="termsCount">0</span>/300</div>
          </div>
        </div>
        <div class="tab-pane" id="tab-payment" style="padding:0;">
          <div class="pay-grid-header">
            <div>Status</div>
            <div>Reference</div>
            <div>Date</div>
            <div>Valid Date</div>
            <div>Milestone</div>
            <div style="text-align:right;">Amount</div>
            <div></div>
          </div>
          <div id="paymentRows">
            <div class="pay-empty-state">
              <span>💳</span> No milestones recorded — <button class="pay-add-inline" onclick="addPayRow()">+ Add milestone</button>
            </div>
          </div>
          <div style="padding:12px 20px;border-top:1px solid var(--border);">
            <button class="add-line-btn" onclick="addPayRow()"><span>＋</span> Add Milestone / Deposit</button>
          </div>
        </div>
      </div>

    </div>
    <div class="side-panel" id="rightPanel">

      <!-- Summary -->
      <div class="card">
        <div class="card-header">
          <span class="card-title">Summary</span>
        </div>
        <div class="card-body" style="padding:20px;">
          <div class="summary-rows">
            <div class="summary-row">
              <span class="label">Subtotal</span>
              <span class="value" id="subtotal">$0.00</span>
            </div>
            <div class="summary-row" style="align-items:flex-start;gap:12px;">
              <span class="label" style="padding-top:2px;">Tax</span>
              <div style="display:flex;align-items:center;gap:6px;">
                <div class="tax-suffix">
                  <input type="number" id="taxRate" value="0" min="0" max="100" step="0.5" style="width:70px;text-align:right;padding-right:26px;" oninput="recalc()">
                </div>
                <span class="value" id="taxAmount">$0.00</span>
              </div>
            </div>
            <div class="summary-row">
              <span class="label">Shipping</span>
              <div style="display:flex;align-items:center;gap:6px;">
                <span style="font-size:0.8rem;color:var(--muted);margin-right:2px;">$</span>
                <input type="number" id="shippingAmt" value="0" min="0" step="0.01" style="width:80px;text-align:right;" oninput="recalc()">
              </div>
            </div>
            <div class="summary-row">
              <span class="label">Handling</span>
              <div style="display:flex;align-items:center;gap:6px;">
                <span style="font-size:0.8rem;color:var(--muted);margin-right:2px;">$</span>
                <input type="number" id="handlingAmt" value="0" min="0" step="0.01" style="width:80px;text-align:right;" oninput="recalc()">
              </div>
            </div>
            <div class="summary-row">
              <span class="label">Discount</span>
              <div style="display:flex;align-items:center;gap:6px;">
                <div class="tax-suffix">
                  <input type="number" id="discountRate" value="0" min="0" max="100" step="0.5" style="width:70px;text-align:right;padding-right:26px;" oninput="recalc()">
                </div>
                <span class="value" id="discountAmount" style="color:var(--red-soft);">-$0.00</span>
              </div>
            </div>
            <div class="summary-row total">
              <span class="label">Total Quoted</span>
              <span class="value" id="total">$0.00</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="card action-card">
        <div class="card-body">
          <button class="btn btn-primary" onclick="saveQuote()">Save</button>
          @if(isset($quote))
            <button class="btn btn-amber" onclick="convertQuoteToInvoice({{ $quote->id }})"><span>⚡</span> Convert to Invoice</button>
          @endif
          <button class="btn btn-ghost" onclick="previewInvoice()">
            <span>👁</span> Preview PDF
          </button>
          <button class="btn btn-ghost" onclick="discardInvoice()" style="color:var(--red-soft);border-color:var(--red-soft);background:transparent;" onmouseover="this.style.background='var(--red-pale)'" onmouseout="this.style.background='transparent'">
            Discard
          </button>
        </div>
      </div>

    </div>
  </main>
</div>

<!-- ─── SEARCH OVERLAY ───────────────────────────────────── -->
<div class="search-overlay" id="searchOverlay" onclick="handleOverlayClick(event)">
  <div class="search-modal" id="searchModal">
    <div class="search-modal-header">
      <span class="search-modal-icon">🔍</span>
      <input class="search-modal-input" id="searchModalInput"
        placeholder="Quote ID, client name, PO number, project ID, quote reference…"
        oninput="runSearch(this.value)" autocomplete="off">
      <button class="search-modal-close" onclick="closeSearch()" title="Close (Esc)">✕</button>
    </div>
    <div class="search-filters">
      <button class="filter-chip active" data-filter="all" onclick="setFilter(this,'all')">All</button>
      <button class="filter-chip" data-filter="invoice" onclick="setFilter(this,'invoice')">Quote ID</button>
      <button class="filter-chip" data-filter="client" onclick="setFilter(this,'client')">Client</button>
      <button class="filter-chip" data-filter="po" onclick="setFilter(this,'po')">PO Number</button>
      <button class="filter-chip" data-filter="project" onclick="setFilter(this,'project')">Project ID</button>
    </div>
    <div class="search-results-body" id="searchResultsBody">
      <div class="search-empty">
        <div class="search-empty-icon">📄</div>
        <div class="search-empty-text">Start typing to search quotes</div>
        <div class="search-empty-sub">Search by quote ID, client, PO, or project reference</div>
      </div>
    </div>
    <div class="search-footer">
      <div class="search-footer-tip">
        <kbd>↑↓</kbd> navigate &nbsp;·&nbsp; <kbd>↵</kbd> open &nbsp;·&nbsp; <kbd>Esc</kbd> close
      </div>
      <span class="search-count" id="searchCount"></span>
    </div>
  </div>
</div>

<script>
  function handleTypeChange(val) {
    const recurring = document.getElementById('recurringFields');
    if (val === 'REC' || val === 'EST') {
      recurring.style.display = 'block';
      const sd = document.getElementById('recStartDate');
      if (!sd.value) sd.value = document.getElementById('issueDate').value;
    } else {
      recurring.style.display = 'none';
    }
  }

  // ── DATES ───────────────────────────────────────────────
  const today = new Date();
  const fmt = d => d.toISOString().split('T')[0];
  const due = new Date(today); due.setDate(due.getDate() + 30);
  @if(!isset($quote))
    if (!document.getElementById('issueDate').value) document.getElementById('issueDate').value = fmt(today);
    if (!document.getElementById('dueDate').value) document.getElementById('dueDate').value = fmt(due);
  @endif

  // ── LINE ITEMS ──────────────────────────────────────────
  let items = [];
  let nextId = 0;

  function addLineItem(desc='', ref='', qty=1, price=0) {
    const id = nextId++;
    items.push({ id, desc, ref, qty: parseFloat(qty) || 1, price: parseFloat(price) || 0 });
    renderItems();
  }

  function removeItem(id) {
    items = items.filter(i => i.id !== id);
    if (!items.length) {
      addLineItem('', '', 1, 0);
    } else {
      renderItems();
    }
  }

  function updateItem(id, field, val) {
    const item = items.find(i => i.id === id);
    if (!item) return;
    item[field] = (field === 'desc' || field === 'ref') ? val : (parseFloat(val) || 0);
    recalc();
  }

  function renderItems() {
    const container = document.getElementById('lineItems');
    container.innerHTML = '';
    items.forEach(item => {
      const div = document.createElement('div');
      div.className = 'line-item';
      div.id = `item-${item.id}`;
      div.innerHTML = `
        <input type="text" placeholder="Service or deliverable description" value="${escapeHtml(item.desc)}"
          oninput="updateItem(${item.id},'desc',this.value)">
        <input type="text" placeholder="Ref / SKU" value="${escapeHtml(item.ref)}"
          oninput="updateItem(${item.id},'ref',this.value)">
        <input type="number" value="${item.qty}" min="0" step="1" style="text-align:center;"
          oninput="updateItem(${item.id},'qty',this.value)">
        <input type="number" value="${item.price}" min="0" step="0.01" style="text-align:right;"
          oninput="updateItem(${item.id},'price',this.value)">
        <div class="amount-display" id="amt-${item.id}">$0.00</div>
        <button class="delete-btn" onclick="removeItem(${item.id})" title="Remove">✕</button>
      `;
      container.appendChild(div);
    });
    recalc();
  }

  function escapeHtml(str) {
    return (str || '').toString().replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#039;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  }

  function recalc() {
    let subtotal = 0;
    items.forEach(item => {
      const amt = (parseFloat(item.qty) || 0) * (parseFloat(item.price) || 0);
      subtotal += amt;
      const el = document.getElementById(`amt-${item.id}`);
      if (el) el.textContent = fmt$(amt);
    });
    const taxRate = parseFloat(document.getElementById('taxRate').value) || 0;
    const discRate = parseFloat(document.getElementById('discountRate').value) || 0;
    const shipping = parseFloat(document.getElementById('shippingAmt').value) || 0;
    const handling = parseFloat(document.getElementById('handlingAmt').value) || 0;
    const taxAmt = subtotal * taxRate / 100;
    const discAmt = subtotal * discRate / 100;
    const total = subtotal + taxAmt - discAmt + shipping + handling;

    document.getElementById('subtotal').textContent = fmt$(subtotal);
    document.getElementById('taxAmount').textContent = fmt$(taxAmt);
    document.getElementById('discountAmount').textContent = `-${fmt$(discAmt)}`;
    document.getElementById('total').textContent = fmt$(total);
  }

  function fmt$(n) {
    return '$' + (parseFloat(n) || 0).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  }

  // Populate items from server or seed
  @if(isset($quote) && $quote->items && $quote->items->count())
    @foreach($quote->items as $it)
      items.push({
        id: nextId++,
        desc: {!! json_encode($it->description) !!},
        ref: {!! json_encode($it->reference ?? '') !!},
        qty: {{ (float) $it->quantity }},
        price: {{ (float) $it->unit_price }}
      });
    @endforeach
    renderItems();
  @else
    addLineItem('', '', 1, 0);
  @endif

  // Set existing edit fields if present
  @if(isset($quote))
    document.getElementById('taxRate').value = {{ (float) $quote->tax_rate }};
    document.getElementById('discountRate').value = {{ (float) $quote->discount_rate }};
    document.getElementById('shippingAmt').value = {{ (float) $quote->shipping_amount }};
    document.getElementById('handlingAmt').value = {{ (float) $quote->handling_amount }};
    recalc();
  @endif

  // ── CLIENT DROPDOWN ─────────────────────────────────────
  function showDropdown() {
    document.getElementById('clientDropdown').style.display = 'block';
  }
  function hideDropdown() {
    setTimeout(() => { document.getElementById('clientDropdown').style.display = 'none'; }, 200);
  }
  function filterClients(val) {
    const opts = document.querySelectorAll('.client-option');
    opts.forEach(opt => {
      const name = opt.querySelector('.client-name').textContent.toLowerCase();
      opt.style.display = name.includes(val.toLowerCase()) ? 'flex' : 'none';
    });
  }
  function selectClient(name, email, initials, contactName='', billingAddress='') {
    document.getElementById('clientSearch').value = name;
    document.getElementById('clientDetails').style.display = 'block';
    document.getElementById('contactEmail').value = email || '';
    document.getElementById('contactName').value = contactName || '';
    const addr = document.getElementById('billingAddress');
    if (addr) addr.value = billingAddress || '';
  }
  function newClient() {
    document.getElementById('clientSearch').value = '';
    document.getElementById('clientDetails').style.display = 'block';
    document.getElementById('contactName').value = '';
    document.getElementById('contactEmail').value = '';
    const addr = document.getElementById('billingAddress');
    if (addr) addr.value = '';
    document.getElementById('clientSearch').focus();
  }

  // ── URL Params Auto-select ──────────────────────────────
  window.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const clientParam = params.get('client');
    if (clientParam) {
      document.getElementById('clientSearch').value = clientParam;
      document.getElementById('clientDetails').style.display = 'block';
      const allCustomers = @json($customers ?? []);
      const found = allCustomers.find(c => c.name.toLowerCase() === clientParam.toLowerCase());
      if (found) {
        selectClient(found.name, found.email || '', found.initials || '', found.contact_name || '', found.billing_address || '');
      }
    }
  });

  // ── STATUS ──────────────────────────────────────────────
  function setStatus(val) {
    ['draft','sent','paid','overdue'].forEach(s => {
      const el = document.getElementById(`s-${s}`);
      if (el) el.classList.toggle('selected', s === val);
    });
  }

  function goToCreateView(e) {
    e.preventDefault();
    const panel = document.getElementById('rightPanel');
    if (!panel) return;
    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    panel.classList.remove('panel-highlight');
    void panel.offsetWidth;
    panel.classList.add('panel-highlight');
    setTimeout(() => panel.classList.remove('panel-highlight'), 950);
  }

  // ── SEARCH DATA ─────────────────────────────────────────
  const invoiceData = @json($allQuotes ?? []);

  let activeFilter = 'all';
  let selectedIndex = -1;

  function openSearch() {
    document.getElementById('searchOverlay').classList.add('open');
    setTimeout(() => document.getElementById('searchModalInput').focus(), 50);
  }
  function closeSearch() {
    document.getElementById('searchOverlay').classList.remove('open');
    document.getElementById('searchModalInput').value = '';
    document.getElementById('searchResultsBody').innerHTML = `
      <div class="search-empty">
        <div class="search-empty-icon">📄</div>
        <div class="search-empty-text">Start typing to search quotes</div>
        <div class="search-empty-sub">Search by quote ID, client, PO, or project reference</div>
      </div>`;
    document.getElementById('searchCount').textContent = '';
    selectedIndex = -1;
  }
  function handleOverlayClick(e) {
    if (e.target === document.getElementById('searchOverlay')) closeSearch();
  }
  function setFilter(btn, filter) {
    document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
    activeFilter = filter;
    runSearch(document.getElementById('searchModalInput').value);
  }

  function highlight(text, query) {
    if (!query || !text) return text || '';
    const idx = text.toLowerCase().indexOf(query.toLowerCase());
    if (idx === -1) return text;
    return text.slice(0,idx) + `<span class="result-highlight">${text.slice(idx, idx+query.length)}</span>` + text.slice(idx+query.length);
  }

  function runSearch(query) {
    const body = document.getElementById('searchResultsBody');
    const q = query.trim().toLowerCase();

    if (!q) {
      body.innerHTML = `<div class="search-empty"><div class="search-empty-icon">📄</div><div class="search-empty-text">Start typing to search quotes</div><div class="search-empty-sub">Search by quote ID, client, PO, or project reference</div></div>`;
      document.getElementById('searchCount').textContent = '';
      return;
    }

    const filtered = invoiceData.filter(inv => {
      const matchesQuery = (
        (inv.inv && inv.inv.toLowerCase().includes(q)) ||
        (inv.client && inv.client.toLowerCase().includes(q)) ||
        (inv.clientId && inv.clientId.toLowerCase().includes(q)) ||
        (inv.po && inv.po.toLowerCase().includes(q)) ||
        (inv.project && inv.project.toLowerCase().includes(q)) ||
        (inv.quote && inv.quote.toLowerCase().includes(q)) ||
        (inv.status && inv.status.toLowerCase().includes(q))
      );
      if (!matchesQuery) return false;
      if (activeFilter === 'all') return true;
      if (activeFilter === 'invoice') return inv.inv.includes(q) || ('quo-'+inv.inv).includes(q);
      if (activeFilter === 'client') return inv.client.toLowerCase().includes(q) || (inv.clientId && inv.clientId.toLowerCase().includes(q));
      if (activeFilter === 'po') return inv.po.toLowerCase().includes(q);
      if (activeFilter === 'project') return inv.project.toLowerCase().includes(q);
      return true;
    });

    document.getElementById('searchCount').textContent = filtered.length ? `${filtered.length} result${filtered.length !== 1 ? 's' : ''}` : '';

    if (!filtered.length) {
      body.innerHTML = `<div class="search-empty"><div class="search-empty-icon">🔍</div><div class="search-empty-text">No quotes found for "${query}"</div><div class="search-empty-sub">Try a different search term or filter</div></div>`;
      return;
    }

    const statusBadge = s => {
      const map = { draft:'badge-draft', sent:'badge-sent', paid:'badge-paid', accepted:'badge-paid', overdue:'badge-overdue', expired:'badge-overdue' };
      return `<span class="result-status-badge ${map[s] || 'badge-draft'}">${s}</span>`;
    };

    const formatDate = d => {
      if (!d) return '';
      const [y,m,day] = d.split('-');
      return new Date(y,m-1,day).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
    };

    const groups = { accepted: [], sent: [], draft: [], expired: [] };
    filtered.forEach(inv => { (groups[inv.status] || groups.draft).push(inv); });
    const order = ['accepted','sent','draft','expired'];
    const labels = { accepted:'Accepted', sent:'Sent', draft:'Draft', expired:'Expired' };

    let html = '';
    order.forEach(key => {
      if (!groups[key] || !groups[key].length) return;
      html += `<div class="search-group-label">${labels[key]} · ${groups[key].length}</div>`;
      groups[key].forEach(inv => {
        const refs = [inv.po, inv.project].filter(Boolean).join(' · ');
        html += `
          <div class="search-result-row" onclick="openInvoice('${inv.inv}')">
            <div class="result-icon">📄</div>
            <div class="result-main">
              <div class="result-inv-num">${highlight('QUO-'+inv.inv, query)}</div>
              <div class="result-client">${highlight(inv.client, query)}</div>
              ${refs ? `<div class="result-ref">${highlight(refs, query)}</div>` : ''}
            </div>
            ${statusBadge(inv.status)}
            <div>
              <div class="result-amount">${fmt$(inv.amount)}</div>
              <div class="result-date">Expires ${formatDate(inv.due)}</div>
            </div>
          </div>`;
      });
    });
    body.innerHTML = html;
    selectedIndex = -1;
  }

  function openInvoice(num) {
    closeSearch();
    window.location.href = "{{ route('subscriber.quotes') }}";
  }

  // ── KEYBOARD SHORTCUT ────────────────────────────────────
  document.addEventListener('keydown', e => {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
      e.preventDefault(); openSearch();
    }
    if (e.key === 'Escape') closeSearch();
  });

  function switchTab(btn, paneId) {
    btn.closest('.tab-card').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.closest('.tab-card').querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById(paneId).classList.add('active');
  }

  // ── PAYMENTS / MILESTONES TAB ────────────────────────────
  let payRows = [], nextPayId = 0;

  function addPayRow(status='receivable', ref='', payDate='', appDate='', source='', amount=0) {
    const id = nextPayId++;
    payRows.push({ id, status, ref, payDate, appDate, source, amount });
    renderPayRows();
  }

  function removePayRow(id) {
    payRows = payRows.filter(r => r.id !== id);
    renderPayRows();
  }

  function stylePayStatus(sel) {
    sel.className = 'pay-status-sel ' + sel.value;
  }

  function renderPayRows() {
    const container = document.getElementById('paymentRows');
    if (!payRows.length) {
      container.innerHTML = `<div class="pay-empty-state"><span>💳</span> No milestones recorded — <button class="pay-add-inline" onclick="addPayRow()">+ Add milestone</button></div>`;
      return;
    }
    const today = new Date().toISOString().split('T')[0];
    container.innerHTML = payRows.map(row => `
      <div class="pay-row" id="pr-${row.id}">
        <select class="pay-status-sel ${row.status || 'receivable'}" onchange="stylePayStatus(this)">
          <option value="receivable" ${row.status === 'receivable' ? 'selected' : ''}>Planned</option>
          <option value="paid" ${row.status === 'paid' ? 'selected' : ''}>Accepted</option>
          <option value="overdue" ${row.status === 'overdue' ? 'selected' : ''}>Pending</option>
        </select>
        <input type="text" placeholder="e.g. Deposit 50%" value="${escapeHtml(row.ref || '')}">
        <input type="date" value="${row.payDate || today}">
        <input type="date" value="${row.appDate || today}">
        <input type="text" placeholder="e.g. Milestone 1" value="${escapeHtml(row.source || '')}">
        <input type="number" class="amt-input" min="0" step="0.01" placeholder="0.00" value="${row.amount || ''}">
        <button class="pay-del-btn" onclick="removePayRow(${row.id})" title="Remove">✕</button>
      </div>
    `).join('');
  }

  function countChars(el, counterId, max) {
    const len = el.value.length;
    document.getElementById(counterId).textContent = Math.min(len, max);
    if (len > max) el.value = el.value.slice(0, max);
  }

  // ── ACTIONS ─────────────────────────────────────────────
  function saveQuote() {
    const clientName = document.getElementById('clientSearch').value.trim();
    if (!clientName) {
      alert('Please enter or select a client name.');
      document.getElementById('clientSearch').focus();
      return;
    }

    const payload = {
      client_name: clientName,
      client_email: document.getElementById('contactEmail').value.trim(),
      contact_name: document.getElementById('contactName').value.trim(),
      billing_address: document.getElementById('billingAddress') ? document.getElementById('billingAddress').value.trim() : '',
      quote_number: document.getElementById('invNum').value.trim(),
      currency: document.getElementById('currency').value,
      issue_date: document.getElementById('issueDate').value,
      expiry_date: document.getElementById('dueDate').value,
      po_number: document.getElementById('poNumber').value.trim(),
      project_id: document.getElementById('projectId').value.trim(),
      notes: document.getElementById('notes').value,
      terms: document.getElementById('termsText').value,
      tax_rate: parseFloat(document.getElementById('taxRate').value) || 0,
      discount_rate: parseFloat(document.getElementById('discountRate').value) || 0,
      shipping_amount: parseFloat(document.getElementById('shippingAmt').value) || 0,
      handling_amount: parseFloat(document.getElementById('handlingAmt').value) || 0,
      items: items.map(i => ({
        description: i.desc,
        reference: i.ref,
        quantity: i.qty,
        unit_price: i.price
      }))
    };

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const isEdit = {{ isset($quote) ? 'true' : 'false' }};
    const url = isEdit ? "{{ isset($quote) ? route('subscriber.quotes.update', $quote->id) : '' }}" : "{{ route('subscriber.quotes.store') }}";
    const method = isEdit ? 'PUT' : 'POST';

    fetch(url, {
      method: method,
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(payload)
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        const invNum = data.quote_number || (data.quote ? data.quote.quote_number : '0019');
        const invInput = document.getElementById('invNum');
        const hint = document.getElementById('invNumHint');

        invInput.value = invNum;
        invInput.style.color = 'var(--ink)';
        invInput.style.fontWeight = '700';
        invInput.style.cursor = 'default';
        hint.innerHTML = `<span style="color:var(--teal);font-weight:600;">✓ Quote saved</span>`;

        const badge = document.getElementById('invStatusBadge');
        badge.textContent = 'Draft';
        badge.className = 'inv-status-badge status-ready';

        document.querySelector('.breadcrumb-current').textContent = 'QUO-' + invNum;

        // Swap topbar buttons to post-save state
        document.querySelector('.topbar-actions').innerHTML = `
          <div class="inv-search-wrap" onclick="openSearch()">
            <span class="inv-search-icon">🔍</span>
            <input class="inv-search-input" placeholder="Search quotes, clients, references…" readonly>
            <span class="inv-search-kbd"><kbd>⌘K</kbd></span>
          </div>
          <div class="topbar-btn-group">
            <button class="btn btn-ghost" onclick="discardInvoice()">Close</button>
            <button class="btn btn-outline" onclick="previewInvoice()"><span>👁</span> Preview PDF</button>
            <button class="btn btn-amber" onclick="sendInvoice()"><span>✉</span> Send Quote</button>
          </div>
        `;

        document.querySelector('.action-card .card-body').innerHTML = `
          <button class="btn btn-amber" onclick="sendInvoice()"><span>✉</span> Send Quote</button>
          <button class="btn btn-outline" onclick="previewInvoice()"><span>👁</span> Preview PDF</button>
        `;

        if (window.toast) {
          window.toast('Quote QUO-' + invNum + ' saved successfully!');
        } else {
          alert('Quote QUO-' + invNum + ' saved successfully!');
        }
      } else {
        alert(data.message || 'Error saving quote.');
      }
    })
    .catch(err => {
      console.error(err);
      alert('An error occurred while saving the quote.');
    });
  }

  function convertQuoteToInvoice(quoteId) {
    if (!confirm('Convert this Quote directly into an Invoice?')) return;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    fetch("{{ url('subscriber/quotes') }}/" + quoteId + "/convert-to-invoice", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
      }
    })
    .then(r => r.json())
    .then(data => {
      if (data.success && data.redirect_url) {
        if (window.toast) window.toast(data.message);
        setTimeout(() => window.location.href = data.redirect_url, 400);
      } else {
        alert(data.message || 'Conversion failed.');
      }
    })
    .catch(err => {
      console.error(err);
      alert('Could not convert quote.');
    });
  }

  function discardInvoice() {
    window.location.href = "{{ route('subscriber.quotes') }}";
  }

  function sendInvoice() {
    const num = document.getElementById('invNum').value;
    const badge = document.getElementById('invStatusBadge');
    badge.textContent = 'Sent';
    badge.className = 'inv-status-badge status-sent';
    alert('Quote QUO-' + num + ' sent to client!');
  }

  function previewInvoice() {
    const num = document.getElementById('invNum').value;
    alert('PDF preview for QUO-' + num);
  }

  // Sidebar toggle helpers
  window.closeSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (sidebar) sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('visible', 'open');
  };

  window.toggleDashboardSidebar = function() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (window.innerWidth <= 960) {
      if (sidebar) sidebar.classList.toggle('open');
      if (overlay) overlay.classList.toggle('open');
    } else {
      document.body.classList.toggle('dashboard-sidebar-collapsed');
    }
  };
</script>

</body>
</html>
