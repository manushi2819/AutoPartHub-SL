@extends('AdminDashboard.index')

@section('title', 'Income Report')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Income Report</h6>
    <a href="{{ route('admin.reports.income.pdf', request()->query()) }}" class="btn btn-danger btn-sm">
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
                <a href="{{ route('admin.reports.income') }}" class="btn btn-secondary btn-sm">Reset</a>
            </div>

        </form>
    </div>
</div>

<div class="row row-cols-md-3 row-cols-1 gy-4 mb-3">
    <div class="col">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Orders Income</p>
                <h5 class="mb-0">Rs. {{ number_format($own_store_earnings, 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Total Commission Earned</p>
                <h5 class="mb-0">Rs. {{ number_format($total_commission, 2) }}</h5>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card shadow-sm border-0 h-100" style="background:#007bff10;">
            <div class="card-body">
                <p class="text-muted mb-1">Total Income</p>
                <h5 class="mb-0 text-primary fw-bold">Rs. {{ number_format($total_income, 2) }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="card basic-data-table shadow-sm border-0 mb-3">
    <div class="card-body">
            <div class="table-responsive">
                <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Order No</th>
                        <th>Vendor</th>
                        <th class="text-end">Vendor Earning</th>
                        <th class="text-end">Commission Income</th>
                        <th class="text-end">Total Income</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($income_details as $item)
                        <tr>
                            <td>{{ $item->created_at->format('Y-m-d H:i A') }}</td>
                            <td>{{ $item->order->order_number ?? '-' }}</td>
                            <td>
                                {{ $item->vendor->shop_name
                                    ?? $item->vendor->owner_name
                                    ?? 'Vendor #' . $item->vendor_id }}
                            </td>
                            <td class="text-end">
                                Rs. {{ number_format($item->vendor_earning_amount, 2) }}
                            </td>
                            <td class="text-end">
                                Rs. {{ number_format($item->vendor_commission_amount, 2) }}
                            </td>
                            <td class="text-end fw-bold text-success">
                                Rs.
                                {{ number_format(
                                    $item->vendor_id == 1
                                        ? $item->vendor_earning_amount
                                        : $item->vendor_commission_amount,
                                    2
                                ) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
    </div>
</div>
 
@endsection