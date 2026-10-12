@extends('main')
@section('title', 'Login - Vastrkaya Ethnic & Modern Couture')
@php
    $show_navbar = true;
    $show_footer = true;
@endphp

@section('hero-section')
<section class="vk-auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="vk-auth-card">
                    <div class="row g-0">
                        
                        <!-- LEFT SHOWCASE BANNER (Desktop Only) -->
                        <div class="col-lg-5 d-none d-lg-block p-0">
                            <div class="vk-auth-side-banner">
                                <div>
                                    <div class="vk-auth-banner-badge">
                                        <i class="bi bi-stars"></i> Vastrkaya Heritage
                                    </div>
                                    <h2 class="vk-auth-banner-title">
                                        Experience Timeless Elegance
                                    </h2>
                                    <p class="vk-auth-banner-desc">
                                        Step into a curated realm of royal ethnic wear, artisanal silks, and contemporary luxury outfits.
                                    </p>

                                    <!-- Perks List -->
                                    <ul class="vk-auth-perks">
                                        <li class="vk-auth-perk-item">
                                            <span class="vk-auth-perk-icon">
                                                <i class="bi bi-patch-check-fill"></i>
                                            </span>
                                            <span>100% Authentic Handcrafted Fabrics</span>
                                        </li>
                                        <li class="vk-auth-perk-item">
                                            <span class="vk-auth-perk-icon">
                                                <i class="bi bi-gift-fill"></i>
                                            </span>
                                            <span>Flat ₹500 Off with Code: <strong>VASTRA500</strong></span>
                                        </li>
                                        <li class="vk-auth-perk-item">
                                            <span class="vk-auth-perk-icon">
                                                <i class="bi bi-truck"></i>
                                            </span>
                                            <span>Express 48h Dispatch & Easy 7-Day Returns</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Glassmorphic Customer Quote Box -->
                                <div class="vk-auth-glass-box">
                                    <div class="d-flex align-items-center gap-1 text-warning mb-2" style="font-size: 0.85rem;">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span class="text-white ms-1 fw-bold">4.9 / 5</span>
                                    </div>
                                    <p class="text-white small mb-1 fst-italic" style="line-height: 1.4;">
                                        "The quality of the silk sarees and bridal couture is unparalleled. Fast delivery and premium finish!"
                                    </p>
                                    <span class="text-white-50" style="font-size: 0.75rem;">
                                        Trusted by 50,000+ patrons worldwide
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT AUTHENTICATION FORM -->
                        <div class="col-12 col-lg-7 p-0">
                            <div class="vk-auth-form-wrap">
                                
                                <div class="vk-auth-header">
                                    <span class="vk-section-badge mb-2">Welcome Back</span>
                                    <h2 class="vk-auth-header-title">Sign In to Your Account</h2>
                                    <p class="vk-auth-header-subtitle">
                                        Access your wishlist, order history, and exclusive member discounts.
                                    </p>
                                </div>

                                <!-- Quick Social Logins -->
                                <div class="vk-social-grid">
                                    <button type="button" class="vk-btn-social">
                                        <svg width="18" height="18" viewBox="0 0 24 24">
                                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                                        </svg>
                                        <span>Google</span>
                                    </button>
                                </div>

                                <div class="vk-auth-divider">
                                    <span>or sign in with email</span>
                                </div>

                                <!-- Login Form -->
                                <form action="{{ route('login.store') }}" method="POST">
                                    @csrf

                                    <!-- Email Address -->
                                    <div class="vk-form-group">
                                        <label for="email" class="vk-form-label">
                                            <span>Email Address or Phone</span>
                                        </label>
                                        <div class="vk-input-group">
                                            <i class="bi bi-envelope vk-input-icon"></i>
                                            <input type="email" 
                                                   id="email" 
                                                   name="email" 
                                                   class="vk-form-input" 
                                                   placeholder="name@example.com" 
                                                   required 
                                                   autocomplete="email">
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="vk-form-group">
                                        <label for="password" class="vk-form-label">
                                            <span>Password</span>
                                            <a href="#" class="vk-forgot-link">Forgot password?</a>
                                        </label>
                                        <div class="vk-input-group">
                                            <i class="bi bi-lock vk-input-icon"></i>
                                            <input type="password" 
                                                   id="password" 
                                                   name="password" 
                                                   class="vk-form-input" 
                                                   placeholder="••••••••••••" 
                                                   required 
                                                   autocomplete="current-password">
                                            <button type="button" class="vk-toggle-password" id="togglePasswordBtn" title="Toggle password visibility">
                                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Remember Me Checkbox -->
                                    <div class="d-flex align-items-center justify-content-between mt-3 mb-2">
                                        <label class="vk-form-check">
                                            <input type="checkbox" name="remember" id="remember" checked>
                                            <span>Remember me on this device</span>
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="vk-btn-auth-submit">
                                        <span>Sign In to Vastrkaya</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </button>

                                    <!-- Switch to Register -->
                                    <div class="vk-auth-switch">
                                        Don't have an account yet? 
                                        <a href="{{ url('/register') }}">Create an account free</a>
                                    </div>

                                    <!-- Security Note -->
                                    <div class="vk-auth-terms">
                                        <i class="bi bi-shield-check text-success me-1"></i> 
                                        Protected by 256-bit SSL encryption. By signing in, you agree to our 
                                        <a href="#">Terms of Service</a> & <a href="#">Privacy Policy</a>.
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Password Show/Hide Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && icon) {
            toggleBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        }
    });
</script>
@endsection
