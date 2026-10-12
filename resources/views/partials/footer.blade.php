<!-- Modern E-Commerce Footer -->
<footer class="vk-footer mt-auto">
    

    <!-- 2. NEWSLETTER SUBSCRIPTION -->
    <div class="vk-footer-newsletter py-5">
        <div class="container-fluid px-3 px-lg-5">
            <div class="row align-items-center justify-content-between g-4">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="vk-newsletter-icon text-white fs-2">
                            <i class="bi bi-envelope-paper-heart"></i>
                        </div>
                        <div>
                            <h4 class="vk-newsletter-heading mb-1">Stay In The Style Loop</h4>
                            <p class="vk-newsletter-desc mb-0">Subscribe for early access to new collections & exclusive festive offers.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <form action="{{ url('/newsletter') }}" method="POST" class="vk-newsletter-form">
                        @csrf
                        <div class="input-group vk-newsletter-input-group ms-lg-auto">
                            <input type="email" 
                                   name="email" 
                                   class="form-control vk-newsletter-input" 
                                   placeholder="Enter your email address..." 
                                   required 
                                   autocomplete="email">
                            <button class="btn vk-newsletter-btn" type="submit">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. MAIN FOOTER CONTENT LINKS -->
    <div class="vk-footer-main py-5">
        <div class="container-fluid px-3 px-lg-5">
            <div class="row g-4 g-lg-5">
                
                <!-- Brand Info & Socials -->
                <div class="col-lg-4 col-md-6">
                    <div class="pe-lg-3">
                        <a href="{{ url('/') }}" class="d-inline-block text-decoration-none mb-3">
                            <img src="{{ asset('logo.png') }}?v={{ file_exists(public_path('logo.png')) ? filemtime(public_path('logo.png')) : time() }}" 
                                 alt="Vastrkaya" 
                                 class="vk-footer-logo-img"
                                 onerror="this.style.display='none'; document.getElementById('vk-footer-fallback-logo').style.display='block';">
                            <span id="vk-footer-fallback-logo" class="fs-4 fw-bold text-white text-uppercase tracking-wider" style="display: none;">
                                <span class="text-danger">V</span>astrkaya
                            </span>
                        </a>
                        <p class="vk-footer-about mb-4">
                            Vastrkaya brings you handcrafted contemporary apparel and timeless ethnic elegance, tailored with passion and woven from rich Indian textiles.
                        </p>
                        <div class="d-flex align-items-center gap-2">
                            <a href="#" class="vk-social-link" title="Instagram" aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="vk-social-link" title="Facebook" aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="vk-social-link" title="Pinterest" aria-label="Pinterest">
                                <i class="bi bi-pinterest"></i>
                            </a>
                            <a href="#" class="vk-social-link" title="X (Twitter)" aria-label="X">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" class="vk-social-link" title="YouTube" aria-label="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Collections / Categories -->
                <div class="col-lg-2 col-6 col-md-3">
                    <h6 class="vk-footer-col-title">Collections</h6>
                    <ul class="vk-footer-links">
                        <li><a href="{{ url('/products') }}" class="vk-footer-link">New Arrivals</a></li>
                        <li><a href="{{ url('/products?category=women') }}" class="vk-footer-link">Women's Wear</a></li>
                        <li><a href="{{ url('/products?category=men') }}" class="vk-footer-link">Men's Apparel</a></li>
                        <li><a href="{{ url('/products?category=ethnic') }}" class="vk-footer-link">Ethnic & Festive</a></li>
                        <li><a href="{{ url('/products?category=bestsellers') }}" class="vk-footer-link">Best Sellers</a></li>
                        <li><a href="{{ url('/products?category=sale') }}" class="vk-footer-link">Special Offers</a></li>
                    </ul>
                </div>

                <!-- Customer Care -->
                <div class="col-lg-2 col-6 col-md-3">
                    <h6 class="vk-footer-col-title">Customer Care</h6>
                    <ul class="vk-footer-links">
                        <li><a href="{{ url('/orders') }}" class="vk-footer-link">Track Your Order</a></li>
                        <li><a href="{{ url('/shipping-policy') }}" class="vk-footer-link">Shipping & Delivery</a></li>
                        <li><a href="{{ url('/returns') }}" class="vk-footer-link">Returns & Refunds</a></li>
                        <li><a href="{{ url('/size-guide') }}" class="vk-footer-link">Size Guide</a></li>
                        <li><a href="{{ url('/faq') }}" class="vk-footer-link">Help & FAQs</a></li>
                        <li><a href="{{ url('/contact') }}" class="vk-footer-link">Contact Support</a></li>
                    </ul>
                </div>

                <!-- Quick Links & Policies -->
                <div class="col-lg-2 col-6 col-md-3">
                    <h6 class="vk-footer-col-title">Quick Links</h6>
                    <ul class="vk-footer-links">
                        <li><a href="{{ url('/about') }}" class="vk-footer-link">About Vastrkaya</a></li>
                        <li><a href="{{ url('/terms') }}" class="vk-footer-link">Terms & Conditions</a></li>
                        <li><a href="{{ url('/privacy-policy') }}" class="vk-footer-link">Privacy Policy</a></li>
                        <li><a href="{{ url('/sustainability') }}" class="vk-footer-link">Sustainability</a></li>
                        <li><a href="{{ url('/careers') }}" class="vk-footer-link">Careers</a></li>
                    </ul>
                </div>

                <!-- Contact & Store Info -->
                <div class="col-lg-2 col-6 col-md-3">
                    <h6 class="vk-footer-col-title">Store Info</h6>
                    <div class="vk-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>Surat, Gujarat, India - 395006</span>
                    </div>
                    <div class="vk-contact-item">
                        <i class="bi bi-telephone"></i>
                        <span>+91 98765 43210</span>
                    </div>
                    <div class="vk-contact-item">
                        <i class="bi bi-envelope"></i>
                        <span>care@vastrkaya.com</span>
                    </div>
                    <div class="vk-contact-item">
                        <i class="bi bi-clock"></i>
                        <span>Mon - Sat: 10:00 AM - 7:00 PM</span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- 4. BOTTOM COPYRIGHT & PAYMENT METHODS -->
    <div class="vk-footer-bottom py-3">
        <div class="container-fluid px-3 px-lg-5">
            <div class="row align-items-center g-3">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">
                        &copy; {{ date('Y') }} <strong>Vastrkaya</strong>. Handcrafted with love in India. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-inline-flex flex-wrap gap-2 justify-content-center justify-content-md-end align-items-center">
                        <span class="small me-1 text-muted d-none d-sm-inline">100% Safe Payments:</span>
                        <span class="vk-payment-badge"><i class="bi bi-credit-card me-1"></i>UPI</span>
                        <span class="vk-payment-badge">VISA</span>
                        <span class="vk-payment-badge">Mastercard</span>
                        <span class="vk-payment-badge">RuPay</span>
                        <span class="vk-payment-badge">Net Banking</span>
                        <span class="vk-payment-badge">Cash on Delivery</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
