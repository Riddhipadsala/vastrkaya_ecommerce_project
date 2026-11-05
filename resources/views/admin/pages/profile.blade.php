@extends('layouts.admin')

@section('title', 'Admin Profile Module - Vastrkaya Luxury E-Commerce')

@section('content')
<!-- Admin Hero Card -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                <h3 class="h4 fw-bold mb-0 text-white dynamic-admin-name">{{ $admin->name ?? 'Administrator' }}</h3>
                <span class="badge bg-danger rounded-pill px-3 py-1 font-12 fw-bold">Super Admin</span>
                <span class="badge bg-success bg-opacity-25 text-white rounded-pill px-3 py-1 font-12"><i class="bi bi-shield-check"></i> Verified</span>
            </div>
            <p class="text-light text-opacity-75 mb-3 font-14">
                Master administrator account with full privileges across Catalog, Stock Inventory, System Roles, and E-Commerce Settings.
            </p>
            <div class="d-flex flex-wrap gap-3 font-13 text-light text-opacity-75">
                <div><i class="bi bi-envelope me-1"></i> {{ Auth::user()->email ?? 'admin@gmail.com' }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Edit Tabs -->
<div class="row g-4">
    <!-- Left: Form Settings -->
    <div class="col-lg-12">
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
                                <input type="tel" name="phone" class="vk-form-control" value="{{ Auth::user()->phone }}" placeholder="+91 XXXXX XXXXX">
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

            </div>
        </div>
    </div>

</div>
@endsection
