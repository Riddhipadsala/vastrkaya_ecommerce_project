@extends('main')

@section('title', 'My Orders - Vastrkaya')

@php
    $show_navbar = true;
    $show_footer = true;
@endphp

@section('hero-section')
    <div class="bg-[#f5f5f6] min-h-screen py-5 sm:py-7 text-slate-800 font-sans"
        style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
        <div class="container-fluid px-3 px-lg-5 max-w-6xl mx-auto">

            <!-- Breadcrumbs Navigation -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb text-xs mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                            class="text-slate-500 hover:text-slate-900 text-decoration-none">Shopping</a></li>
                    <li class="breadcrumb-item active text-slate-900 font-semibold" aria-current="page">My Orders</li>
                </ol>
            </nav>

            <div class="row g-4">

                <!-- ==========================================
                         LEFT SIDEBAR (Account Menu)
                         ========================================== -->
                <div class="col-lg-3 col-xl-3 d-none d-lg-block">
                    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-2xs sticky-top"
                        style="top: 90px;">

                        <!-- Account Header -->
                        <div class="pb-3 border-b border-slate-100">
                            <h2 class="text-sm font-bold text-slate-900 mb-0.5">Account</h2>
                            <p class="text-xs text-slate-500 mb-0 truncate">{{ auth()->user()->name ?? 'Myntra User' }}</p>
                        </div>

                        <!-- Section: Overview -->
                        <div class="py-2.5 border-b border-slate-100">
                            <a href="{{ route('dashboard') }}"
                                class="text-xs font-semibold text-slate-700 hover:text-[#ff3f6c] text-decoration-none d-block py-1">
                                Home
                            </a>
                        </div>

                        <!-- Section: ORDERS -->
                        <div class="py-2.5 border-b border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider d-block mb-1.5">
                                ORDERS
                            </span>
                            <a href="{{ route('orders') }}"
                                class="text-xs font-bold text-[#14cda8] text-decoration-none d-flex align-items-center justify-content-between py-1">
                                <span>Orders &amp; Returns</span>
                                <i class="bi bi-chevron-right text-[10px]"></i>
                            </a>
                        </div>

                        <!-- Section: CREDITS -->
                        <div class="py-2.5 border-b border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider d-block mb-1.5">
                                CREDITS
                            </span>
                            <div class="space-y-1">
                                <a href="/cart"
                                    class="text-xs text-slate-600 hover:text-[#ff3f6c] text-decoration-none d-block py-1">
                                    Coupons
                                </a>
                            </div>
                        </div>

                        <!-- Section: ACCOUNT -->
                        <div class="pt-2.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider d-block mb-1.5">
                                ACCOUNT
                            </span>
                            <div class="space-y-1">
                                <a href="javascript:void(0)"
                                    class="text-xs text-slate-600 hover:text-[#ff3f6c] text-decoration-none d-block py-1">
                                    Profile
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-9 col-xl-9">

                    <div class="space-y-3.5">
                        @foreach ($orders as $order)
                            <div
                                class="bg-white rounded-2xl border border-slate-200/90 shadow-2xs overflow-hidden hover:border-slate-300 transition-all duration-200">

                                <!-- Header Status -->
                                <div class="p-3 sm:p-3.5 pb-2.5 d-flex align-items-center gap-2.5">

                                    <div>
                                        <h4
                                            class="text-xs sm:text-sm font-extrabold {{ $order->order_status == 'cancelled' ? 'text-rose-600' : 'text-green-600' }} mb-0 leading-tight">
                                            {{ $order->order_status }}
                                        </h4>
                                        <span class="text-xs text-slate-500 font-medium">
                                            {{ $order->updated_at->format('d M, Y, h:i A') }}
                                        </span>
                                        <p class="text-xs sm:text-sm font-semibold text-slate-900 mt-1 mb-0">
                                            Total Amount : {{ Round($order->total_amount) }}
                                        </p>
                                    </div>
                                </div>

                                @foreach ($order->orderItems as $oi)
                                    <a href="{{ route('order.details') }}"
                                        class="d-flex align-items-center justify-content-between p-3 sm:p-3.5 border-t border-slate-100 text-decoration-none text-slate-800 hover:bg-slate-50/50 transition">
                                        <div class="d-flex align-items-center gap-3 min-w-0">
                                            <img src="{{ asset('storage/' . $oi->product->image) }}"
                                                alt="Sparx Running Shoes"
                                                class="w-14 h-18 sm:w-16 sm:h-20 object-cover rounded-xl bg-slate-50 border border-slate-200/80 flex-shrink-0">
                                            <div class="min-w-0">
                                                <span class="text-xs font-extrabold text-slate-900 d-block mb-0.5">
                                                    {{ $oi->product->brand }}
                                                </span>
                                                <h5 class="text-xs text-slate-600 truncate mb-1 font-normal">
                                                    {{ $oi->product->name }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="ps-2 flex-shrink-0">
                                            <i class="bi bi-chevron-right text-slate-400 text-sm">Per Product Price :
                                                {{ $oi->unit_price }}</i>
                                        </div>
                                    </a>
                                @endforeach

                                @if ($order->order_status != 'cancelled' && $order->order_status != 'delivered')
                                    <div class="px-3 sm:px-3.5 pb-3.5 pt-1">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <a href="{{ route('order.cancel', $order->id) }}"
                                                    class="btn btn-outline-secondary w-100 py-1.5 rounded-lg text-xs font-semibold text-slate-700 border-slate-300 hover:bg-slate-50 d-flex align-items-center justify-content-center gap-1 shadow-none">
                                                    <i class="bi bi-x-circle text-slate-500"></i>
                                                    <span>Cancel Order</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endforeach

                    </div>

                </div>

            </div>

        </div>
    </div>
@endsection
