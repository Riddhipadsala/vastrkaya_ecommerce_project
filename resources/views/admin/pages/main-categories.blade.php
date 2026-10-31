@extends('layouts.admin')

@section('title', 'Main Category Module - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">
    <!-- Top Bar with Title and Add Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h4 class="h5 fw-bold mb-0 text-heading">Main Category Management</h4>
            <span class="font-13 text-muted">Organize root divisions like Men, Women, Kids &amp; Accessories</span>
        </div>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addMainCategoryModal">
            <i class="bi bi-plus-lg"></i> Add Main Category
        </button>
    </div>

    <!-- Filter Box -->
    <div class="card border rounded-2 bg-white mb-3 shadow-none">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label for="filter_id" class="form-label fw-bold font-13 text-secondary mb-1">Category ID</label>
                    <input type="text" class="form-control form-control-sm" id="filter_id" placeholder="e.g. 1">
                </div>
                <div class="col-md-5 col-sm-6">
                    <label for="filter_name" class="form-label fw-bold font-13 text-secondary mb-1">Main Category Name</label>
                    <input type="text" class="form-control form-control-sm" id="filter_name" placeholder="Search by name (e.g. Women, Men)">
                </div>
                <div class="col-md-4 col-12 d-flex justify-content-md-end gap-2">
                    <button type="button" onclick="clearFilter()" class="btn btn-sm btn-danger px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1">
                        <i class="bi bi-x-lg"></i> Clear Filter
                    </button>
                    <button type="button" onclick="fetchData()" class="btn btn-sm btn-primary px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Categories Table -->
    <div class="card border rounded-2 bg-white shadow-none">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr class="text-secondary font-13">
                        <th style="width: 10%;" class="ps-3">#</th>
                        <th style="width: 50%;">Main Category Name</th>
                        <th style="width: 25%;">Created At</th>
                        <th style="width: 15%;" class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody id="mainCategoryTableBody">
                    <!-- Populated dynamically via JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========================================================================
     ADD MAIN CATEGORY MODAL
     ======================================================================== -->
<div class="modal fade" id="addMainCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-15 fw-bold text-heading">
                    <i class="bi bi-folder-plus text-primary me-2"></i>Add New Main Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMainCategoryForm" onsubmit="storeMainCategory(event)">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-2">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">
                            Main Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="add_category_name" class="form-control form-control-sm"
                            placeholder="e.g. Men, Women, Kids, Ethnic Wear" required>
                        <small class="text-muted font-12 mt-1 d-block">This acts as the top-level grouping for sub-categories.</small>
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
     EDIT MAIN CATEGORY MODAL
     ======================================================================== -->
<div class="modal fade" id="editMainCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-15 fw-bold text-heading">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Main Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMainCategoryForm" onsubmit="updateMainCategory(event)">
                @csrf
                <input type="hidden" id="edit_category_id">
                <div class="modal-body p-4">
                    <div class="mb-2">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">
                            Main Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="edit_category_name" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light bg-opacity-25 py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteMainCategoryConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow p-2">
            <div class="modal-body text-center p-3">
                <div class="w-12 h-12 rounded-full bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; border-radius: 50%;">
                    <i class="bi bi-exclamation-triangle fs-4"></i>
                </div>
                <h6 class="fw-bold text-heading mb-1">Delete Main Category?</h6>
                <p class="text-muted font-12 mb-3">This action cannot be undone.</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-sm btn-danger px-3" id="confirmDeleteMainCatBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let categoryToDelete = null;

    document.addEventListener('DOMContentLoaded', function () {
        fetchData();
    });

    function fetchData() {
        let filter_id = $('#filter_id').val();
        let filter_name = $('#filter_name').val();

        axios.get('{{ route("admin.main-categories.index") }}', {
            params: {
                id: filter_id,
                name: filter_name
            }
        })
        .then((res) => {
            let categories = res.data.mainCategories || [];
            let html = '';

            if (categories.length === 0) {
                html = `
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="bi bi-folder-x fs-3 d-block mb-1"></i>
                            No main categories found
                        </td>
                    </tr>
                `;
            } else {
                categories.forEach((cat, index) => {
                    let createdDate = cat.created_at ? new Date(cat.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : '-';

                    html += `
                        <tr>
                            <td class="ps-3 text-secondary fw-semibold font-13">${index + 1}</td>
                            <td>
                                <div class="fw-bold text-heading font-14 d-flex align-items-center gap-2">
                                    <span class="w-2 h-2 rounded-circle bg-primary d-inline-block"></span>
                                    <span>${cat.name}</span>
                                </div>
                            </td>
                            <td class="text-secondary font-13">${createdDate}</td>
                            <td class="text-end pe-3">
                                <div class="d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit" onclick="editMainCategory(${cat.id})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete" onclick="confirmDelete(${cat.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#mainCategoryTableBody').html(html);
        })
        .catch((error) => {
            console.error('Error fetching main categories:', error);
            window.showToast?.('Failed to load main categories', 'error');
        });
    }

    function clearFilter() {
        $('#filter_id').val('');
        $('#filter_name').val('');
        fetchData();
    }

    function storeMainCategory(e) {
        e.preventDefault();
        let name = $('#add_category_name').val();

        axios.post('{{ route("admin.main-categories.store") }}', { name: name })
            .then((res) => {
                if (res.data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('addMainCategoryModal'))?.hide();
                    $('#addMainCategoryForm')[0].reset();
                    fetchData();
                    window.showToast?.(res.data.message || 'Saved successfully', 'success');
                }
            })
            .catch((err) => {
                let msg = err.response?.data?.message || 'Failed to save';
                window.showToast?.(msg, 'error');
            });
    }

    function editMainCategory(id) {
        axios.get(`/admin/main-categories/${id}/edit`)
            .then((res) => {
                let cat = res.data.mainCategory;
                $('#edit_category_id').val(cat.id);
                $('#edit_category_name').val(cat.name);
                let modal = new bootstrap.Modal(document.getElementById('editMainCategoryModal'));
                modal.show();
            })
            .catch((err) => {
                window.showToast?.('Failed to fetch details', 'error');
            });
    }

    function updateMainCategory(e) {
        e.preventDefault();
        let id = $('#edit_category_id').val();
        let name = $('#edit_category_name').val();

        axios.put(`/admin/main-categories/${id}`, { name: name })
            .then((res) => {
                if (res.data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editMainCategoryModal'))?.hide();
                    fetchData();
                    window.showToast?.(res.data.message || 'Updated successfully', 'success');
                }
            })
            .catch((err) => {
                let msg = err.response?.data?.message || 'Failed to update';
                window.showToast?.(msg, 'error');
            });
    }

    function confirmDelete(id) {
        categoryToDelete = id;
        let modal = new bootstrap.Modal(document.getElementById('deleteMainCategoryConfirmModal'));
        modal.show();
    }

    document.getElementById('confirmDeleteMainCatBtn')?.addEventListener('click', function () {
        if (!categoryToDelete) return;

        axios.delete(`/admin/main-categories/${categoryToDelete}`)
            .then((res) => {
                if (res.data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('deleteMainCategoryConfirmModal'))?.hide();
                    fetchData();
                    window.showToast?.(res.data.message || 'Deleted successfully', 'success');
                }
            })
            .catch((err) => {
                window.showToast?.('Failed to delete', 'error');
            });
    });
</script>
@endsection

