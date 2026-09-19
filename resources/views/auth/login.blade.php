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
                <ul class="nav auth-tabs" id="authTabs" role="tablist" aria-label="Authentication options">
                    <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link active w-100" id="login-tab" type="button" data-auth-tab="login"
                            aria-selected="true">Sign in</button>
                    </li>
                    {{-- <li class="nav-item flex-fill" role="presentation">
                        <button class="nav-link w-100" id="signup-tab" type="button" data-auth-tab="signup"
                            aria-selected="false">Create account</button>
                    </li> --}}
                </ul>

                <form class="auth-form is-visible" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <header>
                        <h2 class="auth-heading">Welcome back</h2>
                        <p class="auth-sub">Sign in to your Velo account</p>
                    </header>

                    @if ($errors->any())
                        <div class="alert auth-alert" role="alert">
                            <span class="alert-icon">!</span>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <div class="d-grid gap-2 mb-4">
                        <button class="btn social-btn" type="button" data-social="google">
                            <svg class="social-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="#4285F4"
                                    d="M23.49 12.27c0-.79-.07-1.54-.2-2.27H12v4.29h6.47c-.28 1.5-1.13 2.77-2.4 3.62v2.96h3.89c2.27-2.09 3.53-5.17 3.53-8.6z" />
                                <path fill="#34A853"
                                    d="M12 24c3.24 0 5.96-1.07 7.95-2.91l-3.89-2.96c-1.08.72-2.46 1.15-4.06 1.15-3.12 0-5.77-2.11-6.72-4.95H1.26v3.05C3.24 21.31 7.31 24 12 24z" />
                                <path fill="#FBBC05"
                                    d="M5.28 14.33c-.24-.72-.38-1.49-.38-2.33s.14-1.61.38-2.33V6.62H1.26C.45 8.24 0 10.07 0 12s.45 3.76 1.26 5.38l4.02-3.05z" />
                                <path fill="#EA4335"
                                    d="M12 4.72c1.76 0 3.34.61 4.59 1.8l3.45-3.45C17.95 1.13 15.23 0 12 0 7.31 0 3.24 2.69 1.26 6.62l4.02 3.05C6.23 6.83 8.88 4.72 12 4.72z" />
                            </svg>
                            Continue with Google
                        </button>
                        <button class="btn social-btn social-btn-dark" type="button" data-social="apple">
                            <svg class="social-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="currentColor"
                                    d="M17.06 12.43c-.03-3.02 2.47-4.47 2.58-4.54-1.41-2.06-3.61-2.34-4.39-2.37-1.87-.19-3.65 1.1-4.6 1.1-.95 0-2.42-1.07-3.98-1.04-2.05.03-3.94 1.19-5 3.03-2.13 3.7-.55 9.18 1.53 12.17 1.01 1.46 2.22 3.11 3.81 3.05 1.53-.06 2.1-.99 3.95-.99 1.84 0 2.36.99 3.98.96 1.64-.03 2.68-1.49 3.68-2.96 1.16-1.7 1.64-3.35 1.67-3.43-.04-.02-3.2-1.23-3.23-4.98zM14.03 3.55c.84-1.02 1.41-2.43 1.25-3.84-1.21.05-2.67.8-3.54 1.82-.78.9-1.46 2.34-1.28 3.72 1.35.1 2.73-.69 3.57-1.7z" />
                            </svg>
                            Continue with Apple
                        </button>
                    </div>

                    <div class="divider"><span></span><small>or sign in with email</small><span></span></div>

                    <div class="alert auth-alert d-none" id="loginError" role="alert">
                        <span class="alert-icon">!</span>
                        <span>Invalid email or password. Please try again.</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="loginEmail">Email address</label>
                        <input class="form-control" type="email" name="email" id="loginEmail"
                            placeholder="you@company.com" autocomplete="email" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="loginPassword">Password</label>
                        <div class="password-field">
                            <input class="form-control" type="password" name="password" id="loginPassword"
                                placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;"
                                autocomplete="current-password" required>
                            <button class="password-toggle" type="button" data-toggle-password="loginPassword"
                                aria-label="Show password">
                                <svg viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z" />
                                    <circle cx="8" cy="8" r="2" />
                                </svg>
                            </button>
                        </div>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                        <button class="link-button" type="button" data-show-forgot>Forgot password?</button>
                    </div>

                    <button class="btn submit-btn" id="loginSubmit" type="submit">
                        <span class="btn-text">Sign in to Velo</span>
                        <span class="btn-spinner" aria-hidden="true"></span>
                    </button>

                    <p class="switch-prompt">Don't have an account? <button type="button"
                            data-auth-tab="signup">Create one free</button></p>
                </form>

                <form class="auth-form" id="signupForm" method="POST" action="{{ route('register') }}">
                    @csrf
                    <header>
                        <h2 class="auth-heading">Create your account</h2>
                        <p class="auth-sub">Start your 14-day free trial &mdash; no credit card needed</p>
                    </header>

                    <div class="d-grid gap-2 mb-4">
                        <button class="btn social-btn" type="button" data-social="google" id="googleLogin"><svg
                                class="social-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="#4285F4"
                                    d="M23.49 12.27c0-.79-.07-1.54-.2-2.27H12v4.29h6.47c-.28 1.5-1.13 2.77-2.4 3.62v2.96h3.89c2.27-2.09 3.53-5.17 3.53-8.6z" />
                                <path fill="#34A853"
                                    d="M12 24c3.24 0 5.96-1.07 7.95-2.91l-3.89-2.96c-1.08.72-2.46 1.15-4.06 1.15-3.12 0-5.77-2.11-6.72-4.95H1.26v3.05C3.24 21.31 7.31 24 12 24z" />
                                <path fill="#FBBC05"
                                    d="M5.28 14.33c-.24-.72-.38-1.49-.38-2.33s.14-1.61.38-2.33V6.62H1.26C.45 8.24 0 10.07 0 12s.45 3.76 1.26 5.38l4.02-3.05z" />
                                <path fill="#EA4335"
                                    d="M12 4.72c1.76 0 3.34.61 4.59 1.8l3.45-3.45C17.95 1.13 15.23 0 12 0 7.31 0 3.24 2.69 1.26 6.62l4.02 3.05C6.23 6.83 8.88 4.72 12 4.72z" />
                            </svg>Sign up with Google</button>
                        <button class="btn social-btn social-btn-dark" type="button" data-social="apple"
                            id="appleLogin"><svg class="social-icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill="currentColor"
                                    d="M17.06 12.43c-.03-3.02 2.47-4.47 2.58-4.54-1.41-2.06-3.61-2.34-4.39-2.37-1.87-.19-3.65 1.1-4.6 1.1-.95 0-2.42-1.07-3.98-1.04-2.05.03-3.94 1.19-5 3.03-2.13 3.7-.55 9.18 1.53 12.17 1.01 1.46 2.22 3.11 3.81 3.05 1.53-.06 2.1-.99 3.95-.99 1.84 0 2.36.99 3.98.96 1.64-.03 2.68-1.49 3.68-2.96 1.16-1.7 1.64-3.35 1.67-3.43-.04-.02-3.2-1.23-3.23-4.98zM14.03 3.55c.84-1.02 1.41-2.43 1.25-3.84-1.21.05-2.67.8-3.54 1.82-.78.9-1.46 2.34-1.28 3.72 1.35.1 2.73-.69 3.57-1.7z" />
                            </svg>Sign up with Apple</button>
                    </div>

                    <div class="divider"><span></span><small>or sign up with email</small><span></span></div>

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
                        <span class="btn-text">Create free account</span>
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
    {{-- <script src="{{ asset('assets/js/script.js') }}"></script> --}}
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
