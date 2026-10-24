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
            <div id="heroPosterCarousel" class="carousel slide carousel-fade vk-hero-carousel w-100" data-bs-ride="carousel"
                data-bs-interval="4500">

                <!-- Indicators -->
                <div class="carousel-indicators vk-carousel-indicators mb-3">
                    <button type="button" data-bs-target="#heroPosterCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroPosterCarousel" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                </div>

                <!-- Carousel Slides (Full Edge-to-Edge Width) -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('main-poster/main-poster1.png') }}" class="d-block w-100 vk-slider-img"
                            alt="Vastrkaya Festive Collection">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('main-poster/main-poster2.png') }}" class="d-block w-100 vk-slider-img"
                            alt="Vastrkaya Contemporary Apparel">
                    </div>
                </div>

                <!-- Next / Previous Controls -->
                <button class="carousel-control-prev vk-carousel-control" type="button"
                    data-bs-target="#heroPosterCarousel" data-bs-slide="prev">
                    <span class="vk-control-icon">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next vk-carousel-control" type="button"
                    data-bs-target="#heroPosterCarousel" data-bs-slide="next">
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

            <!-- Category Grid (5 Boxes in 1 Row on Desktop) -->
            <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 g-lg-4">

                @foreach ($categories as $category)
                    <div class="col">
                        <div class="vk-category-card h-100">
                            <a href="{{ url('/products?category=' . $category->id) }}" class="vk-cat-img-box">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                    class="vk-cat-img" loading="lazy">
                            </a>
                            <div
                                class="flex flex-col items-center justify-center text-center pt-3.5 pb-4.5 px-3 sm:pt-4.5 sm:pb-5.5 sm:px-4 bg-white gap-2.5 sm:gap-3 flex-1">
                                <h5 class="vk-cat-title">
                                    <a href="{{ url('/products?category=' . $category->id) }}"
                                        class="text-decoration-none text-dark">{{ $category->name }}</a>
                                </h5>
                                <a href="{{ url('/products?category=' . $category->id) }}" class="vk-cat-explore-btn">
                                    Explore <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

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
                @foreach ($products as $product)
                    <div class="col">
                        <div class="vk-product-card">
                            <a href="{{ url('products/' . $product->id) }}" class="vk-product-thumb d-block text-decoration-none">
                                <span class="vk-product-tag vk-tag-hot">{{ round($product->discount_percentage) }}%
                                    OFF</span>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="vk-product-img" loading="lazy">
                            </a>
                            <div class="vk-product-body">
                                <span class="vk-product-category">{{ $product->category->name ?? 'Collection' }}</span>
                                <a href="{{ url('products/' . $product->id) }}"
                                    class="vk-product-title">{{ $product->name }}</a>
                                <div class="vk-product-rating">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                    <span class="vk-rating-count">(4.8)</span>
                                </div>
                                <div class="vk-product-price">
                                    <span class="vk-price-current">₹{{ $product->price }}</span>
                                    <span class="vk-price-mrp">₹{{ $product->discount_price }}</span>
                                    <span class="vk-price-discount">{{ $product->discount_percentage }}% OFF</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Centered View All Button -->
            <div class="text-center mt-4 mt-lg-5">
                <a href="{{ url('/products') }}"
                    class="btn btn-outline-dark rounded-pill px-5 py-2 fw-semibold shadow-sm">
                    View All Products <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

        </div>
    </section>

@endsection
