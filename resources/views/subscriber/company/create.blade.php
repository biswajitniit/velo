<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billflow — Set Up Your Company Profile</title>
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
            --slate-mid: #2c3e50;
            --teal: #00b899;
            --teal-dark: #009e82;
            --teal-pale: #d6f5ef;
            --amber: #f5a623;
            --amber-pale: #fef3d8;
            --muted: #6b7280;
            --muted-light: #9ca3af;
            --border: #ddd8cc;
            --border-focus: #00b899;
            --card: #ffffff;
            --error: #ef4444;
            --error-pale: #fef2f2;
            --success: #10b981;
            --input-bg: #faf9f6;
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.10);
            --shadow-lg: 0 24px 64px rgba(0, 0, 0, 0.13);
            --radius: 16px;
            --radius-sm: 10px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--slate);
            color: var(--ink);
            font-size: 15px;
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            width: 52%;
            background: var(--slate);
            display: flex;
            flex-direction: column;
            padding: 40px 5%;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .left-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 80%, rgba(0, 184, 153, 0.18) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 10%, rgba(245, 166, 35, 0.10) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(0, 184, 153, 0.05) 0%, transparent 70%);
        }

        .left-grid {
            position: absolute;
            inset: 0;
            z-index: 0;
            opacity: 0.12;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.3) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.3) 1px, transparent 1px);
            background-size: 44px 44px;
        }

        .left-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .left-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.04em;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .left-logo span {
            color: var(--teal);
        }

        .left-headline-wrap {
            margin-top: auto;
            margin-bottom: auto;
            padding: 40px 0;
        }

        .left-eyebrow {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .14em;
            color: var(--teal);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .left-eyebrow::before {
            content: '';
            width: 24px;
            height: 2px;
            background: var(--teal);
        }

        .left-headline {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 2.8vw, 2.8rem);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -0.04em;
            color: #fff;
            max-width: 420px;
        }

        .left-headline em {
            font-style: normal;
            color: var(--teal);
        }

        .left-body {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.5);
            max-width: 380px;
            margin-top: 1.25rem;
            line-height: 1.7;
        }

        /* Progress steps */
        .steps-list {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-top: 2.5rem;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 0;
            position: relative;
        }

        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 15px;
            top: 44px;
            width: 2px;
            height: calc(100% - 14px);
            background: rgba(255, 255, 255, 0.1);
        }

        .step-item.active::after {
            background: rgba(0, 184, 153, 0.3);
        }

        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            border: 2px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.3);
            transition: all .3s;
        }

        .step-item.done .step-dot {
            background: var(--teal);
            border-color: var(--teal);
            color: #fff;
        }

        .step-item.active .step-dot {
            background: rgba(0, 184, 153, 0.2);
            border-color: var(--teal);
            color: var(--teal);
            box-shadow: 0 0 0 4px rgba(0, 184, 153, 0.15);
        }

        .step-info {
            padding-top: 4px;
        }

        .step-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.3);
            transition: color .3s;
        }

        .step-item.active .step-label {
            color: #fff;
        }

        .step-item.done .step-label {
            color: rgba(255, 255, 255, 0.5);
        }

        .step-sublabel {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.25);
            margin-top: 1px;
        }

        .step-item.active .step-sublabel {
            color: var(--teal);
        }

        .left-footer {
            margin-top: auto;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.25);
            line-height: 1.5;
        }

        .left-footer a {
            color: rgba(255, 255, 255, 0.35);
            text-decoration: none;
        }

        .left-footer a:hover {
            color: var(--teal);
        }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 1;
            background: var(--paper);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0;
            overflow-y: auto;
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--teal), var(--amber), var(--teal));
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
            z-index: 10;
        }

        @keyframes shimmer {
            0% {
                background-position: 0% 0%;
            }

            100% {
                background-position: 200% 0%;
            }
        }

        .rp-inner {
            width: 100%;
            max-width: 520px;
            padding: 56px 32px 48px;
            animation: slideIn .5s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(22px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Welcome badge */
        .welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--teal-pale);
            color: var(--teal-dark);
            border: 1px solid rgba(0, 184, 153, 0.25);
            border-radius: 999px;
            padding: 5px 12px 5px 8px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-bottom: 20px;
        }

        .welcome-badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--teal);
            animation: pulse 1.8s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .6;
                transform: scale(.85);
            }
        }

        .profile-heading {
            font-family: 'Syne', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--slate);
            line-height: 1.1;
            margin-bottom: 6px;
        }

        .profile-sub {
            font-size: 0.875rem;
            color: var(--muted);
            margin-bottom: 32px;
        }

        /* Progress bar */
        .progress-wrap {
            background: var(--cream);
            border-radius: 999px;
            height: 6px;
            margin-bottom: 32px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--teal), var(--teal-dark));
            transition: width .5s cubic-bezier(.34, 1.56, .64, 1);
        }

        .progress-label {
            font-size: 0.72rem;
            color: var(--muted-light);
            font-weight: 500;
            margin-top: 6px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
        }

        .progress-label span {
            color: var(--teal);
            font-weight: 700;
        }

        /* Section dividers */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 24px 0 20px;
        }

        .section-divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .section-divider-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--muted-light);
            white-space: nowrap;
        }

        /* Form groups */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--slate-mid);
            margin-bottom: 7px;
            letter-spacing: 0.01em;
        }

        .form-group label .req {
            color: var(--teal);
            margin-left: 2px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            font-size: 0.95rem;
            line-height: 1;
            color: var(--muted-light);
            pointer-events: none;
            user-select: none;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            background: var(--input-bg);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--ink);
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
            -webkit-appearance: none;
            appearance: none;
        }

        input[type="text"].no-icon,
        input[type="email"].no-icon,
        input[type="tel"].no-icon,
        select.no-icon {
            padding-left: 14px;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--border-focus);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 184, 153, 0.12);
        }

        input.error {
            border-color: var(--error);
            background: var(--error-pale);
        }

        input.error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .input-hint {
            font-size: 0.75rem;
            color: var(--muted-light);
            margin-top: 5px;
            padding-left: 2px;
        }

        .input-error-msg {
            font-size: 0.75rem;
            color: var(--error);
            margin-top: 5px;
            padding-left: 2px;
            display: none;
        }

        select {
            padding-left: 14px;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%236b7280' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        /* Phone row */
        .phone-row {
            display: flex;
            gap: 10px;
        }

        .phone-country {
            width: 110px;
            flex-shrink: 0;
        }

        .phone-number {
            flex: 1;
        }

        /* Display name checkbox */
        .display-name-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            cursor: pointer;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--border);
            background: var(--input-bg);
            transition: border-color .2s, background .2s;
            user-select: none;
        }

        .display-name-check:hover {
            border-color: var(--teal);
            background: rgba(0, 184, 153, 0.04);
        }

        .dn-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 5px;
            flex-shrink: 0;
            border: 2px solid var(--teal);
            background: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .dn-checkbox:not(.checked) {
            background: transparent;
        }

        .dn-checkbox:not(.checked) svg {
            display: none;
        }

        .dn-label {
            font-size: 0.8rem;
            color: var(--slate-mid);
            line-height: 1.4;
        }

        /* SMS opt-in */
        .sms-optin {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: var(--teal-pale);
            border: 1.5px solid rgba(0, 184, 153, 0.22);
            border-radius: var(--radius-sm);
            padding: 14px;
            margin-top: 8px;
            cursor: pointer;
        }

        .sms-check {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            flex-shrink: 0;
            border: 2px solid var(--teal);
            background: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1px;
            transition: all .2s;
        }

        .sms-check svg {
            display: block;
        }

        .sms-optin.unchecked .sms-check {
            background: transparent;
        }

        .sms-optin.unchecked .sms-check svg {
            display: none;
        }

        .sms-text {
            font-size: 0.8rem;
            color: var(--teal-dark);
            line-height: 1.5;
        }

        .sms-text strong {
            font-weight: 700;
            display: block;
            margin-bottom: 1px;
        }

        /* Logo upload */
        .logo-upload-area {
            border: 2px dashed var(--border);
            border-radius: var(--radius-sm);
            padding: 24px;
            text-align: center;
            background: var(--input-bg);
            cursor: pointer;
            transition: all .2s;
            position: relative;
            overflow: hidden;
        }

        .logo-upload-area:hover {
            border-color: var(--teal);
            background: rgba(0, 184, 153, 0.04);
        }

        .logo-upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .logo-upload-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--cream);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin: 0 auto 10px;
        }

        .logo-upload-label {
            font-size: 0.825rem;
            color: var(--slate-mid);
            font-weight: 500;
        }

        .logo-upload-hint {
            font-size: 0.72rem;
            color: var(--muted-light);
            margin-top: 3px;
        }

        .logo-preview {
            display: none;
            align-items: center;
            gap: 12px;
            padding: 10px;
            background: var(--cream);
            border-radius: 8px;
            margin-top: 10px;
        }

        .logo-preview img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: contain;
            background: #fff;
            border: 1px solid var(--border);
        }

        .logo-preview-info {
            font-size: 0.8rem;
            color: var(--slate-mid);
        }

        .logo-preview-name {
            font-weight: 600;
        }

        .logo-preview-size {
            color: var(--muted-light);
            font-size: 0.72rem;
        }

        .logo-preview-remove {
            margin-left: auto;
            cursor: pointer;
            font-size: 0.75rem;
            color: var(--error);
            font-weight: 600;
        }

        /* Submit button */
        .submit-btn {
            width: 100%;
            padding: 14px 20px;
            background: var(--teal);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background .2s, transform .15s, box-shadow .2s;
            margin-top: 28px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 184, 153, 0.3);
        }

        .submit-btn:hover {
            background: var(--teal-dark);
            box-shadow: 0 6px 24px rgba(0, 184, 153, 0.4);
            transform: translateY(-1px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn.loading .btn-text,
        .submit-btn.loading .btn-arrow {
            opacity: 0;
        }

        .submit-btn.loading .spinner {
            opacity: 1;
        }

        .btn-arrow {
            font-size: 1.1rem;
            transition: transform .2s;
        }

        .submit-btn:hover .btn-arrow {
            transform: translateX(3px);
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2.5px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            position: absolute;
            opacity: 0;
            transition: opacity .2s;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Skip link */
        .skip-link {
            text-align: center;
            margin-top: 16px;
            font-size: 0.8rem;
            color: var(--muted);
        }

        .skip-link a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px dashed var(--border);
            transition: color .2s;
        }

        .skip-link a:hover {
            color: var(--slate);
        }

        /* Success screen */
        .success-screen {
            display: none;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px 0;
            animation: slideIn .5s cubic-bezier(.22, 1, .36, 1) both;
        }

        .success-confetti {
            font-size: 3.5rem;
            margin-bottom: 20px;
            animation: bounce .6s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes bounce {
            from {
                opacity: 0;
                transform: scale(.5);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .success-screen h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--slate);
            margin-bottom: 8px;
        }

        .success-screen p {
            font-size: 0.875rem;
            color: var(--muted);
            max-width: 320px;
        }

        .success-card {
            background: var(--card);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 24px;
            margin: 24px 0;
            width: 100%;
            text-align: left;
        }

        .sc-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--cream);
            font-size: 0.825rem;
        }

        .sc-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .sc-key {
            color: var(--muted);
        }

        .sc-val {
            font-weight: 600;
            color: var(--slate);
        }

        .btn-dash {
            width: 100%;
            padding: 14px;
            background: var(--slate);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-dash:hover {
            background: var(--slate-mid);
        }

        .rp-footer {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            display: flex;
            gap: 16px;
            justify-content: center;
            font-size: 0.75rem;
            color: var(--muted-light);
        }

        .rp-footer a {
            color: var(--muted-light);
            text-decoration: none;
            transition: color .2s;
        }

        .rp-footer a:hover {
            color: var(--teal);
        }

        /* Responsive */
        @media (max-width: 820px) {
            body {
                overflow: auto;
                flex-direction: column;
            }

            .left-panel {
                width: 100%;
                min-height: 280px;
                padding: 32px 24px;
            }

            .left-headline-wrap {
                margin: 20px 0;
                padding: 0;
            }

            .steps-list {
                display: none;
            }

            .right-panel {
                overflow: visible;
            }

            .rp-inner {
                padding: 36px 24px 40px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>

<body>

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="left-bg"></div>
        <div class="left-grid"></div>
        <div class="left-content">
            <a href="#" class="left-logo">Bill<span>flow</span></a>

            <div class="left-headline-wrap">
                <div class="left-eyebrow">Step 1 of 3</div>
                <h2 class="left-headline">
                    Let's set up your<br><em>company profile</em>
                </h2>
                <p class="left-body">
                    Tell us about your business so we can personalise your Billflow experience and connect you with your
                    clients.
                </p>

                <div class="steps-list">
                    <div class="step-item done">
                        <div class="step-dot">✓</div>
                        <div class="step-info">
                            <div class="step-label">Create account</div>
                            <div class="step-sublabel">Completed</div>
                        </div>
                    </div>
                    <div class="step-item active">
                        <div class="step-dot">2</div>
                        <div class="step-info">
                            <div class="step-label">Company profile</div>
                            <div class="step-sublabel">You are here</div>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-dot">3</div>
                        <div class="step-info">
                            <div class="step-label">Preferences</div>
                            <div class="step-sublabel">Currency, Invoices & quotes, documents</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="left-footer">
                <a href="#">Privacy</a> · <a href="#">Terms</a> · <a href="#">Help</a><br>
                © 2025 Billflow Inc. All rights reserved.
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">
        <div class="rp-inner">

            <!-- Main form -->
            <div id="profileForm">
                <div class="welcome-badge">
                    <div class="welcome-badge-dot"></div>
                    Welcome aboard
                </div>

                <h1 class="profile-heading">My Profile</h1>
                <p class="profile-sub">Fill in your details to get started. You can always update these later.</p>

                <!-- Progress -->
                <div class="progress-wrap">
                    <div class="progress-fill" id="progressFill" style="width: 0%"></div>
                </div>
                <div class="progress-label">
                    <span id="progressPct">0%</span> complete
                    <span id="progressCount">0 / 8 fields</span>
                </div>

                <!-- Personal Info -->
                <div class="section-divider">
                    <div class="section-divider-line"></div>
                    <div class="section-divider-label">👤 Personal information</div>
                    <div class="section-divider-line"></div>
                </div>

                <form id="profileFormFields" action="{{ route('subscriber.company.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First name <span class="req">*</span></label>
                            <div class="input-wrap">
                                <span class="input-icon">🧑</span>
                                <input type="text" id="firstName" placeholder="Jane"
                                    value="{{ old('firstName', auth()->user()->first_name ?? '') }}"
                                    oninput="trackProgress()">
                            </div>
                            <div class="input-error-msg" id="firstNameErr">Please enter your first name.</div>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last name <span class="req">*</span></label>
                            <div class="input-wrap">
                                <span class="input-icon">🧑</span>
                                <input type="text" id="lastName" placeholder="Smith"
                                    value="{{ old('lastName', auth()->user()->last_name ?? '') }}"
                                    oninput="trackProgress()">
                            </div>
                            <div class="input-error-msg" id="lastNameErr">Please enter your last name.</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address <span class="req">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">✉</span>
                            <input type="email" id="email" placeholder="jane@yourcompany.com"
                                value="{{ old('email', auth()->user()->email ?? '') }}" oninput="trackProgress()">
                        </div>
                        <div class="input-hint">This will be used for account notifications and billing emails.</div>
                        <div class="input-error-msg" id="emailErr">Please enter a valid email address.</div>
                    </div>

                    <!-- Company Info -->
                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-label">🏢 Company information</div>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="form-group">
                        <label for="companyName">Company name <span class="req">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">🏢</span>
                            <input type="text" id="companyName" name="company_name" placeholder="Acme Corp"
                                oninput="trackProgress()">
                        </div>
                        <div class="input-error-msg" id="companyNameErr">Please enter your company name.</div>
                        <div class="display-name-check" id="displayNameCheck" onclick="toggleDisplayName()">
                            <div class="dn-checkbox checked" id="dnCheckbox">
                                <svg width="11" height="8" viewBox="0 0 11 8" fill="none">
                                    <path d="M1 4l3 3 6-6" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span class="dn-label">Display company name on quotes, invoices, and communications. If not
                                enabled, personal name will be used</span>
                        </div>

                        <input type="hidden" name="display_company_name" id="displayCompanyName"
                            value="{{ old('display_company_name', $company?->display_company_name ?? 1) }}">
                    </div>

                    <div class="form-group">
                        <label for="industry">Industry</label>
                        <select id="industry" name="industry" class="no-icon" onchange="trackProgress()">
                            <option value="" selected>Select your industry…</option>
                            <option value="technology-software">Technology & Software</option>
                            <option value="finance-accounting">Finance & Accounting</option>
                            <option value="healthcare">Healthcare</option>
                            <option value="legal-services">Legal Services</option>
                            <option value="marketing-creative">Marketing & Creative</option>
                            <option value="construction-real-estate">Construction & Real Estate</option>
                            <option value="retail-ecommerce">Retail & E-commerce</option>
                            <option value="education">Education</option>
                            <option value="consulting">Consulting</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="addressLine1">Street address <span class="req">*</span></label>
                        <div class="input-wrap">
                            <span class="input-icon">📍</span>
                            <input type="text" name="street_address" id="addressLine1"
                                placeholder="123 Main Street" oninput="trackProgress()">
                        </div>
                        <div class="input-error-msg" id="addressErr">Please enter your street address.</div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City <span class="req">*</span></label>
                            <div class="input-wrap">
                                <span class="input-icon">🏙</span>
                                <input type="text" name="city" id="city" placeholder="New York"
                                    oninput="trackProgress()">
                            </div>
                            <div class="input-error-msg" id="cityErr">Required.</div>
                        </div>
                        <div class="form-group">
                            <label for="state">State / Province</label>
                            <div class="input-wrap">
                                <span class="input-icon">🗺</span>
                                <input type="text" name="state_province" id="state" placeholder="NY"
                                    oninput="trackProgress()">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="zip">ZIP / Postal code</label>
                            <div class="input-wrap">
                                <span class="input-icon">📮</span>
                                <input type="text" name="zip_postal_code" id="zip" placeholder="10001"
                                    oninput="trackProgress()">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select name="country" id="country" class="no-icon" onchange="trackProgress()">
                                <option value="" disabled selected>Select…</option>
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Australia">Australia</option>
                                <option value="Germany">Germany</option>
                                <option value="France">France</option>
                                <option value="Singapore">Singapore</option>
                                <option value="India">India</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- Contact / SMS -->
                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-label">📱 Mobile &amp; SMS</div>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile number <span class="req">*</span></label>
                        <div class="phone-row">
                            <div class="phone-country">
                                <select id="countryCode" name="country_code" class="no-icon"
                                    style="height:100%; padding: 11px 28px 11px 10px; font-size:0.85rem;"
                                    onchange="trackProgress()">
                                    <option value="+1">🇺🇸 +1</option>
                                    <option value="+1ca">🇨🇦 +1</option>
                                    <option value="+44">🇬🇧 +44</option>
                                    <option value="+61">🇦🇺 +61</option>
                                    <option value="+49">🇩🇪 +49</option>
                                    <option value="+33">🇫🇷 +33</option>
                                    <option value="+65">🇸🇬 +65</option>
                                    <option value="+91">🇮🇳 +91</option>
                                </select>
                            </div>
                            <div class="phone-number">
                                <div class="input-wrap">
                                    <span class="input-icon">📱</span>
                                    <input type="tel" id="mobile" name="mobile_number"
                                        placeholder="(555) 000-0000" oninput="formatPhone(this); trackProgress()">
                                </div>
                            </div>
                        </div>
                        <div class="input-error-msg" id="mobileErr">Please enter a valid mobile number.</div>
                    </div>

                    <div class="sms-optin" id="smsOptin" onclick="toggleSms()">
                        <div class="sms-check {{ old('sms_notifications', $company?->sms_notifications ?? false) ? 'checked' : '' }}"
                            id="smsCheck">
                            <svg width="11" height="8" viewBox="0 0 11 8" fill="none">
                                <path d="M1 4l3 3 6-6" stroke="white" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="sms-text">
                            <strong>Enable SMS notifications</strong>
                            Receive invoice alerts, payment confirmations, and important account updates via text
                            message.
                        </div>
                    </div>

                    <input type="hidden" name="sms_notifications" id="smsNotifications"
                        value="{{ old('sms_notifications', $company?->sms_notifications ?? 0) }}">


                    <!-- Logo Upload -->
                    <div class="section-divider">
                        <div class="section-divider-line"></div>
                        <div class="section-divider-label">🖼 Company logo <span
                                style="font-weight:400; text-transform:none; letter-spacing:0; font-size:0.7rem; color:var(--muted-light)">
                                — optional</span></div>
                        <div class="section-divider-line"></div>
                    </div>

                    <div class="logo-upload-area" id="uploadArea">
                        <input type="file" name="logo" accept="image/*" onchange="handleLogoUpload(this)"
                            id="logoInput">
                        <div class="logo-upload-icon">📸</div>
                        <div class="logo-upload-label">Click to upload your logo</div>
                        <div class="logo-upload-hint">PNG, JPG or SVG · Max 2 MB</div>
                    </div>
                    <div class="logo-preview" id="logoPreview">
                        <img id="logoImg" src="" alt="Logo preview">
                        <div class="logo-preview-info">
                            <div class="logo-preview-name" id="logoName"></div>
                            <div class="logo-preview-size" id="logoSize"></div>
                        </div>
                        <div class="logo-preview-remove" onclick="removeLogo()">✕ Remove</div>
                    </div>

                    <!-- CTA -->
                    <button class="submit-btn" id="submitBtn" onclick="handleSubmit()">
                        <div class="spinner"></div>
                        <span class="btn-text">Save profile &amp; continue</span>
                        <span class="btn-arrow">→</span>
                    </button>
                </form>


                <div class="skip-link">
                    <a href="#" onclick="showSuccess(); return false;">Skip for now — I'll fill this in
                        later</a>
                </div>

                <div class="rp-footer">
                    <a href="#">Privacy</a><span>·</span>
                    <a href="#">Terms</a><span>·</span>
                    <a href="#">Help</a>
                </div>
            </div>

            <!-- SUCCESS SCREEN -->
            <div class="success-screen" id="successScreen">
                <div class="success-confetti">🎉</div>
                <h2>Profile saved!</h2>
                <p>Your company profile is all set. Head to your dashboard to start creating invoices.</p>

                <div class="success-card" id="summaryCard">
                    <!-- Populated by JS -->
                </div>

                <button class="btn-dash" onclick="window.location.href='{{ route('subscriber.dashboard') }}'">
                    Go to my dashboard →
                </button>

                <div class="rp-footer" style="margin-top:24px">
                    <a href="#">Privacy</a><span>·</span>
                    <a href="#">Terms</a><span>·</span>
                    <a href="#">Help</a>
                </div>
            </div>

        </div>
    </div>

    <script>
        let smsEnabled = true;

        // ── Phone formatter ──
        function formatPhone(input) {
            let raw = input.value.replace(/\D/g, '').slice(0, 10);
            if (raw.length >= 7) raw = `(${raw.slice(0,3)}) ${raw.slice(3,6)}-${raw.slice(6)}`;
            else if (raw.length >= 4) raw = `(${raw.slice(0,3)}) ${raw.slice(3)}`;
            else if (raw.length > 0) raw = `(${raw}`;
            input.value = raw;
        }

        // ── Display name toggle ──
        let displayNameEnabled = true;

        function toggleDisplayName() {
            displayNameEnabled = !displayNameEnabled;
            document.getElementById('dnCheckbox').classList.toggle('checked', displayNameEnabled);
        }

        // ── SMS toggle ──
        function toggleSms() {
            smsEnabled = !smsEnabled;
            const optin = document.getElementById('smsOptin');
            optin.classList.toggle('unchecked', !smsEnabled);
        }

        // ── Logo upload ──
        function handleLogoUpload(input) {
            const file = input.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            document.getElementById('logoImg').src = url;
            document.getElementById('logoName').textContent = file.name;
            document.getElementById('logoSize').textContent = (file.size / 1024).toFixed(1) + ' KB';
            document.getElementById('logoPreview').style.display = 'flex';
            document.getElementById('uploadArea').style.borderStyle = 'solid';
            document.getElementById('uploadArea').style.borderColor = 'var(--teal)';
        }

        function removeLogo() {
            document.getElementById('logoInput').value = '';
            document.getElementById('logoPreview').style.display = 'none';
            document.getElementById('uploadArea').style.borderStyle = 'dashed';
            document.getElementById('uploadArea').style.borderColor = 'var(--border)';
        }

        // ── Progress tracker ──
        const trackedFields = ['companyName', 'addressLine1', 'city', 'mobile'];

        function trackProgress() {
            let filled = 0;
            trackedFields.forEach(id => {
                const el = document.getElementById(id);
                if (el && el.value.trim()) filled++;
            });
            const industryVal = document.getElementById('industry').value;
            if (industryVal) filled++;
            const total = trackedFields.length + 1;
            const pct = Math.round((filled / total) * 100);
            document.getElementById('progressFill').style.width = pct + '%';
            document.getElementById('progressPct').textContent = pct + '%';
            document.getElementById('progressCount').textContent = `${filled} / ${total} fields`;
        }

        // ── Validation ──
        function validate() {
            let ok = true;
            const required = [{
                    id: 'firstName',
                    errId: 'firstNameErr'
                },
                {
                    id: 'lastName',
                    errId: 'lastNameErr'
                },
                {
                    id: 'email',
                    errId: 'emailErr'
                },
                {
                    id: 'companyName',
                    errId: 'companyNameErr'
                },
                {
                    id: 'addressLine1',
                    errId: 'addressErr'
                },
                {
                    id: 'city',
                    errId: 'cityErr'
                },
                {
                    id: 'mobile',
                    errId: 'mobileErr'
                },
            ];
            required.forEach(({
                id,
                errId
            }) => {
                const inp = document.getElementById(id);
                const err = document.getElementById(errId);
                if (!inp.value.trim()) {
                    inp.classList.add('error');
                    err.style.display = 'block';
                    ok = false;
                } else {
                    inp.classList.remove('error');
                    err.style.display = 'none';
                }
            });

            // Email format
            const emailInp = document.getElementById('email');
            if (emailInp.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInp.value)) {
                emailInp.classList.add('error');
                document.getElementById('emailErr').textContent = 'Please enter a valid email address.';
                document.getElementById('emailErr').style.display = 'block';
                ok = false;
            }
            return ok;
        }

        // ── Submit ──
        function handleSubmit() {
            if (!validate()) {
                shakeBtn(document.getElementById('submitBtn'));
                // scroll to first error
                const firstErr = document.querySelector('.error');
                if (firstErr) firstErr.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            setTimeout(() => {
                btn.classList.remove('loading');
                showSuccess();
            }, 1800);
        }

        function showSuccess() {
            const form = document.getElementById('profileForm');
            const screen = document.getElementById('successScreen');
            const fn = document.getElementById('firstName').value || '—';
            const ln = document.getElementById('lastName').value || '—';
            const email = document.getElementById('email').value || '—';
            const company = document.getElementById('companyName').value || '—';
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const country = document.getElementById('country').value;
            const loc = [city, state, country].filter(Boolean).join(', ') || '—';
            const mobile = document.getElementById('mobile').value || '—';

            const rows = [{
                    key: 'Name',
                    val: `${fn} ${ln}`
                },
                {
                    key: 'Email',
                    val: email
                },
                {
                    key: 'Company',
                    val: company
                },
                {
                    key: 'Location',
                    val: loc
                },
                {
                    key: 'Mobile',
                    val: mobile
                },
                {
                    key: 'SMS alerts',
                    val: smsEnabled ? '✓ Enabled' : '✗ Disabled'
                },
            ];
            document.getElementById('summaryCard').innerHTML = rows.map(r =>
                `<div class="sc-row"><span class="sc-key">${r.key}</span><span class="sc-val">${r.val}</span></div>`
            ).join('');

            form.style.display = 'none';
            screen.style.display = 'flex';
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function shakeBtn(btn) {
            btn.style.transform = 'translateX(-6px)';
            setTimeout(() => btn.style.transform = 'translateX(6px)', 80);
            setTimeout(() => btn.style.transform = 'translateX(-4px)', 160);
            setTimeout(() => btn.style.transform = 'translateX(4px)', 240);
            setTimeout(() => btn.style.transform = '', 320);
        }

        // Remove error on input
        document.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('input', () => {
                el.classList.remove('error');
                const errId = el.id + 'Err';
                const errEl = document.getElementById(errId);
                if (errEl) errEl.style.display = 'none';
            });
        });


        function toggleDisplayName() {
            const checkbox = document.getElementById('dnCheckbox');
            const input = document.getElementById('displayCompanyName');

            const isChecked = input.value === '1';

            if (isChecked) {
                input.value = '0';
                checkbox.classList.remove('checked');
            } else {
                input.value = '1';
                checkbox.classList.add('checked');
            }
        }


        function toggleSms() {
            const checkbox = document.getElementById('smsCheck');
            const input = document.getElementById('smsNotifications');

            const isChecked = input.value === '1';

            if (isChecked) {
                input.value = '0';
                checkbox.classList.remove('checked');
            } else {
                input.value = '1';
                checkbox.classList.add('checked');
            }

            trackProgress();
        }
    </script>
</body>

</html>
