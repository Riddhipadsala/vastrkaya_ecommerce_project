@extends('main')

@section('title', 'Shopping Bag - Vastrkaya')

@php
    $show_navbar = true;
    $show_footer = true;
@endphp

@section('hero-section')
    <div class="bg-[#f8fafc] min-h-screen py-4 sm:py-6 text-slate-800 font-sans"
        style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
        <div class="container-fluid px-3 px-lg-4 max-w-5xl mx-auto">

            <!-- Top Checkout Progress Navigation -->
            <div
                class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 mb-4 pb-3 border-b border-slate-200">
                <!-- Breadcrumbs -->
                <ol class="breadcrumb mb-0 text-xs align-items-center">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Shop</a></li>
                    <li class="breadcrumb-item active text-slate-900 font-semibold" aria-current="page">Shopping Bag</li>
                </ol>

                <!-- Minimal Stepper Indicator -->
                <div class="d-flex align-items-center gap-2 text-xs font-semibold tracking-wider">
                    <span class="text-slate-900 d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-slate-900 text-white d-inline-flex align-items-center justify-content-center text-[10px] font-bold">1</span>
                        BAG
                    </span>
                    <span class="w-8 h-[1px] bg-slate-300"></span>
                    <span class="text-slate-400 d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-slate-200 text-slate-500 d-inline-flex align-items-center justify-content-center text-[10px]">2</span>
                        ADDRESS
                    </span>
                    <span class="w-8 h-[1px] bg-slate-300"></span>
                    <span class="text-slate-400 d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-slate-200 text-slate-500 d-inline-flex align-items-center justify-content-center text-[10px]">3</span>
                        PAYMENT
                    </span>
                </div>
            </div>

            <!-- Free Delivery Notification Bar -->
            <div
                class="bg-emerald-50 border border-emerald-200 rounded-xl px-3.5 py-2.5 mb-3.5 d-flex align-items-center justify-content-between flex-wrap gap-2 text-xs">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-truck text-emerald-700 text-sm"></i>
                    <span class="text-emerald-950 font-medium">
                        Yay! You unlocked <strong class="text-emerald-800">FREE Standard Delivery</strong> on this order.
                    </span>
                </div>
                <span class="badge bg-emerald-600 text-white font-semibold text-[10px] px-2 py-0.5 rounded-pill">
                    FREE SHIPPING
                </span>
            </div>

            <div class="row g-3 g-lg-4">

                <!-- LEFT COLUMN: Cart Items List -->
                <div class="col-lg-7 col-xl-7">

                    <!-- Items Selection & Clear Header -->
                    <div
                        class="bg-white border border-slate-200 rounded-xl px-3.5 py-2.5 mb-2.5 d-flex align-items-center justify-content-between shadow-2xs">
                        <div class="d-flex align-items-center gap-2">
                            <label for="selectAllCart" class="text-xs font-bold text-slate-800 cursor-pointer mb-0">
                                ITEMS IN BAG (<span id="cartCountHeader"></span>)
                            </label>
                        </div>
                        <button type="button"
                            class="btn btn-link p-0 text-xs text-rose-600 hover:text-rose-700 text-decoration-none font-semibold shadow-none border-0"
                            onclick="confirmDeleteOption()">
                            <i class="bi bi-trash3 me-1"></i>Clear Bag
                        </button>
                    </div>

                    <!-- Bag Items List -->
                    <div class="space-y-3" id="cartItemsList">

                    </div>

                    <!-- Empty State -->
                    <div id="emptyCartView" class="bg-white border border-slate-200 rounded-2xl p-5 text-center my-3"
                        style="display: none;">
                        <div
                            class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="bi bi-bag-x text-2xl"></i>
                        </div>
                        <h3 class="text-sm font-bold text-slate-900 mb-1">Your Shopping Bag is Empty</h3>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mb-3">
                            Explore our handcrafted luxury sarees and ethnic wear to add items to your bag.
                        </p>
                        <a href="{{ url('/') }}"
                            class="btn btn-dark text-xs font-semibold px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 shadow-sm">
                            Continue Shopping &rarr;
                        </a>
                    </div>

                    <!-- Security Assurance Strip -->
                    <div
                        class="d-flex align-items-center justify-content-around py-2.5 px-3 mt-3 border border-slate-200 rounded-xl bg-white text-xs text-slate-600">
                        <span class="d-inline-flex align-items-center gap-1.5">
                            <i class="bi bi-shield-check text-emerald-600 text-sm"></i> 100% Secure Checkout
                        </span>
                        <span class="text-slate-300">&bull;</span>
                        <span class="d-inline-flex align-items-center gap-1.5">
                            <i class="bi bi-arrow-repeat text-indigo-600 text-sm"></i> 7 Days Easy Return
                        </span>
                        <span class="text-slate-300">&bull;</span>
                        <span class="d-inline-flex align-items-center gap-1.5">
                            <i class="bi bi-patch-check text-amber-600 text-sm"></i> 100% Authentic Products
                        </span>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Price Details & Checkout -->
                <div class="col-lg-5 col-xl-5">
                    <div class="sticky-top" style="top: 85px;">

                        <!-- Coupons Card -->
                        <div class="bg-white border border-slate-200 rounded-xl p-3.5 mb-3 shadow-2xs">
                            <div class="d-flex align-items-center gap-1.5 mb-2">
                                <i class="bi bi-tag-fill text-amber-600 text-xs"></i>
                                <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Coupons &amp;
                                    Offers</span>
                            </div>

                            <div class="input-group input-group-sm mb-2">
                                <input type="text" id="couponInput"
                                    class="form-control text-xs uppercase shadow-none border-slate-200 rounded-start"
                                    placeholder="ENTER COUPON CODE" value="VASTRA500">
                                <button class="btn btn-dark text-xs px-3 font-semibold bg-slate-900 border-slate-900"
                                    type="button" onclick="applyCoupon()">
                                    Apply
                                </button>
                            </div>
                            <div id="couponAppliedBadge"
                                class="d-flex align-items-center justify-content-between p-2 rounded-lg bg-emerald-50 border border-emerald-200 text-xs text-emerald-800">
                                <span class="d-inline-flex align-items-center gap-1 font-semibold text-[11px]">
                                    <i class="bi bi-check-circle-fill text-emerald-600"></i> Code <strong>VASTRA500</strong>
                                    Applied!
                                </span>
                                <span class="text-[11px] font-bold text-emerald-700">-&#8377;500</span>
                            </div>
                        </div>

                        <!-- Price Details Summary Box (Clean Sans-Serif Modern Typography) -->
                        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                            <h4
                                class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 pb-2 border-b border-slate-100 font-sans">
                                PRICE DETAILS (<span id="summaryCount"></span> ITEMS)
                            </h4>

                            <div class="space-y-2.5 text-xs font-sans">
                                <div class="d-flex justify-content-between text-slate-600">
                                    <span>Total Quantity</span>
                                    <span class="font-medium text-slate-900"><span id="sumQuantity"></span></span>
                                </div>

                                <div class="d-flex justify-content-between text-slate-600">
                                    <span>Total MRP</span>
                                    <span class="font-medium text-slate-900">&#8377;<span id="sumTotalMrp"></span></span>
                                </div>

                                <div class="d-flex justify-content-between text-slate-600 d-none">
                                    <span>Discount on MRP</span>
                                    <span class="text-emerald-600 font-semibold">-&#8377;<span
                                            id="sumTotalDiscount"></span></span>
                                </div>

                                <div class="d-flex justify-content-between text-slate-600">
                                    <span>Coupon Discount</span>
                                    <span class="text-emerald-600 font-semibold">-&#8377;<span
                                            id="sumCouponDiscount"></span></span>
                                </div>

                                <div class="d-flex justify-content-between text-slate-600">
                                    <span>Delivery Charges</span>
                                    <div class="text-end">
                                        <span class="text-emerald-600 font-bold uppercase text-[10px]"
                                            id="deliveryCharges">FREE</span>
                                    </div>
                                </div>

                                <hr class="my-2.5 border-slate-200">

                                <div class="d-flex justify-content-between text-sm font-bold text-slate-900">
                                    <span>Total Amount</span>
                                    <span class="text-lg font-extrabold text-slate-900">&#8377;<span
                                            id="sumFinalAmount"></span></span>
                                </div>
                            </div>

                            <!-- Savings Badge -->
                            <div class="mt-3 p-2.5 rounded-lg bg-emerald-50 border border-emerald-200 text-center">
                                <span
                                    class="text-xs font-semibold text-emerald-800 d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-stars text-amber-500"></i> You are saving <strong>&#8377;<span
                                            id="sumTotalSavings"></span></strong> on this order!
                                </span>
                            </div>
                            <!-- Primary Checkout Button -->
                            <div class="mt-3.5">
                                <a href="{{ route('admin.contact.index') }}"
                                    class="btn btn-dark w-100 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-slate-900 border-slate-900 hover:bg-slate-800 shadow-sm d-flex align-items-center justify-content-center gap-1.5 transition text-white text-decoration-none">
                                    <span>PROCEED TO CHECKOUT</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>

                            <div class="mt-2.5 text-center">
                                <span class="text-[10px] text-slate-400">
                                    <i class="bi bi-lock-fill me-1"></i> Safe &amp; Secure 256-Bit SSL Checkout
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchData();
            mainPriceBox();
        });

        function fetchData() {
            axios.get('/cart')
                .then((res) => {
                    let data = res.data.cartItem || [];

                    $('#cartCountHeader').text(data.length);
                    $('#summaryCount').text(data.length);
                    let records = '';

                    data.forEach(item => {
                        records += `
                    <div class="cart-item-card bg-white border border-slate-200 rounded-xl p-3 shadow-2xs transition-all duration-200 hover:border-slate-300" id="cartItem_${item.id}" data-unit-price="${item.price}">
                        
                        <!-- Top Section: Image & Main Info -->
                        <div class="d-flex gap-3">

                            <!-- Elegant Portrait Ratio Thumbnail (80px x 104px) -->
                            <div class="rounded-lg bg-slate-50 border border-slate-100 overflow-hidden shrink-0 relative flex items-center justify-center p-1" style="width: 80px; height: 104px;">
                                <img src="/storage/${item.product.image}" 
                                        alt="${item.product.name}" 
                                        class="w-full h-full object-cover rounded"
                                        onerror="this.src='/storage/${item.product.image}'">
                            </div>

                            <!-- Info Column -->
                            <div class="flex-grow min-w-0 flex flex-col justify-between">
                                <div>
                                    <!-- Brand & Delete Button -->
                                    <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                        <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                                            VASTRKAYA &bull; ${item.product?.category?.name}
                                        </span>
                                        <button type="button" class="btn btn-link p-0 text-slate-400 hover:text-rose-600 shadow-none border-0 text-xs" 
                                                title="Remove Item" onclick="removeCartItem('${item.id}')">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>

                                    <!-- Title -->
                                    <h4 class="text-sm sm:text-sm font-semibold text-slate-900 mb-1.5 capitalize text-truncate" title="${item.product.name}">
                                        ${item.product.name}
                                    </h4>

                                    <!-- Attributes Pills -->
                                    <div class="d-flex flex-wrap align-items-center gap-1.5 mb-2">
                                        ${(() => {
                                            if (Array.isArray(item.options) && item.options.length > 0) {
                                                return item.options.map(valId => {
                                                    let optName = '';
                                                    let optValName = valId;
                                                    const productOptions = item.product?.product_options || item.product?.productOptions || [];
                                                    for (const po of productOptions) {
                                                        const values = po.option?.option_values || po.option?.optionValues || [];
                                                        const foundVal = values.find(v => v.id == valId || v.name == valId);
                                                        if (foundVal) {
                                                            optName = po.option?.name || '';
                                                            optValName = foundVal.name;
                                                            break;
                                                        }
                                                    }
                                                    return `<span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[11px] font-medium border border-slate-200">${optName ? `<strong class="uppercase text-slate-900">${optName}:</strong> ` : ''}${optValName}</span>`;
                                                }).join('');
                                            } else if (item.options && typeof item.options === 'object' && Object.keys(item.options).length > 0) {
                                                return Object.entries(item.options).map(([name, val]) => 
                                                    `<span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[11px] font-medium border border-slate-200"><strong class="uppercase text-slate-900">${name}:</strong> ${val}</span>`
                                                ).join('');
                                            }
                                            return '';
                                        })()}
                                        ${(item.product.stock > 0 || item.product.decrease_stock > 0) ?
                                           `<span class="text-emerald-700 text-[11px] font-semibold d-inline-flex align-items-center gap-1 stock_${item.id}">
                                                            <i class="bi bi-check-circle-fill text-[10px]"></i> In Stock
                                                        </span>`
                                       :  `<span class="text-red-700 text-[11px] font-semibold d-inline-flex align-items-center gap-1 stock_${item.id}">
                                                            <i class="bi bi-x-circle-fill text-[10px]"></i> Out of Stock
                                                        </span>`
                                       }
                                        
                                    </div>
                                </div>

                                <!-- Price Line -->
                                <div class="d-flex align-items-baseline gap-2">
                                    <span class="text-base font-bold text-slate-900">&#8377;<span id="price_${item.id}">${item.new_price}</span></span>
                                   ${item.product.discount_price > 0
                                        ? `<span class="text-xs text-slate-500">Discount per product</span>
                                                        <span class="text-xs text-slate-400 text-decoration-line-through">&#8377;${ item.product.discount_price}</span>
                                                        <span class="text-xs font-bold text-emerald-600">${item.product.discount_percentage}% OFF</span>`
                                        : ''
                                    }
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Action Bar (Quantity Stepper + Action Links) -->
                        <div class="d-flex align-items-center justify-content-between pt-2.5 mt-2.5 border-t border-slate-100">
                            <!-- Compact Quantity Stepper -->
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-xs text-slate-500 font-medium">Qty:</span>
                                <div class="d-inline-flex align-items-center border border-slate-200 rounded-md bg-white h-7 overflow-hidden">
                                    <button type="button" class="btn btn-link text-slate-600 px-2.5 py-0 h-full border-0 shadow-none hover:bg-slate-100" 
                                            onclick="updateItemQty('${item.id}', -1, ${item.price})">
                                        <i class="bi bi-dash text-xs"></i>
                                    </button>
                                    <span id="qty_${item.id}" class="text-xs font-bold text-slate-800 px-2 min-w-[22px] text-center">
                                        ${item.quantity}
                                    </span>
                                    <button type="button" class="btn btn-link text-slate-600 px-2.5 py-0 h-full border-0 shadow-none hover:bg-slate-100" 
                                            onclick="updateItemQty('${item.id}', 1, ${item.price})">
                                        <i class="bi bi-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex align-items-center gap-3">
                                <button type="button" class="btn btn-link p-0 text-xs text-slate-500 hover:text-rose-600 font-medium text-decoration-none shadow-none border-0 d-inline-flex align-items-center gap-1"
                                        onclick="removeCartItem('${item.id}')">
                                    <i class="bi bi-trash3 text-xs"></i>
                                    <span>Remove</span>
                                </button>
                            </div>
                        </div>
                    </div>`;
                    })

                    $('#cartItemsList').html(records);
                    mainPriceBox();
                })
                .catch((err) => {
                    console.error('Error fetching cart:', err);
                })
        }

        function mainPriceBox() {
            axios.get('/cart/price-count')
                .then((res) => {
                    let data = res.data;
                    if (!data || !data.success) return;

                    let totalCount = parseInt(data.total_count ?? data.totalQuantity ?? 0) || 0;
                    let totalPrice = parseFloat(data.total_price ?? data.totalPrice ?? 0) || 0;
                    let totalDiscount = parseFloat(data.total_discount ?? data.totalDiscount ?? 0) || 0;

                    $('#sumQuantity').text(totalCount);
                    $('#cartCountHeader').text(totalCount);
                    $('#summaryCount').text(totalCount);
                    $('#sumTotalMrp').text(totalPrice.toLocaleString('en-IN'));
                    $('#sumFinalAmount').text((totalPrice + data.delivery_charges).toLocaleString('en-IN'));
                    $('#deliveryCharges').text(data.delivery_charges.toLocaleString('en-IN'));


                    if (document.getElementById('navCartBadge')) {
                        document.getElementById('navCartBadge').textContent = totalCount;
                    }
                })
                .catch((err) => {
                    console.error('Error loading price count:', err);
                });
        }

        // Update item quantity in UI
        function updateItemQty(key, delta, price) {

            const qtyEl = document.getElementById('qty_' + key);
            if (!qtyEl) return;

            let currentQty = parseInt(qtyEl.textContent) || 1;
            let newQty = currentQty + delta;
            if (newQty < 1) return;

            qtyEl.textContent = newQty;

            axios.put(`/cart/update/${key}`, {
                    quantity: newQty
                })
                .then((res) => {
                    if (res.data.success) {

                        $('#price_' + key).text(res.data.new_price);

                        $('.stock_' + key).html(`
                            <span class="text-success-700 text-[11px] font-semibold d-inline-flex align-items-center gap-1 stock_${key}">
                                <i class="bi bi-check-circle-fill text-[10px]"></i> In Stock
                            </span>`);

                        window.showToast('Item Quantity Updated Successfully', 'success');

                        mainPriceBox();
                    } else {
                        $('.stock_' + key).html(`
                            <div class="d-flex flex-column align-items-start gap-1">

                                <span class="text-red-700 text-[11px] font-semibold d-inline-flex align-items-center gap-1 stock_${key}">
                                    <i class="bi bi-x-circle-fill text-[10px]"></i>
                                    Out of Stock
                                </span>

                                <p class="text-red-700 text-[11px] font-semibold d-inline-flex align-items-center gap-1 bg-gray-100 p-2 rounded stock_${key} mb-0">
                                    ${res.data.stock}
                                    <span class="text-slate-700">Quantity Available</span>
                                </p>

                            </div>
                        `);
                        window.showToast('Quantity is Out of Stock', 'error');
                    }
                })
                .catch((err) => {
                    console.log(err);
                    qtyEl.textContent = currentQty;
                });
        }

        // Remove item from UI with smooth fade out
        function removeCartItem(key) {

            const itemCard = document.getElementById('cartItem_' + key);
            console.log(key);
            if (!itemCard) return;

            itemCard.style.transition = 'all 0.2s ease';
            itemCard.style.opacity = '0';
            itemCard.style.transform = 'scale(0.96)';

            axios.delete(`/cart/delete/${key}`)
                .then((res) => {
                    if (res.data.success) {
                        setTimeout(() => {
                            itemCard.remove();

                            // Check if cart is now empty
                            const remaining = document.querySelectorAll('.cart-item-card');
                            if (remaining.length === 0) {
                                document.getElementById('emptyCartView').style.display = 'block';
                                document.getElementById('cartItemsList').style.display = 'none';
                                document.getElementById('cartCountHeader').textContent = '0';
                                document.getElementById('summaryCount').textContent = '0';
                            }

                            mainPriceBox();

                        }, 200);
                        window.showToast('Item Removed Successfully', 'success');
                    } else {
                        window.showToast('Item Not Found!', 'error');
                    }
                })
                .catch((err) => {
                    console.log(err);
                });

        }

        function confirmDeleteOption() {
            axios.delete(`/cart/delete-all`)
                .then((res) => {
                    if (res.data.success) {
                        setTimeout(() => {
                            document.querySelectorAll('.cart-item-card').forEach(c => c.remove());
                            document.getElementById('emptyCartView').style.display = 'block';
                            document.getElementById('cartItemsList').style.display = 'none';
                            document.getElementById('cartCountHeader').textContent = '0';
                            document.getElementById('summaryCount').textContent = '0';

                            mainPriceBox();

                        }, 200);
                        window.showToast('Bag Cleared Successfully', 'success');
                    } else {
                        window.showToast('Item Not Found!', 'error');
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        };

        // Coupon Apply simulation
        function applyCoupon() {
            const code = (document.getElementById('couponInput').value || '').trim().toUpperCase();
            const badge = document.getElementById('couponAppliedBadge');
            if (!code) {
                alert('Please enter a coupon code.');
                return;
            }

            if (code === 'VASTRA500' || code === 'FIRST500') {
                appliedCouponDiscount = 500;
                badge.style.display = 'flex';
                badge.innerHTML =
                    `<span class="d-inline-flex align-items-center gap-1 font-semibold text-[11px]"><i class="bi bi-check-circle-fill text-emerald-600"></i> Code <strong>${code}</strong> Applied!</span><span class="text-[11px] font-bold text-emerald-700">-₹500</span>`;
                document.getElementById('sumCouponDiscount').textContent = '500';
                mainPriceBox();
                alert(`Coupon "${code}" applied successfully! You got ₹500 discount.`);
            } else {
                alert(`Coupon "${code}" is invalid or expired. Try VASTRA500.`);
            }
        }

        function checkoutStock(cart_item_id) {
            axios.get(`/cart/checkout/stock/${cart_item_id}`)
                .then((res) => {

                })
                .catch((err) => {

                })
        }
    </script>
@endsection
