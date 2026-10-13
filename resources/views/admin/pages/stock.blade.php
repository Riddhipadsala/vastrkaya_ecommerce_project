@extends('layouts.admin')

@section('title', 'Current Stock Available - Vastrkaya Luxury E-Commerce')

@section('content')
<!-- Stock KPI Banner -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="vk-card p-3 d-flex align-items-center gap-3">
            <div class="vk-stat-icon-wrap bg-primary bg-opacity-10 text-primary">
                <i class="bi bi-stack fs-4"></i>
            </div>
            <div>
                <span class="text-muted font-13 fw-semibold">Total Stock Units</span>
                <h4 class="fw-bold mb-0 text-heading">3,842</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="vk-card p-3 d-flex align-items-center gap-3">
            <div class="vk-stat-icon-wrap bg-success bg-opacity-10 text-success">
                <i class="bi bi-check-circle-fill fs-4"></i>
            </div>
            <div>
                <span class="text-muted font-13 fw-semibold">Healthy In-Stock</span>
                <h4 class="fw-bold mb-0 text-success">122 Items</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="vk-card p-3 d-flex align-items-center gap-3">
            <div class="vk-stat-icon-wrap bg-warning bg-opacity-10 text-warning">
                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
            </div>
            <div>
                <span class="text-muted font-13 fw-semibold">Low Stock (&le; 5)</span>
                <h4 class="fw-bold mb-0 text-warning">18 Items</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="vk-card p-3 d-flex align-items-center gap-3">
            <div class="vk-stat-icon-wrap bg-danger bg-opacity-10 text-danger">
                <i class="bi bi-x-circle-fill fs-4"></i>
            </div>
            <div>
                <span class="text-muted font-13 fw-semibold">Out of Stock</span>
                <h4 class="fw-bold mb-0 text-danger">8 Items</h4>
            </div>
        </div>
    </div>
</div>

<!-- Main Stock Management Table Card -->
<div class="vk-card">
    <div class="vk-card-header flex-wrap gap-3">
        <div>
            <h4 class="h5 fw-bold mb-1 text-heading">Current Stock Available Live Manager</h4>
            <p class="font-13 text-muted mb-0">Directly monitor inventory units, check threshold limits, and batch restock</p>
        </div>
        <div>
            <button type="button" class="vk-btn vk-btn-primary" data-bs-toggle="modal" data-bs-target="#restockModal">
                <i class="bi bi-plus-circle"></i> Quick Restock Arrival
            </button>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="p-3 border-bottom border-light bg-surface-subtle d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1" style="max-width: 400px;">
            <div class="input-group">
                <span class="input-group-text bg-surface border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control vk-form-control border-start-0" placeholder="Search by item name or SKU...">
            </div>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <select name="status" class="form-select vk-form-select form-select-sm" style="width: 170px;">
                <option value="">All Stock Levels</option>
                <option value="in_stock">Healthy (&gt; 5)</option>
                <option value="low_stock">Low Stock (&le; 5)</option>
                <option value="out_of_stock">Out of Stock (0)</option>
            </select>
            <button type="button" class="vk-btn vk-btn-sm vk-btn-secondary">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="vk-table-responsive">
        <table class="vk-table">
            <thead>
                <tr>
                    <th>Item Details</th>
                    <th>Category</th>
                    <th>Threshold</th>
                    <th>Current Stock Available</th>
                    <th>Stock Health</th>
                    <th>Live Status</th>
                    <th class="text-end">Restock</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="fw-bold text-heading font-15">Royal Banarasi Silk Saree</div>
                        <small class="text-muted">SKU: VK-SAREE-01 &bull; Unit: &#8377;4,999</small>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark">Sarees</span></td>
                    <td><code>5 units</code></td>
                    <td>
                        <span class="h5 fw-bold text-success mb-0">45 Units</span>
                    </td>
                    <td style="min-width: 140px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="vk-stock-meter flex-grow-1"><div class="vk-stock-bar healthy" style="width: 85%;"></div></div>
                            <span class="font-13 fw-bold text-success">85%</span>
                        </div>
                    </td>
                    <td>
                        <span class="vk-badge-pill status-in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span>
                    </td>
                    <td class="text-end">
                        <button type="button" class="vk-btn vk-btn-sm vk-btn-secondary" data-bs-toggle="modal" data-bs-target="#restockModal">
                            Restock +
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="fw-bold text-heading font-15">Handcrafted Embroidered Lehenga</div>
                        <small class="text-muted">SKU: VK-LH-04 &bull; Unit: &#8377;12,499</small>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark">Lehengas</span></td>
                    <td><code>5 units</code></td>
                    <td>
                        <span class="h5 fw-bold text-warning mb-0">4 Units</span>
                    </td>
                    <td style="min-width: 140px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="vk-stock-meter flex-grow-1"><div class="vk-stock-bar warning" style="width: 25%;"></div></div>
                            <span class="font-13 fw-bold text-warning">25%</span>
                        </div>
                    </td>
                    <td>
                        <span class="vk-badge-pill status-low-stock"><i class="bi bi-exclamation-triangle-fill"></i> Low Stock</span>
                    </td>
                    <td class="text-end">
                        <button type="button" class="vk-btn vk-btn-sm vk-btn-primary" data-bs-toggle="modal" data-bs-target="#restockModal">
                            Restock +
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="fw-bold text-heading font-15">Chikankari Georgette Kurti</div>
                        <small class="text-muted">SKU: VK-KURTI-09 &bull; Unit: &#8377;1,899</small>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark">Kurtis</span></td>
                    <td><code>5 units</code></td>
                    <td>
                        <span class="h5 fw-bold text-danger mb-0">0 Units</span>
                    </td>
                    <td style="min-width: 140px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="vk-stock-meter flex-grow-1"><div class="vk-stock-bar danger" style="width: 0%;"></div></div>
                            <span class="font-13 fw-bold text-danger">0%</span>
                        </div>
                    </td>
                    <td>
                        <span class="vk-badge-pill status-out-of-stock"><i class="bi bi-x-circle-fill"></i> Out of Stock</span>
                    </td>
                    <td class="text-end">
                        <button type="button" class="vk-btn vk-btn-sm vk-btn-primary" data-bs-toggle="modal" data-bs-target="#restockModal">
                            Restock +
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="fw-bold text-heading font-15">Zari Work Velvet Sherwani</div>
                        <small class="text-muted">SKU: VK-MEN-02 &bull; Unit: &#8377;8,750</small>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark">Men Ethnic</span></td>
                    <td><code>5 units</code></td>
                    <td>
                        <span class="h5 fw-bold text-success mb-0">28 Units</span>
                    </td>
                    <td style="min-width: 140px;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="vk-stock-meter flex-grow-1"><div class="vk-stock-bar healthy" style="width: 70%;"></div></div>
                            <span class="font-13 fw-bold text-success">70%</span>
                        </div>
                    </td>
                    <td>
                        <span class="vk-badge-pill status-in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span>
                    </td>
                    <td class="text-end">
                        <button type="button" class="vk-btn vk-btn-sm vk-btn-secondary" data-bs-toggle="modal" data-bs-target="#restockModal">
                            Restock +
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Restock Modal -->
<div class="modal fade vk-modal" id="restockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-arrow-up-circle-fill text-success me-2"></i>Restock Inventory Arrival</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.stock.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="vk-form-label">Select Product</label>
                        <select name="product_id" class="vk-form-select" required>
                            <option value="1">Royal Banarasi Silk Saree (45 units left)</option>
                            <option value="2" selected>Handcrafted Embroidered Lehenga (4 units left - LOW)</option>
                            <option value="3">Chikankari Georgette Kurti (0 units - OUT OF STOCK)</option>
                            <option value="4">Zari Work Velvet Sherwani (28 units left)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="vk-form-label">Quantity to Add (Units)</label>
                        <input type="number" name="quantity" class="vk-form-control" placeholder="e.g. 20" min="1" value="20" required>
                    </div>
                    <div class="mb-3">
                        <label class="vk-form-label">Supplier / Batch Note</label>
                        <input type="text" name="notes" class="vk-form-control" placeholder="e.g. Surat Artisan Batch #802">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="vk-btn vk-btn-primary"><i class="bi bi-check2-circle"></i> Confirm Restock</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
