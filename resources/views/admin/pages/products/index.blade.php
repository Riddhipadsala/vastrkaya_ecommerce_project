@extends('layouts.admin')

@section('title', 'Product Module - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">
    <!-- Top Bar with Title and Add Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h4 class="h5 fw-bold mb-0 text-heading">Product Management</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Product
        </a>
    </div>

    <!-- Filter Box (Matching Option Module UI) -->
    <div class="card border rounded-2 bg-white mb-3 shadow-none">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label for="filter_product_id" class="form-label fw-bold font-13 text-secondary mb-1">Product ID</label>
                    <input type="text" class="form-control form-control-sm" id="filter_product_id" placeholder="Product ID">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label for="filter_product_name" class="form-label fw-bold font-13 text-secondary mb-1">Product Name</label>
                    <input type="text" class="form-control form-control-sm" id="filter_product_name" placeholder="Product Name">
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

    <!-- Products Table (Matching Option Module UI) -->
    <div class="card border rounded-2 bg-white shadow-none">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr class="text-secondary font-13">
                        <th style="width: 10%;" class="ps-3">ProductID</th>
                        <th style="width: 10%;">Image</th>
                        <th style="width: 25%;">Product Name</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 12%;">Price</th>
                        <th style="width: 10%;">Stock</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 8%;" class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody class="productstbl">
                
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetchData();
    });

    function fetchData() {

        let filter_id = $('#filter_product_id').val();
        let filter_name = $('#filter_product_name').val();

        let data = '';

        axios.get('/admin/products', {
            params: {
                'id':filter_id,
                'name':filter_name
            }
        })
        .then((res)=> {
            res.data.products.forEach((product,index)=> {
                data += `    
                    <tr>
                        <td class="ps-3 text-secondary fw-semibold font-13">${index+1}</td>
                        <td>
                            <img src="/storage/${product.image}" 
                                alt="Royal Banarasi Silk Saree" 
                                style="width: 70px; height:70px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(0,0,0,0.08);">
                        </td>
                        <td>
                            <div class="fw-semibold text-heading font-14">${product.name}</div>
                            <small class="text-muted font-12">${product.brand}</small>
                        </td>
                        <td class="text-secondary font-13">${product.category.name}</td>
                        <td><span class="fw-bold text-heading">&#8377;${product.price}</span></td>
                        <td><span class="badge text-dark px-2 py-1 font-12">${product.stock}</span></td>
                        <td>
                            <span class="badge text-${product.status ? 'success' : 'danger'} border border-${product.status ? 'success' : 'danger'} border-opacity-25 rounded-pill px-2 py-1 font-12">
                                ${product.status ? 'Active' : 'Inactive'}
                            </span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-inline-flex gap-1">
                                <a href="/admin/products/${product.id}/edit" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit Product">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete Product" onclick="confirmDeleteOption(${product.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>`
                ;
            })
            $('.productstbl').html(data);
        })
        .catch((err)=> {

        })
    } 

    function clearFilter(){
        $('#filter_product_id').val('');
        $('#filter_product_name').val('');
        fetchData();
    }

    function confirmDeleteOption(id) {
        optionIdToDelete = id;
        const modalEl = document.getElementById('deleteConfirmModal');
        const deleteModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
        if (!optionIdToDelete) return;
        axios.delete(`/admin/products/${optionIdToDelete}`)
            .then((res) => {
                if (res.data.success) {
                    const modalEl = document.getElementById('deleteConfirmModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    fetchData();
                    window.showToast?.(res.data.message || 'Product deleted successfully', 'success');
                }
            })
            .catch((error) => {
                console.error(error);
                window.showToast?.('Failed to delete product', 'error');
            });
    });

</script>
@endsection
