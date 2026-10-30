@extends('layouts.admin')

@section('title', 'Coupon Module - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">

    <!-- Top Bar: Title + Add Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h4 class="h5 fw-bold mb-0 text-heading">Coupon Management</h4>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
            <i class="bi bi-plus-lg"></i> Add New Coupon
        </button>
    </div>

    <!-- Filter Box -->
    <div class="card border rounded-2 bg-white mb-3 shadow-none">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3 col-sm-6">
                    <label class="form-label fw-bold font-13 text-secondary mb-1">Coupon Name</label>
                    <input type="text" class="form-control form-control-sm" id="filter_name" placeholder="Coupon name">
                </div>
                <div class="col-md-2 col-sm-6">
                    <label class="form-label fw-bold font-13 text-secondary mb-1">Code</label>
                    <input type="text" class="form-control form-control-sm" id="filter_code" placeholder="e.g. SAVE50">
                </div>
                <div class="col-md-2 col-sm-6">
                    <label class="form-label fw-bold font-13 text-secondary mb-1">Type</label>
                    <select class="form-select form-select-sm" id="filter_type">
                        <option value="">All Types</option>
                        <option value="percentage">Percentage</option>
                        <option value="fix">Fixed Amount</option>
                    </select>
                </div>
                <div class="col-md-1 col-sm-6">
                    <label class="form-label fw-bold font-13 text-secondary mb-1">Status</label>
                    <select class="form-select form-select-sm" id="filter_status">
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2 col-12 d-flex justify-content-md-end gap-2">
                    <button type="button" onclick="clearFilter()" class="btn btn-sm btn-danger px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1">
                        <i class="bi bi-x-lg"></i> Clear
                    </button>
                    <button type="button" onclick="fetchData()" class="btn btn-sm btn-primary px-3 py-1 fw-semibold d-inline-flex align-items-center gap-1">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupons Table -->
    <div class="card border rounded-2 bg-white shadow-none">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr class="text-secondary font-13">
                        <th style="width:5%;" class="ps-3">#</th>
                        <th style="width:14%;">Coupon Name</th>
                        <th style="width:10%;">Code</th>
                        <th style="width:8%;">Discount</th>
                        <th style="width:12%;">Usage</th>
                        <th style="width:10%;">Start Date</th>
                        <th style="width:10%;">End Date</th>
                        <th style="width:10%;">Validity</th>
                        <th style="width:7%;">Status</th>
                        <th style="width:5%;" class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody id="couponTbl"></tbody>
            </table>
        </div>
    </div>

</div>


<!-- ============================================================
     ADD COUPON MODAL
     ============================================================ -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-15 fw-bold text-heading">
                    <i class="bi bi-ticket-perforated text-primary me-2"></i>Add New Coupon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCouponForm" onsubmit="storeCoupon(event)">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">

                        <!-- Coupon Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Coupon Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="coupon_name" class="form-control form-control-sm"
                                placeholder="e.g. Summer Sale 2026" required>
                        </div>

                        <!-- Coupon Code -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Coupon Code <span class="text-danger">*</span>
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="code" id="addCouponCode" class="form-control text-uppercase"
                                    placeholder="e.g. SUMMER50" required
                                    oninput="this.value = this.value.toUpperCase()">
                                <button type="button" class="btn btn-outline-secondary" onclick="generateCode()">
                                    <i class="bi bi-shuffle"></i>
                                </button>
                            </div>
                            <small class="text-muted font-12">Code is auto-uppercased</small>
                        </div>

                        <!-- Discount Type -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Discount Type <span class="text-danger">*</span>
                            </label>
                            <select name="type" class="form-select form-select-sm" required>
                                <option value="" disabled selected>Select type</option>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fix">Fixed Amount (₹)</option>
                            </select>
                        </div>

                        <!-- Discount Value -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Discount Value <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="discount" class="form-control form-control-sm"
                                placeholder="e.g. 20" min="1" required>
                            <small class="text-muted font-12">Enter % or ₹ amount based on type</small>
                        </div>

                        <!-- Status -->
                        <div class="col-md-4">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">Status</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- Total Uses Allowed -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Total Uses Allowed <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="uses_total" class="form-control form-control-sm"
                                placeholder="e.g. 100" min="1" required>
                            <small class="text-muted font-12">Max times coupon can be used</small>
                        </div>

                        <!-- Used Total (auto-tracked, set to 0 on creation) -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">Used Count</label>
                            <input type="number" name="used_total" class="form-control form-control-sm"
                                value="0" min="0" readonly
                                style="background-color: #f8f9fa;">
                            <small class="text-muted font-12">Auto-tracked by the system</small>
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Start Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="start_date" class="form-control form-control-sm" required>
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                End Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="end_date" class="form-control form-control-sm" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top bg-light bg-opacity-25 py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg"></i> Save Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ============================================================
     EDIT COUPON MODAL
     ============================================================ -->
<div class="modal fade" id="editCouponModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-15 fw-bold text-heading">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Coupon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCouponForm" onsubmit="updateCoupon(event)">
                @csrf
                <input type="hidden" id="editCouponId">
                <div class="modal-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Coupon Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="coupon_name" id="editCouponName" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Coupon Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="code" id="editCouponCode" class="form-control form-control-sm text-uppercase" required
                                oninput="this.value = this.value.toUpperCase()">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Discount Type <span class="text-danger">*</span>
                            </label>
                            <select name="type" id="editCouponType" class="form-select form-select-sm" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fix">Fixed Amount (₹)</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Discount Value <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="discount" id="editCouponDiscount" class="form-control form-control-sm" min="1" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">Status</label>
                            <select name="status" id="editCouponStatus" class="form-select form-select-sm">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Total Uses Allowed <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="uses_total" id="editCouponUsesTotal" class="form-control form-control-sm" min="1" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">Used Count</label>
                            <input type="number" name="used_total" id="editCouponUsedTotal" class="form-control form-control-sm" min="0" readonly
                                style="background-color: #f8f9fa;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                Start Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="start_date" id="editCouponStartDate" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold font-13 text-secondary mb-1">
                                End Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="end_date" id="editCouponEndDate" class="form-control form-control-sm" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer border-top bg-light bg-opacity-25 py-2">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-check-lg"></i> Update Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    let couponIdToDelete = null;

    document.addEventListener('DOMContentLoaded', function () {
        fetchData();
    });

    function fetchData() {
        const params = {
            id:     $('#filter_id').val(),
            name:   $('#filter_name').val(),
            code:   $('#filter_code').val(),
            type:   $('#filter_type').val(),
            status: $('#filter_status').val(),
        };

        axios.get('/admin/coupons', { params })
            .then(function (res) {
                const coupons = res.data.coupons || [];

                const total = coupons.length;
                 
                let rows = '';

                if (total === 0) {
                    rows = `<tr>
                        <td colspan="11" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-1"></i>No coupons found
                        </td>
                    </tr>`;
                } else {
                    const today = new Date().toISOString().slice(0, 10);

                    coupons.forEach(function (c, i) {
                        // Validity badge
                        let validity = '';

                        if(c.status == 1) {
                            if (c.end_date < today) {
                                validity = `<span class="badge text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1 font-12">Expired</span>`;
                            } else if (c.start_date > today) {
                                validity = `<span class="badge text-warning border border-warning border-opacity-25 rounded-pill px-2 py-1 font-12">Upcoming</span>`;
                            } else {
                                validity = `<span class="badge text-success border border-success border-opacity-25 rounded-pill px-2 py-1 font-12">Live</span>`;
                            }
                        }

                        // Type badge
                        const discount = c.type === 'percentage'
                            ? `<span class="badge bg-opacity-10 text-primary font-12 px-2 py-1 rounded-pill">${c.discount}%</span>`
                            : `<span class="badge bg-opacity-10 text-success font-12 px-2 py-1 rounded-pill">${c.discount} Fix</span>`;

                        rows += `<tr>
                            <td class="ps-3 text-secondary fw-semibold font-13">${i + 1}</td>
                            <td>
                                <div class="fw-semibold text-heading font-14">${c.coupon_name}</div>
                            </td>
                            <td>
                                <code class="bg-light border rounded px-2 py-1 font-13 text-dark fw-bold">${c.code}</code>
                            </td>
                            <td class="">${discount}</td>
                            <td>
                                <div class="font-12 text-muted mb-1">${c.used_total} / ${c.uses_total} used</div>
                            </td>
                            <td class="font-13 text-secondary">${c.start_date}</td>
                            <td class="font-13 text-secondary">${c.end_date}</td>
                            <td>${validity}</td>
                            <td>
                                <span class="badge ${c.status == 1 ? 'text-success border-success' : 'text-danger border-danger'} border border-opacity-25 rounded-pill px-2 py-1 font-12">
                                    ${c.status == 1 ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded"
                                        title="Edit" data-bs-toggle="modal" data-bs-target="#editCouponModal"
                                        onclick="editCoupon(${c.id})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded"
                                        title="Delete" onclick="confirmDelete(${c.id})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>`;
                    });
                }

                $('#couponTbl').html(rows);
            })
            .catch(function (err) {
                console.error(err);
                window.showToast?.('Failed to load coupons', 'error');
            });
    }

    function clearFilter() {
        $('#filter_name, #filter_code').val('');
        $('#filter_type, #filter_status').val('');
        fetchData();
    }

    function generateCode() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';
        for (let i = 0; i < 8; i++) code += chars.charAt(Math.floor(Math.random() * chars.length));
        document.getElementById('addCouponCode').value = code;
    }

    function storeCoupon(e) {
        e.preventDefault();
        const formData = new FormData($('#addCouponForm')[0]);

        axios.post('/admin/coupons', formData)
            .then(function (res) {
                if (res.data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('addCouponModal'))?.hide();
                    document.getElementById('addCouponForm').reset();
                    fetchData();
                    window.showToast?.('Coupon created successfully', 'success');
                } else {
                    window.showToast?.(res.data.message || 'Failed to create coupon', 'error');
                }
            })
            .catch(function (err) {
                console.error(err);
                window.showToast?.('Failed to create coupon', 'error');
            });
    }

    function editCoupon(id) {
        axios.get('/admin/coupons/' + id + '/edit')
            .then(function (res) {
                const c = res.data.coupon;
                document.getElementById('editCouponId').value       = c.id;
                document.getElementById('editCouponName').value     = c.coupon_name;
                document.getElementById('editCouponCode').value     = c.code;
                document.getElementById('editCouponType').value     = c.type;
                document.getElementById('editCouponDiscount').value = c.discount;
                document.getElementById('editCouponStatus').value   = c.status;
                document.getElementById('editCouponUsesTotal').value = c.uses_total;
                document.getElementById('editCouponUsedTotal').value = c.used_total;
                document.getElementById('editCouponStartDate').value = c.start_date;
                document.getElementById('editCouponEndDate').value   = c.end_date;
            })
            .catch(function (err) {
                window.showToast?.('Failed to load coupon data', 'error');
            });
    }

    function updateCoupon(e) {
        e.preventDefault();

        const id = $('#editCouponId').val();
        const formData = new FormData($('#editCouponForm')[0]);
        formData.append('_method', 'PUT');

        axios.post('/admin/coupons/' + id, formData)
            .then(function (res) {
                if (res.data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editCouponModal'))?.hide();
                    fetchData();
                    window.showToast?.('Coupon updated successfully', 'success');
                } else {
                    window.showToast?.(res.data.message || 'Failed to update coupon', 'error');
                }
            })
            .catch(function (err) {
                console.error(err);
                window.showToast?.('Failed to update coupon', 'error');
            });
    }

    function confirmDelete(id) {
        couponIdToDelete = id;
        const modalEl = document.getElementById('deleteConfirmModal');
        (bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl)).show();
    }

    document.getElementById('confirmDeleteBtn')?.addEventListener('click', function () {
        if (!couponIdToDelete) return;
        axios.delete('/admin/coupons/' + couponIdToDelete)
            .then(function (res) {
                if (res.data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('deleteConfirmModal'))?.hide();
                    fetchData();
                    window.showToast?.(res.data.message || 'Coupon deleted successfully', 'success');
                }
            })
            .catch(function (err) {
                console.error(err);
                window.showToast?.('Failed to delete coupon', 'error');
            });
    });

</script>
@endsection

