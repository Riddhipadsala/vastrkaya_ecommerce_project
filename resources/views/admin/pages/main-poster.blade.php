@extends('layouts.admin')

@section('title', 'Poster Module - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">

    <!-- Top Bar with Title and Add Button (Matching Category/Main Category Module UI) -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h4 class="h5 fw-bold mb-0 text-heading">Poster Management</h4>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPosterModal">
            <i class="bi bi-plus-lg"></i> Add New Poster
        </button>
    </div>

    <!-- Filter Box (Matching Category/Main Category Module UI) -->
    <div class="card border rounded-2 bg-white mb-3 shadow-none">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label for="filter_poster_id" class="form-label fw-bold font-13 text-secondary mb-1">Poster ID</label>
                    <input type="text" class="form-control form-control-sm" id="filter_poster_id" placeholder="Poster ID">
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

    <!-- Posters Table (Matching Category/Main Category Module UI) -->
    <div class="card border rounded-2 bg-white shadow-none">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr class="text-secondary font-13">
                        <th style="width: 6%;" class="ps-3">Id</th>
                        <th style="width: 18%;">Image</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;" class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody class="postertbl" id="postersTableBody">
                 
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination (Matching Category Module UI) -->
    <div id="pagination" class="d-flex justify-content-end align-items-center gap-2 pt-4">
    </div>

</div>

<!-- ========================================================================
     ADD POSTER MODAL (Matching Category Module UI Structure)
     ======================================================================== -->
<div class="modal fade" id="addPosterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-15 fw-bold text-heading">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Add New Poster
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addPosterForm" onsubmit="addPoster(event)">
                <div class="modal-body p-4">
                    
                    <!-- 1. Poster Picture (Matching Category Image upload box) -->
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Poster Image <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-2 border bg-light bg-opacity-50">
                            <img id="addPosterImgPreview" src=""
                                alt="Preview"
                                style="width: 130px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                            <div class="flex-grow-1">
                                <input type="file" name="image" id="posterPictureInput"
                                    class="form-control form-control-sm" accept="image/*" required
                                    onchange="if(this.files && this.files[0]) { var r = new FileReader(); r.onload = function(e){ document.getElementById('addPosterImgPreview').src = e.target.result; }; r.readAsDataURL(this.files[0]); }">
                                <small class="text-muted font-12 d-block mt-1">Recommended: 1920 &times; 700 px (JPG, PNG or WEBP)</small>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <!-- 6. Status Selection -->
                        <div class="col-6 mb-2">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">Status</label>
                            <select name="status" id="addPosterStatus" class="form-select form-select-sm">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-top bg-light bg-opacity-25 py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg"></i> Save Poster
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- ========================================================================
     EDIT POSTER MODAL (Matching Category Module UI Structure)
     ======================================================================== -->
<div class="modal fade" id="editPosterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-15 fw-bold text-heading">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Poster
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editPosterForm" onsubmit="updatePoster(event)">
                <div class="modal-body p-4">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold font-13 text-secondary mb-1">Poster Image</label>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-2 border bg-light bg-opacity-50">
                            <img id="editPosterImgPreview" src=""
                                alt="Preview"
                                style="width: 130px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                            <div class="flex-grow-1">
                                <input type="file" name="image" id="editPosterPictureInput"
                                    class="form-control form-control-sm" accept="image/*"
                                    onchange="if(this.files && this.files[0]) { var r = new FileReader(); r.onload = function(e){ document.getElementById('editPosterImgPreview').src = e.target.result; }; r.readAsDataURL(this.files[0]); }">
                                <small class="text-muted font-12 d-block mt-1">Leave empty to keep current image</small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6 mb-2">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">Status</label>
                            <select name="status" id="editPosterStatus" class="form-select form-select-sm">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>
                <input type="hidden" id="editPosterId">
                <div class="modal-footer border-top bg-light bg-opacity-25 py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg"></i> Update Poster
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>

        document.addEventListener('DOMContentLoaded',()=> {
            fetchData();
        });

        function fetchData(page=1) {
            let posterId = $('#filter_poster_id').val();
            let row = '';
            axios.get(`/admin/banners?page=${page}&poster_id=${posterId}`)
            .then(res => {
                let posters = res.data.posters.data;
                
                if (posters.length === 0) {
                    row += `
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                    No Main Store Posters found.
                                </td>
                            </tr>
                            `;
                }
                else {
                    posters.forEach((poster, index) => {
                        row += `
                                <tr id="posterRow_${poster.id}" class="poster-data-row" data-id="${poster.id}">
                                    <td class="ps-3 text-secondary fw-semibold font-13">${poster.id}</td>
                                    <td>
                                        <img src="/storage/${poster.image}" 
                                            alt="Festive Heritage Saree" 
                                            style="width: 140px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                                    </td>
                                    <td>
                                        <div class="badge ${poster.status ? 'text-success border-success' : 'text-danger border-danger'} border border-opacity-25 rounded-pill px-2 py-1 font-12">${poster.status ? 'Active' : 'InActive' }</div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-1">
                                            <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded" data-bs-toggle="modal" data-bs-target="#editPosterModal" onclick="editPoster(${poster.id})">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete Poster" onclick="confirmDeleteOption(${poster.id})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        `;
                    });
                }

                document.getElementById('postersTableBody').innerHTML = row;
                renderPagination(res.data.posters);
                
            })
            .catch(err => {
                console.log(err);
            });
        }
        
        function renderPagination(data) {
        
            let html='';
            
            data.links.forEach(function(link) {
                let page = null;

                if(link.url) {
                    page = new URL(link.url).searchParams.get('page');
                }

                html += `
                        <button class="btn ${link.active ? 'btn-primary' : 'btn-outline-primary'}" onclick="fetchData(${page})" ${!link.url ? 'disabled' : ''}>
                            ${link.label}
                        </button>
                    `;
            })
            
            document.getElementById('pagination').innerHTML = html;
        }   

        function addPoster(e) {
            e.preventDefault();

            let formData = new FormData($('#addPosterForm')[0]);
            axios.post('/admin/banners',formData)
            .then(res => {
                if (res.data.success) {
                    fetchData();
                    bootstrap.Modal.getInstance(document.getElementById('addPosterModal'))?.hide();
                }
            })
            .catch(err=> {
                console.log(err);
            })
        }
   
        function editPoster(id) {
            axios.get(`/admin/banners/${id}/edit`)
            .then((res)=> {
                let data = res.data.mainPoster;
                
                document.getElementById('editPosterStatus').value = data.status;
                document.getElementById('editPosterImgPreview').src = `/storage/${data.image}`;
                document.getElementById('editPosterId').value = data.id;    
            })
            .catch((err)=> {

            })
        }

        function updatePoster(e) {
            e.preventDefault();

            let postId = $('#editPosterId').val();
            let formData = new FormData($('#editPosterForm')[0]);
            formData.append('_method', 'PUT');
            axios.post(`/admin/banners/${postId}/update`,formData)
            .then((res)=> {
                if (res.data.success) {
                    fetchData();
                    bootstrap.Modal.getInstance(document.getElementById('editPosterModal'))?.hide();
                }
            })
            .catch((err)=> {
                console.log(err);
            })
        }
            
        function confirmDeleteOption(id) {
            optionIdToDelete = id;
            const modalEl = document.getElementById('deleteConfirmModal');
            const deleteModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            deleteModal.show();
        }


        document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
            if (!optionIdToDelete) return;
            axios.delete(`/admin/banners/${optionIdToDelete}`)
                .then((res) => {
                    if (res.data.success) {
                        const modalEl = document.getElementById('deleteConfirmModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        fetchData();
                        window.showToast?.(res.data.message || 'Main Poster deleted successfully', 'success');
                    }
                })
                .catch((error) => {
                    console.error(error);
                    window.showToast?.('Failed to delete category', 'error');
                });
        });

        function clearFilter() {
            $('#filter_poster_id').val('');
            fetchData();
        }

    </script>
@endsection
