@extends('VendorDashboard.index')

@section('title', 'Payout History')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h6>Payout History</h6>
    <a href="{{ route('vendor.reports.settlement-report.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
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
                <a href="{{ route('vendor.reports.settlement-report') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="border rounded p-3">
                    <small class="text-muted">Total Paid Out</small>
                    <h6 class="mb-0">Rs. {{ number_format($total_paid, 2) }}</h6>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table basic-border-table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Paid Date</th>
                        <th>Period</th>
                        <th>Reference</th>
                        <th class="text-end">Amount</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($settlements as $settlement)
                        <tr>
                            <td>{{ $settlement->paid_at ? $settlement->paid_at->format('M d, Y') : '-' }}</td>
                            <td>{{ $settlement->period_start->format('M d, Y') }} - {{ $settlement->period_end->format('M d, Y') }}</td>
                            <td>{{ $settlement->transfer_reference ?? '-' }}</td>
                            <td class="text-end">Rs. {{ number_format($settlement->total_amount, 2) }}</td>
                            <td>{{ $settlement->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection
