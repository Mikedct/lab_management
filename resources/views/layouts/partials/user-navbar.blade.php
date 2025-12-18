{{-- resources/views/layouts/partials/user-navbar.blade.php --}}
<nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #b72024;">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center text-white" href="{{ route('user.dashboard') }}">
            <img src="{{ asset('images/logo-UBD.png') }}" alt="Logo UBD"
                 height="36" class="me-2" onerror="this.style.display='none'">
            <span class="fw-bold">Lab Management System</span>
        </a>

        <button class="navbar-toggler text-white border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#userNavbar">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="userNavbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('user.dashboard') ? 'fw-semibold' : '' }}"
                       href="{{ route('user.dashboard') }}">
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('user.schedule') ? 'fw-semibold' : '' }}"
                       href="{{ route('user.lab-schedule.index') }}">
                        Jadwal Lab
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('user.reports.*') ? 'fw-semibold' : '' }}"
                        href="{{ route('user.reports.index') }}">
                        Report
                    </a>
                </li>
            </ul>

            <form class="d-flex ms-lg-3" method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-outline-light btn-sm" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
