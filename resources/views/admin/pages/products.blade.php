@extends('layouts.admin')

@section('title', 'Product Module - Vastrkaya Luxury E-Commerce')

@section('content')
    <div class="vk-card mb-4">
        <!-- Header (Matching Category Header & Button layout) -->
        <div class="vk-card-header flex-wrap gap-3">
            <div>
                <h4 class="h5 fw-bold mb-1 text-heading">Product Management</h4>
                <p class="font-13 text-muted mb-0">Manage store products with picture, brand, price, and variant options</p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2">
                <button type="button" class="vk-btn vk-btn-info" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-lg"></i> Add Product
                </button>
            </div>
        </div>

        <!-- Search Toolbar (Matching Category Search layout) -->
        <div class="p-3 border-bottom border-light bg-surface-subtle d-flex flex-wrap justify-content-between align-items-center gap-3">
            <form action="{{ route('admin.products.index') }}" method="GET"
                class="d-flex align-items-center gap-2 flex-grow-1" style="max-width: 420px;">
                <div class="input-group">
                    <span class="input-group-text bg-surface border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control vk-form-control border-start-0 search" placeholder="Search by title, brand, SKU..." onkeyup="filterProducts()">
                </div>
            </form>
        </div>

        <!-- Products Table (Matching Category layout with View, Edit, Delete buttons) -->
        <div class="vk-table-responsive">
            <table class="vk-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Picture</th>
                        <th style="width: 220px;">Product Title</th>
                        <th style="width: 140px;">Brand</th>
                        <th style="width: 130px;">Category</th>
                        <th style="width: 120px;">Base Price</th>
                        <th style="width: 130px;">Discount Price</th>
                        <th>Options (SKU / Size / Colour / Material)</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="producttbl">
                    <!-- Sample Row 1 -->
                    <tr class="product-row" data-name="Royal Banarasi Silk Saree" data-brand="Vastrkaya Couture" data-sku="VK-SAR-01">
                        <td>
                            <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=150&auto=format&fit=crop&q=80" 
                                alt="Royal Banarasi Silk Saree" 
                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid var(--vk-border);">
                        </td>
                        <td>
                            <div class="fw-bold text-heading">Royal Banarasi Silk Saree</div>
                            <small class="text-muted">ID: #1</small>
                        </td>
                        <td>Vastrkaya Couture</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-dark">Sarees</span></td>
                        <td><span class="fw-bold">&#8377;4,999.00</span></td>
                        <td>
                            <span class="text-muted text-decoration-line-through font-13">&#8377;7,999.00</span>
                        </td>
                        <td>
                            <div class="font-12">
                                <div><strong>SKU:</strong> VK-SAR-01 &bull; <strong>Size:</strong> Free Size</div>
                                <div><strong>Colour:</strong> Crimson Red &bull; <strong>Fabric:</strong> Katan Silk</div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                Active
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info text-white" title="View Product Details" data-bs-toggle="modal" data-bs-target="#viewProductModal" onclick="viewProduct(1)">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary ms-1" title="Edit Product" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="editProduct(1)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger ms-1" title="Delete Product" onclick="deleteProduct(1)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Row 2 -->
                    <tr class="product-row" data-name="Handcrafted Embroidered Bridal Lehenga" data-brand="Heritage Weaves" data-sku="VK-LH-04">
                        <td>
                            <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=150&auto=format&fit=crop&q=80" 
                                alt="Bridal Lehenga" 
                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid var(--vk-border);">
                        </td>
                        <td>
                            <div class="fw-bold text-heading">Handcrafted Embroidered Bridal Lehenga</div>
                            <small class="text-muted">ID: #2</small>
                        </td>
                        <td>Heritage Weaves</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-dark">Lehengas</span></td>
                        <td><span class="fw-bold">&#8377;12,499.00</span></td>
                        <td>
                            <span class="text-muted text-decoration-line-through font-13">&#8377;16,999.00</span>
                        </td>
                        <td>
                            <div class="font-12">
                                <div><strong>SKU:</strong> VK-LH-04 &bull; <strong>Size:</strong> M, L, XL</div>
                                <div><strong>Colour:</strong> Deep Maroon &bull; <strong>Fabric:</strong> Velvet & Net</div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                Active
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info text-white" title="View Product Details" data-bs-toggle="modal" data-bs-target="#viewProductModal" onclick="viewProduct(2)">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary ms-1" title="Edit Product" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="editProduct(2)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger ms-1" title="Delete Product" onclick="deleteProduct(2)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Row 3 -->
                    <tr class="product-row" data-name="Chikankari Georgette Anarkali Kurti" data-brand="Vastrkaya Couture" data-sku="VK-KURTI-09">
                        <td>
                            <img src="https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=150&auto=format&fit=crop&q=80" 
                                alt="Chikankari Kurti" 
                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid var(--vk-border);">
                        </td>
                        <td>
                            <div class="fw-bold text-heading">Chikankari Georgette Anarkali Kurti</div>
                            <small class="text-muted">ID: #3</small>
                        </td>
                        <td>Vastrkaya Couture</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-dark">Kurtis & Suits</span></td>
                        <td><span class="fw-bold">&#8377;1,899.00</span></td>
                        <td>
                            <span class="text-muted text-decoration-line-through font-13">&#8377;2,499.00</span>
                        </td>
                        <td>
                            <div class="font-12">
                                <div><strong>SKU:</strong> VK-KURTI-09 &bull; <strong>Size:</strong> S, M, L, XL</div>
                                <div><strong>Colour:</strong> Pastel Cyan &bull; <strong>Fabric:</strong> Pure Georgette</div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                Active
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info text-white" title="View Product Details" data-bs-toggle="modal" data-bs-target="#viewProductModal" onclick="viewProduct(3)">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary ms-1" title="Edit Product" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="editProduct(3)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger ms-1" title="Delete Product" onclick="deleteProduct(3)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>

                    <!-- Sample Row 4 -->
                    <tr class="product-row" data-name="Zari Work Velvet Royal Sherwani" data-brand="Royal Men Ethnic" data-sku="VK-MEN-02">
                        <td>
                            <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=150&auto=format&fit=crop&q=80" 
                                alt="Royal Sherwani" 
                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid var(--vk-border);">
                        </td>
                        <td>
                            <div class="fw-bold text-heading">Zari Work Velvet Royal Sherwani</div>
                            <small class="text-muted">ID: #4</small>
                        </td>
                        <td>Royal Men Ethnic</td>
                        <td><span class="badge bg-secondary bg-opacity-10 text-dark">Men Ethnic</span></td>
                        <td><span class="fw-bold">&#8377;8,750.00</span></td>
                        <td>
                            <span class="text-muted font-13">-</span>
                        </td>
                        <td>
                            <div class="font-12">
                                <div><strong>SKU:</strong> VK-MEN-02 &bull; <strong>Size:</strong> 38, 40, 42, 44</div>
                                <div><strong>Colour:</strong> Royal Navy &bull; <strong>Fabric:</strong> Velvet Silk Blend</div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                In Active
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-info text-white" title="View Product Details" data-bs-toggle="modal" data-bs-target="#viewProductModal" onclick="viewProduct(4)">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary ms-1" title="Edit Product" data-bs-toggle="modal" data-bs-target="#editProductModal" onclick="editProduct(4)">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger ms-1" title="Delete Product" onclick="deleteProduct(4)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ========================================================================
         VIEW PRODUCT DETAILS MODAL (New Modal for View Button)
         ======================================================================== -->
    <div class="modal fade vk-modal" id="viewProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-eye text-info me-2"></i>Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <!-- Product Picture Column -->
                        <div class="col-md-4 text-center">
                            <img id="viewProductImg" src="https://via.placeholder.com/250x250?text=Product" 
                                alt="Product Picture" 
                                class="img-fluid rounded-3 shadow-sm border border-light" 
                                style="max-height: 240px; width: 100%; object-fit: cover;">
                            <div class="mt-3">
                                <span id="viewProductStatus" class="badge bg-success rounded-pill px-3 py-2">Active</span>
                            </div>
                        </div>

                        <!-- Product Information Column -->
                        <div class="col-md-8">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span id="viewProductCategory" class="badge bg-secondary bg-opacity-10 text-dark">Category</span>
                                <span id="viewProductBrand" class="badge bg-primary bg-opacity-10 text-primary">Brand</span>
                            </div>
                            <h4 id="viewProductName" class="fw-bold text-heading mb-1">Product Title</h4>
                            <p class="text-muted font-12 mb-3">ID: #<span id="viewProductId">1</span></p>

                            <!-- Pricing Info (Base Price & Discount Price from product_prices) -->
                            <div class="p-3 rounded-3 bg-surface-subtle border border-light mb-3">
                                <div class="row text-center g-2">
                                    <div class="col-6 border-end border-light">
                                        <small class="text-muted d-block font-12">Base Price</small>
                                        <span id="viewProductBasePrice" class="h5 fw-bold text-heading mb-0">&#8377;0.00</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block font-12">Discount Price</small>
                                        <span id="viewProductDiscountPrice" class="h5 fw-bold text-danger mb-0">-</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Options Specifications (from options table) -->
                            <div class="p-3 rounded-3 border border-light mb-3">
                                <h6 class="fw-bold font-13 text-heading mb-2"><i class="bi bi-sliders2 text-primary me-1"></i>Options Specification</h6>
                                <div class="row g-2 font-13">
                                    <div class="col-6">
                                        <span class="text-muted">SKU:</span> <strong id="viewProductSku">-</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">Size:</span> <strong id="viewProductSize">-</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">Colour:</span> <strong id="viewProductColour">-</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">Material:</span> <strong id="viewProductMaterial">-</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <h6 class="fw-bold font-13 text-heading mb-1">Description</h6>
                                <p id="viewProductDescription" class="text-muted font-13 mb-0">No description provided.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="vk-btn vk-btn-primary" data-bs-dismiss="modal" onclick="openEditFromView()">
                        <i class="bi bi-pencil"></i> Edit Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         ADD PRODUCT MODAL (Structure & button layout matching Category)
         ======================================================================== -->
    <div class="modal fade vk-modal" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-box-seam text-danger me-2"></i>Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <!-- 1. Product Picture -->
                        <div class="mb-3">
                            <label class="vk-form-label">Product Picture</label>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3 border border-dashed border-secondary border-opacity-25 bg-surface-subtle">
                                <div class="position-relative">
                                    <img id="addProductImgPreview" src="https://via.placeholder.com/120x120?text=Preview"
                                        alt="Preview"
                                        style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid var(--vk-border);">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image" id="productPictureInput"
                                        class="form-control vk-form-control form-control-sm" accept="image/*"
                                        onchange="if(this.files && this.files[0]) { var r = new FileReader(); r.onload = function(e){ document.getElementById('addProductImgPreview').src = e.target.result; }; r.readAsDataURL(this.files[0]); }">
                                    <small class="text-muted font-12 d-block mt-1">Recommended: JPG, PNG or WEBP (Max 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Product Name & Brand -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <label class="vk-form-label">Product Title</label>
                                <input type="text" name="name" class="vk-form-control" placeholder="e.g. Royal Banarasi Silk Saree" required>
                            </div>
                            <div class="col-md-5">
                                <label class="vk-form-label">Brand</label>
                                <input type="text" name="brand" class="vk-form-control" placeholder="e.g. Vastrkaya Couture">
                            </div>
                        </div>

                        <!-- 3. Category & Status -->
                        <div class="row g-3 mb-3">
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
                            <div class="col-md-6">
                                <label class="vk-form-label">Status</label>
                                <select name="status" class="vk-form-select">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- 4. Base Price & Discount Price (product_prices migration) -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="vk-form-label">Base Price (&#8377;)</label>
                                <input type="number" step="0.01" min="0" name="base_price" class="vk-form-control" placeholder="4999.00" required>
                            </div>
                            <div class="col-md-6">
                                <label class="vk-form-label">Discount Price (&#8377;)</label>
                                <input type="number" step="0.01" min="0" name="discount_price" class="vk-form-control" placeholder="Optional original / discount price">
                            </div>
                        </div>

                        <!-- 5. Options (options table) -->
                        <div class="mb-3 p-3 rounded-3 bg-surface-subtle border border-light">
                            <label class="vk-form-label fw-bold mb-2">Options Specification (options table)</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="font-12 text-muted">SKU</label>
                                    <input type="text" name="sku" class="vk-form-control form-control-sm" placeholder="e.g. VK-SAR-01">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-12 text-muted">Size</label>
                                    <input type="text" name="size" class="vk-form-control form-control-sm" placeholder="e.g. Free Size, S, M, L">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-12 text-muted">Colour</label>
                                    <input type="text" name="colour" class="vk-form-control form-control-sm" placeholder="e.g. Crimson Red">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-12 text-muted">Material</label>
                                    <input type="text" name="material" class="vk-form-control form-control-sm" placeholder="e.g. Pure Banarasi Silk">
                                </div>
                            </div>
                        </div>

                        <!-- 6. Product Description -->
                        <div class="mb-3">
                            <label class="vk-form-label">Product Description</label>
                            <textarea name="description" class="vk-form-control" rows="3"
                                placeholder="Write a brief overview of this product..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="vk-btn vk-btn-primary">
                            <i class="bi bi-check-lg"></i> Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         EDIT PRODUCT MODAL (Structure & button layout matching Category)
         ======================================================================== -->
    <div class="modal fade vk-modal" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square text-danger me-2"></i>Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data" class="formData" onsubmit="updateProduct(event)">
                    @csrf
                    <div class="modal-body">
                        <!-- 1. Product Picture -->
                        <div class="mb-3">
                            <label class="vk-form-label">Product Picture</label>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3 border border-dashed border-secondary border-opacity-25 bg-surface-subtle">
                                <div class="position-relative">
                                    <img id="editProductImgPreview"
                                        alt="Preview"
                                        style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid var(--vk-border);">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="image" id="editProductImg"
                                        class="form-control vk-form-control form-control-sm"
                                        onchange="if(this.files && this.files[0]) { var r = new FileReader(); r.onload = function(e){ document.getElementById('editProductImgPreview').src = e.target.result; }; r.readAsDataURL(this.files[0]); }">
                                    <small class="text-muted font-12 d-block mt-1">Leave empty to keep current picture</small>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Product Name & Brand -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-7">
                                <label class="vk-form-label">Product Title</label>
                                <input type="text" name="name" id="editProductName" class="vk-form-control" required>
                            </div>
                            <div class="col-md-5">
                                <label class="vk-form-label">Brand</label>
                                <input type="text" name="brand" id="editProductBrand" class="vk-form-control">
                            </div>
                        </div>

                        <!-- 3. Category & Status -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="vk-form-label">Category</label>
                                <select name="category_id" id="editProductCategoryId" class="vk-form-select" required>
                                    <option value="1">Sarees</option>
                                    <option value="2">Lehengas</option>
                                    <option value="3">Kurtis & Suits</option>
                                    <option value="4">Men Ethnic</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="vk-form-label">Status</label>
                                <select name="status" id="editProductStatus" class="vk-form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- 4. Base Price & Discount Price -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="vk-form-label">Base Price (&#8377;)</label>
                                <input type="number" step="0.01" min="0" name="base_price" id="editProductBasePrice" class="vk-form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="vk-form-label">Discount Price (&#8377;)</label>
                                <input type="number" step="0.01" min="0" name="discount_price" id="editProductDiscountPrice" class="vk-form-control">
                            </div>
                        </div>

                        <!-- 5. Options (options table) -->
                        <div class="mb-3 p-3 rounded-3 bg-surface-subtle border border-light">
                            <label class="vk-form-label fw-bold mb-2">Options Specification (options table)</label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="font-12 text-muted">SKU</label>
                                    <input type="text" name="sku" id="editProductSku" class="vk-form-control form-control-sm">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-12 text-muted">Size</label>
                                    <input type="text" name="size" id="editProductSize" class="vk-form-control form-control-sm">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-12 text-muted">Colour</label>
                                    <input type="text" name="colour" id="editProductColour" class="vk-form-control form-control-sm">
                                </div>
                                <div class="col-md-6">
                                    <label class="font-12 text-muted">Material</label>
                                    <input type="text" name="material" id="editProductMaterial" class="vk-form-control form-control-sm">
                                </div>
                            </div>
                        </div>

                        <!-- 6. Product Description -->
                        <div class="mb-3">
                            <label class="vk-form-label">Product Description</label>
                            <textarea name="description" id="editProductDescription" class="vk-form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <input type="hidden" class="update-id">
                        <button type="submit" class="vk-btn vk-btn-primary">
                            <i class="bi bi-check-lg"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Sample dataset representing products, options, and product_prices tables
        let currentViewingId = null;
        const sampleProducts = {
            1: {
                id: 1,
                name: 'Royal Banarasi Silk Saree',
                brand: 'Vastrkaya Couture',
                category_id: 1,
                category_name: 'Sarees',
                base_price: 4999.00,
                discount_price: 7999.00,
                status: 'active',
                description: 'Authentic handwoven Banarasi saree featuring intricate golden zari flora and border.',
                image: 'https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=150&auto=format&fit=crop&q=80',
                sku: 'VK-SAR-01',
                size: 'Free Size (5.5m)',
                colour: 'Crimson Red',
                material: 'Pure Katan Silk'
            },
            2: {
                id: 2,
                name: 'Handcrafted Embroidered Bridal Lehenga',
                brand: 'Heritage Weaves',
                category_id: 2,
                category_name: 'Lehengas',
                base_price: 12499.00,
                discount_price: 16999.00,
                status: 'active',
                description: 'Regal maroon velvet lehenga adorned with zardozi embroidery and matching net dupatta.',
                image: 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=150&auto=format&fit=crop&q=80',
                sku: 'VK-LH-04',
                size: 'M, L, XL',
                colour: 'Deep Maroon',
                material: 'Velvet & Net'
            },
            3: {
                id: 3,
                name: 'Chikankari Georgette Anarkali Kurti',
                brand: 'Vastrkaya Couture',
                category_id: 3,
                category_name: 'Kurtis & Suits',
                base_price: 1899.00,
                discount_price: 2499.00,
                status: 'active',
                description: 'Hand-embroidered Lucknowi chikankari floral pattern on premium georgette fabric.',
                image: 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=150&auto=format&fit=crop&q=80',
                sku: 'VK-KURTI-09',
                size: 'S, M, L, XL',
                colour: 'Pastel Cyan',
                material: 'Pure Georgette'
            },
            4: {
                id: 4,
                name: 'Zari Work Velvet Royal Sherwani',
                brand: 'Royal Men Ethnic',
                category_id: 4,
                category_name: 'Men Ethnic',
                base_price: 8750.00,
                discount_price: '',
                status: 'inactive',
                description: 'Navy blue velvet sherwani paired with handcrafted metal buttons and rich mandarin collar.',
                image: 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=150&auto=format&fit=crop&q=80',
                sku: 'VK-MEN-02',
                size: '38, 40, 42, 44',
                colour: 'Royal Navy',
                material: 'Velvet Silk Blend'
            }
        };

        // Filter products client-side on typing
        function filterProducts() {
            let search = $('.search').val().toLowerCase().trim();
            $('.product-row').each(function() {
                let name = ($(this).data('name') || '').toLowerCase();
                let brand = ($(this).data('brand') || '').toLowerCase();
                let sku = ($(this).data('sku') || '').toLowerCase();
                let text = $(this).text().toLowerCase();

                if (!search || name.includes(search) || brand.includes(search) || sku.includes(search) || text.includes(search)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // View Product Details Function
        function viewProduct(id) {
            currentViewingId = id;
            let product = sampleProducts[id];
            if (product) {
                $('#viewProductId').text(product.id);
                $('#viewProductName').text(product.name);
                $('#viewProductBrand').text(product.brand || 'No Brand');
                $('#viewProductCategory').text(product.category_name || 'Uncategorized');
                $('#viewProductBasePrice').html(`&#8377;${parseFloat(product.base_price).toLocaleString('en-IN', {minimumFractionDigits: 2})}`);
                $('#viewProductDiscountPrice').html(product.discount_price ? `&#8377;${parseFloat(product.discount_price).toLocaleString('en-IN', {minimumFractionDigits: 2})}` : '-');
                $('#viewProductSku').text(product.sku || '-');
                $('#viewProductSize').text(product.size || '-');
                $('#viewProductColour').text(product.colour || '-');
                $('#viewProductMaterial').text(product.material || '-');
                $('#viewProductDescription').text(product.description || 'No description provided.');
                
                // Status Badge
                let statusBadge = $('#viewProductStatus');
                if (product.status === 'active') {
                    statusBadge.removeClass('bg-danger').addClass('bg-success').text('Active');
                } else {
                    statusBadge.removeClass('bg-success').addClass('bg-danger').text('Inactive');
                }

                // Image
                let imgSrc = product.image.startsWith('http') ? product.image : `/storage/${product.image}`;
                $('#viewProductImg').attr('src', imgSrc);
            }
        }

        // Helper to jump directly from View modal to Edit modal
        function openEditFromView() {
            if (currentViewingId) {
                editProduct(currentViewingId);
                const editModalEl = document.getElementById('editProductModal');
                const modal = new bootstrap.Modal(editModalEl);
                modal.show();
            }
        }

        // Edit Product
        function editProduct(id) {
            let product = sampleProducts[id];
            if (product) {
                $('#editProductImgPreview').attr('src', product.image.startsWith('http') ? product.image : `/storage/${product.image}`);
                $('#editProductName').val(product.name);
                $('#editProductBrand').val(product.brand);
                $('#editProductCategoryId').val(product.category_id);
                $('#editProductBasePrice').val(product.base_price);
                $('#editProductDiscountPrice').val(product.discount_price);
                $('#editProductStatus').val(product.status);
                $('#editProductDescription').val(product.description);
                $('#editProductSku').val(product.sku);
                $('#editProductSize').val(product.size);
                $('#editProductColour').val(product.colour);
                $('#editProductMaterial').val(product.material);
                $('.update-id').val(product.id);
            }
        }

        // Update Product
        function updateProduct(e) {
            e.preventDefault();
            let id = $('.update-id').val();
            const editModalEl = document.getElementById('editProductModal');
            const modal = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
            modal.hide();

            if (window.showToast) {
                window.showToast('Product updated successfully', 'success');
            }
        }

        // Delete Product
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                if (window.showToast) {
                    window.showToast('Product deleted successfully', 'success');
                }
            }
        }
    </script>
@endsection
