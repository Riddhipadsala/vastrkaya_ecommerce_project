@extends('layouts.admin')

@section('title', 'Product Module - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">
    <!-- Top Bar with Title and Add Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h4 class="h5 fw-bold mb-0 text-heading">Product Management</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg"></i> Add Product
        </a>
    </div>

    <!-- Filter Box (1 search input with Clear Filter & Filter buttons) -->
    <div class="card border rounded-2 bg-white mb-3 shadow-none">
        <div class="card-body p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-7 col-sm-12">
                    <label for="filter_product_search" class="form-label fw-bold font-13 text-secondary mb-1">Product Name</label>
                    <input type="text" class="form-control form-control-sm search" id="filter_product_search" placeholder="Search by product name, brand, category..." value="{{ request('search') }}">
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

    <!-- Products Table Card -->
    <div class="card border rounded-2 bg-white shadow-none mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr class="text-secondary font-13">
                        <th style="width: 80px;" class="ps-3">Picture</th>
                        <th style="min-width: 200px;">Product Name</th>
                        <th style="min-width: 220px;">Options / Variants</th>
                        <th style="width: 130px;">Category</th>
                        <th style="width: 120px;">Price</th>
                        <th style="width: 90px;">Stock</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 120px;" class="text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody class="producttbl">
                    <!-- Dummy Product 1 -->
                    <tr>
                        <td>
                            <img src="https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=150&auto=format&fit=crop&q=80" 
                                 alt="Royal Banarasi Silk Saree" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>
                            <div class="fw-bold text-heading">Royal Banarasi Silk Saree</div>
                            <small class="text-muted">Vastrkaya Couture</small>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <span class="badge bg-light text-dark border">Colour: Crimson Red</span>
                                <span class="badge bg-light text-dark border">Fabric: Pure Silk</span>
                            </div>
                        </td>
                        <td>Sarees</td>
                        <td><span class="fw-bold">&#8377;3,999.00</span></td>
                        <td>24</td>
                        <td class="align-middle">
                            <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit Product" onclick="editProduct(1)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete Product" onclick="confirmDeleteProduct(1)">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Product 2 -->
                    <tr>
                        <td>
                            <img src="https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=150&auto=format&fit=crop&q=80" 
                                 alt="Bridal Velvet Lehenga" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>
                            <div class="fw-bold text-heading">Bridal Velvet Lehenga</div>
                            <small class="text-muted">Heritage Weaves</small>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <span class="badge bg-light text-dark border">Size: Free Size</span>
                                <span class="badge bg-light text-dark border">Colour: Maroon</span>
                                <span class="badge bg-light text-dark border">Fabric: Velvet</span>
                            </div>
                        </td>
                        <td>Lehengas</td>
                        <td><span class="fw-bold">&#8377;14,999.00</span></td>
                        <td>4</td>
                        <td class="align-middle">
                            <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit Product" onclick="editProduct(2)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete Product" onclick="confirmDeleteProduct(2)">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Product 3 -->
                    <tr>
                        <td>
                            <img src="https://images.unsplash.com/photo-1583391733975-dd285a864700?w=150&auto=format&fit=crop&q=80" 
                                 alt="Chanderi Embroidered Kurti" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>
                            <div class="fw-bold text-heading">Chanderi Embroidered Kurti</div>
                            <small class="text-muted">Aura Silk</small>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <span class="badge bg-light text-dark border">Size: S, M, L, XL</span>
                                <span class="badge bg-light text-dark border">Colour: Pastel Cyan</span>
                            </div>
                        </td>
                        <td>Kurtis & Suits</td>
                        <td><span class="fw-bold">&#8377;2,799.00</span></td>
                        <td>0</td>
                        <td class="align-middle">
                            <span class="badge bg-danger rounded-pill px-3 py-2">Inactive</span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit Product" onclick="editProduct(3)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete Product" onclick="confirmDeleteProduct(3)">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Dummy Product 4 -->
                    <tr>
                        <td>
                            <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=150&auto=format&fit=crop&q=80" 
                                 alt="Men's Royal Sherwani" 
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </td>
                        <td>
                            <div class="fw-bold text-heading">Men's Royal Sherwani</div>
                            <small class="text-muted">Royal Men Ethnic</small>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <span class="badge bg-light text-dark border">Size: 38, 40, 42</span>
                                <span class="badge bg-light text-dark border">Colour: Royal Navy</span>
                            </div>
                        </td>
                        <td>Men Ethnic</td>
                        <td><span class="fw-bold">&#8377;8,999.00</span></td>
                        <td>12</td>
                        <td class="align-middle">
                            <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                        </td>
                        <td class="text-end pe-3">
                            <div class="d-inline-flex gap-1">
                                <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit Product" onclick="editProduct(4)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete Product" onclick="confirmDeleteProduct(4)">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- ========================================================================
         ADD PRODUCT MODAL
         ======================================================================== -->
    <div class="modal fade vk-modal" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-box-seam text-danger me-2"></i>Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm" onsubmit="saveProduct(event)">
                    @csrf
                    <div class="modal-body p-4">
                        <!-- Product Picture -->
                        <div class="mb-3">
                            <label class="vk-form-label">Product Picture</label>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3 border border-dashed border-secondary border-opacity-25 bg-surface-subtle">
                                <img id="addProductImgPreview" src="https://via.placeholder.com/80x80?text=Preview"
                                     alt="Preview"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                <div class="flex-grow-1">
                                    <input type="file" name="image" id="addProductImageInput"
                                        class="form-control vk-form-control form-control-sm" accept="image/*"
                                        onchange="previewImg(this, 'addProductImgPreview')">
                                    <small class="text-muted font-12 d-block mt-1">Recommended: JPG, PNG or WEBP (Max 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="vk-form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="vk-form-control" placeholder="e.g. Royal Banarasi Silk Saree" required>
                        </div>

                        <!-- Brand -->
                        <div class="mb-3">
                            <label class="vk-form-label">Brand</label>
                            <input type="text" name="brand" class="vk-form-control" placeholder="e.g. Vastrkaya Couture">
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="vk-form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="addCategorySelect" class="vk-form-select" required>
                                <option value="">Select Category</option>
                                @isset($categories)
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <!-- Price & Discount Price -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="vk-form-label">Price (&#8377;) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" name="price" class="vk-form-control" placeholder="3999.00" required>
                            </div>
                            <div class="col-6">
                                <label class="vk-form-label">Discount Price (&#8377;)</label>
                                <input type="number" step="0.01" min="0" name="discount_price" class="vk-form-control" placeholder="Optional">
                            </div>
                        </div>

                        <!-- Stock & Decrease Stock -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="vk-form-label">Stock <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="vk-form-control" value="0" min="0" required>
                            </div>
                            <div class="col-6">
                                <label class="vk-form-label">Decrease Stock</label>
                                <input type="number" name="descrese_stock" class="vk-form-control" value="0" min="0">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="vk-form-label">Status</label>
                            <select name="status" class="vk-form-select">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-2">
                            <label class="vk-form-label">Description</label>
                            <textarea name="description" class="vk-form-control" rows="3" placeholder="Brief description of the product..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="vk-btn vk-btn-primary" id="saveProductBtn">
                            <i class="bi bi-check-lg"></i> Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================================================
         EDIT PRODUCT MODAL
         ======================================================================== -->
    <div class="modal fade vk-modal" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square text-danger me-2"></i>Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data" id="editProductForm" onsubmit="updateProduct(event)">
                    @csrf
                    <input type="hidden" name="id" id="editProductId" class="update-id">
                    <div class="modal-body p-4">
                        <!-- Product Picture -->
                        <div class="mb-3">
                            <label class="vk-form-label">Product Picture</label>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-3 border border-dashed border-secondary border-opacity-25 bg-surface-subtle">
                                <img id="editProductImgPreview" src="https://via.placeholder.com/80x80?text=Preview"
                                     alt="Preview"
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                <div class="flex-grow-1">
                                    <input type="file" name="image" id="editProductImageInput"
                                        class="form-control vk-form-control form-control-sm" accept="image/*"
                                        onchange="previewImg(this, 'editProductImgPreview')">
                                    <small class="text-muted font-12 d-block mt-1">Leave empty to keep current picture</small>
                                </div>
                            </div>
                        </div>

                        <!-- Product Name -->
                        <div class="mb-3">
                            <label class="vk-form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="editProductName" class="vk-form-control" required>
                        </div>

                        <!-- Brand -->
                        <div class="mb-3">
                            <label class="vk-form-label">Brand</label>
                            <input type="text" name="brand" id="editProductBrand" class="vk-form-control">
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="vk-form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="editCategorySelect" class="vk-form-select" required>
                                <option value="">Select Category</option>
                                @isset($categories)
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <!-- Price & Discount Price -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="vk-form-label">Price (&#8377;) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" name="price" id="editPrice" class="vk-form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="vk-form-label">Discount Price (&#8377;)</label>
                                <input type="number" step="0.01" min="0" name="discount_price" id="editDiscountPrice" class="vk-form-control">
                            </div>
                        </div>

                        <!-- Stock & Decrease Stock -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="vk-form-label">Stock <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="editProductStock" class="vk-form-control" min="0" required>
                            </div>
                            <div class="col-6">
                                <label class="vk-form-label">Decrease Stock</label>
                                <input type="number" name="descrese_stock" id="editProductDecreaseStock" class="vk-form-control" min="0">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="vk-form-label">Status</label>
                            <select name="status" id="editProductStatus" class="vk-form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Description -->
                        <div class="mb-2">
                            <label class="vk-form-label">Description</label>
                            <textarea name="description" id="editProductDescription" class="vk-form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="vk-btn vk-btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="vk-btn vk-btn-primary" id="updateProductBtn">
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
    let productToDeleteId = null;

    // 4 Dummy Records
    const dummyProducts = [
        {
            id: 1,
            name: "Royal Banarasi Silk Saree",
            brand: "Vastrkaya Couture",
            category_id: 1,
            category: { id: 1, name: "Sarees" },
            image: "https://images.unsplash.com/photo-1610030469983-98e550d6193c?w=150&auto=format&fit=crop&q=80",
            options: ["Colour: Crimson Red", "Fabric: Pure Silk"],
            price: 3999.00,
            discount_price: 4999.00,
            stock: 24,
            descrese_stock: 6,
            status: "active",
            description: "Handwoven pure Banarasi silk saree with intricate gold zari brocade work."
        },
        {
            id: 2,
            name: "Bridal Velvet Lehenga",
            brand: "Heritage Weaves",
            category_id: 2,
            category: { id: 2, name: "Lehengas" },
            image: "https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?w=150&auto=format&fit=crop&q=80",
            options: ["Size: Free Size", "Colour: Maroon", "Fabric: Velvet"],
            price: 14999.00,
            discount_price: 18500.00,
            stock: 4,
            descrese_stock: 12,
            status: "active",
            description: "Exquisite bridal crimson velvet lehenga with handcrafted zardozi embroidery."
        },
        {
            id: 3,
            name: "Chanderi Embroidered Kurti",
            brand: "Aura Silk",
            category_id: 3,
            category: { id: 3, name: "Kurtis & Suits" },
            image: "https://images.unsplash.com/photo-1583391733975-dd285a864700?w=150&auto=format&fit=crop&q=80",
            options: ["Size: S, M, L, XL", "Colour: Pastel Cyan"],
            price: 2799.00,
            discount_price: null,
            stock: 0,
            descrese_stock: 15,
            status: "inactive",
            description: "Pastel cyan Chanderi silk flared Anarkali kurti."
        },
        {
            id: 4,
            name: "Men's Royal Sherwani",
            brand: "Royal Men Ethnic",
            category_id: 4,
            category: { id: 4, name: "Men Ethnic" },
            image: "https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=150&auto=format&fit=crop&q=80",
            options: ["Size: 38, 40, 42", "Colour: Royal Navy"],
            price: 8999.00,
            discount_price: 11200.00,
            stock: 12,
            descrese_stock: 3,
            status: "active",
            description: "Bespoke royal navy velvet sherwani with antique gold zari work."
        }
    ];

    $(document).ready(function() {
        fetchData();
        fetchCategoriesIfEmpty();

        // Filter button click
        $('#btnFilter').on('click', function(e) {
            e.preventDefault();
            fetchData();
        });

        // Clear filter button click
        $('#btnClearFilter').on('click', function(e) {
            e.preventDefault();
            $('#filter_product_search').val('');
            fetchData();
        });

        // Press Enter inside search input
        $('#filter_product_search').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                fetchData();
            }
        });
    });

     // Fetch products
    function fetchData() {
        const search = $('#filter_product_search').val() || '';

        axios.get('/admin/products', {
            params: { search: search }
        })
        .then(res => {
            const products = res.data.products || [];
            let listToDisplay = products;

            // Fallback to dummy data if database is empty
            if (products.length === 0) {
                if (!search) {
                    listToDisplay = dummyProducts;
                } else {
                    const q = search.toLowerCase();
                    listToDisplay = dummyProducts.filter(p => 
                        (p.name && p.name.toLowerCase().includes(q)) ||
                        (p.brand && p.brand.toLowerCase().includes(q)) ||
                        (p.category && p.category.name && p.category.name.toLowerCase().includes(q))
                    );
                }
            }

            let html = '';
            if (listToDisplay.length > 0) {
                listToDisplay.forEach((p) => {
                    const imgSrc = p.image 
                        ? (p.image.startsWith('http') ? p.image : `/storage/${p.image}`) 
                        : 'https://via.placeholder.com/60x60?text=No+Img';
                    const categoryName = p.category ? p.category.name : '-';
                    const priceFormatted = `&#8377;${parseFloat(p.price || 0).toLocaleString('en-IN', { minimumFractionDigits: 2 })}`;

                    let optionsHtml = '<span class="text-muted font-13">-</span>';
                    if (p.options && Array.isArray(p.options) && p.options.length > 0) {
                        optionsHtml = `<div class="d-flex flex-wrap gap-1 align-items-center">${p.options.map(opt => `<span class="badge bg-light text-dark border">${opt}</span>`).join('')}</div>`;
                    } else if (typeof p.options === 'string' && p.options.trim()) {
                        optionsHtml = `<span class="badge bg-light text-dark border">${p.options}</span>`;
                    }

                    html += `
                        <tr>
                            <td class="ps-3">
                                <img src="${imgSrc}" 
                                     alt="${p.name}" 
                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                            </td>
                            <td>
                                <div class="fw-bold text-heading">${p.name}</div>
                                <small class="text-muted">${p.brand || ''}</small>
                            </td>
                            <td>${optionsHtml}</td>
                            <td>${categoryName}</td>
                            <td><span class="fw-bold">${priceFormatted}</span></td>
                            <td>${p.stock ?? 0}</td>
                            <td class="align-middle">
                                <span class="badge ${p.status === 'active' ? 'bg-success' : 'bg-danger'} rounded-pill px-3 py-2">
                                    ${p.status === 'active' ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-inline-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-primary px-2 py-1 rounded" title="Edit Product" onclick="editProduct(${p.id})">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger px-2 py-1 rounded" title="Delete Product" onclick="confirmDeleteProduct(${p.id})">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html = `
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            No products found.
                        </td>
                    </tr>
                `;
            }

            $('.producttbl').html(html);
        })
        .catch(err => {
            console.error(err);
        });
    }

    // Add Product
    function saveProduct(e) {
        e.preventDefault();
        const form = document.getElementById('addProductForm');
        const formData = new FormData(form);
        const submitBtn = document.getElementById('saveProductBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status"></span> Saving...`;

        axios.post('/admin/products', formData)
            .then(res => {
                if (res.data.success) {
                    const modalEl = document.getElementById('addProductModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modalInstance.hide();
                    form.reset();
                    document.getElementById('addProductImgPreview').src = 'https://via.placeholder.com/80x80?text=Preview';

                    fetchData();
                    window.showToast?.(res.data.message || 'Product created successfully', 'success');
                } else {
                    window.showToast?.('Failed to create product', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                const msg = err.response?.data?.message || 'Error creating product';
                window.showToast?.(msg, 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `<i class="bi bi-check-lg"></i> Save Product`;
            });
    }

    // Edit Product
    function editProduct(id) {
        const dummy = dummyProducts.find(d => d.id === parseInt(id));

        const populateEditForm = (p) => {
            $('#editProductId').val(p.id);
            $('#editProductName').val(p.name);
            $('#editProductBrand').val(p.brand || '');
            $('#editCategorySelect').val(p.category_id);
            $('#editProductStatus').val(p.status || 'active');
            $('#editPrice').val(p.price);
            $('#editDiscountPrice').val(p.discount_price || '');
            $('#editProductStock').val(p.stock || 0);
            $('#editProductDecreaseStock').val(p.descrese_stock || 0);
            $('#editProductDescription').val(p.description || '');

            const imgSrc = p.image 
                ? (p.image.startsWith('http') ? p.image : `/storage/${p.image}`) 
                : 'https://via.placeholder.com/80x80?text=No+Img';
            $('#editProductImgPreview').attr('src', imgSrc);

            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        };

        axios.get(`/admin/products/${id}/edit`)
            .then(res => {
                if (res.data.product) {
                    populateEditForm(res.data.product);
                } else if (dummy) {
                    populateEditForm(dummy);
                }
            })
            .catch(() => {
                if (dummy) {
                    populateEditForm(dummy);
                } else {
                    window.showToast?.('Failed to load product for editing', 'error');
                }
            });
    }

    // Update Product
    function updateProduct(e) {
        e.preventDefault();
        const id = $('#editProductId').val();
        const form = document.getElementById('editProductForm');
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        const submitBtn = document.getElementById('updateProductBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status"></span> Updating...`;

        axios.post(`/admin/products/${id}`, formData)
            .then(res => {
                if (res.data.success) {
                    const modalEl = document.getElementById('editProductModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modalInstance.hide();

                    fetchData();
                    window.showToast?.(res.data.message || 'Product updated successfully', 'success');
                } else {
                    window.showToast?.('Failed to update product', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                const msg = err.response?.data?.message || 'Error updating product';
                window.showToast?.(msg, 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = `<i class="bi bi-check-lg"></i> Update Product`;
            });
    }

    // Open Delete Confirmation Modal
    function confirmDeleteProduct(id) {
        productToDeleteId = id;
        const modalEl = document.getElementById('deleteConfirmModal');
        if (modalEl) {
            const nameEl = document.getElementById('deleteOptionNameDisplay');
            if (nameEl) nameEl.textContent = 'this product';
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.show();
        } else if (confirm('Are you sure you want to delete this product?')) {
            executeDelete(id);
        }
    }

    // Handle delete confirmation
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
        if (!productToDeleteId) return;
        executeDelete(productToDeleteId);
    });

    function executeDelete(id) {
        axios.delete(`/admin/products/${id}`)
            .then(res => {
                if (res.data.success) {
                    const modalEl = document.getElementById('deleteConfirmModal');
                    if (modalEl) {
                        const modalInstance = bootstrap.Modal.getInstance(modalEl);
                        if (modalInstance) modalInstance.hide();
                    }
                    fetchData();
                    window.showToast?.(res.data.message || 'Product deleted successfully', 'success');
                }
            })
            .catch(err => {
                console.error(err);
                window.showToast?.('Failed to delete product', 'error');
            })
            .finally(() => {
                productToDeleteId = null;
            });
    }
</script>
@endsection
