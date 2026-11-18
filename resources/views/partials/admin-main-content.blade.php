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
            <!-- Notifications Dropdown -->
            <div class="dropdown">
                <button type="button"
                    class="vk-topbar-action"
                    id="notificationDropdownBtn"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                    title="Notifications">

                    <i class="bi bi-bell-fill"></i>

                    <span class="vk-notification-badge" id="notificationCount">
                    </span>

                </button>

                <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-0 vk-notification-dropdown" aria-labelledby="notificationDropdownBtn">
                    <!-- Header -->
                    <div class="vk-notification-header">
                        <div class="d-flex align-items-center gap-2">
                            <h6 class="mb-0 fw-bold text-heading font-14">Notifications</h6>
               
                            <span class="badge rounded-pill bg-danger-subtle text-danger font-11 px-2 py-0.5 fw-bold" id="notificationNewCount"></span>
                        </div>
                        <button type="button"
                            id="markAllReadBtn"
                            class="btn btn-link p-0 text-decoration-none font-12 text-muted"
                            title="Mark all read">
                            Mark all read
                        </button>
                    </div>

                    <!-- Scrollable Notification List -->
                    <div class="vk-notification-list" id="notificationList">
                        
                    </div>
                </div>
            </div>

            <!-- Light / Dark Theme Switcher -->
            <button type="button" class="vk-theme-toggle" id="themeToggleBtn" title="Toggle Light / Dark Mode">
                <i class="bi bi-moon-stars-fill text-secondary"></i>
            </button>

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