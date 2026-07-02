@extends('VendorDashboard.index')

@section('title', 'Sales & Earnings Report')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 3px 9px; border-radius: 20px; font-weight: 500; }
.status-pending { background: #fff3cd; color: #92660d; }
.status-paid { background: #d1f2dd; color: #0f5132; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Sales & Earnings Report</h6>
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
                <p class="text-muted mb-1 small">Commission</p>
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

<div class="row row-cols-md-2 row-cols-1 gy-3 mb-3">
    <div class="col">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted fw-bold mb-1 small">Card Sales</p>
                <h6 class="mb-0">Net Earning: Rs. {{ number_format($card_earning, 2) }}</h6>
                <small class="text-muted">Commission: Rs. {{ number_format($card_revenue - $card_earning, 2) }}</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted fw-bold mb-1 small">COD Sales</p>
                <h6 class="mb-0">Net Earning: Rs. {{ number_format($cod_earning, 2) }}</h6>
                <small class="text-muted">Commission: Rs. {{ number_format($cod_revenue - $cod_earning, 2) }}</small>
            </div>
        </div>
    </div>
</div>


<div class="card shadow-sm border-0 mb-3">
    <div class="card-header text-white" style="background-color: #0aac3e42;">
        <h6 class="mb-0" style="font-size: 17px !important;">Earnings Summary</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="border rounded p-3">
                    <small class="text-muted">Total Earned</small>
                    <h6 class="mb-0">Rs. {{ number_format($total_earned, 2) }}</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-3">
                    <small class="text-muted">Transferred to You</small>
                    <h6 class="mb-0 text-success">Rs. {{ number_format($total_paid, 2) }}</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded p-3">
                    <small class="text-muted">Pending</small>
                    <h6 class="mb-0 text-warning">Rs. {{ number_format($total_pending, 2) }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-header text-white" style="background-color: #007bff42;">
        <h6 class="mb-0" style="font-size: 17px !important;">Order Details</h6>
    </div>
    <div class="card-body">
            <div class="table-responsive">
                <table class="table basic-border-table mb-0 align-middle" id="dataTable" data-page-length='10'>
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Order #</th>
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
    </div>
</div>



<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection
