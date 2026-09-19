@include('subscriber.includes.header')
<style>
    .step-progress {
        display: flex;
        flex-direction: column;
        gap: 3px;
        margin-bottom: 24px;
    }

    .step-item {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 8px 10px;
        border-radius: 9px;
    }

    .step-item.done {
        opacity: 0.48;
    }

    .step-item.active {
        background: rgba(0, 184, 153, 0.12);
    }

    .step-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.68rem;
        font-weight: 700;
        flex-shrink: 0;
        border: 2px solid rgba(255, 255, 255, 0.14);
        color: rgba(255, 255, 255, 0.32);
    }

    .step-item.done .step-num {
        background: var(--teal);
        border-color: var(--teal);
        color: white;
    }

    .step-item.active .step-num {
        background: var(--teal);
        border-color: var(--teal);
        color: white;
        box-shadow: 0 0 0 4px rgba(0, 184, 153, 0.22);
    }

    .step-label strong {
        display: block;
        color: rgba(255, 255, 255, 0.82);
        font-weight: 600;
        font-size: 0.78rem;
        line-height: 1.2;
    }

    .step-label span {
        color: rgba(255, 255, 255, 0.3);
        font-size: 0.7rem;
    }

    .nav-title {
        font-size: 0.62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .13em;
        color: rgba(255, 255, 255, 0.26);
        padding: 0 10px;
        margin-bottom: 3px;
        margin-top: 2px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 7px 10px;
        border-radius: 7px;
        font-size: 0.79rem;
        color: rgba(255, 255, 255, 0.4);
        text-decoration: none;
        cursor: pointer;
        transition: all .16s;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.06);
        color: rgba(255, 255, 255, 0.7);
    }

    .nav-link.active {
        background: rgba(0, 184, 153, 0.15);
        color: var(--teal);
        font-weight: 600;
    }

    .nav-icon {
        font-size: 0.9rem;
        width: 17px;
        text-align: center;
        flex-shrink: 0;
    }

    .nav-badge {
        margin-left: auto;
        font-size: 0.56rem;
        font-weight: 700;
        background: var(--amber);
        color: var(--slate);
        padding: 1px 5px;
        border-radius: 99px;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .left-footer {
        margin-top: auto;
        padding-top: 18px;
    }

    .left-footer-text {
        font-size: 0.69rem;
        color: rgba(255, 255, 255, 0.2);
        line-height: 1.5;
    }

    /* RIGHT PANEL */
    .right-panel {
        flex: 1;
        background: var(--paper);
        overflow-y: auto;
        position: relative;
    }

    .right-panel::before {
        content: '';
        position: fixed;
        top: 0;
        left: 300px;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--teal), var(--amber), var(--teal));
        background-size: 200% 100%;
        animation: shimmer 3s linear infinite;
        z-index: 100;
    }

    @keyframes shimmer {
        0% {
            background-position: 0% 0%;
        }

        100% {
            background-position: 200% 0%;
        }
    }

    .page-header {
        padding: 28px 46px 20px;
        border-bottom: 1px solid var(--border);
        background: var(--paper);
        position: sticky;
        top: 0;
        z-index: 50;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .page-eyebrow {
        font-size: 0.66rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: var(--teal);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 3px;
    }

    .page-eyebrow::before {
        content: '';
        width: 16px;
        height: 2px;
        background: var(--teal);
    }

    .page-header h1 {
        font-family: 'Syne', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.04em;
        color: var(--slate);
        line-height: 1.1;
    }

    .page-header p {
        font-size: 0.83rem;
        color: var(--muted);
        margin-top: 3px;
    }

    .header-actions {
        display: flex;
        gap: 9px;
        align-items: center;
        flex-shrink: 0;
    }

    .btn-skip {
        padding: 8px 17px;
        border-radius: 99px;
        border: 1.5px solid var(--border);
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.81rem;
        color: var(--muted);
        cursor: pointer;
        transition: all .2s;
        white-space: nowrap;
    }

    .btn-skip:hover {
        border-color: var(--muted);
        color: var(--slate);
    }

    .btn-save {
        padding: 8px 20px;
        border-radius: 99px;
        border: none;
        background: var(--teal);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.81rem;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-save:hover {
        background: var(--teal-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(0, 184, 153, 0.35);
    }

    .progress-strip {
        padding: 12px 46px;
        background: var(--cream);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .progress-label {
        font-size: 0.73rem;
        color: var(--muted);
        white-space: nowrap;
    }

    .progress-bar-wrap {
        flex: 1;
        height: 6px;
        background: var(--border);
        border-radius: 99px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(90deg, var(--teal), #00d4b8);
        transition: width .4s cubic-bezier(.34, 1.56, .64, 1);
    }

    .progress-pct {
        font-size: 0.73rem;
        font-weight: 700;
        color: var(--teal);
        white-space: nowrap;
    }

    .page-body {
        padding: 28px 46px 100px;
        max-width: 880px;
    }

    /* Section cards */
    .pref-section {
        background: var(--card);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        margin-bottom: 16px;
        overflow: hidden;
        animation: fadeUp .38s cubic-bezier(.22, 1, .36, 1) both;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(13px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .section-header {
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        border-bottom: 1px solid transparent;
        transition: background .14s;
        gap: 12px;
    }

    .section-header:hover {
        background: #fafaf8;
    }

    .section-header.open {
        border-bottom-color: var(--border);
    }

    .section-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .section-title {
        font-family: 'Syne', sans-serif;
        font-weight: 700;
        font-size: 0.91rem;
        color: var(--slate);
        letter-spacing: -0.02em;
    }

    .section-subtitle {
        font-size: 0.75rem;
        color: var(--muted);
        margin-top: 1px;
    }

    .section-header-right {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .section-status {
        font-size: 0.67rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        padding: 2px 9px;
        border-radius: 99px;
    }

    .status-default {
        background: var(--cream);
        color: var(--muted);
    }

    .status-configured {
        background: var(--teal-pale);
        color: var(--teal-dark);
    }

    .chevron {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted-light);
        font-size: 0.73rem;
        transition: transform .25s cubic-bezier(.34, 1.56, .64, 1);
    }

    .chevron.open {
        transform: rotate(180deg);
    }

    .section-body {
        padding: 20px;
        display: none;
        grid-template-columns: 1fr 1fr;
        gap: 16px 24px;
    }

    .section-body.open {
        display: grid;
    }

    .section-body.single-col {
        grid-template-columns: 1fr;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--slate);
    }

    .field-hint {
        font-size: 0.7rem;
        color: var(--muted-light);
        margin-top: 1px;
    }

    .field-full {
        grid-column: 1 / -1;
    }

    .select-wrap {
        position: relative;
    }

    .select-wrap::after {
        content: '▾';
        position: absolute;
        right: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
        font-size: 0.78rem;
    }

    select,
    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 8px 13px;
        border-radius: var(--radius-sm);
        border: 1.5px solid var(--border);
        background: var(--input-bg);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.83rem;
        color: var(--slate);
        appearance: none;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    select {
        padding-right: 30px;
        cursor: pointer;
    }

    select:focus,
    input:focus {
        border-color: var(--border-focus);
        box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.11);
    }

    .toggle-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .toggle-row-label {
        font-size: 0.83rem;
        font-weight: 500;
        color: var(--slate);
    }

    .toggle-row-desc {
        font-size: 0.74rem;
        color: var(--muted);
        margin-top: 2px;
    }

    .toggle {
        position: relative;
        width: 40px;
        height: 22px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        inset: 0;
        background: var(--border);
        border-radius: 99px;
        cursor: pointer;
        transition: background .2s;
    }

    .toggle-slider::before {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        left: 3px;
        top: 3px;
        background: white;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.14);
        transition: transform .2s cubic-bezier(.34, 1.56, .64, 1);
    }

    .toggle input:checked+.toggle-slider {
        background: var(--teal);
    }

    .toggle input:checked+.toggle-slider::before {
        transform: translateX(18px);
    }

    .chip-group {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .chip {
        padding: 5px 12px;
        border-radius: 99px;
        border: 1.5px solid var(--border);
        background: var(--input-bg);
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--muted);
        cursor: pointer;
        transition: all .16s;
        user-select: none;
    }

    .chip:hover {
        border-color: var(--teal);
        color: var(--teal);
    }

    .chip.active {
        border-color: var(--teal);
        background: var(--teal-pale);
        color: var(--teal-dark);
        font-weight: 600;
    }

    .color-swatches {
        display: flex;
        gap: 7px;
        align-items: center;
        flex-wrap: wrap;
    }

    .swatch {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        cursor: pointer;
        border: 2.5px solid transparent;
        transition: transform .14s;
        position: relative;
    }

    .swatch:hover {
        transform: scale(1.15);
    }

    .swatch.active {
        border-color: var(--slate);
        transform: scale(1.1);
    }

    .swatch.active::after {
        content: '✓';
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        color: white;
        font-weight: 800;
    }

    .stepper-wrap {
        display: flex;
        align-items: center;
    }

    .stepper-wrap input[type="number"] {
        width: 68px;
        text-align: center;
        border-radius: 0;
        border-left: none;
        border-right: none;
    }

    .stepper-btn {
        width: 34px;
        height: 36px;
        border: 1.5px solid var(--border);
        background: var(--input-bg);
        cursor: pointer;
        font-size: 0.95rem;
        color: var(--muted);
        transition: all .14s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stepper-btn:first-child {
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
    }

    .stepper-btn:last-child {
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }

    .stepper-btn:hover {
        background: var(--teal-pale);
        color: var(--teal);
        border-color: var(--teal);
    }

    .notif-grid {
        border: 1px solid var(--border);
        border-radius: 9px;
        overflow: hidden;
        background: var(--input-bg);
    }

    .notif-row-header {
        display: grid;
        grid-template-columns: 1fr repeat(3, 46px);
        gap: 6px;
        padding: 6px 11px;
    }

    .notif-row {
        display: grid;
        grid-template-columns: 1fr repeat(3, 46px);
        align-items: center;
        gap: 6px;
        padding: 8px 11px;
        border-top: 1px solid var(--border);
        transition: background .14s;
    }

    .notif-row:hover {
        background: var(--cream);
    }

    .notif-event {
        font-size: 0.8rem;
        color: var(--slate);
    }

    .notif-ch-label {
        font-size: 0.64rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: var(--muted);
        text-align: center;
    }

    .notif-check {
        display: flex;
        justify-content: center;
    }

    .custom-check {
        width: 17px;
        height: 17px;
        border-radius: 4px;
        border: 2px solid var(--border);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .14s;
        flex-shrink: 0;
    }

    .custom-check.checked {
        background: var(--teal);
        border-color: var(--teal);
        color: white;
    }

    .custom-check.checked::after {
        content: '✓';
        font-size: 0.6rem;
        font-weight: 800;
    }

    /* Icon color accents */
    .icon-banking {
        background: #EBF8F5;
    }

    .icon-clients {
        background: #FFF5EB;
    }

    .icon-documents {
        background: #F0EBFF;
    }

    .icon-integrations {
        background: #EBF0FF;
    }

    .icon-invoices {
        background: #EBF4FF;
    }

    .icon-items {
        background: #EBFFFC;
    }

    .icon-notifications {
        background: #FFFAEB;
    }

    .icon-payments {
        background: #EBFFF5;
    }

    .icon-projects {
        background: #F5EBFF;
    }

    .icon-reports {
        background: #FFF0EB;
    }

    .icon-repository {
        background: #F5FFEB;
    }

    .save-footer {
        position: fixed;
        bottom: 0;
        left: 300px;
        right: 0;
        padding: 14px 46px;
        background: linear-gradient(transparent, var(--paper) 40%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        pointer-events: none;
    }

    .save-footer>* {
        pointer-events: auto;
    }

    .save-footer-left {
        font-size: 0.78rem;
        color: var(--muted);
    }

    .save-footer-left strong {
        color: var(--slate);
    }

    .btn-continue {
        padding: 11px 24px;
        border-radius: 99px;
        border: none;
        background: var(--slate);
        font-family: 'DM Sans', sans-serif;
        font-size: 0.86rem;
        font-weight: 600;
        color: white;
        cursor: pointer;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 18px rgba(30, 42, 56, 0.32);
    }

    .btn-continue:hover {
        background: var(--teal);
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(0, 184, 153, 0.38);
    }

    .toast {
        position: fixed;
        bottom: 74px;
        left: 50%;
        transform: translateX(-50%) translateY(18px);
        background: var(--slate);
        color: white;
        padding: 9px 18px;
        border-radius: 99px;
        font-size: 0.81rem;
        font-weight: 500;
        box-shadow: var(--shadow-md);
        opacity: 0;
        transition: all .28s;
        pointer-events: none;
        z-index: 999;
        white-space: nowrap;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 900px) {
        .left-panel {
            display: none;
        }

        .right-panel::before {
            left: 0;
        }

        .save-footer {
            left: 0;
        }

        .page-header,
        .progress-strip,
        .page-body {
            padding-left: 18px;
            padding-right: 18px;
        }

        .section-body {
            grid-template-columns: 1fr !important;
        }
    }
</style>


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
        </div>

    </header>

    <!-- ═══════════════════════ RIGHT PANEL ═══════════════════════ -->
    <main class="right-panel" id="mainPanel">

        <div class="page-header">
            <div>
                <div class="page-eyebrow">Step 3 of 4</div>
                <h1>Defaults &amp; Preferences</h1>
                <p>Configure how Billflow behaves across all workflows. You can update these anytime.</p>
            </div>
            <div class="header-actions">
                <button class="btn-skip" onclick="showToast('Preferences skipped — using defaults.')">Skip for
                    now</button>
                <button class="btn-save" onclick="saveAll()"><span>Save changes</span> <span>✓</span></button>
            </div>
        </div>

        <div class="progress-strip">
            <span class="progress-label">Sections configured</span>
            <div class="progress-bar-wrap">
                <div class="progress-bar-fill" id="progressFill" style="width:0%"></div>
            </div>
            <span class="progress-pct" id="progressPct">0 / 11</span>
        </div>

        <div class="page-body">

            <!-- ══ 1. BANKING ══ -->
            <div class="pref-section" id="banking" style="animation-delay:.04s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-banking">🏦</div>
                        <div>
                            <div class="section-title">Banking</div>
                            <div class="section-subtitle">Default accounts, currency &amp; reconciliation</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-banking">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field"><label class="field-label">Default Currency</label>
                        <div class="select-wrap"><select onchange="markConfigured('banking')">
                                <option>USD — US Dollar</option>
                                <option>EUR — Euro</option>
                                <option>GBP — British Pound</option>
                                <option>CAD — Canadian Dollar</option>
                                <option>AUD — Australian Dollar</option>
                                <option>JPY — Japanese Yen</option>
                                <option>NGN — Nigerian Naira</option>
                                <option>ZAR — South African Rand</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Primary Bank Account</label>
                        <div class="select-wrap"><select onchange="markConfigured('banking')">
                                <option>— Connect a bank account —</option>
                                <option>Chase Business Checking ···4821</option>
                                <option>Bank of America ···2903</option>
                            </select></div><span class="field-hint">Used for payment receipt and reconciliation.</span>
                    </div>
                    <div class="field"><label class="field-label">Fiscal Year Start</label>
                        <div class="select-wrap"><select>
                                <option>January</option>
                                <option>February</option>
                                <option>March</option>
                                <option>April</option>
                                <option>May</option>
                                <option>June</option>
                                <option>July</option>
                                <option>August</option>
                                <option>September</option>
                                <option>October</option>
                                <option>November</option>
                                <option>December</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Default Tax Rate (%)</label>
                        <div class="stepper-wrap"><button class="stepper-btn"
                                onclick="stepVal('taxRate',-1)">−</button><input type="number" id="taxRate"
                                value="10" min="0" max="100"><button class="stepper-btn"
                                onclick="stepVal('taxRate',1)">+</button></div>
                    </div>
                    <div class="field field-full"><label class="field-label">Auto-reconciliation</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Automatically match transactions to invoices</div>
                                <div class="toggle-row-desc">Billflow suggests matches when amount &amp; date align with
                                    an open invoice.</div>
                            </div><label class="toggle"><input type="checkbox" checked>
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field field-full"><label class="field-label">Bank Feed Sync Frequency</label>
                        <div class="chip-group">
                            <div class="chip" onclick="selectChip(this,'bank-sync')">Real-time</div>
                            <div class="chip active" onclick="selectChip(this,'bank-sync')">Hourly</div>
                            <div class="chip" onclick="selectChip(this,'bank-sync')">Daily</div>
                            <div class="chip" onclick="selectChip(this,'bank-sync')">Manual</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══ 2. CUSTOMERS / CLIENTS ══ -->
            <div class="pref-section" id="clients" style="animation-delay:.07s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-clients">👤</div>
                        <div>
                            <div class="section-title">Customers / Clients</div>
                            <div class="section-subtitle">Default fields, ID format &amp; communication preferences
                            </div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-clients">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field"><label class="field-label">Client ID Format</label>
                        <div class="select-wrap"><select onchange="markConfigured('clients')">
                                <option>Auto-increment (CLT-0001)</option>
                                <option>Name-based (SMITH-01)</option>
                                <option>Custom prefix + number</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Default Credit Limit</label>
                        <div class="select-wrap"><select>
                                <option>No credit limit</option>
                                <option>$500</option>
                                <option>$1,000</option>
                                <option selected>$5,000</option>
                                <option>$10,000</option>
                                <option>$25,000</option>
                            </select></div>
                    </div>
                    <div class="field field-full"><label class="field-label">Required Client Fields</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="toggleChip(this)">Company Name</div>
                            <div class="chip active" onclick="toggleChip(this)">Email</div>
                            <div class="chip active" onclick="toggleChip(this)">Phone</div>
                            <div class="chip" onclick="toggleChip(this)">Tax ID / VAT</div>
                            <div class="chip" onclick="toggleChip(this)">Billing Address</div>
                            <div class="chip" onclick="toggleChip(this)">Website</div>
                            <div class="chip" onclick="toggleChip(this)">Industry</div>
                        </div><span class="field-hint">Fields that must be filled when adding a new client.</span>
                    </div>
                    <div class="field"><label class="field-label">Client Portal Access</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Enable self-service client portal</div>
                                <div class="toggle-row-desc">Clients can view invoices &amp; pay online.</div>
                            </div><label class="toggle"><input type="checkbox" checked
                                    onchange="markConfigured('clients')">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Auto-archive Inactive Clients</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Archive after period of inactivity</div>
                            </div><label class="toggle"><input type="checkbox">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Inactivity Threshold</label>
                        <div class="select-wrap"><select>
                                <option>3 months</option>
                                <option selected>6 months</option>
                                <option>12 months</option>
                                <option>24 months</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Default Communication Language</label>
                        <div class="select-wrap"><select>
                                <option>English</option>
                                <option>French</option>
                                <option>Spanish</option>
                                <option>Portuguese</option>
                                <option>Arabic</option>
                                <option>German</option>
                            </select></div>
                    </div>
                </div>
            </div>

            <!-- ══ 3. DOCUMENTS ══ -->
            <div class="pref-section" id="documents" style="animation-delay:.10s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-documents">🗂</div>
                        <div>
                            <div class="section-title">Documents</div>
                            <div class="section-subtitle">Storage, naming conventions &amp; access controls</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-documents">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field"><label class="field-label">Default Document Format</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'doc-fmt')">PDF</div>
                            <div class="chip" onclick="selectChip(this,'doc-fmt')">DOCX</div>
                            <div class="chip" onclick="selectChip(this,'doc-fmt')">HTML</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">File Naming Convention</label>
                        <div class="select-wrap"><select onchange="markConfigured('documents')">
                                <option>Type_ClientName_Date</option>
                                <option>Number_ClientName</option>
                                <option>Date_Type_Number</option>
                                <option>Custom</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Document Retention Period</label>
                        <div class="select-wrap"><select>
                                <option>1 year</option>
                                <option>3 years</option>
                                <option selected>7 years</option>
                                <option>10 years</option>
                                <option>Indefinitely</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Default Access Level</label>
                        <div class="select-wrap"><select>
                                <option selected>Private (owner only)</option>
                                <option>Team (all members)</option>
                                <option>Client-visible</option>
                                <option>Public link</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">E-signature Required</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Require e-signature on contracts</div>
                                <div class="toggle-row-desc">Documents marked "Contract" need sign-off before
                                    archiving.</div>
                            </div><label class="toggle"><input type="checkbox" checked
                                    onchange="markConfigured('documents')">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Version History</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Keep version history on edited documents</div>
                                <div class="toggle-row-desc">Retains up to 20 previous versions per file.</div>
                            </div><label class="toggle"><input type="checkbox" checked>
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Cloud Storage Integration</label>
                        <div class="select-wrap"><select>
                                <option selected>Billflow Cloud (default)</option>
                                <option>Google Drive</option>
                                <option>Dropbox</option>
                                <option>OneDrive</option>
                                <option>AWS S3</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Auto-attach PDF to Emails</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Attach PDF when sending via email</div>
                            </div><label class="toggle"><input type="checkbox" checked>
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══ 4. INTEGRATIONS (NEW) ══ -->
            <div class="pref-section" id="integrations" style="animation-delay:.13s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-integrations">🔗</div>
                        <div>
                            <div class="section-title">Integrations</div>
                            <div class="section-subtitle">Third-party apps, API access &amp; data sync settings</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-integrations">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field field-full"><label class="field-label">Connected Apps</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="toggleChip(this)">Stripe</div>
                            <div class="chip" onclick="toggleChip(this)">QuickBooks</div>
                            <div class="chip" onclick="toggleChip(this)">Xero</div>
                            <div class="chip" onclick="toggleChip(this)">Slack</div>
                            <div class="chip" onclick="toggleChip(this)">HubSpot</div>
                            <div class="chip" onclick="toggleChip(this)">Salesforce</div>
                            <div class="chip" onclick="toggleChip(this)">Zapier</div>
                            <div class="chip" onclick="toggleChip(this)">Google Workspace</div>
                            <div class="chip" onclick="toggleChip(this)">Microsoft 365</div>
                            <div class="chip" onclick="toggleChip(this)">Shopify</div>
                        </div><span class="field-hint">Toggle apps to enable. Full setup happens in Settings →
                            Integrations.</span>
                    </div>
                    <div class="field"><label class="field-label">Accounting Software Sync</label>
                        <div class="select-wrap"><select onchange="markConfigured('integrations')">
                                <option selected>None (Billflow standalone)</option>
                                <option>QuickBooks Online</option>
                                <option>Xero</option>
                                <option>FreshBooks</option>
                                <option>Wave Accounting</option>
                                <option>Sage</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Sync Direction</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'sync-dir')">Billflow → Accounting</div>
                            <div class="chip" onclick="selectChip(this,'sync-dir')">Two-way sync</div>
                            <div class="chip" onclick="selectChip(this,'sync-dir')">Accounting → Billflow</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Sync Frequency</label>
                        <div class="select-wrap"><select>
                                <option>Real-time</option>
                                <option selected>Every 15 minutes</option>
                                <option>Hourly</option>
                                <option>Daily</option>
                                <option>Manual only</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">REST API Access</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Enable REST API for this workspace</div>
                                <div class="toggle-row-desc">Allows external tools to read/write data via API key.
                                </div>
                            </div><label class="toggle"><input type="checkbox" checked
                                    onchange="markConfigured('integrations')">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Webhook Events</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Send webhook on key events</div>
                                <div class="toggle-row-desc">POST to your URL on invoice paid, payment failed, etc.
                                </div>
                            </div><label class="toggle"><input type="checkbox">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">OAuth App Permissions</label>
                        <div class="select-wrap"><select>
                                <option selected>Read only</option>
                                <option>Read + Write</option>
                                <option>Full access (admin)</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Data Export Format</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'int-export')">JSON</div>
                            <div class="chip" onclick="selectChip(this,'int-export')">CSV</div>
                            <div class="chip" onclick="selectChip(this,'int-export')">XML</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Auto-sync on Import</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Trigger sync when new data is imported</div>
                            </div><label class="toggle"><input type="checkbox">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Integration Error Alerts</label>
                        <div class="select-wrap"><select>
                                <option selected>Email + In-app</option>
                                <option>In-app only</option>
                                <option>Email only</option>
                                <option>None</option>
                            </select></div>
                    </div>
                </div>
            </div>

            <!-- ══ 5. INVOICES & QUOTES ══ -->
            <div class="pref-section" id="invoices" style="animation-delay:.16s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-invoices">📄</div>
                        <div>
                            <div class="section-title">Invoices &amp; Quotes</div>
                            <div class="section-subtitle">Numbering, due dates, templates &amp; terms</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-invoices">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field"><label class="field-label">Invoice Number Prefix</label><input type="text"
                            value="INV-" placeholder="e.g. INV-" onchange="markConfigured('invoices')"><span
                            class="field-hint">e.g. INV-0001, INV-0002…</span></div>
                    <div class="field"><label class="field-label">Quote Number Prefix</label><input type="text"
                            value="QUO-" placeholder="e.g. QUO-"></div>
                    <div class="field"><label class="field-label">Default Payment Terms</label>
                        <div class="select-wrap"><select onchange="markConfigured('invoices')">
                                <option>Net 7</option>
                                <option selected>Net 15</option>
                                <option>Net 30</option>
                                <option>Net 45</option>
                                <option>Net 60</option>
                                <option>Due on Receipt</option>
                                <option>Custom</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Quote Expiry (days)</label>
                        <div class="stepper-wrap"><button class="stepper-btn"
                                onclick="stepVal('quoteExp',-1)">−</button><input type="number" id="quoteExp"
                                value="30" min="1" max="365"><button class="stepper-btn"
                                onclick="stepVal('quoteExp',1)">+</button></div>
                    </div>
                    <div class="field field-full"><label class="field-label">Default Invoice Template</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'inv-tmpl')">Classic</div>
                            <div class="chip" onclick="selectChip(this,'inv-tmpl')">Modern</div>
                            <div class="chip" onclick="selectChip(this,'inv-tmpl')">Compact</div>
                            <div class="chip" onclick="selectChip(this,'inv-tmpl')">Detailed</div>
                            <div class="chip" onclick="selectChip(this,'inv-tmpl')">Minimal</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Late Payment Fee</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Apply late fee after due date</div>
                                <div class="toggle-row-desc">Adds a configurable % fee on overdue invoices.</div>
                            </div><label class="toggle"><input type="checkbox">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Auto-send Reminders</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Send payment reminders automatically</div>
                                <div class="toggle-row-desc">Email reminders 3 days before &amp; after due date.</div>
                            </div><label class="toggle"><input type="checkbox" checked>
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Accent Color on Invoices</label>
                        <div class="color-swatches">
                            <div class="swatch active" style="background:#00b899" onclick="selectSwatch(this)"
                                title="Teal"></div>
                            <div class="swatch" style="background:#1e2a38" onclick="selectSwatch(this)"
                                title="Slate"></div>
                            <div class="swatch" style="background:#f5a623" onclick="selectSwatch(this)"
                                title="Amber"></div>
                            <div class="swatch" style="background:#6366f1" onclick="selectSwatch(this)"
                                title="Indigo"></div>
                            <div class="swatch" style="background:#ef4444" onclick="selectSwatch(this)"
                                title="Red"></div>
                            <div class="swatch" style="background:#0ea5e9" onclick="selectSwatch(this)"
                                title="Sky"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══ 6. ITEMS ══ -->
            <div class="pref-section" id="items" style="animation-delay:.19s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-items">🏷</div>
                        <div>
                            <div class="section-title">Items</div>
                            <div class="section-subtitle">Products, services, pricing &amp; inventory defaults</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-items">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field"><label class="field-label">Default Item Type</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'item-type')">Service</div>
                            <div class="chip" onclick="selectChip(this,'item-type')">Product</div>
                            <div class="chip" onclick="selectChip(this,'item-type')">Subscription</div>
                            <div class="chip" onclick="selectChip(this,'item-type')">Bundle</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Pricing Model</label>
                        <div class="select-wrap"><select onchange="markConfigured('items')">
                                <option selected>Fixed price</option>
                                <option>Hourly rate</option>
                                <option>Per unit</option>
                                <option>Tiered pricing</option>
                                <option>Usage-based</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Default Unit of Measure</label>
                        <div class="select-wrap"><select>
                                <option selected>Each (ea)</option>
                                <option>Hour (hr)</option>
                                <option>Day</option>
                                <option>Month</option>
                                <option>Kilogram (kg)</option>
                                <option>Litre (L)</option>
                                <option>Metre (m)</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Item Code Format</label><input type="text"
                            value="ITEM-" placeholder="e.g. SKU-, PROD-"></div>
                    <div class="field"><label class="field-label">Tax Inclusive Pricing</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Show tax-inclusive prices to clients</div>
                                <div class="toggle-row-desc">Tax breakdown shown separately in line items.</div>
                            </div><label class="toggle"><input type="checkbox">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Inventory Tracking</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Track stock levels for physical items</div>
                                <div class="toggle-row-desc">Low-stock alerts when below threshold.</div>
                            </div><label class="toggle"><input type="checkbox" onchange="markConfigured('items')">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Maximum Discount Allowed</label>
                        <div class="select-wrap"><select>
                                <option selected>No maximum</option>
                                <option>Up to 10%</option>
                                <option>Up to 20%</option>
                                <option>Up to 50%</option>
                                <option>Require approval above 10%</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Display on Client Portal</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Show item catalogue in client portal</div>
                            </div><label class="toggle"><input type="checkbox">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══ 7. NOTIFICATIONS ══ -->
            <div class="pref-section" id="notifications" style="animation-delay:.22s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-notifications">🔔</div>
                        <div>
                            <div class="section-title">Notifications</div>
                            <div class="section-subtitle">Choose when &amp; how you and your team are alerted</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-notifications">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body single-col">
                    <div class="field"><label class="field-label">Notification Channels by Event</label>
                        <div class="notif-grid">
                            <div class="notif-row-header"><span class="notif-ch-label"
                                    style="text-align:left">Event</span><span class="notif-ch-label">Email</span><span
                                    class="notif-ch-label">Push</span><span class="notif-ch-label">SMS</span></div>
                            <div class="notif-row"><span class="notif-event">Invoice paid</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Invoice overdue</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">New client added</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Quote accepted</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Quote expired</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Payment failed</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Project milestone reached</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Low inventory alert</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Bank feed disconnected</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Integration sync error</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                            <div class="notif-row"><span class="notif-event">Weekly summary digest</span>
                                <div class="notif-check">
                                    <div class="custom-check checked" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                                <div class="notif-check">
                                    <div class="custom-check" onclick="toggleCheck(this)"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px 24px;">
                        <div class="field"><label class="field-label">Digest Frequency</label>
                            <div class="chip-group">
                                <div class="chip" onclick="selectChip(this,'notif-freq')">Instant</div>
                                <div class="chip active" onclick="selectChip(this,'notif-freq')">Daily</div>
                                <div class="chip" onclick="selectChip(this,'notif-freq')">Weekly</div>
                            </div>
                        </div>
                        <div class="field"><label class="field-label">Quiet Hours</label>
                            <div class="select-wrap"><select onchange="markConfigured('notifications')">
                                    <option selected>No quiet hours</option>
                                    <option>10pm – 7am</option>
                                    <option>11pm – 8am</option>
                                    <option>Custom range</option>
                                </select></div>
                        </div>
                        <div class="field"><label class="field-label">Notify All Admins</label>
                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-row-label">Copy all admins on critical alerts</div>
                                </div><label class="toggle"><input type="checkbox" checked>
                                    <div class="toggle-slider"></div>
                                </label>
                            </div>
                        </div>
                        <div class="field"><label class="field-label">In-App Sound</label>
                            <div class="toggle-row">
                                <div>
                                    <div class="toggle-row-label">Play sound for in-app notifications</div>
                                </div><label class="toggle"><input type="checkbox">
                                    <div class="toggle-slider"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══ 8. PAYMENTS ══ -->
            <div class="pref-section" id="payments" style="animation-delay:.25s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-payments">💳</div>
                        <div>
                            <div class="section-title">Payments</div>
                            <div class="section-subtitle">Accepted methods, gateways &amp; payout settings</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-payments">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field field-full"><label class="field-label">Accepted Payment Methods</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="toggleChip(this)">Credit Card</div>
                            <div class="chip active" onclick="toggleChip(this)">Bank Transfer (ACH)</div>
                            <div class="chip" onclick="toggleChip(this)">PayPal</div>
                            <div class="chip active" onclick="toggleChip(this)">Stripe</div>
                            <div class="chip" onclick="toggleChip(this)">Apple Pay</div>
                            <div class="chip" onclick="toggleChip(this)">Google Pay</div>
                            <div class="chip" onclick="toggleChip(this)">Crypto</div>
                            <div class="chip" onclick="toggleChip(this)">Check / Cheque</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Primary Payment Gateway</label>
                        <div class="select-wrap"><select onchange="markConfigured('payments')">
                                <option selected>Stripe</option>
                                <option>PayPal</option>
                                <option>Square</option>
                                <option>Braintree</option>
                                <option>Authorize.net</option>
                                <option>Flutterwave</option>
                                <option>Paystack</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Payout Schedule</label>
                        <div class="select-wrap"><select>
                                <option>Instant</option>
                                <option selected>Daily</option>
                                <option>Weekly</option>
                                <option>Monthly</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Allow Partial Payments</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Clients may pay partial amounts</div>
                                <div class="toggle-row-desc">Invoice stays open until fully settled.</div>
                            </div><label class="toggle"><input type="checkbox">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Auto-send Payment Receipt</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Email confirmation sent on payment</div>
                            </div><label class="toggle"><input type="checkbox" checked
                                    onchange="markConfigured('payments')">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Surcharge Policy</label>
                        <div class="select-wrap"><select>
                                <option selected>No surcharge</option>
                                <option>Pass card fees to client</option>
                                <option>Split card fees 50/50</option>
                                <option>Custom surcharge %</option>
                            </select></div>
                    </div>
                </div>
            </div>

            <!-- ══ 9. PROJECTS (NEW) ══ -->
            <div class="pref-section" id="projects" style="animation-delay:.28s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-projects">📁</div>
                        <div>
                            <div class="section-title">Projects</div>
                            <div class="section-subtitle">Tracking, billing methods, timelines &amp; team defaults
                            </div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-projects">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field"><label class="field-label">Default Billing Method</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'proj-billing')">Fixed Price</div>
                            <div class="chip" onclick="selectChip(this,'proj-billing')">Time &amp; Materials</div>
                            <div class="chip" onclick="selectChip(this,'proj-billing')">Milestone-based</div>
                            <div class="chip" onclick="selectChip(this,'proj-billing')">Retainer</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Default Status on Creation</label>
                        <div class="select-wrap"><select onchange="markConfigured('projects')">
                                <option selected>Draft</option>
                                <option>Active</option>
                                <option>Pending Approval</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Project ID Format</label><input type="text"
                            value="PRJ-" placeholder="e.g. PRJ-, PROJ-"><span class="field-hint">e.g. PRJ-0001,
                            PRJ-0002…</span></div>
                    <div class="field"><label class="field-label">Default Timeline View</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'proj-view')">Gantt</div>
                            <div class="chip" onclick="selectChip(this,'proj-view')">Kanban</div>
                            <div class="chip" onclick="selectChip(this,'proj-view')">List</div>
                            <div class="chip" onclick="selectChip(this,'proj-view')">Calendar</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Time Tracking</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Enable time tracking on all projects</div>
                                <div class="toggle-row-desc">Team members can log hours against project tasks.</div>
                            </div><label class="toggle"><input type="checkbox" checked
                                    onchange="markConfigured('projects')">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Default Hourly Rate</label>
                        <div class="stepper-wrap"><button class="stepper-btn"
                                onclick="stepVal('hourlyRate',-5)">−</button><input type="number" id="hourlyRate"
                                value="100" min="0" step="5"><button class="stepper-btn"
                                onclick="stepVal('hourlyRate',5)">+</button></div><span class="field-hint">Applied
                            unless overridden per project.</span>
                    </div>
                    <div class="field"><label class="field-label">Auto-invoice on Milestone</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Generate invoice when milestone is complete</div>
                                <div class="toggle-row-desc">Draft invoice created automatically for review.</div>
                            </div><label class="toggle"><input type="checkbox">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Budget Overage Alert</label>
                        <div class="select-wrap"><select>
                                <option selected>Alert at 80% of budget</option>
                                <option>Alert at 90% of budget</option>
                                <option>Alert at 100% of budget</option>
                                <option>No alerts</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Client Visibility</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Share project progress via client portal</div>
                                <div class="toggle-row-desc">Clients see milestones and status updates only.</div>
                            </div><label class="toggle"><input type="checkbox" checked>
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Expense Tracking</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Track project-related expenses</div>
                                <div class="toggle-row-desc">Log costs to include in project invoicing.</div>
                            </div><label class="toggle"><input type="checkbox" checked>
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Default Task Priority</label>
                        <div class="chip-group">
                            <div class="chip" onclick="selectChip(this,'task-pri')">Low</div>
                            <div class="chip active" onclick="selectChip(this,'task-pri')">Medium</div>
                            <div class="chip" onclick="selectChip(this,'task-pri')">High</div>
                            <div class="chip" onclick="selectChip(this,'task-pri')">Critical</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Archive Completed Projects After</label>
                        <div class="select-wrap"><select>
                                <option>Immediately</option>
                                <option selected>30 days</option>
                                <option>90 days</option>
                                <option>Never (manual only)</option>
                            </select></div>
                    </div>
                </div>
            </div>

            <!-- ══ 10. REPORTS ══ -->
            <div class="pref-section" id="reports" style="animation-delay:.31s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-reports">📊</div>
                        <div>
                            <div class="section-title">Reports</div>
                            <div class="section-subtitle">Default report types, scheduling &amp; export formats</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-reports">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field field-full"><label class="field-label">Dashboard Default Reports</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="toggleChip(this)">Revenue Overview</div>
                            <div class="chip active" onclick="toggleChip(this)">Outstanding Invoices</div>
                            <div class="chip active" onclick="toggleChip(this)">Cash Flow</div>
                            <div class="chip" onclick="toggleChip(this)">Aged Receivables</div>
                            <div class="chip" onclick="toggleChip(this)">Top Clients</div>
                            <div class="chip" onclick="toggleChip(this)">Expense Summary</div>
                            <div class="chip" onclick="toggleChip(this)">Tax Summary</div>
                            <div class="chip" onclick="toggleChip(this)">Profit &amp; Loss</div>
                            <div class="chip" onclick="toggleChip(this)">Project Profitability</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Default Date Range</label>
                        <div class="select-wrap"><select onchange="markConfigured('reports')">
                                <option>This week</option>
                                <option selected>This month</option>
                                <option>This quarter</option>
                                <option>This year</option>
                                <option>Last 30 days</option>
                                <option>Custom range</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Default Export Format</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'report-fmt')">PDF</div>
                            <div class="chip" onclick="selectChip(this,'report-fmt')">Excel</div>
                            <div class="chip" onclick="selectChip(this,'report-fmt')">CSV</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Chart Style</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="selectChip(this,'chart-style')">Bar</div>
                            <div class="chip" onclick="selectChip(this,'chart-style')">Line</div>
                            <div class="chip" onclick="selectChip(this,'chart-style')">Area</div>
                            <div class="chip" onclick="selectChip(this,'chart-style')">Donut</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Scheduled Report Emails</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Email reports on a schedule</div>
                                <div class="toggle-row-desc">Send automated summaries to your inbox.</div>
                            </div><label class="toggle"><input type="checkbox" onchange="markConfigured('reports')">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Schedule Frequency</label>
                        <div class="select-wrap"><select>
                                <option>Daily</option>
                                <option selected>Weekly (Monday)</option>
                                <option>Monthly (1st)</option>
                                <option>Quarterly</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Comparative Period</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Show prior period comparison by default</div>
                                <div class="toggle-row-desc">Adds a vs. last period column to all reports.</div>
                            </div><label class="toggle"><input type="checkbox" checked>
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Currency Display</label>
                        <div class="select-wrap"><select>
                                <option selected>Symbol ($1,000)</option>
                                <option>Code (USD 1,000)</option>
                                <option>Full name (US Dollar 1,000)</option>
                            </select></div>
                    </div>
                </div>
            </div>

            <!-- ══ 11. REPOSITORY ══ -->
            <div class="pref-section" id="repository" style="animation-delay:.34s">
                <div class="section-header" onclick="toggleSection(this)">
                    <div class="section-header-left">
                        <div class="section-icon-wrap icon-repository">📦</div>
                        <div>
                            <div class="section-title">Repository</div>
                            <div class="section-subtitle">Asset library, templates &amp; media management</div>
                        </div>
                    </div>
                    <div class="section-header-right"><span class="section-status status-default"
                            id="status-repository">Default</span>
                        <div class="chevron">▾</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="field"><label class="field-label">Default Upload Folder</label>
                        <div class="select-wrap"><select onchange="markConfigured('repository')">
                                <option selected>/ Root</option>
                                <option>/Invoices</option>
                                <option>/Contracts</option>
                                <option>/Media</option>
                                <option>/Templates</option>
                            </select></div>
                    </div>
                    <div class="field"><label class="field-label">Max File Size Limit</label>
                        <div class="select-wrap"><select>
                                <option>5 MB</option>
                                <option selected>25 MB</option>
                                <option>50 MB</option>
                                <option>100 MB</option>
                                <option>No limit</option>
                            </select></div>
                    </div>
                    <div class="field field-full"><label class="field-label">Allowed File Types</label>
                        <div class="chip-group">
                            <div class="chip active" onclick="toggleChip(this)">PDF</div>
                            <div class="chip active" onclick="toggleChip(this)">Images (PNG, JPG, SVG)</div>
                            <div class="chip active" onclick="toggleChip(this)">Spreadsheets (XLS, CSV)</div>
                            <div class="chip" onclick="toggleChip(this)">Word Documents</div>
                            <div class="chip" onclick="toggleChip(this)">Video</div>
                            <div class="chip" onclick="toggleChip(this)">ZIP Archives</div>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">AI Auto-tagging</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Auto-tag uploads with AI</div>
                                <div class="toggle-row-desc">Suggests categories and tags automatically.</div>
                            </div><label class="toggle"><input type="checkbox" checked>
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Duplicate Detection</label>
                        <div class="toggle-row">
                            <div>
                                <div class="toggle-row-label">Warn on duplicate file uploads</div>
                                <div class="toggle-row-desc">Compares file hash before saving.</div>
                            </div><label class="toggle"><input type="checkbox" checked
                                    onchange="markConfigured('repository')">
                                <div class="toggle-slider"></div>
                            </label>
                        </div>
                    </div>
                    <div class="field"><label class="field-label">Default Sharing Permission</label>
                        <div class="select-wrap"><select>
                                <option selected>Private</option>
                                <option>Team</option>
                                <option>Public link (read-only)</option>
                            </select></div>
                    </div>
                </div>
            </div>

        </div><!-- /page-body -->

        <div class="save-footer">
            <div class="save-footer-left" id="footerNote">Configure at least one section to continue.</div>
            <button class="btn-continue" id="continueBtn" onclick="handleContinue()">Save &amp; Continue to Step 4
                <span>→</span></button>
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
                placeholder="Search invoices, clients, PO, project…" oninput="runGlobalSearch(this.value)" autofocus>
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

<script>
    const configured = new Set();
    const TOTAL = 11;
    const NAV_IDS = ['banking', 'clients', 'documents', 'integrations', 'invoices', 'items', 'notifications',
        'payments', 'projects', 'reports', 'repository'
    ];

    function toggleSection(header) {
        const body = header.nextElementSibling;
        const isOpen = body.classList.contains('open');
        document.querySelectorAll('.section-body').forEach(b => b.classList.remove('open'));
        document.querySelectorAll('.section-header').forEach(h => {
            h.classList.remove('open');
            h.querySelector('.chevron').classList.remove('open');
        });
        if (!isOpen) {
            body.classList.add('open');
            header.classList.add('open');
            header.querySelector('.chevron').classList.add('open');
            updateNavHighlight(header.closest('.pref-section').id);
        }
    }

    function markConfigured(id) {
        configured.add(id);
        const el = document.getElementById('status-' + id);
        if (el) {
            el.textContent = 'Configured';
            el.className = 'section-status status-configured';
        }
        updateProgress();
    }

    function updateProgress() {
        const pct = Math.round(configured.size / TOTAL * 100);
        document.getElementById('progressFill').style.width = pct + '%';
        document.getElementById('progressPct').textContent = configured.size + ' / ' + TOTAL;
        if (configured.size > 0) document.getElementById('footerNote').innerHTML = '<strong>' + configured.size +
            ' of ' + TOTAL + '</strong> sections configured.';
    }

    function selectChip(el, group) {
        el.closest('.chip-group').querySelectorAll('.chip[onclick*="' + group + '"]').forEach(c => c.classList.remove(
            'active'));
        el.classList.add('active');
    }

    function toggleChip(el) {
        el.classList.toggle('active');
    }

    function toggleCheck(el) {
        el.classList.toggle('checked');
    }

    function selectSwatch(el) {
        el.closest('.color-swatches').querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
        el.classList.add('active');
    }

    function stepVal(id, delta) {
        const inp = document.getElementById(id);
        inp.value = Math.max(parseFloat(inp.min) || 0, parseFloat(inp.value || 0) + delta);
    }

    function updateNavHighlight(activeId) {
        document.querySelectorAll('.nav-link').forEach((l, i) => l.classList.toggle('active', NAV_IDS[i] === activeId));
    }

    function scrollTo(id) {
        const el = document.getElementById(id);
        if (!el) return;
        if (!el.querySelector('.section-body.open')) toggleSection(el.querySelector('.section-header'));
        setTimeout(() => el.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        }), 50);
        updateNavHighlight(id);
    }

    function saveAll() {
        NAV_IDS.forEach(id => markConfigured(id));
        showToast('✓ All preferences saved successfully!');
    }

    function handleContinue() {
        if (configured.size === 0) {
            showToast('Configure at least one section, or click Skip.');
            return;
        }
        const btn = document.getElementById('continueBtn');
        btn.innerHTML = '<span style="display:inline-block;animation:spin .6s linear infinite">⟳</span> Saving…';
        setTimeout(() => {
            btn.innerHTML = '✓ Saved! Heading to Step 4…';
            btn.style.background = 'var(--teal)';
            showToast('🎉 Preferences saved! Welcome to Billflow.');
        }, 1400);
    }

    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(window._tt);
        window._tt = setTimeout(() => t.classList.remove('show'), 3200);
    }

    const spy = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) updateNavHighlight(e.target.id);
        });
    }, {
        rootMargin: '-25% 0px -60% 0px'
    });
    document.querySelectorAll('.pref-section').forEach(s => spy.observe(s));

    window.addEventListener('load', () => {
        const first = document.querySelector('.pref-section .section-header');
        if (first) toggleSection(first);
    });
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
@include('subscriber.includes.footer')
