<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'CareerCraft') }}</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <style>
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 450px;
            margin: 50px auto;
            /* space below navbar */
        }

        .card {
            border-radius: 1rem;
        }

        .logo-icon {
            height: 50px;
            margin-right: 5px;
            /* adjust spacing */
        }

        .logo-text {
            height: 50px;
            margin-left: -45px;
            /* remove extra padding inside image */
            display: inline-block;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            {{-- Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ route('seeker.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="CareerCraft Logo" class="logo-icon">
                <img src="{{ asset('images/text-logo-black.png') }}" alt="CareerCraft Text" class="logo-text">
            </a>

            {{-- Right Side --}}
            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('login') }}"
                    class="btn {{ request()->routeIs('login') ? 'btn-primary disabled' : 'btn-outline-primary' }} text-decoration-none fw-semibold">
                    Sign In
                </a>
                <a href="{{ route('register.form') }}"
                    class="btn {{ request()->routeIs('register') ? 'btn-primary disabled' : 'btn-outline-primary' }} text-decoration-none fw-semibold">
                    Sign Up
                </a>
            </div>

        </div>
    </nav>


    {{-- Page Content --}}
    <div class="auth-wrapper">
        {{ $slot }}
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
