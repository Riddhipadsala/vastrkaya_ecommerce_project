<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Vastrkaya Luxury E-Commerce')</title>

    <!-- Pre-load theme script to prevent flicker -->
    <script>
        (function() {
            try {
                var savedTheme = localStorage.getItem('vk_admin_theme') || 
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', savedTheme);
            } catch (e) {}
        })();
    </script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tailwind CSS & Vastrkaya Admin Custom CSS -->
    @vite(['resources/css/app.css', 'resources/css/admin-dashboard.css', 'resources/js/admin-dashboard.js', 'resources/js/app.js'])
    @yield('styles')
</head>

<body class="vk-admin-body">
    <div class="vk-admin-wrapper">

        @include('partials.sidebar')

        <!-- ====================================================================
             MAIN CONTENT WRAPPER
             ==================================================================== -->
        <div class="vk-main-content">
            
            <!-- Sticky Top Navigation Bar -->
            <header class="vk-topbar">
                <div class="vk-topbar-left">
                    <button type="button" class="vk-sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Toggle Menu">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h1 class="h5 mb-0 fw-bold text-heading" id="pageTitleHeading">Admin Overview Dashboard</h1>
                        <span class="font-13 text-muted">Vastrkaya E-Commerce Store Control Center</span>
                    </div>
                </div>

                <div class="vk-topbar-right">
                    <!-- Global Search input -->
                    <div class="vk-search-box d-none d-md-block">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Search products, categories...">
                    </div>

                    <!-- Light / Dark Theme Switcher -->
                    <button type="button" class="vk-theme-toggle" id="themeToggleBtn" title="Toggle Light / Dark Mode">
                        <i class="bi bi-moon-stars-fill text-secondary"></i>
                    </button>

                    <!-- Notifications Dropdown -->
                    <div class="dropdown">
                        <button class="vk-topbar-action" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="vk-action-dot"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 vk-card" aria-labelledby="notifDropdown" style="width: 300px;">
                            <li class="px-3 py-2 border-bottom border-light">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-bold">Notifications</h6>
                                    <span class="badge bg-danger rounded-pill">2 New</span>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-start gap-2" href="#stock" data-module-target="module-stock">
                                    <i class="bi bi-exclamation-triangle-fill text-warning mt-1"></i>
                                    <div>
                                        <p class="mb-0 font-13 fw-semibold">Low Stock Alert</p>
                                        <small class="text-muted">Silk Anarkali Suit has only 2 units left</small>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-start gap-2" href="#stock" data-module-target="module-stock">
                                    <i class="bi bi-x-circle-fill text-danger mt-1"></i>
                                    <div>
                                        <p class="mb-0 font-13 fw-semibold">Out of Stock</p>
                                        <small class="text-muted">Banarasi Silk Saree is out of stock</small>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Admin User Dropdown -->
                    <div class="dropdown">
                        <div class="vk-admin-dropdown-btn" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                            <div class="vk-admin-avatar-sm">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="vk-admin-header-name d-none d-sm-inline dynamic-admin-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <i class="bi bi-chevron-down text-muted font-13"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-2 vk-card">
                            <li class="px-3 py-2 border-bottom border-light">
                                <div class="fw-bold dynamic-admin-name">{{ Auth::user()->name ?? 'Administrator' }}</div>
                                <small class="text-muted">{{ Auth::user()->email ?? 'admin@gmail.com' }}</small>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('admin.profile.index') }}">
                                    <i class="bi bi-person text-primary"></i>
                                    <span>Admin Profile</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 text-danger d-flex align-items-center gap-2" href="{{ route('logout') }}">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Body: Content Render Area -->
            <main class="vk-page-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3" role="alert">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="py-3 px-4 border-top border-light text-muted font-13 d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    &copy; {{ date('Y') }} <strong class="text-heading">Vastrkaya E-Commerce</strong>. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

        <!-- ========================================================================
         CONFIRM DELETE OPTION MODAL
         ======================================================================== -->
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 rounded-4 shadow">

                    <div class="modal-body text-center p-4">

                        <i class="bi bi-trash3-fill text-danger fs-1"></i>

                        <h5 class="fw-bold mt-3">Delete Option?</h5>

                        <p class="text-muted small">
                            Are you sure you want to delete
                            <strong id="deleteOptionNameDisplay">this option</strong>?
                        </p>

                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-light border"
                                    data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="button" class="btn btn-danger"
                                    id="confirmDeleteBtn">
                                <i class="bi bi-trash3"></i> Delete
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    @yield('scripts')
</body>

</html>
