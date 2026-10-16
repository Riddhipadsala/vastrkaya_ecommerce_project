@extends('layouts.admin')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="vk-card mb-4">
        <div class="vk-card-header flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h4 class="h5 fw-bold mb-0 text-heading">Add New Product</h4>
                    <p class="font-13 text-muted mb-0">Fill in product details, pricing, inventory, and configure variant options</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back To Products
                </a>
            </div>
        </div>
    </div>

    <!-- Alert / Validation Feedback -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following errors:</div>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="createProductForm">
        @csrf

        <div class="row g-4">
            <!-- Left Column: Main Details -->
            <div class="col-lg-8">
                <!-- 1. Basic Information -->
                <div class="vk-card p-4 mb-4">
                    <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                        <i class="bi bi-info-circle text-primary me-2"></i>Basic Information
                    </h5>

                    <div class="row g-3">
                        <!-- Product Name -->
                        <div class="col-12">
                            <label class="vk-form-label fw-bold">Product Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   id="productName" 
                                   class="vk-form-control @error('name') is-invalid @enderror" 
                                   placeholder="e.g. Royal Banarasi Silk Saree" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Brand -->
                        <div class="col-md-6">
                            <label class="vk-form-label fw-bold">Brand</label>
                            <input type="text" 
                                   name="brand" 
                                   id="productBrand" 
                                   class="vk-form-control @error('brand') is-invalid @enderror" 
                                   placeholder="e.g. Vastrkaya Couture" 
                                   value="{{ old('brand') }}">
                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="col-md-6">
                            <label class="vk-form-label fw-bold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="productCategory" class="vk-form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <textarea name="description" 
                                      id="productDescription" 
                                      class="vk-form-control @error('description') is-invalid @enderror" 
                                      rows="4" 
                                      placeholder="Provide detailed description of fabrics, embroidery, fit, care instructions...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 2. Pricing & Inventory -->
                <div class="vk-card p-4 mb-4">
                    <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                        <i class="bi bi-tag text-primary me-2"></i>Pricing & Inventory
                    </h5>

                    <div class="row g-3">
                        <!-- Regular Price -->
                        <div class="col-md-4">
                            <label class="vk-form-label fw-bold">Regular Price (&#8377;) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-surface text-muted border-end-0">&#8377;</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       name="price" 
                                       id="productPrice" 
                                       class="form-control vk-form-control border-start-0 @error('price') is-invalid @enderror" 
                                       placeholder="3999.00" 
                                       value="{{ old('price') }}" 
                                       required 
                                       oninput="calculateDiscount()"
                                    >
                            </div>
                            @error('price')
                                <div class="text-danger font-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Discount Price -->
                        <div class="col-md-4">
                            <label class="vk-form-label fw-bold">Discount Price (&#8377;)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-surface text-muted border-end-0">&#8377;</span>
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       name="discount_price" 
                                       id="productDiscountPrice" 
                                       class="form-control vk-form-control border-start-0 @error('discount_price') is-invalid @enderror" 
                                       placeholder="Optional" 
                                       value="{{ old('discount_price') }}" 
                                       oninput="calculateDiscount()">
                            </div>
                            @error('discount_price')
                                <div class="text-danger font-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Discount Percentage -->
                        <div class="col-md-4">
                            <label class="vk-form-label fw-bold">Discount (%)</label>
                            <div class="input-group">
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       max="100" 
                                       name="discount_percentage" 
                                       id="productDiscountPercent" 
                                       class="form-control vk-form-control border-end-0 @error('discount_percentage') is-invalid @enderror" 
                                       placeholder="0.00" 
                                       value="{{ old('discount_percentage') }}" 
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
                                <input type="number" 
                                       step="0.01" 
                                       min="0" 
                                       name="actual_amount" 
                                       id="actualAmount" 
                                       class="form-control vk-form-control border-end-0 @error('actual_amount') is-invalid @enderror" 
                                       placeholder="0.00" 
                                       value="{{ old('actual_amount') }}" 
                                       >
                            </div>
                            @error('actual_amount')
                                <div class="text-danger font-12 mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div class="col-md-6">
                            <label class="vk-form-label fw-bold">Available Stock <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="stock" 
                                   id="productStock" 
                                   class="vk-form-control @error('stock') is-invalid @enderror" 
                                   value="{{ old('stock', 0) }}" 
                                   min="0" 
                                   required>
                            <small class="text-muted font-12">Total quantity currently available in inventory</small>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Decrease Stock Threshold -->
                        <div class="col-md-6">
                            <label class="vk-form-label fw-bold">Decrease / Low Stock Alert</label>
                            <input type="number" 
                                   name="descrese_stock" 
                                   id="productDecreaseStock" 
                                   class="vk-form-control @error('descrese_stock') is-invalid @enderror" 
                                   value="{{ old('descrese_stock', 0) }}" 
                                   min="0">
                            <small class="text-muted font-12">Notify admin when inventory drops below this quantity</small>
                            @error('descrese_stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 3. Product Options & Variants -->
                <div class="vk-card p-4 mb-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom border-light">
                        <div>
                            <h5 class="fw-bold text-heading font-15 mb-0">
                                <i class="bi bi-sliders2 text-primary me-2"></i>Product Options &amp; Variants
                            </h5>
                            <small class="text-muted">Select the options and specific values (e.g. Size, Colour, Fabric) available for this product</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.options.index') }}" class="vk-btn vk-btn-sm vk-btn-secondary" target="_blank" title="Manage all store options">
                                <i class="bi bi-gear"></i> Manage Options
                            </a>
                        </div>
                    </div>

                    <!-- Option Selection Toolbar -->
                    <div class="p-3 mb-3 rounded-3 border bg-surface-subtle">
                        <label class="vk-form-label fw-bold mb-2">
                            <i class="bi bi-plus-square text-primary me-1"></i> Choose an Option to Configure:
                        </label>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <div class="flex-grow-1" style="max-width: 400px;">
                                <select id="optionPickerSelect" class="form-select vk-form-select">
                                    <option value="">-- Choose Option --</option>
                                    @if(isset($options))
                                        @foreach($options as $opt)
                                            <option value="{{ $opt->id }}">
                                                {{ $opt->name }} ({{ ucfirst($opt->type) }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger font-12 select-error"></span>
                            </div>
                            <button type="button" class="vk-btn vk-btn-info" onclick="addSelectedOptionFromDropdown()">
                                <i class="bi bi-plus-lg"></i> Add Option to Product
                            </button>
                        </div>
                    </div>

                    <!-- Configured Options Container -->
                    <div id="optionsContainer" class="d-flex flex-column gap-3">
                        @if(isset($options) && $options->count() > 0)
                            @php
                                $hasAnyActiveOption = false;
                            @endphp
                            @foreach($options as $option)
                                @php
                                    $oldValues = old("options.{$option->id}.values", []);
                                    $isOptionActive = !empty($oldValues);
                                    if ($isOptionActive) {
                                        $hasAnyActiveOption = true;
                                    }
                                @endphp
                                <div class="option-card rounded-3 border bg-surface-subtle p-3" 
                                     id="option_card_{{ $option->id }}" 
                                     style="{{ $isOptionActive ? '' : 'display: none;' }}">
                                    
                                    <!-- Option Card Header -->
                                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 pb-2 mb-3 border-bottom border-light">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary rounded-circle p-2 text-white">
                                                <i class="bi bi-check2"></i>
                                            </span>
                                            <div>
                                                <h6 class="fw-bold text-heading mb-0 font-15">{{ $option->name }}</h6>
                                                <small class="text-muted font-12">Type: {{ ucfirst($option->type) }}</small>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-primary py-1 px-2 font-12 rounded-2" 
                                                    onclick="selectAllValues('{{ $option->id }}')" 
                                                    title="Select all values">
                                                <i class="bi bi-check-all"></i> Select All
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-secondary py-1 px-2 font-12 rounded-2" 
                                                    onclick="deselectAllValues('{{ $option->id }}')" 
                                                    title="Clear all">
                                                <i class="bi bi-x"></i> Clear
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger py-1 px-2 font-12 rounded-2" 
                                                    onclick="removeOptionCard('{{ $option->id }}')" 
                                                    title="Remove option">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Values List -->
                                    <div>
                                        <div class="fw-semibold font-13 text-muted mb-2">
                                            Select Values for {{ $option->name }}:
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            @forelse($option->optionValues as $val)
                                                <div class="form-check p-2 px-3 border rounded bg-white d-flex align-items-center gap-2">
                                                    <input class="form-check-input mt-0 opt-val-cb-{{ $option->id }}" 
                                                           type="checkbox" 
                                                           name="options[{{ $option->id }}][values][]" 
                                                           value="{{ $val->id }}" 
                                                           id="val_{{ $val->id }}"
                                                           {{ in_array($val->id, (array)$oldValues) ? 'checked' : '' }}>
                                                    <label class="form-check-label font-13 fw-semibold text-heading mb-0" for="val_{{ $val->id }}">
                                                        @if($val->option_image)
                                                            <img src="{{ asset('storage/' . $val->option_image) }}" 
                                                                 alt="{{ $val->name }}" 
                                                                 style="width: 20px; height: 20px; object-fit: cover; border-radius: 4px;" class="me-1">
                                                        @endif
                                                        {{ $val->name }}
                                                    </label>
                                                </div>
                                            @empty
                                                <span class="text-muted font-12">No values configured for this option.</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Notice when no option is visible -->
                        <div id="noOptionsNotice" class="p-4 text-center bg-surface-subtle rounded-3 border border-dashed border-secondary border-opacity-25" style="{{ !empty($hasAnyActiveOption) ? 'display: none;' : '' }}">
                            <i class="bi bi-sliders2 fs-2 text-primary"></i>
                            <h6 class="fw-bold text-heading mt-2 mb-1">No Options Selected Yet</h6>
                            <p class="text-muted font-13 mb-0">Select an option from the dropdown above and click "Add Option to Product" to configure sizes, colours, or other variants.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Media, Status & Actions -->
            <div class="col-lg-4">
                <!-- 4. Product Image -->
                <div class="vk-card p-4 mb-4">
                    <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                        <i class="bi bi-image text-primary me-2"></i>Product Picture
                    </h5>

                    <div class="text-center mb-3">
                        <div class="position-relative d-inline-block">
                            <img id="imagePreview" 
                                 src="https://via.placeholder.com/300x300?text=Select+Picture" 
                                 alt="Product Preview" 
                                 class="img-fluid rounded-3 border border-light" 
                                 style="width: 100%; max-height: 240px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-2">
                        <input type="file" 
                               name="image" 
                               id="productImageInput" 
                               class="form-control vk-form-control form-control-sm @error('image') is-invalid @enderror" 
                               accept="image/*" 
                               onchange="previewImage(this)">
                        <small class="text-muted font-12 d-block mt-1">Recommended: JPG, PNG, WEBP (Max: 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 5. Status Card -->
                <div class="vk-card p-4 mb-4">
                    <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                        Status & Visibility
                    </h5>

                    <div>
                        <label class="vk-form-label fw-bold">Product Status</label>
                        <select name="status" id="productStatus" class="vk-form-select @error('status') is-invalid @enderror">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active (Visible on Store)</option>
                            <option value="inactive" {{ old('status', 'inactive') == 'inactive' ? 'selected' : '' }}>Inactive (Hidden)</option>
                        </select>
                        <small class="text-muted font-12 d-block mt-1">Only active products will be displayed on the storefront</small>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 6. Form Actions -->
                <div class="vk-card p-4 mb-4">
                    <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                        <i class="bi bi-check2-circle text-primary me-2"></i>Publish
                    </h5>

                    <button type="submit" class="vk-btn vk-btn-info w-100 py-2 mb-2" id="saveProductBtn">
                        <i class="bi bi-check-lg"></i> Save Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-secondary w-100 py-2">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
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

        if (price > 0 && discountPrice > 0 && discountPrice < price) {
            const diff = price - discountPrice;
            const percent = (diff / price) * 100;
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

    // =========================================================================
    // PRODUCT OPTIONS & VALUES SELECTION (jQuery)
    // =========================================================================

    // Add selected option from dropdown
    function addSelectedOptionFromDropdown() {
        var optionId = $('#optionPickerSelect').val();

        if (!optionId) {
            $('.select-error').text('Please select an option from the dropdown first.');
            $('#optionPickerSelect').focus();
            return;
        }

        $('.select-error').text('');
        $('#option_card_' + optionId).fadeIn();
        $('#noOptionsNotice').hide();
        $('#optionPickerSelect').val('');
    }

    // Remove option card
    function removeOptionCard(optionId) {
        $('#option_card_' + optionId).fadeOut(function() {
            $('.opt-val-cb-' + optionId).prop('checked', false);
            if ($('.option-card:visible').length === 0) {
                $('#noOptionsNotice').show();
            }
        });
    }

    // Select all values for an option
    function selectAllValues(optionId) {
        $('.opt-val-cb-' + optionId).prop('checked', true);
    }

    // Deselect all values for an option
    function deselectAllValues(optionId) {
        $('.opt-val-cb-' + optionId).prop('checked', false);
    }
</script>
@endsection
