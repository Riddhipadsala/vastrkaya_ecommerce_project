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

    document.getElementById('reg_phone').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/\D/g, '');
        e.target.value = e.target.value.slice(0, 10);
    })
</script>
@endsection
