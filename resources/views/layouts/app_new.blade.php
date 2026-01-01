<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SG Finance')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --secondary: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --sidebar-width: 260px;
            --header-height: 70px;
            --footer-height: 40px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 14px;
            background: #f8fafc;
            color: #334155;
            overflow-x: hidden;
            height: 100vh;
        }

        /* Layout Container */
        .app-container {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #e5e7eb;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
            background: #f8fafc;
        }

        /* Header */
        .header {
            height: var(--header-height);
            background: white;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        /* Content Area */
        .content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8fafc;
        }

        /* Footer */
        .footer {
            height: var(--footer-height);
            background: white;
            border-top: 1px solid #e5e7eb;
            position: sticky;
            bottom: 0;
            z-index: 1030;
            display: flex;
            align-items: center;
        }

        .footer-content {
            font-size: 12px;
            color: #6b7280;
            padding: 0 20px;
        }

        /* Sidebar Styles */
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            background: white;
        }

        .sidebar-menu {
            padding: 15px;
            flex: 1;
        }

        .nav-link {
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 8px;
            font-size: 15px;
            color: #475569;
            transition: all 0.2s;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.2);
        }

        .nav-link i {
            width: 20px;
            font-size: 16px;
            margin-right: 12px;
        }

        /* Logo */
        .company-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #000c0b, #3e11a7);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        /* User Profile */
        .user-profile {
            padding: 15px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--primary-light);
        }

        /* Mobile Header */
        .mobile-header {
            display: none;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 10px 15px;
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .mobile-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu-btn {
            font-size: 24px;
            color: var(--primary);
            background: none;
            border: none;
        }

        /* User Actions */
        .user-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Search Bar */
        .search-container {
            display: block;
        }

        .search-container .form-control {
            font-size: 14px;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        /* Overlay for Mobile */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
            backdrop-filter: blur(3px);
        }

        .overlay.active {
            display: block;
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .mobile-header {
                display: block;
            }

            .header {
                display: none;
            }

            .search-container {
                display: none !important;
            }
        }

        /* Custom Styles */
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 20px;
            font-weight: 600;
            font-size: 16px;
        }

        .card-body {
            padding: 20px;
        }

        .btn {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: #4338ca;
            border-color: #4338ca;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(79, 70, 229, 0.2);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('styles')
</head>

<body>
    <!-- Overlay for Mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Mobile Header -->
    <div class="mobile-header" id="mobileHeader">
        <div class="mobile-nav">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-btn me-3" id="mobileMenuBtn">
                    <i class="bi bi-list"></i>
                </button>
                <div class="d-flex align-items-center">
                    <div class="company-logo me-2">
                        {{-- <i class="bi bi-people-fill"></i> --}}
                        <img src="{{ asset('img/assets/logo-sg.png') }}"
     class="img-fluid"
     style="max-height:40px;"
     alt="SG Finance">

                    </div>
                    <h5 class="mb-0 fw-bold"><span class="text-primary">Finance</span></h5>
                </div>
            </div>

            <div class="user-actions">
                <div>
                    <a href="{{ route('calculator') }}" target="_blank">
                        <i class="bi bi-calculator me-3"></i></a>
                </div>

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="btn btn-light position-relative" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 10px;">
                            5
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="width: 280px;">
                        <div class="dropdown-header fw-bold">Notifications</div>
                        <div class="dropdown-item">
                            <small class="text-primary fw-medium">New employee joined</small>
                            <div class="text-muted">2 hours ago</div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item text-center">View all</a>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="dropdown user-dropdown">
                    <div class="user-info" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=fff"
                                class="w-100 h-100" alt="Admin">
                        </div>
                        <span class="fw-medium d-none d-sm-inline">Admin</span>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2"></i>My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear me-2"></i>Settings
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger logout-btn" href="#">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- App Container -->
    <div class="app-container">

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <!-- Sidebar Header -->
            <div class="sidebar-header">
                <div class="d-flex align-items-center">
                    <div class="company-logo me-3">
                        {{-- <i class="bi bi-people-fill"></i> --}}
                        <img src="{{ asset('img/assets/logo-sg.png') }}"
     class="img-fluid"
     style="max-height:40px;"
     alt="SG Finance">
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0"><span class="text-primary">Finance</span></h4>
                        <small class="text-muted">Management System</small>
                    </div>
                    <button class="btn-close ms-auto d-lg-none" id="sidebarClose"></button>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="sidebar-menu">
                @include('layouts.partials.sidebar-menu')
            </div>

            <!-- User Profile in Sidebar -->
            {{-- <div class="user-profile">
                <div class="d-flex align-items-center">
                    <div class="user-avatar me-3">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=4f46e5&color=fff" 
                             class="w-100 h-100" alt="Admin User">
                    </div>
                    <div>
                        <div class="fw-bold">Admin User</div>
                        <small class="text-muted">Administrator</small>
                    </div>
                    <div class="dropdown ms-auto">
                        <button class="btn btn-link text-dark" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger logout-btn" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div> --}}
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">

            <!-- Desktop Header -->
            <header class="header d-none d-lg-block">
                @include('layouts.partials.header')
            </header>

            <!-- Content Area -->
            <div class="content">
                <!-- Page Header -->
                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h3 class="fw-bold mb-2">@yield('page-title', 'Dashboard')</h3>
                                    <p class="text-muted mb-0">@yield('page-description', 'Welcome back! Here\'s what\'s happening today.')</p>
                                </div>
                                <div class="d-flex gap-2">
                                    @yield('page-actions')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer">
                @include('layouts.partials.footer')
            </footer>
        </main>
    </div>
    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}


    <!-- Main Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebarClose = document.getElementById('sidebarClose');

            // Toggle sidebar on mobile
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.add('active');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            // Close sidebar
            sidebarClose.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            });

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 991) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnMobileBtn = mobileMenuBtn.contains(event.target);

                    if (!isClickInsideSidebar && !isClickOnMobileBtn && sidebar.classList.contains(
                        'active')) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                        document.body.style.overflow = 'auto';
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });

            // Logout functionality
            document.querySelectorAll('.logout-btn').forEach(logoutBtn => {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Are you sure you want to logout?')) {
                        // Add logout logic here
                        window.location.href = "{{ route('logout') }}";
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
