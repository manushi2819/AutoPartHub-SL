@extends('AdminDashboard.index')

@section('title', 'Vendor Commissions (Card)')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.status-pending { background: #fff3cd; color: #92660d; }
.status-paid { background: #d1f2dd; color: #0f5132; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Vendor Commissions — Card Orders</h6>
</div>

{{-- TABS --}}
<ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('admin.vendor-commissions-card.index', ['tab' => 'pending']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'pending' ? 'active' : '' }}">
            Vendors With Pending Commissions
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ route('admin.vendor-commissions-card.index', ['tab' => 'history']) }}"
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
                                        <a href="{{ route('admin.vendor-commissions-card.vendor', $vendor->id) }}" class="btn btn-sm btn-primary">
                                            Review &amp; Mark Paid
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
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
                <div class="table-responsive">
                     <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Vendor</th>
                                <th>Vendor Contact</th>
                                <th>Period</th>
                                <th class="text-end">Amount</th>
                                <th>Marked Paid On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settlements as $settlement)
                                <tr>
                                    <td>{{ $settlement->vendor->shop_name ?? $settlement->vendor->name }}</td>
                                    <td>{{ $settlement->vendor->email ?? '' }} - {{ $settlement->vendor->phone ?? '' }}</td>
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