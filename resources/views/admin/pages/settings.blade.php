@extends('layouts.admin')

@section('title', 'Store & Delivery Settings - Vastrkaya')

@section('content')
<div class="container-fluid px-0">

    <!-- Top Header Card -->
    <div class="vk-card mb-4">
        <div class="vk-card-header flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h4 class="h5 fw-bold mb-0 text-heading">Store &amp; Delivery Settings</h4>
                    <span class="font-12 text-muted">Configure minimum order requirements, free delivery thresholds, and delivery charges.</span>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please check the following errors:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Settings Form -->
    <form action="{{ route('admin.settings.update') }}" method="POST" id="storeSettingsForm">
        @csrf

        <div class="vk-card p-4 mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom border-light">
                <h5 class="fw-bold text-heading font-15 mb-0">
                    <i class="bi bi-truck text-primary me-2"></i>Order &amp; Shipping Thresholds
                </h5>
            </div>

            <div class="row g-4">

                <!-- 2. Free Delivery Amount -->
                <div class="col-md-4">
                    <label class="vk-form-label fw-bold mb-1" for="minimum_order_amount">
                        Free Delivery Threshold (&#8377;) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-surface text-muted border-end-0 font-13">&#8377;</span>
                        <input type="number" 
                               step="1" 
                               min="0" 
                               name="minimum_order_amount" 
                               id="minimum_order_amount"
                               class="form-control vk-form-control border-start-0 @error('minimum_order_amount') is-invalid @enderror" 
                               placeholder="0" 
                               value="{{ old('minimum_order_amount', $setting->minimum_order_amount ?? 0) }}" 
                               required>
                    </div>
                    <small class="text-muted font-11 d-block mt-1">
                        Orders at or above this amount qualify for free shipping.
                    </small>
                    @error('minimum_order_amount')
                        <div class="text-danger font-12 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 3. Delivery Charge -->
                <div class="col-md-4">
                    <label class="vk-form-label fw-bold mb-1" for="deliveryCharge">
                        Delivery Charge (&#8377;) <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-surface text-muted border-end-0 font-13">&#8377;</span>
                        <input type="number" 
                               step="1" 
                               min="0" 
                               name="delivery_charge" 
                               id="deliveryCharge"
                               class="form-control vk-form-control border-start-0 @error('delivery_charge') is-invalid @enderror" 
                               placeholder="0" 
                               value="{{ old('delivery_charge', $setting->delivery_charge ?? 0) }}" 
                               required>
                    </div>
                    <small class="text-muted font-11 d-block mt-1">
                        Delivery Charge apply on the order.
                    </small>
                    @error('delivery_charge')
                        <div class="text-danger font-12 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Actions -->
        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('admin.dashboard') }}" class="vk-btn vk-btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-sm btn-primary px-3 py-2">
                <i class="bi bi-check-lg me-1"></i> Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
