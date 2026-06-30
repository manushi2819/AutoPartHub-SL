@extends('VendorDashboard.index')

@section('title', 'Admin Commissions (Card)')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.status-pending { background: #fff3cd; color: #92660d; }
.status-paid { background: #d1f2dd; color: #0f5132; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Admin Commissions — Card Orders</h6>
</div>

{{-- TABS --}}
<ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('vendor.commissions-card.index', ['tab' => 'pending']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'pending' ? 'active' : '' }}">
            Pending Commissions <span class="badge bg-light text-dark">
                (Total: Rs. {{ number_format($pending->sum('commission_amount'), 2) }})
                </span>
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ route('vendor.commissions-card.index', ['tab' => 'history']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'history' ? 'active' : '' }}">
            Settlement History
        </a>
    </li>
</ul>

@if($tab == 'pending')
    <div class="card basic-data-table shadow-sm border-0 mb-3">
        <div class="card-body">

                <p class="text-danger" style="font-size:12px">**
                    These amounts are already retained by admin from card payments — no action needed from you. This is for your reference only.
                </p>
                <div class="table-responsive">
                    <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th class="text-end">Commission Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pending as $commission)
                                <tr>
                                    <td>{{ $commission->order->order_number ?? '—' }}</td>
                                    <td>{{ $commission->product->name ?? 'N/A' }}</td>
                                    <td>{{ $commission->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">Rs. {{ number_format($commission->commission_amount, 2) }}</td>
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
                                <th>Marked Paid On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settlements as $settlement)
                                <tr>
                                    <td>{{ $settlement->period_start->format('M d') }} – {{ $settlement->period_end->format('M d, Y') }}</td>
                                    <td class="text-end fw-bold">Rs. {{ number_format($settlement->total_amount, 2) }}</td>
                                    <td>{{ $settlement->reviewed_at?->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endif
@endsection