@extends('layouts.admin')

@section('title', 'Category Module - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">
    <!-- Top Bar with Title and Add Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h4 class="h5 fw-bold mb-0 text-heading">Category Management</h4>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-lg"></i> Add New Category
        </button>
    </div>

    <!-- Filter Box (Matching Product Module UI) -->
    <div class="card border rounded-2 bg-white mb-3 shadow-none">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label for="filter_category_id" class="form-label fw-bold font-13 text-secondary mb-1">Category ID</label>
                    <input type="text" class="form-control form-control-sm" id="filter_category_id" placeholder="Category ID">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label for="filter_category_name" class="form-label fw-bold font-13 text-secondary mb-1">Category Name</label>
                    <input type="text" class="form-control form-control-sm" id="filter_category_name" placeholder="Category Name">
                </div>
                <div class="col-md-5 col-12 d-flex justify-content-md-end gap-2">
                    <button type="button" onclick="clearFilter()" class="btn btn-sm btn-danger px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1" id="btnClearFilter">
                        <i class="bi bi-x-lg"></i> Clear Filter
                    </button>
                    <button type="button" onclick="fetchData()" class="btn btn-sm btn-primary px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1" id="btnFilter">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Table (Matching Product Module UI) -->
    <div class="card border rounded-2 bg-white shadow-none">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr class="text-secondary font-13">
                        <th style="width: 6%;" class="ps-3">#</th>
                        <th style="width: 10%;">Image</th>
                        <th style="width: 20%;">Category Name</th>
                        <th style="width: 18%;">Main Category</th>
                        <th style="width: 26%;">Description</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;" class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody class="categorytbl">

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================================================
     ADD CATEGORY MODAL
     ======================================================================== -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-15 fw-bold text-heading">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Add New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <!-- 1. Category Picture -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Category Image</label>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-2 border bg-light bg-opacity-50">
                            <img id="addCategoryImgPreview" src="https://via.placeholder.com/70x70?text=Preview"
                                alt="Preview"
                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                            <div class="flex-grow-1">
                                <input type="file" name="image" id="categoryPictureInput"
                                    class="form-control form-control-sm" accept="image/*" required
                                    onchange="if(this.files && this.files[0]) { var r = new FileReader(); r.onload = function(e){ document.getElementById('addCategoryImgPreview').src = e.target.result; }; r.readAsDataURL(this.files[0]); }">
                                <small class="text-muted font-12 d-block mt-1">Recommended: JPG, PNG or WEBP (Max 2MB)</small>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Main Category Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Main Category <span class="text-danger">*</span></label>
                        <select name="main_category_id" id="addMainCategoryId" class="form-select form-select-sm" required>
                            <option value="" disabled selected>-- Select Main Category --</option>
                            @foreach ($mainCategories ?? [] as $mainCat)
                                <option value="{{ $mainCat->id }}">{{ $mainCat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Category Title -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm"
                            placeholder="e.g. Sarees, Lehengas, Kurtis" required>
                    </div>

                    <!-- 4. Category Description -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control form-control-sm" rows="3"
                            placeholder="Write a brief overview of this category..." required></textarea>
                    </div>

                    <!-- 5. Category Status -->
                    <div class="mb-2">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light bg-opacity-25 py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================
     EDIT CATEGORY MODAL
     ======================================================================== -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-15 fw-bold text-heading">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" enctype="multipart/form-data" class="formData" onsubmit="updateCategory(event)">
                @csrf
                <div class="modal-body p-4">
                    <!-- 1. Category Picture -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Category Image</label>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-2 border bg-light bg-opacity-50">
                            <img id="editCategoryImgPreview"
                                alt="Preview"
                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                            <div class="flex-grow-1">
                                <input type="file" name="image" id="editCategoryImg"
                                    class="form-control form-control-sm" accept="image/*"
                                    onchange="if(this.files && this.files[0]) { var r = new FileReader(); r.onload = function(e){ document.getElementById('editCategoryImgPreview').src = e.target.result; }; r.readAsDataURL(this.files[0]); }">
                                <small class="text-muted font-12 d-block mt-1">Leave empty to keep current image</small>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Main Category Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Main Category <span class="text-danger">*</span></label>
                        <select name="main_category_id" id="editMainCategoryId" class="form-select form-select-sm" required>
                            <option value="" disabled>-- Select Main Category --</option>
                            @foreach ($mainCategories ?? [] as $mainCat)
                                <option value="{{ $mainCat->id }}">{{ $mainCat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Category Title -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="editCategoryTitle" class="form-control form-control-sm" required>
                    </div>

                    <!-- 4. Category Description -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Description</label>
                        <textarea name="description" id="editCategoryDescription" class="form-control form-control-sm" rows="3"></textarea>
                    </div>

                    <!-- 5. Category Status -->
                    <div class="mb-2">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Status</label>
                        <select name="status" id="editCategoryStatus" class="form-select form-select-sm">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light bg-opacity-25 py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <input type="hidden" class="update-id">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let optionIdToDelete = null;

    document.addEventListener('DOMContentLoaded', function() {
        fetchData();
    });

    function fetchData() {
        let filter_id = $('#filter_category_id').val();
        let filter_name = $('#filter_category_name').val();

        axios.get('/admin/categories', {
            params: {
                id: filter_id,
                name: filter_name
            }
        })
        .then((res) => {
            let categories = res.data.categories;
            let data = '';

            if (categories.length === 0) {
                data = `
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                            No categories found
                        </td>
                    </tr>
                `;
            } else {
                categories.forEach((e, index) => {
                    let mainCatName = e.main_category ? e.main_category.name : '-';
                    data += `
                        <tr>
                            <td class="ps-3 text-secondary fw-semibold font-13">${index + 1}</td>
                            <td>
                                <img src="/storage/${e.image}" 
                                    alt="${e.name}" 
                                    style="width: 70px; height: 70px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                            </td>
                            <td>
                                <div class="fw-semibold text-heading font-14">${e.name}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border font-12 px-2.5 py-1 rounded-pill">
                                    <i class="bi bi-diagram-3 me-1 text-primary"></i>${mainCatName}
                                </span>
                            </td>
                            <td class="text-secondary font-13">${e.description || '-'}</td>
                            <td>
                                <span class="badge ${e.status === 1 ? 'text-success border-success' : 'text-danger border-danger'} border border-opacity-25 rounded-pill px-2 py-1 font-12">
                                    ${e.status === 1 ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit Category" data-bs-toggle="modal" data-bs-target="#editCategoryModal" onclick="editCategory(${e.id})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete Category" onclick="confirmDeleteOption(${e.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            $('.categorytbl').html(data);
        })
        .catch((error) => {
            console.error(error);
        });
    }

    function clearFilter() {
        $('#filter_category_id').val('');
        $('#filter_category_name').val('');
        fetchData();
    }

    function editCategory(id) {
        axios.get(`/admin/categories/${id}/edit`)
            .then((res) => {
                let cat = res.data.category;
                $('#editCategoryImgPreview').attr('src', `/storage/${cat.image}`);
                $('#editMainCategoryId').val(cat.main_category_id || '');
                $('#editCategoryTitle').val(cat.name);
                $('#editCategoryDescription').val(cat.description);
                $('#editCategoryStatus').val(cat.status); 
                $('.update-id').val(cat.id); 
            })
            .catch((err) => {
                window.showToast?.('Failed to edit category', 'error');
            });
    }

    function updateCategory(e) {
        e.preventDefault();

        let id = $('.update-id').val();
        let form = $('.formData')[0];
        let formData = new FormData(form);
        formData.append('_method', 'PUT');

        axios.post(`/admin/categories/${id}`, formData)
            .then((res) => {
                const editModalEl = document.getElementById('editCategoryModal');
                const modal = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
                modal.hide();

                if (res.data.success) {
                    fetchData();
                    window.showToast?.('Category updated successfully', 'success');
                } else {
                    window.showToast?.('Failed to update category', 'error');
                }
            })
            .catch((err) => {
                console.error(err);
                window.showToast?.('Failed to update category', 'error');
            });
    }

    function confirmDeleteOption(id) {
        optionIdToDelete = id;
        const modalEl = document.getElementById('deleteConfirmModal');
        const deleteModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
        if (!optionIdToDelete) return;
        axios.delete(`/admin/categories/${optionIdToDelete}`)
            .then((res) => {
                if (res.data.success) {
                    const modalEl = document.getElementById('deleteConfirmModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    fetchData();
                    window.showToast?.(res.data.message || 'Category deleted successfully', 'success');
                }
            })
            .catch((error) => {
                console.error(error);
                window.showToast?.('Failed to delete category', 'error');
            });
    });
</script>
@endsection
