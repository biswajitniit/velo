<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Velo — User Management</title>
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
    --purple: #7c3aed;
    --purple-pale: #ede9fe;
    --blue: #3b82f6;
    --blue-pale: #dbeafe;
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
    transition: transform .28s cubic-bezier(.22,1,.36,1), box-shadow .28s ease;
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
  .portal-badge {
    display: inline-block;
    font-size: 0.58rem; font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase;
    background: rgba(0,184,153,0.2); color: var(--teal);
    padding: 2px 8px; border-radius: 4px; margin-top: 4px;
  }
  .sidebar-user {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 24px; border-bottom: 1px solid var(--border-dark); flex-shrink: 0;
  }
  .user-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    background: linear-gradient(135deg, var(--teal), var(--teal-dark));
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.82rem; color: #fff; flex-shrink: 0;
    border: 2px solid rgba(0,184,153,0.4);
  }
  .user-details { min-width: 0; }
  .user-name {
    font-size: 0.82rem; font-weight: 600; color: #fff;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .user-company { font-size: 0.7rem; color: rgba(255,255,255,0.45); margin-top: 1px; }
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
    font-size: 0.7rem; font-weight: 600; padding: 1px 7px;
    border-radius: 99px; background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.5);
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

  /* ─── LAYOUT SHELL ────────────────────────────────────── */
  .shell { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; transition: margin-left .28s cubic-bezier(.22,1,.36,1); }
  body.sidebar-collapsed { --sidebar-w: 0px; }
  body.sidebar-collapsed .sidebar { transform: translateX(-260px); box-shadow: none; }
  body.sidebar-collapsed .shell { margin-left: 0; }
  body.sidebar-collapsed::before { left: 0; }

  /* ─── TOP BAR ─────────────────────────────────────────── */
  .topbar {
    position: sticky; top: 0; z-index: 40; height: var(--topbar-h);
    background: rgba(245,242,235,0.92); backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 32px; gap: 16px;
  }
  .topbar-left { display: flex; align-items: center; gap: 16px; }
  .sidebar-toggle-btn {
    width: 38px; height: 38px; border: 0; border-radius: 10px;
    background: transparent; color: var(--slate); cursor: pointer;
    display: inline-flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 5px;
    transition: background .18s, color .18s; flex-shrink: 0;
  }
  .sidebar-toggle-btn:hover { background: var(--cream); color: var(--teal); }
  .sidebar-toggle-btn span {
    width: 23px; height: 2px; border-radius: 99px;
    background: currentColor; display: block;
  }
  .page-title {
    font-family: 'Syne', sans-serif; font-size: 1.15rem;
    font-weight: 700; color: var(--slate); letter-spacing: -0.02em;
  }
  .btn-pay {
    display: flex; align-items: center; gap: 7px;
    padding: 8px 18px; background: var(--teal); color: #fff;
    border: none; border-radius: 99px;
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 600;
    cursor: pointer; transition: background .2s, transform .15s, box-shadow .2s;
    white-space: nowrap;
  }
  .btn-pay:hover { background: var(--teal-dark); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(0,184,153,0.35); }
  .topbar-search {
    display: flex; align-items: center; gap: 8px;
    background: var(--card); border: 1.5px solid var(--border);
    border-radius: 99px; padding: 7px 16px; min-width: 220px; transition: border-color .2s;
  }
  .topbar-search:focus-within { border-color: var(--teal); }
  .topbar-search input {
    border: none; outline: none; background: transparent;
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem; color: var(--ink); width: 100%;
  }
  .topbar-search input::placeholder { color: var(--muted); }
  .search-icon { font-size: 0.85rem; color: var(--muted); }
  .topbar-right { display: flex; align-items: center; gap: 10px; }
  .topbar-btn {
    width: 36px; height: 36px; border-radius: 50%;
    border: 1.5px solid var(--border); background: var(--card); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.9rem; color: var(--muted); transition: border-color .2s, color .2s, background .2s;
    position: relative; text-decoration: none;
  }
  .topbar-btn:hover { border-color: var(--teal); color: var(--teal); background: var(--teal-pale); }
  .topbar-dot {
    position: absolute; top: 5px; right: 5px;
    width: 7px; height: 7px; background: var(--red-soft); border-radius: 50%;
    border: 1.5px solid var(--paper);
  }
  .shimmer-bar {
    position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: 3px; z-index: 100;
    background: linear-gradient(90deg, var(--teal) 0%, var(--amber) 50%, var(--teal) 100%);
    background-size: 200% 100%; animation: shimmer 3s linear infinite;
  }
  @keyframes shimmer { 0%{background-position:100% 0} 100%{background-position:-100% 0} }

  /* ─── MAIN CONTENT ────────────────────────────────────── */
  .main { flex: 1; padding: 32px; }

  /* ─── PAGE HEADER ─────────────────────────────────────── */
  .page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 24px; gap: 16px; flex-wrap: wrap;
  }
  .page-header-left { flex: 1; }
  .page-eyebrow {
    font-size: 0.7rem; font-weight: 600; letter-spacing: 0.12em;
    text-transform: uppercase; color: var(--teal); margin-bottom: 4px;
  }
  .page-heading {
    font-family: 'Syne', sans-serif; font-size: 1.75rem;
    font-weight: 800; color: var(--slate); letter-spacing: -0.03em; line-height: 1.15;
  }
  .page-sub { font-size: 0.875rem; color: var(--muted); margin-top: 4px; }
  .page-actions { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

  /* ─── BUTTONS ─────────────────────────────────────────── */
  .btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: 0.875rem; font-weight: 600;
    cursor: pointer; transition: all .18s; border: 1.5px solid transparent;
    text-decoration: none; white-space: nowrap;
  }
  .btn-primary {
    background: var(--teal); color: #fff; border-color: var(--teal);
    box-shadow: 0 0 0 0 rgba(0,184,153,0);
  }
  .btn-primary:hover {
    background: var(--teal-dark); border-color: var(--teal-dark);
    box-shadow: 0 4px 16px rgba(0,184,153,0.35); transform: translateY(-1px);
  }
  .btn-outline {
    background: transparent; color: var(--slate); border-color: var(--border);
  }
  .btn-outline:hover { border-color: var(--teal); color: var(--teal); background: var(--teal-pale); }
  .btn-ghost { background: transparent; color: var(--muted); border-color: transparent; padding: 9px 12px; }
  .btn-ghost:hover { color: var(--ink); background: var(--cream); }
  .btn-danger { background: var(--red-pale); color: var(--red-soft); border-color: transparent; }
  .btn-danger:hover { background: var(--red-soft); color: #fff; }
  .btn-sm { padding: 6px 12px; font-size: 0.8rem; }

  /* ─── SEAT USAGE CARDS ───────────────────────────────── */
  .seat-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px; }
  .seat-card {
    background: var(--card); border-radius: var(--radius); border: 1.5px solid var(--border);
    padding: 20px 24px; box-shadow: var(--shadow-sm);
    display: flex; flex-direction: column; gap: 12px;
  }
  .seat-card-header { display: flex; align-items: center; justify-content: space-between; }
  .seat-label {
    font-size: 0.75rem; font-weight: 600; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--muted);
  }
  .seat-badge {
    font-size: 0.7rem; font-weight: 700; padding: 3px 10px;
    border-radius: 99px; letter-spacing: 0.04em;
  }
  .badge-ok { background: var(--teal-pale); color: var(--teal-dark); }
  .badge-warn { background: var(--amber-pale); color: #b47d00; }
  .badge-over { background: var(--red-pale); color: var(--red-soft); }
  .seat-count {
    font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800;
    color: var(--slate); letter-spacing: -0.04em; line-height: 1;
  }
  .seat-count span { font-size: 1rem; font-weight: 400; color: var(--muted); margin-left: 4px; }
  .seat-bar-wrap { background: var(--cream); border-radius: 99px; height: 6px; overflow: hidden; }
  .seat-bar { height: 100%; border-radius: 99px; transition: width .6s ease; }
  .seat-bar.ok { background: linear-gradient(90deg, var(--teal), var(--teal-dark)); }
  .seat-bar.warn { background: linear-gradient(90deg, var(--amber), #e8930a); }
  .seat-bar.over { background: linear-gradient(90deg, var(--red-soft), #c93232); }
  .seat-meta { font-size: 0.775rem; color: var(--muted); }

  /* ─── FILTER BAR ─────────────────────────────────────── */
  .filter-bar {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 20px; flex-wrap: wrap;
  }
  .tab-group {
    display: flex; align-items: center;
    background: var(--card); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); padding: 3px; gap: 2px;
  }
  .tab-btn {
    padding: 7px 16px; border-radius: 8px; border: none;
    font-family: 'DM Sans', sans-serif; font-size: 0.82rem; font-weight: 500;
    cursor: pointer; transition: all .15s; color: var(--muted); background: transparent;
    display: flex; align-items: center; gap: 6px;
  }
  .tab-btn.active { background: var(--slate); color: #fff; font-weight: 600; }
  .tab-btn .count {
    background: rgba(255,255,255,0.2); color: inherit;
    font-size: 0.7rem; padding: 0 6px; border-radius: 99px;
  }
  .tab-btn:not(.active) .count { background: var(--cream); color: var(--muted); }
  .filter-spacer { flex: 1; }
  .filter-select {
    padding: 8px 14px; border-radius: var(--radius-sm); border: 1.5px solid var(--border);
    background: var(--card); font-family: 'DM Sans', sans-serif; font-size: 0.82rem;
    color: var(--ink); cursor: pointer; outline: none; transition: border-color .2s;
  }
  .filter-select:focus { border-color: var(--teal); }

  /* ─── USER TABLE ─────────────────────────────────────── */
  .table-card {
    background: var(--card); border-radius: var(--radius);
    border: 1.5px solid var(--border); box-shadow: var(--shadow-sm); overflow: hidden;
  }
  .table-wrap { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; }
  thead tr { border-bottom: 1.5px solid var(--border); }
  th {
    padding: 12px 16px; text-align: left;
    font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em;
    text-transform: uppercase; color: var(--muted); white-space: nowrap;
  }
  .uid-link {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.875rem; font-weight: 600; color: var(--ink);
    cursor: pointer; white-space: nowrap;
    text-decoration: none; border-bottom: none;
    transition: color .15s;
  }
  .uid-link:hover { color: var(--teal); }

  /* User ID field in modal */
  .uid-field-wrap { position: relative; }
  .uid-field-wrap input {
    width: 100%; padding: 9px 13px; border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); font-family: 'DM Mono','Fira Mono',monospace;
    font-size: 0.875rem; letter-spacing: 0.06em; color: var(--ink);
    background: var(--card); outline: none; transition: border-color .2s;
  }
  .uid-field-wrap input:focus { border-color: var(--teal); }
  .uid-field-wrap input:disabled {
    background: var(--cream); color: var(--muted); cursor: not-allowed;
  }
  .uid-field-wrap input.uid-error { border-color: var(--red-soft) !important; }
  .uid-error-msg {
    font-size: 0.74rem; color: var(--red-soft); margin-top: 4px; display: none;
  }
  .uid-error-msg.show { display: block; }
  .uid-autogen-row {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 11px; border-radius: var(--radius-sm);
    background: var(--cream); border: 1px solid var(--border);
    font-size: 0.78rem; color: var(--muted); margin-top: 6px;
  }
  .uid-autogen-row.locked { background: #f0f9ff; border-color: #bae6fd; color: #0369a1; }
  .uid-autogen-row input[type=checkbox] { accent-color: var(--teal); width:14px; height:14px; cursor:pointer; }
  .uid-autogen-row input[type=checkbox]:disabled { cursor: not-allowed; opacity: 0.6; }
  .uid-autogen-row a { color: var(--teal-dark); font-weight: 600; text-decoration: underline; cursor: pointer; }

  /* Sort headers */
  th.sortable {
    cursor: pointer; user-select: none; white-space: nowrap;
  }
  th.sortable:hover { color: var(--ink); }
  th.sortable .sort-arrows {
    display: inline-flex; flex-direction: column;
    gap: 1px; margin-left: 5px; vertical-align: middle; opacity: 0.3;
    transition: opacity .15s;
  }
  th.sortable:hover .sort-arrows { opacity: 0.6; }
  th.sortable .sort-arrows span {
    display: block; width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent;
  }
  th.sortable .sort-arrows .arr-up  { border-bottom: 5px solid currentColor; }
  th.sortable .sort-arrows .arr-dn  { border-top:    5px solid currentColor; }
  th.sortable.sort-asc  .sort-arrows,
  th.sortable.sort-desc .sort-arrows { opacity: 1; }
  th.sortable.sort-asc  .arr-up  { color: var(--teal); }
  th.sortable.sort-asc  .arr-dn  { color: var(--border); }
  th.sortable.sort-desc .arr-dn  { color: var(--teal); }
  th.sortable.sort-desc .arr-up  { color: var(--border); }
  tbody tr {
    border-bottom: 1px solid var(--border); transition: background .12s;
    animation: rowIn .3s ease both;
  }
  @keyframes rowIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(0,184,153,0.035); }
  td { padding: 14px 16px; font-size: 0.875rem; vertical-align: middle; }

  /* User cell */
  .user-cell { display: flex; align-items: center; gap: 12px; }
  .avatar {
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.75rem; color: #fff; flex-shrink: 0;
  }
  .av-teal { background: linear-gradient(135deg, var(--teal), var(--teal-dark)); }
  .av-amber { background: linear-gradient(135deg, var(--amber), #e8930a); }
  .av-purple { background: linear-gradient(135deg, #7c3aed, #5b21b6); }
  .av-blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
  .av-slate { background: linear-gradient(135deg, #64748b, #475569); }
  .av-rose { background: linear-gradient(135deg, #f43f5e, #be123c); }
  .av-green { background: linear-gradient(135deg, #22c55e, #16a34a); }
  .user-info-cell { min-width: 0; }
  .user-full-name {
    font-weight: 600; color: var(--ink);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
  }
  .user-email { font-size: 0.78rem; color: var(--muted); }

  /* Status */
  .status-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.82rem; font-weight: 500; white-space: nowrap;
    color: var(--ink);
  }
  .status-badge::before {
    content: ''; width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
  }
  .s-new::before        { background: #6366f1; }
  .s-pending::before    { background: var(--amber); animation: pulse-dot 1.5s ease infinite; }
  @keyframes pulse-dot  { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.5)} }
  .s-active::before     { background: var(--teal); }
  .s-inactive::before   { background: var(--red-soft); }
  .s-subscriber::before { background: var(--teal); }

  /* Role */
  .role-text {
    font-size: 0.82rem; color: var(--muted); font-weight: 500;
  }

  /* Type pill */
  .type-pill {
    display: inline-block; padding: 2px 7px; border-radius: 5px;
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.07em;
    text-transform: uppercase; cursor: default;
  }
  .t-internal { background: var(--slate); color: rgba(255,255,255,0.9); }
  .t-client   { background: var(--amber-pale); color: #a06400; border: 1px solid #f5c97a; }

  /* Row actions */
  .row-actions { display: flex; align-items: center; gap: 4px; opacity: 0; transition: opacity .15s; }
  tbody tr:hover .row-actions { opacity: 1; }
  .row-action-btn {
    width: 30px; height: 30px; border-radius: 7px; border: none;
    background: transparent; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; color: var(--muted); transition: background .15s, color .15s;
  }
  .row-action-btn:hover { background: var(--cream); color: var(--ink); }
  .row-action-btn.danger:hover { background: var(--red-pale); color: var(--red-soft); }
  .row-action-btn.teal:hover { background: var(--teal-pale); color: var(--teal-dark); }

  .last-active { font-size: 0.8rem; color: var(--muted); white-space: nowrap; }

  .client-cell { display: flex; flex-direction: column; gap: 1px; }
  .client-name { font-size: 0.85rem; font-weight: 600; color: var(--ink); white-space: nowrap; }
  .client-id {
    font-size: 0.72rem; color: var(--muted); font-family: 'DM Mono', 'Fira Mono', monospace;
    letter-spacing: 0.02em;
  }
  .client-none { font-size: 0.78rem; color: var(--border); }

  /* User Type Toggle */
  .type-toggle-group {
    display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
  }
  .type-toggle-btn {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    gap: 4px; padding: 16px 12px; border-radius: var(--radius-sm);
    border: 2px solid var(--border); background: var(--card); cursor: pointer;
    transition: all .18s; text-align: center; position: relative; overflow: hidden;
  }
  .type-toggle-btn::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,184,153,0.07), transparent);
    opacity: 0; transition: opacity .18s;
  }
  .type-toggle-btn:hover { border-color: var(--teal); }
  .type-toggle-btn:hover::before { opacity: 1; }
  .type-toggle-btn.active {
    border-color: var(--teal); background: var(--teal-pale);
    box-shadow: 0 0 0 3px rgba(0,184,153,0.15);
  }
  .type-toggle-btn.active::before { opacity: 1; }
  .type-toggle-icon { font-size: 1.4rem; line-height: 1; }
  .type-toggle-label {
    font-family: 'Syne', sans-serif; font-size: 0.9rem; font-weight: 700;
    color: var(--slate); letter-spacing: -0.01em;
  }
  .type-toggle-btn.active .type-toggle-label { color: var(--teal-dark); }
  .type-toggle-sub { font-size: 0.72rem; color: var(--muted); }
  .type-toggle-btn.active .type-toggle-sub { color: var(--teal-dark); opacity: 0.8; }

  /* Client Lookup */
  .client-lookup-block { animation: fadeSlideIn .22s ease; }
  @keyframes fadeSlideIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:none; } }
  .client-lookup-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
  .client-id-wrap { position: relative; }
  .client-id-wrap input {
    width: 100%; padding: 9px 13px; border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); font-size: 0.875rem; color: var(--ink);
    background: var(--card); outline: none; transition: border-color .2s;
  }
  .client-id-wrap input:focus { border-color: var(--teal); }
  .client-id-wrap input.resolved { border-color: var(--teal); background: var(--teal-pale); }
  .client-id-wrap input.error { border-color: var(--red-soft); }
  .client-id-dropdown {
    position: absolute; top: calc(100% + 4px); left: 0; right: 0;
    background: var(--card); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); box-shadow: var(--shadow-md);
    z-index: 50; overflow: hidden; display: none;
  }
  .client-id-dropdown.open { display: block; }
  .dditem {
    padding: 10px 14px; cursor: pointer; display: flex;
    align-items: center; gap: 10px; transition: background .12s;
  }
  .dditem:hover { background: var(--teal-pale); }
  .dditem-id {
    font-family: 'DM Mono','Fira Mono',monospace; font-size: 0.78rem;
    color: var(--teal-dark); font-weight: 600; flex-shrink: 0;
  }
  .dditem-name { font-size: 0.85rem; color: var(--ink); }
  .client-name-resolved {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 13px; border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    background: var(--cream); min-height: 42px; transition: all .2s;
  }
  .client-name-resolved.ok { border-color: var(--teal); background: var(--teal-pale); }
  .client-name-resolved.error { border-color: var(--red-soft); background: var(--red-pale); }
  .resolved-icon { font-size: 0.95rem; flex-shrink: 0; }
  .resolved-text { font-size: 0.82rem; color: var(--muted); }
  .client-name-resolved.ok .resolved-text { color: var(--teal-dark); font-weight: 600; }

  /* Empty state */
  .empty-state {
    padding: 60px 24px; text-align: center; display: none; flex-direction: column;
    align-items: center; gap: 12px;
  }
  .empty-icon { font-size: 2.5rem; opacity: 0.4; }
  .empty-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.1rem; color: var(--slate); }
  .empty-sub { font-size: 0.875rem; color: var(--muted); max-width: 300px; }

  /* Modal */
  .modal-overlay {
    position: fixed; inset: 0; background: rgba(14,22,32,0.55);
    backdrop-filter: blur(4px); z-index: 200;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none; transition: opacity .2s;
  }
  .modal-overlay.open { opacity: 1; pointer-events: all; }
  .modal {
    background: var(--card); border-radius: var(--radius);
    box-shadow: var(--shadow-lg); width: 100%; max-width: 540px;
    max-height: 90vh; overflow-y: auto; position: relative;
    transform: translateY(20px) scale(0.97); transition: transform .25s ease, opacity .25s;
    opacity: 0;
  }
  .modal-overlay.open .modal { transform: none; opacity: 1; }
  .modal-header {
    padding: 24px 28px 20px; border-bottom: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
  }
  .modal-title {
    font-family: 'Syne', sans-serif; font-size: 1.1rem;
    font-weight: 800; color: var(--slate); letter-spacing: -0.02em;
  }
  .modal-close {
    width: 32px; height: 32px; border-radius: 8px; border: none;
    background: var(--cream); cursor: pointer; display: flex;
    align-items: center; justify-content: center; font-size: 1.1rem;
    color: var(--muted); transition: all .15s;
  }
  .modal-close:hover { background: var(--red-pale); color: var(--red-soft); }
  .modal-body { padding: 24px 28px; }
  .modal-footer {
    padding: 16px 28px; border-top: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: flex-end; gap: 10px;
  }
  .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .form-grid.full { grid-template-columns: 1fr; }
  .field { display: flex; flex-direction: column; gap: 6px; }
  .field.span2 { grid-column: 1 / -1; }
  .field-label {
    font-size: 0.8rem; font-weight: 600; color: var(--slate); letter-spacing: 0.01em;
  }
  .field-hint { font-size: 0.74rem; color: var(--muted); }
  .field input, .field select, .field textarea {
    padding: 9px 13px; border: 1.5px solid var(--border); border-radius: var(--radius-sm);
    font-family: 'DM Sans', sans-serif; font-size: 0.875rem; color: var(--ink);
    background: var(--card); outline: none; transition: border-color .2s;
  }
  .field input:focus, .field select:focus { border-color: var(--teal); }
  .field input::placeholder { color: var(--muted); }
  .toggle-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 13px; border: 1.5px solid var(--border); border-radius: var(--radius-sm);
  }
  .toggle-label { font-size: 0.85rem; color: var(--ink); }
  .toggle-sub { font-size: 0.75rem; color: var(--muted); }
  .toggle {
    position: relative; width: 40px; height: 22px; flex-shrink: 0;
  }
  .toggle input { opacity: 0; width: 0; height: 0; }
  .toggle-slider {
    position: absolute; inset: 0; border-radius: 99px;
    background: var(--border); cursor: pointer; transition: background .2s;
  }
  .toggle-slider::after {
    content: ''; position: absolute; width: 16px; height: 16px;
    border-radius: 50%; background: #fff; top: 3px; left: 3px;
    transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,0.2);
  }
  .toggle input:checked + .toggle-slider { background: var(--teal); }
  .toggle input:checked + .toggle-slider::after { transform: translateX(18px); }

  /* Limit banner */
  .limit-banner {
    border-radius: var(--radius); padding: 18px 22px; margin-bottom: 20px;
    display: none; animation: slideDown .3s ease;
    border-left: 4px solid;
  }
  @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: none; } }
  .limit-banner.show { display: block; }
  .limit-banner.warn { background: var(--amber-pale); border-color: var(--amber); }
  .limit-banner.error { background: var(--red-pale); border-color: var(--red-soft); }
  .limit-banner-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px; }
  .limit-banner-title {
    font-weight: 700; font-size: 0.9rem;
    display: flex; align-items: center; gap: 8px;
  }
  .limit-banner.warn .limit-banner-title { color: #b47d00; }
  .limit-banner.error .limit-banner-title { color: var(--red-soft); }
  .limit-banner-close { background: none; border: none; cursor: pointer; font-size: 1rem; opacity: 0.5; }
  .limit-banner-close:hover { opacity: 1; }
  .limit-actions { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 12px; }
  .limit-action-btn {
    padding: 6px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 600;
    cursor: pointer; transition: all .15s; border: 1.5px solid; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
  }
  .la-upgrade { background: var(--teal); color: #fff; border-color: var(--teal); }
  .la-upgrade:hover { background: var(--teal-dark); border-color: var(--teal-dark); }
  .la-seats { background: transparent; color: var(--slate); border-color: var(--border); }
  .la-seats:hover { border-color: var(--teal); color: var(--teal); }
  .la-inactive { background: transparent; color: var(--muted); border-color: var(--border); }
  .la-inactive:hover { border-color: var(--slate); color: var(--slate); }

  /* Confirm modal */
  .confirm-modal { max-width: 420px; }
  .confirm-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--red-pale); color: var(--red-soft);
    font-size: 1.4rem; display: flex; align-items: center; justify-content: center;
    margin-bottom: 14px;
  }

  .reset-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--teal-pale); color: var(--teal-dark);
    font-size: 1.4rem; display: flex; align-items: center; justify-content: center;
    margin-bottom: 14px;
  }

  /* Toast */
  .toast-container {
    position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%);
    z-index: 9999; display: flex; flex-direction: column; align-items: center; gap: 8px;
    pointer-events: none;
  }
  .toast {
    background: var(--slate); color: #fff; padding: 12px 20px;
    border-radius: 99px; font-size: 0.85rem; font-weight: 500;
    box-shadow: var(--shadow-md); display: flex; align-items: center; gap: 9px;
    pointer-events: all; max-width: 380px;
    animation: toastIn .3s ease;
  }
  @keyframes toastIn { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:none; } }
  .toast.fade-out { animation: toastOut .3s ease forwards; }
  @keyframes toastOut { to { opacity:0; transform:translateY(12px); } }
  .toast-icon { font-size: 1rem; flex-shrink: 0; }

  /* Tooltip */
  [data-tip] { position: relative; }
  [data-tip]:hover::after {
    content: attr(data-tip);
    position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%);
    background: var(--slate); color: #fff; font-size: 0.72rem; padding: 4px 9px;
    border-radius: 6px; white-space: nowrap; pointer-events: none; z-index: 100;
  }

  /* Search bar */
  .search-bar-wrap { margin-bottom: 16px; }
  .search-bar {
    display: flex; align-items: center; gap: 10px;
    background: var(--card); border: 2px solid var(--border);
    border-radius: var(--radius); padding: 10px 16px;
    box-shadow: var(--shadow-sm);
    transition: border-color .2s, box-shadow .2s;
    flex-wrap: wrap;
  }
  .search-bar:focus-within {
    border-color: var(--teal);
    box-shadow: 0 0 0 4px rgba(0,184,153,0.1), var(--shadow-sm);
  }
  .search-bar-icon { font-size: 1.1rem; color: var(--muted); flex-shrink: 0; }
  .search-bar-input {
    flex: 1; min-width: 200px; border: none; outline: none;
    font-family: 'DM Sans', sans-serif; font-size: 0.95rem;
    color: var(--ink); background: transparent;
    caret-color: var(--teal);
  }
  .search-bar-input::placeholder { color: var(--muted); }
  .search-tag-list { display: flex; gap: 6px; flex-wrap: wrap; }
  .search-tag {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px 3px 8px; border-radius: 99px;
    font-size: 0.75rem; font-weight: 600;
    background: var(--slate); color: #fff;
    animation: tagPop .15s ease;
  }
  @keyframes tagPop { from{transform:scale(0.8);opacity:0} to{transform:scale(1);opacity:1} }
  .search-tag .tag-field { opacity: 0.6; margin-right: 2px; }
  .search-tag-remove {
    background: none; border: none; color: rgba(255,255,255,0.6);
    cursor: pointer; font-size: 0.85rem; padding: 0; line-height: 1;
    transition: color .12s;
  }
  .search-tag-remove:hover { color: #fff; }
  .search-clear-btn {
    background: none; border: none; cursor: pointer;
    color: var(--muted); font-size: 0.9rem; padding: 2px 6px;
    border-radius: 6px; transition: all .15s; flex-shrink: 0;
  }
  .search-clear-btn:hover { background: var(--red-pale); color: var(--red-soft); }
  .search-hints {
    display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    padding: 8px 4px 2px;
  }
  .search-result-info {
    margin-left: auto; font-size: 0.78rem; color: var(--muted); font-weight: 500;
  }
  .search-result-info strong { color: var(--teal-dark); }

  mark.hl {
    background: rgba(0,184,153,0.18); color: var(--teal-dark);
    border-radius: 3px; padding: 0 2px; font-weight: 700;
  }

  /* Import Modal */
  .import-steps {
    display: flex; align-items: center; gap: 6px;
    margin-bottom: 20px; flex-wrap: wrap;
  }
  .import-step {
    display: flex; align-items: center; gap: 6px;
    font-size: 0.78rem; font-weight: 600; color: var(--muted);
    padding: 5px 0;
  }
  .import-step.active { color: var(--teal-dark); }
  .import-step.done   { color: var(--teal); }
  .istep-num {
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--cream); color: var(--muted);
    font-size: 0.7rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .import-step.active .istep-num { background: var(--teal); color: #fff; }
  .import-step.done   .istep-num { background: var(--teal-dark); color: #fff; }
  .import-step-sep { color: var(--border); font-size: 0.8rem; }

  .import-info-box {
    background: var(--cream); border: 1.5px solid var(--border);
    border-radius: var(--radius-sm); padding: 14px 16px; margin-bottom: 14px;
  }
  .import-cols { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
  .import-col {
    padding: 3px 10px; border-radius: 6px; font-size: 0.72rem;
    font-family: 'DM Mono','Fira Mono',monospace; font-weight: 600;
  }
  .import-col.req { background: var(--teal-pale); color: var(--teal-dark); }
  .import-col.opt { background: var(--cream); color: var(--muted); border: 1px solid var(--border); }

  .import-template-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.8rem; font-weight: 600; color: var(--teal-dark);
    cursor: pointer; text-decoration: underline; margin-bottom: 14px;
  }
  .import-template-link:hover { color: var(--teal); }

  .import-drop-zone {
    border: 2px dashed var(--border); border-radius: var(--radius);
    padding: 32px 20px; text-align: center; transition: all .2s;
    background: var(--paper); cursor: default;
  }
  .import-drop-zone.drag-over { border-color: var(--teal); background: var(--teal-pale); }
  .import-drop-zone.has-file  { border-color: var(--teal); border-style: solid; background: var(--teal-pale); }
  .import-drop-icon { font-size: 2rem; margin-bottom: 8px; }
  .import-drop-label { font-weight: 600; color: var(--slate); font-size: 0.9rem; }
  .import-drop-sub   { font-size: 0.78rem; color: var(--muted); margin: 6px 0; }
  .import-file-name  { margin-top: 10px; font-size: 0.8rem; font-weight: 600; color: var(--teal-dark); }

  .import-summary {
    display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 14px;
  }
  .import-stat {
    flex: 1; min-width: 100px; padding: 12px 14px; border-radius: var(--radius-sm);
    border: 1.5px solid var(--border); background: var(--card); text-align: center;
  }
  .import-stat-num { font-family: 'Syne',sans-serif; font-size: 1.5rem; font-weight: 800; }
  .import-stat-label { font-size: 0.72rem; color: var(--muted); font-weight: 500; }
  .import-stat.ok  .import-stat-num { color: var(--teal-dark); }
  .import-stat.err .import-stat-num { color: var(--red-soft); }
  .import-stat.warn .import-stat-num { color: #b47d00; }

  .import-preview-wrap { overflow-x: auto; border: 1.5px solid var(--border); border-radius: var(--radius-sm); max-height: 280px; overflow-y: auto; }
  .import-preview-table { width: 100%; border-collapse: collapse; font-size: 0.78rem; }
  .import-preview-table th {
    padding: 8px 10px; background: var(--slate); color: rgba(255,255,255,0.8);
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.07em; text-transform: uppercase;
    position: sticky; top: 0; white-space: nowrap;
  }
  .import-preview-table td { padding: 7px 10px; border-bottom: 1px solid var(--border); white-space: nowrap; }
  .import-preview-table tr.row-ok:hover td  { background: rgba(0,184,153,0.05); }
  .import-preview-table tr.row-err td { background: var(--red-pale); }
  .import-preview-table tr.row-warn td { background: var(--amber-pale); }
  .import-row-status { font-size: 0.7rem; font-weight: 700; }
  .irs-ok   { color: var(--teal-dark); }
  .irs-err  { color: var(--red-soft); }
  .irs-warn { color: #b47d00; }

  .import-confirm-box {
    border-radius: var(--radius); padding: 20px 22px;
    background: var(--teal-pale); border: 1.5px solid var(--teal);
    font-size: 0.875rem; line-height: 1.7;
  }
  .import-confirm-box.has-errors {
    background: var(--amber-pale); border-color: var(--amber);
  }

  .sidebar-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,0.5); z-index: 45;
  }
  .sidebar-overlay.visible { display: block; }

  @media (max-width: 960px) {
    .sidebar { transform: translateX(-100%); transition: transform .25s; }
    .sidebar.open { transform: none; }
    .shell { margin-left: 0; }
    .shimmer-bar { left: 0; }
    .seat-grid { grid-template-columns: 1fr; }
    .form-grid { grid-template-columns: 1fr; }
    .form-grid .field.span2 { grid-column: auto; }
  }
  @media (max-width: 600px) {
    .main { padding: 16px; }
    .page-header { flex-direction: column; }
    .filter-bar { gap: 6px; }
    th, td { padding: 10px 10px; }
    .row-actions { opacity: 1; }
  }
</style>
</head>
<body>

<div class="shimmer-bar"></div>

<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<!-- ══ SIDEBAR ═══════════════════════════════════════════ -->
@include('subscriber.includes.sidebar')

<!-- ══ SHELL ══════════════════════════════════════════════ -->
<div class="shell">

  <!-- Top Bar -->
  <header class="topbar">
    <div class="topbar-left">
      <button class="sidebar-toggle-btn" type="button" onclick="toggleDesktopSidebar()" aria-label="Toggle sidebar" aria-expanded="true">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="page-title">User Management</div>
      <div class="topbar-search">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search users, clients, invoices…" oninput="document.getElementById('searchInput').value=this.value; onSearchInput();">
      </div>
    </div>
    <div class="topbar-right">
      <a href="{{ route('subscriber.notifications') }}" class="topbar-btn" title="Notifications">
        🔔
        <span class="topbar-dot"></span>
      </a>
      <a href="#" class="topbar-btn" title="Help" onclick="event.preventDefault();showToast('👥','Manage your team and customer portal accounts.');">❓</a>
    </div>
  </header>

  <!-- Main -->
  <main class="main">

    <!-- Page Header -->
    <div class="page-header">
      <div class="page-header-left">
        <div class="page-eyebrow">Administration</div>
        <h1 class="page-heading">User Management</h1>
        <p class="page-sub">Manage internal team members and client portal users. Seat limits are set in <a href="{{ route('settings.index') }}" style="color:var(--teal);text-decoration:none;font-weight:600;">Defaults &amp; Preferences</a>.</p>
      </div>
      <div class="page-actions">
        <button class="btn btn-outline" onclick="exportUsers()">⬇ Export</button>
        <button class="btn btn-outline" onclick="openImportModal()">⬆ Import</button>
        <button class="btn btn-primary" onclick="openAddModal()">＋ Add User</button>
      </div>
    </div>

    <!-- Limit Banner (hidden by default, shown when limit exceeded) -->
    <div class="limit-banner warn" id="limitBanner">
      <div class="limit-banner-header">
        <div class="limit-banner-title">⚠️ Approaching User Seat Limit</div>
        <button class="limit-banner-close" onclick="document.getElementById('limitBanner').classList.remove('show')">✕</button>
      </div>
      <div style="font-size:0.85rem;color:#92610a;">You're using <strong id="bannerUsed">4 of 5</strong> internal user seats on your <strong>Pro Plan</strong>. Adding more users will require an upgrade or additional seats.</div>
      <div class="limit-actions">
        <a href="#" class="limit-action-btn la-upgrade" onclick="showToast('🚀','Redirecting to plan upgrade…');return false;">🚀 Upgrade Plan</a>
        <a href="#" class="limit-action-btn la-seats" onclick="showToast('💺','Opening seat purchase…');return false;">💺 Buy More Seats</a>
        <a href="#" class="limit-action-btn la-inactive" onclick="filterByStatus('inactive');return false;">💤 View Inactive Users</a>
      </div>
    </div>

    <!-- Seat Usage Cards -->
    <div class="seat-grid">
      <div class="seat-card">
        <div class="seat-card-header">
          <div class="seat-label">Internal Team Seats</div>
          <span class="seat-badge badge-warn" id="intBadge">Near Limit</span>
        </div>
        <div class="seat-count" id="intCount">4 <span>/ 5 seats</span></div>
        <div class="seat-bar-wrap">
          <div class="seat-bar warn" id="intBar" style="width:80%"></div>
        </div>
        <div class="seat-meta">1 seat remaining · Pro Plan includes 5 internal users</div>
      </div>
      <div class="seat-card">
        <div class="seat-card-header">
          <div class="seat-label">Client Portal Users</div>
          <span class="seat-badge badge-ok" id="extBadge">Within Limit</span>
        </div>
        <div class="seat-count" id="extCount">5 <span>/ 20 seats</span></div>
        <div class="seat-bar-wrap">
          <div class="seat-bar ok" id="extBar" style="width:25%"></div>
        </div>
        <div class="seat-meta">15 seats remaining · Pro Plan includes 20 client users</div>
      </div>
    </div>

    <!-- Search Bar -->
    <div class="search-bar-wrap" id="searchBarWrap">
      <div class="search-bar">
        <span class="search-bar-icon">🔍</span>
        <input
          type="text"
          id="searchInput"
          class="search-bar-input"
          placeholder="Search by user name, email, Client ID or client name…"
          oninput="onSearchInput()"
          onkeydown="onSearchKey(event)"
          autocomplete="off"
        >
        <div class="search-tag-list" id="searchTags"></div>
        <button class="search-clear-btn" id="searchClearBtn" onclick="clearSearch()" style="display:none;" title="Clear search">✕</button>
      </div>
      <div class="search-hints" id="searchHints">
        <span class="search-result-info" id="searchResultInfo"></span>
      </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
      <div class="tab-group">
        <button class="tab-btn active" id="tabAll" onclick="switchTab('all')">All Users <span class="count" id="countAll">9</span></button>
        <button class="tab-btn" id="tabInternal" onclick="switchTab('internal')">Internal <span class="count" id="countInternal">4</span></button>
        <button class="tab-btn" id="tabClient" onclick="switchTab('client')">Clients <span class="count" id="countClient">5</span></button>
      </div>
      <div class="filter-spacer"></div>
      <select class="filter-select" id="statusFilter" onchange="filterUsers()">
        <option value="">All Statuses</option>
        <option value="subscriber">Subscriber</option>
        <option value="new">New</option>
        <option value="pending">Pending</option>
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
      <select class="filter-select" id="roleFilter" onchange="filterUsers()">
        <option value="">All Roles</option>
        <option value="Admin">Admin</option>
        <option value="Manager">Manager</option>
        <option value="Staff">Staff</option>
        <option value="Viewer">Viewer</option>
        <option value="Client">Client</option>
      </select>
    </div>

    <!-- User Table -->
    <div class="table-card">
      <div class="table-wrap">
        <table id="userTable">
          <thead>
            <tr>
              <th style="padding-left:20px;width:32px;"><input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" style="cursor:pointer;accent-color:var(--teal);width:15px;height:15px;"></th>
              <th class="sortable" id="th-userId"     onclick="sortTable('userId')">User ID <span class="sort-arrows"><span class="arr-up"></span><span class="arr-dn"></span></span></th>
              <th class="sortable" id="th-name"       onclick="sortTable('name')">Name <span class="sort-arrows"><span class="arr-up"></span><span class="arr-dn"></span></span></th>
              <th class="sortable" id="th-type"       onclick="sortTable('type')">Type <span class="sort-arrows"><span class="arr-up"></span><span class="arr-dn"></span></span></th>
              <th class="sortable" id="th-role"       onclick="sortTable('role')">Role <span class="sort-arrows"><span class="arr-up"></span><span class="arr-dn"></span></span></th>
              <th class="sortable" id="th-client"     onclick="sortTable('client')">Client <span class="sort-arrows"><span class="arr-up"></span><span class="arr-dn"></span></span></th>
              <th class="sortable" id="th-lastActive" onclick="sortTable('lastActive')">Last Active <span class="sort-arrows"><span class="arr-up"></span><span class="arr-dn"></span></span></th>
              <th>2FA</th>
              <th class="sortable" id="th-status"     onclick="sortTable('status')">Status <span class="sort-arrows"><span class="arr-up"></span><span class="arr-dn"></span></span></th>
              <th style="text-align:right;padding-right:20px;">Actions</th>
            </tr>
          </thead>
          <tbody id="userTableBody">
          </tbody>
        </table>
        <div class="empty-state" id="emptyState">
          <div class="empty-icon">👤</div>
          <div class="empty-title">No users found</div>
          <div class="empty-sub">Try adjusting your search or filter criteria.</div>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- ══ ADD / EDIT USER MODAL ══════════════════════════════ -->
<div class="modal-overlay" id="userModal">
  <div class="modal">
    <div class="modal-header">
      <div class="modal-title" id="modalTitle">Add New User</div>
      <button class="modal-close" onclick="closeModal('userModal')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">

        <!-- ① User Type — always first -->
        <div class="field span2">
          <label class="field-label">User Type <span style="color:var(--red-soft)">*</span></label>
          <div class="type-toggle-group" id="typeToggleGroup">
            <button type="button" class="type-toggle-btn active" id="typeBtnInternal" onclick="selectUserType('internal')">
              <span class="type-toggle-icon">🏢</span>
              <span class="type-toggle-label">Internal</span>
              <span class="type-toggle-sub">Team member</span>
            </button>
            <button type="button" class="type-toggle-btn" id="typeBtnClient" onclick="selectUserType('client')">
              <span class="type-toggle-icon">🌐</span>
              <span class="type-toggle-label">Client</span>
              <span class="type-toggle-sub">Portal user</span>
            </button>
          </div>
          <input type="hidden" id="fType" value="internal">
        </div>

        <!-- ② User ID -->
        <div class="field span2">
          <label class="field-label">User ID <span style="color:var(--red-soft)">*</span></label>
          <div class="uid-field-wrap">
            <input type="text" id="fUserId" maxlength="10" placeholder="0000000000" autocomplete="off">
            <div class="uid-error-msg" id="fUserIdError">This User ID already exists. Please enter a unique 10-digit ID.</div>
          </div>
          <div class="uid-autogen-row" id="uidAutoGenRow">
            <input type="checkbox" id="fUserIdAuto" onchange="onUserIdAutoChange()">
            <label for="fUserIdAuto" style="cursor:pointer;">Auto-generate User ID</label>
            <span id="uidAutoGenNote" style="margin-left:auto;"></span>
          </div>
        </div>
        <div class="field span2 client-lookup-block" id="clientLookupBlock" style="display:none;">
          <label class="field-label">Client Lookup <span style="color:var(--red-soft)">*</span></label>
          <div class="client-lookup-row">
            <div class="client-id-wrap">
              <input type="text" id="fClientIdInput" placeholder="Client ID (e.g. CLT-0012)" oninput="onClientIdInput()" autocomplete="off" style="font-family:'DM Mono','Fira Mono',monospace;letter-spacing:0.04em;">
              <div class="client-id-dropdown" id="clientIdDropdown"></div>
            </div>
            <div class="client-name-resolved" id="clientNameResolved">
              <span class="resolved-icon" id="resolvedIcon">🔍</span>
              <span class="resolved-text" id="resolvedText">Enter Client ID to look up</span>
            </div>
          </div>
          <input type="hidden" id="fClientName" value="">
          <input type="hidden" id="fClientIdHidden" value="">
          <span class="field-hint">Type a Client ID or name to search — the client record will auto-populate.</span>
        </div>

        <!-- ③ Name fields -->
        <div class="field">
          <label class="field-label">First Name <span style="color:var(--red-soft)">*</span></label>
          <input type="text" id="fFirstName" placeholder="e.g. Sarah">
        </div>
        <div class="field">
          <label class="field-label">Last Name <span style="color:var(--red-soft)">*</span></label>
          <input type="text" id="fLastName" placeholder="e.g. Thompson">
        </div>

        <!-- ④ Email -->
        <div class="field span2">
          <label class="field-label">Email Address <span style="color:var(--red-soft)">*</span></label>
          <input type="email" id="fEmail" placeholder="e.g. sarah@acme.com">
          <span class="field-hint">An invitation will be sent to this address.</span>
        </div>

        <!-- ⑤ Role -->
        <div class="field span2">
          <label class="field-label">Role</label>
          <select id="fRole">
            <option value="Admin">Admin</option>
            <option value="Manager">Manager</option>
            <option value="Staff" selected>Staff</option>
            <option value="Viewer">Viewer</option>
          </select>
        </div>

        <!-- ⑥ Toggles -->
        <div class="field span2">
          <div class="toggle-row">
            <div>
              <div class="toggle-label">Send invitation email immediately</div>
              <div class="toggle-sub">User will receive an email to set up their password.</div>
            </div>
            <label class="toggle"><input type="checkbox" id="fSendInvite" checked><div class="toggle-slider"></div></label>
          </div>
        </div>
        <div class="field span2">
          <div class="toggle-row">
            <div>
              <div class="toggle-label">Require two-factor authentication</div>
              <div class="toggle-sub">User must enable 2FA before accessing the platform.</div>
            </div>
            <label class="toggle"><input type="checkbox" id="fRequire2FA"><div class="toggle-slider"></div></label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('userModal')">Cancel</button>
      <button class="btn btn-primary" id="modalSaveBtn" onclick="saveUser()">Save User</button>
    </div>
  </div>
</div>

<!-- ══ DELETE CONFIRM MODAL ════════════════════════════════ -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal confirm-modal">
    <div class="modal-body" style="padding-top:28px;">
      <div class="confirm-icon">🗑️</div>
      <div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--slate);margin-bottom:8px;">Delete User?</div>
      <div style="font-size:0.875rem;color:var(--muted);line-height:1.6;" id="deleteMsg">This user will be permanently removed and will immediately lose access to the platform. This action cannot be undone.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('deleteModal')">Cancel</button>
      <button class="btn btn-danger" onclick="confirmDelete()">Delete User</button>
    </div>
  </div>
</div>

<!-- ══ RESET PASSWORD MODAL ════════════════════════════════ -->
<div class="modal-overlay" id="resetModal">
  <div class="modal confirm-modal">
    <div class="modal-body" style="padding-top:28px;">
      <div class="reset-icon">🔐</div>
      <div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--slate);margin-bottom:8px;">Reset Password</div>
      <div style="font-size:0.875rem;color:var(--muted);line-height:1.6;" id="resetMsg">A password reset link will be sent to this user's email address. The link expires after 24 hours.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('resetModal')">Cancel</button>
      <button class="btn btn-primary" onclick="confirmReset()">Send Reset Link</button>
    </div>
  </div>
</div>

<!-- ══ SUSPEND CONFIRM MODAL ══════════════════════════════ -->
<div class="modal-overlay" id="suspendModal">
  <div class="modal confirm-modal">
    <div class="modal-body" style="padding-top:28px;">
      <div class="confirm-icon">🚫</div>
      <div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--slate);margin-bottom:8px;" id="suspendTitle">Suspend User?</div>
      <div style="font-size:0.875rem;color:var(--muted);line-height:1.6;" id="suspendMsg">This user will be suspended and immediately lose access until re-activated.</div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('suspendModal')">Cancel</button>
      <button class="btn btn-danger" id="suspendConfirmBtn" onclick="confirmSuspend()">Suspend User</button>
    </div>
  </div>
</div>

<!-- ══ ACTIVATE MODAL ══════════════════════════════════════ -->
<div class="modal-overlay" id="activateModal">
  <div class="modal confirm-modal">
    <div class="modal-body" style="padding-top:28px;">
      <div class="reset-icon">✅</div>
      <div style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:var(--slate);margin-bottom:8px;">Activate User?</div>
      <div style="font-size:0.875rem;color:var(--muted);line-height:1.6;" id="activateMsg"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-ghost" onclick="closeModal('activateModal')">Cancel</button>
      <button class="btn btn-primary" onclick="confirmActivate()">Activate User</button>
    </div>
  </div>
</div>

<!-- ══ IMPORT MODAL ═══════════════════════════════════════ -->
<div class="modal-overlay" id="importModal">
  <div class="modal" style="max-width:600px;">
    <div class="modal-header">
      <div class="modal-title">Import Users</div>
      <button class="modal-close" onclick="closeImportModal()">✕</button>
    </div>
    <div class="modal-body">

      <!-- Step indicator -->
      <div class="import-steps" id="importSteps">
        <div class="import-step active" id="istep1"><span class="istep-num">1</span> Upload File</div>
        <div class="import-step-sep">→</div>
        <div class="import-step" id="istep2"><span class="istep-num">2</span> Preview &amp; Validate</div>
        <div class="import-step-sep">→</div>
        <div class="import-step" id="istep3"><span class="istep-num">3</span> Confirm</div>
      </div>

      <!-- Step 1: Upload -->
      <div id="importStep1">
        <div class="import-info-box">
          <div style="font-weight:600;margin-bottom:6px;font-size:0.875rem;">📋 Required CSV columns</div>
          <div class="import-cols">
            <span class="import-col req">first_name</span>
            <span class="import-col req">last_name</span>
            <span class="import-col req">email</span>
            <span class="import-col req">type</span>
            <span class="import-col req">role</span>
            <span class="import-col opt">user_id</span>
            <span class="import-col opt">client_id</span>
            <span class="import-col opt">client_name</span>
          </div>
          <div style="font-size:0.75rem;color:var(--muted);margin-top:8px;">
            <strong style="color:var(--ink)">type</strong> values: <code>internal</code> or <code>client</code> &nbsp;·&nbsp;
            <strong style="color:var(--ink)">user_id</strong>: omit to auto-generate &nbsp;·&nbsp;
            <span style="color:var(--teal-dark);font-weight:600;">■</span> Required &nbsp;
            <span style="color:var(--muted);font-weight:600;">■</span> Optional
          </div>
        </div>
        <a class="import-template-link" onclick="downloadTemplate()">⬇ Download CSV template</a>
        <div class="import-drop-zone" id="importDropZone"
          ondragover="event.preventDefault();this.classList.add('drag-over')"
          ondragleave="this.classList.remove('drag-over')"
          ondrop="handleFileDrop(event)">
          <div class="import-drop-icon">📂</div>
          <div class="import-drop-label">Drag &amp; drop your CSV file here</div>
          <div class="import-drop-sub">or</div>
          <label class="btn btn-outline btn-sm" style="cursor:pointer;">
            Browse File
            <input type="file" accept=".csv" id="importFileInput" style="display:none;" onchange="handleFileSelect(event)">
          </label>
          <div class="import-file-name" id="importFileName"></div>
        </div>
      </div>

      <!-- Step 2: Preview & Validate -->
      <div id="importStep2" style="display:none;">
        <div class="import-summary" id="importSummary"></div>
        <div class="import-preview-wrap">
          <table class="import-preview-table" id="importPreviewTable"></table>
        </div>
      </div>

      <!-- Step 3: Confirm -->
      <div id="importStep3" style="display:none;">
        <div class="import-confirm-box" id="importConfirmBox"></div>
      </div>

    </div>
    <div class="modal-footer" id="importFooter">
      <button class="btn btn-ghost" onclick="closeImportModal()">Cancel</button>
      <button class="btn btn-outline btn-sm" id="importBackBtn" onclick="importGoBack()" style="display:none;">← Back</button>
      <button class="btn btn-primary" id="importNextBtn" onclick="importNext()" disabled>Next →</button>
    </div>
  </div>
</div>

<!-- ══ TOAST CONTAINER ════════════════════════════════════ -->
<div class="toast-container" id="toastContainer"></div>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ─── DATA LOADED FROM CONTROLLER ───────────────────────────
const PLAN_LIMITS = @json($planLimits ?? ['internal' => 5, 'client' => 20]);
let users = @json($jsUsers ?? []);
const CLIENT_REGISTRY = @json($clientRegistry ?? []);

let currentTab = 'all';
let editingId = null;
let deletingId = null;
let resetId = null;
let suspendId = null;
let nextId = users.length ? Math.max(...users.map(u => u.id)) + 1 : 1;

// ─── USER ID CONFIG ───────────────────────────────────────
const USER_ID_AUTO_GENERATE = true;
let nextUserIdSeed = @json($nextUserId ?? '0000000010');

function getNextAutoUserId() {
  return String(nextUserIdSeed);
}

// ─── SEARCH ENGINE ────────────────────────────────────────
let searchTokens = [];

function parseSearch(raw) {
  const tokens = [];
  const prefixRe = /(name|email|clientid|client|status):("([^"]+)"|(\S+))/gi;
  let match;
  let remaining = raw;
  while ((match = prefixRe.exec(raw)) !== null) {
    const field = match[1].toLowerCase();
    const value = (match[3] || match[4] || '').toLowerCase().trim();
    if (value) tokens.push({ field, value });
    remaining = remaining.replace(match[0], '');
  }
  const free = remaining.trim();
  if (free) tokens.push({ field: 'any', value: free.toLowerCase() });
  return tokens;
}

function userMatchesTokens(u, tokens) {
  if (!tokens.length) return true;
  return tokens.every(tok => {
    const v = tok.value;
    switch (tok.field) {
      case 'name':     return `${u.firstName} ${u.lastName}`.toLowerCase().includes(v);
      case 'email':    return u.email.toLowerCase().includes(v);
      case 'clientid': return (u.clientId || '').toLowerCase().includes(v);
      case 'client':   return (u.clientName || '').toLowerCase().includes(v);
      case 'status':   return u.status.toLowerCase().includes(v);
      default:         return (
        `${u.firstName} ${u.lastName}`.toLowerCase().includes(v) ||
        u.email.toLowerCase().includes(v) ||
        (u.userId || '').toLowerCase().includes(v) ||
        (u.clientId || '').toLowerCase().includes(v) ||
        (u.clientName || '').toLowerCase().includes(v) ||
        u.status.toLowerCase().includes(v)
      );
    }
  });
}

function getFiltered() {
  const status = document.getElementById('statusFilter').value;
  const role   = document.getElementById('roleFilter').value;
  return users.filter(u => {
    const matchTab    = currentTab === 'all' || u.type === currentTab;
    const matchSearch = userMatchesTokens(u, searchTokens);
    const matchStatus = !status || u.status === status;
    const matchRole   = !role   || u.role   === role;
    return matchTab && matchSearch && matchStatus && matchRole;
  });
}

function onSearchInput() {
  const raw = document.getElementById('searchInput').value;
  searchTokens = parseSearch(raw);
  document.getElementById('searchClearBtn').style.display = raw.trim() ? '' : 'none';
  renderSearchTags();
  renderTable();
}

function renderSearchTags() {
  const container = document.getElementById('searchTags');
  const prefixed = searchTokens.filter(t => t.field !== 'any');
  container.innerHTML = prefixed.map((tok, i) => `
    <span class="search-tag">
      <span class="tag-field">${tok.field}:</span>${tok.value}
      <button class="search-tag-remove" onclick="removeToken(${i})" title="Remove">✕</button>
    </span>
  `).join('');
}

function removeToken(idx) {
  const inp = document.getElementById('searchInput');
  const prefixed = searchTokens.filter(t => t.field !== 'any');
  const tok = prefixed[idx];
  const re = new RegExp(tok.field + ':(\"[^\"]*\"|\\S+)', 'gi');
  let remaining = inp.value;
  let count = 0;
  remaining = remaining.replace(re, (m) => {
    if (count++ === idx) return '';
    return m;
  });
  inp.value = remaining.trim();
  onSearchInput();
}

function clearSearch() {
  document.getElementById('searchInput').value = '';
  searchTokens = [];
  document.getElementById('searchClearBtn').style.display = 'none';
  renderSearchTags();
  renderTable();
}

function onSearchKey(e) {
  if (e.key === 'Escape') clearSearch();
}

function hl(text, tokens) {
  if (!text) return '—';
  let result = escHtml(text);
  const anyTok = tokens.find(t => t.field === 'any');
  if (anyTok) {
    const re = new RegExp('(' + escRe(anyTok.value) + ')', 'gi');
    result = result.replace(re, '<mark class="hl">$1</mark>');
  }
  return result;
}
function escHtml(s) { return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }
function escRe(s) { return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }

function filterUsers() { renderTable(); }

function renderTable() {
  const filtered = getFiltered();
  const body = document.getElementById('userTableBody');
  const empty = document.getElementById('emptyState');

  // Update tab counts
  document.getElementById('countAll').textContent = users.length;
  document.getElementById('countInternal').textContent = users.filter(u=>u.type==='internal').length;
  document.getElementById('countClient').textContent = users.filter(u=>u.type==='client').length;

  // Result info
  const infoEl = document.getElementById('searchResultInfo');
  if (searchTokens.length) {
    infoEl.innerHTML = `Showing <strong>${filtered.length}</strong> of ${users.length} users`;
  } else {
    infoEl.innerHTML = '';
  }

  if (filtered.length === 0) {
    body.innerHTML = '';
    empty.style.display = 'flex';
    return;
  }
  empty.style.display = 'none';

  body.innerHTML = filtered.map((u, i) => `
    <tr style="animation-delay:${i * 0.04}s">
      <td style="padding-left:20px;"><input type="checkbox" class="row-check" data-id="${u.id}" style="cursor:pointer;accent-color:var(--teal);width:15px;height:15px;"></td>
      <td><span class="uid-link" onclick="openEditModal(${u.id})" title="Click to edit user">${u.userId}</span></td>
      <td>
        <div class="user-cell">
          <div class="avatar ${u.avClass}">${u.avatar}</div>
          <div class="user-info-cell">
            <div class="user-full-name">${hl(u.firstName + ' ' + u.lastName, searchTokens)}</div>
            <div class="user-email">${hl(u.email, searchTokens)}</div>
          </div>
        </div>
      </td>
      <td><span class="type-pill t-${u.type}" title="${u.type === 'internal' ? 'Internal' : 'Client'}">${u.type === 'internal' ? 'INT' : 'CL'}</span></td>
      <td><span class="role-text">${u.role}</span></td>
      <td>
        ${u.clientId ? `<div class="client-cell"><div class="client-name">${hl(u.clientName, searchTokens)}</div><div class="client-id">${hl(u.clientId, searchTokens)}</div></div>` : '<span class="client-none">—</span>'}
      </td>
      <td><span class="last-active">${u.lastActive}</span></td>
      <td style="text-align:center;">${u.twoFA ? '<span title="2FA enabled" style="color:var(--teal);font-size:1rem;">🛡️</span>' : '<span title="2FA disabled" style="color:var(--muted);font-size:0.75rem;">—</span>'}</td>
      <td><span class="status-badge s-${u.status}">${statusLabel(u)}</span></td>
      <td style="text-align:right;padding-right:20px;">
        <div class="row-actions">
          ${rowActions(u)}
        </div>
      </td>
    </tr>
  `).join('');

  updateSeatCards();
}

function updateSeatCards() {
  const intUsed = users.filter(u => u.type === 'internal').length;
  const extUsed = users.filter(u => u.type === 'client').length;
  const intPct = Math.min((intUsed / PLAN_LIMITS.internal) * 100, 100);
  const extPct = Math.min((extUsed / PLAN_LIMITS.client) * 100, 100);

  document.getElementById('intCount').innerHTML = `${intUsed} <span>/ ${PLAN_LIMITS.internal} seats</span>`;
  document.getElementById('extCount').innerHTML = `${extUsed} <span>/ ${PLAN_LIMITS.client} seats</span>`;
  document.getElementById('intBar').style.width = intPct + '%';
  document.getElementById('extBar').style.width = extPct + '%';

  const intBadge = document.getElementById('intBadge');
  const intBar = document.getElementById('intBar');
  if (intUsed >= PLAN_LIMITS.internal) {
    intBadge.textContent = 'Limit Reached'; intBadge.className = 'seat-badge badge-over';
    intBar.className = 'seat-bar over';
  } else if (intPct >= 80) {
    intBadge.textContent = 'Near Limit'; intBadge.className = 'seat-badge badge-warn';
    intBar.className = 'seat-bar warn';
  } else {
    intBadge.textContent = 'Within Limit'; intBadge.className = 'seat-badge badge-ok';
    intBar.className = 'seat-bar ok';
  }

  const extBadge = document.getElementById('extBadge');
  const extBar = document.getElementById('extBar');
  if (extUsed >= PLAN_LIMITS.client) {
    extBadge.textContent = 'Limit Reached'; extBadge.className = 'seat-badge badge-over';
    extBar.className = 'seat-bar over';
  } else if (extPct >= 80) {
    extBadge.textContent = 'Near Limit'; extBadge.className = 'seat-badge badge-warn';
    extBar.className = 'seat-bar warn';
  } else {
    extBadge.textContent = 'Within Limit'; extBadge.className = 'seat-badge badge-ok';
    extBar.className = 'seat-bar ok';
  }

  const banner = document.getElementById('limitBanner');
  if (intUsed >= PLAN_LIMITS.internal) {
    banner.className = 'limit-banner error show';
    document.querySelector('#limitBanner .limit-banner-title').textContent = '🚨 Internal User Seat Limit Reached';
    banner.querySelector('div[style]').innerHTML = `You've reached the maximum of <strong>${PLAN_LIMITS.internal} internal users</strong> on your <strong>Pro Plan</strong>. To add more team members, please upgrade your plan or purchase additional seats.`;
    document.getElementById('bannerUsed').textContent = `${intUsed} of ${PLAN_LIMITS.internal}`;
  } else if (intPct >= 80) {
    banner.className = 'limit-banner warn show';
    document.querySelector('#limitBanner .limit-banner-title').textContent = '⚠️ Approaching User Seat Limit';
    document.getElementById('bannerUsed').textContent = `${intUsed} of ${PLAN_LIMITS.internal}`;
  } else {
    banner.classList.remove('show');
  }
}

function statusLabel(u) {
  const labels = { subscriber:'Subscriber', new:'New', pending:'Pending', active:'Active', inactive:'Inactive' };
  return labels[u.status] || capitalize(u.status);
}

function rowActions(u) {
  if (u.isSubscriber) {
    return `<span style="font-size:0.72rem;color:var(--muted);padding:0 4px;">Owner account</span>`;
  }
  const btn = (tip, icon, fn, cls='') =>
    `<button class="row-action-btn ${cls}" data-tip="${tip}" onclick="${fn}(${u.id})">${icon}</button>`;

  switch (u.status) {
    case 'new':
      return btn('Edit','✏️','openEditModal')
           + btn('Send Invite','📨','sendInvite','teal')
           + btn('Delete','🗑️','openDeleteModal','danger');
    case 'pending':
      return btn('Edit','✏️','openEditModal')
           + btn('Resend Invite','🔄','resendInvite','teal')
           + btn('Activate','✅','openActivateModal','teal')
           + btn('Delete','🗑️','openDeleteModal','danger');
    case 'active':
      return btn('Edit','✏️','openEditModal')
           + btn('Reset Password','🔐','openResetModal','teal')
           + btn('Suspend','🚫','openSuspendModal')
           + btn('Delete','🗑️','openDeleteModal','danger');
    case 'inactive':
      return btn('Activate','✅','openActivateModal','teal')
           + btn('Edit','✏️','openEditModal')
           + btn('Refresh — Resend invite & set Pending','🔄','resendInvite','teal')
           + btn('Delete','🗑️','openDeleteModal','danger');
    default:
      return '';
  }
}

function switchTab(tab) {
  currentTab = tab;
  ['all','internal','client'].forEach(t => {
    document.getElementById('tab' + capitalize(t)).classList.toggle('active', t === tab);
  });
  renderTable();
}

function filterByStatus(status) {
  document.getElementById('statusFilter').value = status;
  renderTable();
}

// ─── ADD / EDIT MODAL ──────────────────────────────────────
function openAddModal() {
  editingId = null;
  document.getElementById('modalTitle').textContent = 'Add New User';
  document.getElementById('modalSaveBtn').textContent = 'Save User';
  document.getElementById('fFirstName').value = '';
  document.getElementById('fLastName').value = '';
  document.getElementById('fEmail').value = '';
  selectUserType('internal');
  document.getElementById('fRole').value = 'Staff';
  clearClientLookup();
  document.getElementById('fSendInvite').checked = false;
  document.getElementById('fRequire2FA').checked = false;
  initUserIdField(null);
  openModal('userModal');
}

function openEditModal(id) {
  const u = users.find(x => x.id === id);
  if (!u) return;
  editingId = id;
  document.getElementById('modalTitle').textContent = 'Edit User';
  document.getElementById('modalSaveBtn').textContent = 'Save Changes';
  document.getElementById('fFirstName').value = u.firstName;
  document.getElementById('fLastName').value = u.lastName;
  document.getElementById('fEmail').value = u.email;
  selectUserType(u.type);
  document.getElementById('fRole').value = u.role;
  if (u.clientId && u.clientName) {
    resolveClient(u.clientId, u.clientName);
  } else {
    clearClientLookup();
  }
  document.getElementById('fSendInvite').checked = false;
  document.getElementById('fRequire2FA').checked = u.twoFA;
  initUserIdField(u.userId);
  openModal('userModal');
}

function initUserIdField(existingId) {
  const inp     = document.getElementById('fUserId');
  const autoChk = document.getElementById('fUserIdAuto');
  const row     = document.getElementById('uidAutoGenRow');
  const note    = document.getElementById('uidAutoGenNote');
  const errMsg  = document.getElementById('fUserIdError');
  inp.classList.remove('uid-error');
  errMsg.classList.remove('show');

  if (existingId) {
    inp.value    = existingId;
    inp.disabled = true;
    autoChk.checked  = false;
    autoChk.disabled = true;
    row.className = 'uid-autogen-row';
    note.innerHTML = '<span style="color:var(--muted)">User ID cannot be changed after creation.</span>';
  } else if (USER_ID_AUTO_GENERATE) {
    const preview = getNextAutoUserId();
    inp.value    = preview;
    inp.disabled = true;
    autoChk.checked  = true;
    autoChk.disabled = true;
    row.className = 'uid-autogen-row locked';
    note.innerHTML = `Auto-generate is <strong>ON</strong> in <a href="{{ route('settings.index') }}">Defaults &amp; Preferences</a>`;
  } else {
    inp.value    = '';
    inp.disabled = false;
    inp.placeholder = 'Enter 10-digit User ID';
    autoChk.checked  = false;
    autoChk.disabled = true;
    row.className = 'uid-autogen-row';
    note.innerHTML = `Manual entry required. Change in <a href="{{ route('settings.index') }}">Defaults &amp; Preferences</a>`;
  }
}

function onUserIdAutoChange() {}

function validateUserId(newUid, excludeId) {
  if (!newUid || newUid.length !== 10 || !/^\d{10}$/.test(newUid)) return 'User ID must be exactly 10 digits.';
  const exists = users.some(u => u.userId === newUid && u.id !== excludeId);
  if (exists) return 'This User ID already exists. Please enter a unique 10-digit ID.';
  return null;
}

function selectUserType(type) {
  document.getElementById('fType').value = type;
  document.getElementById('typeBtnInternal').classList.toggle('active', type === 'internal');
  document.getElementById('typeBtnClient').classList.toggle('active', type === 'client');

  const block = document.getElementById('clientLookupBlock');
  block.style.display = type === 'client' ? '' : 'none';

  const roleSel = document.getElementById('fRole');
  if (type === 'internal') {
    roleSel.innerHTML = '<option value="Admin">Admin</option><option value="Manager">Manager</option><option value="Staff" selected>Staff</option><option value="Viewer">Viewer</option>';
  } else {
    roleSel.innerHTML = '<option value="Client" selected>Client</option>';
  }

  if (type === 'internal') clearClientLookup();
}

function clearClientLookup() {
  const inp = document.getElementById('fClientIdInput');
  if (inp) inp.value = '';
  document.getElementById('fClientName').value = '';
  document.getElementById('fClientIdHidden').value = '';
  const resolved = document.getElementById('clientNameResolved');
  resolved.className = 'client-name-resolved';
  document.getElementById('resolvedIcon').textContent = '🔍';
  document.getElementById('resolvedText').textContent = 'Enter Client ID to look up';
  closeDropdown();
}

function resolveClient(clientId, clientName) {
  const inp = document.getElementById('fClientIdInput');
  if (inp) inp.value = clientId;
  inp.classList.remove('error'); inp.classList.add('resolved');
  document.getElementById('fClientName').value = clientName;
  document.getElementById('fClientIdHidden').value = clientId;
  const resolved = document.getElementById('clientNameResolved');
  resolved.className = 'client-name-resolved ok';
  document.getElementById('resolvedIcon').textContent = '✅';
  document.getElementById('resolvedText').textContent = clientName;
  closeDropdown();
}

function onClientIdInput() {
  const val = document.getElementById('fClientIdInput').value.trim().toLowerCase();
  const inp = document.getElementById('fClientIdInput');
  inp.classList.remove('resolved','error');
  document.getElementById('fClientName').value = '';
  document.getElementById('fClientIdHidden').value = '';
  const resolved = document.getElementById('clientNameResolved');
  resolved.className = 'client-name-resolved';
  document.getElementById('resolvedIcon').textContent = '🔍';
  document.getElementById('resolvedText').textContent = 'Enter Client ID to look up';

  if (!val) { closeDropdown(); return; }

  const matches = CLIENT_REGISTRY.filter(c =>
    (c.id || '').toLowerCase().includes(val) || (c.name || '').toLowerCase().includes(val)
  );

  const dd = document.getElementById('clientIdDropdown');
  if (matches.length === 0) {
    dd.classList.remove('open');
    resolved.className = 'client-name-resolved error';
    document.getElementById('resolvedIcon').textContent = '❌';
    document.getElementById('resolvedText').textContent = 'No client found';
    return;
  }

  dd.innerHTML = matches.map(c => `
    <div class="dditem" onclick="resolveClient('${c.id}','${c.name}')">
      <span class="dditem-id">${c.id}</span>
      <span class="dditem-name">${c.name}</span>
    </div>
  `).join('');
  dd.classList.add('open');

  const exact = CLIENT_REGISTRY.find(c => (c.id || '').toLowerCase() === val);
  if (exact) resolveClient(exact.id, exact.name);
}

function closeDropdown() {
  const dd = document.getElementById('clientIdDropdown');
  if (dd) dd.classList.remove('open');
}

document.addEventListener('click', e => {
  if (!e.target.closest('.client-id-wrap')) closeDropdown();
});

// ─── SAVE USER (AJAX) ──────────────────────────────────────
async function saveUser() {
  const firstName = document.getElementById('fFirstName').value.trim();
  const lastName = document.getElementById('fLastName').value.trim();
  const email = document.getElementById('fEmail').value.trim();
  const type = document.getElementById('fType').value;
  const role = document.getElementById('fRole').value;
  const clientName = document.getElementById('fClientName').value;
  const clientId = document.getElementById('fClientIdHidden').value;
  const twoFA = document.getElementById('fRequire2FA').checked;
  const sendInvite = document.getElementById('fSendInvite').checked;

  if (!firstName || !lastName || !email) { showToast('⚠️','Please fill in all required fields'); return; }
  if (type === 'client' && !clientId) { showToast('⚠️','Please select a client using the Client ID lookup'); document.getElementById('fClientIdInput').focus(); return; }

  const uidInp = document.getElementById('fUserId');
  const uidErrMsg = document.getElementById('fUserIdError');
  const userId = uidInp.value.trim();
  uidInp.classList.remove('uid-error');
  uidErrMsg.classList.remove('show');

  if (!editingId) {
    const uidErr = validateUserId(userId, null);
    if (uidErr) {
      uidInp.classList.add('uid-error');
      uidErrMsg.textContent = uidErr;
      uidErrMsg.classList.add('show');
      uidInp.focus();
      return;
    }
  }

  const payload = {
    firstName, lastName, email, type, role,
    clientId, clientName, twoFA, sendInvite, userId
  };

  const btn = document.getElementById('modalSaveBtn');
  btn.disabled = true;
  btn.textContent = 'Saving…';

  try {
    const url = editingId ? `/subscriber/customers/${editingId}` : '/subscriber/customers';
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
    if (data.success && data.user) {
      if (editingId) {
        const idx = users.findIndex(u => u.id === editingId);
        if (idx !== -1) users[idx] = data.user;
        showToast('✅', `${firstName} ${lastName} updated successfully`);
      } else {
        users.push(data.user);
        const nextNum = parseInt(nextUserIdSeed) + 1;
        nextUserIdSeed = String(nextNum).padStart(10, '0');
        showToast('✅', `${firstName} ${lastName} added · User ID: ${data.user.userId}`);
      }
      closeModal('userModal');
      renderTable();
    } else {
      showToast('⚠️', data.message || 'Error saving user');
    }
  } catch (err) {
    showToast('⚠️', 'Network error saving user');
  } finally {
    btn.disabled = false;
    btn.textContent = editingId ? 'Save Changes' : 'Save User';
  }
}

// ─── STATUS ACTIONS (AJAX) ─────────────────────────────────
async function sendInvite(id) {
  const u = users.find(x => x.id === id);
  try {
    const res = await fetch(`/subscriber/customers/${id}/status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ action: 'invite' })
    });
    const data = await res.json();
    if (data.success) {
      u.status = 'pending';
      u.lastActive = data.lastActive || 'Invite sent just now';
      renderTable();
      showToast('📨', `Invitation sent to ${u.email} — status set to Pending`);
    }
  } catch (e) {
    showToast('⚠️', 'Error sending invitation');
  }
}

async function resendInvite(id) {
  const u = users.find(x => x.id === id);
  try {
    const res = await fetch(`/subscriber/customers/${id}/status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ action: 'resend_invite' })
    });
    const data = await res.json();
    if (data.success) {
      u.status = 'pending';
      u.lastActive = data.lastActive || 'Invite resent just now';
      renderTable();
      showToast('🔄', `Invitation resent to ${u.email}`);
    }
  } catch (e) {
    showToast('⚠️', 'Error resending invitation');
  }
}

let activatingId = null;
function openActivateModal(id) {
  const u = users.find(x => x.id === id);
  activatingId = id;
  const msg = u.status === 'inactive'
    ? `${u.firstName} ${u.lastName} will be reactivated and regain full access to the platform.`
    : `${u.firstName} ${u.lastName} will be marked Active. This simulates the user completing their first login.`;
  document.getElementById('activateMsg').textContent = msg;
  openModal('activateModal');
}

async function confirmActivate() {
  const u = users.find(x => x.id === activatingId);
  try {
    const res = await fetch(`/subscriber/customers/${activatingId}/status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ action: 'activate' })
    });
    const data = await res.json();
    if (data.success) {
      u.status = 'active';
      u.lastActive = data.lastActive || 'Just now';
      closeModal('activateModal');
      renderTable();
      showToast('✅', `${u.firstName} ${u.lastName} is now Active`);
    }
  } catch (e) {
    showToast('⚠️', 'Error activating user');
  }
}

function openResetModal(id) {
  const u = users.find(x => x.id === id);
  resetId = id;
  document.getElementById('resetMsg').textContent = `A new password will be generated and sent to ${u.email} based on the password policy set in Company Defaults.`;
  openModal('resetModal');
}

async function confirmReset() {
  const u = users.find(x => x.id === resetId);
  try {
    await fetch(`/subscriber/customers/${resetId}/status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ action: 'reset_password' })
    });
    closeModal('resetModal');
    showToast('🔐', `New password sent to ${u.email}`);
  } catch (e) {
    showToast('⚠️', 'Error sending reset password link');
  }
}

function openSuspendModal(id) {
  const u = users.find(x => x.id === id);
  suspendId = id;
  document.getElementById('suspendTitle').textContent = 'Suspend User?';
  document.getElementById('suspendMsg').textContent = `${u.firstName} ${u.lastName} will be suspended and immediately lose access until reactivated.`;
  openModal('suspendModal');
}

async function confirmSuspend() {
  const u = users.find(x => x.id === suspendId);
  try {
    const res = await fetch(`/subscriber/customers/${suspendId}/status`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ action: 'suspend' })
    });
    const data = await res.json();
    if (data.success) {
      u.status = 'inactive';
      closeModal('suspendModal');
      renderTable();
      showToast('🚫', `${u.firstName} ${u.lastName} is now Inactive`);
    }
  } catch (e) {
    showToast('⚠️', 'Error suspending user');
  }
}

function openDeleteModal(id) {
  const u = users.find(x => x.id === id);
  deletingId = id;
  document.getElementById('deleteMsg').textContent = `${u.firstName} ${u.lastName} (${u.email}) will be permanently removed. This action cannot be undone.`;
  openModal('deleteModal');
}

async function confirmDelete() {
  const u = users.find(x => x.id === deletingId);
  try {
    const res = await fetch(`/subscriber/customers/${deletingId}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    });
    const data = await res.json();
    if (data.success) {
      users = users.filter(x => x.id !== deletingId);
      closeModal('deleteModal');
      renderTable();
      showToast('🗑️', `${u.firstName} ${u.lastName} has been deleted`);
    }
  } catch (e) {
    showToast('⚠️', 'Error deleting user');
  }
}

// ─── EXPORT ───────────────────────────────────────────────
function exportUsers() {
  const rows = [
    ['User ID', 'First Name', 'Last Name', 'Email', 'Type', 'Role', 'Status', 'Client ID', 'Client Name', 'Last Active', '2FA']
  ];
  getFiltered().forEach(u => {
    rows.push([
      u.userId, u.firstName, u.lastName, u.email, u.type, u.role, u.status,
      u.clientId || '', u.clientName || '', u.lastActive || '', u.twoFA ? 'Yes' : 'No'
    ]);
  });
  const csv = rows.map(r => r.map(c => `"${String(c||'').replace(/"/g,'""')}"`).join(',')).join('\n');
  const a = document.createElement('a');
  a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
  a.download = 'velo-users.csv';
  a.click();
  showToast('⬇️', 'Exporting users to CSV…');
}

function toggleSelectAll(el) {
  document.querySelectorAll('.row-check').forEach(cb => cb.checked = el.checked);
}

// ─── SORT ─────────────────────────────────────────────────
let sortState = { field: null, dir: 1 };

const sortKeys = {
  userId:     u => u.userId || '',
  name:       u => `${u.firstName} ${u.lastName}`.toLowerCase(),
  type:       u => u.type,
  role:       u => u.role,
  status:     u => { const order = { subscriber:0, active:1, pending:2, new:3, inactive:4 }; return order[u.status] ?? 9; },
  client:     u => (u.clientName || '').toLowerCase(),
  lastActive: u => u.lastActive.toLowerCase(),
};

function sortTable(field) {
  if (sortState.field === field) {
    sortState.dir *= -1;
  } else {
    sortState.field = field;
    sortState.dir = 1;
  }

  const subscriber = users.filter(u => u.isSubscriber);
  const rest = users.filter(u => !u.isSubscriber);
  const keyFn = sortKeys[field] || (u => '');
  rest.sort((a, b) => {
    const va = keyFn(a), vb = keyFn(b);
    if (typeof va === 'number') return (va - vb) * sortState.dir;
    return va.localeCompare(vb) * sortState.dir;
  });
  users = [...subscriber, ...rest];

  updateSortHeaders();
  renderTable();
}

function updateSortHeaders() {
  document.querySelectorAll('th.sortable').forEach(th => {
    th.classList.remove('sort-asc', 'sort-desc');
  });
  if (!sortState.field) return;
  const th = document.getElementById(`th-${sortState.field}`);
  if (th) th.classList.add(sortState.dir === 1 ? 'sort-asc' : 'sort-desc');
}

function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', e => {
    if (e.target === overlay) overlay.classList.remove('open');
  });
});

function showToast(icon, msg) {
  const c = document.getElementById('toastContainer');
  const t = document.createElement('div');
  t.className = 'toast';
  t.innerHTML = `<span class="toast-icon">${icon}</span><span>${msg}</span>`;
  c.appendChild(t);
  setTimeout(() => {
    t.classList.add('fade-out');
    setTimeout(() => t.remove(), 300);
  }, 2600);
}

// ─── IMPORT ───────────────────────────────────────────────
let importStep = 1;
let importRows = [];
let importValid = [];

function openImportModal() {
  importStep = 1;
  importRows = [];
  importValid = [];
  document.getElementById('importFileName').textContent = '';
  document.getElementById('importFileInput').value = '';
  document.getElementById('importDropZone').className = 'import-drop-zone';
  document.getElementById('importStep1').style.display = '';
  document.getElementById('importStep2').style.display = 'none';
  document.getElementById('importStep3').style.display = 'none';
  document.getElementById('importNextBtn').disabled = true;
  document.getElementById('importNextBtn').textContent = 'Next →';
  document.getElementById('importBackBtn').style.display = 'none';
  setImportStep(1);
  openModal('importModal');
}

function closeImportModal() { closeModal('importModal'); }

function setImportStep(n) {
  importStep = n;
  [1,2,3].forEach(i => {
    const el = document.getElementById('istep' + i);
    el.classList.remove('active','done');
    if (i < n)      el.classList.add('done');
    else if (i === n) el.classList.add('active');
  });
  document.getElementById('importBackBtn').style.display = n > 1 ? '' : 'none';
  if (n === 3) {
    document.getElementById('importNextBtn').textContent = '✅ Import Users';
  } else {
    document.getElementById('importNextBtn').textContent = 'Next →';
  }
}

function importNext() {
  if (importStep === 1) {
    if (!importRows.length) return;
    buildPreview();
    document.getElementById('importStep1').style.display = 'none';
    document.getElementById('importStep2').style.display = '';
    document.getElementById('importNextBtn').disabled = importValid.filter(r=>r._status==='err').length === importValid.length;
    setImportStep(2);
  } else if (importStep === 2) {
    buildConfirm();
    document.getElementById('importStep2').style.display = 'none';
    document.getElementById('importStep3').style.display = '';
    document.getElementById('importNextBtn').disabled = false;
    setImportStep(3);
  } else if (importStep === 3) {
    commitImport();
  }
}

function importGoBack() {
  if (importStep === 2) {
    document.getElementById('importStep2').style.display = 'none';
    document.getElementById('importStep1').style.display = '';
    document.getElementById('importNextBtn').disabled = false;
    setImportStep(1);
  } else if (importStep === 3) {
    document.getElementById('importStep3').style.display = 'none';
    document.getElementById('importStep2').style.display = '';
    setImportStep(2);
  }
}

function handleFileDrop(e) {
  e.preventDefault();
  document.getElementById('importDropZone').classList.remove('drag-over');
  const file = e.dataTransfer.files[0];
  if (file) processImportFile(file);
}

function handleFileSelect(e) {
  const file = e.target.files[0];
  if (file) processImportFile(file);
}

function processImportFile(file) {
  if (!file.name.endsWith('.csv')) { showToast('⚠️','Please upload a .csv file'); return; }
  const reader = new FileReader();
  reader.onload = (e) => {
    const text = e.target.result;
    importRows = parseCSV(text);
    if (importRows.length < 2) { showToast('⚠️','CSV appears empty or invalid'); return; }
    document.getElementById('importDropZone').classList.add('has-file');
    document.getElementById('importFileName').textContent = `✅  ${file.name}  (${importRows.length - 1} row${importRows.length-1!==1?'s':''} found)`;
    document.getElementById('importNextBtn').disabled = false;
  };
  reader.readAsText(file);
}

function parseCSV(text) {
  return text.trim().split('\n').map(line =>
    line.split(',').map(c => c.trim().replace(/^"|"$/g,''))
  );
}

function buildPreview() {
  const headers = importRows[0].map(h => h.toLowerCase().trim());
  const col = name => headers.indexOf(name);
  const avatarColors = ['av-teal','av-amber','av-purple','av-blue','av-rose','av-green','av-slate'];

  const usedIds = new Set(users.map(u => u.userId));
  let autoSeed = parseInt(nextUserIdSeed);

  importValid = importRows.slice(1).map((row, i) => {
    const get = name => (row[col(name)] || '').trim();
    const errors = [];
    const warns  = [];

    const firstName = get('first_name');
    const lastName  = get('last_name');
    const email     = get('email');
    const type      = get('type').toLowerCase();
    const role      = get('role');

    if (!firstName) errors.push('Missing first_name');
    if (!lastName)  errors.push('Missing last_name');
    if (!email || !email.includes('@')) errors.push('Invalid email');
    if (!['internal','client'].includes(type)) errors.push('type must be internal or client');

    let userId = get('user_id');
    if (!userId) {
      if (USER_ID_AUTO_GENERATE) {
        userId = String(autoSeed).padStart(10,'0');
        autoSeed++;
      } else {
        errors.push('user_id required');
      }
    } else if (!/^\d{10}$/.test(userId)) {
      errors.push('user_id must be 10 digits');
    } else if (usedIds.has(userId)) {
      errors.push(`User ID ${userId} already exists`);
    } else {
      usedIds.add(userId);
    }

    const clientId   = get('client_id')   || undefined;
    const clientName = get('client_name') || undefined;
    if (type === 'client' && !clientId) warns.push('No client_id for client user');

    const rowStatus = errors.length ? 'err' : warns.length ? 'warn' : 'ok';
    const avClass   = avatarColors[(nextId + i) % avatarColors.length];
    const avatar    = ((firstName[0]||'?') + (lastName[0]||'?')).toUpperCase();

    return { userId, firstName, lastName, email, type, role: role || (type==='client'?'Client':'Staff'),
             clientId, clientName, errors, warns, _status: rowStatus, avClass, avatar };
  });

  const total = importValid.length;
  const ok    = importValid.filter(r=>r._status==='ok').length;
  const warn  = importValid.filter(r=>r._status==='warn').length;
  const err   = importValid.filter(r=>r._status==='err').length;

  document.getElementById('importSummary').innerHTML = `
    <div class="import-stat ok"><div class="import-stat-num">${ok}</div><div class="import-stat-label">Ready</div></div>
    <div class="import-stat warn"><div class="import-stat-num">${warn}</div><div class="import-stat-label">Warnings</div></div>
    <div class="import-stat err"><div class="import-stat-num">${err}</div><div class="import-stat-label">Errors</div></div>
    <div class="import-stat"><div class="import-stat-num">${total}</div><div class="import-stat-label">Total Rows</div></div>
  `;

  const table = document.getElementById('importPreviewTable');
  table.innerHTML = `
    <thead><tr>
      <th>#</th><th>User ID</th><th>First Name</th><th>Last Name</th>
      <th>Email</th><th>Type</th><th>Role</th><th>Client ID</th><th>Issues</th>
    </tr></thead>
    <tbody>
      ${importValid.map((r,i)=>`
        <tr class="row-${r._status}">
          <td>${i+1}</td>
          <td style="font-family:monospace;font-weight:600;">${r.userId||'—'}</td>
          <td>${escHtml(r.firstName)}</td>
          <td>${escHtml(r.lastName)}</td>
          <td>${escHtml(r.email)}</td>
          <td>${r.type==='internal'?'INT':'CL'}</td>
          <td>${escHtml(r.role)}</td>
          <td>${r.clientId||'—'}</td>
          <td>
            ${r.errors.map(e=>`<div class="import-row-status irs-err">✗ ${escHtml(e)}</div>`).join('')}
            ${r.warns.map(w=>`<div class="import-row-status irs-warn">⚠ ${escHtml(w)}</div>`).join('')}
            ${!r.errors.length && !r.warns.length ? '<span class="import-row-status irs-ok">✓ OK</span>' : ''}
          </td>
        </tr>
      `).join('')}
    </tbody>
  `;
}

function buildConfirm() {
  const ok   = importValid.filter(r=>r._status!=='err');
  const err  = importValid.filter(r=>r._status==='err');
  const box  = document.getElementById('importConfirmBox');
  box.className = 'import-confirm-box' + (err.length ? ' has-errors' : '');
  box.innerHTML = `
    <div style="font-family:'Syne',sans-serif;font-size:1rem;font-weight:800;color:var(--slate);margin-bottom:10px;">
      ${err.length ? '⚠️ Import with warnings' : '✅ Ready to import'}
    </div>
    <div><strong>${ok.length}</strong> user${ok.length!==1?'s':''} will be imported with status <strong>New</strong>.</div>
    ${err.length ? `<div style="color:var(--red-soft);margin-top:6px;"><strong>${err.length}</strong> row${err.length!==1?'s':''} with errors will be <strong>skipped</strong>.</div>` : ''}
    <div style="margin-top:10px;font-size:0.8rem;color:var(--muted);">All imported users will have status <strong>New</strong> and must be invited before they can log in.</div>
  `;
}

async function commitImport() {
  const toImport = importValid.filter(r => r._status !== 'err');
  try {
    const res = await fetch('/subscriber/customers/import', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      },
      body: JSON.stringify({ rows: toImport })
    });
    const data = await res.json();
    if (data.success && data.imported) {
      data.imported.forEach(u => users.push(u));
      closeImportModal();
      renderTable();
      showToast('✅', `${data.imported.length} users imported successfully`);
    } else {
      showToast('⚠️', data.message || 'Error during import');
    }
  } catch (e) {
    showToast('⚠️', 'Network error during import');
  }
}

function downloadTemplate() {
  const csv = 'first_name,last_name,email,type,role,user_id,client_id,client_name\nJane,Smith,jane@example.com,internal,Staff,,\nAcme,Contact,contact@acme.com,client,Client,,CLT-0004,Acme Corp\n';
  const a = document.createElement('a');
  a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
  a.download = 'billflow_users_template.csv';
  a.click();
  showToast('⬇️', 'CSV template downloaded');
}

function capitalize(str) { return str.charAt(0).toUpperCase() + str.slice(1); }

// ─── INIT ─────────────────────────────────────────────────
renderTable();
</script>

<script>
function toggleDesktopSidebar() {
  if (window.matchMedia('(max-width: 960px)').matches) {
    toggleSidebar();
    return;
  }
  const collapsed = document.body.classList.toggle('sidebar-collapsed');
  document.querySelectorAll('.sidebar-toggle-btn').forEach(btn => btn.setAttribute('aria-expanded', String(!collapsed)));
}

function toggleSidebar() {
  if (window.matchMedia('(max-width: 960px)').matches) {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    if (sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      overlay.classList.remove('visible');
    } else {
      sidebar.classList.add('open');
      overlay.classList.add('visible');
    }
  } else {
    const collapsed = document.body.classList.toggle('sidebar-collapsed');
    document.querySelectorAll('.sidebar-toggle-btn').forEach(btn => btn.setAttribute('aria-expanded', String(!collapsed)));
  }
}

function closeSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  if (sidebar) sidebar.classList.remove('open');
  if (overlay) overlay.classList.remove('visible');
}
</script>
</body>
</html>
