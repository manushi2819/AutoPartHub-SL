@extends('AdminDashboard.index')

@section('title', 'Vendor Earnings')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.status-pending { background: #fff3cd; color: #92660d; }
.status-paid { background: #d1f2dd; color: #0f5132; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Vendor Earnings (Card Orders)</h6>
</div>

{{-- TABS --}}
<ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('admin.vendor-earnings.index', ['tab' => 'pending']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'pending' ? 'active' : '' }}">
            Vendors With Pending Earnings
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ route('admin.vendor-earnings.index', ['tab' => 'history']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'history' ? 'active' : '' }}">
            Settlement History
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
                                <th>Vendor</th>
                                <th>Vendor Contact</th>
                                <th>Vendor Address</th>
                                <th class="text-end">Pending Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendors as $vendor)
                                <tr>
                                    <td>{{ $vendor->shop_name ?? $vendor->name }}</td>
                                    <td>{{ $vendor->email ?? '' }} - {{ $vendor->phone ?? '' }}</td>
                                    <td>{{ $vendor->address ?? '' }} - {{ $vendor->district ?? '' }}</td>
                                    <td class="text-end fw-bold">Rs. {{ number_format($vendor->pending_total, 2) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.vendor-earnings.vendor', $vendor->id) }}" class="btn btn-sm btn-primary">
                                            Review &amp; Settle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@else
    <div class="card basic-data-table shadow-sm border-0 mb-3">
        <div class="card-body">
                <div class="table-responsive">
                     <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Vendor</th>
                                <th>Vendor Contact</th>
                                <th>Period</th>
                                <th class="text-end">Amount</th>
                                <th>Reference</th>
                                <th>Paid On</th>
                                <th>Slip</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settlements as $settlement)
                                <tr>
                                    <td>{{ $settlement->vendor->shop_name ?? $settlement->vendor->name }}</td>
                                    <td>{{ $settlement->vendor->email ?? '' }} - {{ $settlement->vendor->phone ?? '' }}</td>
                                    <td>{{ $settlement->period_start->format('M d') }} – {{ $settlement->period_end->format('M d, Y') }}</td>
                                    <td class="text-end fw-bold">Rs. {{ number_format($settlement->total_amount, 2) }}</td>
                                    <td>{{ $settlement->transfer_reference ?? '—' }}</td>
                                    <td>{{ $settlement->paid_at->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        @if($settlement->payment_slip)
                                            <a href="{{ asset($settlement->payment_slip) }}" target="_blank" class="text-primary">
                                                <i class="fa-solid fa-receipt"></i> View
                                            </a>
                                        @endif
                                    </td>
                                     <td class="text-center">
                                        <a href="{{ route('admin.vendor-earnings.settlement.show', $settlement->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-eye"></i> Details
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