@extends('layouts.admin')

@section('title', 'Category Module - Vastrkaya Luxury E-Commerce')

@section('content')
    <div class="vk-card mb-4">
        <!-- Header -->
        <div class="vk-card-header flex-wrap gap-3">
            <div>
                <h4 class="h5 fw-bold mb-1 text-heading">Category Management</h4>
                <p class="font-13 text-muted mb-0">Manage store categories with picture, title, and description</p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <button type="button" class="vk-btn vk-btn-info" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-lg"></i> Add Category
                </button>
            </div>
        </div>

        <!-- Search Toolbar -->
        <div
            class="p-3 border-bottom border-light bg-surface-subtle d-flex flex-wrap justify-content-between align-items-center gap-3">
            <form action="{{ route('admin.categories.index') }}" method="GET"
                class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 420px;">
                <div class="input-group">
                    <span class="input-group-text bg-surface border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control vk-form-control border-start-0 search" placeholder="Search by title..." onkeyup="fetchData()">
                </div>
            </form>
        </div>

        <!-- Categories Table (Picture, Title, Description, Actions) -->
        <div class="vk-table-responsive">
            <table class="vk-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Picture</th>
                        <th style="width: 220px;">Category Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="categorytbl">

                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================================================
         ADD CATEGORY MODAL (Picture, Title, Description)
         ======================================================================== -->
    <div class="modal fade vk-modal" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-image text-danger me-2"></i>Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- 1. Category Picture -->
                        <div class="mb-3">
                            <label class="vk-form-label">Category Picture</label>
                            <div
                                class="d-flex align-items-center gap-3 p-3 rounded-3 border border-dashed border-secondary border-opacity-25 bg-surface-subtle">
                                <div class="position-relative">
                                    <img id="addCategoryImgPreview" src="https://via.placeholder.com/120x120?text=Preview"
                                        alt="Preview"
                                        style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid var(--vk-border);">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image" id="categoryPictureInput"
                                        class="form-control vk-form-control form-control-sm" accept="image/*"
                                        onchange="if(this.files && this.files[0]) { var r = new FileReader(); r.onload = function(e){ document.getElementById('addCategoryImgPreview').src = e.target.result; }; r.readAsDataURL(this.files[0]); }">
                                    <small class="text-muted font-12 d-block mt-1">Recommended: JPG, PNG or WEBP (Max
                                        2MB)</small>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Category Title -->
                        <div class="mb-3">
                            <label class="vk-form-label">Category Title</label>
                            <input type="text" name="name" class="vk-form-control"
                                placeholder="e.g. Sarees, Lehengas, Kurtis" required>
                        </div>

                        <!-- 3. Category Description -->
                        <div class="mb-3">
                            <label class="vk-form-label">Category Description</label>
                            <textarea name="description" class="vk-form-control" rows="3"
                                placeholder="Write a brief overview of this category..."></textarea>
                        </div>

                        <!-- 4. Category Status -->
                        <div class="mb-3">
                            <label class="vk-form-label">Status</label>
                            <select name="status" class="vk-form-select">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="vk-btn vk-btn-primary">
                            <i class="bi bi-check-lg"></i> Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         EDIT CATEGORY MODAL (Picture, Title, Description)
         ======================================================================== -->
    <div class="modal fade vk-modal" id="editCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square text-danger me-2"></i>Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data" class="formData" onsubmit="updateCategory(event)">
                    @csrf
                    <div class="modal-body">
                        <!-- 1. Category Picture -->
                        <div class="mb-3">
                            <label class="vk-form-label">Category Picture</label>
                            <div
                                class="d-flex align-items-center gap-3 p-3 rounded-3 border border-dashed border-secondary border-opacity-25 bg-surface-subtle">
                                <div class="position-relative">
                                    <img id="editCategoryImgPreview"
                                        alt="Preview"
                                        style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid var(--vk-border);">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image" id="editCategoryImg"
                                        class="form-control vk-form-control form-control-sm" >
                                    <small class="text-muted font-12 d-block mt-1">Leave empty to keep current
                                        picture</small>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Category Title -->
                        <div class="mb-3">
                            <label class="vk-form-label">Category Title</label>
                            <input type="text" name="name" id="editCategoryTitle" class="vk-form-control" value="" required>
                        </div>

                        <!-- 3. Category Description -->
                        <div class="mb-3">
                            <label class="vk-form-label">Category Description</label>
                            <textarea name="description" id="editCategoryDescription" class="vk-form-control" rows="3"></textarea>
                        </div>

                        <!-- 4. Category Status -->
                        <div class="mb-3">
                            <label class="vk-form-label">Status</label>
                            <select name="status" id="editCategoryStatus" class="vk-form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input type="hidden" class="update-id">
                        <button type="submit" class="vk-btn vk-btn-primary">
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
        document.addEventListener('DOMContentLoaded', function() {
            fetchData();
        });

        function fetchData() {

            let searchData = $('.search').val();

            axios.get('/admin/categories',
                { params : {
                                search: searchData
                            }
                })
                .then((res) => {
                    let categories = res.data.categories;
                    let data = '';
                    categories.forEach((e) => {
                        data +=
                            `
                        <tr>
                            <td>
                                <img src="/storage/${e.image}" 
                                    alt="${e.name}" 
                                    style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px;">
                            </td>
                            <td>${e.name}</td>
                            <td>${e.description}</td>
                            <td class="align-middle">
                                <span class="badge ${e.status === 'active' ? 'bg-success' : 'bg-danger'} rounded-pill px-3 py-3">
                                    ${e.status === 'active' ? 'Active' : 'In Active'}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal" onclick="editCategory(${e.id})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="confirmDeleteOption(${e.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    });

                    $('.categorytbl').html(data);

                })
                .catch((error) => {
                    console.error(error);
                })
        }

        function editCategory(id) {
            axios.get(`/admin/categories/${id}/edit`)
                .then((res)=> {
                    $('#editCategoryImgPreview').attr('src',`/storage/${res.data.category.image}`);
                    $('#editCategoryTitle').val(res.data.category.name);
                    $('#editCategoryDescription').val(res.data.category.description);
                    $('#editCategoryStatus').val(res.data.category.status); 
                    $('.update-id').val(res.data.category.id); 
                    
                })
                .catch((err)=> {
                    window.showToast('Failed to edit category','error');
                })
        }

        function updateCategory(e) {
            e.preventDefault();

            let id = $('.update-id').val();

            let form = $('.formData')[0];

            let formData = new FormData(form);
            formData.append('_method', 'PUT');
            axios.post(`/admin/categories/${id}`, formData)
                .then((res)=> {

                    const editModalEl = document.getElementById('editCategoryModal');
                    const modal = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
                    modal.hide();

                    if(res.data.success) {
                        fetchData();
                        window.showToast('Category updated successfully','success');
                    }
                    else {
                        window.showToast('Failed to update category','error');
                    }
                })
                .catch((err)=> {
                    console.error(err);
                    window.showToast('Failed to update category','error');
                })
        }

        // Open Delete Confirmation Modal
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
                    window.showToast('Failed to delete category','error');
                })
        });
        
    </script>
@endsection
