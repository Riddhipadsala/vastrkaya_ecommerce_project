@extends('layouts.admin')

@section('title', 'Product Module - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="vk-card mb-4">
    <div class="vk-card-header flex-wrap gap-3">
        <div>
            <h4 class="h5 fw-bold mb-1 text-heading">Product Catalog Management Module</h4>
            <p class="font-13 text-muted mb-0">Create, edit, price, and maintain luxury e-commerce merchandise</p>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <button type="button" class="vk-btn vk-btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-lg"></i> Add New Product
            </button>
        </div>
    </div>

    <!-- Product Stats Strip -->
    <div class="p-3 border-bottom border-light bg-surface-subtle">
        <div class="row g-3 text-center">
            <div class="col-sm-3 col-6 border-end border-light">
                <div class="text-muted font-13">Total Products</div>
                <div class="h5 fw-bold mb-0 text-heading">148</div>
            </div>
            <div class="col-sm-3 col-6 border-end border-light">
                <div class="text-muted font-13">Active in Catalog</div>
                <div class="h5 fw-bold mb-0 text-success">140</div>
            </div>
            <div class="col-sm-3 col-6 border-end border-light">
                <div class="text-muted font-13">Low / Out of Stock</div>
                <div class="h5 fw-bold mb-0 text-danger">8</div>
            </div>
            <div class="col-sm-3 col-6">
                <div class="text-muted font-13">Average Price</div>
                <div class="h5 fw-bold mb-0 text-heading">&#8377;5,280</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="p-3 border-bottom border-light bg-surface-subtle d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1" style="max-width: 400px;">
            <div class="input-group">
                <span class="input-group-text bg-surface border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control vk-form-control border-start-0" placeholder="Search product name or SKU...">
            </div>
        </div>

        <div class="d-flex flex-wrap align-items-center gap-2">
            <select name="category" class="form-select vk-form-select form-select-sm" style="width: 150px;">
                <option value="">All Categories</option>
                <option value="sarees">Sarees</option>
                <option value="lehengas">Lehengas</option>
                <option value="kurtis">Kurtis & Suits</option>
                <option value="men">Men Ethnic</option>
            </select>

            <select name="stock_status" class="form-select vk-form-select form-select-sm" style="width: 150px;">
                <option value="">All Stock Status</option>
                <option value="in_stock">In Stock</option>
                <option value="low_stock">Low Stock (&le; 5)</option>
                <option value="out_of_stock">Out of Stock</option>
            </select>

            <button type="button" class="vk-btn vk-btn-sm vk-btn-secondary">
                <i class="bi bi-funnel"></i> Apply
            </button>
        </div>
    </div>

    <!-- Products Table -->
    <div class="vk-table-responsive">
        <table class="vk-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Price (INR)</th>
                    <th>Available Stock</th>
                    <th>Stock Status</th>
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
                                <div class="fw-bold text-heading font-15">Royal Banarasi Silk Saree</div>
                                <small class="text-muted">SKU: VK-SAREE-01</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark">Sarees</span></td>
                    <td>
                        <div class="fw-bold text-heading">&#8377;4,999</div>
                        <small class="text-muted text-decoration-line-through">&#8377;7,999</small>
                    </td>
                    <td>
                        <span class="fw-bold text-success font-15">45 Units</span>
                        <div class="vk-stock-meter"><div class="vk-stock-bar healthy" style="width: 85%;"></div></div>
                    </td>
                    <td>
                        <span class="vk-badge-pill status-in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span>
                    </td>
                    <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                    <td class="text-end">
                        <div class="btn-group">
                            <button class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm" title="Edit Product" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm text-danger ms-1" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="vk-product-thumb d-flex align-items-center justify-content-center bg-light text-secondary">
                                <i class="bi bi-gem fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-heading font-15">Handcrafted Embroidered Lehenga</div>
                                <small class="text-muted">SKU: VK-LH-04</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark">Lehengas</span></td>
                    <td>
                        <div class="fw-bold text-heading">&#8377;12,499</div>
                        <small class="text-muted text-decoration-line-through">&#8377;16,999</small>
                    </td>
                    <td>
                        <span class="fw-bold text-warning font-15">4 Units</span>
                        <div class="vk-stock-meter"><div class="vk-stock-bar warning" style="width: 25%;"></div></div>
                    </td>
                    <td>
                        <span class="vk-badge-pill status-low-stock"><i class="bi bi-exclamation-triangle-fill"></i> Low Stock</span>
                    </td>
                    <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                    <td class="text-end">
                        <div class="btn-group">
                            <button class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm" title="Edit Product" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm text-danger ms-1" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="vk-product-thumb d-flex align-items-center justify-content-center bg-light text-secondary">
                                <i class="bi bi-flower1 fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-heading font-15">Chikankari Georgette Kurti</div>
                                <small class="text-muted">SKU: VK-KURTI-09</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark">Kurtis</span></td>
                    <td>
                        <div class="fw-bold text-heading">&#8377;1,899</div>
                        <small class="text-muted text-decoration-line-through">&#8377;2,499</small>
                    </td>
                    <td>
                        <span class="fw-bold text-danger font-15">0 Units</span>
                        <div class="vk-stock-meter"><div class="vk-stock-bar danger" style="width: 0%;"></div></div>
                    </td>
                    <td>
                        <span class="vk-badge-pill status-out-of-stock"><i class="bi bi-x-circle-fill"></i> Out of Stock</span>
                    </td>
                    <td><span class="badge bg-warning bg-opacity-10 text-warning">Restock Needed</span></td>
                    <td class="text-end">
                        <div class="btn-group">
                            <button class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm" title="Edit Product" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm text-danger ms-1" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="vk-product-thumb d-flex align-items-center justify-content-center bg-light text-secondary">
                                <i class="bi bi-stars fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-heading font-15">Zari Work Velvet Sherwani</div>
                                <small class="text-muted">SKU: VK-MEN-02</small>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary bg-opacity-10 text-dark">Men Ethnic</span></td>
                    <td>
                        <div class="fw-bold text-heading">&#8377;8,750</div>
                        <small class="text-muted text-decoration-line-through">&#8377;11,500</small>
                    </td>
                    <td>
                        <span class="fw-bold text-success font-15">28 Units</span>
                        <div class="vk-stock-meter"><div class="vk-stock-bar healthy" style="width: 70%;"></div></div>
                    </td>
                    <td>
                        <span class="vk-badge-pill status-in-stock"><i class="bi bi-check-circle-fill"></i> In Stock</span>
                    </td>
                    <td><span class="badge bg-success bg-opacity-10 text-success">Active</span></td>
                    <td class="text-end">
                        <div class="btn-group">
                            <button class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm" title="Edit Product" data-bs-toggle="modal" data-bs-target="#editProductModal">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="vk-btn vk-btn-icon vk-btn-secondary vk-btn-sm text-danger ms-1" title="Delete" onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade vk-modal" id="addProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-box-seam text-danger me-2"></i>Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="vk-form-label">Product Name</label>
                            <input type="text" name="name" class="vk-form-control" placeholder="e.g. Royal Banarasi Silk Saree" required>
                        </div>
                        <div class="col-md-4">
                            <label class="vk-form-label">SKU</label>
                            <input type="text" name="sku" class="vk-form-control" placeholder="e.g. VK-SAR-001">
                        </div>
                        <div class="col-md-6">
                            <label class="vk-form-label">Category</label>
                            <select name="category_id" class="vk-form-select" required>
                                <option value="">Select Category</option>
                                <option value="1">Sarees</option>
                                <option value="2">Lehengas</option>
                                <option value="3">Kurtis & Suits</option>
                                <option value="4">Men Ethnic</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="vk-form-label">Selling Price (&#8377;)</label>
                            <input type="number" name="price" class="vk-form-control" placeholder="4999" required>
                        </div>
                        <div class="col-md-3">
                            <label class="vk-form-label">Original Price (&#8377;)</label>
                            <input type="number" name="compare_price" class="vk-form-control" placeholder="6999">
                        </div>
                        <div class="col-md-6">
                            <label class="vk-form-label text-primary"><i class="bi bi-stack me-1"></i>Current Stock Available</label>
                            <input type="number" name="stock_quantity" class="vk-form-control" placeholder="Quantity in units (e.g. 50)" required>
                        </div>
                        <div class="col-md-6">
                            <label class="vk-form-label">Low Stock Alert Threshold</label>
                            <input type="number" name="low_stock_threshold" class="vk-form-control" value="5" placeholder="Default 5 units">
                        </div>
                        <div class="col-12">
                            <label class="vk-form-label">Product Description</label>
                            <textarea name="description" class="vk-form-control" rows="3" placeholder="Craftsmanship details, fabric specs, care instructions..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="vk-btn vk-btn-primary"><i class="bi bi-check-lg"></i> Create Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade vk-modal" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square text-danger me-2"></i>Edit Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="vk-form-label">Product Name</label>
                            <input type="text" name="name" class="vk-form-control" value="Royal Banarasi Silk Saree" required>
                        </div>
                        <div class="col-md-4">
                            <label class="vk-form-label">SKU</label>
                            <input type="text" name="sku" class="vk-form-control" value="VK-SAREE-01">
                        </div>
                        <div class="col-md-6">
                            <label class="vk-form-label">Category</label>
                            <select name="category_id" class="vk-form-select">
                                <option value="1" selected>Sarees</option>
                                <option value="2">Lehengas</option>
                                <option value="3">Kurtis & Suits</option>
                                <option value="4">Men Ethnic</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="vk-form-label">Selling Price (&#8377;)</label>
                            <input type="number" name="price" class="vk-form-control" value="4999">
                        </div>
                        <div class="col-md-3">
                            <label class="vk-form-label">Original Price (&#8377;)</label>
                            <input type="number" name="compare_price" class="vk-form-control" value="7999">
                        </div>
                        <div class="col-md-6">
                            <label class="vk-form-label text-primary"><i class="bi bi-stack me-1"></i>Current Stock Available</label>
                            <input type="number" name="stock_quantity" class="vk-form-control" value="45">
                        </div>
                        <div class="col-md-6">
                            <label class="vk-form-label">Low Stock Threshold</label>
                            <input type="number" name="low_stock_threshold" class="vk-form-control" value="5">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="vk-btn vk-btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
