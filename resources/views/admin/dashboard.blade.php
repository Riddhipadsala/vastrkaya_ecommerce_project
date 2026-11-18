@extends('layouts.admin')

@section('title', 'Admin Dashboard - Vastrkaya Luxury E-Commerce')

@section('content')
<div class="container-fluid px-0">
    <!-- Top Bar with Title and Quick Action Buttons (Matching other modules) -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h4 class="h5 fw-bold mb-0 text-heading">Overview Dashboard</h4>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
                <i class="bi bi-plus-lg"></i> Add Product
            </a>
            <a href="{{ route('admin.options.create') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                <i class="bi bi-sliders2"></i> Add Option
            </a>
            <a href="{{ route('dashboard') }}" target="_blank" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1">
                <i class="bi bi-box-arrow-up-right"></i> Live Store
            </a>
        </div>
    </div>

    <!-- 4 Core Metric KPI Stat Cards (Matching Card Design of Other Modules) -->
    <div class="row g-3 mb-4">
        <!-- Metric 1: Total Products -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border rounded-2 bg-white shadow-none h-100 p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-secondary font-12 fw-bold text-uppercase tracking-wider">Total Products</span>
                        <h3 class="h4 fw-bold text-heading mt-1 mb-0 product-count"></h3>
                    </div>
                </div>
                <div class="mt-auto text-end font-12 pt-2 border-top border-light">
                    <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-muted">
                        View all &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric 2: Active Categories -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border rounded-2 bg-white shadow-none h-100 p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-secondary font-12 fw-bold text-uppercase tracking-wider">Categories</span>
                        <h3 class="h4 fw-bold text-heading mt-1 mb-0 category-count"></h3>
                    </div>
                </div>
                <div class="mt-auto text-end font-12 pt-2 border-top border-light">
                    <a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-muted">
                        Manage &rarr;
                    </a>
                </div>
            </div>
        </div>

       <!-- Metric 3: Option Attributes -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border rounded-2 bg-white shadow-none h-100 p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-secondary font-12 fw-bold text-uppercase tracking-wider">
                            Option Attributes
                        </span>
                        <h3 class="h4 fw-bold text-heading mt-1 mb-0 option-count"></h3>
                    </div>
                </div>
                <div class="mt-auto text-end font-12 pt-2 border-top border-light">
                    <a href="{{ route('admin.options.index') }}"
                    class="text-decoration-none text-muted">
                        Manage &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric 4: Available Stock -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border rounded-2 bg-white shadow-none h-100 p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="text-secondary font-12 fw-bold text-uppercase tracking-wider">Available Stock</span>
                        <h3 class="h4 fw-bold text-heading mt-1 mb-0 stock-count"></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Split Overview Row: Recent Products & Quick Attention Sidebar -->
    <div class="row g-4 mt-4 mb-4">
        <!-- Left: Recent Products & Stock Status Table (Matching Product Module Table) -->
        <div class="col-lg-8">
            <div class="card border rounded-2 bg-white shadow-none h-100">
                <div class="card-header bg-white border-bottom p-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="h6 fw-bold mb-0 text-heading">
                        <i class="bi bi-box-seam text-primary me-2"></i>Recent Products Overview
                    </h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
                        View All Products
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light border-bottom">
                            <tr class="text-secondary font-13">
                                <th style="width: 8%;" class="ps-3">#</th>
                                <th style="width: 12%;">Image</th>
                                <th style="width: 32%;">Product Name</th>
                                <th style="width: 16%;">Category</th>
                                <th style="width: 14%;">Price</th>
                                <th style="width: 10%;">Stock</th>
                                <th style="width: 8%;" class="text-end pe-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="producttbl">
                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Urgent Attention & Quick Navigation Shortcuts -->
        <div class="col-lg-4">
            <!-- Card 1: Urgent Stock Warnings -->
            <div class="card border rounded-2 bg-white shadow-none mb-4">
                <div class="card-header bg-white border-bottom p-3 d-flex justify-content-between align-items-center">
                    <h5 class="h6 fw-bold mb-0 text-heading">
                        <i class="bi bi-shield-exclamation text-warning me-2"></i>Urgent Stock Attention
                    </h5>
                    <span class="badge bg-danger rounded-pill font-11">Action Needed</span>
                </div>
                <div class="card-body p-3">
                    <p class="font-12 text-muted mb-3">
                        These items have fallen below safety inventory limits (&le; 5 units):
                    </p>
                    <div class="urgent-stock"></div>
                </div>
            </div>

            <!-- Card 2: Quick Module Navigation -->
            <div class="card border rounded-2 bg-white shadow-none">
                <div class="card-header bg-white border-bottom p-3">
                    <h5 class="h6 fw-bold mb-0 text-heading">
                        <i class="bi bi-grid-fill text-primary me-2"></i>Module Shortcuts
                    </h5>
                </div>
                <div class="list-group list-group-flush font-13">
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-tags-fill text-success"></i>
                            <span class="fw-semibold text-heading">Category Module</span>
                        </div>
                        <i class="bi bi-chevron-right text-muted font-11"></i>
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-box-seam-fill text-primary"></i>
                            <span class="fw-semibold text-heading">Product Module</span>
                        </div>
                        <i class="bi bi-chevron-right text-muted font-11"></i>
                    </a>

                    <a href="{{ route('admin.options.index') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-sliders2 text-info"></i>
                            <span class="fw-semibold text-heading">Option Module</span>
                        </div>
                        <i class="bi bi-chevron-right text-muted font-11"></i>
                    </a>

                    <a href="{{ route('admin.profile.index') }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between px-3 py-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-badge-fill text-secondary"></i>
                            <span class="fw-semibold text-heading">Admin Profile</span>
                        </div>
                        <i class="bi bi-chevron-right text-muted font-11"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchData();

            $(document).on('click', '.vk-notification-delete-btn', function (e) {

                e.preventDefault();
                e.stopPropagation();

                const id = $(this).data('id');

                deleteNotification(id);

            });

            $(document).on('click', '.vk-notification-item', async function (e) {

                if (!$(this).hasClass('unread')) return;

                const id = $(this).data('id');

                try {

                    await axios.post(`/admin/notifications/${id}/read`);

                    $(this).removeClass('unread');

                    updateNotificationCount();

                } catch (error) {

                    console.error('Notification read error:', error);

                }

            });

            $(document).on('click','#markAllReadBtn', async function (e) {
                e.preventDefault();
                try {

                    await axios.post('/admin/notifications/read-all');
                    
                    $('.vk-notification-item.unread').removeClass('unread');

                    updateNotificationCount();

                } catch (error) {
                    console.error('Mark all read error:', error);
                }

            });


        });

        function updateNotificationCount() {

            const unreadCount = $('.vk-notification-item.unread').length;

            $('#notificationCount').text(unreadCount);

            $('#notificationNewCount').text(`${unreadCount} New`);

        }

        function fetchData() {
            axios.get('/admin/dashboard')
            .then(response => {
            
                const productData = response.data.products;

                let data = ''

                $('.product-count').text(response.data.productCount);
                $('.category-count').text(response.data.categoryCount);
                $('.option-count').text(response.data.optionCount);
                $('.stock-count').text(response.data.stock);
                
                productData.slice(0, 7).forEach((element, index) => {
                    data += `
                        <tr>
                            <td class="ps-3 text-secondary fw-semibold font-13">
                                ${index + 1}
                            </td>
                            <td>
                                <img src="/storage/${element.image}" alt="${element.name}" class="d-flex align-items-center justify-content-center bg-light rounded"
                                    style="width: 48px; height: 48px; border: 1px solid rgba(0,0,0,0.08);">
                            </td>
                            <td>
                                <div class="fw-semibold text-heading font-14">
                                    ${element.name}
                                </div>
                                <small class="text-muted font-12">Vastrkaya Couture</small>
                            </td>
                            <td>
                                <span class="text-secondary font-13">
                                    ${element.category?.name ?? 'No Category'}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-heading">
                                    &#8377;${element.price}
                                </span>
                            </td>
                            <td>
                                <span class="badge text-dark px-2 py-1 font-12">
                                    ${element.stock ?? 0} Units
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <span class="badge text-success border border-success border-opacity-25 rounded-pill px-2 py-1 font-12">
                                    ${Number(element.status) === 1 ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                        </tr>
                    `;

                    $('.urgent-stock').html(response.data.UrgentStock.map((element) => {
                        return `
                            <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light border">
                                <div>
                                    <h6 class="mb-0 fw-bold text-heading font-13">${element.name}</h6>
                                    <small class="text-danger fw-semibold font-12">${element.stock} Units Left</small>
                                </div>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-sm border-danger py-1 px-2 font-12">
                                    Restock
                                </a>
                            </div>
                        `;
                    }).join(''));
                    if(response.data.UrgentStock == 0){
                        $('.urgent-stock').html(`<p class="text-center text-success fw-bold">No products left</p>`);
                    }
                    $('.producttbl').html(data);
                })

                fetchNotification();

            }).catch(err => {
                console.log(err);
            });

        }

        function fetchNotification() {
            
            let data = '';
            axios.get(`/admin/notifications`)
            .then(res => {
                let notifications = res.data.notifications;

                $('#notificationCount').text(notifications.length);

                if (notifications.length === 0) {

                    data = `
                        <div class="p-4 text-center text-muted font-13">
                            <i class="bi bi-bell-slash fs-4 d-block mb-1 text-light"></i>
                            No new notifications
                        </div>
                    `;

                } else {

                    notifications.forEach((n) => {

                        let status = n.data.order_status ?? 'Update';

                        let isCancelled = status.toLowerCase() === 'cancelled';

                        let iconClass = isCancelled
                            ? 'bg-danger-subtle text-danger'
                            : 'bg-success-subtle text-success';

                        let icon = isCancelled
                            ? 'bi-x-circle-fill'
                            : 'bi-check-circle-fill';

                        let unreadClass = n.read_at === null ? 'unread' : '';

                        let message = n.data.message ?? 'Notification details';

                        let createdAt = new Date(n.created_at).toLocaleString();

                        data += `
                            <div class="vk-notification-item ${unreadClass} d-flex align-items-center justify-content-between"
                                data-id="${n.id}">

                                <a
                                    class="d-flex align-items-start gap-3 text-decoration-none flex-grow-1 min-w-0 notify"
                                    style="color: inherit;">

                                    <div class="vk-notification-icon ${iconClass}">
                                        <i class="bi ${icon}"></i>
                                    </div>

                                    <div class="vk-notification-content">

                                        <div class="vk-notification-title">
                                            Order ${status.charAt(0).toUpperCase() + status.slice(1)}
                                        </div>

                                        <div class="vk-notification-desc">
                                            ${message}
                                        </div>

                                        <div class="vk-notification-time">
                                            <i class="bi bi-clock"></i>
                                            ${createdAt}
                                        </div>

                                    </div>
                                </a>

                                <button type="button"
                                    class="vk-notification-delete-btn" 
                                    data-id="${n.id}"
                                    data-response='${res}'
                                    title="Delete notification">

                                    <i class="bi bi-trash3"></i>

                                </button>

                            </div>
                        `;

                    });
                }
                
                $('#notificationList').html(data);
                updateNotificationCount();
            })
            .catch((err)=> {
                console.log(err);
            });

        }
        
        function deleteNotification(id) {
            
            axios.delete(`/admin/notifications/${id}`)
            .then((res)=> {
                if(res.data.success) {
                    $(`.vk-notification-item[data-id="${id}"]`).remove();                    
                    fetchNotification();
                }
            })
            .catch((err)=> {
                window.showToast?.('Error', 'Notification not deleted');
            })
        }

    </script>
@endsection