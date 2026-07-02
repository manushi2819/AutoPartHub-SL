@extends('VendorDashboard.index')

@section('title', 'My Earnings')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.status-pending { background: #fff3cd; color: #92660d; }
.status-paid { background: #d1f2dd; color: #0f5132; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>My Earnings (COD Orders)</h6>
</div>


{{-- TABS --}}
<ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('vendor.earnings.cod.index', ['tab' => 'pending']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'pending' ? 'active' : '' }}">
            Pending Earnings  <span class="badge bg-light text-dark">
                Total: Rs. ({{ number_format($pending->sum('earning_amount'), 2) }})
            </span>
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ route('vendor.earnings.cod.index', ['tab' => 'history']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'history' ? 'active' : '' }}">
            Paid Earnings  <span class="badge bg-light text-dark">
                Total: Rs. ({{ number_format($paid->sum('total_amount'), 2) }})
            </span>
        </a>
    </li>
</ul>

@if($tab == 'pending')
    <div class="card basic-data-table shadow-sm border-0 mb-3">
        <div class="card-body">
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
                                <th>Order #</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th class="text-end">Earning Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paid as $paidearning)
                                <tr>
                                    <td>{{ $paidearning->order->order_number ?? '—' }}</td>
                                    <td>{{ $paidearning->product->name ?? 'N/A' }}</td>
                                    <td>{{ $paidearning->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">Rs. {{ number_format($paidearning->earning_amount, 2) }}</td>
                                    <td><span class="status-pill status-paid ">Paid</span></td>
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