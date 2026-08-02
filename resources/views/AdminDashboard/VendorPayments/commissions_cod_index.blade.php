@extends('AdminDashboard.index')

@section('title', 'Vendor Commissions (COD)')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.status-submitted { background: #cfe2ff; color: #084298; }
.status-paid { background: #d1f2dd; color: #0f5132; }
.status-rejected { background: #f8d7da; color: #842029; }
.status-pending { background: #f8ebd7; color: #eac41b; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Vendor Commissions — COD Orders</h6>
</div>

<div class="card basic-data-table shadow-sm border-0 mb-3">
    <div class="card-body">
        {{-- TABS --}}
        <ul class="nav focus-tab nav-pills">

            <li class="nav-item">
                <a href="{{ route('admin.vendor-commissions-cod.index',['tab'=>'pending_commissions']) }}"
                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 
                {{ $tab == 'pending_commissions' ? 'active' : '' }}">
                    Pending Commissions ({{ $pendingCommissions->count() }})
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('admin.vendor-commissions-cod.index',['tab'=>'pending']) }}"
                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 
                {{ $tab == 'pending' ? 'active' : '' }}">
                    Pending Review ({{ $pending->count() }})
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('admin.vendor-commissions-cod.index',['tab'=>'history']) }}"
                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 
                {{ $tab == 'history' ? 'active' : '' }}">
                    Payment History
                </a>
            </li>

        </ul>
        </div>
</div>

@if($tab == 'pending_commissions')
<div class="card basic-data-table shadow-sm border-0 mb-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0" id="dataTable" data-page-length="10">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Vendor</th>
                        <th>Order No</th>
                        <th>Product</th>
                        <th class="text-end">Commission Amount</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pendingCommissions as $commission)
                    <tr>
                        <td>
                            {{ $commission->created_at->format('M d, Y') }}
                        </td>
                        <td>
                            {{ $commission->vendor->shop_name 
                                ?? $commission->vendor->name
                                ?? 'Vendor #'.$commission->vendor_id }}
                            <br>
                            <small class="text-muted">
                                {{ $commission->vendor->phone ?? '' }}
                            </small>
                        </td>
                        <td>
                            {{ $commission->order->order_number ?? '-' }}
                        </td>
                        <td>
                            {{ $commission->orderItem->product->name ?? '-' }}
                        </td>
                        <td class="text-end fw-bold">
                            Rs. {{ number_format($commission->commission_amount, 2) }}
                        </td>
                        <td>
                            <span class="status-pill status-pending">
                                Pending
                            </span>
                        </td>
                        <td class="text-center">
                            @if(strtolower($commission->vendor->status ?? '') === 'suspended')
                                <a href="{{ route('admin.vendor-commissions-cod.settle-manual', $commission->vendor_id) }}"
                                class="btn btn-sm btn-warning">
                                    Settle Manually
                                </a>
                            @else
                                <span class="text-muted small">Awaiting vendor submission</span>
                            @endif
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>

@elseif($tab == 'pending')
    <div class="card basic-data-table shadow-sm border-0 mb-3">
        <div class="card-body">
                <div class="table-responsive">
                     <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Vendor</th>
                                <th>Vendor Contact</th>
                                <th>Vendor Address</th>
                                <th>Period</th>
                                <th class="text-end">Claimed Amount</th>
                                <th>Submitted On</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                       <tbody>
                        @foreach($pending as $settlement)

                        <tr>
                            <td>
                                {{ $settlement->vendor->shop_name 
                                    ?? $settlement->vendor->name }}
                            </td>
                            <td>
                                {{ $settlement->vendor->email ?? '' }}
                                <br>
                                {{ $settlement->vendor->phone ?? '' }}
                            </td>
                            <td>
                                {{ $settlement->vendor->address ?? '' }}
                                -
                                {{ $settlement->vendor->district ?? '' }}
                            </td>
                            <td>
                                @if($settlement->type == 'pending_commission')

                                    {{ \Carbon\Carbon::parse($settlement->period_start)->format('M d, Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($settlement->period_end)->format('M d, Y') }}
                                @else
                                    {{ $settlement->period_start->format('M d') }}
                                    -
                                    {{ $settlement->period_end->format('M d, Y') }}

                                @endif
                            </td>
                            <td class="text-end fw-bold">
                                Rs. {{ number_format($settlement->total_amount,2) }}
                            </td>
                            <td>
                                @if($settlement->type == 'pending_commission')

                                    <span class="status-pill status-rejected">
                                        Not Submitted
                                    </span>
                                @else
                                    <span class="status-pill status-submitted">
                                        Submitted
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($settlement->type == 'pending_commission')
                                    <a href="{{ route('admin.vendor-commissions-cod.vendor',$settlement->vendor_id) }}"
                                    class="btn btn-sm btn-primary">
                                        Review
                                    </a>
                                @else
                                    <a href="{{ route('admin.vendor-commissions-cod.show',$settlement->id) }}"
                                    class="btn btn-sm btn-primary">
                                        Review
                                    </a>
                                @endif
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
                                <th>Status</th>
                                <th>Reviewed On</th>
                                <th class="text-center">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $settlement)
                                <tr>
                                    <td>{{ $settlement->vendor->shop_name ?? $settlement->vendor->name }}</td>
                                    <td>{{ $settlement->vendor->email ?? '' }} - {{ $settlement->vendor->phone ?? '' }}</td>
                                    <td>{{ $settlement->period_start->format('M d') }} – {{ $settlement->period_end->format('M d, Y') }}</td>
                                    <td class="text-end fw-bold">Rs. {{ number_format($settlement->total_amount, 2) }}</td>
                                    <td>
                                        <span class="status-pill status-{{ $settlement->status }}">
                                            {{ ucfirst($settlement->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $settlement->reviewed_at?->format('M d, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.vendor-commissions-cod.show', $settlement->id) }}" class="btn btn-sm btn-outline-secondary">
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
@endsection