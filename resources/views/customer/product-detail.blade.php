@extends('main')

@section('title', ($product->name ?? 'Product Detail') . ' - Vastrkaya')

@php
    $show_navbar = true;
    $show_footer = true;

    // Pricing calculations
    $sellingPrice = (float) $product->price;
    $discountPrice = (float) ($product->discount_price ?? 0);
    $discountPercent = (float) ($product->discount_percentage ?? 0);

    if ($discountPrice > 0 && $discountPrice < $sellingPrice) {
        $actualPrice = $sellingPrice;
        $finalPrice = $discountPrice;
    } else {
        $finalPrice = $sellingPrice;
        $actualPrice = $discountPrice > $sellingPrice ? $discountPrice : $sellingPrice * 1.3;
    }

    if ($discountPercent <= 0 && $actualPrice > $finalPrice) {
        $discountPercent = (($actualPrice - $finalPrice) / $actualPrice) * 100;
    }

    $savings = max(0, $actualPrice - $finalPrice);
@endphp

@section('hero-section')
    <div class="bg-white text-slate-800 font-sans">

        <!-- Breadcrumb -->
        <div class="border-b border-slate-200 py-2.5 mb-4 bg-white">
            <div class="container-fluid px-3 px-lg-4">
                <ol class="breadcrumb mb-0 text-xs align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Shop</a>
                    </li>
                    @if ($product->category)
                        <li class="breadcrumb-item">
                            <a href="{{ url('/products?category=' . $product->category_id) }}"
                                class="text-slate-500 hover:text-slate-900 text-decoration-none">
                                {{ $product->category->name }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active text-slate-800 font-medium truncate max-w-xs" aria-current="page">
                        {{ $product->name }}
                    </li>
                </ol>
            </div>
        </div>

        <!-- Product Layout -->
        <div class="container-fluid px-3 px-lg-4 pb-5">
            <div class="row g-4 g-lg-5">

                <!-- LEFT COLUMN: Gallery -->
                <div class="col-lg-5 col-xl-5">
                    <div class="sticky-top" style="top: 85px; z-index: 5;">

                        <div class="d-flex flex-column flex-md-row gap-2">
                            <!-- Vertical Thumbnails -->
                            <div class="order-2 order-md-1 d-flex flex-md-column gap-2 overflow-auto"
                                style="max-height: 440px;">
                                <!-- Main Image Thumb -->
                                <div class="vk-gallery-thumb active w-[52px] h-[64px] shrink-0 border border-slate-200 rounded p-0.5 cursor-pointer bg-white transition hover:border-slate-400 [&.active]:border-slate-900 [&.active]:shadow-[0_0_0_1px_#0f172a]"
                                    onclick="switchShowcaseImage('{{ asset('storage/' . $product->image) }}', this)">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover rounded">
                                </div>
                            </div>

                            <!-- Main Image Display Container -->
                            <div id="mainImgContainer"
                                class="order-1 order-md-2 flex-grow-1 position-relative bg-white border border-slate-200 rounded-lg min-h-[420px] flex items-center justify-center select-none p-3 shadow-none">

                                <!-- Discount Tag -->
                                @if ($discountPercent > 0)
                                    <span
                                        class="position-absolute top-2.5 start-2.5 badge bg-danger text-xs font-semibold px-2 py-1 rounded z-10">
                                        {{ round($discountPercent) }}% OFF
                                    </span>
                                @endif

                                <!-- Share & Wishlist Icons -->
                                <div class="position-absolute top-2.5 end-2.5 d-flex gap-1.5 z-10 d-none">
                                    <button type="button"
                                        class="btn btn-light rounded-circle p-0 d-flex align-items-center justify-content-center shadow-none border border-slate-200 w-8 h-8 transition hover:bg-white hover:shadow-sm d-none"
                                        title="Wishlist" onclick="addWishlist('{{ $product->id }}')">
                                        <i
                                            class="bi bi-heart{{ $product->wishLists->isNotEmpty() ? '-fill text-danger' : '' }} wishbtn"></i>
                                    </button>
                                </div>

                                <!-- Navigation Arrows -->
                                <button type="button"
                                    class="position-absolute start-2 top-50 -translate-y-1/2 w-8 h-8 bg-white/90 border border-slate-200 text-slate-900 transition hover:bg-white hover:shadow-sm rounded-circle d-flex align-items-center justify-content-center p-0 z-10"
                                    onclick="cycleGallery(-1)" title="Previous">
                                    <i class="bi bi-chevron-left text-xs"></i>
                                </button>
                                <button type="button"
                                    class="position-absolute end-2 top-50 -translate-y-1/2 w-8 h-8 bg-white/90 border border-slate-200 text-slate-900 transition hover:bg-white hover:shadow-sm rounded-circle d-flex align-items-center justify-content-center p-0 z-10"
                                    onclick="cycleGallery(1)" title="Next">
                                    <i class="bi bi-chevron-right text-xs"></i>
                                </button>

                                <!-- Slide Counter -->
                                @php
                                    $activePovs = $product->productOptionValues
                                        ? $product->productOptionValues->where('status', 1)
                                        : collect();
                                    $totalPhotos =
                                        1 +
                                        ($activePovs->whereNotNull('image')->count() +
                                            $activePovs->whereNotNull('optionValue.option_value_image')->count());
                                @endphp
                                <span id="vkSlideCounterBadge"
                                    class="position-absolute bottom-2.5 end-2.5 badge bg-slate-900/80 rounded px-2 py-0.5 text-[10px] text-white z-10">
                                    1 / {{ max(1, $totalPhotos) }}
                                </span>

                                <!-- Main Image -->
                                <img id="mainDisplayPhoto" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="img-fluid max-h-[420px] w-full object-contain transition-opacity duration-150">
                            </div>
                        </div>

                        <!-- Simple Trust Badges Strip -->
                        <div
                            class="d-flex align-items-center justify-content-around py-2.5 px-2 mt-2 border border-slate-200 rounded-lg bg-slate-50 text-slate-600 text-xs">
                            <span class="d-inline-flex align-items-center gap-1">
                                <i class="bi bi-shield-check text-success text-sm"></i> 100% Genuine
                            </span>
                            <span class="text-slate-300">&bull;</span>
                            <span class="d-inline-flex align-items-center gap-1">
                                <i class="bi bi-truck text-primary text-sm"></i> Fast Delivery
                            </span>
                            <span class="text-slate-300">&bull;</span>
                            <span class="d-inline-flex align-items-center gap-1">
                                <i class="bi bi-arrow-counterclockwise text-dark text-sm"></i> 7 Days Return
                            </span>
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN: Product Details & Purchase Actions -->
                <div class="col-lg-7 col-xl-7">

                    <!-- Category / Brand Line -->
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="uppercase tracking-wider text-slate-500 text-[11px] font-semibold">
                            {{ $product->brand ?: 'Vastrkaya' }} @if ($product->category)
                                &bull; {{ $product->category->name }}
                            @endif
                        </span>
                        @if ($product->stock > 0)
                            <span
                                class="badge text-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5 text-[10px] font-semibold rounded">
                                In Stock
                            </span>
                        @else
                            <span
                                class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-0.5 text-[10px] font-semibold rounded">
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="h5 fw-bold text-slate-900 mb-2 capitalize text-xl leading-snug product_id" data-id="{{ $product->id }}">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating & Reviews -->
                    <div class="d-flex align-items-center gap-2 mb-2.5 text-xs text-slate-500">
                        <span
                            class="badge bg-success text-white px-1.5 py-0.5 rounded text-[10px] font-semibold d-inline-flex align-items-center gap-1">
                            4.9 <i class="bi bi-star-fill text-[9px]"></i>
                        </span>
                        <span>124 ratings</span>
                        <span>&bull;</span>
                        <a href="#collapseReviews" class="text-slate-500 hover:text-slate-900 text-decoration-none"
                            onclick="document.querySelector('#headingReviews button')?.click();">
                            85 reviews
                        </a>
                    </div>

                    <!-- Pricing Section -->
                    <div class="d-flex align-items-baseline gap-2.5 mb-1 flex-wrap">
                        <span class="h4 fw-bold text-slate-900 mb-0 text-2xl">
                            &#8377;<span class="price">{{ number_format($product->price - $product->discount_price) }}</span>
                        </span>
                        @if ($savings > 0)
                            <span class="text-muted text-decoration-line-through text-xs">
                                &#8377;<span class="discount-price">{{ number_format($product->price ) }}</span>
                            </span>
                            <span class="text-xs font-bold text-success px-1.5 py-0.5 text-success bg-opacity-10 rounded">
                                {{ round($discountPercent) }}% OFF
                            </span>
                        @endif
                    </div>
                    <div class="text-xs text-slate-400 mb-3">Inclusive of all taxes</div>

                    <!-- Scoped Option Swatch Selection Styles -->
                    <style>
                        .vk-option-item {
                            position: relative;
                            display: inline-flex;
                        }

                        .vk-option-item input[type="radio"]:checked+label {
                            border-color: #0f172a !important;
                            box-shadow: 0 0 0 1px #0f172a !important;
                        }

                        .vk-option-item.has-img input[type="radio"]:checked+label {
                            background-color: #f8fafc !important;
                            color: #0f172a !important;
                            font-weight: 600 !important;
                        }

                        .vk-option-item.has-text input[type="radio"]:checked+label {
                            background-color: #0f172a !important;
                            color: #ffffff !important;
                            font-weight: 600 !important;
                        }
                    </style>

                    <!-- Variants / Options Selection -->
                    @if ($product->productOptions && $product->productOptions->count() > 0)
                        @foreach ($product->productOptions as $pOpt)
                            @php
                                $optModel = $pOpt->option;
                                $assignedValues = $product->productOptionValues
                                    ->where('option_id', $pOpt->option_id)
                                    ->where('status', 1);
                            @endphp

                            @if (($pOpt->status ?? 1) == 1 && $optModel && $assignedValues->count() > 0)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1.5">
                                        <label class="form-label text-[11px] uppercase text-slate-500 font-bold mb-0">
                                            Select {{ $optModel->name }}:
                                            <span class="text-slate-900 font-bold ms-1"
                                                id="labelOption_{{ $optModel->id }}">
                                                {{ $assignedValues->first()->optionValue->name ?? '' }}
                                            </span>
                                        </label>
                                        @if (strtolower($optModel->name) === 'size')
                                            <button type="button"
                                                class="btn btn-link text-decoration-none p-0 text-xs text-danger"
                                                data-bs-toggle="modal" data-bs-target="#sizeGuideModal">
                                                <i class="bi bi-rulers me-1"></i>Size Chart
                                            </button>
                                        @endif
                                    </div>

                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($assignedValues as $k => $pov)
                                            @php
                                                $optVal = $pov->optionValue;
                                                $valImg = $pov->image ?: $optVal->option_value_image ?? null;
                                                $isFirst = $k === $assignedValues->keys()->first();
                                            @endphp
                                            @if ($optVal)
                                                <div class="vk-option-item {{ $valImg ? 'has-img' : 'has-text' }}">
                                                    <input type="radio"
                                                        class="btn-check peer opt-radio-{{ $optModel->id }} input-radio"
                                                        name="opt_choice[{{ $optModel->id }}]"
                                                        id="optVal_{{ $pov->id }}" value="{{ $optVal->id }}"
                                                        data-option-name="{{ $optModel->name }}"
                                                        data-pov-id="{{ $pov->id }}"
                                                        data-option-id="{{ $optModel->id }}"
                                                        onchange="handleOptionChange('{{ $optModel->id }}', '{{ $optVal->name }}', '{{ $valImg ? asset('storage/' . $valImg) : '' }}', {{ $pov->id }})"
                                                        {{ $isFirst ? 'checked' : '' }}>

                                                    @if ($valImg)
                                                        <label
                                                            class="vk-option-label border border-slate-200 rounded px-2.5 py-1.5 text-xs font-medium cursor-pointer bg-white transition hover:border-slate-400 peer-checked:border-slate-900 peer-checked:bg-slate-50 peer-checked:ring-1 peer-checked:ring-slate-900 d-flex align-items-center gap-1.5 select-none"
                                                            for="optVal_{{ $pov->id }}">
                                                            <img src="{{ asset('storage/' . $valImg) }}"
                                                                alt="{{ $optVal->name }}"
                                                                class="w-6 h-6 object-cover rounded border border-slate-100">
                                                            <span class="text-xs px-1">{{ $optVal->name }}</span>
                                                        </label>
                                                    @else
                                                        <label
                                                            class="vk-option-label border border-slate-200 rounded px-3 py-1.5 text-center text-xs font-medium cursor-pointer bg-white transition hover:border-slate-400 peer-checked:border-slate-900 peer-checked:bg-slate-900 peer-checked:text-white peer-checked:font-semibold select-none"
                                                            for="optVal_{{ $pov->id }}">
                                                            {{ $optVal->name }}
                                                        </label>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    <!-- Quantity & Action Buttons -->
                    <div class="d-flex flex-wrap align-items-center gap-2 my-3">
                        <!-- Add to Cart Button -->
                        <button type="button" id="addToCartBtn" onclick="handleAddToCart({{ $product }})"
                            class="btn btn-dark flex-grow-1 text-xs font-semibold d-inline-flex align-items-center justify-content-center gap-1.5 rounded shadow-sm h-[38px] bg-slate-900 border-slate-900 hover:bg-slate-800 transition-all duration-200">
                            <i class="bi bi-cart3 text-sm"></i>
                            <span id="addToCartBtnText">Add to Cart</span>
                        </button>

                        <!-- Buy Now Button -->
                        <button type="button"
                            class="btn btn-warning flex-grow-1 text-xs font-semibold d-inline-flex align-items-center justify-content-center gap-1.5 rounded shadow-sm text-dark h-[38px] bg-amber-500 border-amber-500 hover:bg-amber-600">
                            <i class="bi bi-lightning-fill text-sm"></i> Buy Now
                        </button>
                    </div>

                    <!-- Simple Clean Details Accordions -->
                    <div class="accordion" id="productDetailsAccordion">

                        <!-- 1. Description -->
                        <div class="accordion-item border border-slate-200 rounded mb-2 overflow-hidden">
                            <h2 class="accordion-header" id="headingDescription">
                                <button
                                    class="accordion-button text-xs font-semibold text-slate-800 bg-slate-50 py-2.5 px-3.5 shadow-none"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription"
                                    aria-expanded="true" aria-controls="collapseDescription">
                                    <i class="bi bi-file-text me-2 text-primary"></i> Product Description
                                </button>
                            </h2>
                            <div id="collapseDescription" class="accordion-collapse collapse show"
                                aria-labelledby="headingDescription">
                                <div class="accordion-body text-xs text-slate-600 p-3.5 bg-white leading-relaxed">
                                    <p class="mb-0">
                                        {!! nl2br(e($product->description)) ?:
                                            'Carefully crafted using premium quality materials for style, comfort, and durability. Ideal for casual, festive, and daily wear.' !!}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Specifications / Product Details -->
                        <div class="accordion-item border border-slate-200 rounded mb-2 overflow-hidden">
                            <h2 class="accordion-header" id="headingSpecs">
                                <button
                                    class="accordion-button collapsed text-xs font-semibold text-slate-800 bg-slate-50 py-2.5 px-3.5 shadow-none"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseSpecs"
                                    aria-expanded="false" aria-controls="collapseSpecs">
                                    <i class="bi bi-info-circle me-2 text-primary"></i> Specifications & Details
                                </button>
                            </h2>
                            <div id="collapseSpecs" class="accordion-collapse collapse" aria-labelledby="headingSpecs">
                                <div class="accordion-body p-0">
                                    <table class="table table-sm table-bordered mb-0 text-xs">
                                        <tbody>
                                            <tr>
                                                <td class="bg-slate-50 text-slate-500 font-semibold w-2/5">Category</td>
                                                <td class="text-slate-800">{{ $product->category->name ?? 'Apparel' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="bg-slate-50 text-slate-500 font-semibold">Brand</td>
                                                <td class="text-slate-800">{{ $product->brand ?: 'Vastrkaya' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-slate-50 text-slate-500 font-semibold">Product SKU</td>
                                                <td class="text-slate-800">
                                                    VK-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="bg-slate-50 text-slate-500 font-semibold">Stock Status</td>
                                                <td class="text-slate-800">
                                                    @if ($product->stock > 0)
                                                        <span class="text-success font-semibold">{{ $product->stock }}
                                                            units left</span>
                                                    @else
                                                        <span class="text-danger font-semibold">Out of Stock</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Shipping & Returns -->
                        <div class="accordion-item border border-slate-200 rounded mb-2 overflow-hidden">
                            <h2 class="accordion-header" id="headingShipping">
                                <button
                                    class="accordion-button collapsed text-xs font-semibold text-slate-800 bg-slate-50 py-2.5 px-3.5 shadow-none"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseShipping"
                                    aria-expanded="false" aria-controls="collapseShipping">
                                    <i class="bi bi-truck me-2 text-primary"></i> Shipping & Returns
                                </button>
                            </h2>
                            <div id="collapseShipping" class="accordion-collapse collapse"
                                aria-labelledby="headingShipping">
                                <div class="accordion-body text-xs text-slate-600 p-3.5 bg-white leading-relaxed">
                                    <ul class="list-unstyled mb-0 space-y-1">
                                        <li>&bull; Dispatched within 24-48 business hours.</li>
                                        <li>&bull; Delivery in 3-5 business days across India.</li>
                                        <li>&bull; 7 days easy return and replacement policy.</li>
                                        <li>&bull; Free shipping on orders above &#8377;999.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Customer Reviews -->
                        <div class="accordion-item border border-slate-200 rounded mb-2 overflow-hidden"
                            id="reviewsAccordionSection">
                            <h2 class="accordion-header" id="headingReviews">
                                <button
                                    class="accordion-button collapsed text-xs font-semibold text-slate-800 bg-slate-50 py-2.5 px-3.5 shadow-none"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseReviews"
                                    aria-expanded="false" aria-controls="collapseReviews">
                                    <i class="bi bi-star me-2 text-warning"></i> Customer Reviews (4.9 / 5)
                                </button>
                            </h2>
                            <div id="collapseReviews" class="accordion-collapse collapse"
                                aria-labelledby="headingReviews">
                                <div class="accordion-body text-xs text-slate-600 p-3.5 bg-white">
                                    <div class="d-flex align-items-center gap-2.5 p-2 bg-slate-50 rounded mb-2.5">
                                        <span class="font-bold text-slate-900 text-lg">4.9</span>
                                        <div class="text-warning text-xs">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                                                class="bi bi-star-fill"></i>
                                        </div>
                                        <span class="text-xs text-slate-400 ms-auto">Based on 124 ratings</span>
                                    </div>

                                    <div class="d-flex flex-column gap-2">
                                        <div class="p-2 border border-slate-200 rounded bg-white text-xs">
                                            <div class="d-flex justify-content-between mb-1">
                                                <strong class="text-slate-800">Pooja S. <span
                                                        class="badge text-success bg-opacity-15 text-success text-[9px]">Verified</span></strong>
                                                <span class="text-slate-400 text-[10px]">3 days ago</span>
                                            </div>
                                            <p class="text-slate-600 mb-0">Good fabric quality, matches the photo nicely.
                                            </p>
                                        </div>
                                        <div class="p-2 border border-slate-200 rounded bg-white text-xs">
                                            <div class="d-flex justify-content-between mb-1">
                                                <strong class="text-slate-800">Ananya V. <span
                                                        class="badge text-success bg-opacity-15 text-success text-[9px]">Verified</span></strong>
                                                <span class="text-slate-400 text-[10px]">1 week ago</span>
                                            </div>
                                            <p class="text-slate-600 mb-0">Nice packaging and fast delivery.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <!-- BOTTOM SECTION: Related Products (Taller Box Height with Tailwind & Bootstrap) -->
            @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="mt-5 pt-4 border-t border-slate-200">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <div>
                            <span class="text-[10px] font-bold uppercase block mb-1 text-amber-700 tracking-[1.5px]">
                                &#124;&#124; CURATED COLLECTION &#124;&#124;
                            </span>
                            <h3 class="font-bold text-slate-900 mb-0 text-xl md:text-2xl">
                                Related Products
                            </h3>
                        </div>
                        <a href="{{ url('/') }}"
                            class="text-decoration-none text-xs font-semibold text-slate-900 hover:text-amber-700 d-inline-flex align-items-center gap-1 transition">
                            View All Products &rarr;
                        </a>
                    </div>

                    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-lg-4">
                        @foreach ($relatedProducts->take(4) as $rel)
                            <div class="col">
                                <!-- Increased Box Height Card with Tailwind CSS & Bootstrap Utilities -->
                                <div
                                    class="border border-slate-200 rounded-2xl bg-white overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-lg flex flex-col justify-between h-full group">
                                    <div>
                                        <!-- Tall Product Image Box (Height increased to 300px) -->
                                        <a href="{{ url('products/' . $rel->id) }}"
                                            class="relative block w-full h-72 sm:h-80 md:h-[300px] bg-[#fbfbfa] overflow-hidden">
                                            @if ($rel->discount_percentage)
                                                <span
                                                    class="position-absolute top-2.5 start-2.5 bg-green-700 text-white text-[9px] font-bold tracking-wider px-2 py-0.5 rounded uppercase z-10 shadow-sm">
                                                    {{ round($rel->discount_percentage) }}% OFF
                                                </span>
                                            @endif
                                            <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->name }}"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        </a>

                                        <!-- Content Body -->
                                        <div class="p-3 pb-2">
                                            <span
                                                class="text-[10px] font-bold tracking-wider text-amber-700 uppercase block mb-1 truncate">
                                                {{ $rel->category->name ?? 'Collection' }}
                                            </span>
                                            <h6 class="text-xs font-bold text-slate-800 mb-2 truncate">
                                                <a href="{{ url('products/' . $rel->id) }}" title="{{ $rel->name }}"
                                                    class="text-inherit text-decoration-none hover:text-slate-900">
                                                    {{ $rel->name }}
                                                </a>
                                            </h6>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <div class="d-flex align-items-baseline gap-1.5">
                                                    <span
                                                        class="font-bold text-slate-900 text-sm md:text-base">&#8377;{{ number_format($rel->price) }}</span>
                                                    @if ($rel->discount_price)
                                                        <span
                                                            class="text-slate-400 text-decoration-line-through text-xs">&#8377;{{ number_format($rel->discount_price + $rel->price) }}</span>
                                                    @endif
                                                </div>
                                                <span
                                                    class="text-xs font-semibold text-slate-800 d-inline-flex align-items-center gap-1">
                                                    <i class="bi bi-star-fill text-warning text-[10px]"></i> 4.8
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="px-3 pb-3">
                                        <a href="{{ url('products/' . $rel->id) }}"
                                            class="bg-[#a85d58] border border-[#ebe8e1] text-slate-800 text-xs font-semibold rounded-lg py-2 px-3 block w-full text-center text-decoration-none text-white transition hover:bg-slate-600 hover:text-white hover:border-slate-900">
                                            View Product &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Floating Add to Cart Toast Notification -->
    <div id="cartToast"
        class="fixed top-20 right-4 z-50 transition-all duration-300 opacity-0 translate-y-2 pointer-events-none"
        style="max-width: 340px;">
        <div class="bg-slate-900 text-white rounded-xl shadow-2xl p-3 border border-slate-800 flex items-center gap-3">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                class="w-11 h-11 object-cover rounded-lg shrink-0 border border-slate-700">
            <div class="flex-grow min-w-0">
                <div class="d-flex align-items-center gap-1 text-[11px] text-emerald-400 font-semibold mb-0.5">
                    <i class="bi bi-check-circle-fill"></i> Added to Bag!
                </div>
                <div class="text-xs text-white font-medium truncate">{{ $product->name }}</div>
                <div class="text-[10px] text-slate-400">Qty: <span id="toastQty">1</span> &bull;
                    &#8377;{{ number_format($product->price + $product->discount) }}</div>
            </div>
            <a href="{{ url('/cart') }}"
                class="text-[11px] font-semibold text-white bg-slate-800 hover:bg-slate-700 border border-slate-700 px-2.5 py-1.5 rounded-md text-decoration-none whitespace-nowrap transition">
                View Bag
            </a>
            <button type="button" onclick="closeCartToast()"
                class="text-slate-400 hover:text-white text-xs p-1 ml-1 border-0 bg-transparent shadow-none">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <!-- Size Guide Modal -->
    <div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-sm">
                <div class="modal-header py-2.5 px-3 border-b border-slate-200">
                    <h6 class="modal-title font-bold text-slate-900 text-xs mb-0" id="sizeGuideModalLabel">
                        <i class="bi bi-rulers me-1.5 text-danger"></i>Size Measurement Guide
                    </h6>
                    <button type="button" class="btn-close text-[10px] shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <p class="text-xs text-slate-500 mb-2">Measurements are in inches (&plusmn; 0.5" standard tolerance):
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-xs align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Size</th>
                                    <th>Chest</th>
                                    <th>Waist</th>
                                    <th>Hips</th>
                                    <th>Length</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>S</strong></td>
                                    <td>36</td>
                                    <td>32</td>
                                    <td>38</td>
                                    <td>54</td>
                                </tr>
                                <tr>
                                    <td><strong>M</strong></td>
                                    <td>38</td>
                                    <td>34</td>
                                    <td>40</td>
                                    <td>54</td>
                                </tr>
                                <tr>
                                    <td><strong>L</strong></td>
                                    <td>40</td>
                                    <td>36</td>
                                    <td>42</td>
                                    <td>55</td>
                                </tr>
                                <tr>
                                    <td><strong>XL</strong></td>
                                    <td>42</td>
                                    <td>38</td>
                                    <td>44</td>
                                    <td>55</td>
                                </tr>
                                <tr>
                                    <td><strong>XXL</strong></td>
                                    <td>44</td>
                                    <td>40</td>
                                    <td>46</td>
                                    <td>56</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // All available gallery photos for cycling
        const allGalleryImages = [
            '{{ asset('storage/' . $product->image) }}',
            @if ($product->productOptionValues)
                @foreach ($product->productOptionValues->where('status', 1) as $pov)
                    @php $valImg = $pov->image ?: ($pov->optionValue->option_value_image ?? null); @endphp
                    @if ($valImg)
                        '{{ asset('storage/' . $valImg) }}',
                    @endif
                @endforeach
            @endif
        ];

        let currentGalleryIdx = 0;

        function switchShowcaseImage(imageUrl, thumbEl) {
            if (!imageUrl) return;
            const mainImg = document.getElementById('mainDisplayPhoto');

            if (mainImg) {
                mainImg.style.opacity = '0.35';
                mainImg.src = imageUrl;
                setTimeout(() => {
                    mainImg.style.opacity = '1';
                }, 120);
            }

            // Sync slide counter badge if matched
            const idx = allGalleryImages.indexOf(imageUrl);
            if (idx !== -1) {
                currentGalleryIdx = idx;
                const badge = document.getElementById('vkSlideCounterBadge');
                if (badge) {
                    badge.textContent = `${currentGalleryIdx + 1} / ${Math.max(1, allGalleryImages.length)}`;
                }
            }

            let activeThumb = thumbEl;
            if (!activeThumb && imageUrl) {
                document.querySelectorAll('.vk-gallery-thumb').forEach(el => {
                    const img = el.querySelector('img');
                    if (img && img.src.includes(imageUrl)) {
                        activeThumb = el;
                    }
                });
            }
            if (activeThumb) {
                document.querySelectorAll('.vk-gallery-thumb').forEach(el => {
                    el.classList.remove('active');
                });
                activeThumb.classList.add('active');
            }
        }

        // Cycle images through previous and next navigation arrows
        function cycleGallery(delta) {
            if (!allGalleryImages || allGalleryImages.length <= 1) return;
            currentGalleryIdx = (currentGalleryIdx + delta + allGalleryImages.length) % allGalleryImages.length;
            const targetUrl = allGalleryImages[currentGalleryIdx];

            // Find matching thumbnail element to highlight
            const thumbs = document.querySelectorAll('.vk-gallery-thumb');
            let matchingThumb = null;
            thumbs.forEach(t => {
                const img = t.querySelector('img');
                if (img && img.src.includes(targetUrl)) {
                    matchingThumb = t;
                }
            });

            switchShowcaseImage(targetUrl, matchingThumb);
        }

        document.addEventListener('DOMContentLoaded', function () {

            let povIds = [];

            $('.input-radio:checked').each(function () {
                let povId = $(this).data('pov-id');

                if (povId) {
                    povIds.push(povId);
                }
            });

            if(povIds.length != 0) {
                fetchPrice(povIds);
            }
            
        });

        function handleOptionChange(optionId, valName, valImage, povId) {

            const lbl = document.getElementById('labelOption_' + optionId);

            if (lbl) {
                lbl.textContent = valName;
            }

            let povIds = [];
             $('.input-radio:checked').each(function () {
                let povId = $(this).data('pov-id');

                if (povId) {
                    povIds.push(povId);
                }

            });

            if(povIds.length != 0) {
                fetchPrice(povIds);
            }
        }


        function fetchPrice(povId) {

            axios.post('/option-value/price/change', {
                povId: povId,
                _token: "{{ csrf_token() }}"
            })
            .then((res) => {
                if (res.data.success) {
                    $('.price').text(res.data.finalPrice);
                    $('.discount-price').text(res.data.discount_price);
                }
            })
            .catch((err) => {
                console.error(err.response?.data || err);
                window.showToast('Something went wrong', 'error');
            });

        }

        let toastTimeout = null;

        // Handle Add to Cart Button UI interaction
        function handleAddToCart(product) {
            const selectedOptionValueIds = [];

            document.querySelectorAll('input[name^="opt_choice"]:checked').forEach(input => {
                const valId = parseInt(input.value);
                if (!isNaN(valId)) {
                    selectedOptionValueIds.push(valId);
                }
            });

            // Extract numeric price safely (removes any currency symbols, commas, or spaces)
            const rawPrice = $('.price').text() || '';
            const cleanPrice = parseFloat(rawPrice.replace(/[^0-9.]/g, '')) || 0;

            axios.post('{{ route('cart.add') }}', {
                    product: product,
                    options: selectedOptionValueIds,
                    price: cleanPrice,
                    quantity: 1
                })
                .then(response => {
                    showCartToast();
                })
                .catch((err) => {
                    console.error(err);
                });
        }

        function showCartToast() {
            const toast = document.getElementById('cartToast');
            if (!toast) return;

            // Show toast
            toast.classList.remove('opacity-0', 'translate-y-2', 'pointer-events-none');
            toast.classList.add('opacity-100', 'translate-y-0');

            if (toastTimeout) clearTimeout(toastTimeout);
            toastTimeout = setTimeout(closeCartToast, 1500);
        }

        function closeCartToast() {
            const toast = document.getElementById('cartToast');
            if (!toast) return;
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-2', 'pointer-events-none');
        }
    </script>
@endsection
