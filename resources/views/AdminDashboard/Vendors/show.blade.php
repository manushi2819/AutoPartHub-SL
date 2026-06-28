@extends('AdminDashboard.index')

@section('title', 'Vendor Details')

@section('content')

<style>
@media (max-width: 767.98px) {
    .row.g-4 {
        flex-direction: column;
    }

    .col-8, .col-4 {
        width: 100% !important;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .card-body {
        padding: 0.75rem !important;
    }

    h6, h4, .fw-semibold {
        font-size: 1rem !important;
    }
}

 h6 {
    font-size: 18px !important;
}

.vendor-logo-box{
    width: 90px;
    height: 90px;
    border-radius: 14px;
    overflow: hidden;
    background: #111;
    flex-shrink: 0;
}

.vendor-logo-box img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.stat-box{
    text-align: center;
    padding: 14px 10px;
    border-radius: 10px;
    background: #f8f9fa;
}

.stat-box .stat-num{
    font-size: 1.4rem;
    font-weight: 700;
    color: #007bff;
}

.stat-box .stat-label{
    font-size: 0.78rem;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.product-thumb{
    width: 50px;
    height: 50px;
    border-radius: 6px;
    overflow: hidden;
    background: #f5f5f5;
}

.product-thumb img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Vendor Details - {{ $vendor->shop_name }}</h6>
    <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="iconify" data-icon="mdi:arrow-left"></i> Back
    </a>
</div>

<div class="row g-4">

    {{-- Left: Vendor Info --}}
    <div class="col-8">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff60;">
                <h6 class="mb-0">Vendor Information</h6>
            </div>
            <div class="card-body">

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="vendor-logo-box">
                        @if($vendor->logo)
                            <img src="{{ asset($vendor->logo) }}" alt="{{ $vendor->shop_name }}">
                        @else
                            <img src="{{ asset('images/default-shop.png') }}" alt="{{ $vendor->shop_name }}">
                        @endif
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $vendor->shop_name }}</h5>
                        @if($vendor->found_year)
                            <p class="text-muted mb-1">Since {{ $vendor->found_year }}</p>
                        @endif
                        <span class="px-3 py-1 rounded-pill fw-medium text-sm
                            {{ $vendor->status == 'Approved' ? 'bg-success-focus text-success-main' : 'bg-warning-focus text-warning-main' }}">
                            {{ $vendor->status }}
                        </span>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-6">
                        <p class="mb-1"><strong>Owner Name:</strong> {{ $vendor->owner_name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $vendor->email }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $vendor->phone }}</p>
                        <p class="mb-1"><strong>NIC:</strong> {{ $vendor->nic }}</p>
                        <p class="mb-1"><strong>Province:</strong> {{ $vendor->province }}</p>
                        <p class="mb-1"><strong>Address:</strong> {{ $vendor->address }},  {{ $vendor->district }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><strong>Bank Name:</strong> {{ $vendor->bank_name }}</p>
                        <p class="mb-1"><strong>Branch Name:</strong> {{ $vendor->branch_name }}</p>
                        <p class="mb-1"><strong>Account Name:</strong> {{ $vendor->account_name }}</p>
                        <p class="mb-1"><strong>Account Number:</strong> {{ $vendor->account_number }}</p>
                    </div>
                </div>

                @if($vendor->description)
                    <hr class="my-3">
                    <p class="mb-0">{{ $vendor->description }}</p>
                @endif

            </div>
        </div>
    </div>

    {{-- Right: Stats & Documents --}}
    <div class="col-4">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff60;">
                <h6 class="mb-0">Summary</h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-num">{{ $productsCount }}</div>
                            <div class="stat-label">Products</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-num">{{ $ordersCount }}</div>
                            <div class="stat-label">Orders</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-num">{{ $totalStock }}</div>
                            <div class="stat-label">In Stock</div>
                        </div>
                    </div>
                </div>

                <hr class="my-3">

                <p class="mb-1"><strong>Approved At:</strong>
                    {{ $vendor->approved_at ? \Carbon\Carbon::parse($vendor->approved_at)->format('F d, Y') : 'Not approved yet' }}
                </p>
                <p class="mb-0"><strong>Joined:</strong> {{ $vendor->created_at->format('F d, Y') }}</p>
            </div>
        </div>

       
    </div>

</div>

{{-- Products Table --}}
<div class="card basic-data-table shadow-sm border-0 mb-3">
    <div class="card-header text-white" style="background-color: #007bff60;">
        <h6 class="mb-0">Products ({{ $productsCount }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
           <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Commission</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendor->products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="product-thumb">
                                    @if($product->images->count())
                                        <img src="{{ asset('uploads/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('no-image.png') }}" alt="No image">
                                    @endif
                                </div>
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($product->name, 30) }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>Rs. {{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->vendor_percentage  ?? '' }} % - {{ number_format($product->vendor_commission_amount, 2) }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                <span class="px-3 py-1 rounded-pill fw-medium text-sm
                                    {{ $product->status ? 'bg-success-focus text-success-main' : 'bg-warning-focus text-warning-main' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No products found for this vendor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection