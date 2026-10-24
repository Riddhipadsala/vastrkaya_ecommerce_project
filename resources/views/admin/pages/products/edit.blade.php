@extends('layouts.admin')

@section('title', 'Edit Product - Vastrkaya Luxury E-Commerce')

@section('content')
    <div class="container-fluid px-0">
        <!-- Header Card (Matching Option & Product Module Layout) -->
        <div class="vk-card mb-4">
            <div class="vk-card-header flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h4 class="h5 fw-bold mb-0 text-heading">Edit Product: {{ $product->name }}</h4>
                        <span class="font-12 text-muted"> &bull; Last updated:
                            {{ $product->updated_at ? $product->updated_at->diffForHumans() : 'N/A' }}</span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Products
                    </a>
                    <button type="button" class="btn btn-info text-white" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh Page
                    </button>
                </div>
            </div>
        </div>

        <!-- Alert / Validation Feedback -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following
                    errors:</div>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            id="editProductForm">
            @csrf
            @method('PUT')

            <!-- 1. Product Basic Information Card -->
            <div class="vk-card p-4 mb-4">
                <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                    <i class="bi bi-info-circle text-primary me-2"></i>Product Information
                </h5>

                <div class="row g-3">
                    <!-- Product Name -->
                    <div class="col-md-6">
                        <label class="vk-form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="productName"
                            class="vk-form-control @error('name') is-invalid @enderror"
                            placeholder="e.g. Royal Banarasi Silk Saree" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Brand -->
                    <div class="col-md-3">
                        <label class="vk-form-label fw-bold">Brand</label>
                        <input type="text" name="brand" id="productBrand"
                            class="vk-form-control @error('brand') is-invalid @enderror"
                            placeholder="e.g. Vastrkaya Couture" value="{{ old('brand', $product->brand) }}">
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-3">
                        <label class="vk-form-label fw-bold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="productCategory"
                            class="vk-form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="vk-form-label fw-bold">Description</label>
                        <textarea name="description" id="productDescription" class="vk-form-control @error('description') is-invalid @enderror"
                            rows="3" placeholder="Provide detailed description of fabrics, embroidery, fit, care instructions...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 2. Pricing & Inventory Card -->
            <div class="vk-card p-4 mb-4">
                <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                    <i class="bi bi-tag text-primary me-2"></i>Pricing & Inventory
                </h5>

                <div class="row g-3">
                    <!-- Regular Price -->
                    <div class="col-md-3">
                        <label class="vk-form-label fw-bold">Regular Price (&#8377;) <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-surface text-muted border-end-0">&#8377;</span>
                            <input type="number" step="0.01" min="0" name="price" id="productPrice"
                                class="form-control vk-form-control border-start-0 @error('price') is-invalid @enderror"
                                placeholder="3999.00" value="{{ old('price', $product->price) }}" required
                                oninput="calculateDiscount()">
                        </div>
                        @error('price')
                            <div class="text-danger font-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Discount Price -->
                    <div class="col-md-3">
                        <label class="vk-form-label fw-bold">Discount Price (&#8377;)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-surface text-muted border-end-0">&#8377;</span>
                            <input type="number" step="0.01" min="0" name="discount_price"
                                id="productDiscountPrice"
                                class="form-control vk-form-control border-start-0 @error('discount_price') is-invalid @enderror"
                                placeholder="Optional" value="{{ old('discount_price', $product->discount_price) }}"
                                oninput="calculateDiscount()">
                        </div>
                        @error('discount_price')
                            <div class="text-danger font-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Discount Percentage -->
                    <div class="col-md-2">
                        <label class="vk-form-label fw-bold">Discount (%)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" max="100"
                                name="discount_percentage" id="productDiscountPercent"
                                class="form-control vk-form-control border-end-0 @error('discount_percentage') is-invalid @enderror"
                                placeholder="0" value="{{ old('discount_percentage', $product->discount_percentage) }}"
                                oninput="calculateDiscountFromPercent()">
                            <span class="input-group-text bg-surface text-muted border-start-0">%</span>
                        </div>
                        @error('discount_percentage')
                            <div class="text-danger font-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remaining amount -->
                    <div class="col-md-4">
                        <label class="vk-form-label fw-bold">Actual Amount (&#8377;)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" name="actual_amount" id="actualAmount"
                                class="form-control vk-form-control border-end-0 @error('actual_amount') is-invalid @enderror"
                                placeholder="0.00"
                                value="{{ old('actual_amount', $product->discount_price ? $product->price - $product->discount_price : $product->price) }}">
                        </div>
                        @error('actual_amount')
                            <div class="text-danger font-12 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="col-md-6">
                        <label class="vk-form-label fw-bold">Available Stock <span class="text-danger">*</span></label>
                        <input type="number" name="stock" id="productStock"
                            class="vk-form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock', $product->stock) }}" min="0" required>
                        <small class="text-muted font-12">Total quantity currently available in inventory</small>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- 3. Media & Status Card -->
            <div class="vk-card p-4 mb-4">
                <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                    <i class="bi bi-image text-primary me-2"></i>Media & Status
                </h5>

                <div class="row g-3 align-items-center">
                    <!-- Product Image Input & Preview -->
                    <div class="col-md-8">
                        <label class="vk-form-label fw-bold">Product Image</label>
                        <div class="d-flex align-items-center gap-3">
                            @php
                                $imgSrc = $product->image
                                    ? asset('storage/' . $product->image)
                                    : 'https://via.placeholder.com/60x60?text=Preview';
                            @endphp
                            <img id="imagePreview" src="{{ $imgSrc }}" alt="{{ $product->name }}"
                                style="width: 55px; height: 55px; object-fit: cover; border-radius: 8px; border: 1px solid var(--vk-border); flex-shrink: 0;">
                            <div class="flex-grow-1">
                                <input type="file" name="image" id="productImageInput"
                                    class="form-control vk-form-control @error('image') is-invalid @enderror"
                                    accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted font-12 d-block mt-1">
                                    @if ($product->image)
                                        <span class="text-success fw-semibold"><i class="bi bi-check-circle"></i> Current
                                            image uploaded.</span>
                                        Leave empty to keep existing image. (Max: 2MB)
                                    @else
                                        Recommended: JPG, PNG, WEBP (Max: 2MB)
                                    @endif
                                </small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status (0 = Inactive, 1 = Active) -->
                    <div class="col-md-4">
                        <label class="vk-form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" id="productStatus"
                            class="vk-form-select @error('status') is-invalid @enderror">
                            <option value="1"
                                {{ old('status', (string) $product->status) === '1' ? 'selected' : '' }}>Active (Visible on
                                Store)</option>
                            <option value="0"
                                {{ old('status', (string) $product->status) === '0' ? 'selected' : '' }}>Inactive (Hidden)
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 4. Product Options & Variants Card -->
            @php
                $assignedOptionValueMap = $product->productOptionValues->keyBy('option_value_id');
                $assignedOptionValueIds = $assignedOptionValueMap->keys()->toArray();
                $hasExistingOptions = count($product->productOptions) > 0;
            @endphp

            <div class="vk-card p-4 mb-4">
                <div
                    class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom border-light">
                    <div>
                        <h5 class="fw-bold text-heading font-15 mb-0">
                            <i class="bi bi-sliders2 text-primary me-2"></i>Product Options &amp; Variants
                        </h5>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnToggleAllOptionBodies"
                            onclick="toggleAllOptionBodies()" title="Collapse or Expand all option values">
                            <i class="bi bi-arrows-collapse me-1" id="toggleAllOptionsIcon"></i>
                            <span id="toggleAllOptionsText">Collapse All</span>
                        </button>
                        <a href="{{ route('admin.options.index') }}" class="btn btn-sm btn-outline-secondary"
                            target="_blank">
                            <i class="bi bi-gear"></i> Manage Options
                        </a>
                    </div>
                </div>

                <!-- Option Selection Toolbar -->
                <div class="p-3 mb-3 rounded-2 border bg-surface-subtle">
                    <label class="vk-form-label fw-bold mb-2">
                        <i class="bi bi-plus-square text-primary me-1"></i> Add / Choose Option to Configure:
                    </label>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="flex-grow-1" style="max-width: 380px;">
                            <select id="optionPickerSelect" class="form-select vk-form-select">
                                <option value="">-- Choose Option --</option>
                                @if (isset($options))
                                    @foreach ($options as $opt)
                                        <option value="{{ $opt->id }}">
                                            {{ $opt->name }} ({{ ucfirst($opt->type) }})
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="text-danger font-12 select-error"></span>
                        </div>
                    </div>
                </div>

                <!-- Configured Options Container -->
                <div id="optionsContainer" class="d-flex flex-column gap-3">
                    @forelse ($product->productOptions as $pOpt)
                        @php
                            $item = $pOpt->option;
                        @endphp

                        @if ($item)
                            <div class="option-card rounded-2 border p-3 shadow-none {{ ($pOpt->status ?? 1) == 0 ? 'bg-light opacity-75' : 'bg-white' }}"
                                name="options[{{ $item->id }}]" id="option_card_{{ $item->id }}">

                                <input type="hidden" name="options[{{ $item->id }}][option_id]"
                                    value="{{ $item->id }}">

                                <!-- Option Card Header -->
                                <div
                                    class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-2 mb-2 border-bottom border-light">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary text-white rounded-circle p-1">
                                            <i class="bi bi-check2"></i>
                                        </span>
                                        @php
                                            $assignedCount = $item->optionValues
                                                ->filter(function ($v) use ($assignedOptionValueMap) {
                                                    $pov = $assignedOptionValueMap->get($v->id);
                                                    return $pov && $pov->status == 1;
                                                })
                                                ->count();
                                        @endphp
                                        <div>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6 class="fw-bold text-heading mb-0 font-14">{{ $item->name }}</h6>
                                                <span
                                                    class="badge bg-light text-primary border font-11 rounded-pill {{ $assignedCount > 0 ? '' : 'd-none' }}"
                                                    id="selected_count_badge_{{ $item->id }}">
                                                    {{ $assignedCount }} selected
                                                </span>
                                            </div>
                                            <small class="text-muted font-11">Type: {{ ucfirst($item->type) }}</small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-1">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary py-1 px-2 font-12 rounded"
                                            id="btn_toggle_{{ $item->id }}"
                                            onclick="toggleOptionBody('{{ $item->id }}')"
                                            title="Collapse / Expand Values">
                                            <i class="bi bi-chevron-up" id="icon_toggle_{{ $item->id }}"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary py-1 px-2 font-12 rounded"
                                            onclick="selectAllValues('{{ $item->id }}')">
                                            <i class="bi bi-check-all"></i> Select All
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary py-1 px-2 font-12 rounded"
                                            onclick="deselectAllValues('{{ $item->id }}')">
                                            <i class="bi bi-x"></i> Clear
                                        </button>
                                        <select name="options[{{ $item->id }}][status]"
                                            class="form-select form-select-sm py-1 px-2 font-12 rounded fw-medium"
                                            style="width: auto; min-width: 95px;"
                                            onchange="handleOptionStatusChange(this, '{{ $item->id }}', '{{ $product->id }}')">
                                            <option value="1" {{ ($pOpt->status ?? 1) == 1 ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0" {{ ($pOpt->status ?? 1) == 0 ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Values List Body (Collapsible) -->
                                <div class="option-values-body" id="option_values_body_{{ $item->id }}">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-semibold font-12 text-muted">
                                            Select Values &amp; Optional Price:
                                        </span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2.5">
                                        @foreach ($item->optionValues as $val)
                                            @php
                                                $pov = $assignedOptionValueMap->get($val->id);
                                                $isChecked = $pov && $pov->status == 1;
                                                $valPrice = $pov && $pov->price > 0 ? $pov->price : '';
                                            @endphp
                                            <div class="variant-item-box rounded-3 border transition-all p-2.5 {{ $isChecked ? 'border-primary shadow-xs bg-white' : 'border-light bg-surface-subtle' }}"
                                                id="variant_box_{{ $item->id }}_{{ $val->id }}"
                                                style="min-width: 210px; flex: 1 1 210px; max-width: 270px;">

                                                <!-- Top Row: Checkbox, Swatch & Label -->
                                                <div class="d-flex align-items-center justify-content-between gap-2">
                                                    <div
                                                        class="form-check d-flex align-items-center gap-2 mb-0 flex-grow-1 cursor-pointer">
                                                        <input
                                                            class="form-check-input mt-0 opt-val-cb-{{ $item->id }}"
                                                            type="checkbox" name="options[{{ $item->id }}][values][]"
                                                            value="{{ $val->id }}"
                                                            id="val_{{ $item->id }}_{{ $val->id }}"
                                                            data-option-id="{{ $item->id }}"
                                                            data-val-id="{{ $val->id }}"
                                                            onchange="toggleVariantPrice(this, '{{ $item->id }}', '{{ $val->id }}')"
                                                            {{ $isChecked ? 'checked' : '' }} />
                                                        <label
                                                            class="form-check-label font-13 fw-semibold text-heading mb-0 cursor-pointer d-flex align-items-center gap-1.5"
                                                            for="val_{{ $item->id }}_{{ $val->id }}">
                                                            @if ($val->option_value_image)
                                                                <img src="{{ asset('storage/' . $val->option_value_image) }}"
                                                                    alt="{{ $val->name }}"
                                                                    style="width: 22px; height: 22px; object-fit: cover; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1);"
                                                                    class="shrink-0">
                                                            @endif
                                                            <span>{{ $val->name }}</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Price Section: Appears when checkbox is selected -->
                                                <div class="variant-price-wrap mt-2 pt-2 border-top border-light {{ $isChecked ? '' : 'd-none' }}"
                                                    id="price_wrap_{{ $item->id }}_{{ $val->id }}">
                                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                                        <label class="font-11 text-muted fw-semibold mb-0"
                                                            for="price_{{ $item->id }}_{{ $val->id }}">
                                                            <i class="bi bi-tag text-primary me-1"></i>Price (&#8377;):
                                                        </label>
                                                        <small class="font-10 text-muted">Optional</small>
                                                    </div>
                                                    <div class="input-group input-group-sm">
                                                        <span
                                                            class="input-group-text bg-light text-muted border-end-0 font-11">&#8377;</span>
                                                        <input type="number" step="0.01" min="0"
                                                            name="options[{{ $item->id }}][prices][{{ $val->id }}]"
                                                            id="price_{{ $item->id }}_{{ $val->id }}"
                                                            class="form-control form-control-sm border-start-0 font-12"
                                                            placeholder="0.00"
                                                            value="{{ $valPrice !== '' ? $valPrice : '' }}"
                                                            {{ $isChecked ? '' : 'disabled' }} />
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                    @endforelse

                    <!-- Notice when no option is visible -->
                    <div id="noOptionsNotice"
                        class="p-4 text-center bg-surface-subtle rounded-2 border border-dashed border-secondary border-opacity-25"
                        style="{{ $hasExistingOptions ? 'display: none;' : '' }}">
                        <i class="bi bi-sliders2 fs-3 text-secondary"></i>
                        <h6 class="fw-bold text-heading mt-2 mb-1">No Options Configured</h6>
                        <p class="text-muted font-12 mb-0">Select an option from the dropdown above to configure variants
                            for this product.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Actions (Matching Option Module Layout) -->
            <div class="d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-sm btn-primary" id="saveProductBtn">
                    <i class="bi bi-check-lg"></i> Update Product
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto calculate discounts on load if values exist
            calculateDiscount();

            const optionPicker = document.getElementById('optionPickerSelect');

            optionPicker.addEventListener('change', function() {
                const selectedOption = this.value;
                if (!selectedOption) return;

                // Check if card is already added
                if ($(`#option_card_${selectedOption}`).length > 0) {
                    if (window.showToast) {
                        window.showToast('This option is already added to this product.', 'info');
                    } else {
                        alert('This option is already added to this product.');
                    }
                    this.value = '';
                    return;
                }

                axios.get(`/admin/options/${selectedOption}`)
                    .then((res) => {
                        let item = res.data.option;

                        let tag = `
                            <div class="option-card rounded-2 border bg-white p-3 shadow-none" 
                                name="options[${item.id}]" id="option_card_${item.id}">
                                
                                <input type="hidden" name="options[${item.id}][option_id]" value="${item.id}">
                                
                                <!-- Option Card Header -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-2 mb-2 border-bottom border-light">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-primary text-white rounded-circle p-1">
                                            <i class="bi bi-check2"></i>
                                        </span>
                                        <div>
                                            <div class="d-flex align-items-center gap-2">
                                                <h6 class="fw-bold text-heading mb-0 font-14">${item.name}</h6>
                                                <span class="badge bg-light text-primary border font-11 rounded-pill d-none" id="selected_count_badge_${item.id}">
                                                    0 selected
                                                </span>
                                            </div>
                                            <small class="text-muted font-11">Type: ${item.type}</small>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-1">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-secondary py-1 px-2 font-12 rounded" 
                                                id="btn_toggle_${item.id}"
                                                onclick="toggleOptionBody('${item.id}')"
                                                title="Collapse / Expand Values">
                                            <i class="bi bi-chevron-up" id="icon_toggle_${item.id}"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary py-1 px-2 font-12 rounded" 
                                                onclick="selectAllValues('${item.id}')">
                                            <i class="bi bi-check-all"></i> Select All
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-secondary py-1 px-2 font-12 rounded" 
                                                onclick="deselectAllValues('${item.id}')">
                                            <i class="bi bi-x"></i> Clear
                                        </button>
                                        <select name="options[${item.id}][status]" 
                                                class="form-select form-select-sm py-1 px-2 font-12 rounded fw-medium" 
                                                style="width: auto; min-width: 95px;"
                                                onchange="handleOptionStatusChange(this, '${item.id}','{{ $product->id }}')">
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Values List Body (Collapsible) -->
                                <div class="option-values-body" id="option_values_body_${item.id}">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-semibold font-12 text-muted">
                                            Select Values &amp; Optional Price:
                                        </span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2.5">
                                        ${(item.option_values || []).map(val => {
                                            return `
                                                        <div class="variant-item-box rounded-3 border transition-all p-2.5 border-light bg-surface-subtle"
                                                             id="variant_box_${item.id}_${val.id}"
                                                             style="min-width: 210px; flex: 1 1 210px; max-width: 270px;">
                                                            
                                                            <!-- Top Row: Checkbox, Swatch & Label -->
                                                            <div class="d-flex align-items-center justify-content-between gap-2">
                                                                <div class="form-check d-flex align-items-center gap-2 mb-0 flex-grow-1 cursor-pointer">
                                                                    <input class="form-check-input mt-0 opt-val-cb-${item.id}" 
                                                                            type="checkbox" 
                                                                            name="options[${item.id}][values][]" 
                                                                            value="${val.id}" 
                                                                            id="val_${item.id}_${val.id}"
                                                                            data-option-id="${item.id}"
                                                                            data-val-id="${val.id}"
                                                                            onchange="toggleVariantPrice(this, '${item.id}', '${val.id}')"
                                                                    />
                                                                    <label class="form-check-label font-13 fw-semibold text-heading mb-0 cursor-pointer d-flex align-items-center gap-1.5" for="val_${item.id}_${val.id}">
                                                                        ${val.option_value_image ? `
                                                                    <img src="/storage/${val.option_value_image}" 
                                                                         alt="${val.name}" 
                                                                         style="width: 22px; height: 22px; object-fit: cover; border-radius: 4px; border: 1px solid rgba(0,0,0,0.1);" class="shrink-0">
                                                                ` : ''}
                                                                        <span>${val.name}</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <!-- Price Section: Appears when checkbox is selected -->
                                                            <div class="variant-price-wrap mt-2 pt-2 border-top border-light d-none" 
                                                                 id="price_wrap_${item.id}_${val.id}">
                                                                <div class="d-flex align-items-center justify-content-between mb-1">
                                                                    <label class="font-11 text-muted fw-semibold mb-0" for="price_${item.id}_${val.id}">
                                                                        <i class="bi bi-tag text-primary me-1"></i>Price (&#8377;):
                                                                    </label>
                                                                    <small class="font-10 text-muted">Optional</small>
                                                                </div>
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-text bg-light text-muted border-end-0 font-11">&#8377;</span>
                                                                    <input type="number" 
                                                                           step="0.01" 
                                                                           min="0" 
                                                                           name="options[${item.id}][prices][${val.id}]" 
                                                                           id="price_${item.id}_${val.id}"
                                                                           class="form-control form-control-sm border-start-0 font-12" 
                                                                           placeholder="0.00" 
                                                                           value=""
                                                                           disabled
                                                                        />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `;
                                        }).join('')}
                                    </div>
                                </div>
                            </div>
                        `;

                        $('#optionsContainer').append(tag);
                        $("#noOptionsNotice").hide();
                        optionPicker.value = '';
                    })
                    .catch((err) => {
                        let errMsg = (err.response && err.response.data && err.response.data.message) ?
                            err.response.data.message : 'Failed to load option';
                        if (window.showToast) {
                            window.showToast('error', errMsg);
                        } else {
                            alert(errMsg);
                        }
                    });
            });
        });

        // Toggle variant price section when variant is checked/unchecked
        function toggleVariantPrice(cb, optionId, valId) {
            const isChecked = $(cb).is(':checked');
            const box = $(`#variant_box_${optionId}_${valId}`);
            const priceWrap = $(`#price_wrap_${optionId}_${valId}`);
            const priceInput = $(`#price_${optionId}_${valId}`);

            if (isChecked) {
                box.addClass('border-primary shadow-xs bg-white').removeClass('border-light bg-surface-subtle');
                priceWrap.removeClass('d-none').hide().slideDown(140);
                priceInput.prop('disabled', false);
            } else {
                box.removeClass('border-primary shadow-xs bg-white').addClass('border-light bg-surface-subtle');
                priceWrap.slideUp(140, function() {
                    $(this).addClass('d-none');
                });
                priceInput.prop('disabled', true);
            }
            updateSelectedCountBadge(optionId);
        }

        // Live Image Preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Calculate discount percentage when price or discount price changes
        function calculateDiscount() {
            const price = parseFloat($('#productPrice').val()) || 0;
            const discountPrice = parseFloat($('#productDiscountPrice').val()) || 0;

            if (price > 0 && discountPrice > 0 && discountPrice <= price) {
                const diff = price - discountPrice;
                const percent = (discountPrice * 100) / price;
                $('#productDiscountPercent').val(percent.toFixed(2));
                $('#actualAmount').val(diff.toFixed(2));
            } else if (discountPrice === 0) {
                $('#productDiscountPercent').val('');
                $('#actualAmount').val(price.toFixed(2));
            } else {
                $('#actualAmount').val(0);
            }
        }

        // Calculate discount price when percentage is typed
        function calculateDiscountFromPercent() {
            const price = parseFloat($('#productPrice').val()) || 0;
            const percent = parseFloat($('#productDiscountPercent').val()) || 0;

            if (price > 0 && percent > 0 && percent <= 100) {
                const discountAmount = (price * percent) / 100;
                const newPrice = price - discountAmount;
                $('#productDiscountPrice').val(discountAmount.toFixed(2));
                $('#actualAmount').val(newPrice.toFixed(2));
            } else {
                $('#productDiscountPrice').val('');
                $('#actualAmount').val(0);
            }
        }

        // Select all values for an option
        function selectAllValues(optionId) {
            $(`.opt-val-cb-${optionId}`).each(function() {
                if (!$(this).is(':checked')) {
                    $(this).prop('checked', true);
                    const valId = $(this).data('val-id');
                    toggleVariantPrice(this, optionId, valId);
                }
            });
            updateSelectedCountBadge(optionId);
        }

        // Deselect all values for an option
        function deselectAllValues(optionId) {
            $(`.opt-val-cb-${optionId}`).each(function() {
                if ($(this).is(':checked')) {
                    $(this).prop('checked', false);
                    const valId = $(this).data('val-id');
                    toggleVariantPrice(this, optionId, valId);
                }
            });
            updateSelectedCountBadge(optionId);
        }

        // Toggle visual style when status changed between Active & Inactive
        function handleOptionStatusChange(selectElem, optionid, productid) {
            const statusData = $(selectElem).val();
            const card = $('#option_card_' + optionid);

            if (statusData === '0') {
                card.addClass('bg-light opacity-75');
            } else {
                card.removeClass('bg-light opacity-75');
            }

            axios.post('/admin/product/option/status', {
                    optionId: optionid,
                    status: statusData,
                    productId: productid
                })
                .then((res) => {
                    window.showToast('Option status changed!', 'success');
                })
                .catch((err) => {
                    console.error(err);
                    window.showToast('Something went wrong!', 'error');
                });
        }

        // Update selected values counter badge for an option card
        function updateSelectedCountBadge(optionId) {
            const count = $(`.opt-val-cb-${optionId}:checked`).length;
            const badge = $(`#selected_count_badge_${optionId}`);
            if (badge.length) {
                if (count > 0) {
                    badge.text(`${count} selected`).removeClass('d-none');
                } else {
                    badge.addClass('d-none');
                }
            }
        }

        // Toggle individual option card values body (Collapse / Expand)
        function toggleOptionBody(optionId) {
            const body = $(`#option_values_body_${optionId}`);
            const icon = $(`#icon_toggle_${optionId}`);
            body.stop(true, true).slideToggle(180, function() {
                if (body.is(':visible')) {
                    icon.removeClass('bi-chevron-down').addClass('bi-chevron-up');
                } else {
                    icon.removeClass('bi-chevron-up').addClass('bi-chevron-down');
                }
            });
        }

        // Toggle all option cards at once
        let allOptionsCollapsed = false;

        function toggleAllOptionBodies() {
            allOptionsCollapsed = !allOptionsCollapsed;
            const bodies = $('.option-values-body');
            const toggleIcon = $('#toggleAllOptionsIcon');
            const toggleText = $('#toggleAllOptionsText');

            if (allOptionsCollapsed) {
                bodies.stop(true, true).slideUp(180);
                $('[id^="icon_toggle_"]').removeClass('bi-chevron-up').addClass('bi-chevron-down');
                toggleIcon.removeClass('bi-arrows-collapse').addClass('bi-arrows-expand');
                toggleText.text('Expand All');
            } else {
                bodies.stop(true, true).slideDown(180);
                $('[id^="icon_toggle_"]').removeClass('bi-chevron-down').addClass('bi-chevron-up');
                toggleIcon.removeClass('bi-arrows-expand').addClass('bi-arrows-collapse');
                toggleText.text('Collapse All');
            }
        }
    </script>
@endsection
