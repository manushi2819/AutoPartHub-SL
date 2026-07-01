@extends('AdminDashboard.index')

@section('title','Vendors')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Vendors</h6>

    <a href="{{ route('admin.reports.vendors.pdf', request()->query()) }}"
       class="btn btn-danger btn-sm">
        <i class="fa-solid fa-file-pdf me-1"></i> Download PDF
    </a>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">

        <form method="GET" class="row g-3 align-items-end">

            <div class="col-md-4">
                <label>From</label>
                <input type="date"
                       name="start_date"
                       class="form-control"
                       value="{{ $start->format('Y-m-d') }}">
            </div>

            <div class="col-md-4">
                <label>To</label>
                <input type="date"
                       name="end_date"
                       class="form-control"
                       value="{{ $end->format('Y-m-d') }}">
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary btn-sm">Filter</button>

                <a href="{{ route('admin.reports.vendors') }}"
                   class="btn btn-secondary btn-sm">
                    Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vendor</th>
                        <th>Vendor contact</th>
                        <th>Vendor Address</th>
                        <th>Owner</th>
                        <th class="text-end">Total Orders</th>
                        <th class="text-end">Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendors as $index=>$vendor)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>
                                {{ $vendor->vendor->shop_name ?? '-' }}
                            </td>
                            <td>
                                {{ $vendor->vendor->email ?? '-' }} - {{ $vendor->vendor->phone ?? '-' }}
                            </td>
                            <td>
                                {{ $vendor->vendor->address ?? '-' }}, {{ $vendor->vendor->district ?? '-' }}
                            </td>
                            <td>
                                {{ $vendor->vendor->owner_name ?? '-' }}
                            </td>
                            <td class="text-end">
                                {{ number_format($vendor->total_orders) }}
                            </td>
                            <td class="text-end fw-bold">
                                Rs. {{ number_format($vendor->total_sales,2) }}
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection