<!DOCTYPE html>
<html lang="en">

@php
    $loginId = session('login_id');
    $role = session('role');

    $profileImage = null;

    if ($loginId && $role === 'seeker') {
        $profileImage = DB::table('tbl_seeker_profile')->where('login_id', $loginId)->value('seeker_photo');
    }
@endphp


<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seeker Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Include Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


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

        .swal2-container.swal2-top-end {
            top: 80px !important;
        }

        .swal2-popup.swal2-toast {
            border-radius: 10px;
            padding: 10px 15px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            {{-- Logo --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ route('seeker.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="CareerCraft Logo" class="logo-icon">
                <img src="{{ asset('images/text-logo-black.png') }}" alt="CareerCraft Text" class="logo-text">
            </a>

            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('seeker.index') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('seeker.about') }}">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('seeker.jobs') }}">Jobs</a>
                </li>

            </ul>

            {{-- Right side icons and profile --}}
            <ul class="navbar-nav ms-auto align-items-center">
                {{-- Saved Jobs --}}
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="#" title="My Jobs">
                        <i class="bi bi-briefcase-fill fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            5
                        </span>
                    </a>


                </li>

                {{-- Notifications --}}
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="#" title="Notifications">
                        <i class="bi bi-bell-fill fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>
                </li>

                {{-- Notifications --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('seeker.payment.page') }}">


                        <i class="fas fa-crown" style="color: gold;"></i>
                        </span>
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
                        {{-- <img src="{{ asset('images/user-logo.png') }}" alt="Profile" class="profile-img me-2"> --}}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('seeker.profile') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Applications</a></li>
                        <li> <a class="nav-link" href="{{ route('seeker.payment.page') }}">
                                <i class="fas fa-crown" style="color: gold;"></i> Premium
                            </a></li>
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
    <footer class="bg-light text-center py-3 border-top fixed-bottom">
        <small>&copy; {{ date('Y') }} Job Portal. All rights reserved.</small>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>
