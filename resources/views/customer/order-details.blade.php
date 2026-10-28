@extends('main')

@section('title', 'Order Details - Vastrkaya')

@php
    $show_navbar = true;
    $show_footer = true;
@endphp

@section('hero-section')
    <div class="bg-[#f5f5f6] min-h-screen py-5 sm:py-7 text-slate-800 font-sans"
        style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
        <div class="container-fluid px-3 px-lg-4 max-w-5xl mx-auto">

            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb text-xs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-slate-500 hover:text-slate-900 text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/cart') }}" class="text-slate-500 hover:text-slate-900 text-decoration-none">Shopping Bag</a></li>
                    <li class="breadcrumb-item active text-slate-900 font-semibold" aria-current="page">Order Details</li>
                </ol>
            </nav>

            <div class="row g-4 justify-content-center">

                <div class="col-lg-8 col-xl-8">

                        <!-- 3. ALL ORDERED PRODUCTS LIST -->
                        @if((isset($products) && $products->isNotEmpty()) || $items->isNotEmpty())
                            <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-2xs">
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-b border-slate-100">
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-0 font-sans">
                                        Ordered Items ({{ isset($products) && $products->isNotEmpty() ? $products->count() : $items->count() }})
                                    </h4>
                                    @if ($order->order_status)
                                        <span class="badge {{($order->order_status == 'pending')? 'bg-warning' : (($order->order_status == 'delivered')? 'bg-success' : 'bg-danger')}} border border-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                            {{ $order->order_status }}
                                        </span>
                                    @endif
                                </div>
                                <div class="space-y-3">
                                    @foreach($products as $p)
                                        <div class="d-flex align-items-center justify-content-between gap-3 p-3 rounded-2xl bg-white border border-slate-200/90 hover:border-slate-300 hover:shadow-xs transition-all duration-200">
                                            <!-- Product Thumbnail & Details -->
                                            <div class="d-flex align-items-center gap-3 min-w-0 flex-grow-1">
                                                <!-- Image with subtle quantity chip -->
                                                <div class="position-relative flex-shrink-0">
                                                    <img src="{{ asset('storage/'.$p->image) }}"
                                                        alt="{{ $p->name ?? 'Product' }}"
                                                        class="w-16 h-20 sm:w-18 sm:h-22 object-cover rounded-xl bg-slate-50 border border-slate-100 shadow-2xs" />
                                                </div>

                                                <!-- Text Info -->
                                                <div class="min-w-0 flex-grow-1">
                                                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-[#ff3f6c] d-block mb-1">
                                                        {{ $p->brand ?? 'Vastrkaya' }}
                                                    </span>
                                                    <h5 class="text-xs sm:text-sm font-bold text-slate-800 truncate mb-1.5" title="{{ $p->name ?? 'Product' }}">
                                                        {{ $p->name ?? 'Ethnic Product' }}
                                                    </h5>
                                                    <div class="d-flex flex-wrap align-items-center gap-2 text-xs">
                                                        <span class="text-slate-300"></span>
                                                        <span class="text-[11px] text-slate-500 font-medium">
                                                            &#8377;{{ number_format($p->orderItems->first()->unit_price) }} each
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Price Summary Block (Far Right) -->
                                            <div class="text-end flex-shrink-0 ps-2">
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider d-block mb-0.5">
                                                    Total Qty 
                                                </span>
                                                <span class="text-sm sm:text-base font-extrabold text-slate-900 d-block">
                                                   {{ number_format($p->orderitems->first()->quantity) }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                       
                            {{-- Savings Highlight Strip --}}
                            @if($setting->minimum_order_amount <= $payment->total_amount)
                                <div class="p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-200/80 d-flex align-items-center gap-2 text-xs text-emerald-900">

                                    <div class="w-5 h-5 rounded-full bg-emerald-600 text-white d-flex align-items-center justify-content-center text-[10px] flex-shrink-0">
                                        <i class="bi bi-stars"></i>
                                    </div>

                                    <span class="font-medium text-[11px] sm:text-xs">
                                        You're saving
                                        <strong class="text-emerald-700">
                                            &#8377;{{ $setting->delivery_charge }}
                                        </strong>
                                        on this Order.
                                    </span>

                                </div>
                            @endif


                        <!-- 5. DELIVERY TO CARD -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-2xs">
                            <!-- Recipient Header with Avatar -->
                            <div class="d-flex align-items-center gap-2.5 mb-3">
                                <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-800 d-flex align-items-center justify-content-center text-sm font-bold flex-shrink-0">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <span class="text-[11px] text-slate-400 font-medium d-block">Delivery To</span>
                                    <span class="text-xs sm:text-sm font-bold text-slate-900">{{ $selectedAddress->name }}</span>
                                </div>
                            </div>

                            <hr class="my-2.5 border-slate-100">

                            <!-- Contact Details -->
                            <div class="d-flex align-items-center gap-2.5 mb-3 text-xs">
                                <i class="bi bi-telephone text-slate-400"></i>
                                <div>       
                                    <span class="text-slate-400 text-[11px] d-block">Contact Details</span>
                                    <strong class="text-slate-800">{{ $selectedAddress->contact_number }}</strong>
                                </div>
                            </div>

                            <!-- Delivery Address & Map Preview -->
                            <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                                <div class="d-flex align-items-start gap-2.5 text-xs">
                                    <i class="bi bi-geo-alt text-slate-400 mt-0.5"></i>
                                    <div>
                                        <span class="text-slate-400 text-[11px] d-block">Delivery Address</span>
                                        <span class="text-slate-700 leading-relaxed">{{ $selectedAddress->address_type_line_1 . ', ' . $selectedAddress->address_type_line_2 . ', ' . $selectedAddress->city . ', ' . $selectedAddress->state . ' - ' . $selectedAddress->pincode }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Change Details Button -->
                            @if ($order->order_status !== 'cancelled')
                                <a href="/order/{{ $order->id }}/cancel" class="btn btn-outline-secondary w-100 py-2 rounded-xl text-xs font-bold text-slate-700 border-slate-300 hover:bg-slate-50 d-flex align-items-center justify-content-center gap-1.5 shadow-none text-decoration-none">
                                    <i class="bi bi-pencil text-slate-500"></i>
                                    <span>Cancel Order</span>
                                </a>
                            @endif
                        </div>

                        <!-- 6. PAYMENT STATUS CARD -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-2xs">
                            <span class="text-xs font-bold text-slate-900 d-block mb-1.5">Payment Status</span>
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 text-xs">
                                <div class="d-flex align-items-center gap-2 font-semibold text-slate-800">
                                    <i class="bi bi-check-circle-fill text-emerald-600 text-sm"></i>
                                    <span>{{ $payment->payment_method === 'online' ? 'Online Payment' : 'Cash on delivery' }}</span>
                                </div>
                                <span class="badge bg-emerald-500 text-emerald-100 font-bold px-2.5 py-1 rounded-full text-[10px]">&#8377;  {{  number_format($order->total_amount, 2) }}
                                </span>
                            </div>
                        </div>

                        <!-- 7. UPDATES SENT TO CARD -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-2xs">
                            <div class="d-flex align-items-start gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 d-flex align-items-center justify-content-center text-xs flex-shrink-0 mt-0.5">
                                    <i class="bi bi-chat-left-text"></i>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-slate-900 d-block mb-1">Updates sent to</span>
                                    <div class="text-[11px] text-slate-500">
                                        Call &bull; <strong class="text-slate-800">{{ $selectedAddress->contact_number }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 8. ORDER DETAILS CARD -->
                        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-2xs">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 d-flex align-items-center justify-content-center text-xs flex-shrink-0">
                                    <i class="bi bi-receipt"></i>
                                </div>
                                <span class="text-xs font-bold text-slate-900">Order details</span>
                            </div>

                            <div class="row g-2 text-xs">
                                <div class="col-6 col-sm-4">
                                    <span class="text-[11px] text-slate-400 d-block">Ordered On</span>
                                    <span class="font-medium text-slate-800">{{ $order->created_at->format('d F Y') }}, {{ $order->created_at->format('h:i A') }}</span>
                                </div>
                                <div class="col-6 col-sm-8">
                                    <span class="text-[11px] text-slate-400 d-block">Order ID</span>
                                    <span class="font-mono text-slate-800 text-[11px] break-all">{{ $order->order_number }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Return to Shopping CTA -->
                        <div class="text-center pt-2 pb-4">
                            <a href="{{ url('/') }}" class="btn btn-dark py-2.5 px-4 rounded-xl text-xs font-bold uppercase tracking-wider text-decoration-none shadow-sm">
                                <i class="bi bi-bag me-1.5"></i> Continue Shopping
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
