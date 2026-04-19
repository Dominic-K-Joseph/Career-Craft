<!DOCTYPE html>
<html lang="en">

@php
    $loginId = session('login_id');
    $role = session('role');

    $profileImage = null;

    if ($loginId && $role === 'employer') {
        $profileImage = DB::table('tbl_company')->where('login_id', $loginId)->value('company_logo');
    }
@endphp


<head>
    <meta charset="UTF-8">
    <title>Employer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Include Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

    <style>
        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
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

        .btn-blue-800 {
            background-color: #1e40af !important;
            /* Tailwind $blue-800 hex */
            border-color: #1e40af !important;
            color: #fff !important;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg nnavbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            {{-- Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ route('seeker.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="CareerCraft Logo" class="logo-icon">
                <img src="{{ asset('images/text-logo-white.png') }}" alt="CareerCraft Text" class="logo-text">
            </a>

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('employer.index') }}">Home</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link text-light" href="{{ route('employer.dashboard') }}">Dashboard</a>
                </li> --}}
            </ul>

            {{-- Right side icons and profile --}}
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="{{ route('employer.dashboard') }}" title="Dashboard">
                        <span class="material-symbols-outlined" style="color: white">
                            dashboard
                        </span>
                    </a>
                </li>

                {{-- Notifications --}}
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="#" title="Notifications">
                        <span class="material-symbols-outlined" style="color: white">
                            notifications
                        </span>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>
                </li>

                {{-- Profile Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" href="#" id="profileDropdown" role="button">
                        @if ($profileImage)
                            <img src="{{ asset('storage/' . $profileImage) }}" alt="Profile" class="profile-img me-2">
                        @else
                            <img src="{{ asset('images/user-logo.png') }}" alt="Profile" class="profile-img me-2">
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{route('employer.profile.edit')}}">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Applications</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container py-4">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    <footer class="bg-light text-center py-3 mt-4 border-top">
        <small>&copy; {{ date('Y') }} Job Portal. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
