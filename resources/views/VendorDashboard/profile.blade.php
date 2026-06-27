@extends('VendorDashboard.master')

@section('title', 'Vendor Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-24">
    <h6 class="fw-semibold mb-0">Vendor Profile</h6>
    <a href="{{ route('vendor.dashboard') }}" class="btn btn-secondary btn-sm">Back</a>
</div>


<div class="row g-4">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="mb-16 d-flex justify-content-center">
                    @if($vendor->logo)
                        <img src="{{ asset($vendor->logo) }}" alt="Vendor Logo" class="rounded-circle border" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="rounded-circle border d-flex align-items-center justify-content-center bg-light" style="width: 120px; height: 120px; font-size: 42px; font-weight: 700; color: #6c757d;">
                            {{ strtoupper(substr($vendor->shop_name ?? 'V', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <h6 class="fw-semibold mb-8">{{ $vendor->shop_name }}</h6>
                <p class="text-muted mb-16">{{ $vendor->owner_name }}</p>

                <ul class="list-unstyled mb-0 text-start">
                    <li class="mb-12"><strong>Email:</strong> {{ $vendor->email }}</li>
                    <li class="mb-12"><strong>Phone:</strong> {{ $vendor->phone }}</li>
                    <li class="mb-12"><strong>NIC:</strong> {{ $vendor->nic }}</li>
                    <li class="mb-12"><strong>Address:</strong> {{ $vendor->address }}</li>
                    <li class="mb-12"><strong>District:</strong> {{ $vendor->district }}</li>
                    <li class="mb-12"><strong>Province:</strong> {{ $vendor->province }}</li>
                    <li class="mb-12"><strong>Status:</strong> {{ $vendor->status }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills mb-20">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#editProfile">Edit Profile</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#changePassword">Change Password</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="editProfile">
                        <form method="POST" action="{{ route('vendor.profile.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Shop Name <span class="text-danger">*</span></label>
                                    <input type="text" name="shop_name" value="{{ old('shop_name', $vendor->shop_name) }}" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Owner Name <span class="text-danger">*</span></label>
                                    <input type="text" name="owner_name" value="{{ old('owner_name', $vendor->owner_name) }}" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', $vendor->email) }}" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" value="{{ old('phone', $vendor->phone) }}" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">NIC <span class="text-danger">*</span></label>
                                    <input type="text" name="nic" value="{{ old('nic', $vendor->nic) }}" class="form-control" required>
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $vendor->address) }}" class="form-control">
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">District</label>
                                    <input type="text" name="district" value="{{ old('district', $vendor->district) }}" class="form-control">
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Province</label>
                                    <input type="text" name="province" value="{{ old('province', $vendor->province) }}" class="form-control">
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Bank Name</label>
                                    <input type="text" name="bank_name" value="{{ old('bank_name', $vendor->bank_name) }}" class="form-control">
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Branch Name</label>
                                    <input type="text" name="branch_name" value="{{ old('branch_name', $vendor->branch_name) }}" class="form-control">
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Account Name</label>
                                    <input type="text" name="account_name" value="{{ old('account_name', $vendor->account_name) }}" class="form-control">
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Account Number</label>
                                    <input type="text" name="account_number" value="{{ old('account_number', $vendor->account_number) }}" class="form-control">
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Logo</label>
                                    <input type="file" name="logo" class="form-control">
                                </div>

                                <div class="col-md-6 mb-20">
                                    <label class="form-label fw-semibold">Banner</label>
                                    <input type="file" name="banner" class="form-control">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-sm">Save Changes</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="changePassword">
                        <form method="POST" action="{{ route('vendor.profile.password') }}">
                            @csrf

                            <div class="mb-20">
                                <label class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-20">
                                <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success btn-sm">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
