@extends('main')

@section('title', 'Payment - Vastrkaya Checkout')

@php
    $show_navbar = true;
    $show_footer = true;
@endphp

@section('hero-section')
    <div class="bg-[#f8f9fa] min-h-screen py-5 sm:py-7 text-slate-800 font-sans"
        style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
        <div class="container-fluid px-3 px-lg-4 max-w-5xl mx-auto">

            <!-- Top Checkout Progress Stepper Navigation -->
            <div
                class="d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 mb-4 pb-3 border-b border-slate-200">
                <!-- Breadcrumbs -->
                <ol class="breadcrumb mb-0 text-xs align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('cart.index') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Shopping Bag</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('contact.index') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Delivery Address</a>
                    </li>
                    <li class="breadcrumb-item active text-slate-900 font-semibold" aria-current="page">Payment
                    </li>
                </ol>

                <!-- Minimal Stepper Indicator -->
                <div class="d-flex align-items-center gap-2 text-xs font-semibold tracking-wider">
                    <!-- Step 1: BAG (Completed) -->
                    <a href="{{ route('cart.index') }}"
                        class="text-emerald-700 hover:text-emerald-800 text-decoration-none d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-emerald-600 text-white d-inline-flex align-items-center justify-content-center text-[10px] font-bold">
                            <i class="bi bi-check-lg"></i>
                        </span>
                        <span>BAG</span>
                    </a>
                    <span class="w-8 h-[1px] bg-emerald-300"></span>

                    <!-- Step 2: ADDRESS (Completed) -->
                    <a href="{{ route('contact.index') }}"
                        class="text-emerald-700 hover:text-emerald-800 text-decoration-none d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-emerald-600 text-white d-inline-flex align-items-center justify-content-center text-[10px] font-bold">
                            <i class="bi bi-check-lg"></i>
                        </span>
                        <span>ADDRESS</span>
                    </a>
                    <span class="w-8 h-[1px] bg-emerald-300"></span>

                    <!-- Step 3: PAYMENT (Active) -->
                    <span class="text-slate-900 d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-slate-900 text-white d-inline-flex align-items-center justify-content-center text-[10px] font-bold">
                            3
                        </span>
                        <span class="font-bold">PAYMENT</span>
                    </span>
                </div>
            </div>

            <!-- Delivery Address Quick Summary Bar -->
            <div
                class="bg-white border border-slate-200 rounded-xl p-3.5 sm:p-4 mb-4 shadow-2xs d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                <div class="d-flex align-items-start gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 d-flex align-items-center justify-content-center flex-shrink-0 mt-0.5">
                        <i class="bi bi-geo-alt-fill text-sm"></i>
                    </div>
                    <div class="text-xs">
                        <div class="d-flex align-items-center gap-2 mb-0.5 flex-wrap">
                            <span class="text-slate-500 font-medium">Deliver to:</span>
                            <span class="font-bold text-slate-900">
                                {{ $selectedAddress->name ?? (Auth::check() ? Auth::user()->name : 'Customer') }}
                            </span>
                        </div>
                        <div class="text-slate-600 text-[12px] leading-relaxed line-clamp-1">
                            @if ($selectedAddress)
                                {{ $selectedAddress->address_type_line_1 }},
                                @if (!empty($selectedAddress->address_type_line_2))
                                    {{ $selectedAddress->address_type_line_2 }},
                                @endif
                                {{ $selectedAddress->city }}, {{ $selectedAddress->state }} &bull; Mobile: <strong
                                    class="text-slate-800">{{ $selectedAddress->contact_number }}</strong>
                            @endif
                        </div>
                    </div>
                </div>

                <a href="{{ route('contact.index') }}"
                    class="btn btn-sm text-[11px] font-bold uppercase tracking-wider px-3 py-1.5 rounded transition shadow-none flex-shrink-0"
                    style="border: 1px solid #ff3f6c; color: #ff3f6c; text-decoration: none;">
                    Change Address
                </a>
            </div>

            <div class="row g-4">

                <!-- LEFT COLUMN: Payment Modes Selection UI -->
                <div class="col-lg-7 col-xl-7">
                    <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-2xs">

                        <!-- Header -->
                        <div
                            class="d-flex align-items-center justify-content-between mb-4 pb-2.5 border-b border-slate-100">
                            <div>
                                <h2 class="text-sm sm:text-base font-bold text-slate-900 uppercase tracking-wider mb-2"
                                    style="color: #282c3f;">
                                    Choose Payment Mode
                                </h2>
                                <p class="text-xs text-slate-500 mb-0 mt-0.5">
                                    Select your preferred payment method to complete the order
                                </p>
                            </div>
                        </div>

                        <!-- Main Payment Options (Cash on Delivery & Online Payment) -->
                        <form action="{{ route('checkout.payment.store') }}" method="post">
                            @csrf
                            <div class="space-y-3.5 mb-4">
                                <input type="hidden" name="total_price" value="{{ $priceCount['payable_price'] }}">
                                <input type="hidden" name="order_number" value="" id="order_number">
                                <div class="payment-method-card border rounded-xl p-3.5 sm:p-4 transition cursor-pointer relative"
                                    id="codCardWrapper" onclick="selectPaymentMethod('cod')"
                                    style="border: 2px solid #ff3f6c; background-color: #fffafb;">

                                    <div class="d-flex align-items-start justify-content-between gap-3">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="pt-0.5">
                                                <input type="radio" name="payment_method" id="payment_mode_cod"
                                                    value="cod" checked class="form-check-input custom-pink-radio mt-0"
                                                    style="accent-color: #ff3f6c; width: 18px; height: 18px; cursor: pointer;">
                                            </div>
                                            <div>
                                                <label for="payment_mode_cod"
                                                    class="font-bold text-sm text-slate-900 mb-0.5 cursor-pointer d-flex align-items-center gap-2">
                                                    <span>Cash On Delivery </span>
                                                </label>
                                                <p class="text-xs text-slate-500 mb-0 mt-0.5 leading-relaxed">
                                                    Pay by cash or scan delivery agent's UPI QR code upon arrival at your
                                                    doorstep.
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="w-9 h-9 rounded-lg bg-rose-50 text-[#ff3f6c] d-flex align-items-center justify-content-center flex-shrink-0 text-base">
                                            <i class="bi bi-cash-stack"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- OPTION 2: ONLINE PAYMENT -->
                                <div class="payment-method-card border rounded-xl p-3.5 sm:p-4 transition cursor-pointer relative"
                                    id="onlineCardWrapper" onclick="selectPaymentMethod('online')"
                                    style="border: 1px solid #e2e8f0; background-color: #ffffff;">

                                    <div class="d-flex align-items-start justify-content-between gap-3">
                                        <div class="d-flex align-items-start gap-3">
                                            <div class="pt-0.5">
                                                <input type="radio" name="payment_method" id="payment_mode_online"
                                                    value="online" class="form-check-input custom-pink-radio mt-0"
                                                    style="accent-color: #ff3f6c; width: 18px; height: 18px; cursor: pointer;">
                                            </div>
                                            <div>
                                                <label for="payment_mode_online"
                                                    class="font-bold text-sm text-slate-900 mb-0.5 cursor-pointer d-flex align-items-center gap-2">
                                                    <span>Online Payment</span>
                                                </label>
                                                <p class="text-xs text-slate-500 mb-0 mt-0.5 leading-relaxed">
                                                    UPI , Credit / Debit Card
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="w-9 h-9 rounded-lg bg-indigo-50 text-indigo-600 d-flex align-items-center justify-content-center flex-shrink-0 text-base">
                                            <i class="bi bi-credit-card-2-front"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Payment Action Button -->
                            <div class="pt-1 mb-3" id="paymentBtnContainer">
                                <button type="submit" id="paymentActionButton"
                                    class="btn w-100 py-3 rounded-md text-xs sm:text-sm font-bold uppercase tracking-wider text-white shadow-sm transition border-0 d-flex align-items-center justify-content-center gap-2"
                                    style="background-color: #ff3f6c; letter-spacing: 0.5px;">
                                    <i class="bi bi-bag-check-fill" id="paymentBtnIcon"></i>
                                    <span id="paymentBtnText">Place Order Via Cash On Delivery</span>
                                </button>
                            </div>

                        </form>

                        <!-- Safety & Trust Highlights -->
                        <div class="pt-3 border-t border-slate-100 mt-4 text-center">
                            <span class="text-[11px] text-slate-400 d-inline-flex align-items-center gap-1.5">
                                <i class="bi bi-shield-check text-emerald-600 text-sm"></i>
                                Safe &amp; Secure Payments &bull; 100% Buyer Protection &bull; Instant Refund Guarantee
                            </span>
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN: Price Details & Order Items Summary Box -->
                <div class="col-lg-5 col-xl-5">
                    <div class="sticky-top" style="top: 85px;">

                        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-2xs">
                            <h4
                                class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 pb-2 border-b border-slate-100 font-sans">
                                PRICE DETAILS ({{ $priceCount['total_count'] ?? 0 }}
                                {{ ($priceCount['total_count'] ?? 0) === 1 ? 'ITEM' : 'ITEMS' }})
                            </h4>

                            <div class="space-y-2.5 text-xs font-sans">
                                <div class="d-flex justify-content-between text-slate-600">
                                    <span>Total MRP</span>
                                    <span
                                        class="font-medium text-slate-900">&#8377;{{ number_format($priceCount['total_price'] ?? 0) }}</span>
                                </div>

                                <div class="d-flex justify-content-between text-slate-600">
                                    <span>Delivery Charges</span>
                                    <div class="text-end">
                                        @if (($priceCount['delivery_charges'] ?? 0) == 0)
                                            <span class="text-emerald-600 font-bold uppercase text-[10px]">FREE</span>
                                        @else
                                            <span
                                                class="font-medium text-slate-900">&#8377;{{ number_format($priceCount['delivery_charges']) }}</span>
                                        @endif
                                    </div>
                                </div>

                                <hr class="my-2.5 border-slate-200">

                                <div class="d-flex justify-content-between text-sm font-bold text-slate-900">
                                    <span>Total Amount</span>
                                    <span class="text-lg font-extrabold text-slate-900" id="totalAmountText">
                                        &#8377;{{ number_format(($priceCount['total_price'] ?? 0) + ($priceCount['delivery_charges'] ?? 0)) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Selected Payment Method Indicator Box -->
                            <div
                                class="mt-3.5 p-2.5 rounded-lg bg-rose-50 border border-rose-200 text-xs text-slate-800 d-flex align-items-center justify-content-between">
                                <span class="d-flex align-items-center gap-1.5 font-medium">
                                    <i class="bi bi-check2-circle text-[#ff3f6c] font-bold"></i>
                                    <span>Paying via:</span>
                                </span>
                                <span class="font-bold text-[#ff3f6c]" id="summarySelectedMethodBadge">
                                    Cash On Delivery
                                </span>
                            </div>

                            <!-- Cart Items Preview Collapse (Optional accordion) -->
                            @if (isset($cart) && $cart->cartItems && $cart->cartItems->count() > 0)
                                <div class="mt-3 pt-3 border-t border-slate-100">
                                    <div
                                        class="d-flex align-items-center justify-content-between text-xs text-slate-700 cursor-pointer">
                                        <span class="font-bold d-flex align-items-center gap-1.5">
                                            <i class="bi bi-bag text-slate-500"></i> View Items in this Order
                                            ({{ $cart->cartItems->count() }})
                                        </span>
                                        <i class="bi bi-chevron-down text-slate-400 text-[10px]"></i>
                                    </div>
                                    <div class="" id="orderItemsCollapse">
                                        <div class="space-y-2 max-h-48 overflow-y-auto pe-1">
                                            @foreach ($cart->cartItems as $cItem)
                                                <div
                                                    class="d-flex align-items-center gap-2 p-1.5 rounded-lg bg-slate-50 border border-slate-100 text-xs">
                                                    @if (isset($cItem->product->image))
                                                        <img src="/storage/{{ $cItem->product->image }}"
                                                            alt="{{ $cItem->product->name }}"
                                                            class="w-9 h-11 object-cover rounded bg-white border border-slate-200">
                                                    @endif
                                                    <div class="flex-grow-1 min-w-0">
                                                        <div class="font-semibold text-slate-900 truncate">
                                                            {{ $cItem->product->name ?? 'Ethnic Product' }}</div>
                                                        <div class="text-[11px] text-slate-500">Qty:
                                                            {{ $cItem->quantity }} &bull;
                                                            &#8377;{{ number_format($cItem->new_price ?? ($cItem->product->price ?? 0)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-3 text-center">
                                <span class="text-[10px] text-slate-400">
                                    <i class="bi bi-lock-fill me-1"></i> Safe &amp; Secure 256-Bit SSL Checkout
                                </span>
                            </div>
                        </div>

                        <!-- Trust Strip -->
                        <div
                            class="bg-white border border-slate-200 rounded-xl p-3 mt-3 text-xs text-slate-600 space-y-2 shadow-2xs">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-truck text-emerald-600 text-sm"></i>
                                <span>Express Dispatch in 24-48 Business Hours</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-arrow-repeat text-indigo-600 text-sm"></i>
                                <span>7 Days Hassle-free Exchange &amp; Returns</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-patch-check text-amber-600 text-sm"></i>
                                <span>100% Genuine Handcrafted Ethnic Wear</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Scoped Styles -->
    <style>
        .custom-pink-radio:checked {
            background-color: #ff3f6c !important;
            border-color: #ff3f6c !important;
        }

        .online-subtab.active {
            background-color: #ffffff !important;
            color: #0f172a !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08) !important;
        }

        .upi-app-pill.active,
        .bank-pill.active,
        .wallet-row.active {
            border-color: #ff3f6c !important;
            background-color: #fffafb !important;
        }
    </style>

    <!-- Client-Side UI Interactive Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#order_number').val(Math.random().toString(36).substring(2, 10).toUpperCase());
        })

        let currentSelectedMethod = 'cod';
        const totalAmountText =
            '{{ number_format(($priceCount['total_price'] ?? 0) + ($priceCount['delivery_charges'] ?? 0)) }}';

        // Switch between COD and Online Payment
        function selectPaymentMethod(mode) {
            currentSelectedMethod = mode;

            const codCard = document.getElementById('codCardWrapper');
            const onlineCard = document.getElementById('onlineCardWrapper');
            const codRadio = document.getElementById('payment_mode_cod');
            const onlineRadio = document.getElementById('payment_mode_online');
            const summaryBadge = document.getElementById('summarySelectedMethodBadge');
            const btnText = document.getElementById('paymentBtnText');
            const btnIcon = document.getElementById('paymentBtnIcon');

            if (mode === 'cod') {
                codRadio.checked = true;
                codCard.style.border = '2px solid #ff3f6c';
                codCard.style.backgroundColor = '#fffafb';

                onlineRadio.checked = false;
                onlineCard.style.border = '1px solid #e2e8f0';
                onlineCard.style.backgroundColor = '#ffffff';

                if (summaryBadge) summaryBadge.textContent = 'Cash On Delivery';
                if (btnText) btnText.textContent = 'Place Order Via Cash On Delivery';
                if (btnIcon) btnIcon.className = 'bi bi-bag-check-fill';
            } else {
                onlineRadio.checked = true;
                onlineCard.style.border = '2px solid #ff3f6c';
                onlineCard.style.backgroundColor = '#fffafb';

                codRadio.checked = false;
                codCard.style.border = '1px solid #e2e8f0';
                codCard.style.backgroundColor = '#ffffff';

                if (summaryBadge) summaryBadge.textContent = 'Online Payment';
                if (btnText) btnText.textContent = `Pay ₹${totalAmountText} Via Online Payment`;
                if (btnIcon) btnIcon.className = 'bi bi-shield-lock-fill';
            }
        }
    </script>
@endsection
