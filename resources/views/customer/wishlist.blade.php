@extends('main')

@section('title', 'My Wishlist - Vastrkaya Luxury E-Commerce')

@php
    $show_navbar = true;
    $show_footer = true;
@endphp

@section('hero-section')
<div class="bg-[#f8fafc] min-h-screen py-4 sm:py-6 text-slate-800" style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="container-fluid px-3 px-lg-5 max-w-7xl mx-auto">
        
        <!-- Breadcrumb (Myntra Style) -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb text-xs mb-0">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-slate-500 hover:text-slate-900 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-slate-500 hover:text-slate-900 text-decoration-none">My Account</a></li>
                <li class="breadcrumb-item active text-slate-900 font-semibold" aria-current="page">My Wishlist</li>
            </ol>
        </nav>

        <!-- Page Header with Items Counter -->
        <div class="d-flex align-items-baseline gap-2 mb-4 pb-2 border-b border-slate-200 d-none">
            <h1 class="text-lg sm:text-xl font-bold text-slate-900 uppercase tracking-wide mb-0">
                My Wishlist
            </h1>
            <span class="text-slate-500 text-sm font-medium" id="wishlistCountHeader">
                <span id="wishlistTotalNum">{{ count($wishlistItems) }}</span> Items
            </span>
        </div>

        <!-- ====================================================================
             1. WISHLIST PRODUCTS GRID (MYNTRA LUXURY 5-COL / 4-COL LAYOUT)
             ==================================================================== -->
        <div id="wishlistGridContainer" class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3 g-md-4">
            @foreach ($wishlistItems as $item)
                <div class="col wishlist-item-col" id="wishlist-item-{{ $item['id'] }}">
                    <div class="card h-100 bg-white border border-slate-200 rounded-lg overflow-hidden shadow-none transition duration-200 hover:shadow-md hover:border-slate-300 position-relative group d-flex flex-column">
                        
                        <!-- Top-Right Remove (Close) Cross Button (Myntra Style) -->
                        <button type="button" 
                                class="btn-close-wishlist position-absolute top-2 end-2 z-10 w-7 h-7 rounded-circle bg-white/90 backdrop-blur-sm border border-slate-200 text-slate-500 d-flex align-items-center justify-content-center transition hover:bg-slate-900 hover:text-white hover:border-slate-900 shadow-sm"
                                title="Remove from Wishlist"
                                onclick="removeWishlistItem('{{ $item['id'] }}', '{{ addslashes($item['name']) }}')">
                            <i class="bi bi-x-lg text-[11px]"></i>
                        </button>

                        <!-- Product Thumbnail Container with Rating Badge -->
                        <a href="{{ url('/products/' . $item->product->id) }}" class="d-block position-relative bg-slate-100 overflow-hidden text-decoration-none" style="aspect-ratio: 3/4;">
                            <img src="{{ asset('/storage/'.$item->product->image) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-100 h-100 object-fit-cover transition duration-300 group-hover:scale-105"
                                 loading="lazy"
                                 onerror="this.src='https://via.placeholder.com/300x400?text=Product+Photo'">
                        </a>

                        <!-- Product Details Body -->
                        <div class="p-2.5 sm:p-3 d-flex flex-column flex-grow-1">
                            <!-- Brand -->
                            <div class="text-[11px] font-bold text-slate-900 uppercase tracking-wider text-truncate mb-0.5">
                                {{ $item->product->brand }}
                            </div>

                            <!-- Product Name -->
                            <a href="{{ url('/products/' . $item->product->id) }}" class="text-xs text-slate-600 text-truncate text-decoration-none hover:text-slate-900 mb-2" title="{{ $item->product->name }}">
                                {{ $item->product->name }}
                            </a>

                            <!-- Pricing -->
                            <div class="d-flex align-items-baseline gap-1.5 mt-auto flex-wrap font-sans">
                                <span class="text-sm font-bold text-slate-900">
                                    &#8377;{{ number_format($item->product->price) }}
                                </span>
                                @if ($item->product->discount_percentage > 0 && $item->product->discount_price > 0)
                                    <span class="text-[11px] text-slate-400 text-decoration-line-through">
                                        &#8377;{{ number_format($item->product->original_price) }}
                                    </span>
                                    <span class="text-[11px] font-bold text-rose-600">
                                        ({{ $item->product->discount }}% OFF)
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Full-Width Bottom Action (Myntra "MOVE TO BAG" Button) -->
                        <div class="border-t border-slate-100">
                            <button type="button" 
                                    class="w-100 py-2.5 px-3 bg-white hover:bg-[#6c2222] hover:text-white text-[#6c2222] text-xs font-bold uppercase tracking-wider transition duration-150 d-flex align-items-center justify-content-center gap-1.5 border-0"
                                    onclick="moveToBag('{{ $item['id'] }}', '{{ addslashes($item['name']) }}')">
                                <i class="bi bi-bag text-sm"></i>
                                <span>MOVE TO BAG</span>
                            </button>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <!-- ====================================================================
             2. EMPTY WISHLIST STATE (MYNTRA SIGNATURE STYLE)
             ==================================================================== -->
        <div id="emptyWishlistState" class="text-center py-5 my-4" style="display: none;">
            <div class="max-w-md mx-auto px-4">
                <div class="w-20 h-20 bg-rose-50 rounded-circle text-rose-600 d-inline-flex align-items-center justify-content-center mb-3.5 shadow-sm">
                    <i class="bi bi-heart text-3xl"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900 uppercase tracking-wide mb-1.5">
                    Your Wishlist is Empty
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 mb-4 leading-relaxed">
                    Explore our curated ethnic luxury collections and save your favorite styles to review anytime.
                </p>
                <a href="{{ url('/') }}" class="btn btn-dark px-4 py-2.5 text-xs font-bold uppercase tracking-wider rounded-md shadow-sm transition hover:bg-slate-800">
                    <i class="bi bi-arrow-left me-1.5"></i> Continue Shopping
                </a>
            </div>
        </div>

    </div>
</div>

<!-- Extra Styling for Myntra Hover & Micro-interactions -->
<style>
    .btn-close-wishlist {
        cursor: pointer;
        opacity: 0.9;
    }
    .btn-close-wishlist:hover {
        opacity: 1;
        transform: scale(1.08);
    }
    .wishlist-item-col {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
</style>

<script>
    // Remove item from wishlist with smooth UI fade out
    function removeWishlistItem(itemId, itemName) {
        const itemEl = document.getElementById('wishlist-item-' + itemId);
        if (itemEl) {
            itemEl.style.opacity = '0';
            itemEl.style.transform = 'scale(0.95)';
            
            setTimeout(() => {
                itemEl.remove();
                updateWishlistCounter();
                if (window.showToast) {
                    window.showToast(itemName + ' removed from wishlist', 'info');
                }
            }, 250);
        }
    }

    // Move to Bag simulated action (Myntra UI flow)
    function moveToBag(itemId, itemName) {
        if (window.showToast) {
            window.showToast(itemName + ' moved to bag successfully!', 'success');
        } else {
            alert(itemName + ' moved to bag!');
        }

        // Optionally remove from wishlist after moving to bag
        removeWishlistItem(itemId, itemName);
    }

    // Dynamic Item Counter & Empty State Handler
    function updateWishlistCounter() {
        const remainingItems = document.querySelectorAll('.wishlist-item-col').length;
        const totalNumEl = document.getElementById('wishlistTotalNum');
        if (totalNumEl) {
            totalNumEl.textContent = remainingItems;
        }

        if (remainingItems === 0) {
            document.getElementById('wishlistGridContainer').style.display = 'none';
            document.getElementById('wishlistCountHeader').style.display = 'none';
            document.getElementById('emptyWishlistState').style.display = 'block';
        }
    }
</script>
@endsection
