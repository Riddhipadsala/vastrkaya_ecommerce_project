@extends('layouts.admin')

@section('title', 'Option Module - Vastrkaya Luxury E-Commerce')

@section('content')
    <div class="vk-card mb-4">
        <!-- Header (Matching Category & Product Header style) -->
        <div class="vk-card-header flex-wrap gap-3">
            <div>
                <h4 class="h5 fw-bold mb-1 text-heading">Option & Variant Attributes Management</h4>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('admin.options.create') }}" class="vk-btn vk-btn-info">
                    <i class="bi bi-plus-lg"></i> Add New Option
                </a>
            </div>
        </div>

        <!-- Option Stats Strip -->
        <div class="row g-3 text-center justify-content-end mt-2">
            <div class="col-sm-3 col-6 border-end border-light">
                <div class="text-muted font-13 fw-semibold">Total Options</div>
                <div class="h5 fw-bold mb-0 text-heading" id="totalOptionsCount">
                </div>
            </div>

            <div class="col-sm-3 col-6 border-end border-light">
                <div class="text-muted font-13 fw-semibold">Total Values</div>
                <div class="h5 fw-bold mb-0 text-primary" id="totalValuesCount">
                </div>
            </div>
        </div>


        <!-- Search Toolbar -->
        <div class="p-3 border-bottom border-light bg-surface-subtle d-flex flex-wrap justify-content-between align-items-center gap-3">
            <form action="{{ route('admin.options.index') }}" method="GET"
                class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 420px;">
                <div class="input-group">
                    <span class="input-group-text bg-surface border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control vk-form-control border-start-0 search" placeholder="Search option or value (e.g. Size, Colour, S, Red)..." onkeyup="fetchData()">
                </div>
            </form>
        </div>

        <!-- Options Table (Layout matching Category & Product module) -->
        <div class="vk-table-responsive">
            <table class="vk-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">ID</th>
                        <th style="width: 200px;">Option Name</th>
                        <th>Configured Values</th>
                        <th style="width: 130px;">Total Values</th>
                        <th style="width: 120px;">Short Order</th>
                        <th class="text-end" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="optionstbl">
                   
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            fetchData();
        })

        function fetchData(){
            
            let optionstbl = document.querySelector('.optionstbl');

            let searchData = $('.search').val();

            axios.get('/admin/options',{
                    params: {
                        search: searchData
                    }
                })
                .then(res=> {

                    $('#totalOptionsCount').text(res.data.options.length +'  Configured');
                    $('#totalValuesCount').text(res.data.options.reduce((total, option) => total + option.option_values.length, 0) +' Values');
                    
                    let data = '';

                    if(res.data.options && res.data.options.length > 0){
                        res.data.options.forEach((o,index) => {
                            data += `
                                <tr class="option-row" data-name="${o.name}">
                                <td><strong>${index +1}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div>
                                            <div class="fw-bold text-heading text-capitalize">${o.name}</div>
                                            <small class="text-muted"><span class="fw-bold">Type: </span>${o.type || ''}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1 align-items-center">
                                        ${(o.option_values || []).map(ov => {
                                                return `<span class="badge bg-opacity-10 text-dark fs-6 fw-semibold px-2 py-1 text-uppercase option-value">${ov.name}</span>`;
                                            }).join(' ')}
                                    </div>
                                </td>
                                <td><span class="badge bg-light text-dark border">${(o.option_values || []).length} Values</span></td>
                                <td class="align-middle">
                                    <span class="badge bg-success rounded-pill px-3 py-2">${o.sort_order ?? 0}</span>
                                </td>
                                <td class="text-end">
                                    <a href="/admin/options/${o.id}/edit" class="btn btn-sm btn-primary ms-1" title="Edit Option">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger ms-1" title="Delete Option" onclick="confirmDeleteOption(${o.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    } else {
                        data = `<tr><td colspan="6" class="text-center text-muted py-4"><i class="bi bi-inbox fs-3 d-block mb-1"></i>No options configured yet.</td></tr>`;
                    }
                    
                    $('.optionstbl').html(data); 

                    if (res.data.totalOptionsCount !== undefined) {
                        $('#totalOptionsCount').text(`${res.data.totalOptionsCount} Configured`);
                    }
                    if (res.data.totalValuesCount !== undefined) {
                        $('#totalValuesCount').text(`${res.data.totalValuesCount} Values`);
                    } 

                })
                .catch(err=> {
                    console.log(err);
                    window.showToast?.('failed some internal error','error');
                })    
        }
        
        let optionIdToDelete = null;

        // Open Delete Confirmation Modal
        function confirmDeleteOption(id) {
            optionIdToDelete = id;
            const modalEl = document.getElementById('deleteConfirmModal');
            const deleteModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            deleteModal.show();
        }

        // Handle confirmed deletion
        document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
            if (!optionIdToDelete) return;

            axios.delete(`/admin/options/${optionIdToDelete}`)
                .then(res => {
                    if (res.data.success) {
                        const modalEl = document.getElementById('deleteConfirmModal');
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        fetchData();
                        window.showToast?.(res.data.message || 'Option deleted successfully', 'success');
                    }
                })
                .catch(err => {
                    console.error(err);
                    window.showToast?.('Failed to delete option due to an internal error', 'error');
                })
               
        });

    </script>
@endsection
