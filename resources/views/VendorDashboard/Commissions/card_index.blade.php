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

<div class="card basic-data-table shadow-sm border-0 mb-3">
    <div class="card-body">

        <p class="text-danger mb-3" style="font-size:12px">**
            These amounts are already retained by admin from card payments — no action needed from you. This is for your reference only.
        </p>

        @if($commissions->isEmpty())
            <p class="text-muted mb-0">No card commission records yet.</p>
        @else
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
                        @foreach($commissions as $commission)
                            <tr>
                                <td>{{ $commission->order->order_number ?? '—' }}</td>
                                <td>{{ $commission->product->name ?? 'N/A' }}</td>
                                <td>{{ $commission->created_at->format('M d, Y') }}</td>
                                <td class="text-end">Rs. {{ number_format($commission->commission_amount, 2) }}</td>
                                <td>
                                    <span class="status-pill status-{{ $commission->status }}">
                                        {{ ucfirst($commission->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $commissions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection