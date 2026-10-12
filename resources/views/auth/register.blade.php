@extends('main')
@section('title', 'Register - Vastrkaya Ethnic & Modern Couture')
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
                            <div class="vk-auth-side-banner register-banner">
                                <div>
                                    <div class="vk-auth-banner-badge">
                                        <i class="bi bi-gem"></i> Privilege Club
                                    </div>
                                    <h2 class="vk-auth-banner-title">
                                        Unlock Exclusive Ethnic Haute Couture
                                    </h2>
                                    <p class="vk-auth-banner-desc">
                                        Join over 50,000+ fashion lovers celebrating authentic handlooms, royal silks, and contemporary styles.
                                    </p>

                                    <!-- Member Perks -->
                                    <ul class="vk-auth-perks">
                                        <li class="vk-auth-perk-item">
                                            <span class="vk-auth-perk-icon">
                                                <i class="bi bi-gift-fill"></i>
                                            </span>
                                            <span>Instant ₹500 Welcome Voucher</span>
                                        </li>
                                        <li class="vk-auth-perk-item">
                                            <span class="vk-auth-perk-icon">
                                                <i class="bi bi-lightning-charge-fill"></i>
                                            </span>
                                            <span>VIP Early Access to Festive Drops</span>
                                        </li>
                                        <li class="vk-auth-perk-item">
                                            <span class="vk-auth-perk-icon">
                                                <i class="bi bi-heart-pulse-fill"></i>
                                            </span>
                                            <span>Tailored Size & Styling Consultations</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Glassmorphic Testimonial Box -->
                                <div class="vk-auth-glass-box">
                                    <div class="d-flex align-items-center gap-1 text-warning mb-2" style="font-size: 0.85rem;">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span class="text-white ms-1 fw-bold">5.0 / 5</span>
                                    </div>
                                    <p class="text-white small mb-1 fst-italic" style="line-height: 1.4;">
                                        "Vastrkaya's pure silk collection transformed my wedding shopping experience. Flawless craftsmanship!"
                                    </p>
                                    <span class="text-white-50" style="font-size: 0.75rem;">
                                        Rhea & Siddharth, Verified Buyers
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT REGISTRATION FORM -->
                        <div class="col-12 col-lg-7 p-0">
                            <div class="vk-auth-form-wrap">
                                
                                <div class="vk-auth-header">
                                    <span class="vk-section-badge mb-2">New Membership</span>
                                    <h2 class="vk-auth-header-title">Create Your Account</h2>
                                    <p class="vk-auth-header-subtitle">
                                        Sign up in 30 seconds to enjoy personalized recommendations and instant offers.
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
                                    <span>or register with email</span>
                                </div>

                                <!-- Registration Form -->
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf

                                    <!-- Full Name -->
                                    <div class="vk-form-group">
                                        <label for="name" class="vk-form-label">
                                            <span>Full Name</span>
                                        </label>
                                        <div class="vk-input-group">
                                            <i class="bi bi-person vk-input-icon"></i>
                                            <input type="text" 
                                                   id="name" 
                                                   name="name" 
                                                   class="vk-form-input" 
                                                   placeholder="e.g. Priya Sharma" 
                                                   required 
                                                   autocomplete="name">
                                        </div>
                                    </div>

                                    <!-- Email & Phone (Grid) -->
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <div class="vk-form-group">
                                                <label for="reg_email" class="vk-form-label">
                                                    <span>Email Address</span>
                                                </label>
                                                <div class="vk-input-group">
                                                    <i class="bi bi-envelope vk-input-icon"></i>
                                                    <input type="email" 
                                                           id="reg_email" 
                                                           name="email" 
                                                           class="vk-form-input" 
                                                           placeholder="name@example.com" 
                                                           required 
                                                           autocomplete="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="vk-form-group">
                                                <label for="reg_phone" class="vk-form-label">
                                                    <span>Phone Number</span>
                                                </label>
                                                <div class="vk-input-group">
                                                    <i class="bi bi-telephone vk-input-icon"></i>
                                                    <input type="tel" 
                                                           id="reg_phone" 
                                                           name="phone" 
                                                           class="vk-form-input" 
                                                           placeholder="+91 98765 43210" 
                                                           required 
                                                           autocomplete="tel">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Password & Confirm Password (Grid) -->
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <div class="vk-form-group">
                                                <label for="reg_password" class="vk-form-label">
                                                    <span>Password</span>
                                                </label>
                                                <div class="vk-input-group">
                                                    <i class="bi bi-lock vk-input-icon"></i>
                                                    <input type="password" 
                                                           id="reg_password" 
                                                           name="password" 
                                                           class="vk-form-input" 
                                                           placeholder="Min. 8 characters" 
                                                           required 
                                                           autocomplete="new-password">
                                                    <button type="button" class="vk-toggle-password" id="toggleRegPasswordBtn" title="Toggle password">
                                                        <i class="bi bi-eye" id="toggleRegPasswordIcon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="vk-form-group">
                                                <label for="password_confirmation" class="vk-form-label">
                                                    <span>Confirm Password</span>
                                                </label>
                                                <div class="vk-input-group">
                                                    <i class="bi bi-shield-lock vk-input-icon"></i>
                                                    <input type="password" 
                                                           id="password_confirmation" 
                                                           name="password_confirmation" 
                                                           class="vk-form-input" 
                                                           placeholder="Repeat password" 
                                                           required 
                                                           autocomplete="new-password">
                                                    <button type="button" class="vk-toggle-password" id="toggleConfPasswordBtn" title="Toggle password">
                                                        <i class="bi bi-eye" id="toggleConfPasswordIcon"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Terms & Marketing Checkbox -->
                                    <div class="mt-2 mb-3">
                                        <label class="vk-form-check">
                                            <input type="checkbox" name="terms" id="terms" required checked>
                                            <span>I agree to Vastrkaya's <a href="#" class="text-decoration-underline text-dark">Terms of Use</a> and <a href="#" class="text-decoration-underline text-dark">Privacy Policy</a>.</span>
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="vk-btn-auth-submit">
                                        <span>Create Vastrkaya Account</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </button>

                                    <!-- Switch to Login -->
                                    <div class="vk-auth-switch">
                                        Already have an account? 
                                        <a href="{{ url('/login') }}">Sign In here</a>
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
        function setupToggle(btnId, inputId, iconId) {
            const btn = document.getElementById(btnId);
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (btn && input && icon) {
                btn.addEventListener('click', function () {
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            }
        }

        setupToggle('toggleRegPasswordBtn', 'reg_password', 'toggleRegPasswordIcon');
        setupToggle('toggleConfPasswordBtn', 'password_confirmation', 'toggleConfPasswordIcon');
    });
</script>
@endsection
