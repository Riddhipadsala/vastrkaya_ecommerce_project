@extends('layouts.admin')

@section('title', 'Create Option & Add Values - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="vk-card mb-4">
        <div class="vk-card-header flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <h4 class="h5 fw-bold mb-0 text-heading">Create New Option & Add Values</h4>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.options.index') }}" class="vk-btn vk-btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back To Option
                </a>
            </div>
        </div>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" id="createOptionForm">
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
                           placeholder="e.g. Size, Colour, Fabric" 
                           required>
                </div>

                <!-- Option Type (options.type) -->
                <div class="col-md-4">
                    <label class="vk-form-label fw-bold">Option Type <span class="text-danger">*</span></label>
                    <select name="type" id="input-type" class="form-control select-type">
                        <optgroup label="Choose">
                            <option value="select" selected="">Select</option>
                            <option value="radio">Radio</option>
                            <option value="checkbox">Checkbox</option>
                        </optgroup>

                        <optgroup label="Input">
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="json">Json</option>
                        </optgroup>
                        
                        <optgroup label="File">
                            <option value="file">File</option>
                        </optgroup>

                        <optgroup label="Date">
                            <option value="date">Date</option>
                            <option value="time">Time</option>
                            <option value="datetime">Date &amp; Time</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Sort Order (options.sort_order) -->
                <div class="col-md-3">
                    <label class="vk-form-label fw-bold">Sort Order <span class="text-danger">*</span></label>
                    <input type="number" 
                           name="sort_order" 
                           id="optionSortOrder" 
                           class="vk-form-control" 
                           value="0" 
                           min="0" 
                           required>
                </div>
            </div>
        </div>

        <!-- 2. Option Values List Card -->
        <div class="vk-card p-4 mb-4"  id='option-value'>
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom border-light">
                <div>
                    <h5 class="fw-bold text-heading font-15 mb-0">
                        <i class="bi bi-list-check text-primary me-2"></i>Option Values List
                    </h5>
                </div>
                <button type="button" class="btn btn-sm btn-primary add-btn" onclick="addOptionValueRow()">
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
                            <th style="min-width: 220px;">Option Picture </th>
                            <th style="width: 140px;">Sort Order</th>
                            <th class="text-end" style="width: 90px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="optionValuesTbody">
                        <!-- Dynamic rows appended by JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div id="noValuesAlert" class="p-4 text-center bg-surface-subtle rounded-3 border border-dashed border-secondary border-opacity-25 mt-2 d-none">
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
            <button type="button" class="btn btn-sm btn-primary" onclick="submitOptionForm(event)">
                <i class="bi bi-check-lg"></i> Save Option & All Values
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let rowIndex = 0;

document.getElementById('input-type').addEventListener('change', function() {
    let value = this.value;
    if(value != 'radio' && value != 'checkbox' && value != 'select') {
        document.getElementById('option-value').style.display = 'none'
    }
    else {
        $('#option-value').show();
    }
});

    document.addEventListener('DOMContentLoaded', function() {
    });

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
        
        emptyAlert.classList.add('d-none');

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
            emptyAlert.classList.remove('d-none');
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
                numCell.textContent = idx + 1;
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

    // Form submit validation & demonstration
    function submitOptionForm(e) {
        e.preventDefault();
        
        const optionName = (document.getElementById('optionName').value || '').trim();
        if (!optionName) {
            if (window.showToast) {
                window.showToast('Please enter the Option Name', 'error');
            } else {
                alert('Please enter the Option Name');
            }
            document.getElementById('optionName').focus();
            return;
        }

        const rows = document.querySelectorAll('.option-value-row');
        if (rows.length === 0) {
            if (window.showToast) {
                window.showToast('Please add at least one Option Value', 'error');
                return;
            } else {
                alert('Please add at least one Option Value');
            }
            return;
        }

        let form = $('#createOptionForm');
        let formData = new FormData(form[0]);

        axios.post(`/admin/options`,formData)
            .then((res) => {
                window.showToast(res.message,'success');
                window.location.href = `{{ route('admin.options.index') }}`;
            }).catch((err) => {
                window.showToast(err.response.data.message,'error');
            })
    }
</script>
@endsection
