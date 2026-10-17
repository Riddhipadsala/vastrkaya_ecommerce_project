@extends('layouts.admin')

@section('title', 'Option Module - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">
    <!-- Top Bar with Title and Add Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h4 class="h5 fw-bold mb-0 text-heading">Option Attributes</h4>
        <a href="{{ route('admin.options.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Option
        </a>
    </div>

    <!-- Filter Box (Matching UI in Picture) -->
    <div class="card border rounded-2 bg-white mb-3 shadow-none">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label for="filter_option_id" class="form-label fw-bold font-13 text-secondary mb-1">Option ID</label>
                    <input type="text" class="form-control form-control-sm" id="filter_option_id" placeholder="Option ID">
                </div>
                <div class="col-md-4 col-sm-6">
                    <label for="filter_option_name" class="form-label fw-bold font-13 text-secondary mb-1">Option Name</label>
                    <input type="text" class="form-control form-control-sm" id="filter_option_name" placeholder="Option Name">
                </div>
                <div class="col-md-5 col-12 d-flex justify-content-md-end gap-2">
                    <button type="button" class="btn btn-sm btn-danger px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1" id="btnClearFilter">
                        <i class="bi bi-x-lg"></i> Clear Filter
                    </button>
                    <button type="button" class="btn btn-sm btn-primary px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1" id="btnFilter">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Options Table (Matching UI in Picture) -->
    <div class="card border rounded-2 bg-white shadow-none">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr class="text-secondary font-13">
                        <th style="width: 15%;" class="ps-3">OptionID</th>
                        <th style="width: 30%;">Name</th>
                        <th style="width: 18%;">Type</th>
                        <th style="width: 12%;">Sort Order</th>
                        <th style="width: 12%;" class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody class="optionstbl">
                    <!-- Loaded via jQuery Ajax -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetchData();

        // Filter button click
        $('#btnFilter').on('click', function(e) {
            e.preventDefault();
            fetchData();
        });

        // Clear filter button click
        $('#btnClearFilter').on('click', function(e) {
            e.preventDefault();
            $('#filter_option_id').val('');
            $('#filter_option_name').val('');
            fetchData();
        });
        
    });

    function fetchData() {
        var optionId = $('#filter_option_id').val();
        var optionName = $('#filter_option_name').val();

        $.ajax({
            url: '{{ route("admin.options.index") }}',
            type: 'GET',
            data: {
                option_id: optionId,
                option_name: optionName
            },
            dataType: 'json',
            success: function(res) {
                var data = '';

                if (res.options && res.options.length > 0) {
                    $.each(res.options, function(index, o) {
                        data += `
                            <tr>
                                <td class="ps-3 text-secondary">${index + 1}</td>
                                <td class="fw-medium text-dark">${o.name}</td>
                                <td class="text-secondary">${o.type || 'select'}</td>
                                <td class="text-secondary pl-2">${o.sort_order ?? 0}</td>
                                <td class="text-end pe-3">
                                    <div class="d-inline-flex gap-1">
                                        <a href="/admin/options/${o.id}/edit" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit Option">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    data = `
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>No options found matching the criteria.
                            </td>
                        </tr>
                    `;
                }

                $('.optionstbl').html(data);
            },
            error: function(err) {
                console.error(err);
                $('.optionstbl').html(`
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No options found.
                        </td>
                    </tr>
                `);
            }
        });
    }


</script>
@endsection
