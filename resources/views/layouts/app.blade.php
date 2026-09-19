<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <base href="/">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    @stack('css')
</head>

<body class="invoicepro-page">

    {{-- Navbar --}}
    @include('partials.navbar')


    @yield('content')


    {{-- Footer --}}
    @include('partials.footer')

    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>
    @stack('scripts')

</body>

</html>
