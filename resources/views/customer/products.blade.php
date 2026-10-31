@extends('main')

@section('title', 'Shop Products - Vastrkaya Online Fashion')

@php
    $show_navbar = true;
    $show_footer = true;
@endphp

@section('hero-section')
    <style>
        /* Exact Myntra Product Grid & Card Styling */
        .myntra-card {
            background: #ffffff;
            border: 1px solid #f5f5f6;
            border-radius: 0;
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            text-align: left;
            transition: box-shadow 0.2s ease, transform 0.15s ease;
            overflow: hidden;
        }
        .myntra-card:hover {
            box-shadow: 0 4px 16px rgba(40, 44, 63, 0.12);
        }
        .myntra-img-wrap {
            position: relative;
            display: block;
            width: 100%;
            aspect-ratio: 1 / 0.9;
            background-color: #f7f7f8;
            overflow: hidden;
            text-decoration: none;
        }
        .myntra-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            display: block;
            transition: transform 0.35s ease;
        }
        .myntra-card:hover .myntra-img-wrap img {
            transform: scale(1.03);
        }
        .myntra-rating-pill {
            position: absolute;
            bottom: 8px;
            left: 8px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(2px);
            padding: 2px 6px;
            border-radius: 2px;
            font-size: 11px;
            font-weight: 700;
            color: #282c3f;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            line-height: 1.2;
        }
        .myntra-rating-pill i {
            color: #14958f;
            font-size: 9px;
        }
        .myntra-rating-pill .rating-count {
            color: #7e818c;
            font-weight: 400;
            font-size: 10px;
            margin-left: 2px;
        }
        .myntra-info {
            padding: 13px 12px 16px 12px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            min-height: 100px;
            background: #ffffff;
        }
        .myntra-brand {
            font-size: 14px;
            font-weight: 400;
            color: #282c3f;
            margin-bottom: 3px;
            line-height: 1.25;
            letter-spacing: 0.1px;
        }
        .myntra-title {
            font-size: 16px;
            font-weight: 900;
            color: #535766;
            margin-bottom: 8px;
            line-height: 1.35;
        }
        .myntra-price-row {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: auto;
            padding-top: 2px;
            line-height: 1.2;
        }
        .myntra-final-price {
            font-size: 14px;
            font-weight: 700;
            color: #282c3f;
        }
        .myntra-mrp {
            font-size: 12px;
            font-weight: 400;
            color: #7e818c;
            text-decoration: line-through;
        }
        .myntra-discount {
            font-size: 12px;
            font-weight: 500;
            color: #ff905a;
        }
    </style>

    <div class="bg-white min-h-screen text-slate-800 font-sans" style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
        <div class="container-fluid px-3 px-lg-4 py-3">

            <!-- Breadcrumbs Bar -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb text-xs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-slate-500 hover:text-slate-900 text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/products') }}" class="text-slate-500 hover:text-slate-900 text-decoration-none">Clothing</a></li>
                    <li class="breadcrumb-item active text-slate-900 font-semibold" aria-current="page">All Products</li>
                </ol>
            </nav>

            <!-- Active Applied Filter Chips Strip & Top Meta Header (Clean Myntra Layout) -->
            <div class="d-flex align-items-center justify-content-between pb-2.5 mb-3 border-b border-slate-200">
                <div class="d-flex align-items-center gap-2">
                    <h1 class="mb-0" style="font-size: 16px; font-weight: 700; color: #0f172a; line-height: 1.2;">
                        Ethnic &amp; Modern Collections
                    </h1>
                    <span class="text-muted" id="productCountHeader" style="font-size: 12px; font-weight: 500;">
                         items
                    </span>
                </div>

                <!-- Sort & Mobile Filter Toggle -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Mobile Filter Trigger -->
                    <button type="button" class="btn btn-outline-secondary btn-sm d-lg-none d-inline-flex align-items-center gap-1.5 text-xs font-semibold py-1 px-2.5 rounded-lg shadow-none"
                        data-bs-toggle="offcanvas" data-bs-target="#mobileFilterDrawer" aria-controls="mobileFilterDrawer">
                        <i class="bi bi-funnel"></i>
                        <span>Filters</span>
                    </button>
                </div>
            </div>

            <!-- MAIN GRID: LEFT SIDEBAR FILTERS + RIGHT PRODUCTS -->
            <div class="row g-4">

                <!-- =========================================================
                     LEFT COLUMN: FILTERS SIDEBAR (Desktop)
                     ========================================================= -->
                <div class="col-lg-3 col-xl-2d5 d-none d-lg-block" style="width: 260px;">
                    <div class="sticky-top bg-white border border-slate-200 rounded-2xl p-3.5 shadow-2xs" style="top: 85px; height: calc(100vh - 10px); overflow-y: auto; scrollbar-width: thin;">
                        
                        <!-- Filter Header -->
                        <div class="d-flex align-items-center justify-content-between pb-2.5 mb-2.5 border-b border-slate-100">
                            <span class="text-xs font-extrabold text-slate-900 uppercase tracking-wider d-flex align-items-center gap-1.5">
                                <i class="bi bi-sliders text-slate-600"></i>
                                <span>FILTERS</span>
                            </span>
                            <button type="button" class="btn btn-link p-0 text-[11px] font-bold text-[#ff3f6c] hover:text-[#d93057] text-decoration-none shadow-none border-0">
                                CLEAR ALL
                            </button>
                        </div>

                        <!-- FILTER 1: CATEGORIES -->
                        <div class="py-2.5 border-b border-slate-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Categories</span>
                                <i class="bi bi-chevron-down text-slate-400 text-[10px]"></i>
                            </div>
                            <div class="space-y-1.5 text-xs text-slate-600 max-h-40 overflow-y-auto" style="scrollbar-width: thin;">
                                
                                @foreach($categories as $category)
                                    <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900 py-0.5">
                                        <input type="checkbox" name="category_id" value="{{$category->id}}" class="form-check-input mt-0 custom-checkbox" style="accent-color: #ff3f6c;">
                                        <span class="flex-grow-1 truncate">{{$category->name}}</span>
                                    </label>
                                @endforeach

                            </div>
                        </div>

                        <!-- FILTER 2: BRAND -->
                        <div class="py-2.5 border-b border-slate-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Brand</span>
                                <i class="bi bi-chevron-down text-slate-400 text-[10px]"></i>
                            </div>
                            <div class="space-y-1.5 text-xs text-slate-600 max-h-36 overflow-y-auto" style="scrollbar-width: thin;">
                                
                                @foreach($brands as $brand)
                                    <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                        <input type="checkbox" name="brand" value="{{$brand->brand}}" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;">
                                        <span class="flex-grow-1 truncate">{{$brand->brand}}</span>
                                    </label>
                                @endforeach

                            </div>
                        </div>

                        <!-- FILTER 3: PRICE RANGE -->
                        <div class="py-2.5 border-b border-slate-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Price</span>
                                <i class="bi bi-chevron-down text-slate-400 text-[10px]"></i>
                            </div>
                            <div class="space-y-1.5 text-xs text-slate-600">
                                <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                    <input type="checkbox" name="price" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;" value="0-999">
                                    <span>Under &#8377;999</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                    <input type="checkbox" name="price" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;" value="1000-1999">
                                    <span>&#8377;1,000 to &#8377;1,999</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                    <input type="checkbox" name="price" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;" value="2000-2999">
                                    <span>&#8377;2,000 to &#8377;2,999</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                    <input type="checkbox" name="price" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;" value="3000-above">
                                    <span>&#8377;3,000 and Above</span>
                                </label>
                            </div>
                        </div>

                        <!-- FILTER 4: DISCOUNT PERCENTAGE -->
                        <div class="py-2.5 border-b border-slate-100">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Discount Range</span>
                                <i class="bi bi-chevron-down text-slate-400 text-[10px]"></i>
                            </div>
                            <div class="space-y-1.5 text-xs text-slate-600">
                                <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                    <input type="checkbox" name="discount_percentage" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;" value="10-100">
                                    <span>10% and above</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                    <input type="checkbox" name="discount_percentage" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;" value="20-100">
                                    <span>20% and above</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                    <input type="checkbox" name="discount_percentage" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;" value="30-100">
                                    <span>30% and above</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 cursor-pointer hover:text-slate-900">
                                    <input type="checkbox" name="discount_percentage" class="form-check-input mt-0 custom-checkbox py-0.5" style="accent-color: #ff3f6c;" value="40-100">
                                    <span>40% and above</span>
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- =========================================================
                     RIGHT COLUMN: PRODUCTS GRID (4/5-Column Responsive Layout)
                     ========================================================= -->
                <div class="col-lg-9 col-xl-9 flex-grow-1">

                    <!-- Products Grid (Each card is an individual column matching Myntra look) -->
                    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3 products-record">
                        <div class="col-12 py-5 text-center text-muted" id="productsLoader">
                            <div class="spinner-border text-danger spinner-border-sm me-2" role="status"></div>
                            <span class="text-xs">Loading products...</span>
                        </div>
                    </div>

                    <!-- Pagination Navigation (Myntra Standard Look) -->
                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 pt-5 mt-4 border-t border-slate-200">
                        <span class="text-xs text-slate-500" style="font-size: 12px;">
                            Showing <strong class="text-slate-900" id="productCountPagination"></strong> products
                        </span>

                        <nav aria-label="Products Pagination">
                            <ul class="pagination pagination-sm mb-12 gap-1">
                                <li class="page-item disabled">
                                    <a class="page-link rounded-lg text-xs font-semibold px-3 py-1.5 border-slate-200" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link rounded-lg text-xs font-bold px-3 py-1.5 bg-slate-900 border-slate-900 text-white" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link rounded-lg text-xs font-semibold px-3 py-1.5 border-slate-200 text-slate-700" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link rounded-lg text-xs font-semibold px-3 py-1.5 border-slate-200 text-slate-700" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link rounded-lg text-xs font-semibold px-3 py-1.5 border-slate-200 text-slate-700" href="#">4</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link rounded-lg text-xs font-semibold px-3 py-1.5 border-slate-200 text-slate-700" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- =========================================================
         MOBILE FILTER OFFCANVAS DRAWER (Bootstrap 5)
         ========================================================= -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileFilterDrawer" aria-labelledby="mobileFilterDrawerLabel" style="width: 300px;">
        <div class="offcanvas-header border-bottom py-3">
            <h5 class="offcanvas-title text-sm font-bold text-slate-900 d-flex align-items-center gap-2" id="mobileFilterDrawerLabel">
                <i class="bi bi-sliders text-slate-700"></i>
                <span>FILTERS</span>
            </h5>
            <button type="button" class="btn-close text-xs shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-3">
            <div class="d-flex justify-content-between mb-3 pb-2 border-b border-slate-100">
                <span class="text-xs font-bold text-slate-500">Refine Results</span>
                <a href="javascript:void(0)" class="text-[11px] font-bold text-[#ff3f6c] text-decoration-none">Reset All</a>
            </div>

            <!-- Categories -->
            <div class="mb-3.5">
                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider d-block mb-2">Category</span>
                <div class="space-y-1.5 text-xs text-slate-600">
                    <label class="d-flex align-items-center gap-2"><input type="checkbox" checked style="accent-color:#ff3f6c;"> Sarees</label>
                    <label class="d-flex align-items-center gap-2"><input type="checkbox" style="accent-color:#ff3f6c;"> Kurta for Men</label>
                    <label class="d-flex align-items-center gap-2"><input type="checkbox" style="accent-color:#ff3f6c;"> Girls Casual Wear</label>
                </div>
            </div>

            <!-- Price -->
            <div class="mb-3.5">
                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider d-block mb-2">Price</span>
                <div class="space-y-1.5 text-xs text-slate-600">
                    <label class="d-flex align-items-center gap-2"><input type="checkbox" style="accent-color:#ff3f6c;"> Under ₹999</label>
                    <label class="d-flex align-items-center gap-2"><input type="checkbox" style="accent-color:#ff3f6c;"> ₹1,000 to ₹1,999</label>
                    <label class="d-flex align-items-center gap-2"><input type="checkbox" style="accent-color:#ff3f6c;"> ₹2,000 &amp; Above</label>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer p-3 border-top d-flex gap-2 bg-slate-50">
            <button type="button" class="btn btn-outline-secondary btn-sm flex-grow-1 text-xs font-semibold rounded-lg" data-bs-dismiss="offcanvas">Close</button>
            <button type="button" class="btn btn-dark btn-sm flex-grow-1 text-xs font-semibold rounded-lg bg-slate-900 border-slate-900" data-bs-dismiss="offcanvas">Apply Filters</button>
        </div>
    </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchData();
        
        $('.custom-checkbox').on('change',function() {
        
    let filters = {};

    $('.custom-checkbox:checked').each(function () {

        let name = $(this).attr('name');
        let value = $(this).val();

        if (!filters[name]) {
            filters[name] = [];
        }

        filters[name].push(value);

    });


            axios.get('/products', {
                params: {
                    filters   
                }
            })
            .then((res) => {
                console.log(res);
                
            })

        });
    });

    function fetchData() {

        axios.get('/products')
        .then((res) => {
            let products = (res.data && res.data.products) ? res.data.products : [];
            let container = $('.products-record');

            if (!products || products.length === 0) {
                container.html(`
                    <div class="col-12 py-5 text-center">
                        <i class="bi bi-box-seam text-slate-300" style="font-size: 2.5rem;"></i>
                        <h6 class="mt-3 text-slate-700 font-semibold" style="font-size: 14px;">No products found</h6>
                        <p class="text-slate-400" style="font-size: 12px;">Browse other categories or check back soon.</p>
                    </div>
                `);
                $('#productCountHeader').text('(0 items)');
                $('#productCountPagination').text('0');
                return;
            }

            $('#productCountHeader').text(`(${products.length} items)`);
            $('#productCountPagination').text(products.length);

            let html = '';

            products.forEach((p) => {
              
                let image = (p.image) ? '/storage/'+p.image : 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=500&auto=format&fit=crop&q=80';
                let brand = p.brand ? p.brand : (p.category ? p.category.name : 'Vastrkaya');
                let name = p.name || 'Ethnic Wear';

                let price = parseFloat(p.price) || 0;
                let discountPrice = parseFloat(p.discount_price) || 0;
                let discountPercent = parseFloat(p.discount_percentage) || 0;

                html += `
                    <div class="col">
                        <div class="myntra-card">
                            
                            <!-- Thumbnail Image (3:4 Fashion Aspect Ratio) -->
                            <a href="/products/${p.id}" class="myntra-img-wrap">
                                <img src="${image}" alt="${name}" loading="lazy">
                                
                                <!-- Rating Pill (Bottom Left over image) -->
                                <div class="myntra-rating-pill">
                                    <span>4.2</span>
                                    <i class="bi bi-star-fill"></i>
                                    <span class="rating-count">| 120</span>
                                </div>
                            </a>

                            <!-- Product Info Body -->
                            <div class="myntra-info">
                                <!-- Brand -->
                                <div class="myntra-brand text-truncate" title="${brand}">
                                    ${brand}
                                </div>

                                <!-- Title / Subtitle -->
                                <div class="myntra-title text-truncate" title="${name}">
                                    <a href="/products/${p.id}" class="text-decoration-none" style="color: inherit;">
                                        ${name}
                                    </a>
                                </div>

                                <!-- Pricing Line -->
                                <div class="myntra-price-row">
                                    <span class="myntra-final-price">Rs. ${price}</span>
                                    ${discountPercent ? `
                                        <span class="myntra-mrp">Rs. ${discountPrice}</span>
                                        <span class="myntra-discount">(${discountPercent}% OFF)</span>
                                    ` : ''}
                                </div>
                            </div>

                        </div>
                    </div>
                `;

            });

            container.html(html);
        })
        .catch((err) => {
            console.error('Error fetching products:', err);
            $('.products-record').html(`
                <div class="col-12 py-4 text-center text-danger">
                    <span class="text-xs">Failed to load products. Please refresh the page.</span>
                </div>
            `);
        });


}
</script>
@endsection

