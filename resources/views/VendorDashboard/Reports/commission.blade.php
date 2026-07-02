@extends('VendorDashboard.index')

@section('title', 'My Commission Report')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 3px 9px; border-radius: 20px; font-weight: 500; }
.status-pending { background: #fff3cd; color: #92660d; }
.status-paid { background: #d1f2dd; color: #0f5132; }
.status-submitted { background: #cfe2ff; color: #084298; }
.status-rejected { background: #f8d7da; color: #842029; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>My Commission Report</h6>
    <a href="{{ route('vendor.reports.commission.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
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
                <a href="{{ route('vendor.reports.commission') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row row-cols-md-3 row-cols-2 gy-3 mb-3">
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #2994ff !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Card Commission (Retained by Admin)</p>
                <h6 class="mb-0">Rs. {{ number_format($card_total, 2) }}</h6>
                <small class="text-muted">Settled: Rs. {{ number_format($card_paid, 2) }} | Pending: Rs. {{ number_format($card_pending, 2) }}</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #FF9F29 !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">COD Commission Due to Admin</p>
                <h6 class="mb-0 fw-bold">Rs. {{ number_format($cod_pending, 2) }}</h6>
                <small class="text-muted">Settled: Rs. {{ number_format($cod_paid, 2) }}</small>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="border-left: 3px solid #0db020 !important;">
            <div class="card-body">
                <p class="text-muted mb-1 small">Total Commission (All)</p>
                <h6 class="mb-0">Rs. {{ number_format($card_total + $cod_total, 2) }}</h6>
            </div>
        </div>
    </div>
</div>


{{-- Unified Commission Report Table --}}
<div class="card basic-data-table shadow-sm border-0 mb-3">
    <div class="card-header text-white" style="background-color: #007bff42;">
        <h6 class="mb-0" style="font-size: 17px !important;">Commission Report (All Transactions)</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0 align-middle" id="dataTable" data-page-length='10'>
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Order #</th>
                        <th>Product</th>
                        <th>Payment Method</th>
                        <th class="text-end">Commission</th>
                        <th>Status</th>
                        <th>Note</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($report_rows as $row)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($row['date'])->format('M d, Y') }}
                            </td>

                            <td>
                                {{ $row['order_number'] ?? '-' }}
                            </td>

                            <td>
                                {{ \Illuminate\Support\Str::limit($row['product'] ?? '-', 30) }}
                            </td>

                            <td>
                                {{ $row['payment_method'] }}
                            </td>

                            <td class="text-end">
                                Rs. {{ number_format($row['amount'], 2) }}
                            </td>

                            <td>
                                <span class="status-pill status-{{ strtolower($row['status']) }}">
                                    {{ $row['status'] }}
                                </span>
                            </td>

                            <td>
                                {{ $row['remarks'] ?? '-' }}
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