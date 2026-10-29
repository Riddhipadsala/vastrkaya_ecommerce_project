<!-- Mobile Backdrop -->
<div class="vk-sidebar-backdrop" id="sidebarBackdrop"></div>

<!-- ====================================================================
     ADMIN SIDEBAR
     ==================================================================== -->
<aside class="vk-sidebar" id="adminSidebar">
    <!-- Sidebar Header -->
    <div class="vk-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="vk-sidebar-brand">
            <img src="{{ asset('logo.png') }}" alt="Vastrkaya Logo" style="max-height: 40px; width: auto;">
        </a>
    </div>

    <!-- Sidebar Navigation Menu -->
    <ul class="vk-sidebar-menu">
        <li class="vk-menu-section-title">Core Modules</li>

        <li class="vk-nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="vk-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill vk-nav-icon"></i>
                <span>Overview Dashboard</span>
            </a>
        </li>

        <li class="vk-nav-item">
            <a href="{{ route('admin.categories.index') }}"
                class="vk-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill vk-nav-icon"></i>
                <span>Category Module</span>
            </a>
        </li>

        <li class="vk-nav-item">
            <a href="{{ route('admin.products.index') }}"
                class="vk-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill vk-nav-icon"></i>
                <span>Product Module</span>
            </a>
        </li>

        <li class="vk-nav-item">
            <a href="{{ route('admin.options.index') }}"
                class="vk-nav-link {{ request()->routeIs('admin.options.*') ? 'active' : '' }}">
                <i class="bi bi-sliders2 vk-nav-icon"></i>
                <span>Option Module</span>
            </a>
        </li>

        <li class="vk-nav-item">
            <a href="{{ route('admin.stock.index') }}"
                class="vk-nav-link {{ request()->routeIs('admin.stock.*') ? 'active' : '' }}">
                <i class="bi bi-stack vk-nav-icon"></i>
                <span>Current Stock Available</span>
                <span class="vk-nav-badge bg-warning text-dark">Alerts</span>
            </a>
        </li>

        <li class="vk-nav-item">
            <a href="{{ route('admin.coupons.index') }}"
                class="vk-nav-link {{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                <i class="bi bi-ticket-perforated-fill vk-nav-icon"></i>
                <span>Coupon Module</span>
            </a>
        </li>

        <li class="vk-menu-section-title">Account & Settings</li>

        <li class="vk-nav-item">
            <a href="{{ route('admin.profile.index') }}"
                class="vk-nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge-fill vk-nav-icon"></i>
                <span>Admin Profile</span>
            </a>
        </li>

        <li class="vk-nav-item">
            <a href="{{ route('admin.settings.index') }}"
                class="vk-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill vk-nav-icon"></i>
                <span>Store Settings</span>
            </a>
        </li>

        <li class="vk-nav-item mt-4 pt-2 border-top border-secondary border-opacity-10">
            <a href="{{ route('dashboard') }}" class="vk-nav-link text-muted" target="_blank">
                <i class="bi bi-box-arrow-up-right vk-nav-icon"></i>
                <span>View Customer Store</span>
            </a>
        </li>
    </ul>

    <!-- Sidebar Footer: Admin Profile Brief -->
    <div class="vk-sidebar-footer">
        <div class="vk-sidebar-user">
            <div class="vk-sidebar-avatar-fallback">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="vk-sidebar-user-info">
                <div class="vk-sidebar-user-name dynamic-admin-name">{{ Auth::user()->name ?? 'Super Admin' }}</div>
                <div class="vk-sidebar-user-role">Administrator</div>
            </div>
            <a href="{{ route('logout') }}" class="ms-auto text-muted p-1 hover-danger" title="Logout">
                <i class="bi bi-box-arrow-right fs-5"></i>
            </a>
        </div>
    </div>
</aside>
