<!-- Modern E-Commerce Navigation Bar -->
<header class="vk-header sticky-top bg-white">
    <div class="container-fluid px-3 px-lg-5">
        <div class="vk-navbar d-flex align-items-center justify-content-between py-2 py-lg-3">
            
            <!-- 1. LOGO -->
            <a href="{{ url('/') }}" class="vk-brand d-flex align-items-center text-decoration-none">
                <img src="{{ asset('logo.png') }}?v={{ file_exists(public_path('logo.png')) ? filemtime(public_path('logo.png')) : time() }}" 
                     alt="Vastrkaya Logo" 
                     class="vk-logo-img" 
                     onerror="this.style.display='none'; document.getElementById('vk-fallback-logo').style.display='inline-flex';">
                
                <!-- Fallback stylish text logo in case image is missing -->
                <span id="vk-fallback-logo" class="vk-brand-fallback fw-bold text-dark text-uppercase tracking-wider" style="display: none;">
                    <span class="vk-brand-accent">V</span>astrkaya
                </span>
            </a>

            <!-- 2. SEARCH BAR (Desktop & Tablet) -->
            <div class="vk-search-container d-none d-md-block flex-grow-1 mx-3 mx-lg-5">
                <form action="{{ url('/search') }}" method="GET" class="vk-search-form position-relative">
                    <span class="vk-search-icon position-absolute top-50 translate-middle-y">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           name="q" 
                           class="form-control vk-search-input" 
                           placeholder="Search for clothes, brands, collections..." 
                           autocomplete="off">
                    <button type="submit" class="btn vk-search-btn position-absolute top-50 translate-middle-y">
                        Search
                    </button>
                </form>
            </div>

            <!-- 3. ACTION ICONS (Profile, Wishlist, Bag) -->
            <div class="vk-actions d-flex align-items-center gap-1 gap-sm-2 gap-lg-3">
                
                <!-- PROFILE DROPDOWN -->
                <div class="dropdown vk-dropdown">
                    <a href="javascript:void(0)" 
                       class="vk-action-link d-flex flex-column align-items-center text-decoration-none" 
                       id="profileDropdown" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        <div class="vk-icon-wrapper">
                            <i class="bi bi-person"></i>
                        </div>
                        <span class="vk-action-label d-none d-lg-inline">Profile</span>
                    </a>

                    <!-- Profile Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end vk-profile-menu border-0 shadow-lg p-0" aria-labelledby="profileDropdown">
                        <li class="p-3 bg-light border-bottom rounded-top">
                            <p class="mb-1 fw-bold text-dark small text-uppercase tracking-wider">Welcome {{ auth()->user()->name ?? "Vastrkaya" }}</p>
                            <p class="text-muted mb-2 font-13">Access your account & manage orders</p>
                            @guest
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/login') }}" class="btn btn-dark btn-sm flex-grow-1 fw-semibold rounded-pill py-1 shadow-sm">
                                        Login
                                    </a>
                                    <a href="{{ url('/register') }}" class="btn btn-outline-dark btn-sm flex-grow-1 fw-semibold rounded-pill py-1 shadow-sm">
                                        Sign Up
                                    </a>
                                </div>
                            @endguest
                        </li>
                        <li>
                            <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ url('/orders') }}">
                                <i class="bi bi-box-seam text-secondary"></i>
                                <span>My Orders</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ url('/wishlist') }}">
                                <i class="bi bi-heart text-secondary"></i>
                                <span>Wishlist</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ url('/addresses') }}">
                                <i class="bi bi-geo-alt text-secondary"></i>
                                <span>Saved Addresses</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <li>
                                    <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 text-danger"></i>
                                        <span>Admin Dashboard</span>
                                    </a>
                                </li>
                            @endif
                            <li class="pb-1">
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger" href="{{ route('logout') }}">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <!-- WISHLIST -->
                <a href="{{ url('/wishlist') }}" class="vk-action-link d-flex flex-column align-items-center text-decoration-none">
                    <div class="vk-icon-wrapper position-relative">
                        <i class="bi bi-heart"></i>
                        <span class="vk-badge position-absolute translate-middle badge rounded-pill bg-danger">
                            0
                        </span>
                    </div>
                    <span class="vk-action-label d-none d-lg-inline">Wishlist</span>
                </a>

                <!-- ADD TO CART / BAG -->
                <a href="{{ url('/cart') }}" class="vk-action-link d-flex flex-column align-items-center text-decoration-none">
                    <div class="vk-icon-wrapper position-relative">
                        <i class="bi bi-bag"></i>
                        <span class="vk-badge position-absolute translate-middle badge rounded-pill bg-dark">
                            0
                        </span>
                    </div>
                    <span class="vk-action-label d-none d-lg-inline">Bag</span>
                </a>

            </div>
        </div>

        <!-- MOBILE SEARCH BAR (Visible only on small screens) -->
        <div class="vk-mobile-search d-block d-md-none pb-2 pt-1">
            <form action="{{ url('/search') }}" method="GET" class="vk-search-form position-relative">
                <span class="vk-search-icon position-absolute top-50 translate-middle-y">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" 
                       name="q" 
                       class="form-control vk-search-input" 
                       placeholder="Search clothes, collections..." 
                       autocomplete="off">
            </form>
        </div>

    </div>
</header>