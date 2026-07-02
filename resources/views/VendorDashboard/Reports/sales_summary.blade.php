@extends('VendorDashboard.index')

@section('title', 'My Sales Summary')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>My Sales Summary</h6>
    <a href="{{ route('vendor.reports.sales-summary.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
        <i class="fa-solid fa-file-pdf me-1"></i> Download PDF
    </a>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">From</label>
                <input type="date" name="start_date" class="form-control" value="{{ $period_start->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">To</label>
                <input type="date" name="end_date" class="form-control" value="{{ $period_end->format('Y-m-d') }}">
            </div>
            <div class="col-md-2">
                  <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('vendor.reports.sales-summary') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Headline Stats --}}
<div class="row row-cols-md-4 row-cols-2 gy-3 mb-3">
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #1b92c5 !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Total Orders</p>
                <h5 class="mb-0 text-primary">{{ number_format($total_orders) }}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #484848 !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Total Revenue</p>
                <h5 class="mb-0">Rs. {{ number_format($total_revenue, 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #e2b632 !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Commission Paid</p>
                <h5 class="mb-0 text-warning">Rs. {{ number_format($total_commission, 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #16A34A !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Net Earnings</p>
                <h5 class="mb-0 text-success">Rs. {{ number_format($total_earnings, 2) }}</h5>
            </div>
        </div>
    </div>
</div>

{{-- Payment Method Split --}}
<div class="row row-cols-md-2 row-cols-1 gy-3 mb-3">
    <div class="col">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted fw-bold mb-1 small">Card Sales</p>
                <h6 class="mb-0">Net Earning: Rs. {{ number_format($card_earning, 2) }}</h6>
                <small class="text-muted">Commission: Rs. {{ number_format($card_revenue - $card_earning, 2) }}</small>
                <br><small class="text-muted">Admin transfers this to you weekly</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted  fw-bold mb-1 small">COD Sales</p>
                <h6 class="mb-0">Net Earning: Rs. {{ number_format($cod_earning, 2) }}</h6>
                <small class="text-muted">Commission: Rs. {{ number_format($cod_revenue - $cod_earning, 2) }}</small>
                <br><small class="text-muted">You hold the cash — pay commission to admin</small>
            </div>
        </div>
    </div>
</div>

{{-- Order Details --}}
<div class="card  basic-data-table shadow-sm border-0 mb-3">
    <div class="card-header text-white" style="background-color: #007bff42;">
        <h6 class="mb-0">Order Details</h6>
    </div>
    <div class="card-body">
        @if(count($order_details) === 0)
            <p class="text-muted mb-0">No order details in this period.</p>
        @else
            <div class="table-responsive">
                <table class="table basic-border-table mb-0 align-middle" id="dataTable" data-page-length='10'>
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Order #</th>
                            <th>Customer Name</th>
                            <th>Customer Contact</th>
                            <th>Customer Address</th>
                            <th>Product</th>
                            <th class="text-end">Qty</th>
                            <th>Payment Method</th>
                            <th class="text-end">Revenue</th>
                            <th class="text-end">Commission</th>
                            <th class="text-end">Net Earning</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order_details as $row)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($row['date'])->format('M d, Y') }}</td>
                                <td>{{ $row['order_number'] ?? '-' }}</td>
                                <td>{{ $row['customer_name'] ?? '-' }}</td>
                                <td>{{ $row['customer_contact'] ?? '-' }}</td>
                                <td>{{ $row['customer_address'] ?? '-' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($row['product'], 40) }}</td>
                                <td class="text-end">{{ $row['quantity'] }}</td>
                                <td>{{ ucfirst($row['payment_method'] ?? '-') }}</td>
                                <td class="text-end">Rs. {{ number_format($row['revenue'], 2) }}</td>
                                <td class="text-end text-warning">Rs. {{ number_format($row['commission'], 2) }}</td>
                                <td class="text-end fw-bold text-success">Rs. {{ number_format($row['earning'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection