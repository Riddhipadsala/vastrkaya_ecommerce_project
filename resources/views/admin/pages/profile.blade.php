@extends('layouts.admin')

@section('title', 'Admin Profile Module - Vastrkaya Luxury E-Commerce')

@section('content')
<!-- Admin Hero Card -->
<div class="vk-profile-hero">
    <div class="row align-items-center g-4">
        <div class="col-md-auto text-center text-md-start">
            <div class="position-relative d-inline-block">
                <img id="adminAvatarPreview" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=250&q=80" alt="Admin Avatar" class="vk-profile-avatar-large">
                <label for="adminAvatarInput" class="position-absolute bottom-0 end-0 bg-danger text-white rounded-circle p-2 shadow" style="cursor: pointer; line-height: 1;" title="Change Photo">
                    <i class="bi bi-camera-fill font-13"></i>
                </label>
                <input type="file" id="adminAvatarInput" class="d-none" accept="image/*">
            </div>
        </div>
        <div class="col">
            <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                <h3 class="h4 fw-bold mb-0 text-white dynamic-admin-name">{{ Auth::user()->name ?? 'Administrator' }}</h3>
                <span class="badge bg-danger rounded-pill px-3 py-1 font-12 fw-bold">Super Admin</span>
                <span class="badge bg-success bg-opacity-25 text-white rounded-pill px-3 py-1 font-12"><i class="bi bi-shield-check"></i> Verified</span>
            </div>
            <p class="text-light text-opacity-75 mb-3 font-14">
                Master administrator account with full privileges across Catalog, Stock Inventory, System Roles, and E-Commerce Settings.
            </p>
            <div class="d-flex flex-wrap gap-3 font-13 text-light text-opacity-75">
                <div><i class="bi bi-envelope me-1"></i> {{ Auth::user()->email ?? 'admin@gmail.com' }}</div>
                <div><i class="bi bi-geo-alt me-1"></i> Surat, Gujarat, India</div>
                <div><i class="bi bi-clock-history me-1"></i> Joined: {{ date('M Y') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Edit Tabs -->
<div class="row g-4">
    <!-- Left: Form Settings -->
    <div class="col-lg-8">
        <div class="vk-card p-4">
            <ul class="nav vk-nav-tabs" id="profileTab" role="tablist">
                <li class="nav-item">
                    <button class="vk-tab-btn active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab">
                        <i class="bi bi-person-fill"></i> Personal Info
                    </button>
                </li>
                <li class="nav-item">
                    <button class="vk-tab-btn" id="security-tab" data-bs-toggle="tab" data-bs-target="#security-tab-pane" type="button" role="tab">
                        <i class="bi bi-shield-lock-fill"></i> Password & Security
                    </button>
                </li>
                <li class="nav-item">
                    <button class="vk-tab-btn" id="permissions-tab" data-bs-toggle="tab" data-bs-target="#permissions-tab-pane" type="button" role="tab">
                        <i class="bi bi-key-fill"></i> Role Permissions
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="profileTabContent">
                <!-- Tab 1: Personal Info -->
                <div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel">
                    <form action="{{ route('admin.profile.update', Auth::id() ?? 1) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="vk-form-label">Full Name</label>
                                <input type="text" name="name" class="vk-form-control" value="{{ Auth::user()->name ?? 'Admin User' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="vk-form-label">Email Address</label>
                                <input type="email" name="email" class="vk-form-control" value="{{ Auth::user()->email ?? 'admin@gmail.com' }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="vk-form-label">Phone Number</label>
                                <input type="tel" name="phone" class="vk-form-control" value="+91 98765 43210" placeholder="+91 XXXXX XXXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="vk-form-label">Designation / Role Title</label>
                                <input type="text" class="vk-form-control" value="Chief E-Commerce Administrator" readonly>
                            </div>
                            <div class="col-12">
                                <label class="vk-form-label">Admin Bio & Store Notes</label>
                                <textarea name="bio" class="vk-form-control" rows="3" placeholder="Tell something about your role...">Managing Vastrkaya premium apparel inventory, vendor logistics, and customer catalogs.</textarea>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="vk-btn vk-btn-primary">
                                    <i class="bi bi-check2"></i> Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tab 2: Security & Password -->
                <div class="tab-pane fade" id="security-tab-pane" role="tabpanel">
                    <form action="{{ route('admin.profile.update', Auth::id() ?? 1) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="update_password">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="vk-form-label">Current Password</label>
                                <input type="password" name="current_password" class="vk-form-control" placeholder="Enter current password" required>
                            </div>
                            <div class="col-md-6">
                                <label class="vk-form-label">New Password</label>
                                <input type="password" name="password" class="vk-form-control" placeholder="Min. 8 characters" required>
                            </div>
                            <div class="col-md-6">
                                <label class="vk-form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="vk-form-control" placeholder="Re-enter new password" required>
                            </div>
                            <div class="col-12 font-13 text-muted">
                                <i class="bi bi-shield-check text-success me-1"></i> Make sure password includes uppercase, lowercase, numbers, and symbols.
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="vk-btn vk-btn-primary">
                                    <i class="bi bi-key"></i> Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tab 3: Permissions List -->
                <div class="tab-pane fade" id="permissions-tab-pane" role="tabpanel">
                    <div class="p-3 rounded-3 bg-surface-subtle mb-3">
                        <div class="fw-bold text-heading mb-1">Active Role: <span class="text-danger">Admin</span></div>
                        <small class="text-muted">Synchronized directly with Spatie Laravel Permission Guard</small>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> view-dashboard</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> view-categories</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> create-categories</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> edit-categories</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> delete-categories</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> view-products</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> create-products</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> edit-products</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> delete-products</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> manage-inventory</span>
                        <span class="badge bg-success bg-opacity-10 text-success p-2"><i class="bi bi-check-circle me-1"></i> manage-settings</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Admin Activity & System Status Card -->
    <div class="col-lg-4">
        <div class="vk-card p-4">
            <h5 class="fw-bold mb-3 text-heading">Security & Sessions</h5>
            
            <div class="d-flex align-items-center gap-3 mb-3 p-3 rounded-3 bg-surface-subtle">
                <div class="vk-stat-icon-wrap bg-success bg-opacity-10 text-success">
                    <i class="bi bi-laptop fs-4"></i>
                </div>
                <div>
                    <div class="fw-bold text-heading font-14">Current Session</div>
                    <small class="text-muted">Chrome on Windows &bull; IP: 127.0.0.1</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3 bg-surface-subtle">
                <div class="vk-stat-icon-wrap bg-info bg-opacity-10 text-info">
                    <i class="bi bi-shield-lock fs-4"></i>
                </div>
                <div>
                    <div class="fw-bold text-heading font-14">Two-Factor Authentication</div>
                    <small class="text-muted">Recommended for high-privilege admins</small>
                </div>
            </div>

            <hr class="border-light">

            <h6 class="fw-bold mb-2 text-heading">Display Preferences</h6>
            <div class="d-flex align-items-center justify-content-between p-2">
                <span class="font-14 text-heading">Dark Theme Mode</span>
                <button type="button" class="vk-btn vk-btn-sm vk-btn-secondary" onclick="toggleTheme()">
                    <i class="bi bi-circle-half"></i> Toggle Theme
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
