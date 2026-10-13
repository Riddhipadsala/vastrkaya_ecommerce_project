@extends('layouts.admin')

@section('title', 'Admin Dashboard - Vastrkaya Luxury E-Commerce')

@section('content')

<!-- ========================================================================
     OVERVIEW DASHBOARD
     ======================================================================== -->
<section id="module-dashboard">
    <!-- Welcome Banner -->
    <div class="vk-card mb-4 p-4 border-0" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #ffffff;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="h3 fw-bold mb-1 text-white">Welcome back, <span class="text-danger dynamic-admin-name">{{ Auth::user()->name ?? 'Administrator' }}</span>!</h2>
                <p class="mb-0 text-muted" style="color: #cbd5e1 !important;">
                    Here is the real-time operational status of your Vastrkaya luxury catalog, inventory, and stock health.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-primary">
                    <i class="bi bi-box-seam"></i> Products Catalog
                </a>
                <a href="{{ route('admin.categories.index') }}" class="vk-btn vk-btn-secondary">
                    <i class="bi bi-tag"></i> Categories
                </a>
                <a href="{{ route('admin.stock.index') }}" class="vk-btn vk-btn-outline-primary bg-white bg-opacity-10 text-white border-light">
                    <i class="bi bi-stack"></i> Stock Manager
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Core Metric KPI Cards -->
    <div class="row g-4 mb-4">
        <!-- Metric 1: Total Products -->
        <div class="col-sm-6 col-xl-3">
            <div class="vk-stat-card stat-indigo">
                <div class="vk-stat-header">
                    <div>
                        <div class="vk-stat-label">Total Products</div>
                        <div class="vk-stat-value">148</div>
                    </div>
                    <div class="vk-stat-icon-wrap">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between font-13">
                    <span class="vk-stat-badge trend-up">
                        <i class="bi bi-arrow-up-short"></i> +12% this month
                    </span>
                    <span class="text-muted">6 New added</span>
                </div>
            </div>
        </div>

        <!-- Metric 2: Categories -->
        <div class="col-sm-6 col-xl-3">
            <div class="vk-stat-card stat-rose">
                <div class="vk-stat-header">
                    <div>
                        <div class="vk-stat-label">Active Categories</div>
                        <div class="vk-stat-value">16</div>
                    </div>
                    <div class="vk-stat-icon-wrap">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between font-13">
                    <span class="vk-stat-badge trend-up">
                        <i class="bi bi-check2-circle"></i> All Active
                    </span>
                    <span class="text-muted">Ethnic & Festive</span>
                </div>
            </div>
        </div>

        <!-- Metric 3: Current Stock Available -->
        <div class="col-sm-6 col-xl-3">
            <div class="vk-stat-card stat-emerald">
                <div class="vk-stat-header">
                    <div>
                        <div class="vk-stat-label">Available Stock</div>
                        <div class="vk-stat-value">3,842</div>
                    </div>
                    <div class="vk-stat-icon-wrap">
                        <i class="bi bi-stack"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between font-13">
                    <span class="vk-stat-badge trend-up">
                        <i class="bi bi-shield-check"></i> 88% Healthy
                    </span>
                    <span class="text-muted">Total units</span>
                </div>
            </div>
        </div>

        <!-- Metric 4: Low Stock Warnings -->
        <div class="col-sm-6 col-xl-3">
            <div class="vk-stat-card stat-amber">
                <div class="vk-stat-header">
                    <div>
                        <div class="vk-stat-label">Stock Alerts</div>
                        <div class="vk-stat-value text-danger">8</div>
                    </div>
                    <div class="vk-stat-icon-wrap">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between font-13">
                    <span class="vk-stat-badge trend-danger">
                        <i class="bi bi-bell-fill"></i> Needs Restock
                    </span>
                    <span class="text-muted">3 Out of stock</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Health Summary & Quick Distribution Bar -->
    <div class="vk-card mb-4 p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1 text-heading">Warehouse Stock Distribution Health</h5>
                <p class="text-muted font-13 mb-0">Overview of current inventory levels across active product catalogs</p>
            </div>
            <a href="{{ route('admin.stock.index') }}" class="vk-btn vk-btn-sm vk-btn-secondary">
                <i class="bi bi-arrow-right"></i> Manage Inventory
            </a>
        </div>
        <!-- Multi-segment Progress Bar -->
        <div class="progress rounded-pill mb-3" style="height: 12px; background-color: var(--vk-surface-subtle);">
            <div class="progress-bar bg-success" role="progressbar" style="width: 82%;" title="In Stock (82%)"></div>
            <div class="progress-bar bg-warning" role="progressbar" style="width: 12%;" title="Low Stock (12%)"></div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: 6%;" title="Out of Stock (6%)"></div>
        </div>
        <div class="row text-center font-13 g-2">
            <div class="col-4">
                <span class="d-inline-block rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span>
                <strong class="text-heading">122 Products</strong> In Stock (82%)
            </div>
            <div class="col-4">
                <span class="d-inline-block rounded-circle bg-warning me-1" style="width: 8px; height: 8px;"></span>
                <strong class="text-heading">18 Products</strong> Low Stock (&le; 5 units)
            </div>
            <div class="col-4">
                <span class="d-inline-block rounded-circle bg-danger me-1" style="width: 8px; height: 8px;"></span>
                <strong class="text-heading">8 Products</strong> Out of Stock (0 units)
            </div>
        </div>
    </div>

    <!-- Overview Tables Row: Recent Products & Low Stock Alerts -->
    <div class="row g-4">
        <!-- Left: Recent Products with Stock Status -->
        <div class="col-lg-8">
            <div class="vk-card h-100">
                <div class="vk-card-header">
                    <h5 class="vk-card-title">
                        <i class="bi bi-box-seam text-danger"></i> Recent Products & Stock Status
                    </h5>
                    <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-sm vk-btn-secondary">
                        View All
                    </a>
                </div>
                <div class="vk-table-responsive">
                    <table class="vk-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Current Stock</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="vk-product-thumb d-flex align-items-center justify-content-center bg-light text-secondary">
                                            <i class="bi bi-bag-check fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-heading">Royal Banarasi Silk Saree</div>
                                            <small class="text-muted">SKU: VK-SAREE-01</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-dark">Sarees</span></td>
                                <td class="fw-bold">&#8377;4,999</td>
                                <td>
                                    <span class="fw-bold text-success">45 Units</span>
                                    <div class="vk-stock-meter"><div class="vk-stock-bar healthy" style="width: 85%;"></div></div>
                                </td>
                                <td><span class="vk-badge-pill status-in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm" title="View in Catalog">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="vk-product-thumb d-flex align-items-center justify-content-center bg-light text-secondary">
                                            <i class="bi bi-gem fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-heading">Handcrafted Embroidered Lehenga</div>
                                            <small class="text-muted">SKU: VK-LH-04</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-dark">Lehengas</span></td>
                                <td class="fw-bold">&#8377;12,499</td>
                                <td>
                                    <span class="fw-bold text-warning">4 Units</span>
                                    <div class="vk-stock-meter"><div class="vk-stock-bar warning" style="width: 25%;"></div></div>
                                </td>
                                <td><span class="vk-badge-pill status-low-stock"><i class="bi bi-exclamation-triangle-fill"></i> Low Stock</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm" title="View in Catalog">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="vk-product-thumb d-flex align-items-center justify-content-center bg-light text-secondary">
                                            <i class="bi bi-flower1 fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-heading">Chikankari Georgette Kurti</div>
                                            <small class="text-muted">SKU: VK-KURTI-09</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-dark">Kurtis</span></td>
                                <td class="fw-bold">&#8377;1,899</td>
                                <td>
                                    <span class="fw-bold text-danger">0 Units</span>
                                    <div class="vk-stock-meter"><div class="vk-stock-bar danger" style="width: 0%;"></div></div>
                                </td>
                                <td><span class="vk-badge-pill status-out-of-stock"><i class="bi bi-x-circle-fill"></i> Out of Stock</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.stock.index') }}" class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm" title="Restock in Stock Manager">
                                        <i class="bi bi-stack"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="vk-product-thumb d-flex align-items-center justify-content-center bg-light text-secondary">
                                            <i class="bi bi-stars fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-heading">Zari Work Velvet Sherwani</div>
                                            <small class="text-muted">SKU: VK-MEN-02</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-dark">Men Ethnic</span></td>
                                <td class="fw-bold">&#8377;8,750</td>
                                <td>
                                    <span class="fw-bold text-success">28 Units</span>
                                    <div class="vk-stock-meter"><div class="vk-stock-bar healthy" style="width: 70%;"></div></div>
                                </td>
                                <td><span class="vk-badge-pill status-in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.products.index') }}" class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm" title="View in Catalog">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Low Stock Alert Warning Box -->
        <div class="col-lg-4">
            <div class="vk-card h-100">
                <div class="vk-card-header bg-warning bg-opacity-10">
                    <h5 class="vk-card-title text-warning text-dark">
                        <i class="bi bi-shield-exclamation text-danger"></i> Urgent Stock Attention
                    </h5>
                    <span class="badge bg-danger rounded-pill">Immediate</span>
                </div>
                <div class="vk-card-body">
                    <p class="font-13 text-muted mb-3">
                        These items have fallen below safety inventory limits (&le; 5 units) and risk losing customer orders.
                    </p>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0 py-3 border-bottom d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1 fw-bold text-heading font-14">Handcrafted Lehenga</h6>
                                <div class="font-13 text-danger fw-semibold">Only 4 Units Left</div>
                            </div>
                            <a href="{{ route('admin.stock.index') }}" class="vk-btn vk-btn-sm vk-btn-primary">
                                Restock
                            </a>
                        </div>

                        <div class="list-group-item px-0 py-3 border-bottom d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1 fw-bold text-heading font-14">Chikankari Kurti</h6>
                                <div class="font-13 text-danger fw-semibold">0 Units (Out of Stock)</div>
                            </div>
                            <a href="{{ route('admin.stock.index') }}" class="vk-btn vk-btn-sm vk-btn-primary">
                                Restock
                            </a>
                        </div>

                        <div class="list-group-item px-0 py-3 border-bottom d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1 fw-bold text-heading font-14">Bandhani Silk Dupatta</h6>
                                <div class="font-13 text-warning fw-semibold">3 Units Left</div>
                            </div>
                            <a href="{{ route('admin.stock.index') }}" class="vk-btn vk-btn-sm vk-btn-primary">
                                Restock
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 pt-2">
                        <a href="{{ route('admin.stock.index') }}" class="vk-btn vk-btn-secondary w-100">
                            <i class="bi bi-sliders"></i> Open Stock Management Hub
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
