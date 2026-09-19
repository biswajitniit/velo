<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sign in to Velo to manage invoices, quotes, payments, and client portals.">
    <title>Velo - Admin</title>
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
            <a class="brand-logo" href="{{ route('admin.login') }}" aria-label="Velo home">Velo<span>.</span></a>

            <div class="brand-content">
                <h1 class="brand-title">Your business,<br><em>beautifully billed.</em></h1>


            </div>

            <p class="brand-foot mb-0">&copy; {{ date('Y') }} Velo Technologies, Inc.</p>
        </section>

        <section class="auth-panel d-flex align-items-center justify-content-center">
            <div class="auth-shell w-100">


                <form class="auth-form is-visible" id="loginForm" method="POST"
                    action="{{ route('admin.login.submit') }}">

                    @csrf

                    <header>
                        <h2 class="auth-heading">Welcome back</h2>
                        <p class="auth-sub">Admin in to your Velo account</p>
                    </header>

                    {{-- Success Message --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Error Message --}}
                    @if (session('error'))
                        <div class="alert auth-alert" role="alert">
                            <span class="alert-icon">!</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label" for="loginEmail">
                            Email address
                        </label>

                        <input class="form-control @error('email') is-invalid @enderror" type="email" id="loginEmail"
                            name="email" value="{{ old('email') }}" placeholder="you@company.com"
                            autocomplete="email" required>

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">

                        <label class="form-label" for="loginPassword">
                            Password
                        </label>

                        <div class="password-field">

                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                id="loginPassword" name="password"
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

                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <button class="btn submit-btn" id="loginSubmit" type="submit">

                        <span class="btn-text">
                            Sign in to Velo
                        </span>

                        <span class="btn-spinner" aria-hidden="true"></span>

                    </button>

                </form>


            </div>
        </section>
    </main>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/script.js') }}"></script> --}}
</body>

</html>
