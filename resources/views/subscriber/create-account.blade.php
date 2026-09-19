<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sign in to Velo to manage invoices, quotes, payments, and client portals.">
    <title>Velo - Sign in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <main class="auth-page">
        <section class="brand-panel d-none d-lg-flex flex-column justify-content-between"
            aria-label="Velo product summary">
            <a class="brand-logo" href="{{ route('home') }}" aria-label="Velo home">Velo<span>.</span></a>

            <div class="brand-content">
                <h1 class="brand-title">Your business,<br><em>beautifully billed.</em></h1>
                <p class="brand-copy">Invoices, quotes, payments, and client portals &mdash; all in one place. Join
                    4,200+ businesses who get paid faster with Velo.</p>

                <article class="dashboard-preview" aria-label="Dashboard preview">
                    <div class="preview-window-bar">
                        <span class="window-dot dot-red"></span>
                        <span class="window-dot dot-gold"></span>
                        <span class="window-dot dot-green"></span>
                    </div>
                    <div class="preview-body">
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <div class="stat-card">
                                    <p class="stat-label">Revenue MTD</p>
                                    <strong class="stat-value">$24,810</strong>
                                    <span class="stat-change text-success-soft">&uarr; 18% vs last month</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="stat-card">
                                    <p class="stat-label">Outstanding</p>
                                    <strong class="stat-value">$8,340</strong>
                                    <span class="stat-change text-warning-soft">3 due soon</span>
                                </div>
                            </div>
                        </div>

                        <ul class="invoice-list list-unstyled mb-0">
                            <li>
                                <span>Acme Corp &middot; #INV-1042</span>
                                <span class="status-pill status-paid">Paid</span>
                            </li>
                            <li>
                                <span>Blue Harbor &middot; #INV-1041</span>
                                <span class="status-pill status-pending">Pending</span>
                            </li>
                            <li>
                                <span>Studio Nora &middot; #INV-1040</span>
                                <strong>$950</strong>
                            </li>
                        </ul>
                    </div>
                </article>
            </div>

            <p class="brand-foot mb-0">&copy; 2026 Velo Technologies, Inc.</p>
        </section>

        <section class="auth-panel d-flex align-items-center justify-content-center">
            <div class="auth-shell w-100">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="auth-form is-visible" id="signupForm" method="POST"
                    action="{{ route('create-account') }}">
                    @csrf
                    <input type="hidden" name="amount" value="{{ request('amount') }}">
                    <header>
                        <h2 class="auth-heading">Create your account</h2>
                        <p class="auth-sub">Start your 14-day free trial &mdash; no credit card needed</p>
                    </header>


                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label" for="firstName">First name</label>
                            <input class="form-control" type="text" id="firstName" name="first_name"
                                placeholder="Jane" autocomplete="given-name" required>
                            <div class="invalid-feedback">Required.</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="lastName">Last name</label>
                            <input class="form-control" type="text" id="lastName" name="last_name"
                                placeholder="Smith" autocomplete="family-name" required>
                            <div class="invalid-feedback">Required.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="signupEmail">Work email</label>
                        <input class="form-control" type="email" id="signupEmail" name="email"
                            placeholder="you@company.com" autocomplete="email" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="signupPassword">Password</label>
                        <div class="password-field">
                            <input class="form-control" type="password" id="signupPassword" name="password"
                                placeholder="Create a strong password" autocomplete="new-password" minlength="8"
                                required>
                            <button class="password-toggle" type="button" data-toggle-password="signupPassword"
                                aria-label="Show password">
                                <svg viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z" />
                                    <circle cx="8" cy="8" r="2" />
                                </svg>
                            </button>
                        </div>
                        <div class="invalid-feedback">Password must be at least 8 characters.</div>
                        <div class="strength-meter d-none" id="strengthMeter" aria-live="polite">
                            <div class="strength-bars"><span></span><span></span><span></span><span></span></div>
                            <small id="strengthLabel"></small>
                        </div>
                    </div>

                    <p class="terms-note">By creating an account you agree to our <a href="#">Terms of
                            Service</a> and <a href="#">Privacy Policy</a>. You'll receive product updates and
                        billing emails.</p>

                    <button class="btn submit-btn" id="signupSubmit" type="submit">
                        <span class="btn-text">Create account</span>
                        <span class="btn-spinner" aria-hidden="true"></span>
                    </button>

                    <p class="switch-prompt">Already have an account? <button type="button"
                            data-auth-tab="login">Sign in</button></p>
                </form>

                <form class="forgot-panel" id="forgotForm" novalidate>
                    <button class="back-button" type="button" data-hide-forgot>
                        <svg viewBox="0 0 14 14" aria-hidden="true">
                            <path d="M9 2 4 7l5 5" />
                        </svg>
                        Back to sign in
                    </button>

                    <header class="mt-4">
                        <h2 class="auth-heading">Reset your password</h2>
                        <p class="auth-sub">Enter your email and we'll send you a reset link.</p>
                    </header>

                    <div class="alert auth-alert d-none" id="forgotError" role="alert">
                        <span class="alert-icon">!</span>
                        <span>Please enter a valid email address.</span>
                    </div>

                    <div class="mb-3 forgot-input-group">
                        <label class="form-label" for="forgotEmail">Email address</label>
                        <input class="form-control" type="email" id="forgotEmail" placeholder="you@company.com"
                            autocomplete="email" required>
                    </div>

                    <button class="btn submit-btn" id="forgotSubmit" type="submit">
                        <span class="btn-text">Send reset link</span>
                        <span class="btn-spinner" aria-hidden="true"></span>
                    </button>

                    <div class="success-state" id="forgotSuccess">
                        <div class="success-icon" aria-hidden="true">&#9993;</div>
                        <h3>Check your email</h3>
                        <p>We've sent a password reset link to <strong id="forgotEmailShow"></strong>. It'll expire in
                            30 minutes.</p>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        document.getElementById('googleLogin').addEventListener('click', function() {
            window.location.href = "{{ route('auth.google.redirect') }}";
        });

        document.getElementById('appleLogin').addEventListener('click', function() {
            window.location.href = "{{ route('auth.apple.redirect') }}";
        });
    </script>
</body>

</html>
