<!-- resources/views/layouts/partials/admin-navbar.blade.php -->
<nav style="background-color: #b72024;" class="text-white shadow-lg">
    <div class="container-fluid px-4 py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <!-- Logo & Brand -->
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <img src="{{ asset('images/logo-UBD.png') }}" 
                     alt="Logo Univ A" 
                     height="40" 
                     class="me-3"
                     onerror="this.style.display='none'">
                <h1 class="h4 mb-0 fw-bold">Lab Management System</h1>
            </div>

            <!-- Navigation Menu -->
            <ul class="nav gap-3 flex-wrap">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link text-white px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                        <i class="bi bi-speedometer2 me-1"></i>
                        Dashboard
                    </a>
                </li>
                
           

                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Navigation Link Styles */
    .nav-link {
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
        text-decoration: none;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .nav-link.active-link {
        background-color: rgba(255, 255, 255, 0.2);
        border-bottom: 3px solid #ffffff;
        font-weight: 600;
    }

    /* Logout Button */
    .btn-logout {
        background-color: #ffffff;
        color: #b72024;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-logout:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Logo Hover Effect */
    nav img:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 15px 20px;
        }

        .h4 {
            font-size: 1rem;
        }

        .nav {
            margin-top: 10px;
        }

        .nav-link {
            padding: 6px 12px !important;
            font-size: 14px;
        }

        .btn-logout {
            padding: 6px 15px;
            font-size: 14px;
        }
    }
</style>