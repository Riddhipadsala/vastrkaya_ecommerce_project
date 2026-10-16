@extends('layouts.admin')

@section('title', 'Edit Option & Values - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="vk-card mb-4">
        <div class="vk-card-header flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h4 class="h5 fw-bold mb-0 text-heading">Edit Option & Values</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.options.index') }}" class="vk-btn vk-btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Options
                </a>
                <button type="button" class="btn btn-info" onclick="location.reload()">
                    Refresh Page
                </button>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.options.update', $option->id) }}" method="POST" enctype="multipart/form-data" id="editOptionForm">
        @csrf
        @method('PUT')

        <!-- 1. Option Information Card -->
        <div class="vk-card p-4 mb-4">
            <h5 class="fw-bold text-heading font-15 mb-3 pb-2 border-bottom border-light">
                <i class="bi bi-sliders2 text-primary me-2"></i>Option Information
            </h5>

            <div class="row g-3">
                <!-- Option Name (options.name) -->
                <div class="col-md-5">
                    <label class="vk-form-label fw-bold">Option Name <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="name" 
                           id="optionName" 
                           class="vk-form-control" 
                           value="{{ old('name', $option->name) }}" 
                           placeholder="e.g. Size, Colour, Fabric" 
                           required>
                </div>

                <!-- Option Type (options.type) -->
                <div class="col-md-4">
                    <label class="vk-form-label fw-bold">Option Type <span class="text-danger">*</span></label>
                    <select name="type" id="input-type" class="form-control select-type">
                        <optgroup label="Choose">
                            <option value="select" {{ old('type', $option->type) == 'select' ? 'selected' : '' }}>Select</option>
                            <option value="radio" {{ old('type', $option->type) == 'radio' ? 'selected' : '' }}>Radio</option>
                            <option value="checkbox" {{ old('type', $option->type) == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                        </optgroup>

                        <optgroup label="Input">
                            <option value="text" {{ old('type', $option->type) == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="textarea" {{ old('type', $option->type) == 'textarea' ? 'selected' : '' }}>Textarea</option>
                            <option value="json" {{ old('type', $option->type) == 'json' ? 'selected' : '' }}>Json</option>
                        </optgroup>

                        <optgroup label="File">
                            <option value="file" {{ old('type', $option->type) == 'file' ? 'selected' : '' }}>File</option>
                        </optgroup>

                        <optgroup label="Date">
                            <option value="date" {{ old('type', $option->type) == 'date' ? 'selected' : '' }}>Date</option>
                            <option value="time" {{ old('type', $option->type) == 'time' ? 'selected' : '' }}>Time</option>
                            <option value="datetime" {{ old('type', $option->type) == 'datetime' ? 'selected' : '' }}>Date &amp; Time</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Sort Order (options.sort_order) -->
                <div class="col-md-3">
                    <label class="vk-form-label fw-bold">Sort Order</label>
                    <input type="number" 
                           name="sort_order" 
                           id="optionSortOrder" 
                           class="vk-form-control" 
                           value="{{ old('sort_order', $option->sort_order ?? 0) }}" 
                           min="0">
                </div>
            </div>
        </div>

        <div class="vk-card p-4 mb-4" id="option-value">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom border-light">
                    <div>
                        <h5 class="fw-bold text-heading font-15 mb-0">
                            <i class="bi bi-list-check text-primary me-2"></i>Option Values List
                        </h5>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" onclick="addOptionValueRow()">
                        <i class="bi bi-plus-lg"></i> Add Value Row
                    </button>
                </div>

                <!-- Values Table -->
                <div class="vk-table-responsive">
                    <table class="vk-table" id="optionValuesTable">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th style="min-width: 200px;">Value Name <span class="text-danger">*</span></th>
                                <th style="min-width: 220px;">Option Picture / Swatch</th>
                                <th style="width: 140px;">Sort Order</th>
                                <th class="text-end" style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="optionValuesTbody">
                            @forelse($option->optionValues as $idx => $val)
                                <tr class="option-value-row" id="row-{{ $idx + 1 }}">
                                    <td class="align-middle text-muted fw-bold row-number">
                                        {{ $idx + 1 }}
                                        <!-- Hidden value ID for existing record -->
                                        <input type="hidden" name="option_values[{{ $idx + 1 }}][id]" value="{{ $val->id }}">
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" 
                                            name="option_values[{{ $idx + 1 }}][name]" 
                                            class="vk-form-control form-control-sm value-name-{{ $idx + 1 }}" 
                                            value="{{ $val->name }}" 
                                            placeholder="e.g. Red, XL, Pure Silk" 
                                            required>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center gap-2">
                                            @php
                                                $imgSrc = $val->option_image ? asset('storage/' . $val->option_image) : 'https://via.placeholder.com/40x40?text=Img';
                                            @endphp
                                            <img id="preview-{{ $idx + 1 }}" 
                                                src="{{ $imgSrc }}" 
                                                alt="{{ $val->name }}" 
                                                style="width: 36px; height: 36px; object-fit: cover; border-radius: 8px; border: 1px solid var(--vk-border); flex-shrink: 0;">
                                            <input type="file" 
                                                name="option_values[{{ $idx + 1 }}][option_image]" 
                                                class="form-control vk-form-control form-control-sm" 
                                                accept="image/*"
                                                onchange="previewRowImage(this, 'preview-{{ $idx + 1 }}')">
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <input type="number" 
                                            name="option_values[{{ $idx + 1 }}][sort_order]" 
                                            class="vk-form-control form-control-sm" 
                                            value="{{ $val->sort_order ?? ($idx + 1) }}" 
                                            min="0">
                                    </td>
                                    <td class="align-middle text-end">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger p-1 rounded-2" 
                                                title="Remove Value" 
                                                onclick="removeOptionValueRow('{{ $idx + 1 }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <!-- Empty row will be inserted if no values -->
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="noValuesAlert" class="p-4 text-center bg-surface-subtle rounded-3 border border-dashed border-secondary border-opacity-25 mt-2 {{ count($option->optionValues) > 0 ? 'd-none' : '' }}">
                    <i class="bi bi-inbox fs-2 text-muted"></i>
                    <p class="text-muted font-13 mt-2 mb-2">No option values added yet.</p>
                    <button type="button" class="vk-btn vk-btn-sm vk-btn-primary" onclick="addOptionValueRow()">
                        <i class="bi bi-plus-lg"></i> Add First Value Row
                    </button>
                </div>
        </div>

        <!-- Bottom Actions -->
        <div class="d-flex justify-content-end gap-2 mb-5">
            <a href="{{ route('admin.options.index') }}" class="vk-btn vk-btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-sm btn-primary" onclick="return validateOptionForm()">
                <i class="bi bi-check-lg"></i> Update Option & All Values
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let rowIndex = {{ count($option->optionValues) }};

    // Toggle values list visibility depending on selected type
    const inputTypeSelect = document.getElementById('input-type');

    document.addEventListener('DOMContentLoaded', function() {
        showOrHideValueCard();
    });

    function showOrHideValueCard() {   
        let val = inputTypeSelect.value;
        const valuesCard = document.getElementById('option-value');
        if (val !== 'radio' && val !== 'checkbox' && val !== 'select') {
            valuesCard.style.display = 'none';
        } else {
            valuesCard.style.display = 'block';
        }
    }

    inputTypeSelect.addEventListener('change', showOrHideValueCard);

    // Add a new row to the table
    function addOptionValueRow(name = '', sortOrder = null) {
        
        if(rowIndex != 0) {
            if($(`.value-name-${rowIndex}`).val().trim() == ''){
                window.showToast('Please provide previous row value', 'error');
                $(`.value-name-${rowIndex}`).focus();
                return;
            }
        }

        rowIndex++;

        const tbody = document.getElementById('optionValuesTbody');
        const emptyAlert = document.getElementById('noValuesAlert');

        if (emptyAlert) {
            emptyAlert.classList.add('d-none');
        }

        const orderVal = sortOrder !== null ? sortOrder : rowIndex;

        const tr = document.createElement('tr');
        tr.className = 'option-value-row';
        tr.id = `row-${rowIndex}`;

        tr.innerHTML = `
            <td class="align-middle text-muted fw-bold row-number">
                ${tbody.children.length + 1}
            </td>
            <td class="align-middle">
                <input type="text" 
                       name="option_values[${rowIndex}][name]" 
                       class="vk-form-control form-control-sm value-name-${rowIndex}" 
                       value="${name}" 
                       placeholder="e.g. Red, XL, Pure Silk" 
                       required>
            </td>
            <td class="align-middle">
                <div class="d-flex align-items-center gap-2">
                    <img id="preview-${rowIndex}" 
                         src="https://via.placeholder.com/40x40?text=Img" 
                         alt="Preview" 
                         style="width: 36px; height: 36px; object-fit: cover; border-radius: 8px; border: 1px solid var(--vk-border); flex-shrink: 0;">
                    <input type="file" 
                           name="option_values[${rowIndex}][option_image]" 
                           class="form-control vk-form-control form-control-sm" 
                           accept="image/*"
                           onchange="previewRowImage(this, 'preview-${rowIndex}')">
                </div>
            </td>
            <td class="align-middle">
                <input type="number" 
                       name="option_values[${rowIndex}][sort_order]" 
                       class="vk-form-control form-control-sm" 
                       value="${orderVal}" 
                       min="0">
            </td>
            <td class="align-middle text-end">
                <button type="button" 
                        class="btn btn-sm btn-outline-danger p-1 rounded-2" 
                        title="Remove Value" 
                        onclick="removeOptionValueRow('${rowIndex}')">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        updateRowNumbers();
    }

    // Remove row
    function removeOptionValueRow(id) {
        const row = document.getElementById(`row-${id}`);
        if (row) {
            row.remove();
        }

        const tbody = document.getElementById('optionValuesTbody');
        const emptyAlert = document.getElementById('noValuesAlert');

        if (tbody.children.length === 0) {
            if (emptyAlert) {
                emptyAlert.classList.remove('d-none');
            }
        } else {
            updateRowNumbers();
        }
    }

    // Update row numbers (#1, #2, #3...)
    function updateRowNumbers() {
        const tbody = document.getElementById('optionValuesTbody');
        const rows = tbody.querySelectorAll('.option-value-row');
        rows.forEach((row, idx) => {
            const numCell = row.querySelector('.row-number');
            if (numCell) {
                const hiddenInput = numCell.querySelector('input[type="hidden"]');
                numCell.innerHTML = `${idx + 1}`;
                if (hiddenInput) {
                    numCell.appendChild(hiddenInput);
                }
            }
        });
    }

    // Live image preview for row
    function previewRowImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(previewId);
                if (img) {
                    img.src = e.target.result;
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Client-side form validation before submitting
    function validateOptionForm() {
        const optionName = (document.getElementById('optionName').value || '').trim();
        if (!optionName) {
            if (window.showToast) {
                window.showToast('Please enter the Option Name', 'error');
            } else {
                alert('Please enter the Option Name');
            }
            document.getElementById('optionName').focus();
            return false;
        }

        const typeVal = document.getElementById('input-type').value;
        const requiresValues = (typeVal === 'radio' || typeVal === 'checkbox' || typeVal === 'select');

        const rows = document.querySelectorAll('.option-value-row');
        if (requiresValues && rows.length === 0) {
            if (window.showToast) {
                window.showToast('Please add at least one Option Value', 'error');
            } else {
                alert('Please add at least one Option Value');
            }
            return false;
        }

        return true;
    }
</script>
@endsection
