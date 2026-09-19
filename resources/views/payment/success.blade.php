<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Successful — Velo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        :root {
            --ink: #0f0e0d;
            --ink-2: #3a3834;
            --ink-3: #7a7570;
            --surface: #faf9f7;
            --surface-2: #f2f0ec;
            --surface-3: #e8e4de;
            --accent: #1a6b4a;
            --accent-mid: #2e9969;
            --accent-light: #e4f0eb;
            --gold: #c9832a;
            --gold-light: #fdf3e7;
            --border: rgba(15, 14, 13, 0.09);
            --border-strong: rgba(15, 14, 13, 0.16);
            --font-display: 'Syne', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-body: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 22px;
            --shadow-card: 0 12px 36px rgba(15, 14, 13, 0.07), 0 2px 8px rgba(15, 14, 13, 0.03);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--surface);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            position: relative;
        }

        /* Subtle background glow effect */
        body::before {
            content: '';
            position: absolute;
            top: -160px;
            left: 50%;
            transform: translateX(-50%);
            width: 800px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(46, 153, 105, 0.11) 0%, rgba(250, 249, 247, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* Top Header */
        .page-header {
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5%;
            border-bottom: 1px solid var(--border);
            background: rgba(250, 249, 247, 0.92);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .brand-logo {
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 800;
            color: var(--ink);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .brand-logo span {
            color: var(--accent);
        }

        .header-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--surface-2);
            border: 1px solid var(--border-strong);
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            color: var(--ink-2);
        }

        /* Main Container */
        .main-wrapper {
            flex: 1;
            padding: 48px 20px 64px;
            position: relative;
            z-index: 1;
        }

        .content-container {
            max-width: 780px;
            margin: 0 auto;
        }

        /* Hero Success Section */
        .success-hero {
            text-align: center;
            margin-bottom: 32px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent-light);
            color: var(--accent);
            border: 1px solid rgba(26, 107, 74, 0.25);
            padding: 6px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(26, 107, 74, 0.08);
            animation: fadeInDown 0.5s ease;
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent-mid);
            position: relative;
        }

        .pulse-dot::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 2px solid var(--accent-mid);
            animation: pulseRing 1.8s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        .check-circle {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a6b4a 0%, #2e9969 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 12px 28px rgba(26, 107, 74, 0.32), inset 0 2px 4px rgba(255, 255, 255, 0.3);
            animation: scaleIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .check-circle svg {
            width: 40px;
            height: 40px;
            stroke: #ffffff;
            stroke-width: 3.2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
            animation: checkStroke 0.7s 0.25s ease forwards;
        }

        .success-title {
            font-family: var(--font-display);
            font-size: clamp(28px, 4.5vw, 38px);
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -0.8px;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .success-title em {
            font-style: normal;
            color: var(--accent);
        }

        .success-desc {
            font-size: clamp(15px, 1.8vw, 16.5px);
            color: var(--ink-3);
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Receipt Card */
        .receipt-card {
            background: #ffffff;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            margin-bottom: 28px;
            animation: fadeInUp 0.6s ease 0.1s both;
        }

        .receipt-header {
            padding: 20px 28px;
            background: linear-gradient(180deg, #faf9f7 0%, #f4f2ee 100%);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .receipt-logo {
            font-family: var(--font-display);
            font-size: 18px;
            font-weight: 800;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .receipt-logo span {
            color: var(--accent);
        }

        .receipt-type-pill {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 700;
            background: rgba(15, 14, 13, 0.06);
            color: var(--ink-2);
            padding: 3px 8px;
            border-radius: 6px;
        }

        .paid-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e4f0eb;
            color: #1a6b4a;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
            border: 1px solid rgba(26, 107, 74, 0.2);
        }

        .receipt-body {
            padding: 28px;
        }

        .receipt-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px 28px;
            padding-bottom: 24px;
            border-bottom: 1px dashed var(--border-strong);
        }

        @media (max-width: 580px) {
            .receipt-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        .grid-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .item-label {
            font-size: 11.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--ink-3);
        }

        .item-value {
            font-size: 15.5px;
            font-weight: 600;
            color: var(--ink);
            word-break: break-all;
        }

        .item-value.amount {
            font-family: var(--font-display);
            font-size: 24px;
            font-weight: 800;
            color: var(--accent);
        }

        .code-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface-2);
            padding: 5px 10px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-family: SFMono-Regular, Consolas, "Liberation Mono", Menlo, monospace;
            font-size: 12.5px;
            color: var(--ink-2);
            max-width: 100%;
        }

        .code-pill-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 220px;
        }

        .copy-btn {
            background: transparent;
            border: none;
            color: var(--ink-3);
            cursor: pointer;
            padding: 2px 4px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .copy-btn:hover {
            color: var(--accent);
            background: #ffffff;
        }

        /* Features strip */
        .features-strip {
            padding-top: 22px;
        }

        .features-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--ink-2);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .features-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--ink-2);
            background: var(--surface);
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
        }

        .feature-item svg {
            color: var(--accent);
            flex-shrink: 0;
        }

        /* Receipt Footer */
        .receipt-footer {
            padding: 16px 28px;
            background: var(--surface);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 13px;
            color: var(--ink-3);
        }

        .btn-print-receipt {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-2);
            background: #ffffff;
            border: 1px solid var(--border-strong);
            padding: 6px 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-print-receipt:hover {
            background: var(--surface-2);
            color: var(--ink);
        }

        /* Next Steps */
        .next-steps-wrap {
            margin-top: 36px;
            animation: fadeInUp 0.6s ease 0.2s both;
        }

        .next-steps-title {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            color: var(--ink);
            text-align: center;
            margin-bottom: 20px;
        }

        .next-steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        @media (max-width: 680px) {
            .next-steps-grid {
                grid-template-columns: 1fr;
            }
        }

        .next-step-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease;
            position: relative;
        }

        .next-step-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(15, 14, 13, 0.08);
            border-color: rgba(26, 107, 74, 0.4);
            color: inherit;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--surface-2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 14px;
        }

        .step-card-name {
            font-family: var(--font-display);
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 6px;
        }

        .step-card-desc {
            font-size: 12.5px;
            color: var(--ink-3);
            line-height: 1.5;
            margin-bottom: 14px;
            flex-grow: 1;
        }

        .step-card-action {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--accent);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Action Buttons */
        .actions-hub {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
        }

        .btn-primary-go {
            background: var(--ink);
            color: #ffffff;
            font-family: var(--font-body);
            font-size: 15.5px;
            font-weight: 600;
            padding: 14px 38px;
            border-radius: 999px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 20px rgba(15, 14, 13, 0.16);
            transition: all 0.2s ease;
            border: 2px solid var(--ink);
        }

        .btn-primary-go:hover {
            background: #282622;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15, 14, 13, 0.22);
        }

        .sub-links {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 13.5px;
        }

        .sub-links a {
            color: var(--ink-2);
            text-decoration: none;
            transition: color 0.2s;
        }

        .sub-links a:hover {
            color: var(--accent);
        }

        /* Page Footer */
        .page-footer {
            padding: 24px 20px;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 13px;
            color: var(--ink-3);
            background: #ffffff;
        }

        .page-footer a {
            color: var(--ink-2);
            text-decoration: none;
        }

        .page-footer a:hover {
            color: var(--accent);
        }

        /* Toast Alert */
        .copy-toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: var(--ink);
            color: #ffffff;
            padding: 9px 20px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 500;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 9999;
            pointer-events: none;
        }

        .copy-toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* Animations */
        @keyframes checkStroke {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0.6);
                opacity: 0;
            }
            70% {
                transform: scale(1.08);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes pulseRing {
            0% {
                transform: scale(0.9);
                opacity: 0.8;
            }
            100% {
                transform: scale(2.2);
                opacity: 0;
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Print formatting */
        @media print {
            .page-header,
            .next-steps-wrap,
            .actions-hub,
            .receipt-footer,
            .page-footer,
            .copy-btn {
                display: none !important;
            }
            body {
                background: #ffffff !important;
            }
            .receipt-card {
                box-shadow: none !important;
                border: 1px solid #111 !important;
            }
            .main-wrapper {
                padding: 0 !important;
            }
        }
    </style>
</head>

<body>

    <!-- TOP HEADER -->
    <header class="page-header">
        <a href="{{ route('home') }}" class="brand-logo">Velo<span>.</span></a>
        <div class="header-badge">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            256-Bit SSL Encrypted
        </div>
    </header>

    <!-- MAIN BODY -->
    <main class="main-wrapper">
        <div class="content-container">

            <!-- HERO SUCCESS -->
            <div class="success-hero">
                <div class="status-badge">
                    <span class="pulse-dot"></span>
                    Payment Verified & Active
                </div>

                <div class="check-circle">
                    <svg viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>

                <h1 class="success-title">Payment <em>Successful!</em></h1>
                <p class="success-desc">
                    Your subscription has been activated. Welcome to Velo Pro &mdash; all premium features are ready for your business.
                </p>
            </div>

            <!-- RECEIPT CARD -->
            <div class="receipt-card">
                <div class="receipt-header">
                    <div class="receipt-logo">
                        Velo<span>.</span>
                        <span class="receipt-type-pill">Official Receipt</span>
                    </div>
                    <div class="paid-badge">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        {{ strtoupper($paymentStatus ?? 'PAID') }}
                    </div>
                </div>

                <div class="receipt-body">
                    <div class="receipt-grid">
                        <div class="grid-item">
                            <span class="item-label">Subscription Plan</span>
                            <span class="item-value">{{ $planName ?? 'Velo Starter Plan' }}</span>
                        </div>

                        <div class="grid-item">
                            <span class="item-label">Amount Paid</span>
                            <span class="item-value amount">
                                @if(isset($amountPaid) && $amountPaid > 0)
                                    ${{ number_format($amountPaid, 2) }} <span style="font-size: 13px; font-weight: 500; color: var(--ink-3);">{{ $currency ?? 'USD' }}</span>
                                @else
                                    $29.00 <span style="font-size: 13px; font-weight: 500; color: var(--ink-3);">USD</span>
                                @endif
                            </span>
                        </div>

                        <div class="grid-item">
                            <span class="item-label">Billing Account</span>
                            <span class="item-value">{{ $customerEmail ?? (auth()->check() ? auth()->user()->email : 'Verified Customer') }}</span>
                        </div>

                        <div class="grid-item">
                            <span class="item-label">Reference ID</span>
                            <div class="code-pill">
                                <span class="code-pill-text" id="sessionIdText" title="{{ $sessionId ?? 'cs_test_active_session' }}">
                                    {{ $sessionId ?? 'cs_test_a1bzZZZ7wmbGxRIzX7jhY0W5eh80icyfwQWy6KX3KKPiBdaBjUX1ErJwjf' }}
                                </span>
                                <button type="button" class="copy-btn" onclick="copyReferenceId()" title="Copy Reference ID">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="grid-item">
                            <span class="item-label">Payment Date</span>
                            <span class="item-value">{{ now()->format('M d, Y • h:i A') }}</span>
                        </div>

                        <div class="grid-item">
                            <span class="item-label">Payment Method</span>
                            <span class="item-value" style="display: flex; align-items: center; gap: 6px;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                Stripe Secure Card
                            </span>
                        </div>
                    </div>

                    <!-- UNLOCKED FEATURES -->
                    <div class="features-strip">
                        <div class="features-title">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                            Features Active on Your Account
                        </div>
                        <ul class="features-list">
                            <li class="feature-item">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span><strong>Unlimited</strong> Invoices & Quotes</span>
                            </li>
                            <li class="feature-item">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span><strong>Branded</strong> Client Portal</span>
                            </li>
                            <li class="feature-item">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span><strong>Instant</strong> Online Payments</span>
                            </li>
                            <li class="feature-item">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span><strong>Automated</strong> Reminders</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="receipt-footer">
                    <span>A confirmation receipt has been sent to your email.</span>
                    <button type="button" class="btn-print-receipt" onclick="window.print()">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 6 2 18 2 18 9"></polyline>
                            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                            <rect x="6" y="14" width="12" height="8"></rect>
                        </svg>
                        Print Receipt
                    </button>
                </div>
            </div>

            <!-- WHAT'S NEXT -->
            <div class="next-steps-wrap">
                <h2 class="next-steps-title">Recommended Next Steps</h2>
                <div class="next-steps-grid">
                    <a href="{{ route('subscriber.invoices.create') }}" class="next-step-card">
                        <div class="step-icon">📄</div>
                        <div class="step-card-name">Create an Invoice</div>
                        <p class="step-card-desc">Generate and send professional, branded invoices in seconds.</p>
                        <span class="step-card-action">Create Invoice &rarr;</span>
                    </a>

                    <a href="{{ route('subscriber.dashboard') }}" class="next-step-card">
                        <div class="step-icon">👥</div>
                        <div class="step-card-name">Add Client Profiles</div>
                        <p class="step-card-desc">Organize customer details, billing terms, and contacts in one place.</p>
                        <span class="step-card-action">Manage Clients &rarr;</span>
                    </a>

                    <a href="{{ route('subscriber.dashboard') }}" class="next-step-card">
                        <div class="step-icon">📊</div>
                        <div class="step-card-name">Explore Dashboard</div>
                        <p class="step-card-desc">Monitor revenue, track invoice statuses, and view cashflow analytics.</p>
                        <span class="step-card-action">Go to Analytics &rarr;</span>
                    </a>
                </div>

                <!-- CTA -->
                <div class="actions-hub">
                    <a href="{{ route('subscriber.dashboard') }}" class="btn-primary-go">
                        <span>Go to Dashboard</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>

                    <div class="sub-links">
                        <a href="{{ route('home') }}">&larr; Back to Home</a>
                        <span style="color: var(--border-strong);">&bull;</span>
                        <a href="mailto:support@velobiz.com">Need help? Contact Support</a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="page-footer">
        <div>&copy; 2026 Velo Technologies, Inc. All rights reserved. &nbsp;&bull;&nbsp; <a href="{{ route('home') }}">Terms</a> &nbsp;&bull;&nbsp; <a href="{{ route('home') }}">Privacy</a></div>
    </footer>

    <!-- COPY TOAST -->
    <div id="copyToast" class="copy-toast">
        ✓ Reference ID copied to clipboard!
    </div>

    <script>
        function copyReferenceId() {
            const textElement = document.getElementById('sessionIdText');
            const textToCopy = textElement ? (textElement.getAttribute('title') || textElement.innerText.trim()) : '';
            
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    showToast();
                }).catch(() => {
                    fallbackCopy(textToCopy);
                });
            } else {
                fallbackCopy(textToCopy);
            }
        }

        function fallbackCopy(text) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            showToast();
        }

        function showToast() {
            const toast = document.getElementById('copyToast');
            if (toast) {
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 2200);
            }
        }
    </script>
</body>

</html>
