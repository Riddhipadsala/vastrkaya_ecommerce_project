@extends('main')

@section('title', 'Delivery Address - Vastrkaya')

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
                    <li class="breadcrumb-item active text-slate-900 font-semibold" aria-current="page">Delivery Address
                    </li>
                </ol>

                <!-- Minimal Stepper Indicator -->
                <div class="d-flex align-items-center gap-2 text-xs font-semibold tracking-wider">
                    <a href="{{ route('cart.index') }}"
                        class="text-emerald-700 hover:text-emerald-800 text-decoration-none d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-emerald-600 text-white d-inline-flex align-items-center justify-content-center text-[10px] font-bold">
                            <i class="bi bi-check-lg"></i>
                        </span>
                        <span>BAG</span>
                    </a>
                    <span class="w-8 h-[1px] bg-emerald-300"></span>
                    <span class="text-slate-900 d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-slate-900 text-white d-inline-flex align-items-center justify-content-center text-[10px] font-bold">
                            2
                        </span>
                        <span class="font-bold">ADDRESS</span>
                    </span>
                    <span class="w-8 h-[1px] bg-slate-300"></span>
                    <a href="{{ route('admin.checkout.payment') }}" class="text-slate-400 hover:text-slate-600 text-decoration-none d-inline-flex align-items-center gap-1.5">
                        <span
                            class="w-5 h-5 rounded-circle bg-slate-200 text-slate-500 d-inline-flex align-items-center justify-content-center text-[10px]">
                            3
                        </span>
                        <span>PAYMENT</span>
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div
                    class="alert alert-success border-0 bg-emerald-50 text-emerald-800 rounded-xl p-3 text-xs mb-3 d-flex align-items-center justify-content-between shadow-2xs">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close text-[10px] shadow-none" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 bg-rose-50 text-rose-800 rounded-xl p-3 text-xs mb-3 shadow-2xs">
                    <div class="d-flex align-items-center gap-2 mb-1 font-bold">
                        <i class="bi bi-exclamation-triangle-fill text-rose-600"></i>
                        <span>Please fix the following errors:</span>
                    </div>
                    <ul class="mb-0 ps-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">

                <!-- LEFT COLUMN: Select Delivery Address OR Add/Edit Address Form (Managed via Laravel) -->
                <div class="col-lg-7 col-xl-7">
                    @if (!empty($showForm))
                       <div class="bg-white border border-slate-200 rounded-xl p-4 sm:p-5 shadow-2xs">
                            <div
                                class="d-flex align-items-center justify-content-between mb-3 pb-2 border-b border-slate-100">
                                <h5 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-0 font-sans">
                                    {{ isset($editAddress) ? 'Edit Delivery Address' : 'Add Delivery Address' }}
                                </h5>
                                @if (isset($cartContactInformation) && $cartContactInformation->isNotEmpty())
                                    <a href="{{ route('admin.contact.index') }}"
                                        class="btn btn-sm btn-link text-slate-500 hover:text-slate-900 text-decoration-none p-0 text-xs">
                                        <i class="bi bi-x-lg me-1"></i> Back to Addresses
                                    </a>
                                @endif
                            </div>

                            <form
                                action="{{ isset($editAddress) ? route('admin.contact.update', $editAddress->id) : route('admin.contact.store') }}"
                                method="POST">
                                @csrf
                                @if (isset($editAddress))
                                    @method('PUT')
                                @else
                                    <input type="hidden" name="cart_id" value="{{ $cartId }}">
                                @endif

                                <!-- SECTION 1: CONTACT DETAILS -->
                                <div class="mb-4 pb-1">
                                    <h6 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">
                                        CONTACT DETAILS
                                    </h6>

                                    <!-- Name Input (With title on top) -->
                                    <div class="mb-3.5">
                                        <label for="name"
                                            class="form-label text-xs font-bold text-slate-800 mb-1.5 d-block">
                                            Full Name <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" id="name" name="name"
                                            value="{{ old('name', $editAddress->name ?? (Auth::check() ? Auth::user()->name : '')) }}"
                                            class="form-control text-xs sm:text-sm border-slate-300 rounded-md py-2.5 px-3 shadow-none @error('name') is-invalid @enderror"
                                            placeholder="Enter full name" required>
                                        @error('name')
                                            <div class="text-[11px] text-rose-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Mobile Number Input (With title on top) -->
                                    <div class="mb-3.5">
                                        <label for="contact_number"
                                            class="form-label text-xs font-bold text-slate-800 mb-1.5 d-block">
                                            Mobile Number <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="tel" id="contact_number" name="contact_number"
                                            value="{{ old('contact_number', $editAddress->contact_number ?? '') }}"
                                            maxlength="10" pattern="[0-9]{10}"
                                            class="form-control text-xs sm:text-sm border-slate-300 rounded-md py-2.5 px-3 shadow-none @error('contact_number') is-invalid @enderror"
                                            placeholder="Enter 10-digit mobile number" required>
                                        @error('contact_number')
                                            <div class="text-[11px] text-rose-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- SECTION 2: ADDRESS -->
                                <div class="mb-4 pb-1">
                                    <h6 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">
                                        ADDRESS
                                    </h6>

                                    <!-- Pin Code (With title on top) -->
                                    <div class="mb-3.5">
                                        <label for="pincode"
                                            class="form-label text-xs font-bold text-slate-800 mb-1.5 d-block">
                                            PIN Code <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" id="pincode" name="pincode"
                                            value="{{ old('pincode', $editAddress->pincode ?? '') }}" maxlength="6"
                                            pattern="[0-9]{6}"
                                            class="form-control text-xs sm:text-sm border-slate-300 rounded-md py-2.5 px-3 shadow-none @error('pincode') is-invalid @enderror"
                                            placeholder="Enter 6-digit PIN code" required>
                                        @error('pincode')
                                            <div class="text-[11px] text-rose-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- House Number/Tower/Block (With title on top) -->
                                    <div class="mb-3">
                                        <label for="address_type_line_1"
                                            class="form-label text-xs font-bold text-slate-800 mb-1.5 d-block">
                                            House No. / Building / Tower / Block <span class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" id="address_type_line_1" name="address_type_line_1"
                                            value="{{ old('address_type_line_1', $editAddress->address_type_line_1 ?? '') }}"
                                            class="form-control text-xs sm:text-sm border-slate-300 rounded-md py-2.5 px-3 shadow-none @error('address_type_line_1') is-invalid @enderror"
                                            placeholder="e.g. Flat 402, Royal Residency" required>
                                        <div class="text-[11px] text-amber-600 mt-1 font-normal">
                                            *House Number will allow a doorstep delivery
                                        </div>
                                        @error('address_type_line_1')
                                            <div class="text-[11px] text-rose-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address (locality, building, street) (With title on top) -->
                                    <div class="mb-3.5">
                                        <label for="address_type_line_2"
                                            class="form-label text-xs font-bold text-slate-800 mb-1.5 d-block">
                                            Address (Locality / Area / Street / Landmark) <span
                                                class="text-rose-500">*</span>
                                        </label>
                                        <input type="text" id="address_type_line_2" name="address_type_line_2"
                                            value="{{ old('address_type_line_2', $editAddress->address_type_line_2 ?? '') }}"
                                            class="form-control text-xs sm:text-sm border-slate-300 rounded-md py-2.5 px-3 shadow-none @error('address_type_line_2') is-invalid @enderror"
                                            placeholder="e.g. Near City Mall, Ring Road, Satellite Area" required>
                                        @error('address_type_line_2')
                                            <div class="text-[11px] text-rose-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- City / District & State Row (With titles on top) -->
                                    <div class="row g-2.5 mb-2">
                                        <!-- City -->
                                        <div class="col-6">
                                            <label for="city"
                                                class="form-label text-xs font-bold text-slate-800 mb-1.5 d-block">
                                                City / District <span class="text-rose-500">*</span>
                                            </label>
                                            <input type="text" id="city" name="city"
                                                value="{{ old('city', $editAddress->city ?? '') }}"
                                                class="form-control text-xs sm:text-sm border-slate-300 rounded-md py-2.5 px-3 shadow-none @error('city') is-invalid @enderror"
                                                placeholder="City / District" required>
                                            @error('city')
                                                <div class="text-[11px] text-rose-500 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- State -->
                                        <div class="col-6">
                                            <label for="state"
                                                class="form-label text-xs font-bold text-slate-800 mb-1.5 d-block">
                                                State <span class="text-rose-500">*</span>
                                            </label>
                                            @php
                                                $selectedState = old('state', $editAddress->state ?? 'Gujarat');
                                                $indianStates = [
                                                    'Andhra Pradesh',
                                                    'Arunachal Pradesh',
                                                    'Assam',
                                                    'Bihar',
                                                    'Chhattisgarh',
                                                    'Goa',
                                                    'Gujarat',
                                                    'Haryana',
                                                    'Himachal Pradesh',
                                                    'Jharkhand',
                                                    'Karnataka',
                                                    'Kerala',
                                                    'Madhya Pradesh',
                                                    'Maharashtra',
                                                    'Manipur',
                                                    'Meghalaya',
                                                    'Mizoram',
                                                    'Nagaland',
                                                    'Odisha',
                                                    'Punjab',
                                                    'Rajasthan',
                                                    'Sikkim',
                                                    'Tamil Nadu',
                                                    'Telangana',
                                                    'Tripura',
                                                    'Uttar Pradesh',
                                                    'Uttarakhand',
                                                    'West Bengal',
                                                    'Delhi',
                                                ];
                                            @endphp
                                            <select id="state" name="state"
                                                class="form-select text-xs sm:text-sm border-slate-300 rounded-md py-2.5 px-3 shadow-none text-slate-700 @error('state') is-invalid @enderror"
                                                required>
                                                <option value="" disabled
                                                    {{ empty($selectedState) ? 'selected' : '' }}>Select State</option>
                                                @foreach ($indianStates as $st)
                                                    <option value="{{ $st }}"
                                                        {{ $selectedState == $st ? 'selected' : '' }}>
                                                        {{ $st }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('state')
                                                <div class="text-[11px] text-rose-500 mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- ACTION BUTTONS: Cancel & Save -->
                                <div class="pt-3 border-t border-slate-200 mt-4">
                                    <div class="row g-2.5">
                                        <div class="col-6">
                                            @if (isset($cartContactInformation) && $cartContactInformation->isNotEmpty())
                                                <a href="{{ route('admin.contact.index') }}"
                                                    class="btn btn-outline-secondary w-100 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider border-slate-300 text-slate-700 bg-white hover:bg-slate-50 transition text-center shadow-none text-decoration-none d-flex align-items-center justify-content-center">
                                                    Cancel
                                                </a>
                                            @else
                                                <a href="{{ route('cart.index') }}"
                                                    class="btn btn-outline-secondary w-100 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider border-slate-300 text-slate-700 bg-white hover:bg-slate-50 transition text-center shadow-none text-decoration-none d-flex align-items-center justify-content-center">
                                                    Cancel
                                                </a>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            <button type="submit"
                                                class="btn w-100 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider text-white shadow-sm transition border-0"
                                                style="background-color: #ff3f6c;">
                                                {{ isset($editAddress) ? 'Update' : 'Save' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    @else
                        <!-- ============================================================= -->
                        <!-- 2. SELECT DELIVERY ADDRESS VIEW (When addresses exist)        -->
                        <!-- ============================================================= -->
                        <div>
                            <!-- Header with Title & Add New Address Button -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-0 font-sans"
                                    style="color: #282c3f;">
                                    Select Delivery Address
                                </h2>
                                <a href="{{ route('admin.contact.index', ['add' => 1]) }}"
                                    class="btn text-xs font-bold uppercase tracking-wider px-3.5 py-2 rounded bg-white hover:bg-slate-50 transition shadow-none text-decoration-none"
                                    style="border: 1px solid #282c3f; color: #282c3f; font-size: 11px; letter-spacing: 0.5px;">
                                    ADD NEW ADDRESS
                                </a>
                            </div>

                            <!-- List of Saved Addresses -->
                            @foreach ($cartContactInformation as $index => $address)
                                <div class="border rounded-md p-3.5 sm:p-4 bg-white mb-3 shadow-2xs position-relative"
                                    style="border-color: #eaeaec; border-radius: 6px;">
                                    <div class="d-flex align-items-start gap-2.5">
                                        <!-- Pink Radio Button (Reference Style) -->
                                        <div class="pt-0.5">
                                            <input type="radio" name="selected_address_radio"
                                                id="addr_radio_{{ $address->id }}" value="{{ $address->id }}"
                                                {{ $index === 0 ? 'checked' : '' }}
                                                class="form-check-input mt-0 custom-pink-radio"
                                                style="accent-color: #ff3f6c; width: 17px; height: 17px; cursor: pointer;">
                                        </div>

                                        <!-- Address Details -->
                                        <div class="flex-grow-1">
                                            <!-- Name & Badge -->
                                            <div class="d-flex align-items-center gap-2 mb-1.5 flex-wrap">
                                                <label for="addr_radio_{{ $address->id }}"
                                                    class="font-bold text-sm sm:text-base text-slate-900 mb-0 cursor-pointer"
                                                    style="color: #282c3f; font-weight: 700;">
                                                    {{ $address->name }}
                                                </label>
                                            </div>

                                            <!-- Address Text -->
                                            <div class="text-xs leading-relaxed mb-2"
                                                style="color: #424553; font-size: 13px;">
                                                <div>{{ $address->address_type_line_1 }}</div>
                                                @if (!empty($address->address_type_line_2))
                                                    <div>{{ $address->address_type_line_2 }}</div>
                                                @endif
                                                <div>{{ $address->city }}, {{ $address->state }} -
                                                    {{ $address->pincode }}</div>
                                            </div>

                                            <!-- Mobile Number -->
                                            <div class="text-xs mb-2" style="color: #424553; font-size: 13px;">
                                                Mobile: <span class="font-bold"
                                                    style="color: #282c3f; font-weight: 700;">{{ $address->contact_number }}</span>
                                            </div>

                                            <!-- Action Buttons: REMOVE / EDIT -->
                                            <div class="d-flex align-items-center gap-2 pt-1">
                                                <form action="{{ route('admin.contact.destroy', $address->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn bg-white hover:bg-slate-50 text-[11px] font-bold uppercase tracking-wider px-3.5 py-1.5 rounded transition shadow-none"
                                                        style="border: 1px solid #282c3f; color: #282c3f; letter-spacing: 0.5px;">
                                                        REMOVE
                                                    </button>
                                                </form>

                                                <a href="{{ route('admin.contact.index', ['edit' => $address->id]) }}"
                                                    class="btn bg-white hover:bg-slate-50 text-[11px] font-bold uppercase tracking-wider px-4 py-1.5 rounded transition shadow-none text-decoration-none"
                                                    style="border: 1px solid #282c3f; color: #282c3f; letter-spacing: 0.5px;">
                                                    EDIT
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Dashed Button: + Add New Address (Reference Style) -->
                            <a href="{{ route('admin.contact.index', ['add' => 1]) }}"
                                class="bg-white border text-center p-3.5 rounded-md transition mb-4 shadow-2xs hover:shadow-xs text-decoration-none d-block"
                                style="border: 1px dashed #d4d5d9; border-radius: 6px;">
                                <span
                                    class="text-sm font-bold d-inline-flex align-items-center justify-content-center gap-1"
                                    style="color: #ff3f6c; font-weight: 700;">
                                    + Add New Address
                                </span>
                            </a>

                            <!-- Continue to Payment Button -->
                            <div class="pt-2">
                                <a href="{{ route('admin.checkout.payment') }}"
                                    class="btn w-100 py-3 rounded-md text-xs sm:text-sm font-bold uppercase tracking-wider text-white shadow-sm transition border-0 d-flex align-items-center justify-content-center"
                                    style="background-color: #ff3f6c; letter-spacing: 0.5px; text-decoration: none;">
                                    Deliver To This Address &nbsp;<i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    @endif

                </div>

                <!-- RIGHT COLUMN: Price Details Summary Box -->
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
                                    <span
                                        class="text-lg font-extrabold text-slate-900">&#8377;{{ number_format(($priceCount['total_price'] ?? 0) + ($priceCount['delivery_charges'] ?? 0)) }}</span>
                                </div>
                            </div>

                            <!-- Savings / Free Delivery Badge -->
                            <div class="mt-3 p-2.5 rounded-lg bg-emerald-50 border border-emerald-200 text-center">
                                <span
                                    class="text-xs font-semibold text-emerald-800 d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-shield-check text-emerald-600"></i> Cash on Delivery &amp; Online
                                    Payment Available
                                </span>
                            </div>

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
                                <span>Dispatch within 24–48 business hours</span>
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

    <!-- Scoped Styles for Radio & Hover States -->
    <style>
        .custom-pink-radio:checked {
            background-color: #ff3f6c !important;
            border-color: #ff3f6c !important;
        }
    </style>
@endsection
