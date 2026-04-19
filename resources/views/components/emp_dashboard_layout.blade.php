<!DOCTYPE html>

@php
    $loginId = session('login_id');
    $role = session('role');
    $profileImage = null;

    if ($loginId && $role === 'employer') {
        $profileImage = DB::table('tbl_company')->where('login_id', $loginId)->value('company_logo');
    }
@endphp


<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employer Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    {{-- If your layout doesn't already include it, include Material Icons (Google) --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529;
            color: white;
            z-index: 1020;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            /* ensures everything stretches to full width */
            padding: 0;
            /* remove extra padding */
        }

        .sidebar-logo {
            height: 80px;
            /* fixed height for logo */
            border-bottom: 1px solid #343a40;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .logo-icon {
            height: 50px;
        }

        .logo-text {
            height: 25px;
        }

        .sidebar .nav {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 12px 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #495057;
            color: #fff;
        }


        /* Main content */
        main {
            margin-left: 250px;
            /* same as sidebar width */
            padding: 2rem;
            transition: margin-left 0.3s;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            /* start after sidebar */
            width: calc(100% - 250px);
            background-color: white;
            z-index: 1030;
        }

        .navbar .nav-link,
        .navbar .dropdown-toggle {
            color: #fff;
        }

        .navbar .nav-link:hover {
            color: #ffc107;
        }

        .logo-icon {
            height: 80px;
            margin-right: 5px;
            /* adjust spacing */
        }

        .logo-text {
            height: 80px;
            margin-left: -75px;
            /* remove extra padding inside image */
            display: inline-block;
        }

        /* Notifications badge */
        .nav-item .badge {
            font-size: 0.65rem;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }




        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            main {
                margin-left: 200px;
            }

            .navbar {
                left: 200px;
                width: calc(100% - 200px);
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <!-- Logo on top -->
        <div class="sidebar-logo d-flex align-items-center justify-content-start p-3">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo" class="logo-icon me-2">
            <img src="{{ asset('images/text-logo-white.png') }}" alt="Text Logo" class="logo-text">
        </div>

        <!-- Menu -->
        <ul class="nav flex-column w-100">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('employer/dashboard') ? 'active' : '' }}"
                    href="{{ route('employer.dashboard') }}">
                    <i class="bi bi-house-door me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('employer/jobs*') ? 'active' : '' }}"
                    href="{{ route('employer.jobs.index') }}">

                    <i class="bi bi-briefcase me-2"></i> Manage Jobs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('employer/applicants*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-people me-2"></i> Applicants
                </a>
            </li>
        </ul>
    </div>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">

        <div class="container-fluid">

            <h5>👋 Welcome to the Employer Dashboard</h5>

            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Notifications -->
                <li class="nav-item me-3 position-relative">
                    <a class="nav-link" href="#" title="Notifications">
                        <span class="material-symbols-outlined text-dark">notifications</span>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </a>
                </li>

                <!-- Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown"
                        data-bs-toggle="dropdown">
                        @if ($profileImage)
                            <img src="{{ asset('storage/' . $profileImage) }}" alt="Profile" class="profile-img me-2">
                        @else
                            <img src="{{ asset('images/user-logo.png') }}" alt="Profile" class="profile-img me-2">
                        @endif

                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-5 mt-5">
        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
