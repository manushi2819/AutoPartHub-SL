@extends('VendorDashboard.index')

@section('title', 'Earnings Report')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 3px 9px; border-radius: 20px; font-weight: 500; }
.status-pending { background: #fff3cd; color: #92660d; }
.status-paid { background: #d1f2dd; color: #0f5132; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Earnings Report</h6>
    <a href="{{ route('vendor.reports.earnings.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
        <i class="fa-solid fa-file-pdf me-1"></i> Download PDF
    </a>
</div>

{{-- Date Filter --}}
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
                <a href="{{ route('vendor.reports.earnings') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Headline Stats --}}
<div class="row row-cols-md-3 row-cols-2 gy-3 mb-3">
    <div class="col">
        <div class="card shadow-sm border-0 h-100"  style="border-left: 3px solid #313131 !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Total Earned</p>
                <h6 class="mb-0">Rs. {{ number_format($total_earned, 2) }}</h6>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #0aac3e !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Transferred to You</p>
                <h6 class="mb-0 text-success">Rs. {{ number_format($total_paid, 2) }}</h6>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #ffd448 !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Pending</p>
                <h6 class="mb-0 text-warning">Rs. {{ number_format($total_pending, 2) }}</h6>
            </div>
        </div>
    </div>
</div>

{{-- Earnings Breakdown --}}
<div class="card basic-data-table shadow-sm border-0 mb-3">
    <div class="card-body">
            <div class="table-responsive">
                <table class="table basic-border-table mb-0 align-middle" id="dataTable" data-page-length='10'>
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Product</th>
                            <th>Date</th>
                            <th>Payment</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">Commission</th>
                            <th class="text-end">Net Earning</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($earnings as $earning)
                            <tr>
                                <td>{{ $earning->order->order_number ?? '—' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($earning->product->name ?? 'N/A', 30) }}</td>
                                <td>{{ $earning->created_at->format('M d, Y') }}</td>
                                <td>{{ $earning->order->payment_method ?? '—' }}</td>
                                <td class="text-end">Rs. {{ number_format($earning->orderItem->subtotal ?? 0, 2) }}</td>
                                <td class="text-end">Rs. {{ number_format($earning->orderItem->vendor_commission_amount ?? 0, 2) }}</td>
                                <td class="text-end text-success fw-bold">Rs. {{ number_format($earning->earning_amount, 2) }}</td>
                                <td>
                                    <span class="status-pill status-{{ $earning->status }}">
                                        {{ ucfirst($earning->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>
</div>


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection