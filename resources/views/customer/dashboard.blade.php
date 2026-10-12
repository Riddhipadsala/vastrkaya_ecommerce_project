@extends('main')
@section('title', 'Vastrkaya - Premium Ethnic & Modern Apparel')
@php
    $show_navbar = true;
    $show_footer = true;
@endphp
@section('hero-section')

    <!-- 1. FULL WIDTH HERO POSTER SLIDER -->
    <section class="vk-hero-slider-section w-100 p-0 mb-0">
        <div class="container-fluid p-0">
            <div id="heroPosterCarousel" class="carousel slide carousel-fade vk-hero-carousel w-100" data-bs-ride="carousel" data-bs-interval="4500">
                
                <!-- Indicators -->
                <div class="carousel-indicators vk-carousel-indicators mb-3">
                    <button type="button" data-bs-target="#heroPosterCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroPosterCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                </div>

                <!-- Carousel Slides (Full Edge-to-Edge Width) -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('main-poster/main-poster1.png') }}" class="d-block w-100 vk-slider-img" alt="Vastrkaya Festive Collection">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('main-poster/main-poster2.png') }}" class="d-block w-100 vk-slider-img" alt="Vastrkaya Contemporary Apparel">
                    </div>
                </div>

                <!-- Next / Previous Controls -->
                <button class="carousel-control-prev vk-carousel-control" type="button" data-bs-target="#heroPosterCarousel" data-bs-slide="prev">
                    <span class="vk-control-icon">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next vk-carousel-control" type="button" data-bs-target="#heroPosterCarousel" data-bs-slide="next">
                    <span class="vk-control-icon">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                    <span class="visually-hidden">Next</span>
                </button>

            </div>
        </div>
    </section>

    <!-- 2. VALUE PROPOSITION STRIP (Full Width) -->
    <section class="vk-value-strip mt-8">
        <div class="container-fluid px-3 px-lg-5">
            <div class="row g-3 g-lg-4">
                <div class="col-6 col-lg-3">
                    <div class="vk-value-item">
                        <div class="vk-value-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div>
                            <h6 class="vk-value-title">Free Express Shipping</h6>
                            <p class="vk-value-subtitle">On all orders above ₹999</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="vk-value-item">
                        <div class="vk-value-icon">
                            <i class="bi bi-patch-check"></i>
                        </div>
                        <div>
                            <h6 class="vk-value-title">100% Handcrafted Quality</h6>
                            <p class="vk-value-subtitle">Finest woven Indian fabrics</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="vk-value-item">
                        <div class="vk-value-icon">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>
                        <div>
                            <h6 class="vk-value-title">7-Day Easy Returns</h6>
                            <p class="vk-value-subtitle">Instant door-step pickups</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="vk-value-item">
                        <div class="vk-value-icon">
                            <i class="bi bi-tag"></i>
                        </div>
                        <div>
                            <h6 class="vk-value-title">Flat ₹500 First Order Off</h6>
                            <p class="vk-value-subtitle">Use Coupon Code: <strong>VASTRA500</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. SHOP BY CATEGORY SECTION (Full Width Layout) -->
    <section class="vk-categories-section py-4 py-lg-5">
        <div class="container-fluid px-3 px-lg-5">
            
            <!-- Section Header -->
            <div class="vk-section-header text-center mb-4 mb-lg-5">
                <span class="vk-section-badge">Curated Collections</span>
                <h2 class="vk-section-title">Shop By Category</h2>
                <p class="vk-section-subtitle mb-0">Discover handcrafted ethnic charm and modern luxury styles</p>
            </div>

            <!-- Category Grid (Expanded Larger Size) -->
            <div class="row g-3 g-lg-4">
                
                <!-- Category 1: Women's Ethnic -->
                <div class="col-6 col-md-4 col-lg-4">
                    <a href="{{ url('/products?category=womens-ethnic') }}" class="vk-category-card">
                        <div class="vk-cat-img-box">
                            <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=600&q=80" alt="Women's Ethnic" class="vk-cat-img" loading="lazy">
                            <div class="vk-cat-overlay">
                                <span class="vk-cat-badge">Popular</span>
                                <h5 class="vk-cat-title">Women Ethnic</h5>
                                <p class="vk-cat-count">140+ Styles <i class="bi bi-arrow-right"></i></p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Category 2: Men's Kurtas -->
                <div class="col-6 col-md-4 col-lg-4">
                    <a href="{{ url('/products?category=mens-kurtas') }}" class="vk-category-card">
                        <div class="vk-cat-img-box">
                            <img src="https://images.unsplash.com/photo-1597983073493-88cd35cf93b0?auto=format&fit=crop&w=600&q=80" alt="Men's Traditional" class="vk-cat-img" loading="lazy">
                            <div class="vk-cat-overlay">
                                <span class="vk-cat-badge">Trending</span>
                                <h5 class="vk-cat-title">Men's Kurtas</h5>
                                <p class="vk-cat-count">90+ Styles <i class="bi bi-arrow-right"></i></p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Category 3: Designer Sarees -->
                <div class="col-6 col-md-4 col-lg-4">
                    <a href="{{ url('/products?category=sarees') }}" class="vk-category-card">
                        <div class="vk-cat-img-box">
                            <img src="https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=600&q=80" alt="Designer Sarees" class="vk-cat-img" loading="lazy">
                            <div class="vk-cat-overlay">
                                <span class="vk-cat-badge">Silk & Pure</span>
                                <h5 class="vk-cat-title">Silk Sarees</h5>
                                <p class="vk-cat-count">110+ Styles <i class="bi bi-arrow-right"></i></p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Category 4: Festive Lehengas -->
                <div class="col-6 col-md-4 col-lg-4">
                    <a href="{{ url('/products?category=lehengas') }}" class="vk-category-card">
                        <div class="vk-cat-img-box">
                            <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=600&q=80" alt="Festive Lehengas" class="vk-cat-img" loading="lazy">
                            <div class="vk-cat-overlay">
                                <span class="vk-cat-badge">Festive</span>
                                <h5 class="vk-cat-title">Lehengas</h5>
                                <p class="vk-cat-count">75+ Styles <i class="bi bi-arrow-right"></i></p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Category 5: Indo-Western Fusion -->
                <div class="col-6 col-md-4 col-lg-4">
                    <a href="{{ url('/products?category=indo-western') }}" class="vk-category-card">
                        <div class="vk-cat-img-box">
                            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80" alt="Indo-Western" class="vk-cat-img" loading="lazy">
                            <div class="vk-cat-overlay">
                                <span class="vk-cat-badge">Modern</span>
                                <h5 class="vk-cat-title">Fusion Wear</h5>
                                <p class="vk-cat-count">60+ Styles <i class="bi bi-arrow-right"></i></p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Category 6: Dupattas & Stoles -->
                <div class="col-6 col-md-4 col-lg-4">
                    <a href="{{ url('/products?category=accessories') }}" class="vk-category-card">
                        <div class="vk-cat-img-box">
                            <img src="https://images.unsplash.com/photo-1609357605129-26f69add5d6e?auto=format&fit=crop&w=600&q=80" alt="Dupattas & Stoles" class="vk-cat-img" loading="lazy">
                            <div class="vk-cat-overlay">
                                <span class="vk-cat-badge">Handloom</span>
                                <h5 class="vk-cat-title">Dupattas</h5>
                                <p class="vk-cat-count">85+ Styles <i class="bi bi-arrow-right"></i></p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. FEATURED & TRENDING PRODUCTS (Full Width 4-Column Grid) -->
    <section class="vk-products-section py-4 py-lg-5 bg-white border-top border-bottom">
        <div class="container-fluid px-3 px-lg-5">
            
            <!-- Section Header (Centered like Shop By Category) -->
            <div class="vk-section-header text-center mb-4 mb-lg-5">
                <span class="vk-section-badge">Handcrafted Elegance</span>
                <h2 class="vk-section-title">Trending & Featured Products</h2>
                <p class="vk-section-subtitle mb-0">Top-rated outfits woven with heritage precision</p>
            </div>

            <!-- Product Grid (5 items per row on desktop) -->
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
                
                <!-- Product 1 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-hot">Bestseller</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=600&q=80" alt="Embroidered Chanderi Anarkali" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Women's Ethnic</span>
                            <a href="{{ url('/products/1') }}" class="vk-product-title">Embroidered Chanderi Silk Anarkali Suit Set</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="vk-rating-count">(4.8)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹2,499</span>
                                <span class="vk-price-mrp">₹4,999</span>
                                <span class="vk-price-discount">50% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-new">New</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1597983073493-88cd35cf93b0?auto=format&fit=crop&w=600&q=80" alt="Royal Jacquard Silk Kurta" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Men's Apparel</span>
                            <a href="{{ url('/products/2') }}" class="vk-product-title">Royal Jacquard Silk Kurta with Churidar</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="vk-rating-count">(5.0)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹1,899</span>
                                <span class="vk-price-mrp">₹3,499</span>
                                <span class="vk-price-discount">45% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-discount">Save 40%</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=600&q=80" alt="Pure Kanjeevaram Silk Saree" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Silk Sarees</span>
                            <a href="{{ url('/products/3') }}" class="vk-product-title">Pure Kanjeevaram Woven Gold Zari Silk Saree</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="vk-rating-count">(4.9)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹3,999</span>
                                <span class="vk-price-mrp">₹6,999</span>
                                <span class="vk-price-discount">42% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-hot">Trending</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80" alt="Pastel Georgette Crop Top & Skirt" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Fusion Wear</span>
                            <a href="{{ url('/products/4') }}" class="vk-product-title">Pastel Floral Georgette Co-ord Set with Jacket</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <span class="vk-rating-count">(4.4)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹1,599</span>
                                <span class="vk-price-mrp">₹2,999</span>
                                <span class="vk-price-discount">46% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-new">New</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=600&q=80" alt="Festive Bandhani Silk Saree" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Festive Edit</span>
                            <a href="{{ url('/products/5') }}" class="vk-product-title">Traditional Gujarati Bandhani Georgette Saree</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="vk-rating-count">(4.9)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹2,199</span>
                                <span class="vk-price-mrp">₹4,299</span>
                                <span class="vk-price-discount">48% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-discount">Save 50%</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1609357605129-26f69add5d6e?auto=format&fit=crop&w=600&q=80" alt="Banarasi Brocade Dupatta" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Accessories</span>
                            <a href="{{ url('/products/6') }}" class="vk-product-title">Handwoven Banarasi Zari Silk Heavy Dupatta</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="vk-rating-count">(4.7)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹999</span>
                                <span class="vk-price-mrp">₹1,999</span>
                                <span class="vk-price-discount">50% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 7 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-hot">Hot</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1597983073493-88cd35cf93b0?auto=format&fit=crop&w=600&q=80" alt="Linen Embroidered Nehru Jacket" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Men's Apparel</span>
                            <a href="{{ url('/products/7') }}" class="vk-product-title">Classic Handcrafted Raw Silk Nehru Jacket</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="vk-rating-count">(4.6)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹1,749</span>
                                <span class="vk-price-mrp">₹3,299</span>
                                <span class="vk-price-discount">47% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 8 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-hot">Bestseller</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=600&q=80" alt="Bridal Velvet Embroidered Lehenga" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Lehengas</span>
                            <a href="{{ url('/products/8') }}" class="vk-product-title">Bridal Velvet Zardosi Embroidered Semi-Stitched Lehenga</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="vk-rating-count">(5.0)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹5,499</span>
                                <span class="vk-price-mrp">₹9,999</span>
                                <span class="vk-price-discount">45% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 9 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-new">New</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=600&q=80" alt="Floral Printed Silk Anarkali" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Women's Ethnic</span>
                            <a href="{{ url('/products/9') }}" class="vk-product-title">Organza Floral Printed Anarkali Kurta Set</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="vk-rating-count">(4.8)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹1,999</span>
                                <span class="vk-price-mrp">₹3,899</span>
                                <span class="vk-price-discount">48% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 10 -->
                <div class="col">
                    <div class="vk-product-card">
                        <div class="vk-product-thumb">
                            <span class="vk-product-tag vk-tag-hot">Trending</span>
                            <button type="button" class="vk-wishlist-btn" title="Add to Wishlist" aria-label="Add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </button>
                            <img src="https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=600&q=80" alt="Mirror Work Chikankari Saree" class="vk-product-img" loading="lazy">
                        </div>
                        <div class="vk-product-body">
                            <span class="vk-product-category">Silk Sarees</span>
                            <a href="{{ url('/products/10') }}" class="vk-product-title">Mirror Work Chikankari Georgette Party Saree</a>
                            <div class="vk-product-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="vk-rating-count">(4.9)</span>
                            </div>
                            <div class="vk-product-price">
                                <span class="vk-price-current">₹2,799</span>
                                <span class="vk-price-mrp">₹5,499</span>
                                <span class="vk-price-discount">49% OFF</span>
                            </div>
                            <button type="button" class="vk-add-cart-btn">
                                <i class="bi bi-bag-plus"></i> Add to Bag
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Centered View All Button -->
            <div class="text-center mt-4 mt-lg-5">
                <a href="{{ url('/products') }}" class="btn btn-outline-dark rounded-pill px-5 py-2 fw-semibold shadow-sm">
                    View All Products <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

        </div>
    </section>

@endsection
