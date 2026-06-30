@extends('VendorDashboard.index')

@section('title', 'My Earnings')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.status-pending { background: #fff3cd; color: #92660d; }
.status-paid { background: #d1f2dd; color: #0f5132; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>My Earnings (Card Orders)</h6>
</div>


{{-- TABS --}}
<ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('vendor.earnings.index', ['tab' => 'pending']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'pending' ? 'active' : '' }}">
            Pending Earnings  <span class="badge bg-light text-dark">
                Total: Rs. ({{ number_format($pending->sum('earning_amount'), 2) }})
            </span>
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ route('vendor.earnings.index', ['tab' => 'history']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'history' ? 'active' : '' }}">
            Settlement History
        </a>
    </li>
</ul>

@if($tab == 'pending')
    <div class="card basic-data-table shadow-sm border-0 mb-3">
        <div class="card-body">
                  <p class="text-danger" style="font-size:12px">**
                    These earnings will be transferred to your bank account by admin during the next weekly settlement.
                </p>
                <div class="table-responsive">
                    <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th class="text-end">Earning Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pending as $earning)
                                <tr>
                                    <td>{{ $earning->order->order_number ?? '—' }}</td>
                                    <td>{{ $earning->product->name ?? 'N/A' }}</td>
                                    <td>{{ $earning->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">Rs. {{ number_format($earning->earning_amount, 2) }}</td>
                                    <td><span class="status-pill status-pending">Pending</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@else
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
                <div class="table-responsive">
                    <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Period</th>
                                <th class="text-end">Amount</th>
                                <th>Reference</th>
                                <th>Paid On</th>
                                <th class="text-center">Slip</th>
                                <th class="text-center">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settlements as $settlement)
                                <tr>
                                    <td>{{ $settlement->period_start->format('M d') }} – {{ $settlement->period_end->format('M d, Y') }}</td>
                                    <td class="text-end fw-bold">Rs. {{ number_format($settlement->total_amount, 2) }}</td>
                                    <td>{{ $settlement->transfer_reference ?? '—' }}</td>
                                    <td>{{ $settlement->paid_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        @if($settlement->payment_slip)
                                            <a href="{{ asset($settlement->payment_slip) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                <i class="fa-solid fa-receipt"></i>
                                            </a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('vendor.earnings.settlement.show', $settlement->id) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endif

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection