@extends('AdminDashboard.index')

@section('title', 'Vendor Performance Report')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Vendor Performance / Settlement Report</h6>
    <a href="{{ route('admin.reports.vendor-performance.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
        <i class="fa-solid fa-file-pdf me-1"></i> Download PDF
    </a>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">From</label>
                <input type="date" name="start_date" class="form-control" value="{{ $start->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">To</label>
                <input type="date" name="end_date" class="form-control" value="{{ $end->format('Y-m-d') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.reports.vendor-performance') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card basic-data-table shadow-sm border-0 mb-3">
    <div class="card-body">
            <div class="table-responsive">
               <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                    <thead class="table-light">
                        <tr>
                            <th>Vendor</th>
                            <th class="text-end">Orders</th>
                            <th class="text-end">Total Sales</th>
                            <th class="text-end">Commission Generated</th>
                            <th class="text-end">Commission Collected</th>
                            <th class="text-end">Commission Pending</th>
                            <th class="text-end">Earnings Paid</th>
                            <th class="text-end">Earnings Pending</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendors as $row)
                            <tr>
                                <td>{{ $row->vendor->shop_name ?? $row->vendor->name ?? 'Vendor #' . $row->vendor->id }}</td>
                                <td class="text-end">{{ $row->order_count }}</td>
                                <td class="text-end">Rs. {{ number_format($row->total_sales, 2) }}</td>
                                <td class="text-end">Rs. {{ number_format($row->total_commission_generated, 2) }}</td>
                                <td class="text-end text-success">Rs. {{ number_format($row->commission_paid, 2) }}</td>
                                <td class="text-end text-warning">Rs. {{ number_format($row->commission_pending, 2) }}</td>
                                <td class="text-end text-success">Rs. {{ number_format($row->earnings_paid, 2) }}</td>
                                <td class="text-end text-warning">Rs. {{ number_format($row->earnings_pending, 2) }}</td>

                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
</div>

@endsection